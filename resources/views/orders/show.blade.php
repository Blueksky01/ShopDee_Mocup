@extends('layouts.app')

@section('title', 'รายละเอียดคำสั่งซื้อ #' . $order->order_number . ' - ShopDee')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-file-lines text-indigo-600"></i> รายละเอียดคำสั่งซื้อ
        </h1>
        <a href="{{ route('orders.index') }}" class="text-indigo-600 hover:underline text-sm font-medium">
            &larr; กลับไปยังประวัติสั่งซื้อ
        </a>
    </div>

    <!-- Summary Box -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2 text-sm">
            <p><span class="text-gray-500">เลขที่คำสั่งซื้อ:</span> <strong class="text-indigo-600">{{ $order->order_number }}</strong></p>
            <p><span class="text-gray-500">ผู้สั่งซื้อ:</span> <strong class="text-gray-800">{{ $order->user->name }} ({{ $order->user->email }})</strong></p>
            <p><span class="text-gray-500">วันที่ทำรายการ:</span> <span class="text-gray-700">{{ $order->created_at->format('d/m/Y H:i:s') }}</span></p>
            <p><span class="text-gray-500">วิธีชำระเงิน:</span> <span class="text-gray-700 font-semibold uppercase">{{ $order->payment_method }}</span></p>
        </div>

        <div class="space-y-3 text-sm border-t md:border-t-0 md:border-l border-gray-200 pt-4 md:pt-0 md:pl-6 flex flex-col justify-between">
            <div>
                <p class="text-gray-500">สถานะคำสั่งซื้อ:</p>
                <div class="mt-1">
                    @if($order->status === 'pending')
                        <span class="bg-yellow-100 text-yellow-800 text-sm font-bold px-3 py-1 rounded-full">รอชำระเงิน</span>
                    @elseif($order->status === 'paid')
                        <span class="bg-blue-100 text-blue-800 text-sm font-bold px-3 py-1 rounded-full">ชำระเงินแล้ว</span>
                    @elseif($order->status === 'shipped')
                        <span class="bg-purple-100 text-purple-800 text-sm font-bold px-3 py-1 rounded-full">จัดส่งแล้ว</span>
                    @elseif($order->status === 'completed')
                        <span class="bg-green-100 text-green-800 text-sm font-bold px-3 py-1 rounded-full">เสร็จสิ้น</span>
                    @elseif($order->status === 'cancelled')
                        <span class="bg-red-100 text-red-800 text-sm font-bold px-3 py-1 rounded-full">ยกเลิกแล้ว</span>
                    @endif
                </div>
            </div>

            <!-- Cancel Order Action -->
            @if($order->status === 'pending' && auth()->id() === $order->user_id)
                <div class="flex items-center gap-3 pt-2">
                    <a href="{{ route('payment.show', $order) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-4 py-2 rounded-md shadow text-xs transition">
                        <i class="fa-solid fa-wallet mr-1"></i> ไปหน้าชำระเงิน
                    </a>

                    <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ว่าต้องการยกเลิกคำสั่งซื้อนี้? สต็อกสินค้าจะถูกคืนกลับระบบ');">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-2 rounded-md text-xs transition">
                            <i class="fa-solid fa-xmark mr-1"></i> ขอยกเลิกออเดอร์ (คืนสต็อก)
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Items Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-800 text-sm">
            รายการสินค้าที่สั่งซื้อ (Price Snapshot ณ ตอนสั่งซื้อ)
        </div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase">
                <tr>
                    <th class="p-4">สินค้า</th>
                    <th class="p-4">ราคา ณ ตอนซื้อ</th>
                    <th class="p-4 text-center">จำนวน</th>
                    <th class="p-4 text-right">ราคารวม</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @foreach($order->items as $item)
                    <tr>
                        <td class="p-4 font-medium text-gray-800">
                            {{ $item->product->name }}
                        </td>
                        <td class="p-4 text-gray-600">
                            ฿{{ number_format($item->price_at_purchase, 2) }}
                        </td>
                        <td class="p-4 text-center">
                            {{ $item->quantity }}
                        </td>
                        <td class="p-4 text-right font-bold text-gray-800">
                            ฿{{ number_format($item->subtotal, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 font-extrabold text-sm">
                <tr>
                    <td colspan="3" class="p-4 text-right">ยอดรวมสุทธิ:</td>
                    <td class="p-4 text-right text-indigo-600 text-lg">฿{{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Payment Transaction Logs -->
    @if($order->transactions->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-800 text-sm">
                <i class="fa-solid fa-clock-rotate-left text-indigo-600 mr-1"></i> ประวัติการทำรายการชำระเงิน (Transaction Logs)
            </div>
            <table class="w-full text-left border-collapse text-xs">
                <thead class="bg-gray-100 text-gray-600 uppercase">
                    <tr>
                        <th class="p-3">เลขที่ Transaction</th>
                        <th class="p-3">วิธีชำระ</th>
                        <th class="p-3">จำนวนเงิน</th>
                        <th class="p-3">เวลาที่ทำรายการ</th>
                        <th class="p-3 text-center">ผลลัพธ์</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($order->transactions as $txn)
                        <tr>
                            <td class="p-3 font-mono text-gray-700">{{ $txn->transaction_number }}</td>
                            <td class="p-3 uppercase">{{ $txn->payment_method }}</td>
                            <td class="p-3 font-bold">฿{{ number_format($txn->amount, 2) }}</td>
                            <td class="p-3 text-gray-500">{{ $txn->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="p-3 text-center">
                                @if($txn->status === 'success')
                                    <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded font-bold">SUCCESS</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-2 py-0.5 rounded font-bold">FAILED</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
