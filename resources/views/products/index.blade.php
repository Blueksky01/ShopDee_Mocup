@extends('layouts.app')

@section('title', 'ShopDee - Premium Puffer Jacket Collection')

@section('content')
<div class="space-y-10">

    <!-- HERO SECTION (Cloned from design) -->
    <div class="relative w-full rounded-[32px] overflow-hidden bg-gradient-to-br from-[#c85513] via-[#b3470d] to-[#6d2806] text-white p-6 sm:p-8 lg:p-10 shadow-2xl border border-orange-500/30">
        
        <!-- Ambient Background Glow -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_30%,rgba(255,255,255,0.15),transparent_60%)] pointer-events-none"></div>

        <!-- Top Header Navigation inside Hero -->
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-4 mb-8">
            <!-- Brand Logo Left -->
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white text-[#b3470d] font-bold text-xs flex items-center justify-center rounded-md shadow-md">
                    SD
                </div>
                <span class="font-bold tracking-widest text-sm uppercase">ShopDee Masters</span>
            </div>

            <!-- Floating Pill Navigation Center -->
            <div class="bg-black/30 backdrop-blur-md border border-white/10 rounded-full px-2 py-1.5 flex items-center gap-1 sm:gap-2 shadow-lg">
                <button type="button" class="bg-white text-gray-900 font-bold px-4 py-1.5 rounded-full text-xs shadow transition">
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
                <a href="{{ route('cart.index') }}" class="w-9 h-9 bg-black/20 hover:bg-black/40 rounded-full flex items-center justify-center text-white/90 transition border border-white/10 relative">
                    <i class="fa-solid fa-bag-shopping text-sm"></i>
                    @php
                        $heroCartCount = auth()->check() && auth()->user()->cart ? auth()->user()->cart->items->sum('quantity') : 0;
                    @endphp
                    @if($heroCartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-white text-orange-600 font-bold text-[10px] w-4 h-4 rounded-full flex items-center justify-center">
                            {{ $heroCartCount }}
                        </span>
                    @endif
                </a>
                <button type="button" class="w-9 h-9 bg-black/20 hover:bg-black/40 rounded-full flex items-center justify-center text-white/90 transition border border-white/10">
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
                    <h1 id="hero-title" class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white leading-tight font-serif">
                        Stand out<br>Without trying
                    </h1>
                </div>

                <!-- Paragraph Description -->
                <p id="hero-desc" class="text-white/80 text-xs sm:text-sm leading-relaxed max-w-sm">
                    It's not just about staying warm. It's about stepping outside and instantly feeling confident, comfortable, and completely yourself. Designed to elevate even the simplest outfit, this jacket wraps you in lightweight warmth.
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
                        class="w-72 sm:w-80 lg:w-96 rounded-3xl object-contain drop-shadow-[0_30px_35px_rgba(0,0,0,0.5)] transform hover:scale-105 transition duration-500">
                </div>

                <!-- Bottom Center Caption -->
                <p id="hero-caption" class="text-white/80 text-xs sm:text-sm font-light italic mt-6 tracking-wide text-center">
                    Confidence, wrapped in warmth
                </p>
            </div>

            <!-- RIGHT COLUMN: Pricing, Sizes & Thumbnail Preview -->
            <div class="lg:col-span-3 flex flex-col justify-between items-start lg:items-end space-y-8">
                
                <!-- Price Display -->
                <div class="text-left lg:text-right space-y-1">
                    <div id="hero-old-price" class="text-lg text-white/50 line-through font-medium">฿6,500 ($199)</div>
                    <div id="hero-price" class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight">฿4,990 ($149)</div>
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

                <!-- Alternative Color Thumbnail Preview -->
                <div class="pt-4 text-left lg:text-right">
                    <p class="text-[11px] text-white/60 mb-2">Switch Color:</p>
                    <div id="toggle-color-card" class="group relative w-20 h-20 bg-black/40 border border-white/20 rounded-2xl overflow-hidden shadow-lg hover:scale-105 transition cursor-pointer p-1">
                        <img id="thumb-hero-img" src="{{ asset('images/black_puffer_thumb.jpg') }}" alt="Black Puffer Jacket" class="w-full h-full object-cover rounded-xl">
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition"></div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- END HERO SECTION -->

    <!-- CATALOG SECTION -->
    <div id="catalog" class="space-y-6 pt-4">
        <!-- Search & Filter Banner -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <form method="GET" action="{{ route('products.index') }}#catalog" class="flex flex-col md:flex-row gap-4 justify-between items-center">
                <div class="w-full md:w-1/2 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาสินค้าตามชื่อ หรือ คำอธิบาย..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400 text-sm"></i>
                </div>

                <div class="w-full md:w-auto flex items-center gap-3">
                    <select name="category" onchange="this.form.submit()" class="py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                        <option value="">-- ทุกหมวดหมู่ --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition shadow">
                        ค้นหา
                    </button>

                    @if(request()->hasAny(['search', 'category']))
                        <a href="{{ route('products.index') }}#catalog" class="text-gray-500 hover:text-gray-700 text-sm underline">
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
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition border border-gray-200 flex flex-col overflow-hidden">
                        <div class="h-56 bg-gray-100 flex items-center justify-center relative overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-box-open text-5xl text-gray-300"></i>
                            @endif

                            <span class="absolute top-3 right-3 text-xs font-semibold px-2.5 py-1 rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->stock > 0 ? 'มีสต็อก (' . $product->stock . ')' : 'สินค้าหมด' }}
                            </span>
                        </div>

                        <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                            <div>
                                <span class="text-xs font-medium text-indigo-600 uppercase tracking-wider">
                                    {{ $product->category->name }}
                                </span>
                                <h3 class="text-lg font-bold text-gray-800 mt-1 line-clamp-1">
                                    <a href="{{ route('products.show', $product->slug) }}" class="hover:text-indigo-600 transition">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <p class="text-gray-500 text-xs mt-2 line-clamp-2">
                                    {{ $product->description ?? 'ไม่มีคำอธิบายสินค้า' }}
                                </p>
                            </div>

                            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-xl font-extrabold text-indigo-600">
                                    ฿{{ number_format($product->price, 2) }}
                                </span>

                                @auth
                                    @if(!auth()->user()->isAdmin())
                                        <form action="{{ route('cart.add', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}
                                                class="bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white text-xs px-3.5 py-2 rounded-lg font-medium transition shadow flex items-center gap-1.5">
                                                <i class="fa-solid fa-cart-plus"></i> เพิ่มลงตะกร้า
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs px-3 py-2 rounded-lg font-medium transition">
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
            <div class="bg-white p-12 text-center rounded-lg shadow-sm border border-gray-200">
                <i class="fa-solid fa-store-slash text-5xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-bold text-gray-700">ไม่พบบริการหรือสินค้าที่คุณค้นหา</h3>
                <p class="text-gray-500 text-sm mt-1">ลองเปลี่ยนคำค้นหา หรือเลือกหมวดใหม่อีกครั้ง</p>
            </div>
        @endif
    </div>
</div>

<!-- Dynamic Interactivity Script for Hero Section -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainImg = document.getElementById('main-hero-img');
        const thumbImg = document.getElementById('thumb-hero-img');
        const toggleCard = document.getElementById('toggle-color-card');

        const orangeImgSrc = "{{ asset('images/orange_puffer_hero.jpg') }}";
        const blackImgSrc = "{{ asset('images/black_puffer_thumb.jpg') }}";

        let isOrange = true;

        function switchHeroColor() {
            if (isOrange) {
                mainImg.src = blackImgSrc;
                thumbImg.src = orangeImgSrc;
                document.getElementById('hero-title').innerHTML = 'Noir Elegance<br>In Every Stitch';
                document.getElementById('hero-caption').innerText = 'Unmatched style, wrapped in shadow';
                document.getElementById('hero-price').innerText = '฿5,490 ($169)';
                document.getElementById('hero-old-price').innerText = '฿7,200 ($219)';
            } else {
                mainImg.src = orangeImgSrc;
                thumbImg.src = blackImgSrc;
                document.getElementById('hero-title').innerHTML = 'Stand out<br>Without trying';
                document.getElementById('hero-caption').innerText = 'Confidence, wrapped in warmth';
                document.getElementById('hero-price').innerText = '฿4,990 ($149)';
                document.getElementById('hero-old-price').innerText = '฿6,500 ($199)';
            }
            isOrange = !isOrange;
        }

        toggleCard.addEventListener('click', switchHeroColor);
        document.getElementById('next-slide').addEventListener('click', switchHeroColor);
        document.getElementById('prev-slide').addEventListener('click', switchHeroColor);

        // Size selector interaction
        const sizeBtns = document.querySelectorAll('.size-btn');
        sizeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                sizeBtns.forEach(b => {
                    b.className = 'size-btn w-10 h-10 rounded-full bg-black/40 text-white font-medium border border-white/20 hover:bg-black/60 flex items-center justify-center text-xs transition';
                });
                this.className = 'size-btn w-10 h-10 rounded-full bg-white text-gray-900 font-bold flex items-center justify-center text-xs shadow border border-white transition';
            });
        });
    });
</script>
@endsection
