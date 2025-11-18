@extends('layouts.ad_layout')

@section('title', 'Quản lý gói tập')

@section('content')

{{-- DỮ LIỆU DUMMY CHO GÓI TẬP & STATUS OPTIONS --}}
@php
// Dữ liệu giả (dummy data) cho Gói tập
$membership_packages = [
    (object)[
        'package_id' => 'GT0001',
        'package_name' => 'Gói tháng',
        'price' => 1000000,
        'duration_months' => 1,
        'description' => 'Tập không giới hạn, ...',
        'status' => 'active',
        'slug' => 'goi-thang',
        'image_url' => 'https://via.placeholder.com/160x160.png?text=Goi+1+Thang',
        'is_featured' => true // Nổi bật
    ],
    (object)[
        'package_id' => 'GT0002',
        'package_name' => 'Gói quý',
        'price' => 1000000,
        'duration_months' => 3,
        'description' => 'Tặng 1 buổi PT cá nhân, ...',
        'status' => 'active',
        'slug' => 'goi-quy',
        'image_url' => 'https://via.placeholder.com/160x160.png?text=Goi+Quy',
        'is_featured' => false // Không nổi bật
    ],
    (object)[
        'package_id' => 'GT0003',
        'package_name' => 'Gói năm',
        'price' => 1000000,
        'duration_months' => 12,
        'description' => 'Tặng 5 buổi PT/thăm, ...',
        'status' => 'active',
        'slug' => 'goi-nam',
        'image_url' => 'https://via.placeholder.com/160x160.png?text=Goi+Nam',
        'is_featured' => true // Nổi bật
    ],
    (object)[
        'package_id' => 'GT0004',
        'package_name' => 'Gói PT cá nhân',
        'price' => 1000000,
        'duration_months' => 1,
        'description' => 'Huấn luyện viên cá nhân, ...',
        'status' => 'active',
        'slug' => 'goi-pt-ca-nhan',
        'image_url' => 'https://via.placeholder.com/160x160.png?text=Goi+PT',
        'is_featured' => false // Không nổi bật
    ],
    (object)[
        'package_id' => 'GT0005',
        'package_name' => 'Gói nửa năm',
        'price' => 1000000,
        'duration_months' => 6,
        'description' => 'Tập không giới hạn, ...',
        'status' => 'inactive',
        'slug' => 'goi-nua-nam',
        'image_url' => 'https://via.placeholder.com/160x160.png?text=Goi+6+Thang',
        'is_featured' => false // Không nổi bật
    ],
];

// Dữ liệu cho Custom Select Trạng thái
$status_options = [
    'active' => 'Đang hoạt động',
    'inactive' => 'Dừng hoạt động',
];
@endphp

{{-- Header --}}
<div class="flex justify-end items-center mb-6">
    <div class="flex items-center space-x-3 text-sm text-gray-500 mr-4">
        <span class="font-medium">Hôm nay</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>
    <button id="openAddModalBtn"
        class="flex items-center px-4 py-2 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 transition-colors duration-150 shadow-md">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4v16m8-8H4"></path>
        </svg>
        Thêm
    </button>
</div>

