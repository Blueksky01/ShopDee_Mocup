@extends('layouts.app')

@section('title', 'รายละเอียดคำสั่งซื้อ #' . $order->order_number . ' - ShopDee')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <!-- Top Header & Back Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex text-xs text-rust/60 gap-2 mb-1">
                <a href="{{ route('products.index') }}" class="hover:text-terracotta transition">หน้าแรก</a>
                <span>/</span>
                <a href="{{ route('orders.index') }}" class="hover:text-terracotta transition">ประวัติสั่งซื้อ</a>
                <span>/</span>
                <span class="text-terracotta font-semibold">#{{ $order->order_number }}</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-bold text-rust flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-terracotta/15 text-terracotta flex items-center justify-center text-lg shadow-sm">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <span>รายละเอียดคำสั่งซื้อ</span>
            </h1>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-1.5 bg-limestone hover:bg-limestone-light text-rust px-4 py-2 rounded-xl text-xs font-semibold border border-terracotta/20 transition shadow-sm">
                <i class="fa-solid fa-print text-terracotta"></i> พิมพ์ใบเสร็จ (Print)
            </button>
            <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-1.5 bg-terracotta hover:bg-terracotta-dark text-white px-4 py-2 rounded-xl text-xs font-semibold shadow transition">
                <i class="fa-solid fa-list-ul"></i> ประวัติสั่งซื้อ
            </a>
        </div>
    </div>

    <!-- Interactive Status Tracker Card -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-terracotta/20 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-limestone pb-4">
            <div>
                <span class="text-xs text-rust/60">เลขที่คำสั่งซื้อ:</span>
                <span class="text-base font-mono font-bold text-rust ml-1">#{{ $order->order_number }}</span>
            </div>
            <div>
                <span class="text-xs text-rust/60">สถานะคำสั่งซื้อ:</span>
                @if($order->status === 'pending')
                    <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full ml-1">
                        <i class="fa-regular fa-clock mr-1"></i> รอชำระเงิน
                    </span>
                @elseif($order->status === 'paid')
                    <span class="bg-olive/20 text-olive-dark text-xs font-bold px-3 py-1 rounded-full ml-1 border border-olive/30">
                        <i class="fa-solid fa-circle-check mr-1 text-olive"></i> ชำระเงินแล้ว (เตรียมจัดส่ง)
                    </span>
                @elseif($order->status === 'shipped')
                    <span class="bg-purple-100 text-purple-800 text-xs font-bold px-3 py-1 rounded-full ml-1">
                        <i class="fa-solid fa-truck-fast mr-1"></i> อยู่ระหว่างจัดส่ง
                    </span>
                @elseif($order->status === 'completed')
                    <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full ml-1">
                        <i class="fa-solid fa-box-check mr-1"></i> จัดส่งสำเร็จแล้ว
                    </span>
                @elseif($order->status === 'cancelled')
                    <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full ml-1">
                        <i class="fa-solid fa-circle-xmark mr-1"></i> ยกเลิกแล้ว (คืนสต็อกแล้ว)
                    </span>
                @endif
            </div>
        </div>

        @if($order->status !== 'cancelled')
            <!-- Live Progress Bar -->
            <div class="py-2">
                <div class="flex items-center justify-between relative max-w-2xl mx-auto">
                    <!-- Tracker line -->
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1.5 bg-limestone w-full z-0"></div>
                    @php
                        $widthPercent = match($order->status) {
                            'pending' => '10%',
                            'paid' => '45%',
                            'shipped' => '75%',
                            'completed' => '100%',
                            default => '0%',
                        };
                    @endphp
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1.5 bg-olive transition-all duration-700 z-0" style="width: {{ $widthPercent }};"></div>

                    <!-- Step 1 -->
                    <div class="relative z-10 flex flex-col items-center gap-1.5">
                        <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['paid', 'shipped', 'completed']) ? 'bg-olive text-white ring-4 ring-olive/20' : 'bg-terracotta text-white ring-4 ring-terracotta/20' }} flex items-center justify-center text-xs font-bold shadow">
                            <i class="fa-solid {{ in_array($order->status, ['paid', 'shipped', 'completed']) ? 'fa-check' : 'fa-clock' }}"></i>
                        </div>
                        <span class="text-[11px] font-bold {{ $order->status === 'pending' ? 'text-terracotta' : 'text-rust' }}">1. สั่งซื้อ / ชำระเงิน</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative z-10 flex flex-col items-center gap-1.5">
                        <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['paid', 'shipped', 'completed']) ? 'bg-olive text-white ring-4 ring-olive/20' : 'bg-limestone text-rust/40' }} flex items-center justify-center text-xs font-bold shadow">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <span class="text-[11px] font-bold {{ in_array($order->status, ['paid', 'shipped', 'completed']) ? 'text-olive-dark' : 'text-rust/50' }}">2. กำลังเตรียมพัสดุ</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative z-10 flex flex-col items-center gap-1.5">
                        <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['shipped', 'completed']) ? 'bg-olive text-white ring-4 ring-olive/20' : 'bg-limestone text-rust/40' }} flex items-center justify-center text-xs font-bold shadow">
                            <i class="fa-solid fa-truck"></i>
                        </div>
                        <span class="text-[11px] font-bold {{ in_array($order->status, ['shipped', 'completed']) ? 'text-olive-dark' : 'text-rust/50' }}">3. อยู่ระหว่างขนส่ง</span>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative z-10 flex flex-col items-center gap-1.5">
                        <div class="w-8 h-8 rounded-full {{ $order->status === 'completed' ? 'bg-olive text-white ring-4 ring-olive/20' : 'bg-limestone text-rust/40' }} flex items-center justify-center text-xs font-bold shadow">
                            <i class="fa-solid fa-house-chimney"></i>
                        </div>
                        <span class="text-[11px] font-bold {{ $order->status === 'completed' ? 'text-olive-dark' : 'text-rust/50' }}">4. จัดส่งสำเร็จ</span>
                    </div>
                </div>
            </div>
        @endif

        @if($order->status === 'pending')
            <div class="bg-amber-50 border border-amber-200 p-4 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-amber-600 text-xl"></i>
                    <div class="text-xs text-amber-900">
                        <strong class="block text-sm">คำสั่งซื้อนี้ยังไม่ได้รับการชำระเงิน</strong>
                        โปรดชำระเงินเพื่อดำเนินการจัดส่งสินค้า
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('payment.show', $order) }}" class="bg-terracotta hover:bg-terracotta-dark text-white font-bold px-4 py-2 rounded-xl text-xs shadow transition flex items-center gap-1.5">
                        <i class="fa-solid fa-wallet"></i> ไปชำระเงินตอนนี้
                    </a>
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('ต้องการยกเลิกคำสั่งซื้อนี้และคืนสต็อกสินค้าหรือไม่?');">
                        @csrf
                        <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 font-bold px-3 py-2 rounded-xl text-xs transition">
                            ยกเลิก
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    <!-- Order Items & Shipping Address Grid -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        
        <!-- Ordered Items Table (8 cols) -->
        <div class="md:col-span-8 bg-white rounded-3xl shadow-sm border border-terracotta/20 overflow-hidden">
            <div class="p-4 sm:p-5 bg-limestone-light/70 border-b border-limestone font-bold text-rust text-sm flex items-center justify-between">
                <span>รายการสินค้าที่สั่งซื้อ ({{ $order->items->count() }} รายการ)</span>
                <span class="text-xs font-normal text-rust/60">บันทึกราคา ณ ตอนสั่งซื้อ</span>
            </div>

            <table class="w-full text-left border-collapse">
                <thead class="bg-limestone-light/30 border-b border-limestone text-xs font-semibold text-rust/60 uppercase">
                    <tr>
                        <th class="p-4">สินค้า</th>
                        <th class="p-4 text-right">ราคา/ชิ้น</th>
                        <th class="p-4 text-center">จำนวน</th>
                        <th class="p-4 text-right">ราคารวม</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-limestone text-sm">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="p-4 flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-limestone/50 border border-terracotta/15 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if($item->product && $item->product->image)
                                        @if(str_starts_with($item->product->image, 'http'))
                                            <img src="{{ $item->product->image }}" class="w-full h-full object-cover">
                                        @elseif(str_starts_with($item->product->image, 'images/'))
                                            <img src="{{ asset($item->product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                        @endif
                                    @else
                                        <i class="fa-solid fa-box text-terracotta/40"></i>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <div class="font-bold text-rust text-xs sm:text-sm truncate">{{ $item->product->name ?? 'สินค้าที่สั่งซื้อ' }}</div>
                                    <div class="text-[10px] text-rust/50">{{ $item->product->category->name ?? 'สินค้า' }}</div>
                                </div>
                            </td>
                            <td class="p-4 text-right font-medium text-rust text-xs sm:text-sm">
                                ฿{{ number_format($item->price_at_purchase, 2) }}
                            </td>
                            <td class="p-4 text-center font-bold text-rust text-xs sm:text-sm">
                                x{{ $item->quantity }}
                            </td>
                            <td class="p-4 text-right font-extrabold text-terracotta text-xs sm:text-sm">
                                ฿{{ number_format($item->subtotal, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-limestone-light/50 font-bold border-t border-limestone">
                    <tr>
                        <td colspan="3" class="p-4 text-right text-xs sm:text-sm text-rust">ยอดชำระสุทธิ:</td>
                        <td class="p-4 text-right text-base sm:text-xl font-extrabold text-terracotta">
                            ฿{{ number_format($order->total_amount, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Order Information Summary (4 cols) -->
        <div class="md:col-span-4 space-y-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-terracotta/20 space-y-4">
                <h3 class="text-sm font-bold text-rust border-b border-limestone pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-terracotta"></i> ข้อมูลการจัดส่ง
                </h3>

                <div class="space-y-3 text-xs text-rust/70">
                    <div>
                        <span class="block text-rust/50">ผู้รับพัสดุ:</span>
                        <span class="font-bold text-rust">{{ $order->user->name }}</span>
                    </div>
                    <div>
                        <span class="block text-rust/50">อีเมลติดต่อ:</span>
                        <span class="text-rust">{{ $order->user->email }}</span>
                    </div>
                    <div>
                        <span class="block text-rust/50">ช่องทางชำระเงิน:</span>
                        <span class="font-bold uppercase text-terracotta">{{ $order->payment_method }}</span>
                    </div>
                    <div>
                        <span class="block text-rust/50">ที่อยู่จัดส่ง:</span>
                        <p class="mt-1 bg-limestone-light p-3 rounded-2xl border border-terracotta/10 text-rust leading-relaxed">
                            {{ $order->shipping_address }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Transaction Logs Table -->
    @if($order->transactions->count() > 0)
        <div class="bg-white rounded-3xl shadow-sm border border-terracotta/20 overflow-hidden">
            <div class="p-4 sm:p-5 bg-limestone-light/70 border-b border-limestone font-bold text-rust text-sm flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-terracotta"></i> ประวัติการทำรายการชำระเงิน (Payment Transaction Logs)
            </div>
            <table class="w-full text-left border-collapse text-xs">
                <thead class="bg-limestone-light/30 text-rust/60 uppercase">
                    <tr>
                        <th class="p-3.5">เลขที่ Transaction</th>
                        <th class="p-3.5">ช่องทาง</th>
                        <th class="p-3.5 text-right">จำนวนเงิน</th>
                        <th class="p-3.5">เวลาทำรายการ</th>
                        <th class="p-3.5 text-center">ผลลัพธ์</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-limestone">
                    @foreach($order->transactions as $txn)
                        <tr>
                            <td class="p-3.5 font-mono text-rust font-semibold">{{ $txn->transaction_number }}</td>
                            <td class="p-3.5 uppercase font-medium text-rust">{{ $txn->payment_method }}</td>
                            <td class="p-3.5 text-right font-extrabold text-terracotta">฿{{ number_format($txn->amount, 2) }}</td>
                            <td class="p-3.5 text-rust/60">{{ $txn->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="p-3.5 text-center">
                                @if($txn->status === 'success')
                                    <span class="bg-olive/20 text-olive-dark font-bold px-2.5 py-1 rounded-full border border-olive/30">SUCCESS</span>
                                @else
                                    <span class="bg-red-100 text-red-800 font-bold px-2.5 py-1 rounded-full">FAILED</span>
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
