@extends('layouts.app')

@section('title', 'สมัครสมาชิก - ShopDee Masters')

@section('content')
<div class="max-w-4xl mx-auto my-6 bg-white rounded-[32px] shadow-2xl border border-terracotta/20 overflow-hidden grid grid-cols-1 md:grid-cols-12">

    <!-- LEFT SIDE: Visual Showcase (Noir Black Jacket Theme) -->
    <div class="md:col-span-5 bg-gradient-to-br from-[#2d3748] via-[#1a202c] to-[#0d1117] text-white p-8 flex flex-col justify-between relative overflow-hidden">
        <!-- Ambient Glow -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_30%,rgba(255,255,255,0.15),transparent_70%)] pointer-events-none"></div>

        <div class="relative z-10 space-y-4">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-white text-gray-900 font-bold text-xs flex items-center justify-center rounded-md shadow-md">
                    JM
                </div>
                <span class="font-bold tracking-widest text-sm uppercase text-white font-serif">JACKET MASTERS</span>
            </div>
            <h2 class="text-3xl font-bold font-serif leading-tight">Join the Exclusive Collection</h2>
            <p class="text-xs text-gray-300 leading-relaxed font-light">
                สมัครสมาชิกง่ายๆ เพียงไม่กี่ขั้นตอน เพื่อรับสิทธิพิเศษในการสั่งซื้อสินค้า สะสมประวัติออเดอร์ และเข้าถึงคอลเลกชันใหม่ก่อนใคร
            </p>
        </div>

        <!-- Floating Showcase Product Image -->
        <div class="relative z-10 my-6 flex justify-center">
            <img src="{{ asset('images/black_isolated.jpg') }}" alt="Black Puffer Jacket Showcase" 
                class="w-48 object-contain mix-blend-multiply drop-shadow-[0_20px_25px_rgba(0,0,0,0.6)] transform hover:scale-105 transition duration-500">
        </div>

        <div class="relative z-10 text-xs text-gray-400 border-t border-white/20 pt-4 flex items-center justify-between">
            <span>&copy; {{ date('Y') }} ShopDee System</span>
            <span class="bg-white/20 px-2.5 py-1 rounded-full text-[10px] font-semibold text-white">Member Join</span>
        </div>
    </div>

    <!-- RIGHT SIDE: Interactive Register Form -->
    <div class="md:col-span-7 p-8 sm:p-10 flex flex-col justify-between space-y-6">
        <div>
            <h2 class="text-2xl font-bold text-rust flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-terracotta"></i> สมัครสมาชิกใหม่ (Register)
            </h2>
            <p class="text-xs text-rust/60 mt-1">กรอกข้อมูลส่วนตัวเพื่อสร้างบัญชีสมาชิกประเภท Customer</p>

            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4 mt-6">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-bold text-rust uppercase tracking-wider mb-1">ชื่อ - นามสกุล (Full Name)</label>
                    <div class="relative">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus placeholder="สมชาย ใจดี"
                            class="w-full pl-10 pr-4 py-2.5 border border-terracotta/30 rounded-2xl focus:outline-none focus:ring-2 focus:ring-terracotta text-sm bg-limestone-light/40 text-rust">
                        <i class="fa-solid fa-user absolute left-3.5 top-3.5 text-terracotta/60 text-sm"></i>
                    </div>
                    @error('name')
                        <p class="text-terracotta text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-rust uppercase tracking-wider mb-1">อีเมล (Email Address)</label>
                    <div class="relative">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="somchai@example.com"
                            class="w-full pl-10 pr-4 py-2.5 border border-terracotta/30 rounded-2xl focus:outline-none focus:ring-2 focus:ring-terracotta text-sm bg-limestone-light/40 text-rust">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-3.5 text-terracotta/60 text-sm"></i>
                    </div>
                    @error('email')
                        <p class="text-terracotta text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-bold text-rust uppercase tracking-wider mb-1">รหัสผ่าน</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required placeholder="อย่างน้อย 6 ตัวอักษร"
                                class="w-full pl-10 pr-4 py-2.5 border border-terracotta/30 rounded-2xl focus:outline-none focus:ring-2 focus:ring-terracotta text-sm bg-limestone-light/40 text-rust">
                            <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-terracotta/60 text-sm"></i>
                        </div>
                        @error('password')
                            <p class="text-terracotta text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-rust uppercase tracking-wider mb-1">ยืนยันรหัสผ่าน</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="พิมพ์รหัสผ่านซ้ำอีกครั้ง"
                                class="w-full pl-10 pr-4 py-2.5 border border-terracotta/30 rounded-2xl focus:outline-none focus:ring-2 focus:ring-terracotta text-sm bg-limestone-light/40 text-rust">
                            <i class="fa-solid fa-shield-halved absolute left-3.5 top-3.5 text-terracotta/60 text-sm"></i>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-terracotta hover:bg-terracotta-dark text-white font-bold py-3 rounded-2xl shadow-lg transition transform hover:-translate-y-0.5 text-sm flex items-center justify-center gap-2 mt-2">
                    <span>ยืนยันการสมัครสมาชิก</span>
                    <i class="fa-solid fa-circle-check text-xs"></i>
                </button>
            </form>
        </div>

        <div class="text-center border-t border-limestone pt-4">
            <p class="text-xs text-rust/70">มีบัญชีผู้ใช้อยู่แล้ว? 
                <a href="{{ route('login') }}" class="text-terracotta hover:underline font-bold">เข้าสู่ระบบที่นี่</a>
            </p>
        </div>
    </div>

</div>
@endsection
