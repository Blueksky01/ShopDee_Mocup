@extends('layouts.app')

@section('title', 'ตะกร้าสินค้าของคุณ - ShopDee')

@section('content')
<div class="space-y-8">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <nav class="flex text-xs text-rust/60 gap-2 mb-1">
                <a href="{{ route('products.index') }}" class="hover:text-terracotta transition">หน้าแรก</a>
                <span>/</span>
                <span class="text-terracotta font-semibold">ตะกร้าสินค้า</span>
            </nav>
            <h1 class="text-2xl sm:text-3xl font-bold text-rust flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-terracotta/15 text-terracotta flex items-center justify-center text-lg shadow-sm">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <span>ตะกร้าสินค้าของคุณ</span>
                <span class="text-xs font-normal bg-terracotta text-white px-3 py-1 rounded-full shadow-sm">
                    {{ $cart->items->sum('quantity') }} ชิ้น
                </span>
            </h1>
        </div>

        <a href="{{ route('products.index') }}#catalog" class="inline-flex items-center gap-2 text-sm text-rust/80 hover:text-terracotta font-medium transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>เลือกซื้อสินค้าเพิ่มเติม</span>
        </a>
    </div>

    @if($cart->items->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Items Selection & Table (8 cols) -->
            <div class="lg:col-span-8 space-y-4">

                <!-- Table Header Actions Card -->
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-terracotta/20 flex items-center justify-between">
                    <label class="flex items-center gap-3 cursor-pointer select-none text-sm font-bold text-rust">
                        <input type="checkbox" id="select-all-checkbox" checked
                            class="w-4 h-4 rounded text-terracotta focus:ring-terracotta border-terracotta/40 accent-terracotta">
                        <span>เลือกสินค้าทั้งหมด (<span id="selected-count-label">{{ $cart->items->count() }}</span>/{{ $cart->items->count() }})</span>
                    </label>

                    <span class="text-xs text-olive-dark font-medium bg-olive/15 px-3 py-1 rounded-full">
                        <i class="fa-solid fa-shield-check mr-1"></i> สินค้าของแท้ 100%
                    </span>
                </div>

                <!-- Items List -->
                <div class="bg-white rounded-2xl shadow-sm border border-terracotta/20 overflow-hidden divide-y divide-limestone">
                    @foreach($cart->items as $item)
                        <div class="cart-item-row p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 transition hover:bg-limestone-light/40"
                            data-item-id="{{ $item->id }}"
                            data-price="{{ $item->product->price }}"
                            data-qty="{{ $item->quantity }}"
                            data-stock="{{ $item->product->stock }}">

                            <!-- Checkbox + Image + Title -->
                            <div class="flex items-center gap-4 flex-1">
                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" checked
                                    class="item-checkbox w-4 h-4 rounded text-terracotta focus:ring-terracotta border-terracotta/40 accent-terracotta cursor-pointer">

                                <div class="w-20 h-20 bg-limestone/50 rounded-2xl border border-terracotta/15 flex-shrink-0 flex items-center justify-center overflow-hidden relative">
                                    @if($item->product->image)
                                        @if(str_starts_with($item->product->image, 'http'))
                                            <img src="{{ $item->product->image }}" class="w-full h-full object-cover">
                                        @elseif(str_starts_with($item->product->image, 'images/'))
                                            <img src="{{ asset($item->product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                        @endif
                                    @else
                                        <i class="fa-solid fa-box-open text-terracotta/40 text-2xl"></i>
                                    @endif
                                </div>

                                <div class="space-y-1">
                                    <span class="text-[10px] font-bold tracking-wider uppercase text-terracotta bg-terracotta/10 px-2 py-0.5 rounded-md">
                                        {{ $item->product->category->name ?? 'สินค้า' }}
                                    </span>
                                    <h3 class="font-bold text-rust hover:text-terracotta transition text-sm sm:text-base">
                                        <a href="{{ route('products.show', $item->product->slug) }}">
                                            {{ $item->product->name }}
                                        </a>
                                    </h3>
                                    <div class="text-xs text-rust/60 flex items-center gap-2">
                                        <span>คงเหลือ: <strong class="text-rust/80">{{ $item->product->stock }}</strong> ชิ้น</span>
                                        @if($item->product->stock < 5)
                                            <span class="text-terracotta font-semibold">(สินค้าใกล้หมด)</span>
                                        @endif
                                    </div>
                                    <div class="text-sm font-extrabold text-terracotta sm:hidden">
                                        ฿{{ number_format($item->product->price, 2) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Unit Price (Desktop) -->
                            <div class="hidden sm:block text-right pr-4">
                                <span class="text-xs text-rust/50 block">ราคา/ชิ้น</span>
                                <span class="text-sm font-bold text-rust">
                                    ฿{{ number_format($item->product->price, 2) }}
                                </span>
                            </div>

                            <!-- Quantity Stepper Controls (+ / -) -->
                            <div class="flex items-center justify-between sm:justify-center w-full sm:w-auto gap-4">
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-1.5" id="form-update-{{ $item->id }}">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <div class="flex items-center bg-limestone-light border border-terracotta/30 rounded-xl overflow-hidden shadow-inner">
                                        <button type="button" class="btn-qty-minus w-8 h-8 flex items-center justify-center text-rust hover:bg-terracotta hover:text-white transition disabled:opacity-40 disabled:hover:bg-transparent disabled:hover:text-rust"
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                            <i class="fa-solid fa-minus text-xs"></i>
                                        </button>
                                        
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                            class="qty-input w-12 text-center text-xs font-bold text-rust bg-transparent focus:outline-none border-0"
                                            onchange="this.form.submit()">
                                        
                                        <button type="button" class="btn-qty-plus w-8 h-8 flex items-center justify-center text-rust hover:bg-terracotta hover:text-white transition disabled:opacity-40 disabled:hover:bg-transparent disabled:hover:text-rust"
                                            {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>
                                            <i class="fa-solid fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                </form>

                                <!-- Subtotal for Item -->
                                <div class="text-right min-w-[90px]">
                                    <span class="text-xs text-rust/50 block sm:hidden">รวม</span>
                                    <span class="item-subtotal text-base font-extrabold text-terracotta">
                                        ฿{{ number_format($item->product->price * $item->quantity, 2) }}
                                    </span>
                                </div>

                                <!-- Delete button -->
                                <form action="{{ route('cart.remove', $item) }}" method="POST" onsubmit="return confirm('ต้องการนำสินค้านี้ออกจากตะกร้าใช่หรือไม่?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition flex items-center justify-center shadow-sm" title="ลบออกจากตะกร้า">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Shopping Guarantees Banner -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                    <div class="bg-white/80 p-3.5 rounded-2xl border border-terracotta/15 flex items-center gap-3">
                        <i class="fa-solid fa-truck-fast text-terracotta text-lg"></i>
                        <div class="text-xs">
                            <strong class="text-rust block">จัดส่งรวดเร็ว</strong>
                            <span class="text-rust/60">รองรับระบบขนส่งทั่วไทย</span>
                        </div>
                    </div>
                    <div class="bg-white/80 p-3.5 rounded-2xl border border-terracotta/15 flex items-center gap-3">
                        <i class="fa-solid fa-rotate-left text-olive text-lg"></i>
                        <div class="text-xs">
                            <strong class="text-rust block">รับประกันคืนสินค้า</strong>
                            <span class="text-rust/60">เปลี่ยนคืนได้ภายใน 7 วัน</span>
                        </div>
                    </div>
                    <div class="bg-white/80 p-3.5 rounded-2xl border border-terracotta/15 flex items-center gap-3">
                        <i class="fa-solid fa-shield-halved text-terracotta text-lg"></i>
                        <div class="text-xs">
                            <strong class="text-rust block">ชำระเงินปลอดภัย</strong>
                            <span class="text-rust/60">ระบบจำลอง Mockup 100%</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Order Summary Card (4 cols) -->
            <div class="lg:col-span-4 space-y-6">

                <!-- Mockup Promo Code Card -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-terracotta/20 space-y-3">
                    <h3 class="text-sm font-bold text-rust flex items-center gap-2">
                        <i class="fa-solid fa-ticket text-terracotta"></i> โค้ดส่วนลด (Mockup Voucher)
                    </h3>
                    <div class="flex gap-2">
                        <input type="text" id="coupon-input" placeholder="กรอกโค้ด เช่น DEE10"
                            class="flex-1 px-3.5 py-2 border border-terracotta/30 rounded-xl text-xs uppercase focus:outline-none focus:ring-2 focus:ring-terracotta bg-limestone-light/60">
                        <button type="button" id="apply-coupon-btn"
                            class="bg-terracotta hover:bg-terracotta-dark text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow">
                            ใช้โค้ด
                        </button>
                    </div>
                    
                    <!-- Quick Mockup Coupon Chips -->
                    <div class="flex flex-wrap gap-1.5 pt-1">
                        <button type="button" onclick="setCoupon('DEE10')" class="text-[10px] bg-limestone hover:bg-terracotta/20 text-rust font-semibold px-2.5 py-1 rounded-lg border border-terracotta/20 transition">
                            🎟️ DEE10 (ลด 10%)
                        </button>
                        <button type="button" onclick="setCoupon('FREESHIP')" class="text-[10px] bg-limestone hover:bg-terracotta/20 text-rust font-semibold px-2.5 py-1 rounded-lg border border-terracotta/20 transition">
                            🚚 FREESHIP (ส่งฟรี)
                        </button>
                        <button type="button" onclick="setCoupon('WELCOME50')" class="text-[10px] bg-limestone hover:bg-terracotta/20 text-rust font-semibold px-2.5 py-1 rounded-lg border border-terracotta/20 transition">
                            🎁 WELCOME50 (ลด ฿50)
                        </button>
                    </div>
                    <div id="coupon-feedback" class="text-xs hidden font-medium"></div>
                </div>

                <!-- Financial Calculation Card -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-terracotta/20 space-y-4">
                    <h2 class="text-base font-bold text-rust border-b border-limestone pb-3 flex items-center justify-between">
                        <span>สรุปรายการสั่งซื้อ</span>
                        <span class="text-xs text-rust/50 font-normal" id="summary-items-count">{{ $cart->items->sum('quantity') }} ชิ้น</span>
                    </h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-rust/70">
                            <span>ยอดรวมสินค้า:</span>
                            <span class="font-bold text-rust" id="summary-subtotal">฿{{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between text-rust/70">
                            <span>ส่วนลดพิเศษ:</span>
                            <span class="font-bold text-olive-dark" id="summary-discount">-฿0.00</span>
                        </div>

                        <div class="flex justify-between text-rust/70">
                            <span>ค่าจัดส่ง:</span>
                            <span class="font-bold text-olive-dark" id="summary-shipping">ฟรี (Standard)</span>
                        </div>

                        <div class="border-t border-dashed border-terracotta/20 pt-3 flex justify-between items-baseline">
                            <span class="font-bold text-rust text-base">ยอดรวมสุทธิ:</span>
                            <span class="font-extrabold text-2xl text-terracotta" id="summary-total">฿{{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div>

                    <!-- Proceed to Checkout Button -->
                    <a href="{{ route('checkout.index') }}" id="checkout-link-btn"
                        class="w-full bg-terracotta hover:bg-terracotta-dark text-white font-bold py-3.5 px-4 rounded-xl shadow-lg transition flex items-center justify-center gap-2 group text-sm">
                        <span>ดำเนินการสั่งซื้อสินค้า</span>
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <p class="text-[11px] text-center text-rust/50">
                        * สามารถเลือกวิธีชำระเงินและระบุที่อยู่ในขั้นตอนถัดไป
                    </p>
                </div>

            </div>
        </div>
    @else
        <!-- Empty Cart State -->
        <div class="bg-white p-12 sm:p-16 text-center rounded-3xl shadow-sm border border-terracotta/20 max-w-xl mx-auto space-y-5">
            <div class="w-24 h-24 bg-limestone/60 text-terracotta rounded-full flex items-center justify-center mx-auto text-4xl shadow-inner">
                <i class="fa-solid fa-cart-flatbed"></i>
            </div>
            <div class="space-y-1">
                <h3 class="text-2xl font-bold text-rust">ยังไม่มีสินค้าในตะกร้า</h3>
                <p class="text-rust/60 text-sm">เลือกดูคอลเลกชันสินค้าคุณภาพสไตล์ Warm Industrial-Earth แล้วเพิ่มลงตะกร้าได้เลย!</p>
            </div>
            <div class="pt-2">
                <a href="{{ route('products.index') }}#catalog" class="inline-flex items-center gap-2 bg-terracotta hover:bg-terracotta-dark text-white font-medium px-8 py-3 rounded-2xl shadow transition text-sm">
                    <i class="fa-solid fa-store"></i>
                    <span>เริ่มเลือกชมสินค้า</span>
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Interactive Cart Stepper and Calculator JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all-checkbox');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const selectedCountLabel = document.getElementById('selected-count-label');
        const summarySubtotal = document.getElementById('summary-subtotal');
        const summaryDiscount = document.getElementById('summary-discount');
        const summaryTotal = document.getElementById('summary-total');
        const summaryItemsCount = document.getElementById('summary-items-count');
        const checkoutBtn = document.getElementById('checkout-link-btn');

        let currentDiscount = 0;
        let appliedCouponCode = null;

        // Stepper buttons (+ and -)
        document.querySelectorAll('.cart-item-row').forEach(row => {
            const minusBtn = row.querySelector('.btn-qty-minus');
            const plusBtn = row.querySelector('.btn-qty-plus');
            const input = row.querySelector('.qty-input');
            const form = row.querySelector('form');
            const maxStock = parseInt(row.getAttribute('data-stock'), 10);

            if (minusBtn && input) {
                minusBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    let currentVal = parseInt(input.value, 10) || 1;
                    if (currentVal > 1) {
                        input.value = currentVal - 1;
                        form.submit();
                    }
                });
            }

            if (plusBtn && input) {
                plusBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    let currentVal = parseInt(input.value, 10) || 1;
                    if (currentVal < maxStock) {
                        input.value = currentVal + 1;
                        form.submit();
                    }
                });
            }
        });

        // Recalculate totals based on checked items
        function calculateCart() {
            let total = 0;
            let totalQuantity = 0;
            let checkedCount = 0;

            document.querySelectorAll('.cart-item-row').forEach(row => {
                const checkbox = row.querySelector('.item-checkbox');
                if (checkbox && checkbox.checked) {
                    const price = parseFloat(row.getAttribute('data-price')) || 0;
                    const qty = parseInt(row.getAttribute('data-qty'), 10) || 1;
                    total += (price * qty);
                    totalQuantity += qty;
                    checkedCount++;
                }
            });

            if (selectedCountLabel) {
                selectedCountLabel.innerText = checkedCount;
            }

            if (summaryItemsCount) {
                summaryItemsCount.innerText = totalQuantity + ' ชิ้น';
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.checked = (checkedCount === itemCheckboxes.length && itemCheckboxes.length > 0);
            }

            // Apply Discount if coupon active
            let discountAmount = 0;
            if (appliedCouponCode === 'DEE10') {
                discountAmount = total * 0.10;
            } else if (appliedCouponCode === 'WELCOME50') {
                discountAmount = Math.min(50, total);
            }

            const netTotal = Math.max(0, total - discountAmount);

            if (summarySubtotal) summarySubtotal.innerText = '฿' + total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            if (summaryDiscount) summaryDiscount.innerText = '-฿' + discountAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            if (summaryTotal) summaryTotal.innerText = '฿' + netTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            if (checkoutBtn) {
                if (checkedCount === 0) {
                    checkoutBtn.classList.add('opacity-50', 'pointer-events-none');
                } else {
                    checkoutBtn.classList.remove('opacity-50', 'pointer-events-none');
                }
            }
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                itemCheckboxes.forEach(cb => {
                    cb.checked = selectAllCheckbox.checked;
                });
                calculateCart();
            });
        }

        itemCheckboxes.forEach(cb => {
            cb.addEventListener('change', calculateCart);
        });

        // Coupon Code Logic Mockup
        const couponInput = document.getElementById('coupon-input');
        const applyBtn = document.getElementById('apply-coupon-btn');
        const feedback = document.getElementById('coupon-feedback');

        window.setCoupon = function(code) {
            if (couponInput) {
                couponInput.value = code;
                applyCoupon(code);
            }
        };

        function applyCoupon(code) {
            const cleanCode = (code || (couponInput ? couponInput.value : '')).trim().toUpperCase();
            if (!feedback) return;

            feedback.classList.remove('hidden', 'text-olive-dark', 'text-red-500');

            if (cleanCode === 'DEE10') {
                appliedCouponCode = 'DEE10';
                feedback.classList.add('text-olive-dark');
                feedback.innerHTML = '<i class="fa-solid fa-circle-check"></i> ใช้งานโค้ด DEE10 สำเร็จ! รับส่วนลด 10%';
            } else if (cleanCode === 'FREESHIP') {
                appliedCouponCode = 'FREESHIP';
                feedback.classList.add('text-olive-dark');
                feedback.innerHTML = '<i class="fa-solid fa-circle-check"></i> ใช้งานโค้ด FREESHIP สำเร็จ! ฟรีค่าจัดส่งทุกรายการ';
            } else if (cleanCode === 'WELCOME50') {
                appliedCouponCode = 'WELCOME50';
                feedback.classList.add('text-olive-dark');
                feedback.innerHTML = '<i class="fa-solid fa-circle-check"></i> ใช้งานโค้ด WELCOME50 สำเร็จ! รับส่วนลด ฿50.00';
            } else {
                appliedCouponCode = null;
                feedback.classList.add('text-red-500');
                feedback.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> โค้ดส่วนลดไม่ถูกต้อง หรือหมดอายุแล้ว';
            }

            calculateCart();
        }

        if (applyBtn) {
            applyBtn.addEventListener('click', function() {
                applyCoupon();
            });
        }
    });
</script>
@endsection
