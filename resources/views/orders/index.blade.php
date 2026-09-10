@extends('layouts.app')

@section('title', 'ประวัติคำสั่งซื้อ - ShopDee')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
        <i class="fa-solid fa-receipt text-indigo-600"></i> ประวัติคำสั่งซื้อของคุณ
    </h1>

    @if($orders->count() > 0)
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">เลขที่คำสั่งซื้อ</th>
                        <th class="p-4">วันที่สั่งซื้อ</th>
                        <th class="p-4">ยอดรวม</th>
                        <th class="p-4 text-center">สถานะ</th>
                        <th class="p-4 text-center">รายละเอียด</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @foreach($orders as $order)
                        <tr>
                            <td class="p-4 font-bold text-indigo-600">
                                {{ $order->order_number }}
                            </td>
                            <td class="p-4 text-gray-600 text-xs">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-4 font-extrabold text-gray-800">
                                ฿{{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="p-4 text-center">
                                @if($order->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-1 rounded-full">รอชำระเงิน</span>
                                @elseif($order->status === 'paid')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-1 rounded-full">ชำระเงินแล้ว</span>
                                @elseif($order->status === 'shipped')
                                    <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-1 rounded-full">จัดส่งแล้ว</span>
                                @elseif($order->status === 'completed')
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-1 rounded-full">เสร็จสิ้น</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-1 rounded-full">ยกเลิกแล้ว</span>
                                @endif
                            </td>
                            <td class="p-4 text-center space-x-2">
                                <a href="{{ route('orders.show', $order) }}" class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded text-xs font-medium transition">
                                    <i class="fa-solid fa-eye mr-1"></i> รายละเอียด
                                </a>
                                @if($order->status === 'pending')
                                    <a href="{{ route('payment.show', $order) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded text-xs font-medium transition shadow">
                                        <i class="fa-solid fa-wallet mr-1"></i> ชำระเงิน
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <div class="bg-white p-12 text-center rounded-lg shadow-sm border border-gray-200 space-y-3">
            <i class="fa-solid fa-folder-open text-5xl text-gray-300"></i>
            <h3 class="text-lg font-bold text-gray-700">ยังไม่มีประวัติการสั่งซื้อ</h3>
            <p class="text-gray-500 text-sm">สั่งซื้อสินค้าชิ้นแรกของคุณเพื่อเริ่มต้นใช้งาน!</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-indigo-600 text-white font-medium px-5 py-2 rounded-lg shadow text-sm transition">
                เลือกชมสินค้า
            </a>
        </div>
    @endif
</div>
@endsection
