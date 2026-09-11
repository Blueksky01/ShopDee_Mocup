@extends('layouts.app')

@section('title', 'JACKET MASTERS - Puffer Jacket Collection')

@section('content')
<style>
  /* Dynamic Expansion Animation: From exact Thumbnail Preview card position to Main Center Spotlight */
  @keyframes expandFromThumbnail {
    0% {
      opacity: 0.25;
      transform: translate(var(--startX, 240px), var(--startY, 140px)) scale(var(--startScale, 0.22));
    }
    100% {
      opacity: 1;
      transform: translate(0, 0) scale(1);
    }
  }

  @keyframes exitSlideLeft {
    0% {
      opacity: 1;
      transform: translate(0, 0) scale(1);
    }
    100% {
      opacity: 0;
      transform: translate(-180px, -30px) scale(0.7);
    }
  }

  @keyframes riseUpShadow {
    0% {
      opacity: 0;
      transform: scale(0.2);
    }
    100% {
      opacity: 0.5;
      transform: scale(1);
    }
  }

  .animate-expand-from-thumb {
    animation: expandFromThumbnail 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }

  .animate-exit-left {
    animation: exitSlideLeft 0.35s cubic-bezier(0.4, 0, 0.2, 1) forwards;
  }

  .animate-shadow-scale {
    animation: riseUpShadow 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }

  /* Seamless Blend Mode to make white box transparent */
  .blend-multiply {
    mix-blend-mode: multiply;
  }
</style>

