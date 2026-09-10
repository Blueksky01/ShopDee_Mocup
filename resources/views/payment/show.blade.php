@extends('layouts.app')

@section('title', 'จำลองการชำระเงิน - ShopDee')

@section('content')
<div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md border border-gray-200 mt-6 space-y-6">
    <div class="text-center space-y-2">
        <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto text-2xl font-bold">
            <i class="fa-solid fa-file-invoice-dollar"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">จำลองการชำระเงิน (Mock Payment)</h1>
        <p class="text-sm text-gray-500">เลขที่คำสั่งซื้อ: <strong class="text-indigo-600">{{ $order->order_number }}</strong></p>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-2 text-sm">
        <div class="flex justify-between">
            <span class="text-gray-600">วิธีชำระเงิน:</span>
            <span class="font-medium text-gray-800 uppercase">{{ $order->payment_method }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-600">ที่อยู่จัดส่ง:</span>
            <span class="font-medium text-gray-800 text-right max-w-xs truncate">{{ $order->shipping_address }}</span>
        </div>
        <div class="flex justify-between border-t border-gray-200 pt-2 text-base font-extrabold text-indigo-600">
            <span>จำนวนเงินที่ต้องชำระ:</span>
            <span>฿{{ number_format($order->total_amount, 2) }}</span>
        </div>
    </div>

    <div class="border-t border-gray-200 pt-4 space-y-4">
        <h3 class="text-sm font-bold text-gray-700 text-center">เลือกผลลัพธ์การทดสอบเพื่อจำลองระบบ (Demo Controls):</h3>

        <form action="{{ route('payment.process', $order) }}" method="POST" class="grid grid-cols-2 gap-4">
            @csrf
            <button type="submit" name="simulated_result" value="success"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg shadow transition text-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-check text-lg"></i> ชำระเงินสำเร็จ (Success)
            </button>

            <button type="submit" name="simulated_result" value="failed"
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg shadow transition text-sm flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-xmark text-lg"></i> ชำระเงินล้มเหลว (Failed)
            </button>
        </form>

        <p class="text-xs text-center text-gray-400">
            * หากเลือก "ชำระเงินล้มเหลว" ระบบจะเปลี่ยนสถานะเป็น Cancelled และคืนสต็อกสินค้าทั้งหมดกลับสู่ระบบโดยอัตโนมัติ
        </p>
    </div>
</div>
@endsection
