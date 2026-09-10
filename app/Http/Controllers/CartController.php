<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    private function getCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }

    public function index(): View
    {
        $cart = $this->getCart();
        $cart->load('items.product');

        $subtotal = $cart->items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cart', 'subtotal'));
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $request->input('quantity', 1);

        if ($product->stock < $quantity) {
            return back()->with('error', "สินค้า {$product->name} เหลือเพียง {$product->stock} ชิ้น ไม่เพียงพอต่อการสั่งซื้อ");
        }

        $cart = $this->getCart();
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', "สินค้าในตะกร้ารวมกันเกินจำนวนสต็อกที่มีอยู่ ({$product->stock} ชิ้น)");
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', "เพิ่ม {$product->name} ลงตะกร้าเรียบร้อยแล้ว");
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $request->input('quantity');

        if ($cartItem->product->stock < $quantity) {
            return back()->with('error', "สินค้า {$cartItem->product->name} เหลือเพียง {$cartItem->product->stock} ชิ้น");
        }

        $cartItem->update(['quantity' => $quantity]);

        return back()->with('success', 'อัปเดตจำนวนสินค้าเรียบร้อยแล้ว');
    }

    public function remove(CartItem $cartItem): RedirectResponse
    {
        $cartItem->delete();

        return back()->with('success', 'ลบสินค้าออกจากตะกร้าเรียบร้อยแล้ว');
    }
}
