@extends('layouts.app')

@section('title', 'เข้าสู่ระบบ - ShopDee')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
        <i class="fa-solid fa-right-to-bracket text-indigo-600 mr-2"></i>เข้าสู่ระบบ
    </h2>

    <!-- Quick Credentials Hint for Demo -->
    <div class="bg-indigo-50 border border-indigo-200 text-indigo-800 text-xs p-3 rounded mb-6">
        <p class="font-bold mb-1"><i class="fa-solid fa-key mr-1"></i> ข้อมูลสำหรับทดสอบ (Demo Accounts):</p>
        <p>🔴 <strong>Admin:</strong> admin@shopdee.com / password123</p>
        <p>🟢 <strong>Customer:</strong> customer@shopdee.com / password123</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">อีเมล (Email)</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
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

        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-600">จดจำฉันในระบบ</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 rounded-md shadow transition">
            เข้าสู่ระบบ
        </button>
    </form>

    <div class="text-center mt-6">
        <p class="text-sm text-gray-600">ยังไม่มีบัญชีผู้ใช้? 
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">สมัครสมาชิกที่นี่</a>
        </p>
    </div>
</div>
@endsection
