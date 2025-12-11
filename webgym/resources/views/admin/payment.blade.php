@extends('layouts.ad_layout')

@section('title', 'Quản lý thanh toán')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Quản lý thanh toán</h1>
        <div class="flex items-center space-x-4 font-open-sans">
            {{-- Dropdown lọc --}}
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900">
                <span class="mr-1 text-sm font-medium">Hôm nay</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </div>

    {{-- TABLE CONTENT --}}
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

            <tbody id="payment-list-body" class="text-sm text-gray-700 text-center">
                @foreach ($payments as $item)
                    @php
                        // Logic màu nền
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';
                        
                        // Format ngày
                        $formattedDate = $item->payment_date 
                            ? \Carbon\Carbon::parse($item->payment_date)->format('d/m/Y') 
                            : 'Chưa có';

                        // Xử lý Status Badge
                        $statusBadge = '';
                        switch($item->status) {
                            case 'completed': 
                                $statusBadge = '<span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">Hoàn thành</span>';
                                break;
                            case 'refunded': 
                            case 'cancelled': 
                                $statusBadge = '<span class="bg-[#DC3545]/10 text-[#DC3545] py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">Bị hủy</span>';
                                break;
                            default:
                                $statusBadge = '<span class="bg-gray-200 text-gray-600 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">'.$item->status.'</span>';
                        }
                        
                        $userName = $item->user?->name ?? 'Khách vãng lai';
                    @endphp

                    {{-- Sự kiện click mở modal --}}
                    <tr class="{{ $rowBg }} cursor-pointer transition-colors modal-trigger group"
                        onclick="openManageModal({{ $item->payment_id }})">
                        
                        {{-- Code --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }} font-medium">
                            {{ $item->payment_code }}
                        </td>

                        {{-- Mã khách hàng --}}
                        <td class="py-4 px-4 align-middle text-left pl-8">
                            <div class="flex flex-col justify-center">
                                <div class="font-semibold text-gray-800">{{ $item->user_id ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($userName, 20) }}</div>
                            </div>
                        </td>

                        {{-- Loại --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ ucfirst(str_replace('_', ' ', $item->payment_type)) }}
                        </td>

                        {{-- Tổng tiền --}}
                        <td class="py-4 px-4 truncate align-middle text-gray-800 font-medium">
                            {{ number_format($item->amount, 0, ',', '.') }}
                        </td>

                        {{-- Phương thức --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $item->method }}
                        </td>

                        {{-- Ngày thanh toán --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $formattedDate }}
                        </td>

                        {{-- Trạng thái --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            {!! $statusBadge !!}
                        </td>
                    </tr>
                    
                    {{-- Spacer row --}}
                    <tr class="h-2"></tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
            {{ $payments->links() }}
        </div>
    </div>
</div>

{{-- MODAL QUẢN LÝ THANH TOÁN --}}
<div id="managePaymentModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl transform transition-all flex flex-col max-h-[90vh] overflow-y-auto">
        
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat uppercase">
            QUẢN LÝ THANH TOÁN
        </h2>

        <div id="managePaymentFormContainer">
            <input type="hidden" id="manage-payment_id">
            
            <h3 class="text-xl font-semibold text-blue-700 mb-6 font-montserrat">Thông tin thanh toán</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                {{-- Cột Trái --}}
                <div class="space-y-4">
                    {{-- Code (Mã thanh toán) --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Code</label>
                        <input type="text" id="manage-payment_code_display" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 font-mono outline-none" readonly>
                    </div>

                    {{-- Phương thức --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Phương thức</label>
                        <input type="text" id="manage-method" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
                    </div>

                    {{-- Loại TT --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Loại TT</label>
                        <input type="text" id="manage-payment_type" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
                    </div>

                    {{-- Tổng tiền --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Tổng tiền</label>
                        <input type="text" id="manage-amount" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 font-medium outline-none" readonly>
                    </div>
                </div>

                {{-- Cột Phải --}}
                <div class="space-y-4">
                    {{-- Khách hàng --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Khách hàng</label>
                        <input type="text" id="manage-customer_name" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 font-medium uppercase outline-none" readonly>
                    </div>

                    {{-- Ngày TT --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Ngày TT</label>
                        <input type="text" id="manage-payment_date" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
                    </div>

                    {{-- Mã tham chiếu --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Mã tham chiếu</label>
                        <input type="text" id="manage-payment_code" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
                    </div>

                    {{-- Trạng thái --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Trạng thái</label>
                        <select id="manage-status" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-800 outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="completed">Hoàn thành</option>
                            <option value="cancelled">Bị hủy</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Buttons Footer --}}
            <div class="flex justify-center items-center mt-8 pt-4 border-t border-gray-100">
                <div class="flex space-x-3">
                    <button type="button" class="close-modal px-6 py-2.5 bg-[#6c757d] hover:bg-[#5a6268] text-white font-semibold rounded-lg transition-colors focus:outline-none shadow-sm">
                        Hủy
                    </button>
                    <button type="button" onclick="submitManageForm()" class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg transition-colors focus:outline-none shadow-md">
                        Lưu thông tin
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Modal helpers
    function openModal(id) {
        const m = document.getElementById(id);
        m.classList.remove('hidden');
        m.classList.add('flex');
    }
    
    function closeModal(id) {
        const m = document.getElementById(id);
        m.classList.add('hidden');
        m.classList.remove('flex');
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.close-modal').forEach(b => b.addEventListener('click', () => {
            closeModal(b.closest('.modal-container').id);
        }));
        document.querySelectorAll('.modal-container').forEach(m => m.addEventListener('click', e => {
            if (e.target === m) closeModal(m.id);
        }));
    });

    // --- FETCH DATA TỪ SERVER ---
    function openManageModal(id) {
        fetch(`/admin/payments/${id}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('manage-payment_id').value = data.payment_id;
                
                // Hiển thị ID ở trường Code cho khớp logic
                document.getElementById('manage-payment_code_display').value = data.payment_id; 
                document.getElementById('manage-payment_code').value = data.payment_code; 

                document.getElementById('manage-customer_name').value = data.user_name;
                document.getElementById('manage-payment_type').value = data.payment_type;
                document.getElementById('manage-amount').value = new Intl.NumberFormat('vi-VN').format(data.amount);
                document.getElementById('manage-method').value = data.method;
                
                document.getElementById('manage-payment_date').value = data.payment_date 
                    ? data.payment_date.split(' ')[0].split('-').reverse().join('/') 
                    : 'Chưa có';
                
                document.getElementById('manage-status').value = data.status;

                openModal('managePaymentModal');
            });
    }

    // --- SUBMIT FORM ---
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