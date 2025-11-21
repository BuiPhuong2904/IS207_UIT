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
            <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-[5%]"></th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Mã lớp</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[20%]">Tên lớp</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[15%]">Loại lớp</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[12%]">Sĩ số tối đa</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase flex-1">Mô tả</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase w-[15%]">Trạng thái</th>
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

                <td colspan="7" class="p-0">
                    <div class="flex w-full rounded-lg items-center {{ $loop->even ? 'bg-white' : 'bg-[#1976D2]/10' }} shadow-sm overflow-hidden class-row-content">

                        {{-- Cột ngôi sao (nếu muốn thêm trường is_featured sau này thì bật lại) --}}
                        <div class="px-4 py-3 w-[5%] text-center star-icon">
                            {{-- @if($class->is_featured ?? false) ... @endif --}}
                        </div>

                        {{-- Mã lớp: LO0001 --}}
                        <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900">
                            LO{{ str_pad($class->class_id, 4, '0', STR_PAD_LEFT) }}
                        </div>

                        <div class="px-4 py-3 w-[20%] text-sm text-gray-700 font-medium">
                            {{ $class->class_name }}
                        </div>

                        <div class="px-4 py-3 w-[15%] text-sm text-gray-700">
                            {{ $class->type }}
                        </div>

                        <div class="px-4 py-3 w-[12%] text-sm text-gray-700">
                            {{ $class->max_capacity }} người
                        </div>

                        <div class="px-4 py-3 flex-1 text-sm text-gray-700 truncate" title="{{ $class->description ?? '' }}">
                            {{ Str::limit($class->description ?? '—', 100) }}
                        </div>

                        <div class="px-4 py-3 w-[15%] text-right">
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

{{-- ========================= MODAL THÊM LỚP  ========================= --}}
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

                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Loại lớp <span class="text-red-500">*</span></label>
                        <select id="add-type" required class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5">
                            <option value="">Chọn loại lớp...</option>
                            <option value="Yoga">Yoga</option>
                            <option value="Gym">Gym</option>
                            <option value="Cardio">Cardio</option>
                            <option value="Zumba">Zumba</option>
                            <option value="Boxing">Boxing</option>
                            <option value="Pilates">Pilates</option>
                            <option value="Dance">Dance</option>
                            <option value="Kickboxing">Kickboxing</option>
                            <option value="MMA">MMA</option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Sĩ số tối đa <span class="text-red-500">*</span></label>
                        <input type="number" id="add-max_capacity" required min="1" max="100" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5">
                    </div>

                    <div class="flex items-start space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3 pt-2">Mô tả</label>
                        <textarea id="add-description" rows="4" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <button type="button" class="close-modal px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Hủy</button>
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">Thêm lớp</button>
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
                        <input type="text" id="manage-class_name" required class="w-2/3 border border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5">
                    </div>

                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Loại lớp</label>
                        <select id="manage-type" required class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5">
                            <option value="Yoga">Yoga</option>
                            <option value="Gym">Gym</option>
                            <option value="Cardio">Cardio</option>
                            <option value="Zumba">Zumba</option>
                            <option value="Boxing">Boxing</option>
                            <option value="Pilates">Pilates</option>
                            <option value="Dance">Dance</option>
                            <option value="Kickboxing">Kickboxing</option>
                            <option value="MMA">MMA</option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Sĩ số tối đa</label>
                        <input type="number" id="manage-max_capacity" required min="1" max="100" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5">
                    </div>

                    <div class="flex items-center space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3">Trạng thái</label>
                        <select id="manage-is_active" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5">
                            <option value="1">Đang hoạt động</option>
                            <option value="0">Dừng hoạt động</option>
                        </select>
                    </div>

                    <div class="flex items-start space-x-4">
                        <label class="block text-sm font-medium text-gray-700 w-1/3 pt-2">Mô tả</label>
                        <textarea id="manage-description" rows="4" class="w-2/3 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-8">
                <button type="button" id="btn-delete-class" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    Xóa lớp
                </button>
                <div class="space-x-4">
                    <button type="button" class="close-modal px-6 py-3 bg-gray-500 text-white rounded-lg">Hủy</button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg">Lưu thay đổi</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ========================= SCRIPT AJAX  ========================= --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const addModal = document.getElementById('addClassModal');
        const manageModal = document.getElementById('manageClassModal');
        const tbody = document.getElementById('classTableBody');

        // Upload ảnh preview
        document.getElementById('add-upload-btn').addEventListener('click', () => document.getElementById('add-image_url').click());
        document.getElementById('add-image_url').addEventListener('change', function(e) {
            if (this.files[0]) {
                const reader = new FileReader();
                reader.onload = (ev) => document.getElementById('add-image-preview').src = ev.target.result;
                reader.readAsDataURL(this.files[0]);
            }
        });

        document.getElementById('manage-upload-btn').addEventListener('click', () => document.getElementById('manage-image_url_input').click());
        document.getElementById('manage-image_url_input').addEventListener('change', function(e) {
            if (this.files[0]) {
                const reader = new FileReader();
                reader.onload = (ev) => document.getElementById('manage-image_url').src = ev.target.result;
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Mở/đóng modal
        function openModal(m) { m.classList.remove('hidden'); m.classList.add('flex'); }
        function closeModal(m) { m.classList.add('hidden'); m.classList.remove('flex'); }

        document.querySelectorAll('.close-modal').forEach(btn => btn.addEventListener('click', () => closeModal(btn.closest('.modal-container'))));
        document.querySelectorAll('.modal-container').forEach(m => m.addEventListener('click', e => e.target === m && closeModal(m)));

        // Mở modal thêm
        document.getElementById('openAddModalBtn').addEventListener('click', () => {
            document.getElementById('addClassForm').reset();
            document.getElementById('add-image-preview').src = "https://via.placeholder.com/160x160.png?text=Class";
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
            document.getElementById('manage-type').value = d.type;
            document.getElementById('manage-max_capacity').value = d.max_capacity;
            document.getElementById('manage-description').value = d.description;
            document.getElementById('manage-is_active').value = d.is_active;
            document.getElementById('manage-image_url').src = d.image_url || "https://via.placeholder.com/160x160.png?text=Class";

            openModal(manageModal);
        });

        // THÊM LỚP
        document.getElementById('addClassForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData();
            formData.append('class_name', document.getElementById('add-class_name').value.trim());
            formData.append('type', document.getElementById('add-type').value);
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
            formData.append('_method', 'PUT');
            formData.append('class_name', document.getElementById('manage-class_name').value.trim());
            formData.append('type', document.getElementById('manage-type').value);
            formData.append('max_capacity', document.getElementById('manage-max_capacity').value);
            formData.append('description', document.getElementById('manage-description').value.trim());
            formData.append('is_active', document.getElementById('manage-is_active').value);
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
            if (!confirm('Xóa lớp học này? Không thể khôi phục!')) return;
            const id = document.getElementById('current-class_id').value;

            fetch(`/admin/class_list/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            })
                .then(r => r.json())
                .then(res => {
                    alert(res.message);
                    if (res.success) location.reload();
                });
        });
    });
</script>
@endpush

@endsection
