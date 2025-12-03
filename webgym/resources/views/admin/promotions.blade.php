@extends('layouts.ad_layout')

@section('title', 'Quản lý khuyến mãi')

@section('content')

{{-- KHỐI TẠO DỮ LIỆU GIẢ (MOCK DATA) --}}
@php
    $promotions = [
        (object)[
            'promotion_id' => 'KM0001',
            'code' => 'HE2025',
            'title' => 'Chào hè rực rỡ',
            'description' => 'Giảm giá cho các gói tập bơi lội',
            'discount_value' => 20,
            'is_percent' => 1,
            'start_date' => '2025-06-01',
            'end_date' => '2025-08-31',
            'min_order_amount' => 500000,
            'max_discount' => 100000,
            'usage_limit' => 1000,
            'per_user_limit' => 1,
            'is_active' => true,
        ],
        (object)[
            'promotion_id' => 'KM0002',
            'code' => 'NEWMEMBER',
            'title' => 'Thành viên mới',
            'description' => 'Giảm trực tiếp 100k cho lần đầu đăng ký',
            'discount_value' => 100000,
            'is_percent' => 0,
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
            'min_order_amount' => 0,
            'max_discount' => 100000,
            'usage_limit' => 500,
            'per_user_limit' => 1,
            'is_active' => true,
        ],
        (object)[
            'promotion_id' => 'KM0003',
            'code' => 'BLACKFRIDAY',
            'title' => 'Siêu sale tháng 11',
            'description' => 'Săn sale giờ vàng',
            'discount_value' => 50,
            'is_percent' => 1,
            'start_date' => '2025-11-20',
            'end_date' => '2025-11-30',
            'min_order_amount' => 1000000,
            'max_discount' => 500000,
            'usage_limit' => 100,
            'per_user_limit' => 1,
            'is_active' => false, 
        ],
        (object)[
            'promotion_id' => 'KM0004',
            'code' => 'TET2026',
            'title' => 'Lì xì đầu năm',
            'description' => 'Mừng xuân sang',
            'discount_value' => 50000,
            'is_percent' => 0,
            'start_date' => '2026-01-01',
            'end_date' => '2026-02-15',
            'min_order_amount' => 200000,
            'max_discount' => 50000,
            'usage_limit' => 2000,
            'per_user_limit' => 2,
            'is_active' => true,
        ],
    ];
