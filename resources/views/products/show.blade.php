@extends('layouts.app')

@section('title', $product->name . ' - ShopDee')

@section('content')
<div class="space-y-8">
    <!-- Breadcrumb & Back -->
    <div class="flex items-center justify-between">
        <nav class="flex text-xs text-rust/60 gap-2 items-center">
            <a href="{{ route('products.index') }}" class="hover:text-terracotta transition">หน้าแรก</a>
            <span>/</span>
            <a href="{{ route('products.index', ['category' => $product->category_id]) }}#catalog" class="hover:text-terracotta transition">{{ $product->category->name }}</a>
            <span>/</span>
            <span class="text-terracotta font-semibold truncate max-w-xs">{{ $product->name }}</span>
        </nav>
        <a href="{{ route('products.index') }}#catalog" class="inline-flex items-center gap-1.5 text-xs text-rust/80 hover:text-terracotta font-medium transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>กลับไปหน้ารายการสินค้า</span>
        </a>
    </div>

    <!-- MAIN PRODUCT CARD -->
    <div class="bg-white rounded-2xl shadow-sm border border-terracotta/20 p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Image Section -->
            <div class="h-80 md:h-96 bg-limestone/40 rounded-2xl flex items-center justify-center overflow-hidden border border-terracotta/10 relative group">
                @if($product->image)
                    @if(str_starts_with($product->image, 'http'))
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @elseif(str_starts_with($product->image, 'images/'))
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @endif
                @else
                    @php
                        $catSlug = $product->category->slug ?? '';
                        $icon = match(true) {
                            str_contains($catSlug, 'clothing') => 'fa-shirt',
                            str_contains($catSlug, 'pants') => 'fa-vest',
                            str_contains($catSlug, 'shoes') => 'fa-shoe-prints',
                            str_contains($catSlug, 'bags') => 'fa-bag-shopping',
                            str_contains($catSlug, 'hats') => 'fa-hat-cowboy',
                            str_contains($catSlug, 'electronics') => 'fa-headphones',
                            default => 'fa-box-open',
                        };
                    @endphp
                    <div class="flex flex-col items-center justify-center space-y-3 text-terracotta/40">
                        <i class="fa-solid {{ $icon }} text-8xl"></i>
                        <span class="text-xs font-bold tracking-widest uppercase text-rust/50">{{ $product->category->name }}</span>
                    </div>
                @endif

                @auth
                    @if(!auth()->user()->isAdmin())
                        <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="absolute top-4 right-4 z-10">
                            @csrf
                            <button type="submit" class="w-10 h-10 rounded-full bg-white/90 hover:bg-white text-rust flex items-center justify-center shadow transition backdrop-blur-sm" title="บันทึกในรายการที่ชอบ">
                                <i class="fa-{{ auth()->user()->hasWishlisted($product->id) ? 'solid text-terracotta' : 'regular text-rust/60' }} fa-heart text-lg"></i>
                            </button>
                        </form>
                    @endif
                @endauth
            </div>

            <!-- Details Section -->
            <div class="flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="inline-block bg-terracotta/15 text-terracotta font-bold text-xs px-3 py-1 rounded-full uppercase tracking-wider">
                            {{ $product->category->name }}
                        </span>

                        <!-- Rating & Sales Badges Header -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <div class="flex text-amber-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($averageRating))
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm font-bold text-rust">{{ $reviewsCount > 0 ? number_format($averageRating, 1) : 'ยังไม่มีคะแนน' }}</span>
                            @if($reviewsCount > 0)
                                <a href="#reviews-section" class="text-xs text-rust/60 hover:text-terracotta underline">({{ $reviewsCount }} รีวิว)</a>
                            @endif
                            <span class="text-rust/30">|</span>
                            <span class="text-xs font-semibold text-terracotta bg-terracotta/10 px-2.5 py-0.5 rounded-full flex items-center gap-1">
                                <i class="fa-solid fa-fire text-terracotta text-[10px]"></i> ขายแล้ว {{ number_format($product->totalSold()) }} ชิ้น
                            </span>
                        </div>
                    </div>

                    <h1 class="text-3xl font-bold text-rust leading-tight">{{ $product->name }}</h1>

                    <div class="text-3xl font-extrabold text-terracotta">
                        ฿{{ number_format($product->price, 2) }}
                    </div>

                    <!-- Stock, Sales & Satisfaction Stats Card -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-limestone-light/70 p-3.5 rounded-xl border border-terracotta/15 text-xs">
                        <div>
                            <span class="text-rust/60 block text-[11px]">สถานะสต็อก</span>
                            @if($product->stock > 0)
                                <span class="text-olive-dark font-bold text-sm"><i class="fa-solid fa-circle-check text-olive mr-1"></i>พร้อมส่ง ({{ $product->stock }})</span>
                            @else
                                <span class="text-terracotta font-bold text-sm"><i class="fa-solid fa-circle-xmark mr-1"></i>สินค้าหมด</span>
                            @endif
                        </div>
                        <div>
                            <span class="text-rust/60 block text-[11px]">ยอดขายสินค้านี้</span>
                            <span class="text-rust font-bold text-sm flex items-center gap-1.5">
                                <i class="fa-solid fa-bag-shopping text-terracotta"></i>
                                <span>{{ number_format($product->totalSold()) }} ชิ้น</span>
                            </span>
                        </div>
                        <div class="col-span-2 sm:col-span-1 border-t sm:border-t-0 pt-2 sm:pt-0 border-terracotta/10">
                            <span class="text-rust/60 block text-[11px]">ความพึงพอใจ</span>
                            <span class="text-amber-500 font-bold text-sm flex items-center gap-1">
                                <i class="fa-solid fa-star text-amber-400"></i>
                                <span>{{ $reviewsCount > 0 ? number_format($averageRating, 1) : '5.0' }} / 5.0</span>
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-limestone pt-4">
                        <h3 class="text-sm font-bold text-rust mb-2">รายละเอียดสินค้า</h3>
                        <p class="text-rust/80 text-sm leading-relaxed whitespace-pre-line">
                            {{ $product->description ?? 'ไม่มีข้อมูลคำอธิบายเพิ่มเติม' }}
                        </p>
                    </div>
                </div>

                <!-- Action Section -->
                @auth
                    @if(!auth()->user()->isAdmin())
                        <div class="space-y-4 pt-4 border-t border-limestone">
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                                @csrf
                                <div class="flex items-center space-x-4">
                                    <label for="quantity" class="text-sm font-medium text-rust">จำนวน:</label>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                        class="w-24 px-3 py-2 border border-terracotta/30 rounded-xl text-center focus:ring-2 focus:ring-terracotta focus:outline-none text-sm bg-limestone-light/50">
                                </div>

                                <div class="flex items-center gap-3">
                                    <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}
                                        class="flex-grow bg-terracotta hover:bg-terracotta-dark disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-medium py-3 rounded-xl shadow transition flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-cart-plus text-lg"></i> เพิ่มลงตะกร้าสินค้า
                                    </button>
                                    
                                    <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-limestone hover:bg-limestone-light text-rust p-3 rounded-xl font-medium transition border border-terracotta/20 flex items-center justify-center" title="บันทึกในรายการที่ชอบ">
                                            <i class="fa-{{ auth()->user()->hasWishlisted($product->id) ? 'solid text-terracotta' : 'regular text-rust' }} fa-heart text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </form>
                        </div>
                    @endif
                @else
                    <div class="bg-limestone/50 p-4 rounded-2xl text-center border border-terracotta/20">
                        <p class="text-sm text-rust/80 mb-3">กรุณาเข้าสู่ระบบเพื่อดำเนินการสั่งซื้อสินค้า หรือ เพิ่มในรายการที่ชอบ</p>
                        <a href="{{ route('login') }}" class="inline-block bg-terracotta hover:bg-terracotta-dark text-white font-medium px-6 py-2.5 rounded-xl text-sm transition shadow">
                            เข้าสู่ระบบ
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- REVIEWS & RATINGS SECTION -->
    <div id="reviews-section" class="bg-white rounded-2xl shadow-sm border border-terracotta/20 p-6 md:p-8 space-y-8">
        
        <!-- Section Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-limestone pb-6">
            <div>
                <h2 class="text-2xl font-bold text-rust flex items-center gap-2.5">
                    <i class="fa-solid fa-star-half-stroke text-amber-500"></i>
                    <span>รีวิวและความคิดเห็นจากลูกค้า</span>
                </h2>
                <p class="text-xs sm:text-sm text-rust/70 mt-1">คะแนนและความคิดเห็นจริงจากผู้ซื้อสินค้าชิ้นนี้</p>
            </div>

            @auth
                @if(!auth()->user()->isAdmin())
                    <a href="#review-form-anchor" class="inline-flex items-center gap-2 bg-terracotta/10 hover:bg-terracotta text-terracotta hover:text-white px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition border border-terracotta/20">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>{{ $userReview ? 'แก้ไขรีวิวของคุณ' : 'เขียนรีวิวสินค้า' }}</span>
                    </a>
                @endif
            @endauth
        </div>

        <!-- Rating Summary Overview -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-center bg-limestone-light/50 p-6 rounded-2xl border border-terracotta/15">
            <!-- Overall Score Badge (4 cols) -->
            <div class="md:col-span-4 flex flex-col items-center justify-center text-center p-4 border-b md:border-b-0 md:border-r border-terracotta/15 space-y-2">
                <span class="text-5xl font-black text-rust tracking-tight">
                    {{ $reviewsCount > 0 ? number_format($averageRating, 1) : '0.0' }}
                </span>
                
                <div class="flex text-amber-400 text-lg space-x-1">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($averageRating))
                            <i class="fa-solid fa-star"></i>
                        @else
                            <i class="fa-regular fa-star text-gray-300"></i>
                        @endif
                    @endfor
                </div>

                <p class="text-xs font-medium text-rust/70">
                    @if($reviewsCount > 0)
                        จากทั้งหมด <span class="font-bold text-rust">{{ $reviewsCount }}</span> ความคิดเห็น
                    @else
                        ยังไม่มีผู้ให้คะแนน
                    @endif
                </p>
            </div>

            <!-- Star Breakdown Progress Bars (8 cols) -->
            <div class="md:col-span-8 space-y-2 px-2">
                @foreach($ratingBreakdown as $star => $data)
                    <div class="flex items-center gap-3 text-xs sm:text-sm">
                        <span class="w-12 font-semibold text-rust flex items-center gap-1 justify-end">
                            <span>{{ $star }}</span>
                            <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                        </span>

                        <div class="flex-grow bg-limestone h-3 rounded-full overflow-hidden">
                            <div class="bg-amber-400 h-full rounded-full transition-all duration-500" style="width: {{ $data['percentage'] }}%;"></div>
                        </div>

                        <span class="w-10 text-right text-rust/60 text-xs font-mono">
                            {{ $data['count'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- REVIEW FORM (Interactive Rating & Comments) -->
        <div id="review-form-anchor" class="pt-2">
            @auth
                @if(!auth()->user()->isAdmin())
                    <div class="bg-white rounded-2xl border-2 border-terracotta/30 p-6 space-y-5 shadow-sm">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-rust flex items-center gap-2">
                                <i class="fa-solid fa-feather-pointed text-terracotta"></i>
                                <span>{{ $userReview ? 'แก้ไขความคิดเห็นและคะแนนดาวของคุณ' : 'เขียนรีวิวและความคิดเห็น' }}</span>
                            </h3>
                            @if($userReview)
                                <span class="text-[11px] bg-olive/20 text-olive-dark font-medium px-2.5 py-1 rounded-full">
                                    <i class="fa-solid fa-circle-check"></i> คุณเคยรีวิวสินค้านี้แล้ว
                                </span>
                            @endif
                        </div>

                        <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-4" id="review-form">
                            @csrf
                            
                            <!-- Star Rating Input Picker -->
                            <div>
                                <label class="block text-xs font-bold text-rust mb-2 uppercase tracking-wider">
                                    ให้คะแนนดาวสำหรับสินค้านี้ <span class="text-terracotta">*</span>
                                </label>
                                
                                <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', $userReview->rating ?? 5) }}">
                                
                                <div class="flex items-center gap-4 flex-wrap">
                                    <div class="flex items-center gap-1 text-2xl text-gray-300 cursor-pointer select-none" id="star-rating-container">
                                        @for($star = 1; $star <= 5; $star++)
                                            <button type="button" class="star-btn transition transform hover:scale-125 focus:outline-none" data-value="{{ $star }}" title="{{ $star }} ดาว">
                                                <i class="fa-solid fa-star {{ $star <= old('rating', $userReview->rating ?? 5) ? 'text-amber-400' : 'text-gray-300' }}"></i>
                                            </button>
                                        @endfor
                                    </div>
                                    <span id="rating-description-label" class="text-xs font-bold text-terracotta bg-terracotta/10 px-3 py-1 rounded-full">
                                        5 ดาว - ยอดเยี่ยมมาก
                                    </span>
                                </div>
                                @error('rating')
                                    <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Comment Textarea -->
                            <div>
                                <label for="comment-text" class="block text-xs font-bold text-rust mb-2 uppercase tracking-wider">
                                    ความคิดเห็นและความรู้สึกที่มีต่อสินค้า
                                </label>
                                <textarea name="comment" id="comment-text" rows="4" maxlength="1000"
                                    placeholder="เล่าประสบการณ์การใช้งาน ความคุ้มค่า เนื้อผ้า หรือความประทับใจเกี่ยวกับสินค้านี้ เพื่อเป็นประโยชน์ต่อผู้ซื้อท่านอื่น..."
                                    class="w-full p-4 border border-terracotta/30 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta text-sm bg-limestone-light/40 text-rust placeholder-rust/40">{{ old('comment', $userReview->comment ?? '') }}</textarea>
                                @error('comment')
                                    <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center justify-end gap-3 pt-2">
                                <button type="submit" class="inline-flex items-center gap-2 bg-terracotta hover:bg-terracotta-dark text-white font-bold px-6 py-2.5 rounded-xl text-xs sm:text-sm shadow-md transition transform hover:-translate-y-0.5">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    <span>{{ $userReview ? 'อัปเดตรีวิวของคุณ' : 'ส่งรีวิวและความคิดเห็น' }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-limestone-light/50 p-4 rounded-xl border border-terracotta/20 text-xs text-rust/70 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-terracotta"></i>
                        <span>คุณกำลังเข้าสู่ระบบในฐานะ Admin (ผู้ดูแลระบบสามารถตรวจสอบและจัดการความคิดเห็นได้)</span>
                    </div>
                @endif
            @else
                <div class="bg-limestone-light/60 p-6 rounded-2xl text-center border border-terracotta/20 space-y-3">
                    <div class="w-12 h-12 rounded-full bg-terracotta/15 text-terracotta flex items-center justify-center mx-auto text-xl">
                        <i class="fa-solid fa-comment-dots"></i>
                    </div>
                    <h3 class="text-base font-bold text-rust">เข้าสู่ระบบเพื่อเขียนรีวิว</h3>
                    <p class="text-xs text-rust/70 max-w-md mx-auto">ร่วมเป็นส่วนหนึ่งในการแบ่งปันประสบการณ์การซื้อสินค้า เพื่อช่วยเหลือผู้ใช้อื่นในการตัดสินใจ</p>
                    <div class="pt-1">
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-terracotta hover:bg-terracotta-dark text-white px-5 py-2 rounded-xl text-xs font-medium transition shadow">
                            <i class="fa-solid fa-right-to-bracket"></i> เข้าสู่ระบบเพื่อรีวิว
                        </a>
                    </div>
                </div>
            @endauth
        </div>

        <!-- REVIEWS LIST -->
        <div class="space-y-4 pt-4 border-t border-limestone">
            <h3 class="text-lg font-bold text-rust flex items-center justify-between">
                <span>ความคิดเห็นทั้งหมด ({{ $reviewsCount }})</span>
            </h3>

            @if($product->reviews->count() > 0)
                <div class="space-y-4">
                    @foreach($product->reviews as $review)
                        <div class="bg-limestone-light/30 hover:bg-limestone-light/60 transition p-5 rounded-2xl border border-terracotta/15 space-y-3">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <!-- Avatar Initials -->
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-terracotta to-rust text-white font-bold text-sm flex items-center justify-center shadow-sm">
                                        {{ mb_substr($review->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-bold text-rust text-sm">{{ $review->user->name ?? 'ผู้ใช้งาน' }}</span>
                                            
                                            @if($review->user && $review->user->isAdmin())
                                                <span class="text-[10px] bg-terracotta text-white font-medium px-2 py-0.5 rounded-full">
                                                    แอดมิน
                                                </span>
                                            @else
                                                <span class="text-[10px] bg-olive/15 text-olive-dark font-medium px-2 py-0.5 rounded-full flex items-center gap-1">
                                                    <i class="fa-solid fa-shield-check text-[9px]"></i> ผู้ซื้อที่ยืนยันแล้ว
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-rust/50 mt-0.5">
                                            {{ $review->created_at ? $review->created_at->diffForHumans() : 'เมื่อสักครู่' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <!-- Stars for this review -->
                                    <div class="flex text-amber-400 text-xs">
                                        @for($s = 1; $s <= 5; $s++)
                                            @if($s <= $review->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star text-gray-300"></i>
                                            @endif
                                        @endfor
                                    </div>

                                    <!-- Delete Button (if author or admin) -->
                                    @auth
                                        @if(auth()->id() === $review->user_id || auth()->user()->isAdmin())
                                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('คุณต้องการลบรีวิวนี้ใช่หรือไม่?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rust/40 hover:text-red-500 text-xs p-1 transition" title="ลบรีวิว">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>

                            <!-- Comment body -->
                            @if($review->comment)
                                <p class="text-rust/85 text-xs sm:text-sm leading-relaxed whitespace-pre-line pl-1 sm:pl-13">
                                    {{ $review->comment }}
                                </p>
                            @else
                                <p class="text-rust/40 text-xs italic pl-1 sm:pl-13">
                                    (ไม่ได้ระบุข้อความความคิดเห็น ให้คะแนน {{ $review->rating }} ดาว)
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-limestone-light/30 p-8 text-center rounded-2xl border border-dashed border-terracotta/20 space-y-2">
                    <i class="fa-regular fa-comments text-4xl text-terracotta/40 mb-1"></i>
                    <h4 class="text-sm font-bold text-rust">ยังไม่มีรีวิวสำหรับสินค้านี้</h4>
                    <p class="text-xs text-rust/60">ร่วมเป็นคนแรกที่แบ่งปันความคิดเห็นและความรู้สึกเกี่ยวกับสินค้าชิ้นนี้!</p>
                </div>
            @endif
        </div>

    </div>
</div>

<!-- Interactive Rating Picker Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const starBtns = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('rating-input');
        const labelText = document.getElementById('rating-description-label');

        const ratingLabels = {
            1: '1 ดาว - ต้องปรับปรุง',
            2: '2 ดาว - พอใช้',
            3: '3 ดาว - ปานกลาง',
            4: '4 ดาว - ดีมาก',
            5: '5 ดาว - ยอดเยี่ยมมาก'
        };

        function updateStars(val) {
            starBtns.forEach(btn => {
                const btnVal = parseInt(btn.getAttribute('data-value'), 10);
                const starIcon = btn.querySelector('i');
                if (btnVal <= val) {
                    starIcon.className = 'fa-solid fa-star text-amber-400';
                } else {
                    starIcon.className = 'fa-solid fa-star text-gray-300';
                }
            });
            if (labelText && ratingLabels[val]) {
                labelText.innerText = ratingLabels[val];
            }
        }

        if (starBtns.length && ratingInput) {
            let currentVal = parseInt(ratingInput.value, 10) || 5;
            updateStars(currentVal);

            starBtns.forEach(btn => {
                // Click to select
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentVal = parseInt(this.getAttribute('data-value'), 10);
                    ratingInput.value = currentVal;
                    updateStars(currentVal);
                });

                // Hover Preview
                btn.addEventListener('mouseenter', function() {
                    const hoverVal = parseInt(this.getAttribute('data-value'), 10);
                    updateStars(hoverVal);
                });
            });

            const starContainer = document.getElementById('star-rating-container');
            if (starContainer) {
                starContainer.addEventListener('mouseleave', function() {
                    updateStars(currentVal);
                });
            }
        }
    });
</script>
@endsection
