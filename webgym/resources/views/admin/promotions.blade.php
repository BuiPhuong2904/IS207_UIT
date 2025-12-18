@extends('layouts.ad_layout')

@section('title', 'Quản lý khuyến mãi')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6 font-open-sans">
    
    {{-- HEADER & BUTTONS --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Quản lý khuyến mãi</h1>
        
        <div class="flex items-center space-x-4">
            
            {{-- Dropdown lọc --}}
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900 bg-gray-100 px-3 py-1.5 rounded-lg">
                <span class="mr-1 text-sm font-medium">Trạng thái</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            {{-- Nút Thêm --}}
            <button onclick="openModal('addPromotionModal')" class="bg-[#28A745] hover:bg-[#218838] text-white px-6 py-2 rounded-full flex items-center font-medium transition-colors shadow-sm cursor-pointer hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm
            </button>
        </div>
    </div>

    {{-- TABLE CONTENT --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto">
            
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center">
                <tr>
                    <th class="py-4 px-4 w-[10%] truncate">ID</th>
                    <th class="py-4 px-4 w-[15%] truncate">Code</th>
                    <th class="py-4 px-4 w-[15%] truncate">Tiêu đề</th>
                    <th class="py-4 px-4 w-[15%] truncate">Giá trị giảm</th>
                    <th class="py-4 px-4 w-[10%] truncate">Kiểu</th>
                    <th class="py-4 px-4 w-[15%] truncate">Ngày bắt đầu</th>
                    <th class="py-4 px-4 w-[15%] truncate">Ngày kết thúc</th>
                    <th class="py-4 px-4 w-[20%] truncate">Trạng thái</th>
                </tr>
            </thead>

            <tbody id="promotion-list-body" class="text-sm text-gray-700 text-center">
                @foreach ($promotions as $item)
                    @php
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white'; 
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';
                        
                        // Format hiển thị bảng (d/m/Y)
                        $showStartDate = $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') : '---';
                        $showEndDate = $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') : '---';

                        // Format cho Data Attribute để điền vào Input Date (Y-m-d)
                        $dataStartDate = $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('Y-m-d') : '';
                        $dataEndDate = $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('Y-m-d') : '';
                        
                        $statusBadge = $item->is_active 
                            ? '<span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">Hiệu lực</span>'
                            : '<span class="bg-gray-200 text-gray-500 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">Dừng</span>';
                    @endphp

                    {{-- ROW CLICKABLE VỚI DATA ATTRIBUTES --}}
                    <tr class="{{ $rowBg }} cursor-pointer transition-colors group"
                        onclick="openManageModalFromData(this)"
                        data-promotion_id="{{ $item->promotion_id }}"
                        data-code="{{ $item->code }}"
                        data-title="{{ $item->title }}"
                        data-discount_value="{{ $item->discount_value }}"
                        data-is_percent="{{ $item->is_percent }}" {{-- Giá trị 0 hoặc 1 --}}
                        data-start_date="{{ $dataStartDate }}"
                        data-end_date="{{ $dataEndDate }}"
                        data-usage_limit="{{ $item->usage_limit }}"
                        data-per_user_limit="{{ $item->per_user_limit }}"
                        data-min_order_amount="{{ $item->min_order_amount }}"
                        data-max_discount="{{ $item->max_discount }}"
                        data-description="{{ $item->description }}"
                        data-is_active="{{ $item->is_active }}"
                    >
                        
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }}">
                            KM{{ str_pad($item->promotion_id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="py-4 px-4 truncate align-middle font-medium font-mono text-gray-800">
                            {{ $item->code }}
                        </td>
                        <td class="py-4 px-4 truncate align-middle font-medium text-gray-800">
                            {{ $item->title }}
                        </td>
                        <td class="py-4 px-4 truncate align-middle text-gray-800 font-mono">
                            {{ number_format($item->discount_value, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $item->is_percent ? '%' : 'VNĐ' }}
                        </td>
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $showStartDate }}
                        </td>
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $showEndDate }}
                        </td>
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            {!! $statusBadge !!}
                        </td>
                    </tr>
                    
                    <tr class="h-2"></tr> 
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
            {{ $promotions->links() }}
        </div>
    </div>
</div>

{{-- ----------------- MODAL 1: THÊM KHUYẾN MÃI ----------------- --}}
<div id="addPromotionModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 font-open-sans">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl transform transition-all h-[90vh] overflow-y-auto custom-scrollbar flex flex-col">
        <h2 class="text-2xl font-bold text-center mb-6 text-[#1976D2] font-montserrat uppercase">
            THÊM KHUYẾN MÃI
        </h2>
        
        <form id="addPromotionForm" class="flex-1">
            <h3 class="text-lg font-bold text-[#1976D2] mb-4 font-montserrat">Thông tin khuyến mãi</h3>
            
            <div class="space-y-4">
                <div class="flex items-center">
                    <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Code <span class="text-red-500">*</span></label>
                    <input type="text" name="code" required class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                <div class="flex items-center">
                    <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Tiêu đề <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Kiểu giảm</label>
                        <div class="flex space-x-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="is_percent" value="0" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-bold">VNĐ</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="is_percent" value="1" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" checked>
                                <span class="ml-2 text-sm font-bold">%</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Giá trị giảm <span class="text-red-500">*</span></label>
                        <input type="number" name="discount_value" required min="0" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Tổng lượt dùng</label>
                        <input type="number" name="usage_limit" min="0" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-gray-800 text-sm font-medium text-right pr-4 md:text-left md:w-32 md:pr-0">Số lần</label>
                        <div class="flex items-center flex-1">
                            <input type="number" name="per_user_limit" min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="ml-2 text-sm text-gray-600 whitespace-nowrap">/người</span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Tối thiểu (VNĐ)</label>
                        <input type="number" name="min_order_amount" min="0" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Giảm tối đa</label>
                        <input type="number" name="max_discount" min="0" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Ngày bắt đầu</label>
                        <input type="date" name="start_date" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Ngày kết thúc</label>
                        <input type="date" name="end_date" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- <div class="flex items-center">
                         <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Trạng thái</label>
                         <select name="is_active" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500">
                             <option value="1">Hoạt động</option>
                             <option value="0">Dừng</option>
                         </select>
                    </div> -->
                </div>

                <div class="flex flex-col mt-4">
                    <label class="text-gray-800 text-sm font-medium mb-2">Mô tả</label>
                    <textarea name="description" rows="3" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
            </div>
            
            <div class="flex justify-center items-center mt-8 space-x-8">
                <button type="button" class="close-modal w-32 py-2.5 bg-[#C4C4C4] hover:bg-gray-400 text-white font-semibold rounded-lg transition-colors">Hủy</button>
                <button type="button" onclick="submitAddForm()" class="w-48 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg shadow-md transition-colors">Lưu</button>
            </div>
        </form>
    </div>
</div>

{{-- ----------------- MODAL 2: CHI TIẾT / SỬA KHUYẾN MÃI ----------------- --}}
<div id="managePromotionModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 font-open-sans">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl transform transition-all h-[90vh] overflow-y-auto custom-scrollbar flex flex-col">
        
        <h2 class="text-2xl font-bold text-center mb-6 text-[#1976D2] font-montserrat uppercase">
            QUẢN LÝ KHUYẾN MÃI
        </h2>

        <form id="managePromotionForm" class="flex-1">
            <input type="hidden" id="manage-promotion_id">

            <h3 class="text-lg font-bold text-[#1976D2] mb-4 font-montserrat">Thông tin khuyến mãi</h3>
            
            <div class="space-y-4">
                 <div class="flex items-center">
                    <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Code <span class="text-red-500">*</span></label>
                    <input type="text" id="manage-code" name="code" required class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 font-mono outline-none focus:ring-2 focus:ring-blue-500">
                 </div>

                <div class="flex items-center">
                    <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Tiêu đề <span class="text-red-500">*</span></label>
                    <input type="text" id="manage-title" name="title" required class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                    
                    {{-- RADIO BUTTONS CHO MODAL SỬA --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Kiểu giảm</label>
                        <div class="flex space-x-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="is_percent" value="0" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-bold">VNĐ</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="is_percent" value="1" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-bold">%</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Giá trị giảm <span class="text-red-500">*</span></label>
                        <input type="number" id="manage-discount_value" name="discount_value" required min="0" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Tổng lượt dùng</label>
                        <input type="number" id="manage-usage_limit" name="usage_limit" min="0" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-gray-800 text-sm font-medium text-right pr-4 md:text-left md:w-32 md:pr-0">Số lần</label>
                        <div class="flex items-center flex-1">
                            <input type="number" id="manage-per_user_limit" name="per_user_limit" min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="ml-2 text-sm text-gray-600 whitespace-nowrap">/người</span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Tối thiểu (VNĐ)</label>
                        <input type="number" id="manage-min_order_amount" name="min_order_amount" min="0" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Giảm tối đa</label>
                        <input type="number" id="manage-max_discount" name="max_discount" min="0" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Ngày bắt đầu</label>
                        <input type="date" id="manage-start_date" name="start_date" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Ngày kết thúc</label>
                        <input type="date" id="manage-end_date" name="end_date" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="flex flex-col mt-4">
                    <label class="text-gray-800 text-sm font-medium mb-2">Mô tả</label>
                    <textarea id="manage-description" name="description" rows="4" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <div class="flex items-center mt-4 w-1/2">
                    <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Trạng thái</label>
                    <select id="manage-is_active" name="is_active" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1">Hoạt động</option>
                        <option value="0">Dừng</option>
                    </select>
                </div>
            </div>

            {{-- Buttons Footer --}}
            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                 <button type="button" id="btn-delete-promotion" class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg shadow-md transition-colors flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Xóa
                 </button>

                 <div class="flex space-x-4">
                    <button type="button" class="close-modal px-8 py-2.5 bg-[#C4C4C4] hover:bg-gray-400 text-white font-semibold rounded-lg transition-colors">Hủy</button>
                    <button type="button" onclick="submitManageForm()" class="px-8 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg shadow-md transition-colors">Lưu</button>
                 </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // --- HELPERS OPEN/CLOSE MODAL ---
    window.openModal = function(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    };

    window.closeModal = function(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    };

    // --- MỞ MODAL SỬA: LẤY DATA TRỰC TIẾP TỪ THẺ TR (KHÔNG FETCH) ---
    window.openManageModalFromData = function(row) {
        const d = row.dataset;

        // Điền dữ liệu cơ bản
        document.getElementById('manage-promotion_id').value = d.promotion_id;
        document.getElementById('manage-code').value = d.code;
        document.getElementById('manage-title').value = d.title;
        document.getElementById('manage-discount_value').value = d.discount_value;
        document.getElementById('manage-description').value = d.description || '';
        
        // --- XỬ LÝ RADIO BUTTON ---
        // 1. Reset
        document.querySelectorAll('#managePromotionForm input[name="is_percent"]').forEach(r => r.checked = false);
        // 2. Tick đúng nút dựa trên value (0 hoặc 1)
        const targetRadio = document.querySelector(`#managePromotionForm input[name="is_percent"][value="${d.is_percent}"]`);
        if (targetRadio) targetRadio.checked = true;
        
        // --- XỬ LÝ DATE (Đã format Y-m-d) ---
        document.getElementById('manage-start_date').value = d.start_date || '';
        document.getElementById('manage-end_date').value = d.end_date || '';
        
        // Điền các trường còn lại
        document.getElementById('manage-usage_limit').value = d.usage_limit || '';
        document.getElementById('manage-per_user_limit').value = d.per_user_limit || '';
        document.getElementById('manage-min_order_amount').value = d.min_order_amount || '';
        document.getElementById('manage-max_discount').value = d.max_discount || '';
        document.getElementById('manage-is_active').value = d.is_active;

        openModal('managePromotionModal');
    };

    // --- SUBMIT ADD ---
    window.submitAddForm = function() {
        const form = document.getElementById('addPromotionForm');
        const formData = new FormData(form);

        fetch('/admin/promotions', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    alert(res.message || 'Thêm thành công!');
                    closeModal('addPromotionModal');
                    location.reload();
                } else {
                    alert('Lỗi: ' + (res.message || 'Không thể thêm'));
                }
            })
            .catch(() => alert('Lỗi hệ thống'));
    };

    // --- SUBMIT UPDATE ---
    window.submitManageForm = function() {
        const id = document.getElementById('manage-promotion_id').value;
        const form = document.getElementById('managePromotionForm');
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        fetch(`/admin/promotions/${id}`, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    alert(res.message || 'Cập nhật thành công!');
                    closeModal('managePromotionModal');
                    location.reload();
                } else {
                    alert('Lỗi cập nhật');
                }
            });
    };

    // --- DELETE ---
    document.getElementById('btn-delete-promotion')?.addEventListener('click', function() {
        const id = document.getElementById('manage-promotion_id')?.value;
        if (!id || !confirm('Xóa khuyến mãi này? Không thể khôi phục!')) return;

        fetch(`/admin/promotions/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    alert('Đã xóa!');
                    closeModal('managePromotionModal');
                    location.reload();
                }
            });
    });

    // --- INIT EVENTS ---
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.close-modal').forEach(b => {
            b.addEventListener('click', () => closeModal(b.closest('.modal-container').id));
        });
        document.querySelectorAll('.modal-container').forEach(m => {
            m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
        });
    });
</script>
@endpush