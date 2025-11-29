@extends('user.layouts.user_dashboard')

@section('title', 'Lịch sử đơn hàng - GRYND')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-black font-montserrat">Đơn hàng của bạn</h1>
    <p class="text-sm text-gray-500 mt-1 font-open-sans">Quản lý đơn hàng cá nhân</p>
</div>

<!-- Tab trạng thái -->
<div class="bg-white rounded-2xl shadow-sm p-3 border border-gray-100 mb-6 font-open-sans">
    <div class="flex w-full gap-2 text-sm font-semibold text-center text-gray-500 overflow-x-auto">
        @foreach ($statusLabels as $slug => $name)
        <a href="?status={{ $slug }}"
           class="py-2 px-4 flex-shrink-0 transition duration-150 rounded-full whitespace-nowrap
                      {{ $status === $slug ? 'text-blue-600 bg-blue-100' : 'text-gray-500 hover:bg-gray-50' }}">
            {{ $name }}
        </a>
        @endforeach
    </div>
</div>

<div class="font-open-sans">
    @if ($orders->count() > 0)
    @foreach ($orders as $order)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-4 overflow-hidden">

        <!-- PHẦN TÓM TẮT (luôn hiển thị + click để mở) -->
        <div class="p-6 cursor-pointer bg-gray-50/30 hover:bg-gray-50/70 transition" onclick="toggleDetail(this)">
            <div class="flex justify-between items-center">
                <div>
                    <span class="font-bold text-gray-800">Mã đơn: {{ $order->order_code ?? '#'.$order->order_id }}</span>
                    <span class="text-sm text-gray-500 block mt-1">
                    {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}
                </span>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-red-600">
                        {{ number_format($order->total_amount, 0, ',', '.') }} ₫
                    </p>
                    <p class="text-sm text-gray-500 mt-1">({{ $order->details->count() }} sản phẩm)</p>
                </div>
                <span class="arrow ml-4 text-gray-400 transition-transform">Down Arrow</span>
            </div>
        </div>

        <!-- PHẦN CHI TIẾT (mặc định ẩn, sẽ hiện khi click) -->
        <div class="border-t border-gray-200 hidden">
            <div class="p-6 pt-4">

                @foreach ($order->details as $item)
                @php
                $variant = $item->product;
                $product = $variant?->product;
                $detailImage = $variant?->image_url
                ? (str_starts_with($variant->image_url, 'http')
                ? $variant->image_url
                : asset('storage/' . ltrim($variant->image_url, '/')))
                : asset('images/no-image.png');
                $productUrl = $product?->slug ? route('product.detail', $product->slug) : '#';
                @endphp

                <div class="flex gap-4 py-4 border-b border-gray-100 last:border-0">
                    <div class="w-20 h-20 rounded overflow-hidden shrink-0 bg-gray-100 border border-gray-200">
                        <img src="{{ $detailImage }}"
                             alt="{{ $product?->product_name ?? 'Sản phẩm' }}"
                             class="w-full h-full object-cover"
                             onerror="this.src='{{ asset('images/no-image.png') }}'">
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-800 line-clamp-2">
                            {{ $product?->product_name ?? 'Sản phẩm đã bị xóa' }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            @if($variant)
                            @if($variant->color)<span class="text-gray-600">{{ $variant->color }}</span>@endif
                            @if($variant->size)<span class="text-gray-600">{{ $variant->color ? ' · ' : '' }}Size {{ $variant->size }}</span>@endif
                            @if($variant->weight)<span class="text-gray-600">{{ ($variant->color || $variant->size) ? ' · ' : '' }}{{ $variant->weight }} {{ $variant->unit ?? 'g' }}</span>@endif
                            @endif
                        </p>

                        <div class="flex justify-between items-end mt-3">
                            <span class="text-gray-600">Số lượng: x{{ $item->quantity }}</span>
                            <span class="font-semibold text-gray-800">
                                {{ number_format($item->final_price, 0, ',', '.') }} ₫
                            </span>
                        </div>

                        <!-- Nút Mua lại & Đánh giá cho từng sản phẩm -->
                        @if($status === 'completed' && $product) <!-- hoặc 'completed' tùy bạn -->
                        <div class="flex gap-2 mt-4">
                            <a href="{{ $productUrl }}" target="_blank"
                               class="px-4 py-1.5 text-sm border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition">
                                Mua lại
                            </a>
                            <a href="{{ $productUrl }}#review-section" target="_blank"
                               class="px-4 py-1.5 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Đánh giá
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach

                <!-- Địa chỉ + mã giảm giá (nếu có) -->
                <div class="mt-6 pt-6 border-t border-gray-200 text-sm text-gray-600">
                    @if($order->shipping_address)
                    <p>Địa chỉ giao: {{ $order->shipping_address }}</p>
                    @endif
                    @if($order->promotion_code)
                    <p class="text-green-600">Mã giảm giá: {{ $order->promotion_code }}</p>
                    @endif
                </div>

            </div>
        </div>
        <!-- Kết thúc phần chi tiết ẩn -->

    </div>
    @endforeach
    @else
    <div class="bg-white rounded-2xl shadow-sm p-12 border border-gray-100 text-center">
        <p class="text-lg text-gray-500">Không có đơn hàng nào ở trạng thái này.</p>
        <p class="mt-2 text-sm text-gray-400">Hãy kiểm tra các tab khác hoặc quay lại sau nhé!</p>
    </div>
    @endif
</div>

<script>
    function toggleDetail(element) {
        const detailSection = element.nextElementSibling;
        detailSection.classList.toggle('hidden');
        element.querySelector('.arrow').classList.toggle('rotate-180');
    }
</script>

<style>
    .rotate-180 {
        transform: rotate(180deg);
        transition: 0.3s;
    }
</style>
@endsection