{{-- Bảng danh sách Gói tập --}}
<div class="bg-white p-6 rounded-lg shadow-xl">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Gói tập</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border-separate border-spacing-y-2">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-[5%]"></th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Mã gói tập</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[15%]">Tên gói tập</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[15%]">Giá tiền</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[15%]">Thời hạn (tháng)</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase flex-1">Mô tả</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase w-[15%]">Trạng thái</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($membership_packages as $package)
                <tr class="transition duration-150 cursor-pointer modal-trigger"
                    data-package_id="{{ $package->package_id }}"
                    data-package_name="{{ $package->package_name }}"
                    data-price="{{ $package->price }}"
                    data-duration_months="{{ $package->duration_months }}"
                    data-description="{{ $package->description }}"
                    data-status="{{ $package->status }}"
                    data-slug="{{ $package->slug }}"
                    data-image_url="{{ $package->image_url }}"
                    data-is_featured="{{ $package->is_featured ? 'true' : 'false' }}"
                >
                    
                    <td colspan="7" class="p-0">
                        <div class="flex w-full rounded-lg items-center 
                                {{ $loop->even ? 'bg-white' : 'bg-[#1976D2]/10' }}
                                shadow-sm overflow-hidden">
                            
                            {{-- CỘT MỚI: Ngôi sao --}}
                            <div class="px-4 py-3 w-[5%] text-center">
                                @if ($package->is_featured)
                                    <svg class="w-5 h-5 text-yellow-500 mx-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.002 8.71c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endif
                            </div>

                            <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900">
                                {{ $package->package_id }}
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700">
                                {{ $package->package_name }}
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700">
                                {{ number_format($package->price, 0, ',', '.') }} VND
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700">
                                {{ $package->duration_months }} tháng
                            </div>
                            <div class="px-4 py-3 flex-1 text-sm text-gray-700 truncate" title="{{ $package->description }}">
                                {{ $package->description }}
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-right">
                                @if ($package->status == 'active')
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800">
                                        Đang hoạt động
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-gray-200 text-gray-800">
                                        Dừng hoạt động
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

---

{{-- ================================================================= --}}
{{-- =================== HTML CHO CÁC MODAL CẬP NHẬT ================= --}}
{{-- ================================================================= --}}


