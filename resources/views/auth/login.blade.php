@extends('layouts.app')

@section('title', 'เข้าสู่ระบบ - ShopDee Masters')

@section('content')
<div class="max-w-4xl mx-auto my-6 bg-white rounded-[32px] shadow-2xl border border-terracotta/20 overflow-hidden grid grid-cols-1 md:grid-cols-12">

    <!-- LEFT SIDE: Visual Showcase (Terracotta & Warm Earth Brand Card) -->
    <div class="md:col-span-5 bg-gradient-to-br from-terracotta via-[#9A462E] to-rust text-white p-8 flex flex-col justify-between relative overflow-hidden">
        <!-- Ambient Glow -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_30%,rgba(240,230,216,0.2),transparent_70%)] pointer-events-none"></div>

        <div class="relative z-10 space-y-4">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-white text-rust font-bold text-xs flex items-center justify-center rounded-md shadow-md">
                    JM
                </div>
                <span class="font-bold tracking-widest text-sm uppercase text-limestone-light font-serif">JACKET MASTERS</span>
            </div>
            <h2 class="text-3xl font-bold font-serif leading-tight">Welcome Back to Premium Style</h2>
            <p class="text-xs text-limestone/80 leading-relaxed font-light">
                เข้าสู่ระบบเพื่อจัดการตะกร้าสินค้า ติดตามคำสั่งซื้อ และสัมผัสประสบการณ์ช้อปปิ้งเสื้อผ้าแฟชั่นพรีเมียม
            </p>
        </div>

        <!-- Floating Showcase Product Image -->
        <div class="relative z-10 my-6 flex justify-center">
            <img src="{{ asset('images/orange_isolated.jpg') }}" alt="Puffer Jacket Showcase" 
                class="w-48 object-contain mix-blend-multiply drop-shadow-[0_20px_25px_rgba(0,0,0,0.4)] transform hover:scale-105 transition duration-500">
        </div>

        <div class="relative z-10 text-xs text-limestone/70 border-t border-white/20 pt-4 flex items-center justify-between">
            <span>&copy; {{ date('Y') }} ShopDee System</span>
            <span class="bg-black/30 px-2.5 py-1 rounded-full text-[10px] font-semibold">Mockup Demo</span>
        </div>
    </div>

    <!-- RIGHT SIDE: Interactive Login Form & Quick Fill Buttons -->
    <div class="md:col-span-7 p-8 sm:p-10 flex flex-col justify-between space-y-6">
        <div>
            <h2 class="text-2xl font-bold text-rust flex items-center gap-2">
                <i class="fa-solid fa-right-to-bracket text-terracotta"></i> เข้าสู่ระบบ (Login)
            </h2>
            <p class="text-xs text-rust/60 mt-1">กรอกข้อมูลผู้ใช้งานหรือเลือกบัญชีทดสอบเพื่อเข้าสู่ระบบ</p>

            <!-- Quick Credentials Fill Buttons (Mockup Feature) -->
            <div class="mt-4 bg-limestone/60 border border-terracotta/20 rounded-2xl p-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-terracotta flex items-center gap-1">
                        <i class="fa-solid fa-bolt text-amber-500"></i> คลิกเพื่อกรอกบัญชีทดสอบ (Demo Quick Fill):
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" id="fill-admin-btn" 
                        class="bg-rust hover:bg-rust-dark text-white text-xs font-medium py-2 px-3 rounded-xl transition shadow flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-user-shield text-amber-400"></i> Admin Account
                    </button>
                    <button type="button" id="fill-customer-btn" 
                        class="bg-terracotta hover:bg-terracotta-dark text-white text-xs font-medium py-2 px-3 rounded-xl transition shadow flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-user text-green-300"></i> Customer Account
                    </button>
                </div>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4 mt-6">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-rust uppercase tracking-wider mb-1">อีเมล (Email)</label>
                    <div class="relative">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com"
                            class="w-full pl-10 pr-4 py-2.5 border border-terracotta/30 rounded-2xl focus:outline-none focus:ring-2 focus:ring-terracotta text-sm bg-limestone-light/40 text-rust">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-3.5 text-terracotta/60 text-sm"></i>
                    </div>
                    @error('email')
                        <p class="text-terracotta text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-rust uppercase tracking-wider mb-1">รหัสผ่าน (Password)</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" required placeholder="••••••••"
                            class="w-full pl-10 pr-10 py-2.5 border border-terracotta/30 rounded-2xl focus:outline-none focus:ring-2 focus:ring-terracotta text-sm bg-limestone-light/40 text-rust">
                        <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-terracotta/60 text-sm"></i>
                        <button type="button" id="toggle-password-btn" class="absolute right-3.5 top-3.5 text-rust/50 hover:text-rust text-sm">
                            <i class="fa-solid fa-eye" id="password-eye-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-terracotta text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-terracotta/30 text-terracotta shadow-sm focus:ring-terracotta">
                        <span class="ml-2 text-rust/70 font-medium">จดจำฉันในระบบ</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-terracotta hover:bg-terracotta-dark text-white font-bold py-3 rounded-2xl shadow-lg transition transform hover:-translate-y-0.5 text-sm flex items-center justify-center gap-2">
                    <span>เข้าสู่ระบบ</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>

        <div class="text-center border-t border-limestone pt-4">
            <p class="text-xs text-rust/70">ยังไม่มีบัญชีผู้ใช้? 
                <a href="{{ route('register') }}" class="text-terracotta hover:underline font-bold">สมัครสมาชิกใหม่ที่นี่</a>
            </p>
        </div>
    </div>

</div>

<!-- Quick Fill & Password Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const fillAdminBtn = document.getElementById('fill-admin-btn');
        const fillCustomerBtn = document.getElementById('fill-customer-btn');
        const togglePasswordBtn = document.getElementById('toggle-password-btn');
        const eyeIcon = document.getElementById('password-eye-icon');

        if (fillAdminBtn) {
            fillAdminBtn.addEventListener('click', function() {
                emailInput.value = 'admin@shopdee.com';
                passwordInput.value = 'password123';
            });
        }

        if (fillCustomerBtn) {
            fillCustomerBtn.addEventListener('click', function() {
                emailInput.value = 'customer@shopdee.com';
                passwordInput.value = 'password123';
            });
        }

        if (togglePasswordBtn) {
            togglePasswordBtn.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.className = 'fa-solid fa-eye-slash';
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.className = 'fa-solid fa-eye';
                }
            });
        }
    });
</script>
@endsection
