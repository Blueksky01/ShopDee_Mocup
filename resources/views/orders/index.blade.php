@extends('layouts.app')

@section('title', 'ประวัติคำสั่งซื้อของคุณ - ShopDee')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex text-xs text-rust/60 gap-2 mb-1">
                <a href="{{ route('products.index') }}" class="hover:text-terracotta transition">หน้าแรก</a>
                <span>/</span>
                <span class="text-terracotta font-semibold">ประวัติคำสั่งซื้อ</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-bold text-rust flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-terracotta/15 text-terracotta flex items-center justify-center text-lg shadow-sm">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <span>ประวัติคำสั่งซื้อของคุณ</span>
            </h1>
        </div>

        <a href="{{ route('products.index') }}#catalog" class="inline-flex items-center gap-2 text-sm text-rust/80 hover:text-terracotta font-medium transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>เลือกซื้อสินค้าเพิ่มเติม</span>
        </a>
    </div>

    @if($orders->count() > 0)
        <div class="bg-white rounded-3xl shadow-sm border border-terracotta/20 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-limestone-light/70 border-b border-limestone text-xs font-semibold text-rust/60 uppercase">
                    <tr>
                        <th class="p-4">เลขที่คำสั่งซื้อ</th>
                        <th class="p-4">วันที่สั่งซื้อ</th>
                        <th class="p-4 text-right">ยอดรวมสุทธิ</th>
                        <th class="p-4 text-center">สถานะ</th>
                        <th class="p-4 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-limestone text-sm">
                    @foreach($orders as $order)
                        <tr class="hover:bg-limestone-light/40 transition">
                            <td class="p-4 font-mono font-bold text-terracotta">
                                <a href="{{ route('orders.show', $order) }}" class="hover:underline">
                                    {{ $order->order_number }}
                                </a>
                                <div class="text-[10px] text-rust/50 uppercase font-sans">{{ $order->payment_method }}</div>
                            </td>
                            <td class="p-4 text-rust/70 text-xs">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-4 text-right font-extrabold text-rust">
                                ฿{{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="p-4 text-center">
                                @if($order->status === 'pending')
                                    <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full">
                                        <i class="fa-regular fa-clock mr-1"></i> รอชำระเงิน
                                    </span>
                                @elseif($order->status === 'paid')
                                    <span class="bg-olive/20 text-olive-dark text-xs font-bold px-3 py-1 rounded-full border border-olive/30">
                                        <i class="fa-solid fa-circle-check mr-1 text-olive"></i> ชำระแล้ว
                                    </span>
                                @elseif($order->status === 'shipped')
                                    <span class="bg-purple-100 text-purple-800 text-xs font-bold px-3 py-1 rounded-full">
                                        <i class="fa-solid fa-truck mr-1"></i> กำลังจัดส่ง
                                    </span>
                                @elseif($order->status === 'completed')
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                                        <i class="fa-solid fa-box-check mr-1"></i> จัดส่งสำเร็จ
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full">
                                        <i class="fa-solid fa-ban mr-1"></i> ยกเลิกแล้ว
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('orders.show', $order) }}" class="bg-limestone hover:bg-limestone-light text-rust px-3 py-1.5 rounded-xl text-xs font-semibold border border-terracotta/20 transition shadow-sm">
                                        <i class="fa-solid fa-eye mr-1"></i> รายละเอียด
                                    </a>
                                    @if($order->status === 'pending')
                                        <a href="{{ route('payment.show', $order) }}" class="bg-terracotta hover:bg-terracotta-dark text-white px-3.5 py-1.5 rounded-xl text-xs font-bold transition shadow">
                                            <i class="fa-solid fa-wallet mr-1"></i> ชำระเงิน
                                        </a>
                                    @endif
                                </div>
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
        <div class="bg-white p-12 sm:p-16 text-center rounded-3xl shadow-sm border border-terracotta/20 max-w-lg mx-auto space-y-4">
            <div class="w-20 h-20 bg-limestone/50 text-terracotta rounded-full flex items-center justify-center mx-auto text-3xl">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-xl font-bold text-rust">ยังไม่มีประวัติคำสั่งซื้อ</h3>
                <p class="text-rust/60 text-xs">เริ่มต้นสั่งซื้อสินค้าและเลือกชำระเงินผ่านระบบจำลองได้ทันที</p>
            </div>
            <div class="pt-2">
                <a href="{{ route('products.index') }}#catalog" class="inline-flex items-center gap-2 bg-terracotta hover:bg-terracotta-dark text-white px-6 py-2.5 rounded-2xl text-xs font-semibold shadow transition">
                    <i class="fa-solid fa-store"></i>
                    <span>เริ่มช้อปปิ้งเลย</span>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
