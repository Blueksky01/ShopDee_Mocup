@extends('layouts.app')

@section('title', 'ShopDee - Dynamic Color Variant Switcher Collection')

@section('content')
<div class="space-y-10">

    <!-- HERO SECTION (Color Variant Switcher / Color-Adaptive Background) -->
    <div id="hero-container" 
        class="relative w-full rounded-[32px] overflow-hidden bg-gradient-to-br from-[#c85513] via-[#b3470d] to-[#6d2806] text-limestone-light p-6 sm:p-8 lg:p-10 shadow-2xl border border-white/20 transition-all duration-700 ease-in-out">
        
        <!-- Ambient Background Glow -->
        <div id="hero-glow" class="absolute inset-0 bg-[radial-gradient(circle_at_50%_30%,rgba(255,255,255,0.2),transparent_65%)] pointer-events-none transition-all duration-700"></div>

        <!-- Top Header Navigation inside Hero -->
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
            <!-- Brand Logo Left -->
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white text-gray-900 font-bold text-xs flex items-center justify-center rounded-md shadow-md">
                    SD
                </div>
                <span class="font-bold tracking-widest text-sm uppercase text-white">ShopDee Adaptive</span>
            </div>

            <!-- Floating Pill Navigation Center -->
            <div class="bg-black/35 backdrop-blur-md border border-white/20 rounded-full px-2 py-1.5 flex items-center gap-1 sm:gap-2 shadow-lg">
                <button type="button" id="hero-pill-badge" class="bg-white text-gray-900 font-bold px-4 py-1.5 rounded-full text-xs shadow transition-all duration-500">
                    COLOR VARIANT COLLECTION
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
                <a href="{{ route('cart.index') }}" class="w-9 h-9 bg-black/20 hover:bg-black/40 rounded-full flex items-center justify-center text-white transition border border-white/20 relative">
                    <i class="fa-solid fa-bag-shopping text-sm"></i>
                    @php
                        $heroCartCount = auth()->check() && auth()->user()->cart ? auth()->user()->cart->items->sum('quantity') : 0;
                    @endphp
                    @if($heroCartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-white text-gray-900 font-bold text-[10px] w-4 h-4 rounded-full flex items-center justify-center shadow">
                            {{ $heroCartCount }}
                        </span>
                    @endif
                </a>
                <button type="button" class="w-9 h-9 bg-black/20 hover:bg-black/40 rounded-full flex items-center justify-center text-white transition border border-white/20">
                    <i class="fa-regular fa-heart text-sm"></i>
                </button>
            </div>
        </div>

        <!-- Hero Content Grid -->
        <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center py-4">
            
            <!-- LEFT COLUMN: Headline & Story -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Carousel Arrows -->
                <div class="flex items-center space-x-2">
                    <button type="button" id="prev-slide" class="w-8 h-8 rounded-full border border-white/20 bg-white/10 hover:bg-white/20 backdrop-blur flex items-center justify-center text-white text-xs transition">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button type="button" id="next-slide" class="w-8 h-8 rounded-full border border-white/20 bg-white/10 hover:bg-white/20 backdrop-blur flex items-center justify-center text-white text-xs transition">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>

                <!-- Headline -->
                <div class="space-y-2">
                    <h1 id="hero-title" class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white leading-tight font-serif transition-all duration-500">
                        Warm Earth<br>Elevated Style
                    </h1>
                </div>

                <!-- Paragraph Description -->
                <p id="hero-desc" class="text-white/85 text-xs sm:text-sm leading-relaxed max-w-sm transition-all duration-500">
                    สัมผัสประสบการณ์ Color Variant Switcher ที่ปรับเปลี่ยนโทนสีและบรรยากาศของหน้าเว็บให้สอดคล้องกับสีเสื้อแจ็กเก็ตพรีเมียมอย่างสมบูรณ์แบบ
                </p>

                <!-- CTA Button -->
                <div>
                    <a href="#catalog" class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-gray-900 font-bold px-6 py-3 rounded-full text-xs sm:text-sm shadow-xl transition transform hover:-translate-y-0.5">
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

            <!-- CENTER COLUMN: 3D Product Spotlight -->
            <div class="lg:col-span-5 flex flex-col items-center justify-center relative">
                <div class="relative group">
                    <img id="main-hero-img" src="{{ asset('images/orange_puffer_hero.jpg') }}" alt="Puffer Jacket Showcase" 
                        class="w-72 sm:w-80 lg:w-96 rounded-3xl object-contain drop-shadow-[0_30px_35px_rgba(0,0,0,0.5)] transform hover:scale-105 transition-all duration-500">
                </div>

                <!-- Bottom Center Caption -->
                <p id="hero-caption" class="text-white/80 text-xs sm:text-sm font-light italic mt-6 tracking-wide text-center transition-all duration-500">
                    Confidence, wrapped in warmth
                </p>
            </div>

            <!-- RIGHT COLUMN: Pricing, Color Swatches & Sizes -->
            <div class="lg:col-span-3 flex flex-col justify-between items-start lg:items-end space-y-8">
                
                <!-- Price Display -->
                <div class="text-left lg:text-right space-y-1">
                    <div id="hero-old-price" class="text-lg text-white/50 line-through font-medium">฿6,500 ($199)</div>
                    <div id="hero-price" class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight">฿4,990 ($149)</div>
                </div>

                <!-- DYNAMIC COLOR VARIANT SWATCHES (COLOR-ADAPTIVE BACKGROUND SWITCHER) -->
                <div class="space-y-3 text-left lg:text-right w-full bg-black/20 backdrop-blur-md p-4 rounded-2xl border border-white/10 shadow-lg">
                    <div class="flex items-center justify-between lg:justify-end gap-2">
                        <span class="text-xs text-white/90 font-bold uppercase tracking-wider">Color Variant:</span>
                        <span id="color-name-label" class="text-xs font-semibold text-amber-300">Terracotta Orange</span>
                    </div>

                    <!-- Swatches list -->
                    <div class="flex items-center justify-start lg:justify-end space-x-3 pt-1">
                        <!-- Orange Swatch -->
                        <button type="button" class="swatch-btn w-9 h-9 rounded-full bg-[#c85513] ring-4 ring-white shadow-xl scale-110 transform transition-all duration-300 hover:scale-115 focus:outline-none"
                            data-variant="orange" title="Terracotta Orange"></button>

                        <!-- Black Swatch -->
                        <button type="button" class="swatch-btn w-9 h-9 rounded-full bg-[#1a202c] ring-2 ring-white/30 shadow-md transform transition-all duration-300 hover:scale-115 focus:outline-none"
                            data-variant="black" title="Noir Glossy Black"></button>

                        <!-- Red Swatch -->
                        <button type="button" class="swatch-btn w-9 h-9 rounded-full bg-[#9b1c1c] ring-2 ring-white/30 shadow-md transform transition-all duration-300 hover:scale-115 focus:outline-none"
                            data-variant="red" title="Crimson Ruby Red"></button>
                    </div>
                </div>

                <!-- Size Selector -->
                <div class="space-y-2 text-left lg:text-right w-full">
                    <span class="text-xs text-white/80 font-medium block">Choose your size:</span>
                    <div class="flex items-center justify-start lg:justify-end space-x-2">
                        <button type="button" class="size-btn w-10 h-10 rounded-full bg-white text-gray-900 font-bold flex items-center justify-center text-xs shadow border border-white transition">36</button>
                        <button type="button" class="size-btn w-10 h-10 rounded-full bg-black/40 text-white font-medium border border-white/20 hover:bg-black/60 flex items-center justify-center text-xs transition">38</button>
                        <button type="button" class="size-btn w-10 h-10 rounded-full bg-black/40 text-white font-medium border border-white/20 hover:bg-black/60 flex items-center justify-center text-xs transition">40</button>
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

<!-- Dynamic Script for Color Variant Switcher & Custom Rounded Dropdown -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // COLOR VARIANT SWITCHER DATA & THEME SYNC
        const heroContainer = document.getElementById('hero-container');
        const mainImg = document.getElementById('main-hero-img');
        const heroTitle = document.getElementById('hero-title');
        const heroDesc = document.getElementById('hero-desc');
        const heroCaption = document.getElementById('hero-caption');
        const heroPrice = document.getElementById('hero-price');
        const heroOldPrice = document.getElementById('hero-old-price');
        const colorLabel = document.getElementById('color-name-label');
        const swatches = document.querySelectorAll('.swatch-btn');

        const variants = {
            orange: {
                bgClasses: 'from-[#c85513] via-[#b3470d] to-[#6d2806]',
                imgSrc: "{{ asset('images/orange_puffer_hero.jpg') }}",
                title: 'Warm Earth<br>Elevated Style',
                desc: 'สัมผัสความอบอุ่นและดีไซน์พรีเมียมด้วยเสื้อ Puffer Jacket โทนสี Terracotta Orange โดดเด่นทุกมุมมอง',
                caption: 'Confidence, wrapped in warmth',
                price: '฿4,990 ($149)',
                oldPrice: '฿6,500 ($199)',
                label: 'Terracotta Orange',
                labelColor: 'text-amber-300'
            },
            black: {
                bgClasses: 'from-[#2d3748] via-[#1a202c] to-[#0d1117]',
                imgSrc: "{{ asset('images/black_puffer_thumb.jpg') }}",
                title: 'Noir Elegance<br>In Every Stitch',
                desc: 'ความเรียบหรูเหนือกาลเวลาด้วยสี Noir Glossy Black สะท้อนความลุ่มลึกและสไตล์ในแบบฉบับของคุณ',
                caption: 'Unmatched style, wrapped in shadow',
                price: '฿5,490 ($169)',
                oldPrice: '฿7,200 ($219)',
                label: 'Noir Glossy Black',
                labelColor: 'text-gray-300'
            },
            red: {
                bgClasses: 'from-[#9b1c1c] via-[#771d1d] to-[#450a0a]',
                imgSrc: "{{ asset('images/red_puffer_thumb.jpg') }}",
                title: 'Crimson Passion<br>Unapologetic Bold',
                desc: 'ปลุกความโดดเด่นสะดุดตาด้วยสี Crimson Ruby Red ถ่ายทอดความมั่นใจและพลังที่ทรงคุณค่า',
                caption: 'Make a bold statement, ignite the night',
                price: '฿5,990 ($179)',
                oldPrice: '฿8,000 ($249)',
                label: 'Crimson Ruby Red',
                labelColor: 'text-rose-300'
            }
        };

        const variantKeys = ['orange', 'black', 'red'];
        let currentVariantIndex = 0;

        function applyVariant(key) {
            const data = variants[key];
            if (!data) return;

            // 1. Update Swatch UI Ring States
            swatches.forEach(btn => {
                if (btn.getAttribute('data-variant') === key) {
                    btn.className = 'swatch-btn w-9 h-9 rounded-full ' + (key === 'orange' ? 'bg-[#c85513]' : (key === 'black' ? 'bg-[#1a202c]' : 'bg-[#9b1c1c]')) + ' ring-4 ring-white shadow-xl scale-110 transform transition-all duration-300 focus:outline-none';
                } else {
                    const btnKey = btn.getAttribute('data-variant');
                    btn.className = 'swatch-btn w-9 h-9 rounded-full ' + (btnKey === 'orange' ? 'bg-[#c85513]' : (btnKey === 'black' ? 'bg-[#1a202c]' : 'bg-[#9b1c1c]')) + ' ring-2 ring-white/30 shadow-md transform transition-all duration-300 hover:scale-115 focus:outline-none';
                }
            });

            // 2. Smoothly Transition Background Gradient
            heroContainer.className = 'relative w-full rounded-[32px] overflow-hidden bg-gradient-to-br ' + data.bgClasses + ' text-limestone-light p-6 sm:p-8 lg:p-10 shadow-2xl border border-white/20 transition-all duration-700 ease-in-out';

            // 3. Fade Out Main Image, Text & Swap Content
            mainImg.classList.add('opacity-0', 'scale-95');
            heroTitle.classList.add('opacity-0');
            heroDesc.classList.add('opacity-0');
            heroCaption.classList.add('opacity-0');

            setTimeout(() => {
                mainImg.src = data.imgSrc;
                heroTitle.innerHTML = data.title;
                heroDesc.innerHTML = data.desc;
                heroCaption.innerText = data.caption;
                heroPrice.innerText = data.price;
                heroOldPrice.innerText = data.oldPrice;
                colorLabel.innerText = data.label;
                colorLabel.className = 'text-xs font-semibold ' + data.labelColor;

                // Fade back in
                mainImg.classList.remove('opacity-0', 'scale-95');
                heroTitle.classList.remove('opacity-0');
                heroDesc.classList.remove('opacity-0');
                heroCaption.classList.remove('opacity-0');
            }, 300);

            currentVariantIndex = variantKeys.indexOf(key);
        }

        // Add Click Listeners to Swatch Buttons
        swatches.forEach(btn => {
            btn.addEventListener('click', function() {
                const variantKey = this.getAttribute('data-variant');
                applyVariant(variantKey);
            });
        });

        // Add Carousel Prev/Next Slide Listeners
        const prevBtn = document.getElementById('prev-slide');
        const nextBtn = document.getElementById('next-slide');

        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                currentVariantIndex = (currentVariantIndex - 1 + variantKeys.length) % variantKeys.length;
                applyVariant(variantKeys[currentVariantIndex]);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                currentVariantIndex = (currentVariantIndex + 1) % variantKeys.length;
                applyVariant(variantKeys[currentVariantIndex]);
            });
        }

        // Size selector interaction
        const sizeBtns = document.querySelectorAll('.size-btn');
        sizeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                sizeBtns.forEach(b => {
                    b.className = 'size-btn w-10 h-10 rounded-full bg-black/40 text-limestone font-medium border border-limestone/20 hover:bg-black/60 flex items-center justify-center text-xs transition';
                });
                this.className = 'size-btn w-10 h-10 rounded-full bg-white text-gray-900 font-bold flex items-center justify-center text-xs shadow border border-white transition';
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
