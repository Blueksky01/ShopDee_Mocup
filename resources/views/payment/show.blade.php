@extends('layouts.app')

@section('title', 'จำลองการชำระเงิน - ShopDee')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <!-- Step Indicator Progress Bar -->
    <div class="bg-white p-4 sm:p-6 rounded-3xl shadow-sm border border-terracotta/20">
        <div class="flex items-center justify-between max-w-3xl mx-auto relative">
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-limestone w-full z-0"></div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-terracotta w-3/4 z-0"></div>

            <div class="relative z-10 flex flex-col items-center gap-1.5">
                <div class="w-10 h-10 rounded-full bg-terracotta text-white flex items-center justify-center font-bold text-sm shadow">
                    <i class="fa-solid fa-check"></i>
                </div>
                <span class="text-xs font-semibold text-rust">1. ตะกร้าสินค้า</span>
            </div>

            <div class="relative z-10 flex flex-col items-center gap-1.5">
                <div class="w-10 h-10 rounded-full bg-terracotta text-white flex items-center justify-center font-bold text-sm shadow">
                    <i class="fa-solid fa-check"></i>
                </div>
                <span class="text-xs font-semibold text-rust">2. ที่อยู่และวิธีชำระ</span>
            </div>

            <div class="relative z-10 flex flex-col items-center gap-1.5">
                <div class="w-10 h-10 rounded-full bg-terracotta text-white flex items-center justify-center font-bold text-sm ring-4 ring-terracotta/20 shadow animate-pulse">
                    3
                </div>
                <span class="text-xs font-bold text-terracotta">3. จำลองชำระเงิน</span>
            </div>

            <div class="relative z-10 flex flex-col items-center gap-1.5">
                <div class="w-10 h-10 rounded-full bg-limestone text-rust/50 flex items-center justify-center font-bold text-sm">
                    4
                </div>
                <span class="text-xs font-medium text-rust/50">4. สำเร็จ</span>
            </div>
        </div>
    </div>

    <!-- Payment Gateway Container -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- LEFT COLUMN: Payment Mockup Gateway Interaction (7 cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- PromptPay QR Code Mockup -->
            @if($order->payment_method === 'promptpay' || $order->payment_method === 'bank_transfer')
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-terracotta/20 space-y-5 text-center">
                    
                    <!-- PromptPay Header -->
                    <div class="flex items-center justify-between border-b border-limestone pb-4">
                        <div class="flex items-center gap-2">
                            <span class="bg-[#003D6B] text-white font-bold text-xs px-3 py-1 rounded-lg tracking-wider">
                                PromptPay
                            </span>
                            <span class="text-xs font-bold text-rust">พร้อมเพย์ QR Code</span>
                        </div>
                        <div class="text-xs text-rust/60 flex items-center gap-1.5">
                            <i class="fa-regular fa-clock text-terracotta"></i>
                            <span>หมดอายุใน: <strong id="countdown-timer" class="text-terracotta font-mono text-sm">14:59</strong></span>
                        </div>
                    </div>

                    <!-- QR Code Display Box -->
                    <div class="bg-gradient-to-b from-limestone-light to-white p-6 rounded-2xl border border-terracotta/20 inline-block shadow-inner">
                        <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-md inline-block relative">
                            <!-- Simulated Dynamic QR Canvas -->
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=PROMPTPAY-SHOPDEE-{{ $order->order_number }}-AMT-{{ $order->total_amount }}"
                                alt="PromptPay QR Code" class="w-48 h-48 mx-auto object-contain rounded-lg">
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="w-8 h-8 bg-white rounded-full p-1 shadow-md flex items-center justify-center">
                                    <i class="fa-solid fa-qrcode text-terracotta text-sm"></i>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <div class="text-xs text-rust/70 font-medium">สแกน QR Code ด้วยแอปธนาคารใดก็ได้</div>
                            <div class="text-lg font-extrabold text-terracotta">฿{{ number_format($order->total_amount, 2) }}</div>
                        </div>
                    </div>

                    <!-- Bank Account Info Option -->
                    <div class="bg-limestone-light/70 p-3.5 rounded-2xl border border-terracotta/15 text-left text-xs space-y-1.5">
                        <div class="font-bold text-rust flex items-center gap-2">
                            <i class="fa-solid fa-building-columns text-terracotta"></i> หรือโอนเข้าบัญชีธนาคาร:
                        </div>
                        <div class="flex items-center justify-between text-rust/80">
                            <span>ธนาคารกสิกรไทย (KBANK): <strong>095-2-88741-0</strong></span>
                            <span class="text-terracotta font-semibold">บจก. ช้อปดี มอคอัพ</span>
                        </div>
                    </div>

                </div>
            @endif

            <!-- Credit / Debit Card Mockup -->
            @if($order->payment_method === 'credit_card')
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-terracotta/20 space-y-6">
                    
                    <div class="border-b border-limestone pb-3 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-rust flex items-center gap-2">
                            <i class="fa-solid fa-credit-card text-terracotta"></i> จำลองการชำระด้วยบัตรเครดิต / เดบิต
                        </h3>
                        <div class="flex gap-1.5 text-rust/60 text-lg">
                            <i class="fa-brands fa-cc-visa"></i>
                            <i class="fa-brands fa-cc-mastercard"></i>
                            <i class="fa-brands fa-cc-jcb"></i>
                        </div>
                    </div>

                    <!-- 3D Credit Card Mockup Visual -->
                    <div class="relative w-full max-w-sm mx-auto h-48 bg-gradient-to-tr from-[#3b231c] via-[#5A2E25] to-[#B5543A] rounded-2xl p-5 text-white shadow-2xl overflow-hidden border border-white/20 flex flex-col justify-between">
                        <div class="absolute -right-10 -bottom-10 w-44 h-44 bg-white/10 rounded-full blur-xl pointer-events-none"></div>

                        <div class="flex items-center justify-between relative z-10">
                            <span class="text-xs font-bold tracking-widest uppercase">SHOPDEE PLATINUM</span>
                            <i class="fa-brands fa-cc-visa text-3xl opacity-90"></i>
                        </div>

                        <div class="flex items-center gap-3 relative z-10">
                            <div class="w-10 h-7 bg-amber-300 rounded-md shadow-inner flex items-center justify-center opacity-90">
                                <div class="w-6 h-4 border border-amber-600/40 rounded"></div>
                            </div>
                            <i class="fa-solid fa-wifi text-xs rotate-90 opacity-80"></i>
                        </div>

                        <div class="space-y-1 relative z-10">
                            <div class="font-mono text-base tracking-widest" id="card-display-number">4532 •••• •••• 8899</div>
                            <div class="flex items-center justify-between text-[10px] text-white/80 uppercase">
                                <div>
                                    <div class="text-[8px] text-white/60">Card Holder</div>
                                    <div class="font-semibold">{{ $order->user->name ?? 'DEMO CUSTOMER' }}</div>
                                </div>
                                <div>
                                    <div class="text-[8px] text-white/60">Expires</div>
                                    <div class="font-semibold">12/28</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mock Card Form Details -->
                    <div class="space-y-3 text-xs">
                        <div>
                            <label class="block font-medium text-rust/70 mb-1">หมายเลขบัตรเครดิต (Card Number)</label>
                            <input type="text" value="4532 8900 1234 8899" readonly
                                class="w-full p-2.5 border border-terracotta/30 rounded-xl bg-limestone-light/50 font-mono text-rust font-semibold">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-medium text-rust/70 mb-1">วันหมดอายุ (Exp Date)</label>
                                <input type="text" value="12/28" readonly
                                    class="w-full p-2.5 border border-terracotta/30 rounded-xl bg-limestone-light/50 font-mono text-rust text-center font-semibold">
                            </div>
                            <div>
                                <label class="block font-medium text-rust/70 mb-1">CVV / CVC</label>
                                <input type="password" value="888" readonly
                                    class="w-full p-2.5 border border-terracotta/30 rounded-xl bg-limestone-light/50 font-mono text-rust text-center font-semibold">
                            </div>
                        </div>
                    </div>

                </div>
            @endif

            <!-- COD Mockup -->
            @if($order->payment_method === 'cod')
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-terracotta/20 text-center space-y-4">
                    <div class="w-16 h-16 bg-olive/15 text-olive-dark rounded-full flex items-center justify-center mx-auto text-3xl">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-xl font-bold text-rust">เก็บเงินปลายทาง (Cash on Delivery)</h3>
                        <p class="text-xs text-rust/70">
                            คุณเลือกชำระเงินเมื่อพนักงานจัดส่งสินค้าถึงที่อยู่ของคุณ โปรดยืนยันรายการเพื่อเริ่มจัดเตรียมสินค้า
                        </p>
                    </div>
                    <div class="bg-limestone-light p-4 rounded-2xl border border-terracotta/15 inline-block text-sm font-bold text-terracotta">
                        ยอดที่ต้องชำระกับพนักงานส่ง: ฿{{ number_format($order->total_amount, 2) }}
                    </div>
                </div>
            @endif

            <!-- DEMO CONTROL BUTTONS (Simulate Success / Failed) -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border-2 border-terracotta/30 space-y-4">
                <div class="text-center space-y-1">
                    <span class="text-[10px] font-bold uppercase tracking-wider bg-terracotta text-white px-2.5 py-0.5 rounded-full">
                        Demo Interactive Controls
                    </span>
                    <h4 class="text-sm font-bold text-rust">เลือกผลลัพธ์เพื่อทดสอบระบบจำลอง (Simulation Buttons):</h4>
                </div>

                <form action="{{ route('payment.process', $order) }}" method="POST" id="payment-process-form" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @csrf
                    
                    <!-- SUCCESS BUTTON -->
                    <button type="button" onclick="triggerSimulation('success')"
                        class="bg-olive hover:bg-olive-dark text-white font-bold py-3.5 px-4 rounded-2xl shadow transition text-xs sm:text-sm flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-circle-check text-lg group-hover:scale-110 transition-transform"></i>
                        <span>ชำระเงินสำเร็จ (Success)</span>
                    </button>

                    <!-- FAILED BUTTON -->
                    <button type="button" onclick="triggerSimulation('failed')"
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-3.5 px-4 rounded-2xl shadow transition text-xs sm:text-sm flex items-center justify-center gap-2 group">
                        <i class="fa-solid fa-circle-xmark text-lg group-hover:scale-110 transition-transform"></i>
                        <span>ชำระเงินล้มเหลว (Failed)</span>
                    </button>

                    <input type="hidden" name="simulated_result" id="simulated_result_input" value="success">
                </form>

                <p class="text-[11px] text-center text-rust/50 leading-relaxed">
                    * เมื่อเลือก <strong>ชำระเงินล้มเหลว</strong> ระบบจะปรับสถานะออเดอร์เป็น <em>Cancelled</em> และคืนสต็อกสินค้ากลับสู่ระบบโดยอัตโนมัติแบบ Real-time
                </p>
            </div>

        </div>

        <!-- RIGHT COLUMN: Order Summary & Info (5 cols) -->
        <div class="lg:col-span-5 space-y-6">

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-terracotta/20 space-y-4">
                <h3 class="text-base font-bold text-rust border-b border-limestone pb-3 flex items-center justify-between">
                    <span>ข้อมูลคำสั่งซื้อ</span>
                    <span class="text-xs bg-amber-100 text-amber-800 font-bold px-2.5 py-0.5 rounded-full">รอชำระเงิน</span>
                </h3>

                <div class="space-y-3 text-xs text-rust/70">
                    <div class="flex justify-between">
                        <span>เลขที่คำสั่งซื้อ:</span>
                        <span class="font-mono font-bold text-rust">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>วันที่สั่งซื้อ:</span>
                        <span class="font-medium text-rust">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>ช่องทางชำระเงิน:</span>
                        <span class="font-bold uppercase text-terracotta">{{ $order->payment_method }}</span>
                    </div>
                    <div class="flex flex-col pt-1">
                        <span class="text-rust/60">ที่อยู่จัดส่ง:</span>
                        <span class="font-medium text-rust mt-0.5 bg-limestone-light p-2 rounded-xl border border-terracotta/10 leading-relaxed">
                            {{ $order->shipping_address }}
                        </span>
                    </div>
                </div>

                <!-- Ordered Items List -->
                <div class="border-t border-limestone pt-3 space-y-2">
                    <span class="text-xs font-bold text-rust block">รายการสินค้า ({{ $order->items->count() }} รายการ):</span>
                    <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between text-xs">
                                <div class="truncate max-w-[170px] text-rust">
                                    <span class="font-medium">{{ $item->product->name }}</span>
                                    <span class="text-rust/50">x{{ $item->quantity }}</span>
                                </div>
                                <span class="font-bold text-rust">฿{{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total Amount -->
                <div class="border-t border-dashed border-terracotta/30 pt-3 flex items-baseline justify-between">
                    <span class="font-bold text-rust text-sm">ยอดชำระทั้งหมด:</span>
                    <span class="font-extrabold text-2xl text-terracotta">฿{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Cancel Order Form if customer changes mind -->
            <div class="text-center">
                <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('คุณต้องการยกเลิกคำสั่งซื้อนี้และคืนสต็อกสินค้าใช่หรือไม่?');">
                    @csrf
                    <button type="submit" class="text-xs text-rust/60 hover:text-red-600 transition underline">
                        ยกเลิกคำสั่งซื้อนี้ (คืนสต็อกสินค้า)
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>

<!-- Simulation Loading Modal Overlay -->
<div id="loading-overlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center space-y-4 shadow-2xl border border-terracotta/20 animate-fade-in">
        <div class="w-16 h-16 rounded-full bg-terracotta/15 text-terracotta flex items-center justify-center mx-auto text-2xl">
            <i class="fa-solid fa-spinner fa-spin"></i>
        </div>
        <div class="space-y-1">
            <h4 class="text-lg font-bold text-rust" id="loading-title">กำลังประมวลผลการชำระเงิน...</h4>
            <p class="text-xs text-rust/60" id="loading-desc">กำลังเชื่อมต่อกับระบบ Gateway และตัดยอดจำลอง</p>
        </div>
    </div>
</div>

<!-- Countdown & Simulation JavaScript -->
<script>
    // 15-minute Countdown Timer Mockup
    let totalSeconds = 15 * 60;
    const timerElement = document.getElementById('countdown-timer');

    if (timerElement) {
        const timerInterval = setInterval(() => {
            totalSeconds--;
            if (totalSeconds <= 0) {
                clearInterval(timerInterval);
                timerElement.innerText = 'หมดเวลา';
            } else {
                const minutes = Math.floor(totalSeconds / 60);
                const seconds = totalSeconds % 60;
                timerElement.innerText = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        }, 1000);
    }

    // Trigger Simulation with Animated Processing Delay
    function triggerSimulation(result) {
        const form = document.getElementById('payment-process-form');
        const input = document.getElementById('simulated_result_input');
        const overlay = document.getElementById('loading-overlay');
        const title = document.getElementById('loading-title');
        const desc = document.getElementById('loading-desc');

        input.value = result;
        overlay.classList.remove('hidden');

        if (result === 'success') {
            title.innerText = 'กำลังยืนยันการชำระเงิน...';
            desc.innerText = 'ตรวจพบยอดโอนเงิน กำลังบันทึกธุรกรรมสำเร็จ';
        } else {
            title.innerText = 'กำลังประมวลผลการยกเลิก...';
            desc.innerText = 'รายการไม่สำเร็จ กำลังคืนสต็อกสินค้าเข้าสู่ระบบ';
        }

        setTimeout(() => {
            form.submit();
        }, 900);
    }
</script>
@endsection