{{-- ----------------- MODAL 1: THÊM GÓI TẬP (GIỮ NGUYÊN) ----------------- --}}
<div id="addPackageModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl"> 
        
        <h2 class="text-3xl font-bold text-center mb-6 
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] 
            bg-clip-text text-transparent">
            THÊM GÓI TẬP
        </h2>
        
        <form>
            {{-- Phần Thông tin --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin gói tập</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Cột ảnh --}}
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img src="https://via.placeholder.com/160x160.png?text=Image" alt="Package Image" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" class="flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Upload ảnh
                    </button>
                    {{-- Thêm input file ẩn cho image_url --}}
                    <input type="file" id="add-image_url" class="hidden">
                </div>

                {{-- Cột thông tin --}}
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-4">
                        <label for="add-package_name" class="block text-sm font-medium text-gray-700 w-1/3">Tên gói tập</label>
                        <input type="text" id="add-package_name" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <label for="add-duration_months" class="block text-sm font-medium text-gray-700 w-1/3">Thời hạn (tháng)</label>
                        <input type="number" id="add-duration_months" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    <div class="flex items-center space-x-4">
                        <label for="add-price" class="block text-sm font-medium text-gray-700 w-1/3">Giá tiền (VNĐ)</label>
                        <input type="number" id="add-price" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="flex items-start space-x-4 mb-4">
                <label for="add-description" class="block text-sm font-medium text-gray-700 w-1/4 pt-2.5">Mô tả</label>
                <textarea id="add-description" rows="5" class="w-3/4 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
            </div>
            
            {{-- Toggle Switch Gói nổi bật (Add Modal) --}}
            <div class="flex items-center space-x-4 mb-8">
                <label class="block text-sm font-medium text-gray-700 w-1/4">Gói tập nổi bật</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" id="add-is_featured" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900"></span>
                </label>
            </div>


            {{-- Nút bấm --}}
            <div class="flex justify-center space-x-4 mt-8">
                <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                    Hủy
                </button>
                <button type="submit" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Thêm thông tin
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ----------------- MODAL 2: QUẢN LÝ GÓI TẬP (CẬP NHẬT TRẠNG THÁI) ----------------- --}}
<div id="managePackageModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl"> 
        
        <h2 class="text-3xl font-bold text-center mb-6 
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] 
            bg-clip-text text-transparent">
            QUẢN LÝ GÓI TẬP
        </h2>
        
        <form>
            {{-- Phần Thông tin --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin gói tập</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Cột ảnh --}}
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="manage-image_url" src="https://via.placeholder.com/160x160.png?text=Image" alt="Package Image" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" class="flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Upload ảnh
                    </button>
                    {{-- Thêm input file ẩn --}}
                    <input type="file" id="manage-image_url_input" class="hidden">
                </div>

                {{-- Cột thông tin --}}
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-4">
                        <label for="manage-package_id" class="block text-sm font-medium text-gray-700 w-1/3">ID</label>
                        <input type="text" id="manage-package_id" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm bg-gray-100 px-4 py-2.5" readonly>
                    </div>
                
                    <div class="flex items-center space-x-4">
                        <label for="manage-package_name" class="block text-sm font-medium text-gray-700 w-1/3">Tên gói tập</label>
                        <input type="text" id="manage-package_name" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <label for="manage-duration_months" class="block text-sm font-medium text-gray-700 w-1/3">Thời hạn (tháng)</label>
                        <input type="number" id="manage-duration_months" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    <div class="flex items-center space-x-4">
                        <label for="manage-price" class="block text-sm font-medium text-gray-700 w-1/3">Giá tiền (VNĐ)</label>
                        <input type="number" id="manage-price" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="mb-4 flex items-start space-x-4">
                <label for="manage-description" class="block text-sm font-medium text-gray-700 w-1/4 pt-2.5">Mô tả</label>
                <textarea id="manage-description" rows="5" class="w-3/4 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
            </div>
            
            {{-- Toggle Switch Gói nổi bật (Manage Modal) --}}
            <div class="flex items-center space-x-4 mb-4">
                <label class="block text-sm font-medium text-gray-700 w-1/4">Gói tập nổi bật</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" id="manage-is_featured" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-900"></span>
                </label>
            </div>

            {{-- Trạng thái (DÙNG CUSTOM SELECT COMPONENT) --}}
            <div class="flex items-center space-x-4">
                <label class="block text-sm font-medium text-gray-700 w-1/4">Trạng thái</label>
                <div class="relative custom-multiselect w-1/2" data-select-id="manage-status-custom" data-type="single"> 
                    <select id="manage-status-custom-hidden-select" name="manage_status" class="hidden">
                         @foreach($status_options as $value => $label)
                             <option value="{{ $value }}">{{ $label }}</option>
                         @endforeach
                    </select>
                    <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                        <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                        <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                            @foreach($status_options as $value => $label)
                            <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $value }}">
                                <div class="flex items-center space-x-3 w-full pointer-events-none">
                                    <span class="text-sm font-medium text-gray-900">{{ $label }}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Nút bấm --}}
            <div class="flex justify-center space-x-4 mt-8">
                <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                    Hủy
                </button>
                <button type="submit" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Lưu thông tin
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<style>
/* === CUSTOM STYLES CHO CUSTOM SELECT COMPONENT (Dùng @apply Tailwind) === */

