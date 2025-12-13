@extends('layouts.ad_layout')

@section('title', 'Quản lý chi nhánh')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">
    
    {{-- HEADER & BUTTONS --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Danh sách chi nhánh</h1>
        
        <div class="flex items-center space-x-4 font-open-sans">
            {{-- Nút Thêm Chi nhánh --}}
            <button id="openAddModalBtn" class="bg-[#28A745] hover:bg-[#218838] text-white px-4 py-2 rounded-full flex items-center text-sm font-semibold transition-colors shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm chi nhánh
            </button>
        </div>
    </div>

    {{-- TABLE CONTENT --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center">
                <tr>
                    <th class="py-4 px-4 w-[10%] truncate">Mã CN</th>
                    <th class="py-4 px-4 w-[20%] truncate">Tên chi nhánh</th>
                    <th class="py-4 px-4 w-[25%] truncate">Địa chỉ</th>
                    <th class="py-4 px-4 w-[15%] truncate">SĐT</th>
                    <th class="py-4 px-4 w-[15%] truncate">Quản lý</th>
                    <th class="py-4 px-4 w-[15%] truncate">Trạng thái</th>
                </tr>
            </thead>

            <tbody id="branch-list-body" class="text-sm text-gray-700 text-center">
                @foreach ($branches as $branch)
                    @php
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';
                        
                        // Giả sử relation trong Model Branch là public function manager() { return $this->belongsTo(User::class, 'manager_id'); }
                        $managerName = $branch->manager ? $branch->manager->full_name : 'Chưa có';
                    @endphp

                    <tr class="{{ $rowBg }} cursor-pointer transition-colors modal-trigger group"
                        id="row-{{ $branch->branch_id }}"
                        data-branch_id="{{ $branch->branch_id }}"
                        data-branch_name="{{ $branch->branch_name }}"
                        data-address="{{ $branch->address }}"
                        data-phone="{{ $branch->phone }}"
                        data-manager_id="{{ $branch->manager_id }}"
                        data-is_active="{{ $branch->is_active }}"
                    >
                        {{-- Mã CN --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }} font-medium">
                            CN{{ str_pad($branch->branch_id, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Tên chi nhánh --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            {{ $branch->branch_name }}
                        </td>

                        {{-- Địa chỉ --}}
                        <td class="py-4 px-4 text-left align-middle truncate max-w-xs" title="{{ $branch->address }}">
                            {{ Str::limit($branch->address, 40) }}
                        </td>

                        {{-- SĐT --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            {{ $branch->phone ?? '-' }}
                        </td>

                        {{-- Quản lý --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $managerName }}
                        </td>

                        {{-- Trạng thái --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            @if ($branch->is_active)
                                <span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                                    Hoạt động
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-500 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                                    Tạm đóng
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
             {{ $branches->links() }} 
        </div>
    </div>
</div>

{{-- ----------------- MODAL 1: THÊM CHI NHÁNH ----------------- --}}
<div id="addBranchModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 transition-opacity">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all scale-100">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
            THÊM CHI NHÁNH MỚI
        </h2>
        <form id="addBranchForm">
            {{-- Thông tin chung --}}
            <div class="space-y-5">
                <div class="flex flex-col">
                    <label class="text-sm font-semibold text-gray-700 mb-2">Tên chi nhánh <span class="text-red-500">*</span></label>
                    <input type="text" id="add-branch_name" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-semibold text-gray-700 mb-2">Địa chỉ <span class="text-red-500">*</span></label>
                    <input type="text" id="add-address" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="flex items-center space-x-6">
                    <div class="flex-1 flex flex-col">
                        <label class="text-sm font-semibold text-gray-700 mb-2">Số điện thoại</label>
                        <input type="text" id="add-phone" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    
                    {{-- CUSTOM SELECT: QUẢN LÝ (Nếu có biến $managers từ controller) --}}
                    <div class="flex-1 flex flex-col">
                        <label class="text-sm font-semibold text-gray-700 mb-2">Người quản lý</label>
                        <div class="relative custom-multiselect w-full" data-select-id="add-manager-custom" data-type="single">
                            <select id="add-manager-custom-hidden-select" class="hidden">
                                <option value="">-- Chưa chọn --</option>
                                @foreach($managers as $manager) 
                                    <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-xl text-left px-4 py-2.5 flex items-center justify-between focus:ring-2 focus:ring-blue-500 outline-none">
                                <span class="custom-multiselect-display text-gray-500">-- Chưa chọn --</span>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                            </button>
                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                    {{-- Demo Static Options nếu chưa có biến managers --}}
                                    <li class="px-4 py-2.5 hover:bg-blue-50 cursor-pointer custom-multiselect-option border-b border-gray-50" data-value="1">
                                        <span class="text-sm font-medium text-gray-700">Admin (Mặc định)</span>
                                    </li>
                                    @foreach($managers as $manager)
                                    <li class="px-4 py-2.5 hover:bg-blue-50 cursor-pointer custom-multiselect-option border-b border-gray-50" data-value="{{ $manager->id }}">
                                        <span class="text-sm font-medium text-gray-700">{{ $manager->full_name }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center space-x-3 mt-8 pt-4 border-t border-gray-100">
                <button type="button" class="close-modal px-6 py-2.5 bg-[#6c757d] hover:bg-[#5a6268] text-white font-semibold rounded-lg transition-colors focus:outline-none">
                    Hủy
                </button>
                <button type="submit" class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg transition-colors focus:outline-none shadow-md">
                    Lưu chi nhánh
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ----------------- MODAL 2: QUẢN LÝ CHI NHÁNH ----------------- --}}
<div id="manageBranchModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl transform transition-all">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
            THÔNG TIN CHI NHÁNH
        </h2>
        <form id="manageBranchForm">
            <input type="hidden" id="current-branch_id">

            <div class="space-y-5">
                <div class="flex items-center space-x-4">
                    <div class="w-1/3 flex flex-col">
                        <label class="text-sm font-semibold text-gray-700 mb-2">Mã CN</label>
                        <input type="text" id="manage-branch_code" class="w-full bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 font-mono" disabled>
                    </div>
                    <div class="w-2/3 flex flex-col">
                        <label class="text-sm font-semibold text-gray-700 mb-2">Tên chi nhánh <span class="text-red-500">*</span></label>
                        <input type="text" id="manage-branch_name" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div class="flex flex-col">
                    <label class="text-sm font-semibold text-gray-700 mb-2">Địa chỉ <span class="text-red-500">*</span></label>
                    <input type="text" id="manage-address" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>

                <div class="flex items-center space-x-6">
                    <div class="flex-1 flex flex-col">
                        <label class="text-sm font-semibold text-gray-700 mb-2">Số điện thoại</label>
                        <input type="text" id="manage-phone" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    {{-- CUSTOM SELECT: MANAGER --}}
                    <div class="flex-1 flex flex-col">
                        <label class="text-sm font-semibold text-gray-700 mb-2">Người quản lý</label>
                        <div class="relative custom-multiselect w-full" data-select-id="manage-manager-custom" data-type="single">
                            <select id="manage-manager-custom-hidden-select" class="hidden">
                                <option value="">-- Chưa chọn --</option>
                                @foreach($managers as $manager) 
                                    <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-xl text-left px-4 py-2.5 flex items-center justify-between focus:ring-2 focus:ring-blue-500 outline-none">
                                <span class="custom-multiselect-display text-gray-500">-- Chưa chọn --</span>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                            </button>
                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                    <li class="px-4 py-2.5 hover:bg-blue-50 cursor-pointer custom-multiselect-option border-b border-gray-50" data-value="1">
                                        <span class="text-sm font-medium text-gray-700">Admin (Mặc định)</span>
                                    </li>
                                    @foreach($managers as $manager)
                                        <li class="px-4 py-2.5 hover:bg-blue-50 cursor-pointer custom-multiselect-option border-b border-gray-50" data-value="{{ $manager->id }}">
                                            <span class="text-sm font-medium text-gray-700">{{ $manager->full_name }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- CUSTOM SELECT: TRẠNG THÁI --}}
                <div class="flex flex-col">
                    <label class="text-sm font-semibold text-gray-700 mb-2">Trạng thái hoạt động</label>
                    <div class="relative custom-multiselect w-full" data-select-id="manage-status-custom" data-type="single">
                        <select id="manage-status-custom-hidden-select" class="hidden">
                            <option value="1">Hoạt động</option>
                            <option value="0">Tạm đóng</option>
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-xl text-left px-4 py-2.5 flex items-center justify-between focus:ring-2 focus:ring-blue-500 outline-none">
                            <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                            <ul class="custom-multiselect-list overflow-y-auto">
                                <li class="px-4 py-2.5 hover:bg-green-50 cursor-pointer custom-multiselect-option border-b border-gray-50" data-value="1">
                                    <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span><span class="text-sm font-medium text-gray-900">Hoạt động</span></div>
                                </li>
                                <li class="px-4 py-2.5 hover:bg-gray-50 cursor-pointer custom-multiselect-option" data-value="0">
                                    <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-gray-400 mr-2"></span><span class="text-sm font-medium text-gray-900">Tạm đóng</span></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                <button type="button" id="btn-delete-branch" class="px-5 py-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 font-semibold transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Xóa chi nhánh
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
    /* === CUSTOM STYLES CHO CUSTOM SELECT COMPONENT === */
    .custom-multiselect-option { @apply bg-white text-gray-700 transition-all duration-200 ease-in-out; }
    .custom-multiselect-option:hover:not(.bg-blue-100) { @apply bg-blue-50 text-gray-900; }
    .custom-multiselect-option.bg-blue-100 { @apply bg-blue-100 text-blue-800 font-medium; }
</style>

<script>
    // --- 1. CUSTOM MULTISELECT LOGIC (REUSABLE) ---
    function updateMultiselectDisplay(container) {
        if (!container) return;
        const select = container.querySelector('select');
        const display = container.querySelector('.custom-multiselect-display');
        const selected = select.options[select.selectedIndex];
        const placeholder = display.dataset.placeholder || 'Chọn...';
        
        if (!selected || selected.value === "") {
            display.textContent = placeholder;
            display.classList.add('text-gray-500');
        } else {
            display.textContent = selected.text;
            display.classList.remove('text-gray-500');
        }
    }

    function setCustomMultiselectValues(container, value) {
        if (!container) return;
        const select = container.querySelector('select');
        const valStr = String(value).trim();
        
        Array.from(select.options).forEach(opt => opt.selected = (String(opt.value).trim() === valStr));
        
        const list = container.querySelector('.custom-multiselect-list');
        if (list) {
            list.querySelectorAll('.custom-multiselect-option').forEach(li => {
                li.classList.remove('bg-blue-100');
                if (String(li.dataset.value).trim() === valStr) li.classList.add('bg-blue-100');
            });
        }
        updateMultiselectDisplay(container);
    }

    function initializeCustomMultiselects() {
        document.querySelectorAll('.custom-multiselect').forEach(container => {
            const trigger = container.querySelector('.custom-multiselect-trigger');
            const panel = container.querySelector('.custom-multiselect-panel');
            const list = container.querySelector('.custom-multiselect-list');
            const select = container.querySelector('select');
            const display = container.querySelector('.custom-multiselect-display');

            if (display) display.dataset.placeholder = display.textContent;

            trigger?.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('.custom-multiselect-panel').forEach(p => { if(p !== panel) p.classList.add('hidden'); });
                panel?.classList.toggle('hidden');
            });

            list?.querySelectorAll('.custom-multiselect-option').forEach(li => {
                li.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const val = li.dataset.value;
                    Array.from(select.options).forEach(opt => opt.selected = (opt.value === val));
                    list.querySelectorAll('.custom-multiselect-option').forEach(l => l.classList.remove('bg-blue-100'));
                    li.classList.add('bg-blue-100');
                    panel?.classList.add('hidden');
                    updateMultiselectDisplay(container);
                });
            });
            updateMultiselectDisplay(container);
        });
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.custom-multiselect')) document.querySelectorAll('.custom-multiselect-panel').forEach(p => p.classList.add('hidden'));
        });
    }

    // --- 2. MAIN APP LOGIC ---
    document.addEventListener('DOMContentLoaded', function () {
        initializeCustomMultiselects();

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const addModal = document.getElementById('addBranchModal');
        const manageModal = document.getElementById('manageBranchModal');
        const addForm = document.getElementById('addBranchForm');
        const manageForm = document.getElementById('manageBranchForm');

        // Helpers Modal
        function closeModal(m) { m.classList.add('hidden'); m.classList.remove('flex'); }
        function openModal(m) { m.classList.remove('hidden'); m.classList.add('flex'); }

        document.querySelectorAll('.close-modal').forEach(b => b.addEventListener('click', () => closeModal(b.closest('.modal-container'))));
        document.querySelectorAll('.modal-container').forEach(m => m.addEventListener('click', e => e.target === m && closeModal(m)));

        // Open ADD Modal
        document.getElementById('openAddModalBtn').onclick = () => {
            addForm.reset();
            setCustomMultiselectValues(document.querySelector('[data-select-id="add-manager-custom"]'), '');
            openModal(addModal);
        };

        // Open MANAGE Modal (Click row)
        document.getElementById('branch-list-body').addEventListener('click', e => {
            const row = e.target.closest('tr.modal-trigger');
            if (!row) return;
            const d = row.dataset;
            
            document.getElementById('current-branch_id').value = d.branch_id;
            document.getElementById('manage-branch_code').value = 'CN' + String(d.branch_id).padStart(3, '0');
            document.getElementById('manage-branch_name').value = d.branch_name || '';
            document.getElementById('manage-address').value = d.address || '';
            document.getElementById('manage-phone').value = d.phone || '';
            
            setCustomMultiselectValues(document.querySelector('[data-select-id="manage-manager-custom"]'), d.manager_id || '');
            setCustomMultiselectValues(document.querySelector('[data-select-id="manage-status-custom"]'), d.is_active);
            
            openModal(manageModal);
        });

        // --- SUBMIT ADD FORM ---
        addForm.onsubmit = async (e) => {
            e.preventDefault();
            const fd = new FormData();
            fd.append('branch_name', document.getElementById('add-branch_name').value);
            fd.append('address', document.getElementById('add-address').value);
            fd.append('phone', document.getElementById('add-phone').value);
            fd.append('manager_id', document.getElementById('add-manager-custom-hidden-select').value);
            fd.append('is_active', 1); // Default active khi tạo mới

            try {
                const res = await fetch('/admin/branches', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd });
                const json = await res.json();
                if(!res.ok) {
                    let msg = 'Lỗi thêm: ';
                    if(json.errors) msg += Object.values(json.errors).join('\n');
                    else msg += json.message;
                    alert(msg);
                } else {
                    alert('Thêm chi nhánh thành công!');
                    location.reload();
                }
            } catch (err) { alert('Lỗi server'); console.error(err); }
        };

        // --- SUBMIT MANAGE FORM ---
        manageForm.onsubmit = async (e) => {
            e.preventDefault();
            const id = document.getElementById('current-branch_id').value;
            const fd = new FormData();
            fd.append('_method', 'PUT');
            fd.append('branch_name', document.getElementById('manage-branch_name').value);
            fd.append('address', document.getElementById('manage-address').value);
            fd.append('phone', document.getElementById('manage-phone').value);
            fd.append('manager_id', document.getElementById('manage-manager-custom-hidden-select').value);
            fd.append('is_active', document.getElementById('manage-status-custom-hidden-select').value);

            try {
                const res = await fetch(`/admin/branches/${id}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd });
                const json = await res.json();
                if(!res.ok) {
                    let msg = 'Lỗi cập nhật: ';
                    if(json.errors) msg += Object.values(json.errors).join('\n');
                    else msg += json.message;
                    alert(msg);
                } else {
                    alert('Cập nhật thành công!');
                    location.reload();
                }
            } catch (err) { alert('Lỗi server'); console.error(err); }
        };

        // --- DELETE ACTION ---
        document.getElementById('btn-delete-branch').onclick = async () => {
            if(!confirm('Bạn chắc chắn muốn xóa chi nhánh này?')) return;
            try {
                const res = await fetch(`/admin/branches/${document.getElementById('current-branch_id').value}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } });
                if(res.ok) { alert('Xóa thành công!'); location.reload(); }
                else alert('Lỗi xóa');
            } catch { alert('Lỗi server'); }
        };
    });
</script>
@endpush