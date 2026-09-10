@extends('layouts.app')

@section('title', 'Admin Dashboard - ShopDee')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fa-solid fa-chart-line text-indigo-600"></i> Admin Dashboard & Analytics
        </h1>
        <span class="text-xs bg-indigo-100 text-indigo-800 font-semibold px-3 py-1 rounded-full">
            แผงควบคุมหลัก
        </span>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">ยอดขายรวม</p>
                <h3 class="text-2xl font-extrabold text-indigo-600 mt-1">฿{{ number_format($totalSales, 2) }}</h3>
            </div>
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center text-xl">
                <i class="fa-solid fa-coins"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">ออเดอร์ทั้งหมด</p>
                <h3 class="text-2xl font-extrabold text-gray-800 mt-1">{{ number_format($totalOrders) }} รายการ</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-xl">
                <i class="fa-solid fa-cart-flatbed"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">จำนวนสินค้าในระบบ</p>
                <h3 class="text-2xl font-extrabold text-gray-800 mt-1">{{ number_format($totalProducts) }} ชนิด</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center text-xl">
                <i class="fa-solid fa-box-archive"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-gray-500 uppercase">ลูกค้าสมาชิก</p>
                <h3 class="text-2xl font-extrabold text-gray-800 mt-1">{{ number_format($totalCustomers) }} คน</h3>
            </div>
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>

    <!-- Chart & Low Stock Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart.js Sales Graph -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-4">
            <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                <i class="fa-solid fa-chart-column text-indigo-600"></i> แนวโน้มยอดขาย 7 วันล่าสุด (บาท)
            </h2>
            <div class="h-64">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- Low Stock Alert Table (stock <= 5) -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-4 flex flex-col justify-between">
            <div>
                <h2 class="text-base font-bold text-gray-800 flex items-center gap-2 border-b border-gray-200 pb-3">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500"></i> สินค้าใกล้หมดสต็อก (&le; 5 ชิ้น)
                </h2>

                @if($lowStockProducts->count() > 0)
                    <div class="divide-y divide-gray-200 max-h-60 overflow-y-auto mt-2">
                        @foreach($lowStockProducts as $product)
                            <div class="py-2.5 flex items-center justify-between text-xs">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $product->name }}</p>
                                    <p class="text-gray-400">฿{{ number_format($product->price, 2) }}</p>
                                </div>
                                <span class="bg-red-100 text-red-800 font-extrabold px-2.5 py-1 rounded">
                                    เหลือ {{ $product->stock }} ชิ้น
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-gray-400 text-xs py-8">
                        <i class="fa-solid fa-check-circle text-2xl text-green-500 mb-2"></i>
                        <p>ไม่มีสินค้าที่สต็อกใกล้หมด</p>
                    </div>
                @endif
            </div>

            <a href="{{ route('admin.products.index') }}" class="block text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold py-2 rounded transition">
                ไปที่หน้าจัดการสต็อกสินค้า
            </a>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-sm font-bold text-gray-800">
                <i class="fa-solid fa-clock text-indigo-600 mr-1"></i> ออเดอร์ล่าสุด
            </h2>
            <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:underline text-xs font-semibold">
                ดูออเดอร์ทั้งหมด &rarr;
            </a>
        </div>

        <table class="w-full text-left border-collapse text-xs">
            <thead class="bg-gray-100 text-gray-600 uppercase font-semibold">
                <tr>
                    <th class="p-3">เลขที่ออเดอร์</th>
                    <th class="p-3">ลูกค้า</th>
                    <th class="p-3">ยอดรวม</th>
                    <th class="p-3 text-center">สถานะ</th>
                    <th class="p-3">วันที่สั่ง</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($recentOrders as $order)
                    <tr>
                        <td class="p-3 font-bold text-indigo-600">{{ $order->order_number }}</td>
                        <td class="p-3 text-gray-800">{{ $order->user->name }}</td>
                        <td class="p-3 font-bold">฿{{ number_format($order->total_amount, 2) }}</td>
                        <td class="p-3 text-center">
                            <span class="px-2 py-0.5 rounded font-semibold text-[10px] uppercase
                                {{ $order->status === 'paid' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="p-3 text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'ยอดขาย (บาท)',
                    data: {!! json_encode($chartTotals) !!},
                    backgroundColor: 'rgba(79, 70, 229, 0.7)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) { return '฿' + value; }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
