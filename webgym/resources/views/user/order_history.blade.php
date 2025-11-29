@extends('user.layouts.user_dashboard')

@section('title', 'Lịch sử đơn hàng - GRYND')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-black font-montserrat">Đơn hàng của bạn</h1>
    <p class="text-sm text-gray-500 mt-1 font-open-sans">Quản lý đơn hàng cá nhân</p>
</div>


<div class="bg-white rounded-2xl shadow-sm p-3 border border-gray-100 mb-6 font-open-sans">
    <div class="flex w-full gap-2 text-sm font-semibold text-center text-gray-500">
        @php
            $statuses = [
                'Chờ xác nhận' => 'pending_confirmation',
                'Chờ lấy hàng' => 'ready_for_pickup',
                'Đang giao' => 'shipping',
                'Đã giao' => 'delivered',
                'Đã hủy' => 'cancelled',
            ];
            $currentStatus = request('status', 'pending_confirmation');
        @endphp

        @foreach ($statuses as $name => $slug)
            <a href="?status={{ $slug }}" 
               class="py-2 px-1 flex-1 transition duration-150 rounded-full whitespace-nowrap
                    @if ($currentStatus == $slug)
                        text-blue-600 bg-blue-100 
                    @else
                        text-gray-500 hover:bg-gray-50
                    @endif">
                {{ $name }}
            </a>
        @endforeach
    </div>
</div>

<div class="font-open-sans">
    @php
        $allOrders = [
            'pending_confirmation' => [
                (object)['id' => '#0003', 'date' => '26/11/2025', 'total' => 450000, 'details' => [
                    (object)['name' => 'Tạ tay 5kg', 'weight' => '5kg', 'qty' => 1, 'price' => 250000],
                    (object)['name' => 'Găng tay tập Gym', 'weight' => 'Màu đen', 'qty' => 1, 'price' => 200000]
                ]],
            ],
            'ready_for_pickup' => [
                (object)['id' => '#0004', 'date' => '25/11/2025', 'total' => 600000, 'details' => [
                    (object)['name' => 'Thảm Yoga', 'weight' => 'Màu hồng', 'qty' => 1, 'price' => 350000],
                    (object)['name' => 'Bình nước thể thao', 'weight' => '1L', 'qty' => 2, 'price' => 125000]
                ]],
            ],
            'shipping' => [
                (object)['id' => '#0005', 'date' => '24/11/2025', 'total' => 320000, 'details' => [
                    (object)['name' => 'Quần tập chạy bộ', 'weight' => 'Size L', 'qty' => 1, 'price' => 320000]
                ]],
            ],
            'delivered' => [ 
                (object)['id' => '#0001', 'date' => '22/11/2025', 'total' => 305000, 'details' => [
                    (object)['name' => 'Tạ tập Gym', 'weight' => '2kg', 'qty' => 1, 'price' => 149000],
                    (object)['name' => 'Đồ tập thể thao', 'weight' => 'XL', 'qty' => 2, 'price' => 156000]
                ]],
                (object)['id' => '#0002', 'date' => '22/11/2025', 'total' => 305000, 'details' => [
                    (object)['name' => 'Tạ tập Gym', 'weight' => '2kg', 'qty' => 1, 'price' => 149000],
                    (object)['name' => 'Đồ tập thể thao', 'weight' => 'XL', 'qty' => 2, 'price' => 156000]
                ]],
            ],
            'cancelled' => [], 
        ];

        $orders = $allOrders[$currentStatus] ?? [];
    @endphp

    @if (count($orders) > 0)
        @foreach ($orders as $order)
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mb-4">
                <div class="flex justify-between items-center mb-4 pb-2 border-b border-dashed border-gray-200">
                    <span class="font-bold text-gray-700">Mã đơn hàng: {{ $order->id }}</span>
                    <span class="text-sm text-gray-500">Ngày đặt hàng: {{ $order->date }}</span>
                </div>
                <span class="arrow ml-4 text-gray-400 transition-transform">Down Arrow</span>
            </div>
        </div>

        <!-- PHẦN CHI TIẾT (mặc định ẩn, sẽ hiện khi click) -->
        <div class="border-t border-gray-200 hidden">
            <div class="p-6 pt-4">

                {{-- BODY: Danh sách sản phẩm --}}
                @foreach ($order->details as $item)
                    <div class="flex items-start mb-4 gap-4">
                        <div class="w-16 h-16 bg-gray-100 rounded-md shrink-0">
                        </div>
                        
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">{{ $item->name }}</p>
                            
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $item->weight }}
                            </p>

                            <div class="flex justify-between items-center mt-1">
                                <p class="text-xs text-gray-500">
                                    Số lượng: x{{ $item->qty }}
                                </p>

                                <div class="text-right font-semibold text-gray-800 text-base">
                                    {{ number_format($item->price * $item->qty, 0, ',', '.') }} VNĐ
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="flex justify-between items-center pt-4 border-t border-gray-200 mt-4">
                    <p class="font-semibold text-lg text-black">
                        Tổng tiền: 
                        <span class="text-2xl text-red-700 font-bold">{{ number_format($order->total, 0, ',', '.') }} VNĐ</span>
                    </p>
                    <div class="flex gap-3">
                        @if ($currentStatus == 'delivered')
                            <button class="px-10 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition duration-150">
                                Mua lại
                            </button>
                        @endif
                        <button class="px-10 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-150">
                            @if ($currentStatus == 'delivered')
                                Đánh giá
                            @else
                                Chi tiết đơn hàng
                            @endif
                        </button>
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




