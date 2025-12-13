@extends('layouts.ad_layout')

@section('title', 'Quản lý thanh toán')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Quản lý thanh toán</h1>
        
        <div class="flex items-center space-x-4 font-open-sans z-20">
            {{-- Dropdown lọc --}}
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

                {{-- FILTER FORM PANEL --}}
                {{-- Lưu ý: Đổi route action thành admin.payments.index --}}
                <form action="{{ route('admin.payments.index') }}" method="GET" id="filter-panel" class="hidden absolute right-0 mt-3 w-[450px] bg-white border border-gray-200 rounded-xl shadow-xl p-5 z-50">                    
                    {{-- 1. Khoảng thời gian --}}
                    <div class="mb-5">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm">Ngày thanh toán</h3>
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

                    {{-- 2. Số tiền --}}
                    <div class="mb-5 border-t pt-4 border-gray-100">
                        <h3 class="font-semibold text-gray-800 mb-3 text-sm">Số tiền giao dịch</h3>
                        <div class="flex space-x-3 mb-3">
                            <input type="number" name="price_from" id="filter-price-from" placeholder="Từ (VND)" value="{{ request('price_from') }}" class="w-1/2 border border-gray-300 rounded-md px-3 py-1.5 text-sm">
                            <input type="number" name="price_to" id="filter-price-to" placeholder="Đến (VND)" value="{{ request('price_to') }}" class="w-1/2 border border-gray-300 rounded-md px-3 py-1.5 text-sm">
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
                                <input type="radio" name="status" value="completed" {{ request('status') == 'completed' ? 'checked' : '' }} class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                                <span class="ml-2 text-sm text-gray-600">Hoàn tất</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="status" value="pending" {{ request('status') == 'pending' ? 'checked' : '' }} class="w-4 h-4 text-yellow-600 border-gray-300 focus:ring-yellow-500">
                                <span class="ml-2 text-sm text-gray-600">Chờ xử lý</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="status" value="refunded" {{ request('status') == 'refunded' ? 'checked' : '' }} class="w-4 h-4 text-blue-500 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-600">Hoàn tiền</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="status" value="failed" {{ request('status') == 'failed' ? 'checked' : '' }} class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                                <span class="ml-2 text-sm text-gray-600">Đã hủy/Lỗi</span>
                            </label>
                        </div>
                    </div>

                    {{-- Footer Buttons --}}
                    <div class="flex justify-end pt-4 space-x-3">
                        <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors flex items-center justify-center">Đặt lại</a>
                        <button type="submit" class="px-6 py-2 text-sm bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 shadow-md transition-colors">Áp dụng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- TABLE CONTENT --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center">
                <tr>
                    <th class="py-4 px-4 w-[10%] truncate">Code</th>
                    <th class="py-4 px-4 w-[22%] truncate">Khách hàng</th>
                    <th class="py-4 px-4 w-[13%] truncate">Loại thanh toán</th>
                    <th class="py-4 px-4 w-[15%] truncate">Tổng tiền (VNĐ)</th>
                    <th class="py-4 px-4 w-[10%] truncate">Phương thức</th>
                    <th class="py-4 px-4 w-[15%] truncate">Ngày thanh toán</th>
                    <th class="py-4 px-4 w-[15%] truncate">Trạng thái</th>
                </tr>
            </thead>

            <tbody id="payment-list-body" class="text-sm text-gray-700 text-center">
                @foreach ($payments as $item)
                    @php
                        // Logic màu nền (Copy từ Order)
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';
                        
                        // Format ngày
                        $formattedDate = $item->payment_date 
                            ? \Carbon\Carbon::parse($item->payment_date)->format('d/m/Y') 
                            : 'Chưa có';

                        $userName = $item->user ? $item->user->full_name : 'Khách vãng lai';
                    @endphp

                    <tr class="{{ $rowBg }} cursor-pointer transition-colors modal-trigger group"
                        onclick="openManageModal({{ $item->payment_id }})">
                        
                        {{-- 1. Code --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }} font-medium text-gray-700">
                            {{ $item->payment_code }}
                        </td>

                        {{-- 2. Khách hàng --}}
                        <td class="py-4 px-4 truncate align-middle text-center font-medium">
                            {{ Str::limit($userName, 25) }}
                        </td>

                        {{-- 3. Loại --}}
                        <td class="py-4 px-4 truncate align-middle">
                            @if(Str::contains($item->payment_type, 'membership'))
                                <span class="px-2 py-1 rounded font-medium tracking-wide">
                                    Gói tập
                                </span>
                            @elseif(Str::contains($item->payment_type, 'order'))
                                <span class="px-2 py-1 rounded font-medium tracking-wide">
                                    Đơn hàng
                                </span>
                            @else
                                <span class="text-gray-600 font-medium">
                                    {{ ucfirst(str_replace('_', ' ', $item->payment_type)) }}
                                </span>
                            @endif
                        </td>

                        {{-- 4. Tổng tiền --}}
                        <td class="py-4 px-4 truncate align-middle text-gray-800 font-medium">
                            {{ number_format($item->amount, 0, ',', '.') }}
                        </td>

                        {{-- 5. Phương thức --}}
                        <td class="py-4 px-4 truncate align-middle">
                            <span class="font-medium text-gray-600 uppercase text-xs px-2 py-1">
                                {{ $item->method }}
                            </span>
                        </td>

                        {{-- 6. Ngày thanh toán --}}
                        <td class="py-4 px-4 truncate align-middle text-gray-600">
                            {{ $formattedDate }}
                        </td>

                        {{-- 7. Trạng thái --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            @switch($item->status)
                                @case('completed')
                                    <span class="bg-[#28A745]/10 text-[#28A745]/90 py-1 px-3 rounded-full text-sm font-semibold">
                                        Hoàn tất
                                    </span>
                                    @break
                                @case('refunded')
                                    <span class="bg-[#0D6EFD]/10 text-[#0D6EFD]/90 py-1 px-3 rounded-full text-sm font-semibold">
                                        Hoàn tiền
                                    </span>
                                    @break
                                @case('failed')
                                    <span class="bg-[#DC3545]/10 text-[#DC3545]/90 py-1 px-3 rounded-full text-sm font-semibold">
                                        Đã hủy
                                    </span>
                                    @break
                                @case('pending')
                                    <span class="bg-[#FFC107]/10 text-[#FFC107]/90 py-1 px-3 rounded-full text-sm font-semibold">
                                        Chờ xử lý
                                    </span>
                                    @break
                                @default
                                    <span class="bg-gray-100 text-gray-500 py-1 px-3 rounded-full text-sm font-semibold">
                                        {{ $item->status }}
                                    </span>
                            @endswitch
                        </td>
                    </tr>
                    
                    {{-- Spacer row --}}
                    <tr class="h-2"></tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
            {{ $payments->links() }}
        </div>
    </div>
</div>

{{-- MODAL QUẢN LÝ THANH TOÁN --}}
<div id="managePaymentModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 transition-opacity">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl transform transition-all flex flex-col max-h-[90vh] overflow-y-auto scale-100">
        
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat uppercase">
            CHI TIẾT THANH TOÁN
        </h2>

        <div id="managePaymentFormContainer">
            <input type="hidden" id="manage-payment_id">
            
            <h3 class="text-lg font-bold text-blue-700 mb-6 font-montserrat uppercase border-b pb-2 border-gray-100">Thông tin chung</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Cột Trái --}}
                <div class="space-y-5">
                    {{-- Code --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Mã giao dịch</label>
                        <input type="text" id="manage-payment_code" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-700 font-mono font-medium outline-none focus:ring-2 focus:ring-blue-200" readonly>
                    </div>

                    {{-- Phương thức --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Phương thức</label>
                        <input type="text" id="manage-method" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-700 uppercase outline-none" readonly>
                    </div>

                    {{-- Loại TT --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Loại thanh toán</label>
                        <input type="text" id="manage-payment_type" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-700 outline-none" readonly>
                    </div>

                    {{-- Tổng tiền --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Số tiền (VNĐ)</label>
                        <input type="text" id="manage-amount" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-700 outline-none" readonly>
                    </div>
                </div>

                {{-- Cột Phải --}}
                <div class="space-y-5">
                    {{-- Khách hàng --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Khách hàng</label>
                        <input type="text" id="manage-customer_name" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-700 font-medium outline-none" readonly>
                    </div>

                    {{-- Ngày TT --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Ngày thanh toán</label>
                        <input type="text" id="manage-payment_date" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-700 outline-none" readonly>
                    </div>

                    {{-- Số điện thoại --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Số điện thoại</label>
                        <input type="text" id="manage-customer_phone" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-700 font-medium outline-none" readonly>
                    </div>

                    {{-- Trạng thái (Editable) --}}
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Cập nhật trạng thái</label>
                        <select id="manage-status" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-gray-800 outline-none focus:ring-2 focus:ring-blue-500 bg-white font-medium cursor-pointer">
                            <option value="pending">Chờ xử lý</option>
                            <option value="completed">Hoàn thành</option>
                            <option value="cancelled">Đã hủy</option>
                            <option value="refunded">Hoàn tiền</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Buttons Footer --}}
            <div class="flex justify-center items-center mt-8 pt-6 border-t border-gray-100 space-x-3">
                <button type="button" class="close-modal px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors focus:outline-none">
                    Đóng
                </button>
                <button type="button" onclick="submitManageForm()" class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg transition-colors focus:outline-none shadow-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Lưu thay đổi
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Modal helpers
    function openModal(id) {
        const m = document.getElementById(id);
        m.classList.remove('hidden');
        setTimeout(() => m.classList.add('flex'), 10);
        m.classList.add('flex');
    }
    
    function closeModal(id) {
        const m = document.getElementById(id);
        m.classList.add('hidden');
        m.classList.remove('flex');
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.close-modal').forEach(b => b.addEventListener('click', () => {
            closeModal(b.closest('.modal-container').id);
        }));
        document.querySelectorAll('.modal-container').forEach(m => m.addEventListener('click', e => {
            if (e.target === m) closeModal(m.id);
        }));
    });

    // --- FETCH DATA TỪ SERVER ---
    function openManageModal(id) {
        fetch(`/admin/payments/${id}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('manage-payment_id').value = data.payment_id;
                
                document.getElementById('manage-customer_phone').value = data.user_phone || 'Chưa cập nhật';
                document.getElementById('manage-payment_code').value = data.payment_code; 

                document.getElementById('manage-customer_name').value = data.user_name;
                
                // Logic hiển thị tiếng Việt trong Modal
                let typeVi = data.payment_type;
                if(typeVi.includes('order')) typeVi = 'Thanh toán đơn hàng';
                else if(typeVi.includes('membership')) typeVi = 'Đăng ký gói tập';
                else if(typeVi.includes('combined')) typeVi = 'Thanh toán Combo';
                
                document.getElementById('manage-payment_type').value = typeVi;
                
                document.getElementById('manage-amount').value = new Intl.NumberFormat('vi-VN').format(data.amount);
                document.getElementById('manage-method').value = data.method;
                
                document.getElementById('manage-payment_date').value = data.payment_date 
                    ? data.payment_date.split(' ')[0].split('-').reverse().join('/') + ' ' + data.payment_date.split(' ')[1]
                    : 'Chưa thanh toán';
                
                let statusValue = data.status;
                if (statusValue === 'failed') {
                    statusValue = 'cancelled';
                }
                document.getElementById('manage-status').value = statusValue;

                openModal('managePaymentModal');
            });
    }

    // --- SUBMIT FORM ---
    function submitManageForm() {
        const id = document.getElementById('manage-payment_id').value;
        const formData = new FormData();
        formData.append('status', document.getElementById('manage-status').value);
        formData.append('_method', 'PUT');

        fetch(`/admin/payments/${id}`, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    alert(res.message || 'Cập nhật thành công!');
                    closeModal('managePaymentModal');
                    location.reload();
                } else {
                    alert('Lỗi cập nhật');
                }
            })
            .catch(() => alert('Lỗi hệ thống'));
    }

    // --- FILTER LOGIC (MỚI) ---
    function toggleFilterPanel() {
        const panel = document.getElementById('filter-panel');
        if (panel) {
            panel.classList.toggle('hidden');
        }
    }

    // Đóng Filter khi click ra ngoài
    document.addEventListener('click', function(event) {
        const container = document.getElementById('filter-container');
        const panel = document.getElementById('filter-panel');
        // Kiểm tra nếu click không nằm trong container và panel đang mở
        if (container && !container.contains(event.target) && panel && !panel.classList.contains('hidden')) {
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
@endpush