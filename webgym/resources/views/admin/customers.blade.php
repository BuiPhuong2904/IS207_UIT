@extends('layouts.ad_layout')

@section('title', 'Quản lý khách hàng')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">
    
    {{-- HEADER & BUTTONS --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Danh sách khách hàng</h1>
        
        <div class="flex items-center space-x-4 font-open-sans">
            {{-- Dropdown lọc --}}
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900">
                <span class="mr-1 text-sm font-medium">Hôm nay</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            {{-- Nút Thêm Khách Hàng --}}
            <button id="openAddModalBtn" class="bg-[#28A745] hover:bg-[#218838] text-white px-4 py-2 rounded-full flex items-center text-sm font-semibold transition-colors shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm khách hàng
            </button>
        </div>
    </div>

    {{-- TABLE CONTENT --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center">
                <tr>
                    <th class="py-4 px-4 w-[10%] truncate">ID</th>
                    <th class="py-4 px-4 w-[20%] truncate">Họ và tên</th>
                    <th class="py-4 px-4 w-[20%] truncate">Email</th>
                    <th class="py-4 px-4 w-[15%] truncate">Số điện thoại</th>
                    <th class="py-4 px-4 w-[10%] truncate">Ngày sinh</th>
                    <th class="py-4 px-4 flex-1 truncate">Địa chỉ</th>
                    <th class="py-4 px-4 w-[15%] truncate">Trạng thái</th>
                </tr>
            </thead>

            <tbody id="customer-list-body" class="text-sm text-gray-700 text-center">
                @forelse ($customers as $customer)
                    @php
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';
                        $formattedDate = $customer->birth_date ? \Carbon\Carbon::parse($customer->birth_date)->format('Y-m-d') : '';
                    @endphp

                    <tr class="{{ $rowBg }} cursor-pointer transition-colors modal-trigger group"
                        id="row-{{ $customer->id }}"
                        data-id="{{ $customer->id }}"
                        data-full_name="{{ $customer->full_name }}"
                        data-email="{{ $customer->email }}"
                        data-phone="{{ $customer->phone ?? '' }}"
                        data-birth_date="{{ $formattedDate }}"
                        data-gender="{{ $customer->gender ?? 'Nam' }}"
                        data-address="{{ $customer->address ?? '' }}"
                        data-status="{{ $customer->status ?? 'active' }}"
                        data-image_url="{{ $customer->image_url ?? asset('images/default-avatar.png') }}"
                    >
                        {{-- ID --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }} font-medium">
                            KH{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Họ tên --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            {{ $customer->full_name }}
                        </td>

                        {{-- Email --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $customer->email }}
                        </td>

                        {{-- SĐT --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            {{ $customer->phone ?? '—' }}
                        </td>

                        {{-- Ngày sinh --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $formattedDate ?: '—' }}
                        </td>

                        {{-- Địa chỉ --}}
                        <td class="py-4 px-4 align-middle text-left max-w-xs truncate" title="{{ $customer->address }}">
                            {{ $customer->address ?? '—' }}
                        </td>

                        {{-- Trạng thái --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            @if ($customer->status == 'active')
                                <span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                                    Hoạt động
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-500 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                                    Bị khóa
                                </span>
                            @endif
                        </td>
                    </tr>
                    
                    <tr class="h-2"></tr> 
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-500 italic">Chưa có khách hàng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(method_exists($customers, 'links'))
        <div class="mt-6 flex justify-center">
             {{ $customers->links() }} 
        </div>
        @endif
    </div>
</div>

{{-- ----------------- MODAL 1: THÊM KHÁCH HÀNG ----------------- --}}
<div id="addCustomerModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 transition-opacity">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto transform transition-all scale-100">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
            THÊM KHÁCH HÀNG MỚI
        </h2>
        <form id="addCustomerForm">
            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">Thông tin cơ bản</h3>
            <div class="flex space-x-6 mb-6">
                <div class="w-40 flex-shrink-0 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-100 rounded-2xl flex items-center justify-center mb-3 border-2 border-dashed border-gray-300 overflow-hidden">
                        <img id="add-image_url_preview" src="{{ asset('images/default-avatar.png') }}" class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="add-upload-btn" class="w-full px-4 py-2 bg-blue-50 text-blue-600 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">Upload ảnh</button>
                    <input type="file" id="add-image_url" class="hidden" accept="image/*">
                </div>

                <div class="flex-1 flex flex-col space-y-4">
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Họ và tên <span class="text-red-500">*</span></label>
                        <input type="text" id="add-full_name" required class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Ngày sinh</label>
                            <input type="date" id="add-birth_date" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="flex items-center flex-1"> 
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Giới tính</label>
                            <div class="flex items-center space-x-4 flex-1"> 
                                <label class="flex items-center cursor-pointer"><input type="radio" name="add-gender" value="Nam" class="mr-2 accent-blue-600" checked> Nam</label>
                                <label class="flex items-center cursor-pointer"><input type="radio" name="add-gender" value="Nữ" class="mr-2 accent-blue-600"> Nữ</label>
                                <label class="flex items-center cursor-pointer"><input type="radio" name="add-gender" value="Khác" class="mr-2 accent-blue-600"> Khác</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Mật khẩu <span class="text-red-500">*</span></label>
                            <input type="password" id="add-password" required class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Xác nhận <span class="text-red-500">*</span></label>
                            <input type="password" id="add-password_confirmation" required class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="add-email" required class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">SĐT</label>
                            <input type="tel" id="add-phone" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Địa chỉ</label>
                        <input type="text" id="add-address" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="flex justify-center space-x-3 mt-8 pt-4 border-t border-gray-100">
                <button type="button" class="close-modal px-6 py-2.5 bg-[#6c757d] hover:bg-[#5a6268] text-white font-semibold rounded-lg transition-colors focus:outline-none">
                    Hủy
                </button>
                <button type="submit" class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg transition-colors focus:outline-none shadow-md">
                    Thêm khách hàng
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ----------------- MODAL 2: QUẢN LÝ / CHỈNH SỬA KHÁCH HÀNG ----------------- --}}
<div id="manageCustomerModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto transform transition-all">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
            QUẢN LÝ KHÁCH HÀNG
        </h2>
        <form id="manageCustomerForm">
            <input type="hidden" id="current-customer_id">

            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">Thông tin chi tiết</h3>
            <div class="flex space-x-6 mb-6">
                {{-- Cột Ảnh --}}
                <div class="w-40 flex-shrink-0 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-100 rounded-2xl flex items-center justify-center mb-3 border-2 border-dashed border-gray-300 overflow-hidden">
                        <img id="manage-image_url_preview" src="" class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="manage-upload-btn" class="w-full px-4 py-2 bg-blue-50 text-blue-600 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">Upload ảnh</button>
                    <input type="file" id="manage-image_url_input" class="hidden" accept="image/*">
                </div>

                {{-- Cột Form --}}
                <div class="flex-1 flex flex-col space-y-4">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">ID</label>
                            <input type="text" id="manage-display_id" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 font-mono" disabled>
                        </div>
                        <div class="flex items-center flex-1">
                            <label class="w-20 flex-shrink-0 text-sm font-semibold text-gray-700">Họ tên <span class="text-red-500">*</span></label>
                            <input type="text" id="manage-full_name" required class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>

                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Ngày sinh</label>
                            <input type="date" id="manage-birth_date" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="flex items-center flex-1"> 
                            <label class="w-20 flex-shrink-0 text-sm font-semibold text-gray-700">Giới tính</label>
                            <div class="flex items-center space-x-4 flex-1"> 
                                <label class="flex items-center cursor-pointer"><input type="radio" name="manage-gender" value="Nam" id="manage-gender-male" class="mr-2 accent-blue-600"> Nam</label>
                                <label class="flex items-center cursor-pointer"><input type="radio" name="manage-gender" value="Nữ" id="manage-gender-female" class="mr-2 accent-blue-600"> Nữ</label>
                                <label class="flex items-center cursor-pointer"><input type="radio" name="manage-gender" value="Khác" id="manage-gender-other" class="mr-2 accent-blue-600"> Khác</label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Mật khẩu</label>
                            <input type="password" id="manage-password" placeholder="Nhập nếu đổi pass" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        {{-- THÊM SELECT TRẠNG THÁI VÀO ĐÂY --}}
                        <div class="flex items-center flex-1">
                            <label class="w-20 flex-shrink-0 text-sm font-semibold text-gray-700">Trạng thái</label>
                            <select id="manage-status" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                                <option value="active">Hoạt động</option>
                                <option value="inactive">Bị khóa</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="manage-email" required class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                         <div class="flex items-center flex-1">
                            <label class="w-20 flex-shrink-0 text-sm font-semibold text-gray-700">SĐT</label>
                            <input type="text" id="manage-phone" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>

                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Địa chỉ</label>
                        <input type="text" id="manage-address" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                <button type="button" id="btn-delete-customer" class="px-5 py-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 font-semibold transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Xóa khách hàng
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const addModal = document.getElementById('addCustomerModal');
        const manageModal = document.getElementById('manageCustomerModal');
        const addForm = document.getElementById('addCustomerForm');
        const manageForm = document.getElementById('manageCustomerForm');
        const defaultAvatar = '{{ asset('images/default-avatar.png') }}';

        // --- 1. LOGIC PREVIEW ẢNH ---
        function setupPreview(btnId, inputId, previewId) {
            const btn = document.getElementById(btnId);
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            if (btn && input) {
                btn.onclick = () => input.click();
                input.onchange = e => {
                    if (e.target.files[0]) {
                        const r = new FileReader();
                        r.onload = ev => preview.src = ev.target.result;
                        r.readAsDataURL(e.target.files[0]);
                    }
                };
            }
        }
        setupPreview('add-upload-btn', 'add-image_url', 'add-image_url_preview');
        setupPreview('manage-upload-btn', 'manage-image_url_input', 'manage-image_url_preview');

        // --- 2. HELPERS MODAL ---
        function closeModal(m) { m.classList.add('hidden'); m.classList.remove('flex'); }
        function openModal(m) { m.classList.remove('hidden'); m.classList.add('flex'); }

        document.querySelectorAll('.close-modal').forEach(b => b.addEventListener('click', () => closeModal(b.closest('.modal-container'))));
        document.querySelectorAll('.modal-container').forEach(m => m.addEventListener('click', e => e.target === m && closeModal(m)));

        // --- 3. OPEN ADD MODAL ---
        document.getElementById('openAddModalBtn').onclick = () => {
            addForm.reset();
            document.getElementById('add-image_url_preview').src = defaultAvatar;
            openModal(addModal);
        };

        // --- 4. OPEN MANAGE MODAL (Click row) ---
        document.getElementById('customer-list-body').addEventListener('click', e => {
            const row = e.target.closest('tr.modal-trigger');
            if (!row) return;
            const d = row.dataset;
            
            // Đổ dữ liệu vào modal Edit
            document.getElementById('current-customer_id').value = d.id;
            document.getElementById('manage-display_id').value = 'KH' + String(d.id).padStart(4, '0');
            document.getElementById('manage-full_name').value = d.full_name || '';
            document.getElementById('manage-email').value = d.email || '';
            document.getElementById('manage-phone').value = d.phone || '';
            document.getElementById('manage-address').value = d.address || '';
            document.getElementById('manage-birth_date').value = d.birth_date || '';
            document.getElementById('manage-password').value = '';
            
            // Xử lý status (mặc định active nếu null)
            document.getElementById('manage-status').value = d.status || 'active';

            // Xử lý radio giới tính
            if (d.gender === 'Nam') document.getElementById('manage-gender-male').checked = true;
            else if (d.gender === 'Nữ') document.getElementById('manage-gender-female').checked = true;
            else document.getElementById('manage-gender-other').checked = true;
            
            // Xử lý ảnh
            document.getElementById('manage-image_url_preview').src = d.image_url || defaultAvatar;
            
            openModal(manageModal);
        });

        // --- 5. SUBMIT ADD FORM (AJAX) ---
        addForm.onsubmit = async (e) => {
            e.preventDefault();
            const pass = document.getElementById('add-password').value;
            const confirmPass = document.getElementById('add-password_confirmation').value;
            if (pass !== confirmPass) { alert('Mật khẩu xác nhận không khớp!'); return; }

            const fd = new FormData();
            fd.append('full_name', document.getElementById('add-full_name').value);
            fd.append('email', document.getElementById('add-email').value);
            fd.append('password', pass);
            fd.append('phone', document.getElementById('add-phone').value);
            fd.append('address', document.getElementById('add-address').value);
            fd.append('gender', document.querySelector('input[name="add-gender"]:checked').value);
            fd.append('birth_date', document.getElementById('add-birth_date').value);
            // Default active khi tạo mới
            fd.append('status', 'active');
            
            if(document.getElementById('add-image_url').files[0]) fd.append('image', document.getElementById('add-image_url').files[0]);

            try {
                const res = await fetch('{{ route("admin.customers.store") }}', { 
                    method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd 
                });
                const json = await res.json();
                if(!res.ok) {
                    let msg = 'Lỗi thêm: ';
                    if(json.errors) msg += Object.values(json.errors).flat().join('\n'); else msg += json.message;
                    alert(msg);
                } else { alert('Thêm khách hàng thành công!'); location.reload(); }
            } catch (err) { alert('Lỗi hệ thống.'); console.error(err); }
        };

        // --- 6. SUBMIT MANAGE FORM (AJAX UPDATE) ---
        manageForm.onsubmit = async (e) => {
            e.preventDefault();
            const id = document.getElementById('current-customer_id').value;
            const fd = new FormData();
            fd.append('_method', 'PUT');
            fd.append('full_name', document.getElementById('manage-full_name').value);
            fd.append('email', document.getElementById('manage-email').value);
            fd.append('phone', document.getElementById('manage-phone').value);
            fd.append('address', document.getElementById('manage-address').value);
            fd.append('gender', document.querySelector('input[name="manage-gender"]:checked').value);
            fd.append('birth_date', document.getElementById('manage-birth_date').value);
            
            // Gửi thêm status
            fd.append('status', document.getElementById('manage-status').value);

            const pass = document.getElementById('manage-password').value;
            if(pass) fd.append('password', pass);

            if(document.getElementById('manage-image_url_input').files[0]) fd.append('image', document.getElementById('manage-image_url_input').files[0]);

            try {
                const res = await fetch(`/admin/customers/${id}`, { 
                    method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd 
                });
                const json = await res.json();
                if(!res.ok) {
                    let msg = 'Lỗi cập nhật: ';
                    if(json.errors) msg += Object.values(json.errors).flat().join('\n'); else msg += json.message;
                    alert(msg);
                } else { alert('Cập nhật thành công!'); location.reload(); }
            } catch (err) { alert('Lỗi hệ thống.'); console.error(err); }
        };

        // --- 7. DELETE ACTION ---
        document.getElementById('btn-delete-customer').onclick = async () => {
            if(!confirm('Bạn có chắc chắn muốn xóa khách hàng này không?')) return;
            const id = document.getElementById('current-customer_id').value;
            try {
                const res = await fetch(`/admin/customers/${id}`, { 
                    method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } 
                });
                if(res.ok) { alert('Xóa thành công!'); location.reload(); } 
                else { const json = await res.json(); alert(json.message || 'Lỗi khi xóa.'); }
            } catch { alert('Lỗi hệ thống.'); }
        };
    });
</script>
@endpush