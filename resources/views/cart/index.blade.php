@extends('layouts.app')

@section('title', 'ตะกร้าสินค้า - ShopDee')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
        <i class="fa-solid fa-cart-shopping text-indigo-600"></i> ตะกร้าสินค้าของคุณ
    </h1>

    @if($cart->items->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Items Table -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <tr>
                            <th class="p-4">สินค้า</th>
                            <th class="p-4">ราคาต่อชิ้น</th>
                            <th class="p-4 text-center">จำนวน</th>
                            <th class="p-4 text-right">ราคารวม</th>
                            <th class="p-4 text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @foreach($cart->items as $item)
                            <tr>
                                <td class="p-4 flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gray-100 rounded flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-box text-gray-400"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('products.show', $item->product->slug) }}" class="font-bold text-gray-800 hover:text-indigo-600">
                                            {{ $item->product->name }}
                                        </a>
                                        <div class="text-xs text-gray-500">คงเหลือ: {{ $item->product->stock }} ชิ้น</div>
                                    </div>
                                </td>
                                <td class="p-4 font-medium text-gray-700">
                                    ฿{{ number_format($item->product->price, 2) }}
                                </td>
                                <td class="p-4">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center justify-center space-x-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                            class="w-16 px-2 py-1 border border-gray-300 rounded text-center text-sm focus:ring-indigo-500">
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-800 text-xs underline">
                                            อัปเดต
                                        </button>
                                    </form>
                                </td>
                                <td class="p-4 text-right font-bold text-indigo-600">
                                    ฿{{ number_format($item->product->price * $item->quantity, 2) }}
                                </td>
                                <td class="p-4 text-center">
                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Order Summary -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 h-fit space-y-4">
                <h2 class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-3">สรุปรายการสั่งซื้อ</h2>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>ยอดรวมสินค้า:</span>
                        <span>฿{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>ค่าจัดส่ง:</span>
                        <span class="text-green-600 font-medium">ฟรี (Mockup)</span>
                    </div>
                    <div class="border-t border-gray-200 pt-2 flex justify-between font-extrabold text-lg text-indigo-600">
                        <span>ยอดรวมสุทธิ:</span>
                        <span>฿{{ number_format($subtotal, 2) }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow transition">
                    ไปที่หน้าชำระเงิน <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    @else
        <div class="bg-white p-12 text-center rounded-lg shadow-sm border border-gray-200 space-y-4">
            <i class="fa-solid fa-cart-flatbed text-6xl text-gray-300"></i>
            <h3 class="text-xl font-bold text-gray-700">ไม่มีสินค้าในตะกร้าของคุณ</h3>
            <p class="text-gray-500 text-sm">เลือกซื้อสินค้าโปรดของคุณและเพิ่มลงตะกร้าได้ทันที</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-2.5 rounded-lg shadow text-sm transition">
                <i class="fa-solid fa-store mr-1"></i> เลือกชมสินค้า
            </a>
        </div>
    @endif
</div>
@endsection
