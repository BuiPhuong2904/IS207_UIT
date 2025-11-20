@extends('layouts.ad_layout')

@section('title', 'Quản lý gói tập')

@section('content')

{{-- 1. THÊM CSRF TOKEN ĐỂ AJAX CHẠY ĐƯỢC --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

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

            <tbody id="packageTableBody"> 
                {{-- 2. LOOP DỮ LIỆU THẬT TỪ DATABASE --}}
                @foreach ($packages as $package)
                <tr class="transition duration-150 cursor-pointer modal-trigger"
                    id="row-{{ $package->package_id }}"
                    {{-- DATA attributes để đổ dữ liệu vào Modal --}}
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
                                shadow-sm overflow-hidden package-row-content">
                            
                            {{-- Cột: Ngôi sao --}}
                            <div class="px-4 py-3 w-[5%] text-center star-icon">
                                @if ($package->is_featured)
                                    <svg class="w-5 h-5 text-yellow-500 mx-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.002 8.71c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endif
                            </div>

                            {{-- Format ID dạng GT + 4 số --}}
                            <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900 package-id-display">
                                GT{{ str_pad($package->package_id, 4, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700 package-name-display">
                                {{ $package->package_name }}
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700 package-price-display">
                                {{ number_format($package->price, 0, ',', '.') }} VND
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700 package-duration-display">
                                @if($package->duration_months)
                                    {{ $package->duration_months }} tháng
                                @else
                                    <span class="text-gray-700 font-medium">Theo ngày</span>
                                @endif
                            </div>
                            <div class="px-4 py-3 flex-1 text-sm text-gray-700 truncate package-description-display" title="{{ $package->description }}">
                                {{ $package->description }}
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-right package-status-display">
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
        {{-- Phân trang --}}
        <div class="mt-4">
            {{ $packages->links() }}
        </div>
    </div>
</div>


{{-- ----------------- MODAL 1: THÊM GÓI TẬP (GIỮ NGUYÊN) ----------------- --}}
<div id="addPackageModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl"> 
        
        <h2 class="text-3xl font-bold text-center mb-6 
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] 
            bg-clip-text text-transparent">
            THÊM GÓI TẬP
        </h2>
        
        <form id="addPackageForm">
            {{-- Phần Thông tin --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin gói tập</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Cột ảnh --}}
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="add-image-preview" src="https://via.placeholder.com/160x160.png?text=Image" alt="Package Image" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="add-upload-btn" class="flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Upload ảnh
                    </button>
                    <input type="file" id="add-image_url" accept="image/*" class="hidden"> 
                </div>

                {{-- Cột thông tin --}}
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-4">
                        <label for="add-package_name" class="block text-sm font-medium text-gray-700 w-1/3">Tên gói tập</label>
                        <input type="text" id="add-package_name" required class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <label for="add-duration_months" class="block text-sm font-medium text-gray-700 w-1/3">Thời hạn (tháng)</label>
                        <input type="number" id="add-duration_months" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black" min="1">
                    </div>

                    <div class="flex items-center space-x-4">
                        <label for="add-price" class="block text-sm font-medium text-gray-700 w-1/3">Giá tiền (VNĐ)</label>
                        <input type="number" id="add-price" required class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black" min="0">
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="flex items-start space-x-4 mb-4">
                <label for="add-description" class="block text-sm font-medium text-gray-700 w-1/4 pt-2.5">Mô tả</label>
                <textarea id="add-description" rows="5" class="w-3/4 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
            </div>
            
            {{-- Toggle Switch Gói nổi bật --}}
            <div class="flex items-center space-x-4 mb-8">
                <label class="block text-sm font-medium text-gray-700 w-1/4">Gói tập nổi bật</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" id="add-is_featured" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
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
<div id="managePackageModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl"> 
        
        <h2 class="text-3xl font-bold text-center mb-6 
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] 
            bg-clip-text text-transparent">
            QUẢN LÝ GÓI TẬP
        </h2>
        
        <form id="managePackageForm">
            {{-- 3. INPUT ẨN ĐỂ BIẾT ĐANG SỬA ID NÀO --}}
            <input type="hidden" id="current-db-id">

            {{-- Phần Thông tin --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin gói tập</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Cột ảnh --}}
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="manage-image_url" src="https://via.placeholder.com/160x160.png?text=Image" alt="Package Image" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="manage-upload-btn" class="flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Upload ảnh
                    </button>
                    <input type="file" id="manage-image_url_input" accept="image/*" class="hidden">
                </div>

                {{-- Cột thông tin --}}
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-4">
                        <label for="manage-package_id" class="block text-sm font-medium text-gray-700 w-1/3">Mã Gói</label>
                        <input type="text" id="manage-package_id" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm bg-gray-100 px-4 py-2.5" readonly>
                    </div>
                
                    <div class="flex items-center space-x-4">
                        <label for="manage-package_name" class="block text-sm font-medium text-gray-700 w-1/3">Tên gói tập</label>
                        <input type="text" id="manage-package_name" required class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <label for="manage-duration_months" class="block text-sm font-medium text-gray-700 w-1/3">Thời hạn (tháng)</label>
                        <input type="number" id="manage-duration_months" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black" min="1">
                    </div>

                    <div class="flex items-center space-x-4">
                        <label for="manage-price" class="block text-sm font-medium text-gray-700 w-1/3">Giá tiền (VNĐ)</label>
                        <input type="number" id="manage-price" required class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black" min="0">
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="mb-4 flex items-start space-x-4">
                <label for="manage-description" class="block text-sm font-medium text-gray-700 w-1/4 pt-2.5">Mô tả</label>
                <textarea id="manage-description" rows="5" class="w-3/4 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
            </div>
            
            {{-- Toggle Switch Gói nổi bật --}}
            <div class="flex items-center space-x-4 mb-4">
                <label class="block text-sm font-medium text-gray-700 w-1/4">Gói tập nổi bật</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" id="manage-is_featured" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>

            {{-- Trạng thái (CUSTOM SELECT) --}}
            <div class="flex items-center space-x-4">
                <label class="block text-sm font-medium text-gray-700 w-1/4">Trạng thái</label>
                <div class="relative custom-multiselect w-1/2" data-select-id="manage-status-custom" data-type="single"> 
                    <select id="manage-status-custom-hidden-select" name="manage_status" class="hidden">
                         <option value="active">Đang hoạt động</option>
                         <option value="inactive">Dừng hoạt động</option>
                    </select>
                    <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                        <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                        <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                            <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="active">
                                <div class="flex items-center space-x-3 w-full pointer-events-none"><span class="text-sm font-medium text-gray-900">Đang hoạt động</span></div>
                            </li>
                            <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="inactive">
                                <div class="flex items-center space-x-3 w-full pointer-events-none"><span class="text-sm font-medium text-gray-900">Dừng hoạt động</span></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Nút bấm (ĐÃ THÊM NÚT XÓA) --}}
            <div class="flex justify-between space-x-4 mt-8">
                 <button type="button" id="btn-delete-package" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 font-medium">
                    Xóa gói này
                </button>

                <div class="flex space-x-4">
                    <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                        Hủy
                    </button>
                    <button type="submit" class="px-8 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"> 
                        Cập nhật
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<style>
/* === CUSTOM STYLES CHO CUSTOM SELECT (GIỮ NGUYÊN) === */
.custom-multiselect-option:hover { @apply bg-[#999999]/50 text-gray-900; }
.custom-multiselect-option:hover span { @apply text-gray-900; }
.custom-multiselect-option.bg-blue-100 { @apply bg-blue-500/50 text-gray-900; }
.custom-multiselect-option.bg-blue-100 span { @apply text-gray-900; }
.custom-multiselect-option.bg-blue-100:hover { @apply bg-[#999999]/50 text-gray-900; }
.custom-multiselect-option { @apply bg-white text-gray-900; }
</style>

<script>
// --- 4. SCRIPT CUSTOM SELECT (GIỮ NGUYÊN KHÔNG SỬA) ---
function updateMultiselectDisplay(container) {
    const hiddenSelect = container.querySelector('select');
    const displaySpan = container.querySelector('.custom-multiselect-display');
    const selected = Array.from(hiddenSelect.selectedOptions);
    
    let placeholder = 'Chọn...';
    if (container.dataset.selectId === 'manage-status-custom') placeholder = 'Chọn trạng thái...';

    if (selected.length === 0 || (selected.length === 1 && selected[0].value === "")) {
        displaySpan.textContent = placeholder;
        displaySpan.classList.add('text-gray-500');
    } else {
        displaySpan.textContent = selected.map(opt => opt.text).join(', ');
        displaySpan.classList.remove('text-gray-500');
    }
}

function setCustomMultiselectValues(container, valuesString, delimiter = ',') {
    if (!container) return;
    const hiddenSelect = container.querySelector('select');
    const optionsList = container.querySelector('.custom-multiselect-list');
    const selectedValues = valuesString ? String(valuesString).split(delimiter).map(v => v.trim()) : [];

    Array.from(hiddenSelect.options).forEach(opt => opt.selected = false);
    if(optionsList) optionsList.querySelectorAll('li').forEach(li => li.classList.remove('bg-blue-100'));

    selectedValues.forEach(val => {
        const opt = hiddenSelect.querySelector(`option[value="${val}"]`);
        if (opt) opt.selected = true;
        if (optionsList) {
            const li = optionsList.querySelector(`li[data-value="${val}"]`);
            if (li) li.classList.add('bg-blue-100');
        }
    });
    updateMultiselectDisplay(container);
}

function initializeCustomMultiselects() {
    document.querySelectorAll('.custom-multiselect').forEach(container => {
        const trigger = container.querySelector('.custom-multiselect-trigger');
        const panel = container.querySelector('.custom-multiselect-panel');
        const searchInput = container.querySelector('.custom-multiselect-search');
        const optionsList = container.querySelector('.custom-multiselect-list');
        const hiddenSelect = container.querySelector('select'); 
        const displaySpan = container.querySelector('.custom-multiselect-display');
        
        if (displaySpan && !displaySpan.dataset.placeholder) displaySpan.dataset.placeholder = displaySpan.textContent;

        if (trigger) {
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('.custom-multiselect-panel').forEach(p => { if (p !== panel) p.classList.add('hidden'); });
                if (panel) panel.classList.toggle('hidden');
            });
        }

        if (optionsList) {
            optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
                li.addEventListener('click', (e) => {
                    e.stopPropagation(); 
                    const value = li.dataset.value;
                    const option = hiddenSelect.querySelector(`option[value="${value}"]`);

                    if (container.dataset.type === 'single') {
                        hiddenSelect.value = value; 
                        optionsList.querySelectorAll('.custom-multiselect-option').forEach(o => o.classList.remove('bg-blue-100'));
                        li.classList.add('bg-blue-100');
                        if (panel) panel.classList.add('hidden'); 
                    }
                    updateMultiselectDisplay(container);
                });
            });
        }
        updateMultiselectDisplay(container);
    });
}
document.addEventListener('click', (e) => {
    if (!e.target.closest('.custom-multiselect')) {
        document.querySelectorAll('.custom-multiselect-panel').forEach(p => p.classList.add('hidden'));
    }
});

// --- MAIN LOGIC: CRUD AJAX ---
document.addEventListener('DOMContentLoaded', function() {
    
    initializeCustomMultiselects();
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Modal Elements
    const addModal = document.getElementById('addPackageModal');
    const manageModal = document.getElementById('managePackageModal');
    const addForm = document.getElementById('addPackageForm'); 
    const manageForm = document.getElementById('managePackageForm');
    
    // Logic Ảnh Preview
    function setupPreview(inputId, imgId) {
        document.getElementById(inputId).addEventListener('change', function(e) {
            if(this.files[0]) {
                const r = new FileReader();
                r.onload = (ev) => document.getElementById(imgId).src = ev.target.result;
                r.readAsDataURL(this.files[0]);
            }
        });
    }
    setupPreview('add-image_url', 'add-image-preview');
    document.getElementById('add-upload-btn').addEventListener('click', () => document.getElementById('add-image_url').click());
    
    setupPreview('manage-image_url_input', 'manage-image_url');
    document.getElementById('manage-upload-btn').addEventListener('click', () => document.getElementById('manage-image_url_input').click());

    // Helpers Modal
    function openModal(m) { m.classList.remove('hidden'); m.classList.add('flex'); }
    function closeModal(m) { m.classList.add('hidden'); m.classList.remove('flex'); }
    document.querySelectorAll('.close-modal').forEach(btn => btn.addEventListener('click', function() { closeModal(this.closest('.modal-container')); }));
    document.querySelectorAll('.modal-container').forEach(c => c.addEventListener('click', function(e) { if (e.target === this) closeModal(this); }));

    // --- 1. CREATE (THÊM MỚI) ---
    document.getElementById('openAddModalBtn').addEventListener('click', function() {
        addForm.reset();
        document.getElementById('add-image-preview').src = "https://via.placeholder.com/160x160.png?text=Image";
        openModal(addModal);
    });

    addForm.addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData();
        formData.append('package_name', document.getElementById('add-package_name').value);
        formData.append('duration_months', document.getElementById('add-duration_months').value);
        formData.append('price', document.getElementById('add-price').value);
        formData.append('description', document.getElementById('add-description').value);
        formData.append('status', 'active'); // Mặc định active khi thêm
        formData.append('is_featured', document.getElementById('add-is_featured').checked ? 1 : 0);
        
        const fileInput = document.getElementById('add-image_url');
        if(fileInput.files[0]) formData.append('image_url', fileInput.files[0]);

        fetch("{{ route('admin.packages.store') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) { alert('Thêm thành công!'); location.reload(); }
            else { alert('Lỗi: ' + JSON.stringify(data.errors || data.message)); }
        })
        .catch(err => console.error(err));
    });

    // --- 2. READ (CLICK VÀO DÒNG ĐỂ SỬA) ---
    document.querySelectorAll('.modal-trigger').forEach(row => {
        row.addEventListener('click', function() {
            const data = this.dataset;
            
            // Điền ID vào input ẩn
            document.getElementById('current-db-id').value = data.package_id; // ID thật trong DB

            // Điền dữ liệu vào form
            document.getElementById('manage-package_id').value = 'GT' + String(data.package_id).padStart(4, '0');
            document.getElementById('manage-package_name').value = data.package_name;
            document.getElementById('manage-duration_months').value = data.duration_months;
            document.getElementById('manage-price').value = parseInt(data.price); // Bỏ .00
            document.getElementById('manage-description').value = data.description;
            document.getElementById('manage-is_featured').checked = (data.is_featured === 'true' || data.is_featured === '1');
            document.getElementById('manage-image_url').src = data.image_url || "https://via.placeholder.com/160x160.png?text=Image";

            // Xử lý Custom Select Status
            const statusContainer = document.querySelector('.custom-multiselect[data-select-id="manage-status-custom"]');
            setCustomMultiselectValues(statusContainer, data.status);
            document.getElementById('manage-status-custom-hidden-select').value = data.status;

            openModal(manageModal);
        });
    });

    // --- 3. UPDATE (CẬP NHẬT) ---
    manageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('current-db-id').value;
        
        let formData = new FormData();
        formData.append('_method', 'PUT'); // Method Spoofing cho Laravel
        formData.append('package_name', document.getElementById('manage-package_name').value);
        formData.append('duration_months', document.getElementById('manage-duration_months').value);
        formData.append('price', document.getElementById('manage-price').value);
        formData.append('description', document.getElementById('manage-description').value);
        formData.append('status', document.getElementById('manage-status-custom-hidden-select').value);
        formData.append('is_featured', document.getElementById('manage-is_featured').checked ? 1 : 0);

        const fileInput = document.getElementById('manage-image_url_input');
        if(fileInput.files[0]) formData.append('image_url', fileInput.files[0]);

        fetch(`/admin/packages/${id}`, {
            method: 'POST', // POST + _method: PUT
            headers: { 
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) { alert('Cập nhật thành công!'); location.reload(); }
            else { alert('Lỗi: ' + JSON.stringify(data.errors || data.message)); }
        })
        .catch(err => console.error(err));
    });

    // --- 4. DELETE (XÓA) ---
    document.getElementById('btn-delete-package').addEventListener('click', function() {
        if(!confirm('Bạn chắc chắn muốn xóa gói này?')) return;
        const id = document.getElementById('current-db-id').value;

        fetch(`/admin/packages/${id}`, {
            method: 'DELETE',
            headers: { 
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) { alert('Đã xóa!'); location.reload(); }
            else { alert('Lỗi: ' + data.message); }
        })
        .catch(err => console.error(err));
    });
});
</script>
@endpush