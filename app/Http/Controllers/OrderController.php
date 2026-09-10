<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product', 'transactions'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View|RedirectResponse
    {
        if (! Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $order->load(['items.product', 'transactions', 'user']);

        return view('orders.show', compact('order'));
    }

    public function cancel(Order $order): RedirectResponse
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'สามารถยกเลิกได้เฉพาะคำสั่งซื้อที่อยู่ในสถานะรอชำระเงิน (Pending) เท่านั้น');
        }

        try {
            DB::transaction(function () use ($order) {
                // Update order status to cancelled
                $order->update(['status' => 'cancelled']);

                // Restore product stock for all items
                foreach ($order->items as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            });

            return redirect()->route('orders.show', $order)->with('success', 'ยกเลิกคำสั่งซื้อและคืนสต็อกสินค้าเรียบร้อยแล้ว');
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการยกเลิกคำสั่งซื้อ: ' . $e->getMessage());
        }
    }
}
