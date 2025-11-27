@extends('user.layouts.user_layout')

@section('title', 'GRYND - Thanh toán')

@section('content')

{{-- DỮ LIỆU GIẢ (MOCK DATA) ĐƯỢC CHÈN TRỰC TIẾP VÀO BLADE --}}
<?php
// Dữ liệu sản phẩm hiển thị trên hóa đơn - ĐÃ CẬP NHẬT THÊM 'quantity'
$cart_items = [
    ['name' => 'Tạ tập gym', 'price' => 100000, 'quantity' => 1, 'image_url' => 'https://via.placeholder.com/20x20/FF0000/FFFFFF?text=TA'],
    ['name' => 'Đồ tập gym', 'price' => 100000, 'quantity' => 2, 'image_url' => 'https://via.placeholder.com/20x20/000000/FFFFFF?text=DO'],
];

// Dữ liệu tóm tắt thanh toán - TÍNH TOÁN LẠI
$subtotal = array_sum(array_map(function($item) {
    return $item['price'] * $item['quantity'];
}, $cart_items));

$discount = 20000;
$shipping_fee = 30000;
$total = $subtotal - $discount + $shipping_fee;

// Dữ liệu phương thức thanh toán
$payment_methods = [
    'Thẻ nội địa' => 'napas_only', 
    'Thẻ quốc tế' => 'visa_master_jcb', 
    'Ví MoMo' => 'momo',
    'Internet Banking' => 'vnpay',
];

// Mảng chứa URL logo CHÍNH XÁC CÁC LINK GOOGLE BẠN ĐÃ YÊU CẦU
$logos = [
    // ⚠️ CÁC LINK NÀY CÓ KHẢ NĂNG KHÔNG HIỂN THỊ HÌNH ẢNH
    'napas' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.movi.vn%2Fen%2Fldp&psig=AOvVaw2oSPCAOWjDa-9Pc3IqnpYT&ust=1764143662749000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCJC0urXpjJEDFQAAAAAdAAAAABAE',
    'visa' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fcdnlogo.com%2Fvi%2Flogo%2Fvisa_32372.html&psig=AOvVaw1ZnT1hBFy5z_d5fB83aeap&ust=1764143689432000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCNDInsPpjJEDFQAAAAAdAAAAABAE',
    'mastercard' => 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.pngegg.com%2Fen%2Fpng-ecupr&psig=AOvVaw1yJj2eb3pHzWNCv1FTdaFU&ust=1764143724026000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCJi4xdHpjJEDFQAAAAAdAAAAABAL',
    
    // Giữ nguyên các logo không được cung cấp
    'jcb' => 'https://i.imgur.com/tH6N07I.png', 
    'momo' => 'https://i.imgur.com/6v3N4w1.png', 
    'vnpay' => 'https://i.imgur.com/w9cQf3h.png', 
];
?>

