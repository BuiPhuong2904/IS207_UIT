@extends('layouts.ad_layout')

@section('title', 'Quản lý thanh toán')

@section('content')

{{-- KHỐI TẠO DỮ LIỆU GIẢ (MOCK DATA) --}}
@php
    // Giả lập dữ liệu danh sách thanh toán khớp với cấu trúc bảng payment
    $payments = [
        (object)[
            'payment_id' => 'TT0001',
            'user_id' => '0001',
            'user_name' => 'SƠN TÙNG MTP',
            'user_avatar' => 'https://i.pravatar.cc/150?u=1',
            'payment_type' => 'Đơn hàng',
            'amount' => 1000000,
            'method' => 'Tiền mặt',
            'payment_date' => '2025-11-06',
            'status' => 'completed',
            'payment_code' => 'GT0001'
        ],
        (object)[
            'payment_id' => 'TT0002',
            'user_id' => '0002',
            'user_name' => 'Nguyễn Văn A',
            'user_avatar' => 'https://i.pravatar.cc/150?u=2',
            'payment_type' => 'Gói tập',
            'amount' => 1000000,
            'method' => 'Chuyển khoản',
            'payment_date' => '2025-11-07',
            'status' => 'completed',
            'payment_code' => 'GT0002'
        ],
        (object)[
            'payment_id' => 'TT0003',
            'user_id' => '0003',
            'user_name' => 'Lê Thị B',
            'user_avatar' => 'https://i.pravatar.cc/150?u=3',
            'payment_type' => 'Đơn hàng',
            'amount' => 500000,
            'method' => 'Chuyển khoản',
            'payment_date' => '2025-11-07',
            'status' => 'completed',
            'payment_code' => 'DH003'
        ],
        (object)[
            'payment_id' => 'TT0004',
            'user_id' => '0004',
            'user_name' => 'Trần Văn C',
            'user_avatar' => 'https://i.pravatar.cc/150?u=4',
            'payment_type' => 'Đơn hàng',
            'amount' => 2500000,
            'method' => 'Chuyển khoản',
            'payment_date' => '2025-11-07',
            'status' => 'completed', // Đã chuyển từ pending sang completed
            'payment_code' => 'DH004'
        ],
        (object)[
            'payment_id' => 'TT0005',
            'user_id' => '0005',
            'user_name' => 'Phạm Thị D',
            'user_avatar' => 'https://i.pravatar.cc/150?u=5',
            'payment_type' => 'Đơn hàng',
            'amount' => 1000000,
            'method' => 'Chuyển khoản',
            'payment_date' => '2025-11-07',
            'status' => 'cancelled', 
            'payment_code' => 'DH005'
        ],
    ];
