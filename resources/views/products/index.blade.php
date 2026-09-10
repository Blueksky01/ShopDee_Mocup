@extends('layouts.app')

@section('title', 'สินค้าทั้งหมด - ShopDee')

@section('content')
<div class="space-y-6">
    <!-- Search & Filter Banner -->
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-4 justify-between items-center">
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
                    <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 text-sm underline">
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
                    <div class="h-48 bg-gray-100 flex items-center justify-center relative overflow-hidden">
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
@endsection
