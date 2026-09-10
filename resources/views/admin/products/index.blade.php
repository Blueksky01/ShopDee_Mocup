@extends('layouts.app')

@section('title', 'จัดการสินค้า - Admin ShopDee')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-boxes-packing text-indigo-600"></i> จัดการรายการสินค้า (Product Management)
        </h1>
        <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg shadow text-sm transition">
            <i class="fa-solid fa-plus mr-1"></i> เพิ่มสินค้าใหม่
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse text-sm">
            <thead class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase">
                <tr>
                    <th class="p-4">สินค้า</th>
                    <th class="p-4">หมวดหมู่</th>
                    <th class="p-4">ราคา</th>
                    <th class="p-4 text-center">สต็อก</th>
                    <th class="p-4 text-center">สถานะ</th>
                    <th class="p-4 text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr>
                        <td class="p-4 flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-100 rounded flex-shrink-0 flex items-center justify-center overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-box text-gray-400"></i>
                                @endif
                            </div>
                            <span class="font-bold text-gray-800">{{ $product->name }}</span>
                        </td>
                        <td class="p-4 text-gray-600 text-xs">
                            {{ $product->category->name }}
                        </td>
                        <td class="p-4 font-bold text-indigo-600">
                            ฿{{ number_format($product->price, 2) }}
                        </td>
                        <td class="p-4 text-center font-bold {{ $product->stock <= 5 ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $product->stock }}
                        </td>
                        <td class="p-4 text-center">
                            @if($product->is_active)
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded font-semibold">เปิดขาย</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded font-semibold">ปิดขาย</span>
                            @endif
                        </td>
                        <td class="p-4 text-center space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs transition">
                                <i class="fa-solid fa-pen-to-square"></i> แก้ไข
                            </a>

                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('ยืนยันการลบสินค้า {{ $product->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs transition">
                                    <i class="fa-solid fa-trash-can"></i> ลบ
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
