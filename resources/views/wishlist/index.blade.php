@extends('layouts.app')

@section('title', 'รายการที่ชอบ (Wishlist) - ShopDee')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-terracotta/20 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-rust flex items-center gap-2">
                <i class="fa-solid fa-heart text-terracotta"></i> รายการที่ชอบ (Wishlist)
            </h1>
            <p class="text-rust/70 text-sm mt-1">สินค้าที่คุณบันทึกไว้สำหรับตัดสินใจซื้อภายหลัง</p>
        </div>
        <a href="{{ route('products.index') }}" class="bg-limestone hover:bg-limestone/80 text-rust px-4 py-2 rounded-xl text-sm font-medium transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> เลือกช้อปสินค้าเพิ่มเติม
        </a>
    </div>

    @if($wishlists->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($wishlists as $wishlist)
                @php
                    $product = $wishlist->product;
                @endphp
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition border border-terracotta/15 flex flex-col overflow-hidden relative">
                    <!-- Wishlist Toggle (Remove) Button -->
                    <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="absolute top-3 right-3 z-10">
                        @csrf
                        <button type="submit" class="w-8 h-8 rounded-full bg-white/90 hover:bg-white text-terracotta flex items-center justify-center shadow transition" title="ลบออกจากสิ่งที่ชอบ">
                            <i class="fa-solid fa-heart text-base"></i>
                        </button>
                    </form>

                    <div class="h-56 bg-limestone/40 flex items-center justify-center relative overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-box-open text-5xl text-terracotta/30"></i>
                        @endif

                        <span class="absolute top-3 left-3 text-xs font-semibold px-3 py-1 rounded-full {{ $product->stock > 0 ? 'bg-olive/20 text-olive-dark border border-olive/30' : 'bg-terracotta/20 text-terracotta-dark border border-terracotta/30' }}">
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

                        <div class="pt-3 border-t border-limestone space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-extrabold text-terracotta">
                                    ฿{{ number_format($product->price, 2) }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2">
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-grow">
                                    @csrf
                                    <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}
                                        class="w-full bg-terracotta hover:bg-terracotta-dark disabled:bg-gray-300 disabled:cursor-not-allowed text-white text-xs py-2.5 rounded-xl font-medium transition shadow flex items-center justify-center gap-1.5">
                                        <i class="fa-solid fa-cart-plus"></i> เพิ่มลงตะกร้า
                                    </button>
                                </form>
                                <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-limestone hover:bg-limestone-light text-rust text-xs p-2.5 rounded-xl font-medium transition border border-terracotta/20" title="ลบออกจากรายการที่ชอบ">
                                        <i class="fa-solid fa-trash-can text-terracotta"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white p-12 text-center rounded-2xl shadow-sm border border-terracotta/20 space-y-4">
            <div class="w-16 h-16 bg-terracotta/10 text-terracotta rounded-full flex items-center justify-center mx-auto text-2xl">
                <i class="fa-regular fa-heart"></i>
            </div>
            <h3 class="text-lg font-bold text-rust">ยังไม่มีสินค้าในรายการที่ชอบ</h3>
            <p class="text-rust/60 text-sm">คุณสามารถกดไอคอนหัวใจที่สินค้าเพื่อบันทึกไว้ดูภายหลังได้</p>
            <div>
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-terracotta hover:bg-terracotta-dark text-white px-6 py-2.5 rounded-xl text-sm font-medium transition shadow">
                    <i class="fa-solid fa-store"></i> ไปที่หน้ารายการสินค้า
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
