@extends('layouts.app')

@section('title', $product->name . ' - ShopDee')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-terracotta/20 p-6 md:p-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Image Section -->
        <div class="h-80 md:h-96 bg-limestone/40 rounded-2xl flex items-center justify-center overflow-hidden border border-terracotta/10 relative">
            @if($product->image)
                @if(str_starts_with($product->image, 'http'))
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @elseif(str_starts_with($product->image, 'images/'))
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
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
                <span class="inline-block bg-terracotta/15 text-terracotta font-bold text-xs px-3 py-1 rounded-full uppercase tracking-wider">
                    {{ $product->category->name }}
                </span>

                <h1 class="text-3xl font-bold text-rust leading-tight">{{ $product->name }}</h1>

                <div class="text-3xl font-extrabold text-terracotta">
                    ฿{{ number_format($product->price, 2) }}
                </div>

                <div class="text-sm">
                    <span class="font-medium text-rust/70">สถานะสต็อก: </span>
                    @if($product->stock > 0)
                        <span class="text-olive-dark font-semibold"><i class="fa-solid fa-circle-check mr-1 text-olive"></i>มีสินค้าอยู่ {{ $product->stock }} ชิ้น</span>
                    @else
                        <span class="text-terracotta font-semibold"><i class="fa-solid fa-circle-xmark mr-1"></i>สินค้าหมด</span>
                    @endif
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
@endsection