@endphp

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6 font-open-sans">
    
    {{-- HEADER & BUTTONS --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Quản lý khuyến mãi</h1>
        
        <div class="flex items-center space-x-4">
            
            {{-- Dropdown lọc --}}
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900 bg-gray-100 px-3 py-1.5 rounded-lg">
                <span class="mr-1 text-sm font-medium">Hôm nay</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            {{-- Nút Thêm --}}
            <button onclick="document.getElementById('addPromotionModal').classList.remove('hidden'); document.getElementById('addPromotionModal').classList.add('flex');" class="bg-[#28A745] hover:bg-[#218838] text-white px-6 py-2 rounded-full flex items-center font-medium transition-colors shadow-sm cursor-pointer hover:shadow-md">
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
                    <th class="py-4 px-4 w-[15%] truncate">Giá trị giảm</th>
                    <th class="py-4 px-4 w-[10%] truncate">Kiểu giảm</th>
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
                        
                        $startDate = \Carbon\Carbon::parse($item->start_date)->format('d/m/Y');
                        $endDate = \Carbon\Carbon::parse($item->end_date)->format('d/m/Y');
                        
                        $statusBadge = $item->is_active 
                            ? '<span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">Hiệu lực</span>'
                            : '<span class="bg-gray-200 text-gray-500 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">Hết hiệu lực</span>';
                    @endphp

                    <tr class="{{ $rowBg }} cursor-pointer transition-colors modal-trigger group"
                        id="row-{{ $item->promotion_id }}"
                        data-promotion_id="{{ $item->promotion_id }}"
                        data-code="{{ $item->code }}"
                        data-title="{{ $item->title }}"
                        data-description="{{ $item->description }}"
                        data-discount_value="{{ $item->discount_value }}"
                        data-is_percent="{{ $item->is_percent }}"
                        data-start_date="{{ $item->start_date }}"
                        data-end_date="{{ $item->end_date }}"
                        data-min_order_amount="{{ $item->min_order_amount }}"
                        data-max_discount="{{ $item->max_discount }}"
                        data-usage_limit="{{ $item->usage_limit }}"
                        data-per_user_limit="{{ $item->per_user_limit }}"
                        data-is_active="{{ $item->is_active }}"
                    >
                        {{-- ID --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }}">
                            {{ $item->promotion_id }}
                        </td>

                        {{-- Code --}}
                        <td class="py-4 px-4 truncate align-middle font-medium font-mono text-gray-800">
                            {{ $item->code }}
                        </td>

                        {{-- Giá trị giảm --}}
                        <td class="py-4 px-4 truncate align-middle text-gray-800 font-mono">
                            {{ number_format($item->discount_value, 0, ',', '.') }}
                        </td>

                        {{-- Kiểu giảm --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $item->is_percent ? '%' : 'VNĐ' }}
                        </td>

                        {{-- Ngày bắt đầu --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $startDate }}
                        </td>

                        {{-- Ngày kết thúc --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $endDate }}
                        </td>

                        {{-- Trạng thái --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            {!! $statusBadge !!}
                        </td>
                    </tr>
                    
                    <tr class="h-2"></tr> 
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center items-center space-x-2">
            <button class="px-3 py-1 rounded bg-gray-200 text-gray-600 hover:bg-gray-300 disabled:opacity-50" disabled>&laquo;</button>
            <button class="px-3 py-1 rounded bg-blue-600 text-white font-bold">1</button>
            <button class="px-3 py-1 rounded hover:bg-gray-200 text-gray-700">2</button>
            <button class="px-3 py-1 rounded bg-gray-200 text-gray-600 hover:bg-gray-300">&raquo;</button>
        </div>
    </div>
</div>

{{-- ----------------- MODAL 1: THÊM KHUYẾN MÃI ----------------- --}}
<div id="addPromotionModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 font-open-sans">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl transform transition-all h-[90vh] overflow-y-auto custom-scrollbar">
        <h2 class="text-2xl font-bold text-center mb-6 text-[#1976D2] font-montserrat uppercase">
            THÊM KHUYẾN MÃI
        </h2>
        
        <form id="addPromotionForm">
            <h3 class="text-lg font-bold text-[#1976D2] mb-4 font-montserrat">Thông tin khuyến mãi</h3>
            
            <div class="space-y-4">
                {{-- Row 1: Code --}}
                <div class="flex items-center">
                    <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Code</label>
                    <input type="text" name="code" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                {{-- Row 2: Tiêu đề --}}
                <div class="flex items-center">
                    <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Tiêu đề</label>
                    <input type="text" name="title" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                {{-- Grid 2 columns for pairs --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                    
                    {{-- Row 3 --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Kiểu giảm</label>
                        <div class="flex space-x-6">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="is_percent" value="0" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" checked>
                                <span class="ml-2 text-sm font-bold">VND</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" name="is_percent" value="1" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="ml-2 text-sm font-bold">%</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Giá trị giảm</label>
                        <input type="number" name="discount_value" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- Row 4 --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Tổng lượt dùng</label>
                        <input type="number" name="usage_limit" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-gray-800 text-sm font-medium text-right pr-4 md:text-left md:w-32 md:pr-0">Số lần</label>
                        <div class="flex items-center flex-1">
                            <input type="number" name="per_user_limit" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="ml-2 text-sm text-gray-600 whitespace-nowrap">/người</span>
                        </div>
                    </div>

                    {{-- Row 5 --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Tối thiểu (VNĐ)</label>
                        <input type="number" name="min_order_amount" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Giảm tối đa (VNĐ)</label>
                        <input type="number" name="max_discount" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- Row 6 --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Ngày bắt đầu</label>
                        <input type="date" name="start_date" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Ngày kết thúc</label>
                        <input type="date" name="end_date" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                {{-- Row 7: Description --}}
                <div class="flex flex-col mt-4">
                    <label class="text-gray-800 text-sm font-medium mb-2">Mô tả</label>
                    <textarea name="description" rows="4" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Mô tả ở đây nè"></textarea>
                </div>
            </div>
            
            <div class="flex justify-center items-center mt-8 space-x-8">
                <button type="button" class="close-modal w-32 py-2.5 bg-[#C4C4C4] hover:bg-gray-400 text-white font-semibold rounded-lg transition-colors">Hủy</button>
                <button type="submit" class="w-48 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg shadow-md transition-colors">Thêm thông tin</button>
            </div>
        </form>
    </div>
</div>

{{-- ----------------- MODAL 2: CHI TIẾT / SỬA KHUYẾN MÃI (UPDATED) ----------------- --}}
<div id="managePromotionModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 font-open-sans">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl transform transition-all h-[90vh] overflow-y-auto custom-scrollbar">
        
        <h2 class="text-2xl font-bold text-center mb-6 text-[#1976D2] font-montserrat uppercase">
            QUẢN LÝ KHUYẾN MÃI
        </h2>

        <form id="managePromotionForm">
            <h3 class="text-lg font-bold text-[#1976D2] mb-4 font-montserrat">Thông tin khuyến mãi</h3>
            
            <div class="space-y-4">
                 {{-- Row 1: ID & Code --}}
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">ID</label>
                        <input type="text" id="manage-promotion_id" readonly class="flex-1 bg-gray-200 border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none cursor-not-allowed">
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Code</label>
                        <input type="text" id="manage-code" readonly class="flex-1 bg-gray-200 border border-gray-300 rounded-lg px-4 py-2 text-gray-700 font-mono outline-none cursor-not-allowed">
                    </div>
                 </div>

                {{-- Row 2: Tiêu đề --}}
                <div class="flex items-center">
                    <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Tiêu đề</label>
                    <input type="text" id="manage-title" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                    
                    {{-- Row 3: Kiểu giảm & Giá trị giảm (READONLY / DISABLED) --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Kiểu giảm</label>
                        <div class="flex space-x-6">
                            <label class="flex items-center cursor-not-allowed opacity-70">
                                <input type="radio" name="manage-is_percent" value="0" disabled class="w-4 h-4 text-gray-500 border-gray-300">
                                <span class="ml-2 text-sm font-bold text-gray-600">VNĐ</span>
                            </label>
                            <label class="flex items-center cursor-not-allowed opacity-70">
                                <input type="radio" name="manage-is_percent" value="1" disabled class="w-4 h-4 text-gray-500 border-gray-300">
                                <span class="ml-2 text-sm font-bold text-gray-600">%</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Giá trị giảm</label>
                        <input type="number" id="manage-discount_value" readonly class="flex-1 bg-gray-200 border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none cursor-not-allowed">
                    </div>

                    {{-- Row 4 --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Tổng lượt dùng</label>
                        <input type="number" id="manage-usage_limit" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-gray-800 text-sm font-medium text-right pr-4 md:text-left md:w-32 md:pr-0">Số lần</label>
                        <div class="flex items-center flex-1">
                            <input type="number" id="manage-per_user_limit" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <span class="ml-2 text-sm text-gray-600 whitespace-nowrap">/người</span>
                        </div>
                    </div>

                    {{-- Row 5 --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Tối thiểu (VNĐ)</label>
                        <input type="number" id="manage-min_order_amount" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Giảm tối đa (VNĐ)</label>
                        <input type="number" id="manage-max_discount" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- Row 6 --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Ngày bắt đầu</label>
                        <input type="date" id="manage-start_date" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Ngày kết thúc</label>
                        <input type="date" id="manage-end_date" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                {{-- Row 7: Description --}}
                <div class="flex flex-col mt-4">
                    <label class="text-gray-800 text-sm font-medium mb-2">Mô tả</label>
                    <textarea id="manage-description" rows="4" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Mô tả ở đây nè"></textarea>
                </div>

                {{-- Row 8: Status --}}
                <div class="flex items-center mt-4 w-1/2">
                    <label class="w-32 flex-shrink-0 text-gray-800 text-sm font-medium">Trạng thái</label>
                    <select id="manage-is_active" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-700 outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1">Hiệu lực</option>
                        <option value="0">Hết hiệu lực</option>
                    </select>
                </div>
            </div>

            {{-- Buttons Footer (UPDATED) --}}
            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                 <button type="button" id="btn-delete-promotion" class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg shadow-md transition-colors flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Xóa
                 </button>

                 <div class="flex space-x-4">
                    <button type="button" class="close-modal px-8 py-2.5 bg-[#C4C4C4] hover:bg-gray-400 text-white font-semibold rounded-lg transition-colors">Hủy</button>
                    <button type="submit" class="px-8 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg shadow-md transition-colors">Lưu thông tin</button>
                 </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- HELPERS ---
        function closeModal(m) { m.classList.add('hidden'); m.classList.remove('flex'); }
        function openModal(m) { m.classList.remove('hidden'); m.classList.add('flex'); }

        document.querySelectorAll('.close-modal').forEach(b => b.addEventListener('click', () => {
            closeModal(b.closest('.modal-container'));
        }));

        document.querySelectorAll('.modal-container').forEach(m => m.addEventListener('click', e => {
            if (e.target === m) closeModal(m);
        }));

        // --- OPEN MANAGE MODAL (Click vào dòng bảng) ---
        document.getElementById('promotion-list-body').addEventListener('click', e => {
            const row = e.target.closest('tr.modal-trigger');
            if (!row) return;
            
            const d = row.dataset; 

            // Điền dữ liệu vào form modal
            document.getElementById('manage-promotion_id').value = d.promotion_id;
            document.getElementById('manage-code').value = d.code;
            document.getElementById('manage-title').value = d.title;
            document.getElementById('manage-discount_value').value = d.discount_value;
            
            // Radio button handling (Chỉ hiển thị, không cho sửa)
            const radioName = 'manage-is_percent';
            const radios = document.getElementsByName(radioName);
            for(let r of radios) {
                if(r.value == d.is_percent) r.checked = true;
            }

            document.getElementById('manage-usage_limit').value = d.usage_limit;
            document.getElementById('manage-per_user_limit').value = d.per_user_limit;
            document.getElementById('manage-min_order_amount').value = d.min_order_amount;
            document.getElementById('manage-max_discount').value = d.max_discount;
            document.getElementById('manage-start_date').value = d.start_date;
            document.getElementById('manage-end_date').value = d.end_date;
            document.getElementById('manage-description').value = d.description;

            // Set status select
            document.getElementById('manage-is_active').value = d.is_active;

            openModal(document.getElementById('managePromotionModal'));
        });

        // --- SUBMIT FORMS (Fake Action) ---
        document.getElementById('managePromotionForm').onsubmit = async (e) => {
            e.preventDefault();
            alert('Đã lưu cập nhật khuyến mãi thành công (Fake)!');
            closeModal(document.getElementById('managePromotionModal'));
        };

        document.getElementById('addPromotionForm').onsubmit = async (e) => {
            e.preventDefault();
            alert('Đã thêm khuyến mãi mới thành công (Fake)!');
            closeModal(document.getElementById('addPromotionModal'));
        };

        // --- XỬ LÝ NÚT XÓA ---
        document.getElementById('btn-delete-promotion').addEventListener('click', function() {
            const id = document.getElementById('manage-promotion_id').value;
            if (confirm('Bạn có chắc chắn muốn xóa khuyến mãi ' + id + ' không? Hành động này không thể hoàn tác.')) {
                // Gọi AJAX xóa ở đây (nếu có backend)
                alert('Đã xóa khuyến mãi ' + id + ' thành công (Fake)!');
                closeModal(document.getElementById('managePromotionModal'));
            }
        });
    });
</script>
@endpush