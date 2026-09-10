<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ShopDee - Warm Industrial-Earth E-Commerce')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        terracotta: '#B5543A',
                        'terracotta-dark': '#9E452E',
                        olive: '#6F7F5F',
                        'olive-dark': '#5B694E',
                        limestone: '#F0E6D8',
                        'limestone-light': '#F8F4EE',
                        rust: '#5A2E25',
                        'rust-dark': '#44221B',
                    }
                }
            }
        }
    </script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Kanit', sans-serif; background-color: #F8F4EE; color: #44221B; }
    </style>
</head>
<body class="flex flex-col min-h-screen">
    <!-- Navbar (Deep Rust Background with Terracotta Highlights) -->
    <nav class="bg-rust text-limestone-light shadow-xl border-b border-terracotta/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('products.index') }}" class="flex items-center space-x-2 text-2xl font-bold tracking-wider text-limestone-light hover:text-terracotta transition">
                        <i class="fa-solid fa-bag-shopping text-terracotta"></i>
                        <span>ShopDee</span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('products.index') }}" class="hover:text-terracotta px-3 py-2 rounded-md text-sm font-medium transition">
                        <i class="fa-solid fa-store mr-1"></i> สินค้าทั้งหมด
                    </a>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="bg-terracotta hover:bg-terracotta-dark text-white px-3 py-2 rounded-md text-sm font-medium transition shadow">
                                <i class="fa-solid fa-chart-line mr-1"></i> Admin Dashboard
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="hover:text-terracotta px-3 py-2 rounded-md text-sm font-medium transition">
                                <i class="fa-solid fa-box-archive mr-1"></i> จัดการสินค้า
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="hover:text-terracotta px-3 py-2 rounded-md text-sm font-medium transition">
                                <i class="fa-solid fa-clipboard-list mr-1"></i> จัดการออเดอร์
                            </a>
                        @else
                            <a href="{{ route('cart.index') }}" class="relative hover:text-terracotta px-3 py-2 rounded-md text-sm font-medium transition">
                                <i class="fa-solid fa-cart-shopping mr-1"></i> ตะกร้าสินค้า
                                @php
                                    $cartCount = auth()->user()->cart ? auth()->user()->cart->items->sum('quantity') : 0;
                                @endphp
                                @if($cartCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-terracotta text-white text-xs font-bold px-2 py-0.5 rounded-full shadow">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('orders.index') }}" class="hover:text-terracotta px-3 py-2 rounded-md text-sm font-medium transition">
                                <i class="fa-solid fa-receipt mr-1"></i> ประวัติคำสั่งซื้อ
                            </a>
                        @endif

                        <div class="border-l border-rust-dark h-6 mx-2"></div>
                        <span class="text-sm font-medium text-limestone">
                            <i class="fa-solid fa-circle-user mr-1 text-olive"></i> {{ auth()->user()->name }} 
                            <span class="text-xs bg-olive text-white px-2 py-0.5 rounded-full ml-1 font-normal">
                                {{ auth()->user()->role }}
                            </span>
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-terracotta hover:bg-terracotta-dark px-3 py-1.5 rounded-md text-sm font-medium text-white transition shadow">
                                <i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-terracotta px-3 py-2 rounded-md text-sm font-medium transition">
                            <i class="fa-solid fa-right-to-bracket mr-1"></i> เข้าสู่ระบบ
                        </a>
                        <a href="{{ route('register') }}" class="bg-terracotta hover:bg-terracotta-dark text-white px-4 py-2 rounded-md text-sm font-medium shadow transition">
                            สมัครสมาชิก
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="bg-olive/20 border border-olive text-rust px-4 py-3 rounded-lg relative mb-4 font-medium" role="alert">
                <span class="block sm:inline"><i class="fa-solid fa-circle-check mr-2 text-olive font-bold"></i>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-terracotta/20 border border-terracotta text-rust px-4 py-3 rounded-lg relative mb-4 font-medium" role="alert">
                <span class="block sm:inline"><i class="fa-solid fa-triangle-exclamation mr-2 text-terracotta font-bold"></i>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    <!-- Footer (Deep Rust & Terracotta Accent) -->
    <footer class="bg-rust text-limestone py-8 mt-auto border-t border-terracotta/30">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm space-y-2">
            <p class="font-medium tracking-wide">&copy; {{ date('Y') }} ShopDee — Warm Industrial-Earth E-Commerce Concept.</p>
            <p class="text-xs text-limestone/60">Terracotta Clay • Olive Accent • Soft Limestone • Deep Rust</p>
        </div>
    </footer>
</body>
</html>