/* Màu Hover: Xám (#999999) 50% opacity */
.custom-multiselect-option:hover {
    /* Đã sửa: bg-[#999999]/50 */
    @apply bg-[#999999]/50 text-gray-900; 
}
.custom-multiselect-option:hover span {
    @apply text-gray-900; /* Đảm bảo chữ đen trên nền mờ */
}

/* Màu Selected: Xanh Blue 50% opacity */
.custom-multiselect-option.bg-blue-100 {
    /* Đã sửa: bg-blue-500/50 */
    @apply bg-blue-500/50 text-gray-900; 
}
.custom-multiselect-option.bg-blue-100 span {
    @apply text-gray-900; 
}

/* Khi hover lên mục đã chọn, áp dụng style hover xám 50% */
.custom-multiselect-option.bg-blue-100:hover {
    @apply bg-[#999999]/50 text-gray-900;
}

/* Đảm bảo trạng thái ban đầu của option */
.custom-multiselect-option {
    @apply bg-white text-gray-900;
}
</style>
<script>
// --- START: CUSTOM SELECT SCRIPT (Giữ nguyên logic) ---

/**
 * Cập nhật văn bản hiển thị
 */
function updateMultiselectDisplay(multiselectContainer) {
    const hiddenSelect = multiselectContainer.querySelector('select');
    const displaySpan = multiselectContainer.querySelector('.custom-multiselect-display');
    const selectedOptions = Array.from(hiddenSelect.selectedOptions);
    
    // Đảm bảo placeholder cho single select
    let placeholder = 'Chọn...';
    if (multiselectContainer.dataset.selectId === 'manage-status-custom') {
        placeholder = 'Chọn trạng thái...';
    }

    if (selectedOptions.length === 0 || (selectedOptions.length === 1 && selectedOptions[0].value === "")) {
        displaySpan.textContent = placeholder;
        displaySpan.classList.add('text-gray-500');
    } else {
        displaySpan.textContent = selectedOptions.map(opt => opt.text).join(', ');
        displaySpan.classList.remove('text-gray-500');
    }
}

/**
 * Đặt (set) giá trị cho custom multiselect
 */
function setCustomMultiselectValues(multiselectContainer, valuesString, delimiter = ',') {
    if (!multiselectContainer) return;

    const hiddenSelect = multiselectContainer.querySelector('select');
    const optionsList = multiselectContainer.querySelector('.custom-multiselect-list');
    
    const selectedValues = valuesString ? String(valuesString).split(delimiter).map(v => v.trim()) : [];
    
    // 1. Reset tất cả các lựa chọn cũ
    Array.from(hiddenSelect.options).forEach(option => option.selected = false);
    if (optionsList) {
        optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
            li.classList.remove('bg-blue-100'); 
        });
    }

    // 2. Đặt các giá trị mới (so khớp bằng VALUE)
    selectedValues.forEach(value => {
        const option = hiddenSelect.querySelector(`option[value="${value}"]`);
        if (option) {
            option.selected = true;
        }
        
        if (optionsList) {
            const li = optionsList.querySelector(`.custom-multiselect-option[data-value="${value}"]`);
            if (li) {
                // Giữ lại class này để CSS tùy chỉnh áp dụng style Selected
                li.classList.add('bg-blue-100'); 
            }
        }
    });

    // 3. Cập nhật lại text hiển thị
    updateMultiselectDisplay(multiselectContainer);
}

/**
 * Khởi tạo tất cả các component '.custom-multiselect'
 */
function initializeCustomMultiselects() {
    document.querySelectorAll('.custom-multiselect').forEach(container => {
        const trigger = container.querySelector('.custom-multiselect-trigger');
        const panel = container.querySelector('.custom-multiselect-panel');
        const searchInput = container.querySelector('.custom-multiselect-search');
        const optionsList = container.querySelector('.custom-multiselect-list');
        const hiddenSelect = container.querySelector('select'); 
        const displaySpan = container.querySelector('.custom-multiselect-display');
        
        // Gán placeholder cho lần đầu
        if (displaySpan && !displaySpan.dataset.placeholder) {
            displaySpan.dataset.placeholder = displaySpan.textContent;
        }

        // 1. Mở/đóng dropdown
        if (trigger) {
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('.custom-multiselect-panel').forEach(p => {
                    if (p !== panel) p.classList.add('hidden');
                });
                if (panel) panel.classList.toggle('hidden');
                if (panel && !panel.classList.contains('hidden') && searchInput) {
                    // searchInput.focus(); // Tạm thời comment do không có search
                }
            });
        }

        // 2. Xử lý khi chọn một mục
        if (optionsList) {
            optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
                li.addEventListener('click', (e) => {
                    e.stopPropagation(); 
                    
                    const value = li.dataset.value;
                    const option = hiddenSelect.querySelector(`option[value="${value}"]`);

                    if (container.dataset.type === 'single') {
                        // === LOGIC CHO SINGLE-SELECT ===
                        hiddenSelect.value = value; 
                        optionsList.querySelectorAll('.custom-multiselect-option').forEach(otherLi => {
                            otherLi.classList.remove('bg-blue-100');
                        });
                        li.classList.add('bg-blue-100');
                        if (panel) panel.classList.add('hidden'); 
                    } else {
                        // === LOGIC CHO MULTI-SELECT (Không áp dụng cho Trạng thái) ===
                        if(option) {
                            option.selected = !option.selected; 
                            li.classList.toggle('bg-blue-100', option.selected); 
                        }
                    }
                    
                    updateMultiselectDisplay(container);
                });
            });
        }
        
        // Cập nhật hiển thị ban đầu
        updateMultiselectDisplay(container);
    });
}

