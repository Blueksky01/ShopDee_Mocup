@extends('layouts.app')

@section('title', 'จัดการคำสั่งซื้อ - Admin ShopDee')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-clipboard-list text-indigo-600"></i> จัดการคำสั่งซื้อทั้งหมด (Order Management)
        </h1>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse text-sm">
            <thead class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase">
                <tr>
                    <th class="p-4">เลขที่ออเดอร์</th>
                    <th class="p-4">ลูกค้า</th>
                    <th class="p-4">ยอดรวม</th>
                    <th class="p-4">วันที่สั่งซื้อ</th>
                    <th class="p-4 text-center">สถานะปัจจุบัน</th>
                    <th class="p-4 text-center">อัปเดตสถานะ</th>
                    <th class="p-4 text-center">ดูรายละเอียด</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr>
                        <td class="p-4 font-bold text-indigo-600">
                            {{ $order->order_number }}
                        </td>
                        <td class="p-4 text-gray-800">
                            <p class="font-semibold">{{ $order->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                        </td>
                        <td class="p-4 font-extrabold text-gray-800">
                            ฿{{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="p-4 text-xs text-gray-500">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="p-4 text-center">
                            @if($order->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-1 rounded-full">Pending</span>
                            @elseif($order->status === 'paid')
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-1 rounded-full">Paid</span>
                            @elseif($order->status === 'shipped')
                                <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-1 rounded-full">Shipped</span>
                            @elseif($order->status === 'completed')
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-1 rounded-full">Completed</span>
                            @elseif($order->status === 'cancelled')
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-1 rounded-full">Cancelled</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex items-center justify-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="text-xs p-1.5 border border-gray-300 rounded focus:ring-indigo-500">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-2.5 py-1 rounded transition">
                                    เปลี่ยน
                                </button>
                            </form>
                        </td>
                        <td class="p-4 text-center">
                            <a href="{{ route('orders.show', $order) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs px-3 py-1.5 rounded font-medium transition">
                                <i class="fa-solid fa-eye"></i> รายละเอียด
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
