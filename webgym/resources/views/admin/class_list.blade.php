@extends('layouts.ad_layout')

@section('title', 'Quản lý lớp học')

@section('content')

{{-- CSRF TOKEN --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Header --}}
<div class="flex justify-end items-center mb-6">
    <div class="flex items-center space-x-3 text-sm text-gray-500 mr-4">
        <span class="font-medium">Hôm nay</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>
    <button id="openAddModalBtn"
            class="flex items-center px-4 py-2 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 transition-colors duration-150 shadow-md">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Thêm lớp
    </button>
</div>

{{-- Bảng danh sách lớp học --}}
<div class="bg-white p-6 rounded-lg shadow-xl">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Danh sách lớp học</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border-separate border-spacing-y-2">
            <thead class="bg-gray-50 font-montserrat text-[#1f1d1d] text-xs font-semibold">
            <tr>
                <th class="px-4 py-3 text-left uppercase w-[10%]">Mã lớp</th>
                <th class="px-4 py-3 text-left uppercase w-[15%]">Tên lớp</th>
                <th class="px-4 py-3 text-left uppercase w-[15%]">Loại lớp</th>
                <th class="px-4 py-3 text-left uppercase w-[12%]">Sức chứa</th>
                <th class="px-4 py-3 text-center uppercase flex-1">Mô tả</th>
                <th class="px-4 py-3 text-center uppercase w-[15%]">Trạng thái</th>
            </tr>
            </thead>

            <tbody id="classTableBody">
            @foreach ($classes as $class)
            <tr class="transition duration-150 cursor-pointer modal-trigger"
                data-class_id="{{ $class->class_id }}"
                data-class_name="{{ $class->class_name }}"
                data-type="{{ $class->type }}"
                data-max_capacity="{{ $class->max_capacity }}"
                data-description="{{ $class->description ?? '' }}"
                data-is_active="{{ $class->is_active }}"
                data-image_url="{{ $class->image_url ?? '' }}"
            >

                <td colspan="6" class="p-0">
                    <div class="flex w-full rounded-lg items-center {{ $loop->even ? 'bg-white' : 'bg-[#1976D2]/10' }} shadow-sm overflow-hidden class-row-content">

                        {{-- Mã lớp: 10% --}}
                        <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900">
                            LO{{ str_pad($class->class_id, 4, '0', STR_PAD_LEFT) }}
                        </div>

                        {{-- TÊN LỚP: 15% --}}
                        <div class="px-4 py-3 w-[15%] text-sm text-gray-700 font-medium">
                            {{ $class->class_name }}
                        </div>

                        {{-- Loại lớp: 15% --}}
                        <div class="px-4 py-3 w-[15%] text-sm text-gray-700">
                            {{ $class->type_label }}
                        </div>

                        {{-- Sức chứa: 12% --}}
                        <div class="px-4 py-3 w-[12%] text-sm text-gray-700">
                            {{ $class->max_capacity }} người
                        </div>

                        {{-- MÔ TẢ: --}}
                        <div class="px-4 py-3 flex-1 text-sm text-gray-700 truncate" title="{{ $class->description ?? '' }}">
                            {{ Str::limit($class->description ?? '—', 100) }}
                        </div>

                        {{-- Trạng thái: 15% --}}
                        <div class="px-4 py-3 w-[15%] text-center">
                            @if($class->is_active)
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

        <div class="mt-6 flex justify-center">
            {{ $classes->links() }}
        </div>
    </div>
</div>

