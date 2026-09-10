<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function show(Order $order): View|RedirectResponse
    {
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)->with('error', 'ออเดอร์นี้ไม่ได้อยู่ในสถานะรอชำระเงิน');
        }

        return view('payment.show', compact('order'));
    }

    public function process(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'simulated_result' => ['required', 'string', 'in:success,failed'],
        ]);

        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)->with('error', 'ออเดอร์นี้ได้รับการประมวลผลไปแล้ว');
        }

        $result = $request->input('simulated_result');
        $transactionNumber = 'TXN-' . date('YmdHis') . '-' . strtoupper(Str::random(4));

        try {
            DB::transaction(function () use ($order, $result, $transactionNumber) {
                if ($result === 'success') {
                    $order->update(['status' => 'paid']);

                    PaymentTransaction::create([
                        'order_id' => $order->id,
                        'transaction_number' => $transactionNumber,
                        'payment_method' => $order->payment_method,
                        'amount' => $order->total_amount,
                        'status' => 'success',
                    ]);
                } else {
                    // Payment failed -> Update order to cancelled & restore product stock atomically
                    $order->update(['status' => 'cancelled']);

                    foreach ($order->items as $item) {
                        $item->product->increment('stock', $item->quantity);
                    }

                    PaymentTransaction::create([
                        'order_id' => $order->id,
                        'transaction_number' => $transactionNumber,
                        'payment_method' => $order->payment_method,
                        'amount' => $order->total_amount,
                        'status' => 'failed',
                    ]);
                }
            });

            if ($result === 'success') {
                return redirect()->route('orders.show', $order)->with('success', 'ชำระเงินสำเร็จแล้ว! ระบบกำลังเตรียมจัดส่งสินค้า');
            } else {
                return redirect()->route('orders.show', $order)->with('error', 'การชำระเงินล้มเหลว! ออเดอร์ถูกยกเลิกและระบบคืนสต็อกสินค้าเรียบร้อยแล้ว');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'เกิดข้อผิดพลาดในการทำรายการชำระเงิน: ' . $e->getMessage());
        }
    }
}
