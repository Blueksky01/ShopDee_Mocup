<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ShopDee - E-Commerce System')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Kanit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Navbar -->
    <nav class="bg-indigo-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('products.index') }}" class="flex items-center space-x-2 text-2xl font-bold tracking-wider">
                        <i class="fa-solid font-bold fa-bag-shopping"></i>
                        <span>ShopDee</span>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('products.index') }}" class="hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fa-solid fa-store mr-1"></i> สินค้าทั้งหมด
                    </a>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="bg-indigo-700 hover:bg-indigo-800 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fa-solid fa-chart-line mr-1"></i> Admin Dashboard
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fa-solid fa-box-archive mr-1"></i> จัดการสินค้า
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fa-solid fa-clipboard-list mr-1"></i> จัดการออเดอร์
                            </a>
                        @else
                            <a href="{{ route('cart.index') }}" class="relative hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fa-solid fa-cart-shopping mr-1"></i> ตะกร้าสินค้า
                                @php
                                    $cartCount = auth()->user()->cart ? auth()->user()->cart->items->sum('quantity') : 0;
                                @endphp
                                @if($cartCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>
                            <a href="{{ route('orders.index') }}" class="hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">
                                <i class="fa-solid fa-receipt mr-1"></i> ประวัติคำสั่งซื้อ
                            </a>
                        @endif

                        <div class="border-l border-indigo-500 h-6 mx-2"></div>
                        <span class="text-sm font-medium text-indigo-100">
                            <i class="fa-solid fa-circle-user mr-1"></i> {{ auth()->user()->name }} 
                            <span class="text-xs bg-indigo-800 px-2 py-0.5 rounded-full ml-1">
                                {{ auth()->user()->role }}
                            </span>
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-md text-sm font-medium text-white transition">
                                <i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-indigo-200 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fa-solid fa-right-to-bracket mr-1"></i> เข้าสู่ระบบ
                        </a>
                        <a href="{{ route('register') }}" class="bg-white text-indigo-600 hover:bg-indigo-50 px-3 py-2 rounded-md text-sm font-medium shadow transition">
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
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm">
            <p>&copy; {{ date('Y') }} ShopDee E-Commerce System (Mockup Demo). All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
