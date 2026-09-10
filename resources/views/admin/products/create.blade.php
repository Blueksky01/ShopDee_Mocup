@extends('layouts.app')

@section('title', 'เพิ่มสินค้าใหม่ - Admin ShopDee')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md border border-gray-200 space-y-6">
    <div class="flex items-center justify-between border-b border-gray-200 pb-4">
        <h1 class="text-xl font-bold text-gray-800"><i class="fa-solid fa-plus text-indigo-600 mr-2"></i>เพิ่มสินค้าใหม่</h1>
        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">&larr; ยกเลิก</a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">หมวดหมู่สินค้า *</label>
            <select name="category_id" id="category_id" required class="mt-1 block w-full p-2.5 border border-gray-300 rounded-md text-sm">
                <option value="">-- เลือกหมวดหมู่ --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">ชื่อสินค้า *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full p-2.5 border border-gray-300 rounded-md text-sm">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">คำอธิบายสินค้า</label>
            <textarea name="description" id="description" rows="3" class="mt-1 block w-full p-2.5 border border-gray-300 rounded-md text-sm">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">ราคาสินค้า (บาท) *</label>
                <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required class="mt-1 block w-full p-2.5 border border-gray-300 rounded-md text-sm">
                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">จำนวนสต็อก *</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', 10) }}" required class="mt-1 block w-full p-2.5 border border-gray-300 rounded-md text-sm">
                @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="image" class="block text-sm font-medium text-gray-700">รูปภาพสินค้า (jpeg, png, jpg, webp ขนาดไม่เกิน 2MB)</label>
            <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="mt-1 block w-full text-sm text-gray-500 border border-gray-300 rounded-md p-2">
            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600">
            <label for="is_active" class="ml-2 text-sm text-gray-700">เปิดวางจำหน่ายสินค้านี้</label>
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-md shadow transition text-sm">
            บันทึกสินค้าใหม่
        </button>
    </form>
</div>
@endsection
