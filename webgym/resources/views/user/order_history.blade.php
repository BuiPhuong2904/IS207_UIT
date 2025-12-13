@extends('user.layouts.user_dashboard')

@section('title', 'Lịch sử đơn hàng - GRYND')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold text-black font-montserrat">Đơn hàng của bạn</h1>
    <p class="text-sm text-gray-500 mt-1 font-open-sans">Quản lý đơn hàng cá nhân</p>
</div>

{{-- TAB TRẠNG THÁI --}}
<div class="bg-white rounded-2xl shadow-sm p-3 border border-gray-100 mb-6 font-open-sans">
    <div class="flex w-full gap-2 text-sm font-semibold text-center text-gray-500 overflow-x-auto">
        @foreach ($statusLabels as $slug => $name)
            <a href="?status={{ $slug }}" 
               class="py-2 px-1 flex-1 transition duration-150 rounded-full whitespace-nowrap
                    @if (request('status', 'pending_confirmation') == $slug)
                        text-blue-600 bg-blue-100 
                    @else hover:bg-gray-50
                    @endif">
                {{ $name }}
            </a>
        @endforeach
    </div>
</div>

<div class="font-open-sans">
    @if (isset($orders) && $orders->count() > 0)
        @foreach ($orders as $order)
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mb-4">
                
                {{-- HEADER: Mã đơn & Ngày --}}
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-dashed border-gray-200">
                    <span class="font-bold text-gray-700">
                        Mã đơn hàng: {{ $order->order_code ?? '#'.$order->id }}
                    </span>
                    <span class="text-sm text-gray-500">
                        Ngày đặt hàng: {{ \Carbon\Carbon::parse($order->created_at ?? $order->order_date)->format('d/m/Y H:i') }}
                    </span>
                </div>

                {{-- BODY: Danh sách sản phẩm --}}
                @foreach ($order->details as $item)
                    @php
                        $variant = $item->product; 
                        $product = $variant?->product;
                        
                        // Xử lý ảnh
                        $detailImage = $variant?->image_url
                            ? (str_starts_with($variant->image_url, 'http')
                                ? $variant->image_url
                                : asset('storage/' . ltrim($variant->image_url, '/')))
                            : asset('images/no-image.png');

                        // --- LOGIC LINK SẢN PHẨM ---
                        $productUrl = '#';
                        if ($product && $product->slug) {
                             $productUrl = route('product.detail', ['slug' => $product->slug]); 
                        }
                    @endphp

                    <div class="flex items-start mb-4 gap-4">
                        {{-- Ảnh (Có link) --}}
                        <div class="w-16 h-16 bg-gray-100 rounded-md shrink-0 overflow-hidden border border-gray-200 group">
                            <a href="{{ $productUrl }}" target="_blank" class="block w-full h-full">
                                <img src="{{ $detailImage }}" 
                                     class="w-full h-full object-cover group-hover:opacity-90 transition-opacity" 
                                     alt="{{ $product?->product_name ?? 'Sản phẩm' }}"
                                     onerror="this.src='{{ asset('images/no-image.png') }}'">
                            </a>
                        </div>
                        
                        {{-- Thông tin --}}
                        <div class="flex-1">
                            {{-- Tên sản phẩm (Hover: In đậm + Màu đen) --}}
                            <p class="text-sm font-medium text-gray-800 line-clamp-2">
                                <a href="{{ $productUrl }}" target="_blank" 
                                   class="transition-all hover:text-black hover:font-bold">
                                    {{ $product?->product_name ?? 'Sản phẩm không còn tồn tại' }}
                                </a>
                            </p>
                            
                            <p class="text-xs text-gray-500 mt-0.5">
                                @if($variant)
                                    @if($variant->color){{ $variant->color }}@endif
                                    @if($variant->size){{ ($variant->color ? ' - ' : '') . $variant->size }}@endif
                                @endif
                            </p>

                            <div class="flex justify-between items-center mt-1">
                                <p class="text-xs text-gray-500">
                                    Số lượng: x{{ $item->quantity }}
                                </p>
                                <div class="text-right font-semibold text-gray-800 text-base">
                                    {{ number_format(($item->final_price ?? $item->unit_price) * $item->quantity, 0, ',', '.') }} ₫
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- FOOTER: Tổng tiền & Nút bấm --}}
                <div class="flex justify-between items-center pt-4 border-t border-gray-200 mt-4">
                    <div class="flex flex-col">
                        <p class="font-semibold text-lg text-black">
                            Tổng tiền: 
                            <span class="text-2xl text-red-700 font-bold">
                                {{ number_format($order->total_amount, 0, ',', '.') }} ₫
                            </span>
                        </p>
                        
                        {{-- HIỂN THỊ SỐ LƯỢNG SẢN PHẨM --}}
                        <span class="text-xs text-gray-500 mt-1">
                            {{ $order->details->sum('quantity') }} sản phẩm
                        </span>
                    </div>

                    {{-- LOGIC NÚT BẤM --}}
                    <div class="flex gap-3">
                        
                        {{-- TRƯỜNG HỢP 1: ĐÃ GIAO (completed) --}}
                        @if ($order->status == 'completed')
                            <a href="{{ route('product') }}" 
                               class="px-10 py-2 text-sm text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition duration-150 flex items-center justify-center whitespace-nowrap">
                                Mua lại
                            </a>
                            <button class="px-10 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-150 flex items-center justify-center whitespace-nowrap">
                                Đánh giá
                            </button>

                        {{-- TRƯỜNG HỢP 2: ĐÃ HỦY (cancelled) --}}
                        @elseif (request('status') == 'cancelled')
                            <a href="{{ route('product') }}" 
                               class="px-10 py-2 text-sm text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition duration-150 flex items-center justify-center whitespace-nowrap">
                                Mua lại
                            </a>

                        {{-- TRƯỜNG HỢP 3: CÁC TRẠNG THÁI KHÁC --}}
                        @else
                            <button class="px-10 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-150 flex items-center justify-center whitespace-nowrap">
                                Chi tiết đơn hàng
                            </button>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 text-center py-12 text-gray-500">
            <p class="text-lg">Không có đơn hàng nào trong trạng thái này.</p>
            <p class="mt-2 text-sm">Hãy kiểm tra các trạng thái khác hoặc quay lại sau.</p>
        </div>
    @endif
</div>

@endsection
