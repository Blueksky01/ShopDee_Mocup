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

        <!-- Brand Features Showcase (Without Jacket Image) -->
        <div class="relative z-10 my-8 space-y-4 text-xs text-limestone/90">
            <div class="flex items-center space-x-3 bg-white/10 backdrop-blur p-3 rounded-2xl border border-white/10">
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-sm text-amber-300">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <p class="font-bold text-white">ระบบรักษาความปลอดภัย</p>
                    <p class="text-[11px] text-limestone/70">เข้ารหัสรหัสผ่านและการชำระเงินปลอดภัย</p>
                </div>
            </div>

            <div class="flex items-center space-x-3 bg-white/10 backdrop-blur p-3 rounded-2xl border border-white/10">
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-sm text-amber-300">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div>
                    <p class="font-bold text-white">การจัดส่งรวดเร็ว</p>
                    <p class="text-[11px] text-limestone/70">ติดตามสถานะการจัดส่งได้เรียลไทม์</p>
                </div>
            </div>

            <div class="flex items-center space-x-3 bg-white/10 backdrop-blur p-3 rounded-2xl border border-white/10">
                <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-sm text-amber-300">
                    <i class="fa-solid fa-gem"></i>
                </div>
                <div>
                    <p class="font-bold text-white">สิทธิพิเศษสำหรับสมาชิก</p>
                    <p class="text-[11px] text-limestone/70">สะสมประวัติออเดอร์และรับส่วนลดพรีเมียม</p>
                </div>
            </div>
        </div>

        <div class="relative z-10 text-xs text-limestone/70 border-t border-white/20 pt-4 flex items-center justify-between">
            <span>&copy; {{ date('Y') }} ShopDee System</span>
            <span class="bg-black/30 px-2.5 py-1 rounded-full text-[10px] font-semibold">Mockup Demo</span>
        </div>
    </div>

    <!-- RIGHT SIDE: Interactive Login Form & Quick Fill Buttons & Social Login -->
    <div class="md:col-span-7 p-8 sm:p-10 flex flex-col justify-between space-y-6">
        <div>
            <h2 class="text-2xl font-bold text-rust flex items-center gap-2">
                <i class="fa-solid fa-right-to-bracket text-terracotta"></i> เข้าสู่ระบบ (Login)
            </h2>
            <p class="text-xs text-rust/60 mt-1">กรอกข้อมูลผู้ใช้งาน หรือใช้ Social Login เพื่อเข้าสู่ระบบ</p>

            <!-- Quick Credentials Fill Buttons (Mockup Feature) -->
            <div class="mt-4 bg-limestone/60 border border-terracotta/20 rounded-2xl p-3.5 space-y-2.5">
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
            <form method="POST" action="{{ route('login') }}" class="space-y-4 mt-5">
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

            <!-- Social Login Mockup Section -->
            <div class="mt-6 space-y-3">
                <div class="relative flex items-center justify-center">
                    <div class="border-t border-terracotta/20 w-full"></div>
                    <span class="bg-white px-3 text-[11px] font-bold text-rust/60 uppercase tracking-wider relative">หรือ เข้าสู่ระบบด้วย Social</span>
                </div>

                <div class="grid grid-cols-3 gap-2.5">
                    <!-- Google Mockup Button -->
                    <button type="button" onclick="alert('Mockup Social Login: เข้าสู่ระบบด้วย Google สำเร็จ!')"
                        class="flex items-center justify-center gap-2 py-2.5 px-3 border border-terracotta/25 rounded-2xl bg-white hover:bg-limestone-light text-rust text-xs font-semibold shadow-sm transition transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                        <span>Google</span>
                    </button>

                    <!-- Facebook Mockup Button -->
                    <button type="button" onclick="alert('Mockup Social Login: เข้าสู่ระบบด้วย Facebook สำเร็จ!')"
                        class="flex items-center justify-center gap-2 py-2.5 px-3 border border-[#1877F2]/30 rounded-2xl bg-[#1877F2]/10 hover:bg-[#1877F2]/20 text-[#1877F2] text-xs font-semibold shadow-sm transition transform hover:-translate-y-0.5">
                        <i class="fa-brands fa-facebook text-base"></i>
                        <span>Facebook</span>
                    </button>

                    <!-- Apple Mockup Button -->
                    <button type="button" onclick="alert('Mockup Social Login: เข้าสู่ระบบด้วย Apple ID สำเร็จ!')"
                        class="flex items-center justify-center gap-2 py-2.5 px-3 border border-rust/30 rounded-2xl bg-rust/10 hover:bg-rust/20 text-rust text-xs font-semibold shadow-sm transition transform hover:-translate-y-0.5">
                        <i class="fa-brands fa-apple text-base"></i>
                        <span>Apple</span>
                    </button>
                </div>
            </div>
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