<div class="space-y-10">

    <!-- HERO SECTION -->
    <div id="hero-container"
        class="relative w-full rounded-[32px] overflow-hidden text-white p-6 sm:p-8 lg:p-10 shadow-2xl border border-white/20">

        <!-- Smooth Background Gradient Layers for Cross-Fade -->
        <div id="hero-bg-base" class="absolute inset-0 bg-gradient-to-br from-[#b85419] via-[#a24410] to-[#782e07] pointer-events-none z-0"></div>
        <div id="hero-bg-fade" class="absolute inset-0 bg-gradient-to-br from-[#b85419] via-[#a24410] to-[#782e07] opacity-0 transition-opacity duration-[1200ms] ease-out pointer-events-none z-0"></div>

        <!-- Ambient Studio Center Glow -->
        <div id="hero-glow" class="absolute inset-0 bg-[radial-gradient(circle_at_50%_40%,rgba(255,200,150,0.25),transparent_65%)] pointer-events-none transition-all duration-700 z-0"></div>

        <!-- Top Header Navigation inside Hero -->
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
            <!-- Brand Logo Left -->
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white text-[#a24410] font-bold text-xs flex items-center justify-center rounded-md shadow-md">
                    JM
                </div>
                <span class="font-bold tracking-widest text-sm uppercase text-white font-serif">JACKET MASTERS</span>
            </div>

            <!-- Floating Pill Navigation Center -->
            <div class="bg-black/30 backdrop-blur-md border border-white/10 rounded-full px-2 py-1.5 flex items-center gap-1 sm:gap-2 shadow-lg">
                <button type="button" id="hero-pill-badge" class="bg-white text-gray-900 font-bold px-4 py-1.5 rounded-full text-xs shadow transition-all duration-500">
                    PUFFER JACKET
                </button>
                <a href="#catalog" class="text-white/80 hover:text-white text-xs font-medium px-3 py-1.5 transition">
                    ALL PRODUCTS
                </a>
                <a href="#about" class="text-white/80 hover:text-white text-xs font-medium px-3 py-1.5 transition">
                    ABOUT US
                </a>
                <a href="#contact" class="text-white/80 hover:text-white text-xs font-medium px-3 py-1.5 transition">
                    CONTACT
                </a>
            </div>

            <!-- Cart & Wishlist Right -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('cart.index') }}" class="w-9 h-9 bg-black/20 hover:bg-black/40 rounded-full flex items-center justify-center text-white transition border border-white/10 relative">
                    <i class="fa-solid fa-bag-shopping text-sm"></i>
                    @php
                        $heroCartCount = auth()->check() && auth()->user()->cart ? auth()->user()->cart->items->sum('quantity') : 0;
                    @endphp
                    @if($heroCartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-white text-[#a24410] font-bold text-[10px] w-4 h-4 rounded-full flex items-center justify-center shadow">
                            {{ $heroCartCount }}
                        </span>
                    @endif
                </a>
                <button type="button" class="w-9 h-9 bg-black/20 hover:bg-black/40 rounded-full flex items-center justify-center text-white transition border border-white/10">
                    <i class="fa-regular fa-heart text-sm"></i>
                </button>
            </div>
        </div>

        <!-- Hero Content Grid -->
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center py-4">

            <!-- LEFT COLUMN: Headline & Story -->
            <div class="lg:col-span-4 space-y-6">


                <!-- Headline -->
                <div class="space-y-2">
                    <h1 id="hero-title" class="text-4xl sm:text-5xl font-bold tracking-tight text-white leading-tight font-serif">
                        Stand out<br>Without trying
                    </h1>
                </div>

                <!-- Paragraph Description -->
                <p id="hero-desc" class="text-white/85 text-xs sm:text-sm leading-relaxed max-w-sm font-light">
                    It's not just about staying warm. It's about stepping outside and instantly feeling confident, comfortable, and completely yourself. Designed to elevate even the simplest outfit, this jacket wraps you in lightweight warmth.
                </p>

                <!-- CTA Button -->
                <div>
                    <a href="#catalog" class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-gray-900 font-bold px-6 py-2.5 rounded-full text-xs shadow-xl transition transform hover:-translate-y-0.5">
                        <span>Get the look</span>
                        <i class="fa-solid fa-chevron-right text-xs"></i>
                    </a>
                </div>

                <!-- Social Icons Bottom Left -->
                <div class="flex items-center space-x-4 pt-4 text-white/60 text-xs">
                    <a href="#" class="hover:text-white transition"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fa-brands fa-pinterest-p"></i></a>
                    <a href="#" class="hover:text-white transition"><i class="fa-brands fa-behance"></i></a>
                </div>
            </div>

            <!-- CENTER COLUMN: 3D Isolated Floating Product Showcase (3D Spin & Vertical Motion) -->
            <div class="lg:col-span-5 flex flex-col items-center justify-center relative [perspective:1000px]">
                <div class="relative group flex flex-col items-center py-4">
                    <!-- Main Spotlight Jacket with Expansion Motion from Bottom-Right Thumbnail -->
                    <img id="main-hero-img" src="{{ asset('images/orange_isolated.png') }}" alt="Puffer Jacket Showcase"
                        class="w-72 sm:w-80 lg:w-[360px] object-contain animate-expand-from-thumb transition-transform duration-500 hover:scale-105">

                    <!-- Dynamic Floor Shadow Element -->
                    <div id="hero-shadow" class="w-64 h-6 bg-black/60 blur-md rounded-full -mt-4 animate-shadow-scale"></div>
                </div>

                <!-- Bottom Center Caption -->
                <p id="hero-caption" class="text-white/90 text-xs sm:text-sm font-light italic mt-6 tracking-wide text-center">
                    Confidence, wrapped in warmth
                </p>
            </div>

            <!-- RIGHT COLUMN: Pricing, Sizes & Thumbnail Preview -->
            <div class="lg:col-span-3 flex flex-col justify-between items-start lg:items-end space-y-8">

                <!-- Price Display -->
                <div class="text-left lg:text-right space-y-0.5">
                    <div id="hero-price" class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight">$149</div>
                    <div id="hero-old-price" class="text-lg text-white/50 line-through font-medium">$199</div>
                </div>

                <!-- Size Selector -->
                <div class="space-y-2 text-left lg:text-right w-full">
                    <span class="text-xs text-white/80 font-medium block">Choose your size:</span>
                    <div class="flex items-center justify-start lg:justify-end space-x-2">
                        <button type="button" class="size-btn w-10 h-10 rounded-full bg-white text-gray-900 font-bold flex items-center justify-center text-xs shadow transition">36</button>
                        <button type="button" class="size-btn w-10 h-10 rounded-full bg-black/40 text-white font-medium border border-white/10 hover:bg-black/60 flex items-center justify-center text-xs transition">38</button>
                        <button type="button" class="size-btn w-10 h-10 rounded-full bg-black/40 text-white font-medium border border-white/10 hover:bg-black/60 flex items-center justify-center text-xs transition">40</button>
                    </div>
                </div>

                <!-- Color Swatches & Alternative Color Thumbnail Preview -->
                <div class="pt-4 text-left lg:text-right space-y-3">
                    <!-- Swatches list -->
                    <div class="flex items-center justify-start lg:justify-end space-x-2.5">
                        <button type="button" class="swatch-btn w-7 h-7 rounded-full bg-[#c85513] ring-4 ring-white shadow-lg scale-110 transition focus:outline-none"
                            data-variant="orange" title="Terracotta Orange"></button>
                        <button type="button" class="swatch-btn w-7 h-7 rounded-full bg-[#1a202c] ring-2 ring-white/30 shadow transition hover:scale-110 focus:outline-none"
                            data-variant="black" title="Noir Glossy Black"></button>
                        <button type="button" class="swatch-btn w-7 h-7 rounded-full bg-[#9b1c1c] ring-2 ring-white/30 shadow transition hover:scale-110 focus:outline-none"
                            data-variant="red" title="Crimson Ruby Red"></button>
                    </div>

                    <!-- Interactive Thumbnail Card in Bottom Right Corner (Source of Entrance Animation) -->
                    <div id="toggle-color-card" class="group relative w-20 h-20 bg-black/30 border border-white/20 rounded-2xl overflow-hidden shadow-xl hover:scale-105 transition cursor-pointer p-1">
                        <img id="thumb-hero-img" src="{{ asset('images/black_isolated.png') }}" alt="Black Puffer Jacket" class="w-full h-full object-contain rounded-xl">
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition"></div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- END HERO SECTION -->

    <!-- CATALOG SECTION -->
    <div id="catalog" class="space-y-6 pt-4">
        <!-- Search & Filter Banner (Terracotta & Soft Limestone Theme) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-terracotta/20">
            <form method="GET" action="{{ route('products.index') }}#catalog" id="filter-form" class="flex flex-col md:flex-row gap-4 justify-between items-center">

                <!-- Search Box -->
                <div class="w-full md:w-1/2 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาสินค้าตามชื่อ หรือ คำอธิบาย..."
                        class="w-full pl-10 pr-4 py-2.5 border border-terracotta/30 rounded-2xl focus:outline-none focus:ring-2 focus:ring-terracotta text-sm bg-limestone-light/50">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3.5 text-terracotta/60 text-sm"></i>
                </div>

                <div class="w-full md:w-auto flex items-center gap-3">

                    <!-- CUSTOM ROUNDED DROPDOWN COMPONENT (High Rounded Corners rounded-2xl) -->
                    <div class="relative inline-block text-left" id="custom-category-dropdown">
                        <input type="hidden" name="category" id="selected-category-input" value="{{ request('category') }}">

                        <button type="button" id="dropdown-toggle-btn"
                            class="py-2.5 px-4 border border-terracotta/30 rounded-2xl focus:outline-none focus:ring-2 focus:ring-terracotta text-sm bg-limestone-light/80 hover:bg-limestone text-rust font-medium flex items-center justify-between gap-3 shadow-sm transition min-w-[200px]">
                            <span id="dropdown-label-text" class="truncate">
                                @if(request('category'))
                                    {{ $categories->firstWhere('id', request('category'))?->name ?? '-- ทุกหมวดหมู่ --' }}
                                @else
                                    -- ทุกหมวดหมู่ --
                                @endif
                            </span>
                            <i class="fa-solid fa-chevron-down text-xs text-terracotta transition-transform duration-200" id="dropdown-arrow"></i>
                        </button>

                        <!-- Custom Dropdown Menu List with High Rounded Corners (rounded-2xl) -->
                        <div id="dropdown-menu-list"
                            class="hidden absolute right-0 mt-2 w-64 bg-white border border-terracotta/20 rounded-2xl shadow-xl overflow-hidden z-50 p-2 space-y-1 transform transition-all duration-200">

                            <div class="dropdown-item px-3.5 py-2.5 text-sm rounded-xl font-medium cursor-pointer transition flex items-center justify-between {{ !request('category') ? 'bg-terracotta text-white font-bold shadow-sm' : 'text-rust hover:bg-terracotta/15 hover:text-terracotta' }}"
                                data-value="">
                                <span>-- ทุกหมวดหมู่ --</span>
                                @if(!request('category'))
                                    <i class="fa-solid fa-circle-check text-xs"></i>
                                @endif
                            </div>

                            @foreach($categories as $category)
                                <div class="dropdown-item px-3.5 py-2.5 text-sm rounded-xl font-medium cursor-pointer transition flex items-center justify-between {{ request('category') == $category->id ? 'bg-terracotta text-white font-bold shadow-sm' : 'text-rust hover:bg-terracotta/15 hover:text-terracotta' }}"
                                    data-value="{{ $category->id }}">
                                    <span>{{ $category->name }}</span>
                                    @if(request('category') == $category->id)
                                        <i class="fa-solid fa-circle-check text-xs"></i>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Search Button -->
                    <button type="submit" class="bg-terracotta hover:bg-terracotta-dark text-white px-6 py-2.5 rounded-2xl text-sm font-medium transition shadow">
                        ค้นหา
                    </button>

                    @if(request()->hasAny(['search', 'category']))
                        <a href="{{ route('products.index') }}#catalog" class="text-rust/70 hover:text-rust text-sm underline px-2">
                            ล้างตัวกรอง
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Product Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition border border-terracotta/15 flex flex-col overflow-hidden">
                        <div class="h-56 bg-limestone/40 flex items-center justify-center relative overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-box-open text-5xl text-terracotta/30"></i>
                            @endif

                            <span class="absolute top-3 right-3 text-xs font-semibold px-3 py-1 rounded-full {{ $product->stock > 0 ? 'bg-olive/20 text-olive-dark border border-olive/30' : 'bg-terracotta/20 text-terracotta-dark border border-terracotta/30' }}">
                                {{ $product->stock > 0 ? 'มีสต็อก (' . $product->stock . ')' : 'สินค้าหมด' }}
                            </span>
                        </div>

                        <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                            <div>
                                <span class="text-xs font-bold text-terracotta uppercase tracking-wider">
                                    {{ $product->category->name }}
                                </span>
                                <h3 class="text-lg font-bold text-rust mt-1 line-clamp-1">
                                    <a href="{{ route('products.show', $product->slug) }}" class="hover:text-terracotta transition">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="text-rust/60 text-xs mt-2 line-clamp-2">
                                    {{ $product->description ?? 'ไม่มีคำอธิบายสินค้า' }}
                                </p>
                            </div>

                            <div class="pt-3 border-t border-limestone flex items-center justify-between">
                                <span class="text-xl font-extrabold text-terracotta">
                                    ฿{{ number_format($product->price, 2) }}
                                </span>

                                @auth
                                    @if(!auth()->user()->isAdmin())
                                        <form action="{{ route('cart.add', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}
                                                class="bg-terracotta hover:bg-terracotta-dark disabled:bg-gray-300 disabled:cursor-not-allowed text-white text-xs px-4 py-2 rounded-xl font-medium transition shadow flex items-center gap-1.5">
                                                <i class="fa-solid fa-cart-plus"></i> เพิ่มลงตะกร้า
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="bg-limestone hover:bg-limestone/80 text-rust text-xs px-3.5 py-2 rounded-xl font-medium transition">
                                        เข้าสู่ระบบเพื่อซื้อ
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <div class="bg-white p-12 text-center rounded-2xl shadow-sm border border-terracotta/20">
                <i class="fa-solid fa-store-slash text-5xl text-terracotta/30 mb-4"></i>
                <h3 class="text-lg font-bold text-rust">ไม่พบบริการหรือสินค้าที่คุณค้นหา</h3>
                <p class="text-rust/60 text-sm mt-1">ลองเปลี่ยนคำค้นหา หรือเลือกหมวดใหม่อีกครั้ง</p>
            </div>
        @endif
    </div>
</div>

<!-- Dynamic Script for Thumbnail-to-Center Morphing Motion & Custom Rounded Dropdown -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // COLOR VARIANT SWITCHER DATA & THEME SYNC
        const heroContainer = document.getElementById('hero-container');
        const heroBgBase = document.getElementById('hero-bg-base');
        const heroBgFade = document.getElementById('hero-bg-fade');
        const mainImg = document.getElementById('main-hero-img');
        const thumbImg = document.getElementById('thumb-hero-img');
        const heroShadow = document.getElementById('hero-shadow');
        const heroTitle = document.getElementById('hero-title');
        const heroDesc = document.getElementById('hero-desc');
        const heroCaption = document.getElementById('hero-caption');
        const heroPrice = document.getElementById('hero-price');
        const heroOldPrice = document.getElementById('hero-old-price');
        const swatches = document.querySelectorAll('.swatch-btn');
        const toggleCard = document.getElementById('toggle-color-card');

        const variants = {
            orange: {
                bgClasses: 'from-[#b85419] via-[#a24410] to-[#782e07]',
                imgSrc: "{{ asset('images/orange_isolated.png') }}",
                thumbSrc: "{{ asset('images/black_isolated.png') }}",
                title: 'Stand out<br>Without trying',
                desc: "It's not just about staying warm. It's about stepping outside and instantly feeling confident, comfortable, and completely yourself. Designed to elevate even the simplest outfit, this jacket wraps you in lightweight warmth.",
                caption: 'Confidence, wrapped in warmth',
                price: '$149',
                oldPrice: '$199'
            },
            black: {
                bgClasses: 'from-[#2d3748] via-[#1a202c] to-[#0d1117]',
                imgSrc: "{{ asset('images/black_isolated.png') }}",
                thumbSrc: "{{ asset('images/red_isolated.png') }}",
                title: 'Noir Elegance<br>In Every Stitch',
                desc: 'Unmatched style, wrapped in shadow. Crafted with ultra-lightweight water-resistant fabric to deliver pure comfort and modern aesthetic.',
                caption: 'Unmatched style, wrapped in shadow',
                price: '$169',
                oldPrice: '$219'
            },
            red: {
                bgClasses: 'from-[#9b1c1c] via-[#771d1d] to-[#450a0a]',
                imgSrc: "{{ asset('images/red_isolated.png') }}",
                thumbSrc: "{{ asset('images/orange_isolated.png') }}",
                title: 'Crimson Passion<br>Unapologetic Bold',
                desc: 'Make a statement wherever you go. Bold ruby shine paired with cloud-like warmth designed for unforgettable impressions.',
                caption: 'Make a statement, ignite the night',
                price: '$179',
                oldPrice: '$249'
            }
        };

        const variantKeys = ['orange', 'black', 'red'];
        let currentVariantIndex = 0;
        let isAnimating = false;

        function applyVariant(key) {
            if (isAnimating) return;
            const data = variants[key];
            if (!data) return;

            isAnimating = true;

            // 1. Swatch Highlight States
            swatches.forEach(btn => {
                const btnKey = btn.getAttribute('data-variant');
                if (btnKey === key) {
                    btn.className = 'swatch-btn w-7 h-7 rounded-full ' + (key === 'orange' ? 'bg-[#c85513]' : (key === 'black' ? 'bg-[#1a202c]' : 'bg-[#9b1c1c]')) + ' ring-4 ring-white shadow-lg scale-110 transition focus:outline-none';
                } else {
                    btn.className = 'swatch-btn w-7 h-7 rounded-full ' + (btnKey === 'orange' ? 'bg-[#c85513]' : (btnKey === 'black' ? 'bg-[#1a202c]' : 'bg-[#9b1c1c]')) + ' ring-2 ring-white/30 shadow transition hover:scale-110 focus:outline-none';
                }
            });

            // 2. Smoothly Cross-fade Background Gradient over 1.2 seconds
            if (heroBgFade && heroBgBase) {
                heroBgFade.className = 'absolute inset-0 bg-gradient-to-br ' + data.bgClasses + ' opacity-0 transition-opacity duration-[1200ms] ease-out pointer-events-none z-0';
                void heroBgFade.offsetWidth;
                heroBgFade.classList.remove('opacity-0');
                heroBgFade.classList.add('opacity-100');
            }

            // Calculate dynamic start offsets relative to exact thumbnail card coordinates
            if (thumbImg && mainImg) {
                const mainRect = mainImg.getBoundingClientRect();
                const thumbRect = thumbImg.getBoundingClientRect();

                const startX = (thumbRect.left + thumbRect.width / 2) - (mainRect.left + mainRect.width / 2);
                const startY = (thumbRect.top + thumbRect.height / 2) - (mainRect.top + mainRect.height / 2);
                const startScale = mainRect.width > 0 ? (thumbRect.width / mainRect.width) : 0.22;

                mainImg.style.setProperty('--startX', `${startX}px`);
                mainImg.style.setProperty('--startY', `${startY}px`);
                mainImg.style.setProperty('--startScale', startScale);
            }

            // 3. STEP A: Exit current main jacket (slide out left)
            mainImg.classList.remove('animate-expand-from-thumb');
            heroShadow.classList.remove('animate-shadow-scale');
            mainImg.classList.add('animate-exit-left');

            setTimeout(() => {
                // STEP B: Update Image Source and Text Contents
                mainImg.src = data.imgSrc;
                if (thumbImg) thumbImg.src = data.thumbSrc;
                heroTitle.innerHTML = data.title;
                heroDesc.innerText = data.desc;
                heroCaption.innerText = data.caption;
                heroPrice.innerText = data.price;
                heroOldPrice.innerText = data.oldPrice;

                // Force DOM Reflow to re-trigger Keyframe animation
                void mainImg.offsetWidth;
                void heroShadow.offsetWidth;

                // STEP C: Expand new jacket from bottom-right thumbnail position into main center spotlight
                mainImg.classList.remove('animate-exit-left');
                mainImg.classList.add('animate-expand-from-thumb');
                heroShadow.classList.add('animate-shadow-scale');

                currentVariantIndex = variantKeys.indexOf(key);

                setTimeout(() => {
                    isAnimating = false;
                    if (heroBgBase && heroBgFade) {
                        heroBgBase.className = 'absolute inset-0 bg-gradient-to-br ' + data.bgClasses + ' pointer-events-none z-0';
                        heroBgFade.classList.remove('transition-opacity', 'duration-[1200ms]');
                        heroBgFade.classList.remove('opacity-100');
                        heroBgFade.classList.add('opacity-0');
                        void heroBgFade.offsetWidth;
                        heroBgFade.classList.add('transition-opacity', 'duration-[1200ms]');
                    }
                }, 1200);
            }, 250);
        }

        // AUTO-SLIDE TIMER (Cycles jacket color automatically every 4.5s)
        let autoSlideTimer = null;

        function startAutoSlide() {
            stopAutoSlide();
            autoSlideTimer = setInterval(() => {
                const nextIndex = (currentVariantIndex + 1) % variantKeys.length;
                applyVariant(variantKeys[nextIndex]);
            }, 3500);
        }

        function stopAutoSlide() {
            if (autoSlideTimer) {
                clearInterval(autoSlideTimer);
                autoSlideTimer = null;
            }
        }

        function resetAutoSlide() {
            stopAutoSlide();
            startAutoSlide();
        }

        // Click Listeners for Swatches
        swatches.forEach(btn => {
            btn.addEventListener('click', function() {
                applyVariant(this.getAttribute('data-variant'));
                resetAutoSlide();
            });
        });

        // Click Listener for Bottom Right Thumbnail Card
        if (toggleCard) {
            toggleCard.addEventListener('click', function() {
                const nextIndex = (currentVariantIndex + 1) % variantKeys.length;
                applyVariant(variantKeys[nextIndex]);
                resetAutoSlide();
            });
        }

        // Pause auto-slide on hover over Hero Container for smooth user experience
        if (heroContainer) {
            heroContainer.addEventListener('mouseenter', stopAutoSlide);
            heroContainer.addEventListener('mouseleave', startAutoSlide);
        }

        // Start Auto Slide on page load
        startAutoSlide();

        // Size selector interaction
        const sizeBtns = document.querySelectorAll('.size-btn');
        sizeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                sizeBtns.forEach(b => {
                    b.className = 'size-btn w-10 h-10 rounded-full bg-black/40 text-white font-medium border border-white/10 hover:bg-black/60 flex items-center justify-center text-xs transition';
                });
                this.className = 'size-btn w-10 h-10 rounded-full bg-white text-gray-900 font-bold flex items-center justify-center text-xs shadow transition';
            });
        });

        // CUSTOM ROUNDED DROPDOWN SCRIPT
        const dropdownBtn = document.getElementById('dropdown-toggle-btn');
        const dropdownMenu = document.getElementById('dropdown-menu-list');
        const dropdownArrow = document.getElementById('dropdown-arrow');
        const hiddenInput = document.getElementById('selected-category-input');

        if (dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
                dropdownArrow.classList.toggle('rotate-180');
            });

            document.querySelectorAll('.dropdown-item').forEach(item => {
                item.addEventListener('click', function() {
                    const val = this.getAttribute('data-value');
                    hiddenInput.value = val;
                    document.getElementById('filter-form').submit();
                });
            });

            document.addEventListener('click', function(e) {
                const container = document.getElementById('custom-category-dropdown');
                if (container && !container.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                    dropdownArrow.classList.remove('rotate-180');
                }
            });
        }
    });
</script>
@endsection
