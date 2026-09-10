@extends('layouts.app')

@section('title', 'ยืนยันสั่งซื้อสินค้า - ShopDee')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
        <i class="fa-solid fa-credit-card text-indigo-600"></i> ยืนยันการสั่งซื้อสินค้า
    </h1>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @csrf

        <!-- Shipping & Payment Form -->
        <div class="md:col-span-2 space-y-6">
            <!-- Shipping Address -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-4">
                <h2 class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                    <i class="fa-solid fa-location-dot text-indigo-600 mr-1"></i> ที่อยู่สำหรับจัดส่งสินค้า
                </h2>

                <div>
                    <label for="shipping_address" class="block text-sm font-medium text-gray-700">ที่อยู่อย่างละเอียด (บ้านเลขที่, ถนน, แขวง/ตำบล, เขต/อำเภอ, จังหวัด, รหัสไปรษณีย์)</label>
                    <textarea name="shipping_address" id="shipping_address" rows="4" required placeholder="กรอกที่อยู่สำหรับจัดส่งสินค้า..."
                        class="mt-1 block w-full p-3 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">123/45 ถนนสุขุมวิท แขวงคลองเตย เขตคลองเตย กรุงเทพมหานคร 10110</textarea>
                    @error('shipping_address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Payment Method -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 space-y-4">
                <h2 class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">
                    <i class="fa-solid fa-wallet text-indigo-600 mr-1"></i> เลือกวิธีชำระเงิน
                </h2>

                <div class="space-y-3">
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-indigo-50 transition">
                        <input type="radio" name="payment_method" value="bank_transfer" checked class="text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-3 font-medium text-gray-800 text-sm"><i class="fa-solid fa-building-columns mr-2 text-indigo-600"></i>โอนเงินผ่านธนาคาร (Bank Transfer)</span>
                    </label>

                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-indigo-50 transition">
                        <input type="radio" name="payment_method" value="credit_card" class="text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-3 font-medium text-gray-800 text-sm"><i class="fa-solid fa-credit-card mr-2 text-indigo-600"></i>บัตรเครดิต / เดบิตจำลอง (Mock Credit Card)</span>
                    </label>

                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-indigo-50 transition">
                        <input type="radio" name="payment_method" value="cod" class="text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-3 font-medium text-gray-800 text-sm"><i class="fa-solid fa-hand-holding-dollar mr-2 text-indigo-600"></i>เก็บเงินปลายทาง (Cash on Delivery)</span>
                    </label>
                </div>
                @error('payment_method')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Order Summary & Submit Button -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 h-fit space-y-4">
            <h2 class="text-lg font-bold text-gray-800 border-b border-gray-200 pb-2">สรุปคำสั่งซื้อ</h2>

            <div class="space-y-3 text-sm max-h-48 overflow-y-auto pr-1">
                @foreach($cart->items as $item)
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-medium text-gray-700 truncate max-w-[150px]">{{ $item->product->name }} x{{ $item->quantity }}</span>
                        <span class="font-bold text-gray-800">฿{{ number_format($item->product->price * $item->quantity, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="border-t border-gray-200 pt-3 space-y-2 text-sm">
                <div class="flex justify-between font-extrabold text-lg text-indigo-600">
                    <span>ยอดชำระสุทธิ:</span>
                    <span>฿{{ number_format($subtotal, 2) }}</span>
                </div>
            </div>

            <!-- Double-click Protection Button -->
            <button type="submit" id="submit-btn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-check"></i> ยืนยันสั่งซื้อสินค้า
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('checkout-form').addEventListener('submit', function() {
        const btn = document.getElementById('submit-btn');
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i>กำลังประมวลผลคำสั่งซื้อ...';
    });
</script>
@endsection
