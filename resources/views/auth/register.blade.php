@extends('layouts.app')

@section('title', 'สมัครสมาชิก - ShopDee')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
        <i class="fa-solid fa-user-plus text-indigo-600 mr-2"></i>สมัครสมาชิกใหม่
    </h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">ชื่อ - นามสกุล</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">อีเมล (Email)</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">รหัสผ่าน (Password)</label>
            <input type="password" name="password" id="password" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">ยืนยันรหัสผ่าน</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm">
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-md shadow transition">
            ยืนยันการสมัครสมาชิก
        </button>
    </form>

    <div class="text-center mt-6">
        <p class="text-sm text-gray-600">มีบัญชีผู้ใช้อยู่แล้ว? 
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium">เข้าสู่ระบบ</a>
        </p>
    </div>
</div>
@endsection
