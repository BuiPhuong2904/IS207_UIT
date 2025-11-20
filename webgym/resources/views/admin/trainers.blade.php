@extends('layouts.ad_layout')

@section('title', 'Quản lý huấn luyện viên')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Header --}}
<div class="flex justify-end items-center mb-6 hidden lg:flex">
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
        Thêm HLV
    </button>
</div>

{{-- Bảng danh sách HLV --}}
<div class="bg-white p-6 rounded-lg shadow-xl">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Danh sách huấn luyện viên</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border-separate border-spacing-y-2">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Mã HLV</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[20%]">Họ và tên</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[20%]">Email</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[12%]">Tiền lương</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[12%]">Chuyên môn</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase flex-1">Lịch làm việc</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase w-[15%]">Trạng thái</th>
            </tr>
            </thead>

            <tbody id="trainerTableBody">
            @foreach ($trainers as $trainer)
            <tr class="transition duration-150 cursor-pointer modal-trigger"
                data-trainer_id="{{ $trainer->user_id }}"
                data-full_name="{{ $trainer->user->full_name ?? '' }}"
                data-email="{{ $trainer->user->email ?? '' }}"
                data-phone="{{ $trainer->user->phone ?? '' }}"
                data-address="{{ $trainer->user->address ?? '' }}"
                data-salary="{{ $trainer->salary }}"
                data-specialty="{{ $trainer->specialty }}"
                data-experience_years="{{ $trainer->experience_years }}"
                data-work_schedule="{{ $trainer->work_schedule }}"
                data-branch_id="{{ $trainer->branch_id }}"
                data-status="{{ $trainer->status }}"
                data-image_url="{{ $trainer->user->image_url ?? asset('images/default-avatar.png') }}"
            >
                <td colspan="7" class="p-0">
                    <div class="flex w-full rounded-lg items-center {{ $loop->even ? 'bg-white' : 'bg-[#1976D2]/10' }} shadow-sm overflow-hidden">
                        <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900">
                            HLV{{ str_pad($trainer->user_id, 4, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="px-4 py-3 w-[20%] text-sm font-medium text-gray-800">
                            {{ $trainer->user->full_name ?? 'Chưa có tên' }}
                        </div>
                        <div class="px-4 py-3 w-[20%] text-sm text-gray-700">
                            {{ $trainer->user->email ?? '-' }}
                        </div>
                        <div class="px-4 py-3 w-[12%] text-sm text-gray-700">
                            {{ number_format($trainer->salary, 0, ',', '.') }} đ
                        </div>
                        <div class="px-4 py-3 w-[12%] text-sm text-gray-700 font-medium">
                            {{ $trainer->specialty }}
                        </div>
                        <div class="px-4 py-3 flex-1 text-sm text-gray-700 truncate" title="{{ $trainer->work_schedule }}">
                            {{ $trainer->work_schedule ?: '—' }}
                        </div>
                        <div class="px-4 py-3 w-[15%] text-right">
                            @if($trainer->status == 'active')
                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800">
                                Đang hoạt động
                            </span>
                            @else
                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-gray-200 text-gray-800">
                                Nghỉ việc
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
            {{ $trainers->links() }}
        </div>
    </div>
</div>

{{-- ========================= MODAL THÊM HLV ========================= --}}
<div id="addTrainerModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-y-auto">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent">
            THÊM HUẤN LUYỆN VIÊN
        </h2>

        <form id="addTrainerForm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Ảnh -->
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-48 h-48 bg-gray-200 rounded-xl overflow-hidden mb-4 border-4 border-dashed border-gray-300">
                        <img id="add-image-preview" src="https://via.placeholder.com/192x192.png?text=HLV" class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="add-upload-btn" class="flex items-center px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Chọn ảnh đại diện
                    </button>
                    <input type="file" id="add-image_url" accept="image/*" class="hidden">
                </div>

                <!-- Form thông tin -->
                <div class="md:col-span-2 space-y-6">
                    <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin cá nhân</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên <span class="text-red-500">*</span></label>
                            <input type="text" id="add-full_name" required class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="add-email" required class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu <span class="text-red-500">*</span></label>
                            <input type="text" id="add-password" required placeholder="Tạo mật khẩu tạm" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                            <input type="text" id="add-phone" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                        <input type="text" id="add-address" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin công việc</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Chuyên môn <span class="text-red-500">*</span></label>
                            <input type="text" id="add-specialty" required placeholder="Yoga, Gym, Zumba..." class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kinh nghiệm (năm)</label>
                            <input type="number" id="add-experience_years" min="0" value="0" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tiền lương (VND/tháng) <span class="text-red-500">*</span></label>
                            <input type="number" id="add-salary" required min="0" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ID Chi nhánh <span class="text-red-500">*</span></label>
                            <input type="number" id="add-branch_id" required placeholder="Ví dụ: 1" value="1" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lịch làm việc</label>
                        <textarea id="add-work_schedule" rows="4" placeholder="VD: Ca sáng T2-T7, Ca tối T2-CN..." class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-center space-x-8 mt-10">
                <button type="button" class="close-modal px-8 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Hủy</button>
                <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">Thêm HLV</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================= MODAL QUẢN LÝ HLV ========================= --}}
<div id="manageTrainerModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-y-auto">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent">
            QUẢN LÝ HUẤN LUYỆN VIÊN
        </h2>

        <form id="manageTrainerForm">
            <input type="hidden" id="current-trainer_id">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-48 h-48 bg-gray-200 rounded-xl overflow-hidden mb-4 border-4 border-dashed border-gray-300">
                        <img id="manage-image-preview" src="" class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="manage-upload-btn" class="flex items-center px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Đổi ảnh đại diện
                    </button>
                    <input type="file" id="manage-image_url_input" accept="image/*" class="hidden">
                </div>

                <div class="md:col-span-2 space-y-6">
                    <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin cá nhân</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mã HLV</label>
                            <input type="text" id="manage-trainer_code" disabled class="w-full bg-gray-100 rounded-2xl px-4 py-2.5">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                            <input type="text" id="manage-full_name" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="manage-email" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                            <input type="text" id="manage-phone" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                        <input type="text" id="manage-address" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin công việc</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Chuyên môn</label>
                            <input type="text" id="manage-specialty" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kinh nghiệm (năm)</label>
                            <input type="number" id="manage-experience_years" min="0" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tiền lương (VND/tháng)</label>
                            <input type="number" id="manage-salary" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Chi nhánh</label>
                            <input type="number" id="manage-branch_id" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                            <select id="manage-status" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                <option value="active">Đang hoạt động</option>
                                <option value="inactive">Nghỉ việc</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lịch làm việc</label>
                            <textarea id="manage-work_schedule" rows="4" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-10">
                <button type="button" id="btn-delete-trainer" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Xóa HLV
                </button>
                <div class="space-x-4">
                    <button type="button" class="close-modal px-8 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Hủy</button>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Lưu thay đổi</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ========================= SCRIPT AJAX ========================= --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const addModal     = document.getElementById('addTrainerModal');
        const manageModal  = document.getElementById('manageTrainerModal');
        const addForm      = document.getElementById('addTrainerForm');
        const manageForm   = document.getElementById('manageTrainerForm');

        if (!addForm || !manageForm) {
            console.error('Không tìm thấy form! Kiểm tra id="addTrainerForm" và id="manageTrainerForm"');
            return;
        }

        // === PREVIEW ẢNH ===
        function setupPreview(btnId, inputId, previewId) {
            const btn = document.getElementById(btnId);
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            if (btn && input) {
                btn.onclick = () => input.click();
                input.onchange = e => {
                    if (e.target.files[0]) {
                        const reader = new FileReader();
                        reader.onload = ev => preview.src = ev.target.result;
                        reader.readAsDataURL(e.target.files[0]);
                    }
                };
            }
        }
        setupPreview('add-upload-btn',    'add-image_url',         'add-image-preview');
        setupPreview('manage-upload-btn', 'manage-image_url_input','manage-image-preview');

        // === MODAL HELPER ===
        function openModal(m)  { m.classList.remove('hidden'); m.classList.add('flex'); }
        function closeModal(m) { m.classList.add('hidden');    m.classList.remove('flex'); }

        document.querySelectorAll('.close-modal').forEach(btn =>
            btn.addEventListener('click', () => closeModal(btn.closest('.modal-container')))
        );
        document.querySelectorAll('.modal-container').forEach(m =>
            m.addEventListener('click', e => e.target === m && closeModal(m))
        );

        // === MỞ MODAL THÊM ===
        document.getElementById('openAddModalBtn')?.addEventListener('click', () => {
            addForm.reset();
            document.getElementById('add-image-preview').src = 'https://via.placeholder.com/192x192.png?text=HLV';
            openModal(addModal);
        });

        // === CLICK DÒNG → MỞ MODAL SỬA ===
        document.getElementById('trainerTableBody').addEventListener('click', e => {
            const row = e.target.closest('tr.modal-trigger');
            if (!row) return;

            const d = row.dataset;
            document.getElementById('current-trainer_id').value = d.trainer_id;

            document.getElementById('manage-trainer_code').value      = 'HLV' + String(d.trainer_id).padStart(4, '0');
            document.getElementById('manage-full_name').value        = d.full_name || '';
            document.getElementById('manage-email').value            = d.email || '';
            document.getElementById('manage-phone').value            = d.phone || '';
            document.getElementById('manage-address').value          = d.address || '';
            document.getElementById('manage-specialty').value        = d.specialty || '';
            document.getElementById('manage-experience_years').value = d.experience_years || 0;
            document.getElementById('manage-salary').value           = d.salary || '';
            document.getElementById('manage-work_schedule').value    = d.work_schedule || '';
            document.getElementById('manage-branch_id').value       = d.branch_id || '';
            document.getElementById('manage-status').value           = d.status || 'active';
            document.getElementById('manage-image-preview').src      = d.image_url;

            openModal(manageModal);
        });

        // === THÊM MỚI ===
        addForm.onsubmit = async function (e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('user_id', '1'); // Ch có crud user
            formData.append('specialty',        document.getElementById('add-specialty').value.trim());
            formData.append('experience_years', document.getElementById('add-experience_years').value);
            formData.append('salary',           document.getElementById('add-salary').value);
            formData.append('work_schedule',    document.getElementById('add-work_schedule').value.trim());
            formData.append('branch_id',        document.getElementById('add-branch_id').value);
            formData.append('status',           'active'); // ← Mặc định luôn active
            if (document.getElementById('add-image_url').files[0]) {
                formData.append('image_url', document.getElementById('add-image_url').files[0]);
            }
            console.log(formData);
            try {
                const res = await fetch('/admin/trainers', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    body: formData
                });
                const json = await res.json();
                alert(json.message || 'Thêm thành công!');
                if (json.success) location.reload();
            } catch (err) {
                console.error(err);
                alert('Lỗi server!');
            }
        };

        // === SỬA – ĐOẠN QUAN TRỌNG NHẤT ===
        manageForm.onsubmit = async function (e) {
            e.preventDefault();

            const id = document.getElementById('current-trainer_id').value;
            if (!id) return alert('Không có ID HLV!');

            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('full_name',       document.getElementById('manage-full_name').value.trim());
            formData.append('email',           document.getElementById('manage-email').value.trim());
            formData.append('phone',           document.getElementById('manage-phone').value.trim());
            formData.append('address',         document.getElementById('manage-address').value.trim());
            formData.append('specialty',       document.getElementById('manage-specialty').value.trim());
            formData.append('experience_years',document.getElementById('manage-experience_years').value);
            formData.append('salary',          document.getElementById('manage-salary').value);
            formData.append('work_schedule',   document.getElementById('manage-work_schedule').value.trim());
            formData.append('branch_id',       document.getElementById('manage-branch_id').value);
            formData.append('status',          document.getElementById('manage-status').value);

            if (document.getElementById('manage-image_url_input').files[0]) {
                formData.append('image_url', document.getElementById('manage-image_url_input').files[0]);
            }

            try {
                const res = await fetch(`/admin/trainers/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const json = await res.json();
                alert(json.message || 'Cập nhật thành công!');
                if (json.success) location.reload();
            } catch (err) {
                console.error('Lỗi fetch:', err);
                alert('Lỗi server – mở F12 → Network để xem chi tiết');
            }
        };

        // === XÓA ===
        document.getElementById('btn-delete-trainer')?.addEventListener('click', async () => {
            if (!confirm('Xóa HLV này? Không thể khôi phục!')) return;
            const id = document.getElementById('current-trainer_id').value;

            const res = await fetch(`/admin/trainers/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const json = await res.json();
            alert(json.message);
            if (json.success) location.reload();
        });
    });
</script>
@endpush

@endsection