{{-- ========================= MODAL THÊM LỚP  ========================= --}}
<div id="addClassModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent">
            THÊM LỚP HỌC
        </h2>

        <form id="addClassForm">
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin lớp học</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Ảnh upload --}}
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg overflow-hidden mb-3">
                        <img id="add-image-preview" src="https://via.placeholder.com/160x160.png?text=Class" alt="Preview" class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="add-upload-btn" class="flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Upload ảnh
                    </button>
                    <input type="file" id="add-image_url" accept="image/*" class="hidden">
                </div>

                {{-- Thông tin --}}
                <div class="md:col-span-2 space-y-5">
                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Tên lớp <span class="text-red-500">*</span></label>
                        <input type="text" id="add-class_name" required class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5">
                    </div>

                    {{-- Loại lớp --}}
                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Loại lớp <span class="text-red-500">*</span></label>
                        
                        <div class="relative custom-multiselect w-2/3" data-select-id="add-type-custom" data-type="single">
                            
                            {{-- 1. SELECT ẨN (Dùng để gửi dữ liệu đi) --}}
                            <select id="add-type-custom-hidden-select" name="add_type" required class="hidden">
                                <option value="">Chọn loại lớp...</option>
                                {{-- Chạy vòng lặp lấy dữ liệu từ biến $types truyền sang --}}
                                @foreach($types as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>

                            {{-- 2. NÚT BẤM HIỂN THỊ --}}
                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                                <span class="custom-multiselect-display text-gray-500">Chọn loại lớp...</span>
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>

                            {{-- 3. DANH SÁCH DROPDOWN --}}
                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                    {{-- Chạy vòng lặp tạo các dòng li --}}
                                    @foreach($types as $key => $label)
                                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" 
                                            data-value="{{ $key }}">
                                            <div class="flex items-center space-x-3 w-full pointer-events-none">
                                                {{-- Hiển thị Label --}}
                                                <span class="text-sm font-medium text-gray-900">{{ $label }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Sức chứa <span class="text-red-500">*</span></label>
                        <input type="number" id="add-max_capacity" required min="1" max="100" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5">
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="flex items-start space-x-4 mb-4">
                <label for="add-description" class="block text-sm font-medium text-gray-700 w-1/4 pt-2.5">Mô tả</label>
                <textarea id="add-description" rows="5" class="w-3/4 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
            </div>

            {{-- Nút bấm --}}
            <div class="flex justify-center space-x-4 mt-8">
                <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                    Hủy
                </button>
                <button type="submit" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Thêm lớp
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================= MODAL SỬA / QUẢN LÝ LỚP ========================= --}}
<div id="manageClassModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent">
            QUẢN LÝ LỚP HỌC
        </h2>

        <form id="manageClassForm">
            <input type="hidden" id="current-class_id">

            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin lớp học</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg overflow-hidden mb-3">
                        <img id="manage-image_url" src="" alt="Preview" class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="manage-upload-btn" class="flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Đổi ảnh
                    </button>
                    <input type="file" id="manage-image_url_input" accept="image/*" class="hidden">
                </div>

                <div class="md:col-span-2 space-y-5">
                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Mã lớp</label>
                        <input type="text" id="manage-class_id-display" disabled class="w-2/3 bg-gray-100 border border-gray-300 rounded-2xl px-4 py-2.5">
                    </div>

                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Tên lớp</label>
                        <input type="text" id="manage-class_name" required class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5">
                    </div>

                    {{-- Loại lớp --}}
                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Loại lớp</label>
                        <div class="relative custom-multiselect w-2/3" data-select-id="manage-type-custom" data-type="single">
                            
                            {{-- 1. Select Ẩn --}}
                            <select id="manage-type-custom-hidden-select" name="manage_type" required class="hidden">
                                @foreach($types as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>

                            {{-- 2. Nút bấm hiển thị --}}
                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                                <span class="custom-multiselect-display text-gray-500">Chọn loại lớp...</span>
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>

                            {{-- 3. Danh sách Dropdown --}}
                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                    @foreach($types as $key => $label)
                                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" 
                                            data-value="{{ $key }}">
                                            <div class="flex items-center space-x-3 w-full pointer-events-none">
                                                <span class="text-sm font-medium text-gray-900">{{ $label }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Sức chứa</label>
                        <input type="number" id="manage-max_capacity" required min="1" max="100" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5">
                    </div>

                    {{-- Trạng thái --}}
                    <div class="flex items-center space-x-4 mb-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Trạng thái</label>
                        <div class="relative custom-multiselect w-2/3" data-select-id="manage-is_active-custom" data-type="single"> 
                            <select id="manage-is_active-custom-hidden-select" name="manage_is_active" class="hidden">
                                <option value="1">Đang hoạt động</option>
                                <option value="0">Dừng hoạt động</option>
                            </select>
                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                                <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                    <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="1">
                                        <div class="flex items-center space-x-3 w-full pointer-events-none"><span class="text-sm font-medium text-gray-900">Đang hoạt động</span></div>
                                    </li>
                                    <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="0">
                                        <div class="flex items-center space-x-3 w-full pointer-events-none"><span class="text-sm font-medium text-gray-900">Dừng hoạt động</span></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="mb-4 flex items-start space-x-4">
                <label for="manage-description" class="block text-sm font-medium text-gray-700 w-1/4 pt-2.5">Mô tả</label>
                <textarea id="manage-description" rows="5" class="w-3/4 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
            </div>
            
            {{-- Nút bấm --}}
            <div class="flex justify-between space-x-4 mt-8">
                <button type="button" id="btn-delete-class" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 font-medium">
                    Xóa lớp này
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

{{-- ========================= SCRIPT AJAX  ========================= --}}
@push('scripts')
<style>
/* === CUSTOM STYLES CHO CUSTOM SELECT === */
.custom-multiselect-option:hover { @apply bg-[#999999]/50 text-gray-900; }
.custom-multiselect-option:hover span { @apply text-gray-900; }
.custom-multiselect-option.bg-blue-100 { @apply bg-blue-500/50 text-gray-900; }
.custom-multiselect-option.bg-blue-100 span { @apply text-gray-900; }
.custom-multiselect-option.bg-blue-100:hover { @apply bg-[#999999]/50 text-gray-900; }
.custom-multiselect-option { @apply bg-white text-gray-900; }
</style>

<script>
// --- SCRIPT CUSTOM SELECT  ---
function updateMultiselectDisplay(container) {
    const hiddenSelect = container.querySelector('select');
    const displaySpan = container.querySelector('.custom-multiselect-display');
    const selected = Array.from(hiddenSelect.selectedOptions);
    
    let placeholder = 'Chọn...';
    if (container.dataset.selectId === 'manage-is_active-custom') placeholder = 'Chọn trạng thái...';
    if (container.dataset.selectId === 'add-type-custom' || container.dataset.selectId === 'manage-type-custom') placeholder = 'Chọn loại lớp...';

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

    // Cập nhật giá trị cho thẻ <select> ẩn
    Array.from(hiddenSelect.options).forEach(opt => opt.selected = false);
    selectedValues.forEach(val => {
        const opt = hiddenSelect.querySelector(`option[value="${val}"]`);
        if (opt) opt.selected = true;
    });

    // Cập nhật giao diện (li element)
    if(optionsList) optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => li.classList.remove('bg-blue-100'));
    selectedValues.forEach(val => {
        if (optionsList) {
            const li = optionsList.querySelector(`.custom-multiselect-option[data-value="${val}"]`);
            if (li) li.classList.add('bg-blue-100');
        }
    });

    updateMultiselectDisplay(container);
}

function initializeCustomMultiselects() {
    document.querySelectorAll('.custom-multiselect').forEach(container => {
        const trigger = container.querySelector('.custom-multiselect-trigger');
        const panel = container.querySelector('.custom-multiselect-panel');
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
                        // Xóa lựa chọn cũ và đặt lựa chọn mới
                        Array.from(hiddenSelect.options).forEach(o => o.selected = false);
                        if (option) option.selected = true;
                        
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
// --- END SCRIPT CUSTOM SELECT ---

// --- MAIN LOGIC: CRUD AJAX ---
document.addEventListener('DOMContentLoaded', function() {
    
    initializeCustomMultiselects(); // Khởi tạo Custom Select
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Modal Elements
    const addModal = document.getElementById('addClassModal');
    const manageModal = document.getElementById('manageClassModal');
    const addForm = document.getElementById('addClassForm'); 
    const manageForm = document.getElementById('manageClassForm');
    const tbody = document.getElementById('classTableBody');

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

    document.querySelectorAll('.close-modal').forEach(btn => btn.addEventListener('click', () => closeModal(btn.closest('.modal-container'))));
    document.querySelectorAll('.modal-container').forEach(m => m.addEventListener('click', e => e.target === m && closeModal(m)));

    // Mở modal thêm
    document.getElementById('openAddModalBtn').addEventListener('click', () => {
        addForm.reset();
        document.getElementById('add-image-preview').src = "https://via.placeholder.com/160x160.png?text=Class";
        
        // Reset Custom Selects
        setCustomMultiselectValues(document.querySelector('.custom-multiselect[data-select-id="add-type-custom"]'), '');
        
        openModal(addModal);
    });

    // Click dòng → mở modal sửa
    tbody.addEventListener('click', function(e) {
        const row = e.target.closest('tr.modal-trigger');
        if (!row) return;

        const d = row.dataset;
        document.getElementById('current-class_id').value = d.class_id;
        document.getElementById('manage-class_id-display').value = 'LO' + String(d.class_id).padStart(4, '0');
        document.getElementById('manage-class_name').value = d.class_name;
        document.getElementById('manage-max_capacity').value = d.max_capacity;
        document.getElementById('manage-description').value = d.description;
        document.getElementById('manage-image_url').src = d.image_url || "https://via.placeholder.com/160x160.png?text=Class";

        // Gán giá trị cho Custom Selects
        setCustomMultiselectValues(document.querySelector('.custom-multiselect[data-select-id="manage-type-custom"]'), d.type);
        setCustomMultiselectValues(document.querySelector('.custom-multiselect[data-select-id="manage-is_active-custom"]'), d.is_active);

        openModal(manageModal);
    });

    // THÊM LỚP
    document.getElementById('addClassForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData();
        
        // Lấy giá trị từ Custom Select
        const classType = document.getElementById('add-type-custom-hidden-select').value;
        if (!classType) { alert('Vui lòng chọn Loại lớp!'); return; }
        
        formData.append('class_name', document.getElementById('add-class_name').value.trim());
        formData.append('type', classType);
        formData.append('max_capacity', document.getElementById('add-max_capacity').value);
        formData.append('description', document.getElementById('add-description').value.trim());
        formData.append('is_active', 1);
        if (document.getElementById('add-image_url').files[0]) {
            formData.append('image_url', document.getElementById('add-image_url').files[0]);
        }

        fetch("{{ route('admin.class_list.store') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            body: formData
        })
            .then(r => r.json())
            .then(res => {
                alert(res.message);
                if (res.success) location.reload();
            })
            .catch(() => alert('Lỗi kết nối!'));
    });

    // SỬA LỚP
    document.getElementById('manageClassForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('current-class_id').value;
        const formData = new FormData();
        
        // Lấy giá trị từ Custom Select
        const classType = document.getElementById('manage-type-custom-hidden-select').value;
        const isActive = document.getElementById('manage-is_active-custom-hidden-select').value;
        
        formData.append('_method', 'PUT');
        formData.append('class_name', document.getElementById('manage-class_name').value.trim());
        formData.append('type', classType);
        formData.append('max_capacity', document.getElementById('manage-max_capacity').value);
        formData.append('description', document.getElementById('manage-description').value.trim());
        formData.append('is_active', isActive);
        if (document.getElementById('manage-image_url_input').files[0]) {
            formData.append('image_url', document.getElementById('manage-image_url_input').files[0]);
        }

        fetch(`/admin/class_list/${id}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            body: formData
        })
            .then(r => r.json())
            .then(res => {
                alert(res.message);
                if (res.success) location.reload();
            });
    });

    // XÓA LỚP
    document.getElementById('btn-delete-class').addEventListener('click', function() {
        if (!confirm('Bạn chắc chắn muốn xóa lớp này?')) return;
        const id = document.getElementById('current-class_id').value;

        fetch(`/admin/class_list/${id}`, {
            method: 'DELETE',
            headers: { 
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
            .then(r => r.json())
            .then(res => {
                alert(res.message);
                if (res.success) location.reload();
            })
            .catch(err => console.error(err));
    });
});
</script>
@endpush

@endsection