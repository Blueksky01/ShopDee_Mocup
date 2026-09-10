@extends('layouts.app')

@section('title', $product->name . ' - ShopDee')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 md:p-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Image Section -->
        <div class="h-80 md:h-96 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden border border-gray-200">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
                <i class="fa-solid fa-box-open text-7xl text-gray-300"></i>
            @endif
        </div>

        <!-- Details Section -->
        <div class="flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                    {{ $product->category->name }}
                </span>

                <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>

                <div class="text-3xl font-extrabold text-indigo-600">
                    ฿{{ number_format($product->price, 2) }}
                </div>

                <div class="text-sm">
                    <span class="font-medium text-gray-700">สถานะสต็อก: </span>
                    @if($product->stock > 0)
                        <span class="text-green-600 font-semibold"><i class="fa-solid fa-circle-check mr-1"></i>มีสินค้าอยู่ {{ $product->stock }} ชิ้น</span>
                    @else
                        <span class="text-red-600 font-semibold"><i class="fa-solid fa-circle-xmark mr-1"></i>สินค้าหมด</span>
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-sm font-semibold text-gray-800 mb-2">รายละเอียดสินค้า</h3>
                    <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ $product->description ?? 'ไม่มีข้อมูลคำอธิบายเพิ่มเติม' }}
                    </p>
                </div>
            </div>

            <!-- Action Section -->
            @auth
                @if(!auth()->user()->isAdmin())
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4 pt-4 border-t border-gray-200">
                        @csrf
                        <div class="flex items-center space-x-4">
                            <label for="quantity" class="text-sm font-medium text-gray-700">จำนวน:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                class="w-24 px-3 py-2 border border-gray-300 rounded-md text-center focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>

                        <button type="submit" {{ $product->stock <= 0 ? 'disabled' : '' }}
                            class="w-full bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-medium py-3 rounded-lg shadow transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-cart-plus text-lg"></i> เพิ่มลงตะกร้าสินค้า
                        </button>
                    </form>
                @endif
            @else
                <div class="bg-gray-50 p-4 rounded-lg text-center border border-gray-200">
                    <p class="text-sm text-gray-600 mb-3">กรุณาเข้าสู่ระบบเพื่อดำเนินการสั่งซื้อสินค้า</p>
                    <a href="{{ route('login') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2 rounded-lg text-sm transition">
                        เข้าสู่ระบบ
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
