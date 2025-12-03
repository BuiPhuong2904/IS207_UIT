@extends('user.layouts.user_layout')
@section('title', 'Đặt hàng thành công - GRYND')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-4xl">
    <div class="bg-white rounded-xl shadow-xl p-8 text-center">
        <div class="mb-8">
            <svg class="w-20 h-20 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h1 class="text-4xl font-bold text-gray-800 mt-4">Đặt hàng thành công!</h1>
            <p class="text-lg text-gray-600 mt-2">Cảm ơn bạn đã tin tưởng GRYND</p>
        </div>

        <div class="bg-gray-50 rounded-lg p-6 text-left">
            <h2 class="text-2xl font-bold mb-4">Thông tin đơn hàng</h2>
            <p><strong>Mã đơn hàng:</strong> <span class="text-blue-600 font-mono text-xl">{{ $order->order_code }}</span></p>
            <p><strong>Phương thức thanh toán:</strong> Thanh toán khi nhận hàng (COD)</p>
            <p><strong>Tổng tiền:</strong> <span class="text-2xl font-bold text-red-600">{{ number_format($order->total_amount) }}đ</span></p>
            <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
        </div>

        @if($order->details->count() > 0)
        <div class="mt-8 bg-gray-50 rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4">Sản phẩm đã đặt</h3>
            @foreach($order->details as $detail)
            <div class="flex justify-between py-2 border-b last:border-0">
                <span>{{ $detail->product?->product?->product_name ?? 'Sản phẩm' }} × {{ $detail->quantity }}</span>
                <span>{{ number_format($detail->final_price * $detail->quantity) }}đ</span>
            </div>
            @endforeach
        </div>
        @endif

        @if($registrations->count() > 0)
        <div class="mt-8 bg-green-50 rounded-lg p-6 border border-green-200">
            <h3 class="text-xl font-bold mb-4 text-green-800">Gói tập đã kích hoạt thành công!</h3>
            @foreach($registrations as $reg)
            <div class="bg-white rounded-lg p-4 mb-3 shadow">
                <p class="font-semibold text-lg">{{ $reg->package->package_name }}</p>
                <p class="text-sm text-gray-600">
                    Từ: {{ $reg->start_date->format('d/m/Y') }} →
                    Đến: {{ $reg->end_date->format('d/m/Y') }}
                </p>
                <span class="inline-block mt-2 px-3 py-1 bg-green-600 text-white text-xs rounded-full">Đã kích hoạt</span>
            </div>
            @endforeach
        </div>
        @endif

        <div class="mt-10">
            <a href="{{ route('home') }}" class="bg-blue-600 text-white px-8 py-4 rounded-lg font-bold hover:bg-blue-700 inline-block">
                Về trang chủ
            </a>
            <a href="{{ route('order_history') }}" class="ml-4 text-blue-600 underline">
                Xem lịch sử đơn hàng →
            </a>
        </div>
    </div>
</div>
@endsection
