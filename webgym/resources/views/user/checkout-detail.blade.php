@extends('user.layouts.user_layout')
@section('title', 'GRYND - Thanh toán')

@section('content')
<div class="container mx-auto px-4 py-8 font-['Roboto']">

    {{-- BREADCRUMB --}}
    <nav class="flex text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center"><a href="{{ url('/') }}" class="hover:text-gray-700">Trang Chủ</a></li>
            <li><span class="mx-1">/</span><a href="{{ route('checkout') }}" class="hover:text-gray-700">Giỏ hàng</a></li>
            <li><span class="mx-1">/</span><span class="font-semibold text-gray-900">Hóa đơn</span></li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-gray-900 mb-8 font-['Montserrat']">Chi tiết hóa đơn</h1>

    {{-- FORM CHÍNH --}}
    <form class="grid grid-cols-1 lg:grid-cols-3 gap-8 bg-white p-6 rounded-lg shadow-xl border border-gray-100"
          method="POST"
          action="{{ route('order.store') }}"
          id="checkout-form">
        @csrf

        {{-- HIDDEN INPUTS --}}
        <input type="hidden" name="cart_items"       value="{{ old('cart_items', json_encode($cart_items)) }}">
        <input type="hidden" name="promotion_code"   value="{{ old('promotion_code', $promotion_code) }}">
        <input type="hidden" name="total_amount"     value="{{ $total_amount }}">

        {{-- CỘT TRÁI: THÔNG TIN KHÁCH HÀNG --}}
        <main class="lg:col-span-2 space-y-6">
            <h2 class="text-2xl font-bold text-gray-900 border-b pb-2 mb-4">Thông tin giao hàng</h2>

            <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Họ và tên *" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500" required>
            
            <input type="text" name="address" value="{{ old('address') }}" placeholder="Địa chỉ chi tiết (số nhà, đường, phường/xã) *" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500" required>
            
            <input type="text" name="apartment_details" value="{{ old('apartment_details') }}" placeholder="Thông tin căn hộ, số tầng (tùy chọn)" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500">
            
            <input type="tel" name="phone_number" value="{{ old('phone_number') }}" placeholder="Số điện thoại *" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500" required>
            
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Địa chỉ email *" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500" required>

            <div class="flex items-center">
                <input id="save-info" type="checkbox" name="save_info" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" {{ old('save_info') ? 'checked' : '' }}>
                <label for="save-info" class="ml-2 text-sm font-medium text-gray-900">Lưu thông tin cho lần mua sau</label>
            </div>
        </main>

        {{-- CỘT PHẢI: TÓM TẮT ĐƠN HÀNG --}}
        <aside class="lg:col-span-1 border-l border-gray-200 lg:pl-6 space-y-4">
            <h2 class="text-2xl font-bold text-gray-900 border-b pb-2 mb-4">Tóm tắt đơn hàng</h2>

            {{-- DANH SÁCH SẢN PHẨM --}}
            <div class="space-y-4 border-b border-gray-200 pb-4 mb-4 max-h-96 overflow-y-auto">
                <p class="font-semibold text-gray-700">Sản phẩm:</p>
                @foreach($cart_items as $item)
                <div class="flex justify-between items-start text-sm">
                    <div class="flex items-start space-x-2">
                        <img src="{{ $item['image_url'] ?? asset('images/no-image.jpg') }}" alt="{{ $item['name'] }}" class="w-8 h-8 object-cover rounded-sm border border-gray-200 mt-1">
                        
                        <div class="flex flex-col">
                            <span class="text-gray-900 font-medium">{{ $item['name'] }}</span>
                            @if(!empty($item['size']) || !empty($item['color']))
                            <span class="text-xs text-gray-500">
                                {{ $item['size'] ?? '' }}{{ ($item['size'] && $item['color']) ? ' • ' : '' }}{{ $item['color'] ?? '' }}
                            </span>
                            @endif
                            <span class="text-xs text-gray-500 mt-1"> x{{ $item['quantity'] }}</span>
                        </div>
                    </div>
                    <span class="text-gray-700 mt-1 font-medium">
                        {{ number_format($item['final_price'] * $item['quantity'], 0, ',', '.') }}đ
                    </span>
                </div>
                @endforeach
            </div>

            {{-- TỔNG TIỀN --}}
            <div class="space-y-2 text-gray-700 border-b border-gray-200 pb-4 mb-4">
                <div class="flex justify-between items-center text-base">
                    <span>Tổng phụ</span>
                    <span class="font-semibold">{{ number_format($subtotal_amount) }}đ</span>
                </div>
                
                @if($item_discount_total > 0)
                <div class="flex justify-between items-center text-base">
                    <span>Giảm giá sản phẩm</span>
                    <span class="font-semibold text-red-600">-{{ number_format($item_discount_total) }}đ</span>
                </div>
                @endif

                @if($promotion_discount > 0)
                <div class="flex justify-between items-center text-base">
                    <span>Mã giảm giá ({{ $promotion_code }})</span>
                    <span class="font-semibold text-green-600">-{{ number_format($promotion_discount) }}đ</span>
                </div>
                @endif

                <div class="flex justify-between items-center text-base">
                    <span>Phí vận chuyển</span>
                    <span class="font-semibold">{{ number_format($shipping_fee) }}đ</span>
                </div>
            </div>

            {{-- TỔNG CỘNG --}}
            <div class="flex justify-between items-center text-xl font-bold text-gray-900 mb-6 border-b pb-4">
                <span>Tổng cộng</span>
                <span class="text-blue-600">{{ number_format($total_amount) }}đ</span>
            </div>

            @if($promo_message)
            <div class="text-xs p-3 rounded-lg mb-4 {{ $promotion_discount > 0 ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                {{ $promo_message }}
            </div>
            @endif

            {{-- PHƯƠNG THỨC THANH TOÁN --}}
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Phương thức thanh toán</h3>
            <div class="space-y-4">
                
                {{-- Ví MoMo --}}
                <label class="payment-option flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-all {{ old('payment_method') === 'momo' ? 'ring-1 ring-blue-500 bg-blue-50 border-blue-500' : '' }}">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="momo" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ old('payment_method') === 'momo' ? 'checked' : '' }}>
                        <span class="ml-3 text-base font-medium text-gray-700">Ví MoMo</span>
                    </div>
                    <img src="https://i.imgur.com/6v3N4w1.png" alt="MoMo" class="h-6 object-contain">
                </label>

                {{-- COD --}}
                <label class="payment-option flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-all {{ old('payment_method') === 'cod' ? 'ring-1 ring-blue-500 bg-blue-50 border-blue-500' : '' }}">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="cod" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ old('payment_method') === 'cod' ? 'checked' : '' }}>
                        <span class="ml-3 text-base font-medium text-gray-700">Thanh toán khi nhận hàng (COD)</span>
                    </div>
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </label>

                {{-- VNPay --}}
                <label class="payment-option flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-all {{ old('payment_method') === 'vnpay' ? 'ring-1 ring-blue-500 bg-blue-50 border-blue-500' : '' }}">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="vnpay" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" {{ old('payment_method') === 'vnpay' ? 'checked' : '' }}>
                        <span class="ml-3 text-base font-medium text-gray-700">VNPay / ATM / Banking</span>
                    </div>
                    <img src="https://i.imgur.com/w9cQf3h.png" alt="VNPay" class="h-6 object-contain">
                </label>

            </div>

            {{-- NÚT ĐẶT HÀNG --}}
            <button type="submit" class="mt-8 w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white text-lg font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                Hoàn tất đặt hàng
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
            
            <p class="text-xs text-center text-gray-500 mt-4">
                Bằng việc đặt hàng, bạn đã đồng ý với <a href="#" class="underline hover:text-blue-600">điều khoản dịch vụ</a> của GRYND.
            </p>
        </aside>
    </form>
</div>

{{-- SCRIPT XỬ LÝ HIỆU ỨNG CLICK --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentInputs = document.querySelectorAll('input[name="payment_method"]');
        
        paymentInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Reset tất cả các label
                document.querySelectorAll('.payment-option').forEach(label => {
                    label.classList.remove('ring-1', 'ring-blue-500', 'bg-blue-50', 'border-blue-500');
                    label.classList.add('border-gray-200');
                });

                // Active label được chọn
                if (this.checked) {
                    const activeLabel = this.closest('label');
                    activeLabel.classList.remove('border-gray-200');
                    activeLabel.classList.add('ring-1', 'ring-blue-500', 'bg-blue-50', 'border-blue-500');
                }
            });
        });
    });
</script>
@endsection
