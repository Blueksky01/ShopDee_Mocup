@extends('layouts.app')

@section('title', 'ยืนยันสั่งซื้อสินค้า - ShopDee')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    
    <!-- Step Indicator Progress Bar -->
    <div class="bg-white p-4 sm:p-6 rounded-3xl shadow-sm border border-terracotta/20">
        <div class="flex items-center justify-between max-w-3xl mx-auto relative">
            <!-- Background Line -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-limestone w-full z-0"></div>
            <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-terracotta w-1/2 z-0"></div>

            <!-- Step 1: Cart -->
            <div class="relative z-10 flex flex-col items-center gap-1.5">
                <a href="{{ route('cart.index') }}" class="w-10 h-10 rounded-full bg-terracotta text-white flex items-center justify-center font-bold text-sm shadow">
                    <i class="fa-solid fa-check"></i>
                </a>
                <span class="text-xs font-semibold text-rust">1. ตะกร้าสินค้า</span>
            </div>

            <!-- Step 2: Checkout (Current) -->
            <div class="relative z-10 flex flex-col items-center gap-1.5">
                <div class="w-10 h-10 rounded-full bg-terracotta text-white flex items-center justify-center font-bold text-sm ring-4 ring-terracotta/20 shadow">
                    2
                </div>
                <span class="text-xs font-bold text-terracotta">2. ที่อยู่และวิธีชำระ</span>
            </div>

            <!-- Step 3: Payment Mockup -->
            <div class="relative z-10 flex flex-col items-center gap-1.5">
                <div class="w-10 h-10 rounded-full bg-limestone text-rust/50 flex items-center justify-center font-bold text-sm">
                    3
                </div>
                <span class="text-xs font-medium text-rust/50">3. จำลองชำระเงิน</span>
            </div>

            <!-- Step 4: Complete -->
            <div class="relative z-10 flex flex-col items-center gap-1.5">
                <div class="w-10 h-10 rounded-full bg-limestone text-rust/50 flex items-center justify-center font-bold text-sm">
                    4
                </div>
                <span class="text-xs font-medium text-rust/50">4. สำเร็จ</span>
            </div>
        </div>
    </div>

    <!-- Main Checkout Form -->
    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf

        <!-- LEFT COLUMN: Shipping Address, Delivery Options & Payment Selection (7 cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- 1. Shipping Address Card -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-terracotta/20 space-y-4">
                <div class="flex items-center justify-between border-b border-limestone pb-3">
                    <h2 class="text-base font-bold text-rust flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-terracotta/15 text-terracotta flex items-center justify-center text-sm">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <span>1. ที่อยู่สำหรับจัดส่งสินค้า</span>
                    </h2>
                    <span class="text-xs text-olive-dark font-medium"><i class="fa-solid fa-truck mr-1"></i> มีบริการเก็บเงินปลายทาง</span>
                </div>

                <!-- Quick Address Presets -->
                <div class="space-y-2">
                    <span class="text-xs font-semibold text-rust/70 block">เลือกจากที่อยู่บันทึกไว้ด่วน:</span>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <button type="button" onclick="selectAddress('home')" id="addr-btn-home"
                            class="addr-preset-btn p-2.5 text-xs rounded-xl border border-terracotta bg-terracotta/10 text-rust font-bold text-left transition flex items-center gap-2">
                            <i class="fa-solid fa-house text-terracotta"></i>
                            <div>
                                <div class="font-bold">🏠 บ้าน</div>
                                <div class="text-[10px] text-rust/60 font-normal truncate">กทม. 10110</div>
                            </div>
                        </button>

                        <button type="button" onclick="selectAddress('office')" id="addr-btn-office"
                            class="addr-preset-btn p-2.5 text-xs rounded-xl border border-terracotta/30 bg-limestone-light text-rust text-left transition hover:bg-limestone flex items-center gap-2">
                            <i class="fa-solid fa-building text-rust/70"></i>
                            <div>
                                <div class="font-bold">🏢 ที่ทำงาน</div>
                                <div class="text-[10px] text-rust/60 font-normal truncate">สุขุมวิท 21, กทม.</div>
                            </div>
                        </button>

                        <button type="button" onclick="selectAddress('custom')" id="addr-btn-custom"
                            class="addr-preset-btn p-2.5 text-xs rounded-xl border border-terracotta/30 bg-limestone-light text-rust text-left transition hover:bg-limestone flex items-center gap-2">
                            <i class="fa-solid fa-pen text-rust/70"></i>
                            <div>
                                <div class="font-bold">✏️ กำหนดเอง</div>
                                <div class="text-[10px] text-rust/60 font-normal">พิมพ์ที่อยู่ใหม่</div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Address Textarea -->
                <div>
                    <label for="shipping_address" class="block text-xs font-medium text-rust/80 mb-1">
                        รายละเอียดที่อยู่จัดส่ง (บ้านเลขที่, อาคาร, ถนน, แขวง/ตำบล, เขต/อำเภอ, จังหวัด, รหัสไปรษณีย์)
                    </label>
                    <textarea name="shipping_address" id="shipping_address" rows="3" required placeholder="กรอกที่อยู่สำหรับจัดส่งสินค้า..."
                        class="w-full p-3.5 border border-terracotta/30 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-terracotta bg-limestone-light/50 font-sans leading-relaxed text-rust">123/45 ถนนสุขุมวิท ซอย 24 แขวงคลองเตย เขตคลองเตย กรุงเทพมหานคร 10110 (โทร 081-234-5678)</textarea>
                    @error('shipping_address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 2. Delivery Method Options -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-terracotta/20 space-y-4">
                <h2 class="text-base font-bold text-rust flex items-center gap-2.5 border-b border-limestone pb-3">
                    <div class="w-8 h-8 rounded-xl bg-terracotta/15 text-terracotta flex items-center justify-center text-sm">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <span>2. เลือกรูปแบบการจัดส่ง (Shipping Options)</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="shipping-option-label relative flex flex-col p-3.5 border-2 border-terracotta bg-terracotta/5 rounded-2xl cursor-pointer transition shadow-sm">
                        <input type="radio" name="shipping_speed" value="standard" checked class="sr-only" onchange="updateShipping(0)">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-bold text-xs text-rust">จัดส่งมาตรฐาน</span>
                            <span class="text-xs font-extrabold text-olive-dark">ฟรี</span>
                        </div>
                        <span class="text-[10px] text-rust/60">ได้รับภายใน 2-3 วันทำการ</span>
                    </label>

                    <label class="shipping-option-label relative flex flex-col p-3.5 border-2 border-terracotta/20 bg-limestone-light/40 rounded-2xl cursor-pointer transition hover:bg-limestone/50">
                        <input type="radio" name="shipping_speed" value="express" class="sr-only" onchange="updateShipping(50)">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-bold text-xs text-rust">Express ด่วนพิเศษ</span>
                            <span class="text-xs font-bold text-terracotta">+฿50</span>
                        </div>
                        <span class="text-[10px] text-rust/60">ได้รับภายใน 1-2 วันทำการ</span>
                    </label>

                    <label class="shipping-option-label relative flex flex-col p-3.5 border-2 border-terracotta/20 bg-limestone-light/40 rounded-2xl cursor-pointer transition hover:bg-limestone/50">
                        <input type="radio" name="shipping_speed" value="sameday" class="sr-only" onchange="updateShipping(100)">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-bold text-xs text-rust">Same Day ส่งด่วน</span>
                            <span class="text-xs font-bold text-terracotta">+฿100</span>
                        </div>
                        <span class="text-[10px] text-rust/60">ส่งถึงภายในวัน (กทม. & ปริมณฑล)</span>
                    </label>
                </div>
            </div>

            <!-- 3. Payment Method Selection -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-terracotta/20 space-y-4">
                <h2 class="text-base font-bold text-rust flex items-center gap-2.5 border-b border-limestone pb-3">
                    <div class="w-8 h-8 rounded-xl bg-terracotta/15 text-terracotta flex items-center justify-center text-sm">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <span>3. เลือกวิธีชำระเงิน (Mockup Payment Options)</span>
                </h2>

                <div class="space-y-3">
                    <!-- Option 1: PromptPay QR -->
                    <label class="payment-method-card flex items-start p-4 border-2 border-terracotta bg-terracotta/5 rounded-2xl cursor-pointer transition">
                        <input type="radio" name="payment_method" value="promptpay" checked class="mt-1 text-terracotta focus:ring-terracotta accent-terracotta" onchange="selectPaymentTab('promptpay')">
                        <div class="ml-3.5 flex-1">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-rust text-sm flex items-center gap-2">
                                    <i class="fa-solid fa-qrcode text-terracotta text-base"></i>
                                    พร้อมเพย์ QR Code (PromptPay QR)
                                </span>
                                <span class="text-[10px] bg-olive text-white px-2 py-0.5 rounded-full font-bold uppercase">แนะนำ</span>
                            </div>
                            <p class="text-xs text-rust/60 mt-0.5">สแกนจ่ายผ่านแอปธนาคารทุกธนาคาร ไม่มีค่าธรรมเนียม</p>
                        </div>
                    </label>

                    <!-- Option 2: Credit / Debit Card -->
                    <label class="payment-method-card flex items-start p-4 border-2 border-terracotta/20 bg-limestone-light/40 rounded-2xl cursor-pointer transition hover:bg-limestone/50">
                        <input type="radio" name="payment_method" value="credit_card" class="mt-1 text-terracotta focus:ring-terracotta accent-terracotta" onchange="selectPaymentTab('credit_card')">
                        <div class="ml-3.5 flex-1">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-rust text-sm flex items-center gap-2">
                                    <i class="fa-brands fa-cc-visa text-terracotta text-base"></i>
                                    บัตรเครดิต / บัตรเดบิต (Credit / Debit Card)
                                </span>
                                <div class="flex gap-1.5 text-rust/70 text-sm">
                                    <i class="fa-brands fa-cc-visa"></i>
                                    <i class="fa-brands fa-cc-mastercard"></i>
                                    <i class="fa-brands fa-cc-jcb"></i>
                                </div>
                            </div>
                            <p class="text-xs text-rust/60 mt-0.5">จำลองการชำระผ่านระบบรักษาความปลอดภัย 3D Secure OTP</p>
                        </div>
                    </label>

                    <!-- Option 3: Bank Transfer -->
                    <label class="payment-method-card flex items-start p-4 border-2 border-terracotta/20 bg-limestone-light/40 rounded-2xl cursor-pointer transition hover:bg-limestone/50">
                        <input type="radio" name="payment_method" value="bank_transfer" class="mt-1 text-terracotta focus:ring-terracotta accent-terracotta" onchange="selectPaymentTab('bank_transfer')">
                        <div class="ml-3.5 flex-1">
                            <span class="font-bold text-rust text-sm flex items-center gap-2">
                                <i class="fa-solid fa-building-columns text-terracotta text-base"></i>
                                โอนเงินผ่านบัญชีธนาคาร & แนบสลิป (Bank Transfer)
                            </span>
                            <p class="text-xs text-rust/60 mt-0.5">กสิกรไทย, ไทยพาณิชย์, กรุงเทพ พร้อมระบบ AI ตรวจสอบสลิปจำลอง</p>
                        </div>
                    </label>

                    <!-- Option 4: Cash on Delivery -->
                    <label class="payment-method-card flex items-start p-4 border-2 border-terracotta/20 bg-limestone-light/40 rounded-2xl cursor-pointer transition hover:bg-limestone/50">
                        <input type="radio" name="payment_method" value="cod" class="mt-1 text-terracotta focus:ring-terracotta accent-terracotta" onchange="selectPaymentTab('cod')">
                        <div class="ml-3.5 flex-1">
                            <span class="font-bold text-rust text-sm flex items-center gap-2">
                                <i class="fa-solid fa-hand-holding-dollar text-terracotta text-base"></i>
                                เก็บเงินปลายทาง (Cash on Delivery)
                            </span>
                            <p class="text-xs text-rust/60 mt-0.5">ชำระเงินสดกับพนักงานจัดส่งเมื่อได้รับสินค้า</p>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN: Order Summary & Confirmation Action (5 cols) -->
        <div class="lg:col-span-5 space-y-6">

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-terracotta/20 space-y-5 sticky top-6">
                <h2 class="text-base font-bold text-rust border-b border-limestone pb-3 flex items-center justify-between">
                    <span>สรุปรายการสั่งซื้อ</span>
                    <a href="{{ route('cart.index') }}" class="text-xs text-terracotta hover:underline font-medium">
                        แก้ไขตะกร้า
                    </a>
                </h2>

                <!-- Items List Preview -->
                <div class="space-y-3 max-h-60 overflow-y-auto pr-1 divide-y divide-limestone">
                    @foreach($cart->items as $item)
                        <div class="pt-2 first:pt-0 flex items-center justify-between gap-3 text-xs">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-limestone/50 border border-terracotta/15 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if($item->product->image)
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
                                    <div class="font-bold text-rust truncate">{{ $item->product->name }}</div>
                                    <div class="text-rust/50">จำนวน {{ $item->quantity }} ชิ้น</div>
                                </div>
                            </div>
                            <span class="font-extrabold text-terracotta whitespace-nowrap">
                                ฿{{ number_format($item->product->price * $item->quantity, 2) }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <!-- Price Breakdown Calculation -->
                <div class="border-t border-limestone pt-3 space-y-2.5 text-xs text-rust/70">
                    <div class="flex justify-between">
                        <span>ยอดรวมสินค้า:</span>
                        <span class="font-bold text-rust" id="checkout-subtotal">฿{{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>ค่าบริการจัดส่ง:</span>
                        <span class="font-bold text-olive-dark" id="checkout-shipping-fee">ฟรี</span>
                    </div>

                    <div class="border-t border-dashed border-terracotta/30 pt-3 flex justify-between items-baseline">
                        <span class="font-bold text-rust text-base">ยอดที่ต้องชำระ:</span>
                        <span class="font-extrabold text-2xl text-terracotta" id="checkout-grand-total">฿{{ number_format($subtotal, 2) }}</span>
                    </div>
                </div>

                <!-- Submit Button with Spinner -->
                <button type="submit" id="submit-order-btn"
                    class="w-full bg-terracotta hover:bg-terracotta-dark text-white font-bold py-4 px-6 rounded-2xl shadow-xl transition transform active:scale-95 flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-lock text-sm"></i>
                    <span id="btn-text">ดำเนินการไปยังหน้าชำระเงิน</span>
                    <i class="fa-solid fa-arrow-right ml-1"></i>
                </button>

                <div class="bg-limestone-light p-3 rounded-2xl border border-terracotta/15 flex items-center gap-3">
                    <i class="fa-solid fa-shield-halved text-olive text-lg"></i>
                    <div class="text-[11px] text-rust/70">
                        <strong>การชำระเงินจำลอง 100%</strong> ปลอดภัยสำหรับการทดสอบระบบ
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<!-- Interactive UI Scripts for Address Presets, Shipping Fees & Payment Cards -->
<script>
    const baseSubtotal = {{ $subtotal }};
    let shippingFee = 0;

    function selectAddress(type) {
        const textarea = document.getElementById('shipping_address');
        const btns = document.querySelectorAll('.addr-preset-btn');
        
        btns.forEach(b => {
            b.className = 'addr-preset-btn p-2.5 text-xs rounded-xl border border-terracotta/30 bg-limestone-light text-rust text-left transition hover:bg-limestone flex items-center gap-2';
        });

        const activeBtn = document.getElementById('addr-btn-' + type);
        if (activeBtn) {
            activeBtn.className = 'addr-preset-btn p-2.5 text-xs rounded-xl border border-terracotta bg-terracotta/10 text-rust font-bold text-left transition flex items-center gap-2';
        }

        if (type === 'home') {
            textarea.value = '123/45 ถนนสุขุมวิท ซอย 24 แขวงคลองเตย เขตคลองเตย กรุงเทพมหานคร 10110 (โทร 081-234-5678)';
        } else if (type === 'office') {
            textarea.value = 'อาคารเอ็กเชนทาวเวอร์ ชั้น 18 เลขที่ 388 ถนนสุขุมวิท 21 แขวงคลองเตยเหนือ เขตวัฒนา กรุงเทพฯ 10110 (โทร 089-987-6543)';
        } else if (type === 'custom') {
            textarea.value = '';
            textarea.focus();
        }
    }

    function updateShipping(fee) {
        shippingFee = fee;
        const feeLabel = document.getElementById('checkout-shipping-fee');
        const grandTotalLabel = document.getElementById('checkout-grand-total');

        if (fee === 0) {
            feeLabel.innerText = 'ฟรี';
            feeLabel.className = 'font-bold text-olive-dark';
        } else {
            feeLabel.innerText = '+฿' + fee.toFixed(2);
            feeLabel.className = 'font-bold text-terracotta';
        }

        const grandTotal = baseSubtotal + fee;
        grandTotalLabel.innerText = '฿' + grandTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        // Update active border on shipping labels
        const shippingLabels = document.querySelectorAll('.shipping-option-label');
        shippingLabels.forEach(l => {
            const radio = l.querySelector('input');
            if (radio && radio.checked) {
                l.className = 'shipping-option-label relative flex flex-col p-3.5 border-2 border-terracotta bg-terracotta/5 rounded-2xl cursor-pointer transition shadow-sm';
            } else {
                l.className = 'shipping-option-label relative flex flex-col p-3.5 border-2 border-terracotta/20 bg-limestone-light/40 rounded-2xl cursor-pointer transition hover:bg-limestone/50';
            }
        });
    }

    function selectPaymentTab(method) {
        const cards = document.querySelectorAll('.payment-method-card');
        cards.forEach(card => {
            const radio = card.querySelector('input');
            if (radio && radio.checked) {
                card.className = 'payment-method-card flex items-start p-4 border-2 border-terracotta bg-terracotta/5 rounded-2xl cursor-pointer transition shadow-sm';
            } else {
                card.className = 'payment-method-card flex items-start p-4 border-2 border-terracotta/20 bg-limestone-light/40 rounded-2xl cursor-pointer transition hover:bg-limestone/50';
            }
        });
    }

    // Submit Loading Protection
    document.getElementById('checkout-form').addEventListener('submit', function() {
        const btn = document.getElementById('submit-order-btn');
        const text = document.getElementById('btn-text');
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        text.innerText = 'กำลังสร้างคำสั่งซื้อ...';
    });
</script>
@endsection