<div class="container mx-auto px-4 py-8 font-['Roboto']">

    {{-- NAVIGATION / BREADCRUMB --}}
    <nav class="flex text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center"><a href="#" class="hover:text-gray-700">Trang Chủ</a></li>
            <li><span class="mx-1">/</span><a href="#" class="hover:text-gray-700">Giỏ hàng</a></li>
            <li><span class="mx-1">/</span><span class="font-semibold text-gray-900">Hóa đơn</span></li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-gray-900 mb-8 font-['Montserrat']">Chi tiết hóa đơn</h1>

    {{-- FORM CHÍNH: Bao gồm cả thông tin khách hàng và chi tiết hóa đơn --}}
    <form class="grid grid-cols-1 lg:grid-cols-3 gap-8 bg-white p-6 rounded-lg shadow-xl border border-gray-100" method="POST" action="/checkout">
        @csrf {{-- Thêm CSRF token nếu đây là form POST --}}

        {{-- CỘT TRÁI (2/3): THÔNG TIN KHÁCH HÀNG --}}
        <main class="lg:col-span-2 space-y-6">
            <h2 class="text-2xl font-bold text-gray-900 border-b pb-2 mb-4">Thông tin giao hàng</h2>

            {{-- Trường Tên công ty đã được loại bỏ --}}
            <input type="text" name="full_name" placeholder="Họ và tên *" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500" required>
            <input type="text" name="address" placeholder="Địa chỉ *" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500" required>
            <input type="text" name="apartment_details" placeholder="Thông tin căn hộ, số tầng (tùy chọn)" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500">
            {{-- ĐÃ XÓA: <input type="text" name="city_province" placeholder="Thành phố/ Tỉnh *" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500" required> --}}
            <input type="tel" name="phone_number" placeholder="Số điện thoại *" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500" required>
            <input type="email" name="email" placeholder="Địa chỉ email *" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500" required>

            {{-- LƯU THÔNG TIN --}}
            <div class="flex items-center">
                <input id="save-info" type="checkbox" name="save_info" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                <label for="save-info" class="ml-2 text-sm font-medium text-gray-900">Lưu thông tin</label>
            </div>
        </main>

        {{-- CỘT PHẢI (1/3): TÓM TẮT ĐƠN HÀNG VÀ THANH TOÁN --}}
        <aside class="lg:col-span-1 border-l border-gray-200 lg:pl-6 space-y-4">
            <h2 class="text-2xl font-bold text-gray-900 border-b pb-2 mb-4">Tóm tắt đơn hàng</h2>

            {{-- KHỐI SẢN PHẨM - ĐÃ ĐIỀU CHỈNH VỊ TRÍ SỐ LƯỢNG --}}
            <div class="space-y-4 border-b border-gray-200 pb-4 mb-4">
                <p class="font-semibold text-gray-700">Sản phẩm:</p>
                @foreach ($cart_items as $item)
                <div class="flex justify-between items-start text-sm">
                    <div class="flex items-start space-x-2">
                        <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="w-8 h-8 object-cover rounded-sm border border-gray-200 mt-1">
                        
                        {{-- KHỐI TÊN VÀ SỐ LƯỢNG MỚI --}}
                        <div class="flex flex-col">
                            <span class="text-gray-900 font-medium">{{ $item['name'] }}</span>
                            {{-- THAY ĐỔI: SỐ LƯỢNG Ở DÒNG DƯỚI --}}
                            <span class="text-xs text-gray-500 mt-1"> x{{ $item['quantity'] }}</span>
                        </div>
                    </div>
                    {{-- HIỂN THỊ TỔNG GIÁ SẢN PHẨM (Giá * Số lượng) --}}
                    <span class="text-gray-700 mt-1">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>

            {{-- TỔNG KẾT --}}
            <div class="space-y-2 text-gray-700 border-b border-gray-200 pb-4 mb-4">
                <div class="flex justify-between items-center text-base">
                    <span>Tổng phụ</span>
                    <span class="font-semibold">{{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-base">
                    <span>Giảm giá</span>
                    <span class="font-semibold text-red-600">-{{ number_format($discount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-base">
                    <span>Phí vận chuyển</span>
                    <span class="font-semibold">{{ number_format($shipping_fee, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- TỔNG CỘNG --}}
            <div class="flex justify-between items-center text-xl font-bold text-gray-900 mb-6 border-b pb-4">
                <span>Tổng cộng</span>
                <span id="total_value">{{ number_format($total, 0, ',', '.') }} VNĐ</span>
            </div>

            {{-- PHƯƠNG THỨC THANH TOÁN --}}
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Phương thức thanh toán</h3>
            <div class="space-y-4">
                @foreach ($payment_methods as $method => $icon_class)
                <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="{{ $method }}" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" @if ($loop->first) checked @endif required>
                        <span class="ml-3 text-base font-medium text-gray-700">{{ $method }}</span>
                    </div>
                    {{-- LOGO THANH TOÁN --}}
                    <div class="flex space-x-1 items-center">
                        @if ($icon_class == 'napas_only')
                            {{-- Thẻ Nội Địa: Napas --}}
                            <img src="{{ $logos['napas'] }}" alt="Napas" class="h-5 object-contain">
                        @elseif ($icon_class == 'visa_master_jcb')
                            {{-- Thẻ Quốc Tế: Visa, Mastercard, JCB --}}
                            <img src="{{ $logos['visa'] }}" alt="Visa" class="h-5 object-contain">
                            <img src="{{ $logos['mastercard'] }}" alt="Mastercard" class="h-6 object-contain">
                            <img src="{{ $logos['jcb'] }}" alt="JCB" class="h-6 object-contain">
                        @elseif ($icon_class == 'momo')
                            {{-- Ví MoMo --}}
                            <img src="{{ $logos['momo'] }}" alt="MoMo" class="h-6 object-contain">
                        @elseif ($icon_class == 'vnpay')
                            {{-- VNPay --}}
                            <img src="{{ $logos['vnpay'] }}" alt="VNPay" class="h-6 object-contain">
                        @endif
                    </div>
                </label>
                @endforeach
            </div>

            {{-- NÚT ĐẶT HÀNG --}}
            <button type="submit" class="mt-8 w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white text-lg font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                Đặt hàng
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </aside>
    </form>
</div>

@endsection