@extends('layouts.ad_layout')

@section('title', 'Quản lý lớp học')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">
    
    {{-- HEADER & BUTTONS --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Danh sách lớp học</h1>
        
        <div class="flex items-center space-x-4 font-open-sans">
            <!-- Nút Dropdown Lọc -->
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900">
                <span class="mr-1 text-sm font-medium">Trạng thái</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <!-- Nút Thêm Lớp -->
            <button id="openAddModalBtn" class="bg-[#28A745] hover:bg-[#218838] text-white px-4 py-2 rounded-full flex items-center text-sm font-semibold transition-colors shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm lớp
            </button>
        </div>
    </div>

    {{-- TABLE CONTENT --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center">
                <tr>
                    <th class="py-4 px-4 w-[10%] truncate">Mã lớp</th>
                    <th class="py-4 px-4 w-[15%] truncate">Tên lớp</th>
                    <th class="py-4 px-4 w-[15%] truncate">Loại lớp</th>
                    <th class="py-4 px-4 w-[12%] truncate">Sức chứa</th>
                    <th class="py-4 px-4 flex-1 truncate">Mô tả</th>
                    <th class="py-4 px-4 w-[15%] truncate">Trạng thái</th>
                </tr>
            </thead>

            <tbody id="classTableBody" class="text-sm text-gray-700 text-center">
                @foreach ($classes as $class)
                    @php
                        // Logic màu nền xen kẽ 
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';
                    @endphp

                    <tr class="{{ $rowBg }} cursor-pointer transition-colors modal-trigger group"
                        data-class_id="{{ $class->class_id }}"
                        data-class_name="{{ $class->class_name }}"
                        data-type="{{ $class->type }}"
                        data-max_capacity="{{ $class->max_capacity }}"
                        data-description="{{ $class->description ?? '' }}"
                        data-is_active="{{ $class->is_active }}"
                        data-image_url="{{ $class->image_url ?? '' }}"
                    >
                        {{-- Mã lớp --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }} font-medium">
                            LO{{ str_pad($class->class_id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Tên lớp --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            {{ $class->class_name }}
                        </td>

                        {{-- Loại lớp --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $class->type_label }}
                        </td>

                        {{-- Sức chứa --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $class->max_capacity }}
                        </td>

                        {{-- Mô tả --}}
                        <td class="py-4 px-4 align-middle text-left max-w-xs truncate" title="{{ $class->description ?? '' }}">
                            {{ Str::limit($class->description ?? '—', 50) }}
                        </td>

                        {{-- Trạng thái --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            @if($class->is_active)
                                <span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                                    Hoạt động
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-500 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                                    Dừng hoạt động
                                </span>
                            @endif
                        </td>
                    </tr>
                    
                    {{-- Dòng rỗng tạo khoảng cách giữa các hàng --}}
                    <tr class="h-2"></tr> 
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
            {{ $classes->links() }}
        </div>
    </div>
</div>

<!-- Modal thêm lớp -->
<div id="addClassModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/50 transition-opacity">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl transform transition-all scale-100">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
            THÊM LỚP HỌC
        </h2>

        <form id="addClassForm">
            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">Thông tin lớp học</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Ảnh upload --}}
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-100 rounded-2xl overflow-hidden mb-3 border-2 border-dashed border-gray-300 flex items-center justify-center">
                        <img id="add-image-preview" src="https://via.placeholder.com/160x160.png?text=Class" alt="Preview" class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="add-upload-btn" class="flex items-center px-4 py-2 bg-blue-50 text-blue-600 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Upload ảnh
                    </button>
                    <input type="file" id="add-image_url" accept="image/*" class="hidden">
                </div>

                {{-- Thông tin --}}
                <div class="md:col-span-2 space-y-5">
                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-semibold text-gray-700 w-1/3">Tên lớp <span class="text-red-500">*</span></label>
                        <input type="text" id="add-class_name" required class="w-2/3 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                    </div>

                    {{-- Loại lớp --}}
                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-semibold text-gray-700 w-1/3">Loại lớp <span class="text-red-500">*</span></label>
                        
                        <div class="relative custom-multiselect w-2/3" data-select-id="add-type-custom" data-type="single">
                            <select id="add-type-custom-hidden-select" name="add_type" required class="hidden">
                                <option value="">Chọn loại lớp...</option>
                                @foreach($types as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-xl text-left px-4 py-2.5 flex items-center justify-between focus:ring-2 focus:ring-blue-500 outline-none">
                                <span class="custom-multiselect-display text-gray-500">Chọn loại lớp...</span>
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                    @foreach($types as $key => $label)
                                        <li class="px-4 py-2.5 hover:bg-blue-50 cursor-pointer custom-multiselect-option transition-colors border-b border-gray-50 last:border-0" data-value="{{ $key }}">
                                            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-semibold text-gray-700 w-1/3">Sức chứa <span class="text-red-500">*</span></label>
                        <input type="number" id="add-max_capacity" required min="1" max="100" class="w-2/3 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="flex items-start space-x-4 mb-4">
                <label for="add-description" class="block text-sm font-semibold text-gray-700 w-1/4 pt-2.5">Mô tả</label>
                <textarea id="add-description" rows="4" class="w-3/4 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none"></textarea>
            </div>

            {{-- Nút bấm --}}
            <div class="flex justify-center space-x-3 mt-8 pt-4 border-t border-gray-100">
                <button type="button" class="close-modal px-6 py-2.5 bg-[#6c757d] hover:bg-[#5a6268] text-white font-semibold rounded-lg transition-colors focus:outline-none">
                    Hủy
                </button>
                <button type="submit" class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg transition-colors focus:outline-none shadow-md">
                    Thêm lớp
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal quản lý lớp học -->
<div id="manageClassModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/50">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl transform transition-all">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
            QUẢN LÝ LỚP HỌC
        </h2>

        <form id="manageClassForm">
            <input type="hidden" id="current-class_id">

            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">Thông tin lớp học</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-100 rounded-2xl overflow-hidden mb-3 border-2 border-dashed border-gray-300">
                        <img id="manage-image_url" src="" alt="Preview" class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="manage-upload-btn" class="flex items-center px-4 py-2 bg-blue-50 text-blue-600 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Đổi ảnh
                    </button>
                    <input type="file" id="manage-image_url_input" accept="image/*" class="hidden">
                </div>

                <div class="md:col-span-2 space-y-5">
                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-semibold text-gray-700 w-1/3">Mã lớp</label>
                        <input type="text" id="manage-class_id-display" disabled class="w-2/3 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 font-mono">
                    </div>

                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-semibold text-gray-700 w-1/3">Tên lớp</label>
                        <input type="text" id="manage-class_name" required class="w-2/3 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    {{-- Loại lớp --}}
                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-semibold text-gray-700 w-1/3">Loại lớp</label>
                        <div class="relative custom-multiselect w-2/3" data-select-id="manage-type-custom" data-type="single">
                            <select id="manage-type-custom-hidden-select" name="manage_type" required class="hidden">
                                @foreach($types as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-xl text-left px-4 py-2.5 flex items-center justify-between focus:ring-2 focus:ring-blue-500 outline-none">
                                <span class="custom-multiselect-display text-gray-500">Chọn loại lớp...</span>
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                    @foreach($types as $key => $label)
                                        <li class="px-4 py-2.5 hover:bg-blue-50 cursor-pointer custom-multiselect-option border-b border-gray-50 last:border-0" data-value="{{ $key }}">
                                            <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-semibold text-gray-700 w-1/3">Sức chứa</label>
                        <input type="number" id="manage-max_capacity" required min="1" max="100" class="w-2/3 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    {{-- Trạng thái --}}
                    <div class="flex items-center space-x-4 mb-4">
                        <label class="block text-sm font-semibold text-gray-700 w-1/3">Trạng thái</label>
                        <div class="relative custom-multiselect w-2/3" data-select-id="manage-is_active-custom" data-type="single"> 
                            <select id="manage-is_active-custom-hidden-select" name="manage_is_active" class="hidden">
                                <option value="1">Đang hoạt động</option>
                                <option value="0">Dừng hoạt động</option>
                            </select>
                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-xl text-left px-4 py-2.5 flex items-center justify-between focus:ring-2 focus:ring-blue-500 outline-none">
                                <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                    <li class="px-4 py-2.5 hover:bg-green-50 cursor-pointer custom-multiselect-option border-b border-gray-50" data-value="1">
                                        <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span><span class="text-sm font-medium text-gray-900">Đang hoạt động</span></div>
                                    </li>
                                    <li class="px-4 py-2.5 hover:bg-gray-50 cursor-pointer custom-multiselect-option" data-value="0">
                                        <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-gray-400 mr-2"></span><span class="text-sm font-medium text-gray-900">Dừng hoạt động</span></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="mb-4 flex items-start space-x-4">
                <label for="manage-description" class="block text-sm font-semibold text-gray-700 w-1/4 pt-2.5">Mô tả</label>
                <textarea id="manage-description" rows="4" class="w-3/4 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
            </div>
            
            {{-- Nút bấm --}}
            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                <button type="button" id="btn-delete-class" class="px-5 py-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 font-semibold transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Xóa lớp
                </button>

                <div class="flex space-x-3">
                    <button type="button" class="close-modal px-6 py-2.5 bg-[#6c757d] hover:bg-[#5a6268] text-white font-semibold rounded-lg transition-colors focus:outline-none">
                        Hủy
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg transition-colors focus:outline-none shadow-md"> 
                        Cập nhật
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


@push('scripts')
<style>
/* === CUSTOM STYLES CHO CUSTOM SELECT === */
    .custom-multiselect-option:hover { @apply bg-blue-50 text-gray-900; }
    .custom-multiselect-option:hover span { @apply text-gray-900; }
    .custom-multiselect-option.bg-blue-100 { @apply bg-blue-100 text-blue-800; }
    .custom-multiselect-option.bg-blue-100 span { @apply text-blue-800; }
    .custom-multiselect-option { @apply bg-white text-gray-700; }
</style>

<script>
    // --- SCRIPT CUSTOM SELECT ---
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