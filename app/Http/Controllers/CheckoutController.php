<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cart = Cart::where('user_id', Auth::id())->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'ไม่มีสินค้าในตะกร้าสำหรับทำรายการสั่งซื้อ');
        }

        $subtotal = $cart->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout.index', compact('cart', 'subtotal'));
    }

    public function process(Request $request): RedirectResponse
    {
        $request->validate([
            'shipping_address' => ['required', 'string', 'max:500'],
            'payment_method' => ['required', 'string', 'in:bank_transfer,credit_card,cod'],
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'ไม่มีสินค้าในตะกร้า');
        }

        // Verify stock sufficiency for all items
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')->with('error', "สินค้า {$item->product->name} มีสต็อกไม่เพียงพอ (คงเหลือ {$item->product->stock} ชิ้น)");
            }
        }

        try {
            $order = DB::transaction(function () use ($user, $cart, $request) {
                $totalAmount = $cart->items->sum(function ($item) {
                    return $item->product->price * $item->quantity;
                });

                // Generate unique order number (ORD-YYYYMMDDHHMMSS-XXXX)
                $orderNumber = 'ORD-' . date('YmdHis') . '-' . strtoupper(Str::random(4));

                $order = Order::create([
                    'order_number' => $orderNumber,
                    'user_id' => $user->id,
                    'total_amount' => $totalAmount,
                    'shipping_address' => $request->input('shipping_address'),
                    'payment_method' => $request->input('payment_method'),
                    'status' => 'pending',
                ]);

                foreach ($cart->items as $item) {
                    $subtotal = $item->product->price * $item->quantity;

                    $order->items()->create([
                        'product_id' => $item->product_id,
                        'price_at_purchase' => $item->product->price,
                        'quantity' => $item->quantity,
                        'subtotal' => $subtotal,
                    ]);

                    // Deduct stock
                    $item->product->decrement('stock', $item->quantity);
                }

                // Clear user cart
                $cart->items()->delete();

                return $order;
            });

            return redirect()->route('payment.show', $order)->with('success', 'สร้างคำสั่งซื้อเรียบร้อยแล้ว โปรดชำระเงิน');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการสร้างคำสั่งซื้อ: ' . $e->getMessage());
        }
    }
}