@endphp

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">
    
    {{-- HEADER & BUTTONS --}}
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
                @foreach ($payments as $payment)
                    @php
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white'; 
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';
                        $formattedDate = \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y');
                        
                        $statusBadge = '';
                        switch($payment->status) {
                            case 'completed': 
                                $statusBadge = '<span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">Hoàn thành</span>';
                                break;
                            case 'refunded': 
                            case 'cancelled': 
                                // Nền 10% để nổi bật chữ 100% (#DC3545)
                                $statusBadge = '<span class="bg-[#DC3545]/10 text-[#DC3545] py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">Bị hủy</span>';
                                break;
                            // ĐÃ XÓA CASE PENDING
                        }
                    @endphp

                    <tr class="{{ $rowBg }} cursor-pointer transition-colors modal-trigger group"
                        id="row-{{ $payment->payment_id }}"
                        data-payment_id="{{ $payment->payment_id }}"
                        data-user_name="{{ $payment->user_name }}"
                        data-user_id="{{ $payment->user_id }}"
                        data-payment_type="{{ $payment->payment_type }}"
                        data-amount="{{ number_format($payment->amount, 0, ',', '.') }}"
                        data-method="{{ $payment->method }}"
                        data-payment_date="{{ $formattedDate }}"
                        data-payment_code="{{ $payment->payment_code }}"
                        data-status="{{ $payment->status }}" 
                    >
                        {{-- Code --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }} font-medium">
                            {{ $payment->payment_id }}
                        </td>

                        {{-- Mã khách hàng --}}
                        <td class="py-4 px-4 align-middle text-left pl-8">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full overflow-hidden mr-3 border border-gray-200">
                                    <img src="{{ $payment->user_avatar }}" class="h-full w-full object-cover">
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-800">{{ $payment->user_id }}</div>
                                    <div class="text-xs text-gray-500">{{ Str::limit($payment->user_name, 15) }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Loại --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $payment->payment_type }}
                        </td>

                        {{-- Tổng tiền --}}
                        <td class="py-4 px-4 truncate align-middle text-gray-800">
                            {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>

                        {{-- Phương thức --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $payment->method }}
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
                    
                    <tr class="h-2"></tr> 
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center items-center space-x-2">
            <button class="px-3 py-1 rounded bg-gray-200 text-gray-600 hover:bg-gray-300 disabled:opacity-50" disabled>&laquo;</button>
            <button class="px-3 py-1 rounded bg-blue-600 text-white font-bold">1</button>
            <button class="px-3 py-1 rounded hover:bg-gray-200 text-gray-700">2</button>
            <button class="px-3 py-1 rounded hover:bg-gray-200 text-gray-700">3</button>
            <button class="px-3 py-1 rounded bg-gray-200 text-gray-600 hover:bg-gray-300">&raquo;</button>
        </div>
    </div>
</div>

{{-- ----------------- MODAL 2: QUẢN LÝ THANH TOÁN (CHI TIẾT) ----------------- --}}
<div id="managePaymentModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl transform transition-all">
        
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat uppercase">
            QUẢN LÝ THANH TOÁN
        </h2>

        <form id="managePaymentForm">
            <h3 class="text-xl font-semibold text-blue-700 mb-6 font-montserrat">Thông tin thanh toán</h3>
            
            <div class="grid grid-cols-2 gap-x-12 gap-y-6">
                {{-- Cột Trái --}}
                <div class="space-y-4">
                    {{-- payment_code --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Code</label>
                        <input type="text" id="manage-payment_id" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 font-mono outline-none" readonly>
                    </div>

                    {{-- method (ĐÃ CHẶN SỬA) --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Phương thức</label>
                        <input type="text" id="manage-method" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
                    </div>

                    {{-- payment_type (ĐÃ CHẶN SỬA) --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Loại TT</label>
                        <input type="text" id="manage-payment_type" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
                    </div>

                    {{-- amount (ĐÃ CHẶN SỬA) --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Tổng tiền</label>
                        <input type="text" id="manage-amount" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 font-medium outline-none" readonly>
                    </div>
                </div>

                {{-- Cột Phải --}}
                <div class="space-y-4">
                    {{-- Khách hàng (User Name) --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Khách hàng</label>
                        <input type="text" id="manage-customer_name" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 font-medium uppercase outline-none" readonly>
                    </div>

                    {{-- payment_date (ĐÃ CHẶN SỬA) --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Ngày TT</label>
                        <input type="text" id="manage-payment_date" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
                    </div>

                    {{-- payment_code --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Mã tham chiếu</label>
                        <input type="text" id="manage-payment_code" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 outline-none" readonly>
                    </div>

                    {{-- status (CHO PHÉP SỬA) --}}
                    <div class="flex items-center">
                        <label class="w-32 flex-shrink-0 text-gray-700 text-sm font-semibold">Trạng thái</label>
                        <select id="manage-status" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-800 outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="completed">Hoàn thành</option>
                            {{-- ĐÃ XÓA PENDING --}}
                            <option value="cancelled">Bị hủy</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Buttons Footer (ĐÃ SỬA: CĂN GIỮA) --}}
            <div class="flex justify-center items-center mt-8 pt-4 border-t border-gray-100">
                <div class="flex space-x-3">
                    {{-- Nút Hủy --}}
                    <button type="button" class="close-modal px-6 py-2.5 bg-[#6c757d] hover:bg-[#5a6268] text-white font-semibold rounded-lg transition-colors focus:outline-none">
                        Hủy
                    </button>
                    {{-- Nút Lưu thông tin --}}
                    <button type="submit" class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg transition-colors focus:outline-none shadow-md">
                        Lưu thông tin
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
        // --- HELPERS ---
        function closeModal(m) { m.classList.add('hidden'); m.classList.remove('flex'); }
        function openModal(m) { m.classList.remove('hidden'); m.classList.add('flex'); }

        document.querySelectorAll('.close-modal').forEach(b => b.addEventListener('click', () => {
            closeModal(b.closest('.modal-container'));
        }));

        document.querySelectorAll('.modal-container').forEach(m => m.addEventListener('click', e => {
            if (e.target === m) closeModal(m);
        }));

        // --- OPEN MANAGE MODAL (Click vào dòng bảng) ---
        document.getElementById('payment-list-body').addEventListener('click', e => {
            const row = e.target.closest('tr.modal-trigger');
            if (!row) return;
            
            const d = row.dataset; 

            // Điền dữ liệu vào form modal
            document.getElementById('manage-payment_id').value = d.payment_id;
            document.getElementById('manage-customer_name').value = d.user_name;
            document.getElementById('manage-method').value = d.method;
            document.getElementById('manage-payment_date').value = d.payment_date; 
            document.getElementById('manage-payment_type').value = d.payment_type;
            document.getElementById('manage-payment_code').value = d.payment_code;
            document.getElementById('manage-amount').value = d.amount;
            
            // Set status select
            document.getElementById('manage-status').value = d.status;

            openModal(document.getElementById('managePaymentModal'));
        });

        // --- SUBMIT MANAGE FORM (Fake Action) ---
        document.getElementById('managePaymentForm').onsubmit = async (e) => {
            e.preventDefault();
            const newStatus = document.getElementById('manage-status').value;
            alert('Cập nhật thành công (Fake)! Trạng thái mới: ' + newStatus);
            closeModal(document.getElementById('managePaymentModal'));
        };
    });
</script>
@endpush