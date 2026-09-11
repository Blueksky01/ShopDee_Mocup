@extends('layouts.app')

@section('title', 'จัดการคำสั่งซื้อ - Admin ShopDee')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-rust flex items-center gap-2">
            <i class="fa-solid fa-clipboard-list text-terracotta"></i> จัดการคำสั่งซื้อทั้งหมด (Order Management)
        </h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-terracotta/20 overflow-hidden">
        <table class="w-full text-left border-collapse text-sm">
            <thead class="bg-limestone-light border-b border-terracotta/20 text-xs font-semibold text-rust/70 uppercase">
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
            <tbody class="divide-y divide-limestone">
                @foreach($orders as $order)
                    <tr>
                        <td class="p-4 font-bold text-terracotta">
                            {{ $order->order_number }}
                        </td>
                        <td class="p-4 text-rust">
                            <p class="font-semibold">{{ $order->user->name }}</p>
                            <p class="text-xs text-rust/60">{{ $order->user->email }}</p>
                        </td>
                        <td class="p-4 font-extrabold text-rust">
                            ฿{{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="p-4 text-xs text-rust/60">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="p-4 text-center">
                            @if($order->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full border border-yellow-300">Pending</span>
                            @elseif($order->status === 'paid')
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full border border-blue-300">Paid</span>
                            @elseif($order->status === 'shipped')
                                <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full border border-purple-300">Shipped</span>
                            @elseif($order->status === 'completed')
                                <span class="bg-olive/20 text-olive-dark text-xs font-semibold px-3 py-1 rounded-full border border-olive/40">Completed</span>
                            @elseif($order->status === 'cancelled')
                                <span class="bg-terracotta/20 text-terracotta-dark text-xs font-semibold px-3 py-1 rounded-full border border-terracotta/40">Cancelled</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex items-center justify-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="text-xs py-1.5 px-3 border border-terracotta/30 rounded-xl focus:ring-terracotta bg-limestone-light font-medium text-rust">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="bg-terracotta hover:bg-terracotta-dark text-white text-xs px-3 py-1.5 rounded-xl font-medium transition shadow">
                                    เปลี่ยน
                                </button>
                            </form>
                        </td>
                        <td class="p-4 text-center">
                            <a href="{{ route('orders.show', $order) }}" class="bg-limestone hover:bg-limestone/80 text-rust text-xs px-3 py-1.5 rounded-xl font-medium transition">
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
