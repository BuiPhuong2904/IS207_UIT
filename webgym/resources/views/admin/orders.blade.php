@extends('layouts.ad_layout')

@section('title', 'Quản lý đơn hàng')

@section('content')

{{--  MOCK DATA (DỮ LIỆU GIẢ ĐỂ TEST GIAO DIỆN) --}}
@php
    $orders = [
        (object)[
            'id' => 1, 
            'order_code' => 'GYM-20251110-ABC111', 
            'customer_id' => 'KH001', 
            'customer_name' => 'Vũ Thị Ngọc',
            'phone' => '0905.123.456',
            'address' => '123 Nguyễn Huệ, Quận 1, TP.HCM', 
            'date' => '2025-11-10 08:30', 
            'payment_method' => 'Chuyển khoản ngân hàng',
            'subtotal' => 849000,
            'discount' => 50000,
            'total' => 799000, 
            'status' => 'completed',
            'details' => [
                ['name' => 'Thảm tập Yoga định tuyến', 'variant' => 'Tím / 6mm', 'qty' => 1, 'price' => 399000],
                ['name' => 'Quần Legging Nữ nâng mông', 'variant' => 'Xám / M', 'qty' => 1, 'price' => 450000]
            ]
        ],
        (object)[
            'id' => 2, 
            'order_code' => 'GYM-20251114-DEF222', 
            'customer_id' => 'KH002',
            'customer_name' => 'Lý Văn Sang',
            'phone' => '0912.999.888',
            'address' => '45 Lê Lợi, Quận Hải Châu, Đà Nẵng',
            'date' => '2025-11-14 14:15', 
            'payment_method' => 'COD (Thanh toán khi nhận hàng)',
            'subtotal' => 2300000,
            'discount' => 100000,
            'total' => 2200000, 
            'status' => 'processing',
            'details' => [
                ['name' => 'Whey Protein Isolate', 'variant' => 'Vị Chocolate / 5 Lbs', 'qty' => 1, 'price' => 1550000],
                ['name' => 'C4 Pre-Workout Original', 'variant' => 'Icy Blue / 30 Servings', 'qty' => 1, 'price' => 750000]
            ]
        ],
        (object)[
            'id' => 3, 
            'order_code' => 'GYM-20251115-GHI333', 
            'customer_id' => 'KH003',
            'customer_name' => 'Trần Thị Quỳnh',
            'phone' => '0988.777.666',
            'address' => '88 Võ Thị Sáu, Quận 3, TP.HCM',
            'date' => '2025-11-15 09:00', 
            'payment_method' => 'Ví MoMo',
            'subtotal' => 909000,
            'discount' => 0,
            'total' => 909000, 
            'status' => 'pending',
            'details' => [
                ['name' => 'Tạ ấm Kettlebell', 'variant' => 'Hồng / 4kg', 'qty' => 2, 'price' => 220000],
                ['name' => 'Dây nhảy tốc độ cao', 'variant' => 'Đỏ / Free Size', 'qty' => 1, 'price' => 149000],
                ['name' => 'Túi đựng đồ tập Gym', 'variant' => 'Xám / Canvas', 'qty' => 1, 'price' => 320000]
            ]
        ],
        (object)[
            'id' => 4, 
            'order_code' => 'GYM-20251108-JKL444', 
            'customer_id' => 'KH004',
            'customer_name' => 'Trịnh Văn Bình',
            'phone' => '0909.000.111',
            'address' => '12 Đường Láng, Đống Đa, Hà Nội',
            'date' => '2025-11-08 10:20', 
            'payment_method' => 'COD',
            'subtotal' => 750000,
            'discount' => 0,
            'total' => 750000, 
            'status' => 'cancelled',
            'details' => [
                ['name' => 'C4 Pre-Workout', 'variant' => 'Icy Blue', 'qty' => 1, 'price' => 750000]
            ]
        ],
         (object)[
            'id' => 5, 
            'order_code' => 'GYM-20251108-MNO555', 
            'customer_id' => 'KH005',
            'customer_name' => 'Đỗ Văn Phúc',
            'phone' => '0933.444.555',
            'address' => 'Khu Công Nghệ Cao, Thủ Đức',
            'date' => '2025-11-08 16:45', 
            'payment_method' => 'Chuyển khoản',
            'subtotal' => 399000,
            'discount' => 0,
            'total' => 399000, 
            'status' => 'completed',
            'details' => [
                ['name' => 'Găng tay tập Gym', 'variant' => 'Đen / L', 'qty' => 1, 'price' => 250000],
                ['name' => 'Bình nước La Pro', 'variant' => 'Đen / 1500ml', 'qty' => 1, 'price' => 149000]
            ]
        ],
    ];
