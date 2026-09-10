@extends('layouts.app')

@section('title', 'เข้าสู่ระบบ - ShopDee')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-xl shadow-md border border-terracotta/20 mt-10">
    <h2 class="text-2xl font-bold text-center text-rust mb-6">
        <i class="fa-solid fa-right-to-bracket text-terracotta mr-2"></i>เข้าสู่ระบบ
    </h2>

    <!-- Quick Credentials Hint for Demo -->
    <div class="bg-limestone border border-terracotta/30 text-rust text-xs p-4 rounded-lg mb-6">
        <p class="font-bold mb-1 text-terracotta"><i class="fa-solid fa-key mr-1"></i> ข้อมูลสำหรับทดสอบ (Demo Accounts):</p>
        <p>🔴 <strong>Admin:</strong> admin@shopdee.com / password123</p>
        <p>🟢 <strong>Customer:</strong> customer@shopdee.com / password123</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-rust">อีเมล (Email)</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                class="mt-1 block w-full px-3 py-2 border border-terracotta/30 rounded-md shadow-sm focus:outline-none focus:ring-terracotta focus:border-terracotta text-sm bg-limestone-light/50">
            @error('email')
                <p class="text-terracotta text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-rust">รหัสผ่าน (Password)</label>
            <input type="password" name="password" id="password" required
                class="mt-1 block w-full px-3 py-2 border border-terracotta/30 rounded-md shadow-sm focus:outline-none focus:ring-terracotta focus:border-terracotta text-sm bg-limestone-light/50">
            @error('password')
                <p class="text-terracotta text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-terracotta/30 text-terracotta shadow-sm focus:ring-terracotta">
                <span class="ml-2 text-sm text-rust/70">จดจำฉันในระบบ</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-terracotta hover:bg-terracotta-dark text-white font-medium py-2.5 rounded-md shadow transition">
            เข้าสู่ระบบ
        </button>
    </form>

    <div class="text-center mt-6">
        <p class="text-sm text-rust/70">ยังไม่มีบัญชีผู้ใช้? 
            <a href="{{ route('register') }}" class="text-terracotta hover:underline font-bold">สมัครสมาชิกที่นี่</a>
        </p>
    </div>
</div>
@endsection
