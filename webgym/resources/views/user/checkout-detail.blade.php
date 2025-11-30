@extends('user.layouts.user_layout')
@section('title', 'GRYND - Thanh toán')

@section('content')
<div class="container mx-auto px-4 py-8 font-['Roboto']">
    <nav class="flex text-sm text-gray-500 mb-8">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li><a href="{{ url('/') }}" class="hover:text-gray-700">Trang Chủ</a></li>
            <li><span class="mx-1">/</span><a href="{{ route('checkout') }}" class="hover:text-gray-700">Giỏ hàng</a></li>
            <li><span class="mx-1">/</span><span class="font-semibold text-gray-900">Hóa đơn</span></li>
        </ol>
    </nav>

    <h1 class="text-3xl font-bold text-gray-900 mb-8 font-['Montserrat']">Chi tiết hóa đơn</h1>

    {{-- Form gửi thẳng tới OrderController@store --}}
    <form class="grid grid-cols-1 lg:grid-cols-3 gap-8 bg-white p-6 rounded-lg shadow-xl border"
          method="POST"
          action="{{ route('order.store') }}"
          id="checkout-form">
        @csrf

        {{-- BẮT BUỘC PHẢI CÓ 3 hidden này để controller xử lý --}}
        <input type="hidden" name="cart_items"       value="{{ old('cart_items', json_encode($cart_items)) }}">
        <input type="hidden" name="promotion_code"   value="{{ old('promotion_code', $promotion_code) }}">
        <input type="hidden" name="total_amount"     value="{{ $total_amount }}">

        <!-- Thông tin giao hàng -->
        <main class="lg:col-span-2 space-y-6">
            <h2 class="text-2xl font-bold border-b pb-2">Thông tin giao hàng</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="full_name" placeholder="Họ và tên *" class="w-full px-4 py-3 border rounded-lg" value="{{ old('full_name') }}" required>
                <input type="tel" name="phone_number" placeholder="Số điện thoại *" class="w-full px-4 py-3 border rounded-lg" value="{{ old('phone_number') }}" required>
            </div>

            <input type="text" name="address" placeholder="Địa chỉ chi tiết (số nhà, đường, phường/xã) *" class="w-full px-4 py-3 border rounded-lg" value="{{ old('address') }}" required>
            <input type="text" name="apartment_details" placeholder="Căn hộ, tầng, block (không bắt buộc)" class="w-full px-4 py-3 border rounded-lg" value="{{ old('apartment_details') }}">

            <input type="email" name="email" placeholder="Email nhận hóa đơn *" class="w-full px-4 py-3 border rounded-lg" value="{{ old('email') }}" required>

            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="save_info" class="w-4 h-4 text-blue-600 rounded" {{ old('save_info') ? 'checked' : '' }}>
                <span class="ml-2 text-sm">Lưu thông tin cho lần mua sau</span>
            </label>
        </main>

        <!-- Tóm tắt đơn hàng + Phương thức thanh toán -->
        <aside class="lg:col-span-1 border-l pl-6 space-y-6">
            <h2 class="text-2xl font-bold border-b pb-2">Tóm tắt đơn hàng</h2>

            <div class="space-y-4 border-b pb-4 max-h-96 overflow-y-auto">
                @foreach($cart_items as $item)
                <div class="flex justify-between text-sm">
                    <div class="flex space-x-3">
                        <img src="{{ $item['image_url'] ?? asset('images/no-image.jpg') }}" class="w-12 h-12 object-cover rounded border">
                        <div>
                            <div class="font-medium">{{ $item['name'] }}</div>
                            @if(!empty($item['size']) || !empty($item['color']))
                            <div class="text-xs text-gray-500">
                                {{ $item['size'] ?? '' }}{{ ($item['size'] && $item['color']) ? ' • ' : '' }}{{ $item['color'] ?? '' }}
                            </div>
                            @endif
                            <div class="text-xs text-gray-500">x{{ $item['quantity'] }}</div>
                        </div>
                    </div>
                    <div class="font-medium whitespace-nowrap">
                        {{ number_format($item['final_price'] * $item['quantity'], 0, ',', '.') }}đ
                    </div>
                </div>
                @endforeach
            </div>

            <div class="space-y-2 text-gray-700">
                <div class="flex justify-between"><span>Tổng phụ</span><span>{{ number_format($subtotal_amount) }}đ</span></div>
                @if($item_discount_total > 0)
                <div class="flex justify-between text-red-600"><span>Giảm giá sản phẩm</span><span>-{{ number_format($item_discount_total) }}đ</span></div>
                @endif
                @if($promotion_discount > 0)
                <div class="flex justify-between text-green-600 font-medium">
                    <span>Mã giảm giá {{ $promotion_code }}</span>
                    <span>-{{ number_format($promotion_discount) }}đ</span>
                </div>
                @endif
                <div class="flex justify-between"><span>Phí vận chuyển</span><span>{{ number_format($shipping_fee) }}đ</span></div>

                <div class="flex justify-between text-xl font-bold pt-4 border-t">
                    <span>Tổng cộng</span>
                    <span class="text-blue-600">{{ number_format($total_amount) }}đ</span>
                </div>
            </div>

            @if($promo_message)
            <div class="text-sm p-3 rounded-lg {{ $promotion_discount > 0 ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                {{ $promo_message }}
            </div>
            @endif

            <!-- PHƯƠNG THỨC THANH TOÁN -->
            <h3 class="text-lg font-semibold mt-6 mb-3">Phương thức thanh toán</h3>
            <div class="space-y-3">
                <label class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition {{ old('payment_method') === 'momo' ? 'ring-2 ring-blue-500 bg-blue-50' : '' }}">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="momo" class="w-5 h-5 text-blue-600" {{ old('payment_method', 'momo') === 'momo' ? 'checked' : '' }}>
                        <span class="ml-3 font-medium">Ví MoMo</span>
                    </div>
                    <img src="https://i.imgur.com/6v3N4w1.png" alt="MoMo" class="h-9">
                </label>

                <label class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition {{ old('payment_method') === 'cod' ? 'ring-2 ring-blue-500 bg-blue-50' : '' }}">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="cod" class="w-5 h-5 text-blue-600" {{ old('payment_method') === 'cod' ? 'checked' : '' }}>
                        <span class="ml-3 font-medium">Thanh toán khi nhận hàng (COD)</span>
                    </div>
                    <img src="https://via.placeholder.com/100x36?text=COD" alt="COD" class="h-9"> <!-- Thay bằng icon COD nếu có -->
                </label>

                <label class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition {{ old('payment_method') === 'vnpay' ? 'ring-2 ring-blue-500 bg-blue-50' : '' }}">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="vnpay" class="w-5 h-5 text-blue-600" {{ old('payment_method') === 'vnpay' ? 'checked' : '' }}>
                        <span class="ml-3 font-medium">VNPay / Thẻ ATM - Internet Banking</span>
                    </div>
                    <img src="https://i.imgur.com/w9cQf3h.png" alt="VNPay" class="h-9">
                </label>
            </div>

            <!-- Nút hoàn tất -->
            <button type="submit" class="mt-8 w-full py-5 bg-blue-600 text-white text-xl font-bold rounded-lg hover:bg-blue-700 shadow-lg transition transform hover:scale-105">
                Hoàn tất đặt hàng
            </button>

            <p class="text-xs text-center text-gray-500 mt-4">
                Bằng việc đặt hàng, bạn đã đồng ý với <a href="#" class="underline">điều khoản dịch vụ</a> của GRYND.
            </p>
        </aside>
    </form>
</div>
@endsection