@endphp

{{-- CSRF TOKEN --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- ALERT SUCCESS --}}
@if(session('success'))
    <div id="alert-success" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Thành công!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="document.getElementById('alert-success').style.display='none'">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm p-6">
    
    {{-- HEADER & TOOLBAR --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Đơn hàng</h1>
        
        <div class="flex items-center space-x-4 font-open-sans">
            
            {{-- Filter Status Dropdown --}}
            <div class="relative" id="status-filter-container">
                <button onclick="toggleStatusDropdown()" class="flex items-center text-gray-500 cursor-pointer hover:text-gray-900 focus:outline-none">
                    <span id="current-status-label" class="mr-1 text-sm font-medium">Trạng thái: Tất cả</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- Dropdown Menu --}}
                <div id="status-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-10 py-1">
                    <div onclick="filterOrders('all', 'Tất cả')" class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm text-gray-700">Tất cả</div>
                    <div onclick="filterOrders('pending', 'Chờ xác nhận')" class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm text-[#B78103]">Chờ xác nhận</div>
                    <div onclick="filterOrders('processing', 'Đang vận chuyển')" class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm text-[#1976D2]">Đang vận chuyển</div>
                    <div onclick="filterOrders('completed', 'Hoàn tất')" class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm text-[#1FA669]">Hoàn tất</div>
                    <div onclick="filterOrders('cancelled', 'Đã hủy')" class="px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm text-[#F64E60]">Đã hủy</div>
                </div>
            </div>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center ">
                <tr>
                    <th class="py-4 px-4 w-[10%] truncate">Code</th> 
                    <th class="py-4 px-4 w-[20%] truncate">Mã khách hàng</th>                    
                    <th class="py-4 px-4 w-[15%] truncate">Ngày đặt hàng</th>                    
                    <th class="py-4 px-4 w-[25%] truncate">Địa chỉ</th>                    
                    <th class="py-4 px-4 w-[15%] truncate">Tổng tiền (VND)</th>                    
                    <th class="py-4 px-4 w-[15%] truncate">Trạng thái</th>
                </tr>
            </thead>
           
            <tbody class="text-sm text-gray-700 text-center" id="order-table-body">
                @foreach($orders as $item)
                    @php
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';
                    @endphp

                    {{-- 
                        THÊM data-status="{{ $item->status }}" ĐỂ JS LỌC 
                    --}}
                    <tr class="{{ $rowBg }} cursor-pointer transition-colors order-row" 
                        data-status="{{ $item->status }}" 
                        onclick="openOrderModal('{{ $item->order_code }}')">
                        
                        {{-- 1. Code --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }} font-medium">
                            #{{ substr($item->order_code, -5) }}
                        </td>

                        {{-- 2. Mã khách hàng --}}
                        <td class="py-4 px-4 truncate align-middle font-medium text-center">
                            <div class="flex items-center justify-center">
                                <span class="font-medium">{{ $item->customer_id }}</span>
                            </div>
                        </td>

                        {{-- 3. Ngày đặt hàng --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            T{{ \Carbon\Carbon::parse($item->date)->format('w') + 1 }}/{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}
                        </td>

                        {{-- 4. Địa chỉ --}}
                        <td class="py-4 px-4 truncate align-middle font-medium" title="{{ $item->address }}">
                            {{ Str::limit($item->address, 30) }}
                        </td>

                        {{-- 5. Tổng tiền --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            {{ number_format($item->total, 0, ',', '.') }}
                        </td>
                        
                        {{-- 6. Trạng thái --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            @switch($item->status)
                                @case('completed') 
                                    <span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-sm font-semibold">Hoàn tất</span> 
                                    @break
                                @case('processing') 
                                    <span class="bg-[#0D6EFD]/10 text-[#0D6EFD]/70 py-1 px-3 rounded-full text-sm font-semibold">Đang vận chuyển</span> 
                                    @break
                                @case('pending') 
                                    <span class="bg-[#FFC107]/10 text-[#FFC107]/70 py-1 px-3 rounded-full text-sm font-semibold">Chờ xác nhận</span> 
                                    @break
                                @case('cancelled') 
                                    <span class="bg-[#DC3545]/10 text-[#DC3545]/70 py-1 px-3 rounded-full text-sm font-semibold">Đã hủy</span> 
                                    @break
                                @default 
                                    <span class="bg-gray-100 text-gray-500 py-1 px-3 rounded-full text-sm font-semibold">Chưa xác định</span>
                            @endswitch
                        </td>
                    </tr>
                    <tr class="h-2 spacer-row"></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{--  INCLUDE MODAL CHI TIẾT ĐƠN HÀNG --}}
@include('admin.partials.order_detail_modal')


<script>
    // 1. Dữ liệu mock từ Laravel
    const ordersData = @json($orders);

    // 2. Toggle Modal
    function toggleModal(modalID) {
        const modal = document.getElementById(modalID);
        if(modal) {
            modal.classList.toggle('hidden');
        }
    }

    // 3. Mở Modal & Fill dữ liệu
    function openOrderModal(orderCode) {
        const order = ordersData.find(o => o.order_code === orderCode);
        
        if(order) {
            const formatMoney = (amount) => new Intl.NumberFormat('vi-VN').format(amount); 

            // --- Fill Thông tin chung ---
            document.getElementById('modal-order-code').value = order.order_code;
            document.getElementById('modal-date').value = order.date;
            // Mock data không có coupon code, để trống hoặc mặc định
            document.getElementById('modal-coupon').value = ''; 
            document.getElementById('modal-status-select').value = order.status;

            // --- Fill Khách hàng ---
            document.getElementById('modal-customer-name').value = order.customer_name;
            document.getElementById('modal-phone').value = order.phone || '';
            document.getElementById('modal-address').value = order.address;

            // --- Fill Bảng sản phẩm (Render HTML chuẩn 4 cột mới) ---
            const tbody = document.getElementById('modal-product-list');
            tbody.innerHTML = ''; // Xóa dữ liệu cũ

            order.details.forEach((item, index) => {
                const rowHtml = `
                    <tr>
                        <td class="py-2 px-3 text-center text-gray-500 border-r border-gray-100">${index + 1}</td>
                        <td class="py-2 px-3 border-r border-gray-100">
                            <div class="font-medium text-gray-800">${item.name}</div>
                            <div class="text-xs text-gray-500">Phân loại: ${item.variant || 'Tiêu chuẩn'}</div>
                        </td>
                        <td class="py-2 px-3 text-center border-r border-gray-100 font-medium">${item.qty}</td>
                        <td class="py-2 px-3 text-right font-medium text-gray-800">${formatMoney(item.price)}</td>
                    </tr>
                `;
                tbody.innerHTML += rowHtml;
            });

            // --- Fill Footer Tổng tiền ---
            document.getElementById('modal-subtotal').innerText = formatMoney(order.subtotal || order.total);
            document.getElementById('modal-discount').innerText = formatMoney(order.discount || 0);
            document.getElementById('modal-total').innerText = formatMoney(order.total);

            // Hiển thị modal
            toggleModal('order-detail-modal');
        } else {
            alert('Không tìm thấy thông tin đơn hàng!');
        }
    }

    // 4. Dropdown Filter (Giữ nguyên logic cũ)
    function toggleStatusDropdown() {
        document.getElementById('status-dropdown').classList.toggle('hidden');
    }

    document.addEventListener('click', function(event) {
        const container = document.getElementById('status-filter-container');
        const dropdown = document.getElementById('status-dropdown');
        if (container && !container.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

    function filterOrders(status, label) {
        document.getElementById('current-status-label').innerText = 'Trạng thái: ' + label;
        document.getElementById('status-dropdown').classList.add('hidden');

        const rows = document.querySelectorAll('.order-row');
        rows.forEach(row => {
            const rowStatus = row.getAttribute('data-status');
            if (status === 'all' || rowStatus === status) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>

@endsection