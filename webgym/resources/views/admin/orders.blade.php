@extends('layouts.ad_layout')

@section('title', 'Quản lý đơn hàng')

@section('content')

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
        
        <div class="flex items-center space-x-4 font-open-sans z-20">
            
            {{-- Nút Mở Bộ Lọc --}}
            <div class="relative" id="filter-container">
                <button onclick="toggleFilterPanel()" class="flex items-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg shadow-sm transition-all focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium text-sm">Lọc</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- FILTER PANEL (DROPDOWN) --}}
                <form action="{{ route('admin.orders.index') }}" method="GET" id="filter-panel" class="hidden absolute right-0 mt-3 w-[450px] bg-white border border-gray-200 rounded-xl shadow-xl p-5 z-50">                    
                    {{-- 1. Khoảng thời gian --}}
                    <div class="mb-5">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm">Khoảng thời gian</h3>
                        <div class="flex space-x-3 mb-3">
                            <div class="flex-1">
                                <label class="block text-xs text-gray-500 mb-1">Từ ngày:</label>
                                <input type="date" name="date_from" id="filter-date-from" value="{{ request('date_from') }}" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs text-gray-500 mb-1">Đến ngày:</label>
                                <input type="date" name="date_to" id="filter-date-to" value="{{ request('date_to') }}" 
                                    class="w-full border border-gray-300 rounded-md px-3 py-1.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="quick_date" value="today" onchange="setQuickDate('today')" 
                                    {{ request('quick_date') == 'today' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Hôm nay</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="quick_date" value="yesterday" onchange="setQuickDate('yesterday')" 
                                    {{ request('quick_date') == 'yesterday' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Hôm qua</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="quick_date" value="7days" onchange="setQuickDate('7days')" 
                                    {{ request('quick_date') == '7days' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">7 ngày trước</span>
                            </label>
                        </div>
                    </div>

                    {{-- 2. Thành tiền --}}
                    <div class="mb-5 border-t pt-4 border-gray-100">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm">Thành tiền</h3>
                        <div class="flex space-x-3 mb-3">
                            <input type="number" name="price_from" id="filter-price-from" placeholder="Từ (VND)" class="w-1/2 border border-gray-300 rounded-md px-3 py-1.5 text-sm">
                            <input type="number" name="price_to" id="filter-price-to" placeholder="Đến (VND)" class="w-1/2 border border-gray-300 rounded-md px-3 py-1.5 text-sm">
                        </div>
                        <div class="space-y-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="quick_price" value="under500" onchange="setQuickPrice(0, 500000)" 
                                    {{ request('quick_price') == 'under500' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Dưới 500.000</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="quick_price" value="500to1000" onchange="setQuickPrice(500000, 1000000)" 
                                    {{ request('quick_price') == '500to1000' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Từ 500.000 đến 1.000.000</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="quick_price" value="above1000" onchange="setQuickPrice(1000000, 999999999)" 
                                    {{ request('quick_price') == 'above1000' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Trên 1.000.000</span>
                            </label>
                        </div>
                    </div>

                    {{-- 3. Trạng thái --}}
                    <div class="mb-5 border-t pt-4 border-gray-100">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm">Trạng thái</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="status" value="all" {{ request('status', 'all') == 'all' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Tất cả</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="status" value="completed" {{ request('status', 'all') == 'completed' ? 'checked' : '' }} class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                                <span class="ml-2 text-sm text-gray-600">Hoàn tất</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="status" value="pending" {{ request('status', 'all') == 'pending' ? 'checked' : '' }} class="w-4 h-4 text-yellow-600 border-gray-300 focus:ring-yellow-500">
                                <span class="ml-2 text-sm text-gray-600">Chờ xác nhận</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="status" value="processing" {{ request('status', 'all') == 'processing' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Đang vận chuyển</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="status" value="cancelled" {{ request('status', 'all') == 'cancelled' ? 'checked' : '' }} class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                                <span class="ml-2 text-sm text-gray-600">Đã hủy</span>
                            </label>
                        </div>
                    </div>

                    {{-- Footer Buttons --}}
                    <div class="flex justify-end pt-4 space-x-3">
                        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors flex items-center justify-center">Đặt lại</a>
                        <button type="submit" class="px-6 py-2 text-sm bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow-md transition-colors">Áp dụng</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center ">
                <tr>
                    <th class="py-4 px-4 w-[10%] truncate">Mã đơn hàng</th> 
                    <th class="py-4 px-4 w-[20%] truncate">Tên khách hàng</th>                    
                    <th class="py-4 px-4 w-[15%] truncate">Ngày đặt hàng</th>                    
                    <th class="py-4 px-4 w-[25%] truncate">Địa chỉ giao hàng</th>                    
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

                    <tr class="{{ $rowBg }} cursor-pointer transition-colors order-row" 
                        data-status="{{ $item->status }}" 
                        onclick="openOrderModal('{{ $item->order_code }}')">
                        
                        {{-- 1. Code --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }} font-medium">
                            {{ $item->order_code }}
                        </td>

                        {{-- 2. khách hàng --}}
                        <td class="py-4 px-4 truncate align-middle font-medium text-center">
                            <div class="flex items-center justify-center">
                                <span class="font-medium">{{ $item->user_id ? $item->user->full_name : 'N/A'}}</span>
                            </div>
                        </td>

                        {{-- 3. Ngày đặt hàng --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            {{ \Carbon\Carbon::parse($item->order_date)->format('d/m/Y') }}
                        </td>

                        {{-- 4. Địa chỉ --}}
                        <td class="py-4 px-4 truncate text-left font-medium" title="{{ $item->shipping_address }}">
                            {{ Str::limit($item->shipping_address, 30) }}
                        </td>

                        {{-- 5. Tổng tiền --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            {{ number_format($item->total_amount, 0, ',', '.') }}
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
    {{-- Pagination --}}
    <div class="mt-6 flex justify-center">
        {{ $orders->links() }}
    </div>
</div>

{{--  INCLUDE MODAL CHI TIẾT ĐƠN HÀNG --}}
@include('admin.partials.order_detail_modal')

<script>
    // 1. Nhận dữ liệu gốc
    const rawOrders = @json($orders->items());

    // Chuyển đổi (Map) tên cột DB sang tên biến JS 
    const ordersData = rawOrders.map(order => {
        return {
            // Map thông tin chung
            order_code: order.order_code,
            date: order.order_date,
            status: order.status,
            
            // Map thông tin khách (từ quan hệ user)
            customer_name: order.user ? order.user.full_name : 'Khách vãng lai',
            phone: order.user ? order.user.phone : '',
            address: order.shipping_address,

            // Map tiền
            subtotal: (order.details || []).reduce((sum, item) => {
                return sum + (Number(item.final_price) || 0);
            }, 0),
            discount: order.discount_value || 0,
            total: order.total_amount,

            // Map danh sách sản phẩm (từ quan hệ details -> variant -> product)
            details: (order.details || []).map(detail => {
                // Kiểm tra an toàn để tránh lỗi null
                let pName = 'Sản phẩm lỗi/Đã xóa';
                let pVariant = 'Mặc định';
                
                if (detail.product && detail.product.product) {
                    pName = detail.product.product.product_name; // Tên sản phẩm gốc
                    
                    // Check màu/size
                    let color = detail.product.color || '';
                    let size = detail.product.size || '';
                    if(color || size) {
                        pVariant = `${color} / ${size}`;
                    }
                }

                return {
                    name: pName,
                    variant: pVariant,
                    qty: detail.quantity,
                    price: detail.unit_price
                };
            })
        };
    });

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

            // Tìm form bằng ID
            const form = document.getElementById('update-order-form');
            if (form) {
                form.action = `/admin/orders/${order.order_code}`;
            }

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

            // --- Fill Bảng sản phẩm  ---
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

    function toggleFilterPanel() {
        const panel = document.getElementById('filter-panel');
        if (panel) {
            panel.classList.toggle('hidden');
        }
    }

    // 4. Dropdown Filter
    function toggleStatusDropdown() {
        document.getElementById('status-dropdown').classList.toggle('hidden');
    }

    // Đóng Filter khi click ra ngoài
    document.addEventListener('click', function(event) {
        const container = document.getElementById('filter-container');
        const panel = document.getElementById('filter-panel');
        if (container && !container.contains(event.target)) {
            panel.classList.add('hidden');
        }
    });

    // Helper: Định dạng ngày YYYY-MM-DD
    function formatDateString(date) {
        const d = new Date(date);
        let month = '' + (d.getMonth() + 1);
        let day = '' + d.getDate();
        const year = d.getFullYear();
        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        return [year, month, day].join('-');
    }

    // Set nhanh ngày (Hôm nay, Hôm qua...)
    function setQuickDate(type) {
        const today = new Date();
        
        let fromDate, toDate;
        
        if (type === 'today') {
            fromDate = toDate = formatDateString(today);
        } else if (type === 'yesterday') {
            const y = new Date(today);
            y.setDate(y.getDate() - 1);
            fromDate = toDate = formatDateString(y);
        } else if (type === '7days') {
            toDate = formatDateString(today);
            const d = new Date(today);
            d.setDate(d.getDate() - 7);
            fromDate = formatDateString(d);
        }

        document.getElementById('filter-date-from').value = fromDate;
        document.getElementById('filter-date-to').value = toDate;
    }

    // Set nhanh giá tiền
    function setQuickPrice(min, max) {
        document.getElementById('filter-price-from').value = min;
        document.getElementById('filter-price-to').value = max;
    }
</script>

@endsection