// Đóng tất cả dropdown khi click ra ngoài
document.addEventListener('click', (e) => {
    if (!e.target.closest('.custom-multiselect')) {
        document.querySelectorAll('.custom-multiselect-panel').forEach(panel => {
            panel.classList.add('hidden');
        });
    }
});

// --- END: CUSTOM SELECT SCRIPT ---

// --- SCRIPT QUẢN LÝ MODAL (ĐÃ CẬP NHẬT) ---
document.addEventListener('DOMContentLoaded', function() {
    
    initializeCustomMultiselects(); // Khởi tạo Custom Select
    
    const addModal = document.getElementById('addPackageModal');
    const manageModal = document.getElementById('managePackageModal');

    const openAddBtn = document.getElementById('openAddModalBtn');
    const rowTriggers = document.querySelectorAll('tr.modal-trigger');

    const closeTriggers = document.querySelectorAll('.close-modal');
    const modalContainers = document.querySelectorAll('.modal-container');

    function openModal(modal) {
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModal(modal) {
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    // --- SỰ KIỆN MỞ MODAL ---

    // 1. Mở modal "Thêm"
    if (openAddBtn) {
        openAddBtn.addEventListener('click', function() {
            openModal(addModal);
        });
    }

    // 2. Mở modal "Quản lý" khi nhấn vào dòng
    rowTriggers.forEach(row => {
        row.addEventListener('click', function() {
            const data = this.dataset;

            document.getElementById('manage-package_id').value = data.package_id;
            document.getElementById('manage-package_name').value = data.package_name;
            document.getElementById('manage-duration_months').value = data.duration_months;
            document.getElementById('manage-price').value = data.price;
            document.getElementById('manage-description').value = data.description;
            
            // CẬP NHẬT: Xử lý is_featured
            const isFeaturedCheckbox = document.getElementById('manage-is_featured');
            const isFeatured = data.is_featured === 'true'; 
            isFeaturedCheckbox.checked = isFeatured;

            // Cập nhật ảnh
            const avatarImg = document.getElementById('manage-image_url');
            if (data.image_url) {
                avatarImg.src = data.image_url;
            } else {
                avatarImg.src = '[https://via.placeholder.com/160x160.png?text=Image](https://via.placeholder.com/160x160.png?text=Image)';
            }

            // CẬP NHẬT: Set custom single-select cho Trạng thái
            const statusContainer = document.querySelector('.custom-multiselect[data-select-id="manage-status-custom"]');
            setCustomMultiselectValues(statusContainer, data.status, ',');

            // Mở modal
            openModal(manageModal);
        });
    });

    // --- SỰ KIỆN ĐÓNG MODAL ---

    // 1. Đóng modal khi nhấn nút "Hủy"
    closeTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modal = this.closest('.modal-container');
            closeModal(modal);
        });
    });

    // 2. Đóng modal khi nhấn vào nền mờ
    modalContainers.forEach(container => {
        container.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this);
            }
        });
    });

    // 3. Đóng modal khi nhấn phím Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal(addModal);
            closeModal(manageModal);
        }
    });
});
</script>
@endpush
