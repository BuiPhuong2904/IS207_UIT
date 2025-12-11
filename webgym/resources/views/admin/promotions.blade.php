@extends('layouts.ad_layout')

@section('title', 'Quản lý khuyến mãi')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6 font-open-sans">

    {{-- HEADER & BUTTONS --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold uppercase">KHUYẾN MÃI</h1>
        <button onclick="openModal('addPromotionModal')" class="bg-[#28A745] hover:bg-[#218838] text-white px-6 py-2 rounded-full flex items-center font-medium transition-colors shadow-sm hover:shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Thêm
        </button>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            <thead class="font-montserrat text-[#999] text-xs font-medium uppercase">
            <tr>
                <th class="py-4 px-4 w-[10%]">ID</th>
                <th class="py-4 px-4 w-[10%]">Mã</th>
                <th class="py-4 px-4 w-[20%]">Tiêu đề</th>
                <th class="py-4 px-4 w-[10%]">Giảm</th>
                <th class="py-4 px-4 w-[10%]">Bắt đầu</th>
                <th class="py-4 px-4 w-[10%]">Kết thúc</th>
                <th class="py-4 px-4 w-[10%]">Giới hạn</th>
                <th class="py-4 px-4 w-[15%] text-right">Trạng thái</th>
            </tr>
            </thead>
            <tbody id="promotion-list-body">
            @foreach ($promotions as $item)
            @php
            $isOdd = $loop->odd;
            $rowBg = $isOdd ? 'bg-[#1976D2]/10' : 'bg-white';
            $discount = $item->is_percent ? $item->discount_value . '%' : number_format($item->discount_value, 0, ',', '.') . 'đ';
            $startDate = $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') : 'Không giới hạn';
            $endDate = $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') : 'Không giới hạn';
            $usageLimit = $item->usage_limit ? $item->usage_limit : 'Vô hạn';
            $statusBadge = $item->is_active
            ? '<span class="bg-[#28A745]/20 text-[#28A745] py-1 px-4 rounded-full text-xs font-bold">Hoạt động</span>'
            : '<span class="bg-gray-200 text-gray-600 py-1 px-4 rounded-full text-xs font-bold">Dừng</span>';
            @endphp

            <tr class="{{ $rowBg }} cursor-pointer hover:bg-blue-50 transition-colors" onclick="openManageModal({{ $item->promotion_id }})">
                <td class="py-4 px-4 rounded-l-lg">KM{{ str_pad($item->promotion_id, 4, '0', STR_PAD_LEFT) }}</td>
                <td class="py-4 px-4">{{ $item->code }}</td>
                <td class="py-4 px-4 font-medium text-gray-800">{{ $item->title }}</td>
                <td class="py-4 px-4">{{ $discount }}</td>
                <td class="py-4 px-4">{{ $startDate }}</td>
                <td class="py-4 px-4">{{ $endDate }}</td>
                <td class="py-4 px-4">{{ $usageLimit }}</td>
                <td class="py-4 px-4 text-right rounded-r-lg">{!! $statusBadge !!}</td>
            </tr>
            <tr class="h-1 bg-white"></tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-6 flex justify-center">
            {{ $promotions->links() }}
        </div>
    </div>
</div>

{{-- MODAL THÊM --}}
<div id="addPromotionModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-[90%] md:max-w-6xl h-[90vh] flex flex-col overflow-hidden">
        <div class="flex justify-between items-center px-8 py-5 border-b">
            <h2 class="text-xl font-bold text-[#1976D2] font-montserrat uppercase">THÊM KHUYẾN MÃI</h2>
            <div class="flex space-x-3">
                <button type="button" onclick="submitAddForm()" class="px-6 py-2 bg-[#28a745] hover:bg-green-600 text-white rounded-lg text-sm">Lưu</button>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 bg-[#F8F9FA]">
            <form id="addPromotionForm">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Mã khuyến mãi <span class="text-red-500">*</span></label>
                            <input type="text" name="code" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Tiêu đề <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Mô tả</label>
                            <textarea name="description" rows="4" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2"></textarea>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Giá trị giảm <span class="text-red-500">*</span></label>
                            <input type="number" name="discount_value" required min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Loại giảm giá</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="is_percent" value="1" checked>
                                    <span class="ml-2">Phần trăm (%)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="is_percent" value="0">
                                    <span class="ml-2">Cố định (đ)</span>
                                </label>
                            </div>
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Ngày bắt đầu</label>
                            <input type="date" name="start_date" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Ngày kết thúc</label>
                            <input type="date" name="end_date" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Giới hạn sử dụng</label>
                            <input type="number" name="usage_limit" min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Giới hạn mỗi người</label>
                            <input type="number" name="per_user_limit" min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Đơn tối thiểu</label>
                            <input type="number" name="min_order_amount" min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Giảm tối đa</label>
                            <input type="number" name="max_discount" min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 flex items-center justify-between">
                            <label class="block text-gray-800 font-bold">Hoạt động</label>
                            <select name="is_active" class="border border-gray-300 rounded-xl px-4 py-2.5">
                                <option value="1">Hoạt động</option>
                                <option value="0">Dừng</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="px-8 py-4 border-t bg-white flex justify-end space-x-4">
            <button type="button" class="close-modal px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg">Hủy</button>
        </div>
    </div>
</div>

{{-- MODAL SỬA --}}
<div id="managePromotionModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-[90%] md:max-w-6xl h-[90vh] flex flex-col overflow-hidden">
        <div class="flex justify-between items-center px-8 py-5 border-b">
            <h2 class="text-xl font-bold text-[#1976D2] font-montserrat uppercase">QUẢN LÝ KHUYẾN MÃI</h2>
            <div class="flex space-x-3">
                <button type="button" onclick="submitManageForm()" class="px-6 py-2 bg-[#28a745] hover:bg-green-600 text-white rounded-lg text-sm">Lưu</button>
            </div>
        </div>
        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 bg-[#F8F9FA]">
            <form id="managePromotionForm">
                <input type="hidden" id="manage-promotion_id">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Mã khuyến mãi <span class="text-red-500">*</span></label>
                            <input type="text" id="manage-code" name="code" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Tiêu đề <span class="text-red-500">*</span></label>
                            <input type="text" id="manage-title" name="title" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Mô tả</label>
                            <textarea id="manage-description" name="description" rows="4" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2"></textarea>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Giá trị giảm <span class="text-red-500">*</span></label>
                            <input type="number" id="manage-discount_value" name="discount_value" required min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Loại giảm giá</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="is_percent" value="1">
                                    <span class="ml-2">Phần trăm (%)</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="is_percent" value="0">
                                    <span class="ml-2">Cố định (đ)</span>
                                </label>
                            </div>
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Ngày bắt đầu</label>
                            <input type="date" id="manage-start_date" name="start_date" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Ngày kết thúc</label>
                            <input type="date" id="manage-end_date" name="end_date" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Giới hạn sử dụng</label>
                            <input type="number" id="manage-usage_limit" name="usage_limit" min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Giới hạn mỗi người</label>
                            <input type="number" id="manage-per_user_limit" name="per_user_limit" min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Đơn tối thiểu</label>
                            <input type="number" id="manage-min_order_amount" name="min_order_amount" min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <label class="block text-gray-800 font-bold mb-2">Giảm tối đa</label>
                            <input type="number" id="manage-max_discount" name="max_discount" min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-lg">
                        </div>
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 flex items-center justify-between">
                            <label class="block text-gray-800 font-bold">Trạng thái</label>
                            <select id="manage-is_active" name="is_active" class="border border-gray-300 rounded-xl px-4 py-2.5">
                                <option value="1">Hoạt động</option>
                                <option value="0">Dừng</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex justify-center items-center py-4 border-t bg-white space-x-6">
            <button id="btn-delete-promotion" class="px-8 py-2 bg-[#DC3545] hover:bg-red-700 text-white font-semibold rounded-lg">Xóa</button>
            <button type="button" class="close-modal px-8 py-2 bg-[#C4C4C4] hover:bg-gray-500 text-white font-semibold rounded-lg">Hủy</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // === TẤT CẢ HÀM ĐƯỢC ĐƯA RA NGOÀI ĐỂ onclick NHÌN THẤY ===
    window.openModal = function(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    };

    window.closeModal = function(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    };

    // MỞ MODAL SỬA
    window.openManageModal = function(id) {
        fetch(`/admin/promotions/${id}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('manage-promotion_id').value = data.promotion_id;
                document.getElementById('manage-code').value = data.code;
                document.getElementById('manage-title').value = data.title;
                document.getElementById('manage-description').value = data.description || '';
                document.getElementById('manage-discount_value').value = data.discount_value;
                document.querySelector(`input[name="is_percent"][value="${data.is_percent}"]`).checked = true;
                document.getElementById('manage-start_date').value = data.start_date || '';
                document.getElementById('manage-end_date').value = data.end_date || '';
                document.getElementById('manage-usage_limit').value = data.usage_limit || '';
                document.getElementById('manage-per_user_limit').value = data.per_user_limit || '';
                document.getElementById('manage-min_order_amount').value = data.min_order_amount || '';
                document.getElementById('manage-max_discount').value = data.max_discount || '';
                document.getElementById('manage-is_active').value = data.is_active ? '1' : '0';

                openModal('managePromotionModal');
            });
    };

    // LƯU THÊM MỚI
    window.submitAddForm = function() {
        const form = document.getElementById('addPromotionForm');
        const formData = new FormData(form);

        fetch('/admin/promotions', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    alert(res.message || 'Thêm thành công!');
                    closeModal('addPromotionModal');
                    location.reload();
                } else {
                    alert('Lỗi: ' + (res.message || 'Không thể thêm'));
                }
            })
            .catch(() => alert('Lỗi hệ thống'));
    };

    // LƯU SỬA
    window.submitManageForm = function() {
        const id = document.getElementById('manage-promotion_id').value;
        const form = document.getElementById('managePromotionForm');
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        fetch(`/admin/promotions/${id}`, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    alert(res.message || 'Cập nhật thành công!');
                    closeModal('managePromotionModal');
                    location.reload();
                } else {
                    alert('Lỗi cập nhật');
                }
            });
    };

    // XÓA
    document.getElementById('btn-delete-promotion')?.addEventListener('click', function() {
        const id = document.getElementById('manage-promotion_id')?.value;
        if (!id || !confirm('Xóa khuyến mãi này? Không thể khôi phục!')) return;

        fetch(`/admin/promotions/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    alert('Đã xóa!');
                    closeModal('managePromotionModal');
                    location.reload();
                }
            });
    });

    // === DOM LOADED – CHỈ GẮN SỰ KIỆN ===
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.close-modal').forEach(b => {
            b.addEventListener('click', () => closeModal(b.closest('.modal-container').id));
        });
        document.querySelectorAll('.modal-container').forEach(m => {
            m.addEventListener('click', e => { if (e.target === m) closeModal(m.id); });
        });
    });
</script>
@endpush
