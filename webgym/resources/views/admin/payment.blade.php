@extends('layouts.ad_layout')

@section('title', 'Quản lý thanh toán')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Quản lý thanh toán</h1>
        <div class="flex items-center space-x-4 font-open-sans">
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900">
                <span class="mr-1 text-sm font-medium">Hôm nay</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center">
            <tr>
                <th class="py-4 px-4 w-[10%] truncate">Code</th>
                <th class="py-4 px-4 w-[20%] truncate text-left pl-8">Mã khách hàng</th>
                <th class="py-4 px-4 w-[10%] truncate">Loại</th>
                <th class="py-4 px-4 w-[15%] truncate">Tổng tiền (VNĐ)</th>
                <th class="py-4 px-4 w-[15%] truncate">Phương thức</th>
                <th class="py-4 px-4 w-[15%] truncate">Ngày thanh toán</th>
                <th class="py-4 px-4 w-[15%] truncate">Trạng thái</th>
            </tr>
            </thead>
            <tbody id="payment-list-body">
            @foreach ($payments as $item)
            @php
            $isOdd = $loop->odd;
            $rowBg = $isOdd ? 'bg-[#1976D2]/10' : 'bg-white';
            $statusBadge = $item->status === 'completed'
            ? '<span class="bg-[#28A745]/20 text-[#28A745] py-1 px-4 rounded-full text-xs font-bold">Hoàn thành</span>'
            : '<span class="bg-[#DC3545]/20 text-[#DC3545] py-1 px-4 rounded-full text-xs font-bold">Bị hủy</span>';
            $paymentDate = $item->payment_date
            ? \Carbon\Carbon::parse($item->payment_date)->format('d/m/Y')
            : 'Chưa có';
            @endphp

            <tr class="{{ $rowBg }} cursor-pointer hover:bg-blue-50 transition-colors modal-trigger"
                onclick="openManageModal({{ $item->payment_id }})">
                <td class="py-4 px-4 rounded-l-lg">{{ $item->payment_code }}</td>
                <td class="py-4 px-4 text-left pl-8">{{ $item->user?->name ?? 'Khách vãng lai' }}</td>
                <td class="py-4 px-4">{{ ucfirst(str_replace('_', ' ', $item->payment_type)) }}</td>
                <td class="py-4 px-4">{{ number_format($item->amount, 0, ',', '.') }}</td>
                <td class="py-4 px-4">{{ $item->method }}</td>
                <td class="py-4 px-4">{{ $paymentDate }}</td>
                <td class="py-4 px-4 text-right rounded-r-lg">{!! $statusBadge !!}</td>
            </tr>
            <tr class="h-1 bg-white"></tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-6 flex justify-center">
            {{ $payments->links() }}
        </div>
    </div>
</div>

{{-- MODAL QUẢN LÝ THANH TOÁN --}}
<div id="managePaymentModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl flex flex-col overflow-hidden">
        <div class="flex justify-between items-center px-8 py-5 border-b">
            <h2 class="text-xl font-bold text-[#1976D2] font-montserrat uppercase">Chi tiết thanh toán</h2>
            <button type="button" class="close-modal text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-8 space-y-5">
            <input type="hidden" id="manage-payment_id">

            <div class="flex items-center">
                <label class="w-40 flex-shrink-0 text-gray-700 text-sm font-semibold">Tên khách hàng</label>
                <input type="text" id="manage-customer_name" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
            </div>

            <div class="flex items-center">
                <label class="w-40 flex-shrink-0 text-gray-700 text-sm font-semibold">Loại thanh toán</label>
                <input type="text" id="manage-payment_type" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
            </div>

            <div class="flex items-center">
                <label class="w-40 flex-shrink-0 text-gray-700 text-sm font-semibold">Tổng tiền</label>
                <input type="text" id="manage-amount" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
            </div>

            <div class="flex items-center">
                <label class="w-40 flex-shrink-0 text-gray-700 text-sm font-semibold">Phương thức</label>
                <input type="text" id="manage-method" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
            </div>

            <div class="flex items-center">
                <label class="w-40 flex-shrink-0 text-gray-700 text-sm font-semibold">Ngày thanh toán</label>
                <input type="text" id="manage-payment_date" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
            </div>

            <div class="flex items-center">
                <label class="w-40 flex-shrink-0 text-gray-700 text-sm font-semibold">Mã tham chiếu</label>
                <input type="text" id="manage-payment_code" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
            </div>

            <div class="flex items-center">
                <label class="w-40 flex-shrink-0 text-gray-700 text-sm font-semibold">Trạng thái</label>
                <select id="manage-status" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-800 outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="completed">Hoàn thành</option>
                    <option value="cancelled">Bị hủy</option>
                </select>
            </div>
        </div>

        <div class="flex justify-center items-center py-4 border-t bg-white space-x-4">
            <button type="button" class="close-modal px-6 py-2.5 bg-[#6c757d] hover:bg-[#5a6268] text-white font-semibold rounded-lg transition-colors">
                Hủy
            </button>
            <button type="button" onclick="submitManageForm()" class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg transition-colors shadow-md">
                Lưu thông tin
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Modal helpers
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.close-modal').forEach(b => b.addEventListener('click', () => {
            closeModal(b.closest('.modal-container').id);
        }));
        document.querySelectorAll('.modal-container').forEach(m => m.addEventListener('click', e => {
            if (e.target === m) closeModal(m.id);
        }));
    });

    // Mở modal + lấy dữ liệu
    function openManageModal(id) {
        fetch(`/admin/payments/${id}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('manage-payment_id').value = data.payment_id;
                document.getElementById('manage-customer_name').value = data.user_name;
                document.getElementById('manage-payment_type').value = data.payment_type;
                document.getElementById('manage-amount').value = new Intl.NumberFormat('vi-VN').format(data.amount);
                document.getElementById('manage-method').value = data.method;
                document.getElementById('manage-payment_date').value = data.payment_date || 'Chưa có';
                document.getElementById('manage-payment_code').value = data.payment_code;
                document.getElementById('manage-status').value = data.status;

                openModal('managePaymentModal');
            });
    }

    // Lưu trạng thái
    function submitManageForm() {
        const id = document.getElementById('manage-payment_id').value;
        const formData = new FormData();
        formData.append('status', document.getElementById('manage-status').value);
        formData.append('_method', 'PUT');

        fetch(`/admin/payments/${id}`, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    alert(res.message || 'Cập nhật thành công!');
                    closeModal('managePaymentModal');
                    location.reload();
                } else {
                    alert('Lỗi cập nhật');
                }
            })
            .catch(() => alert('Lỗi hệ thống'));
    }
</script>
@endpush
