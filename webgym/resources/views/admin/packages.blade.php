@extends('layouts.ad_layout')

@section('title', 'Quản lý gói tập')

@section('content')

{{-- CSRF TOKEN --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">
    
    {{-- HEADER & BUTTONS --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Danh sách gói tập</h1>
        
        <div class="flex items-center space-x-4 font-open-sans">
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900">
                <span class="mr-1 text-sm font-medium">Hôm nay</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <button id="openAddModalBtn" class="bg-[#28A745] hover:bg-[#218838] text-white px-4 py-2 rounded-full flex items-center text-sm font-semibold transition-colors shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm gói
            </button>
        </div>
    </div>

    {{-- TABLE CONTENT --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center">
                <tr>
                    <th class="py-4 px-0 w-[3%] text-center"></th> {{-- Cột ngôi sao --}}
                    <th class="py-4 px-4 w-[10%] truncate">Mã gói</th>
                    <th class="py-4 px-4 w-[15%] truncate">Tên gói</th>
                    <th class="py-4 px-4 w-[12%] truncate">Giá (VNĐ)</th>
                    <th class="py-4 px-4 w-[10%] truncate">Thời hạn</th>
                    <th class="py-4 px-4 flex-1 truncate">Mô tả</th>
                    <th class="py-4 px-4 w-[15%] truncate">Trạng thái</th>
                </tr>
            </thead>

            <tbody id="packageTableBody" class="text-sm text-gray-700 text-center">
                @foreach ($packages as $package)
                    @php
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';
                    @endphp

                    <tr class="{{ $rowBg }} cursor-pointer transition-colors modal-trigger group"
                        id="row-{{ $package->package_id }}"
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
                        {{-- Ngôi sao nổi bật --}}
                        <td class="py-4 px-1 align-middle text-center {{ $roundLeft }}">
                            <div class="flex items-center justify-center w-full h-full">
                                @if ($package->is_featured)
                                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.002 8.71c-.783-.57-.381-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endif
                            </div>
                        </td>

                        {{-- Mã gói --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            GT{{ str_pad($package->package_id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Tên gói --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            {{ $package->package_name }}
                        </td>

                        {{-- Giá tiền --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            {{ number_format($package->price, 0, ',', '.') }}
                        </td>

                        {{-- Thời hạn --}}
                        <td class="py-4 px-4 truncate align-middle">
                            @if($package->duration_months)
                                {{ $package->duration_months }} tháng 
                            @else
                                Theo ngày
                            @endif
                        </td>

                        {{-- Mô tả --}}
                        <td class="py-4 px-4 align-middle text-left max-w-xs truncate" title="{{ $package->description }}">
                            {{ Str::limit($package->description ?? '—', 50) }}
                        </td>

                        {{-- Trạng thái --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            @if ($package->status == 'active')
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
                    
                    {{-- Dòng rỗng tạo khoảng cách --}}
                    <tr class="h-2"></tr> 
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
            {{ $packages->links() }}
        </div>
    </div>
</div>

{{-- ========================= MODAL THÊM GÓI TẬP ========================= --}}
<div id="addPackageModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 transition-opacity">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl transform transition-all scale-100"> 
        
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
            THÊM GÓI TẬP
        </h2>
        
        <form id="addPackageForm">
            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">Thông tin gói tập</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Cột ảnh --}}
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-100 rounded-2xl overflow-hidden mb-3 border-2 border-dashed border-gray-300 flex items-center justify-center">
                        <img id="add-image-preview" src="https://via.placeholder.com/160x160.png?text=Image" alt="Package Image" class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="add-upload-btn" class="flex items-center px-4 py-2 bg-blue-50 text-blue-600 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Upload ảnh
                    </button>
                    <input type="file" id="add-image_url" accept="image/*" class="hidden"> 
                </div>

                {{-- Cột thông tin --}}
                <div class="md:col-span-2 space-y-5">
                    <div class="flex items-center space-x-4">
                        <label for="add-package_name" class="block text-sm font-semibold text-gray-700 w-1/3">Tên gói tập</label>
                        <input type="text" id="add-package_name" required class="w-2/3 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <label for="add-duration_months" class="block text-sm font-semibold text-gray-700 w-1/3">Thời hạn (tháng)</label>
                        <input type="number" id="add-duration_months" class="w-2/3 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none" min="1">
                    </div>

                    <div class="flex items-center space-x-4">
                        <label for="add-price" class="block text-sm font-semibold text-gray-700 w-1/3">Giá tiền (VNĐ)</label>
                        <input type="number" id="add-price" required class="w-2/3 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none" min="0">
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="flex items-start space-x-4 mb-4">
                <label for="add-description" class="block text-sm font-semibold text-gray-700 w-1/4 pt-2.5">Mô tả</label>
                <textarea id="add-description" rows="4" class="w-3/4 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
            </div>
            
            {{-- Toggle Switch Gói nổi bật --}}
            <div class="flex items-center space-x-4 mb-8">
                <label class="block text-sm font-semibold text-gray-700 w-1/4">Gói tập nổi bật</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" id="add-is_featured" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>

            {{-- Nút bấm --}}
            <div class="flex justify-center space-x-3 mt-8 pt-4 border-t border-gray-100">
                <button type="button" class="close-modal px-6 py-2.5 bg-[#6c757d] hover:bg-[#5a6268] text-white font-semibold rounded-lg transition-colors focus:outline-none">
                    Hủy
                </button>
                <button type="submit" class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg transition-colors focus:outline-none shadow-md">
                    Thêm gói
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ========================= MODAL QUẢN LÝ GÓI TẬP ========================= --}}
<div id="managePackageModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl transform transition-all"> 
        
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
            QUẢN LÝ GÓI TẬP
        </h2>
        
        <form id="managePackageForm">
            <input type="hidden" id="current-db-id">

            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">Thông tin gói tập</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Cột ảnh --}}
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-100 rounded-2xl overflow-hidden mb-3 border-2 border-dashed border-gray-300 flex items-center justify-center">
                        <img id="manage-image_url" src="https://via.placeholder.com/160x160.png?text=Image" alt="Package Image" class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="manage-upload-btn" class="flex items-center px-4 py-2 bg-blue-50 text-blue-600 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Đổi ảnh
                    </button>
                    <input type="file" id="manage-image_url_input" accept="image/*" class="hidden">
                </div>

                {{-- Cột thông tin --}}
                <div class="md:col-span-2 space-y-5">
                    <div class="flex items-center space-x-4">
                        <label for="manage-package_id" class="block text-sm font-semibold text-gray-700 w-1/3">Mã Gói</label>
                        <input type="text" id="manage-package_id" class="w-2/3 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 font-mono" readonly>
                    </div>
                
                    <div class="flex items-center space-x-4">
                        <label for="manage-package_name" class="block text-sm font-semibold text-gray-700 w-1/3">Tên gói tập</label>
                        <input type="text" id="manage-package_name" required class="w-2/3 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <label for="manage-duration_months" class="block text-sm font-semibold text-gray-700 w-1/3">Thời hạn (tháng)</label>
                        <input type="number" id="manage-duration_months" class="w-2/3 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none" min="1">
                    </div>

                    <div class="flex items-center space-x-4">
                        <label for="manage-price" class="block text-sm font-semibold text-gray-700 w-1/3">Giá tiền (VNĐ)</label>
                        <input type="number" id="manage-price" required class="w-2/3 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none" min="0">
                    </div>
                </div>
            </div>

            {{-- Mô tả --}}
            <div class="mb-4 flex items-start space-x-4">
                <label for="manage-description" class="block text-sm font-semibold text-gray-700 w-1/4 pt-2.5">Mô tả</label>
                <textarea id="manage-description" rows="4" class="w-3/4 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
            </div>
            
            {{-- Toggle Switch Gói nổi bật --}}
            <div class="flex items-center space-x-4 mb-4">
                <label class="block text-sm font-semibold text-gray-700 w-1/4">Gói tập nổi bật</label>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" id="manage-is_featured" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </label>
            </div>

            {{-- Trạng thái (CUSTOM SELECT) --}}
            <div class="flex items-center space-x-4">
                <label class="block text-sm font-semibold text-gray-700 w-1/4">Trạng thái</label>
                <div class="relative custom-multiselect w-1/2" data-select-id="manage-status-custom" data-type="single"> 
                    <select id="manage-status-custom-hidden-select" name="manage_status" class="hidden">
                         <option value="active">Đang hoạt động</option>
                         <option value="inactive">Dừng hoạt động</option>
                    </select>
                    <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-xl text-left px-4 py-2.5 flex items-center justify-between focus:ring-2 focus:ring-blue-500 outline-none">
                        <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                        <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                            <li class="px-4 py-2.5 hover:bg-green-50 cursor-pointer custom-multiselect-option border-b border-gray-50" data-value="active">
                                <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span><span class="text-sm font-medium text-gray-900">Đang hoạt động</span></div>
                            </li>
                            <li class="px-4 py-2.5 hover:bg-gray-50 cursor-pointer custom-multiselect-option" data-value="inactive">
                                <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-gray-400 mr-2"></span><span class="text-sm font-medium text-gray-900">Dừng hoạt động</span></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Nút bấm --}}
            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                 <button type="button" id="btn-delete-package" class="px-5 py-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 font-semibold transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Xóa gói
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

@endsection

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