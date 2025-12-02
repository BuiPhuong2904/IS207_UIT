@extends('user.layouts.user_layout')
@section('title', 'Đặt hàng thành công - GRYND')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-4xl font-['Roboto']">
    <div class="bg-white rounded-xl shadow-xl p-8 text-center">
        
        {{-- ICON & TIÊU ĐỀ --}}
        <div class="mb-8">
            <svg class="w-20 h-20 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h1 class="text-4xl font-bold text-gray-800 mt-4">Thanh toán thành công!</h1>
            <p class="text-lg text-gray-600 mt-2">Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của GRYND.</p>
        </div>

        {{-- TRƯỜNG HỢP 1: MUA GÓI TẬP (Membership)     --}}
        @if(isset($type) && $type == 'membership' && isset($registration))
            <div class="bg-green-50 rounded-lg p-6 text-left border border-green-200">
                <h2 class="text-2xl font-bold mb-4 text-green-800">Gói tập đã kích hoạt</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Mã đăng ký:</p>
                        <p class="text-xl font-mono font-bold text-gray-900">{{ $order_code }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Tên gói:</p>
                        <p class="text-xl font-bold text-gray-900">{{ $registration->package->package_name ?? 'Gói tập' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Ngày bắt đầu:</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($registration->start_date)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Ngày kết thúc:</p>
                        <p class="font-medium">{{ \Carbon\Carbon::parse($registration->end_date)->format('d/m/Y') }}</p>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-green-200">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                        Trạng thái: Đang chờ thanh toán / Kích hoạt
                    </span>
                </div>
            </div>

        {{-- TRƯỜNG HỢP 2: MUA SẢN PHẨM (Product)       --}}
        @elseif(isset($type) && $type == 'product' && isset($order))
            <div class="bg-gray-50 rounded-lg p-6 text-left border border-gray-200">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Thông tin đơn hàng</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-600">Mã đơn hàng:</span>
                        <span class="text-blue-600 font-mono font-bold text-lg">{{ $order->order_code }}</span>
                    </div>
                    
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-600">Tổng tiền:</span>
                        <span class="text-xl font-bold text-red-600">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</span>
                    </div>

                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-600">Phương thức thanh toán:</span>
                        <span class="font-medium text-gray-900">
                            {{ $order->payment->method ?? 'Thanh toán khi nhận hàng (COD)' }}
                        </span>
                    </div>

                    <div>
                        <span class="text-gray-600 block mb-1">Địa chỉ giao hàng:</span>
                        <span class="font-medium text-gray-900 block bg-white p-3 rounded border border-gray-200">
                            {{ $order->shipping_address }}
                        </span>
                    </div>
                </div>
            </div>

        {{-- TRƯỜNG HỢP MẶC ĐỊNH (Lỗi/Không tìm thấy)   --}}
        @else
            <div class="bg-yellow-50 rounded-lg p-6 text-center border border-yellow-200">
                <p class="text-yellow-800">Không tìm thấy thông tin đơn hàng hoặc gói tập.</p>
                <p class="text-sm text-yellow-600 mt-1">Mã giao dịch: <strong>{{ $order_code ?? 'N/A' }}</strong></p>
            </div>
        @endif

        {{-- BUTTONS --}}
        <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('home') }}" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg">
                Về trang chủ
            </a>
            
            @if(isset($type) && $type == 'product')
                <a href="{{ route('order_history') }}" class="bg-white text-blue-600 border border-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-blue-50 transition">
                    Xem lịch sử đơn hàng
                </a>
            @elseif(isset($type) && $type == 'membership')
                <a href="{{ route('my_packages') }}" class="bg-white text-blue-600 border border-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-blue-50 transition">
                    Xem gói tập của tôi
                </a>
            @endif
        </div>
    </div>
</div>
@endsection