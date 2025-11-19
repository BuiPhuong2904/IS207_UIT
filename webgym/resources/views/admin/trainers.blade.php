@extends('layouts.ad_layout')

@section('title', 'Quản lý huấn luyện viên')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Header (Giữ nguyên) --}}
<div class="flex justify-end items-center mb-6">
    <div class="flex items-center space-x-3 text-sm text-gray-500 mr-4">
        <span class="font-medium">Hôm nay</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>
    <button id="openAddModalBtn"
            class="flex items-center px-4 py-2 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 transition-colors duration-150 shadow-md">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4"></path>
        </svg>
        Thêm
    </button>
</div>

{{-- Bảng danh sách HLV --}}
<div class="bg-white p-6 rounded-lg shadow-xl">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Huấn luyện viên</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border-separate border-spacing-y-2">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Mã HLV</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[20%]">Họ và tên</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[15%]">Email</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[15%]">Tiền lương</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Chuyên môn</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase flex-1">Lịch làm việc</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase w-[15%]">Trạng thái</th>
            </tr>
            </thead>
            <tbody id="trainer-list-body"> {{-- THÊM ID CHO TBODY --}}
            @php
            // ==========================================================
            // ============ DỮ LIỆU DUMMY ĐÃ ĐỔI TÊN BIẾN =================
            // ==========================================================

            // Dữ liệu cho các dropdown
            $schedules = [
            'Ca sáng: 06:00 - 14:00 (Thứ 2 - Thứ 7)',
            'Ca tối: 14:00 - 22:00 (Thứ 2 - Thứ 7)',
            'Full-time: 08:00 - 17:00 (Thứ 2 - Thứ 6)',
            'Part-time: Sáng Chủ nhật',
            ];
            $branches = [
            'CN1' => 'Chi nhánh 1 (Quận 1)',
            'CN2' => 'Chi nhánh 2 (Quận 3)',
            'CN3' => 'Chi nhánh 3 (Bình Thạnh)',
            ];
            $status_options = [
            'active' => 'Đang hoạt động',
            'inactive' => 'Nghỉ việc',
            ];

            // Dữ liệu giả cho HLV (đã cập nhật)
            $trainers_data = [
            (object)[
            'user_id' => 'HLV0001', // Đã đổi (từ id)
            'full_name' => 'Trần Thành',
            'email' => '123@gmail.com',
            'salary' => '10.000.000',
            'specialty' => 'YOGA',
            'schedule_display' => 'Ca sáng: 06:00 - 14:00 (Thứ 2 - Thứ 7)', // Biến hiển thị
            'status' => 'active',
            'birth_date' => '01/01/2000', // Đã đổi (từ dob)
            'gender' => 'Nam',
            'phone' => '0123456789',
            'address' => '123 Bình Nguyên Võ Tấn',
            'password' => 'AaaBbCcc',
            'experience_years' => 3,
            'work_schedule' => 'Ca sáng: 06:00 - 14:00 (Thứ 2 - Thứ 7)', // Đã đổi (từ schedule_data)
            'branch_id' => 'CN1', // Đã đổi (từ branch_data)
            'image_url' => 'https://via.placeholder.com/40' // Đã đổi (từ avatar)
            ],
            (object)[
            'user_id' => 'HLV0002',
            'full_name' => 'Sơn Tùng MTP',
            'email' => '123@gmail.com',
            'salary' => '10.000.000',
            'specialty' => 'GYM',
            'schedule_display' => 'Ca tối: 14:00 - 22:00 (Thứ 2 - Thứ 7)',
            'status' => 'active',
            'birth_date' => '01/01/1994',
            'gender' => 'Nam',
            'phone' => '0987654321',
            'address' => '456 Bùi Thị Xuân',
            'password' => 'pass123',
            'experience_years' => 5,
            'work_schedule' => 'Ca tối: 14:00 - 22:00 (Thứ 2 - Thứ 7)',
            'branch_id' => 'CN1,CN2',
            'image_url' => 'https://via.placeholder.com/40'
            ],
            (object)[
            'user_id' => 'HLV0004',
            'full_name' => 'Anh Tú',
            'email' => '123@gmail.com',
            'salary' => '10.000.000',
            'specialty' => 'GYM',
            'schedule_display' => 'Ca sáng, Ca tối',
            'status' => 'active',
            'birth_date' => '03/03/1993',
            'gender' => 'Nam',
            'phone' => '0556677889',
            'address' => '321 Nguyễn Huệ',
            'password' => 'anhtu123',
            'experience_years' => 4,
            'work_schedule' => 'Ca sáng: 06:00 - 14:00 (Thứ 2 - Thứ 7)|Ca tối: 14:00 - 22:00 (Thứ 2 - Thứ 7)',
            'branch_id' => 'CN1',
            'image_url' => 'https://via.placeholder.com/40'
            ],
            (object)[
            'user_id' => 'HLV0005',
            'full_name' => 'Liên Bỉnh Phát',
            'email' => '123@gmail.com',
            'salary' => '10.000.000',
            'specialty' => 'YOGA',
            'schedule_display' => 'Part-time: Sáng Chủ nhật',
            'status' => 'inactive',
            'birth_date' => '04/04/1990',
            'gender' => 'Nam',
            'phone' => '0121212121',
            'address' => '111 Pasteur',
            'password' => 'phat123',
            'experience_years' => 6,
            'work_schedule' => 'Part-time: Sáng Chủ nhật',
            'branch_id' => 'CN2',
            'image_url' => 'https://via.placeholder.com/40'
            ],
            ];
            @endphp

            @foreach ($trainers_data as $trainer)
            {{-- SỬA 1: Đổi data-work_schedule thành data-schedule_display --}}
            <tr class="transition duration-150 modal-trigger trainer-row"
                data-user_id="{{ $trainer->user_id }}"
                data-full_name="{{ $trainer->full_name }}"
                data-email="{{ $trainer->email }}"
                data-salary="{{ $trainer->salary }}"
                data-specialty="{{ $trainer->specialty }}"
                data-work_schedule="{{ $trainer->work_schedule }}"
                data-schedule_display="{{ $trainer->schedule_display }}"
                data-status="{{ $trainer->status }}"
                data-birth_date="{{ $trainer->birth_date }}"
                data-gender="{{ $trainer->gender }}"
                data-phone="{{ $trainer->phone }}"
                data-address="{{ $trainer->address }}"
                data-password="{{ $trainer->password }}"
                data-experience_years="{{ $trainer->experience_years }}"
                data-branch_id="{{ $trainer->branch_id }}"
                data-image_url="{{ $trainer->image_url }}"
            >
                <td colspan="7" class="p-0">
                    <div class="flex w-full rounded-lg items-center
                                {{ $loop->even ? 'bg-white' : 'bg-[#1976D2]/10' }}
                                shadow-sm overflow-hidden">

                        <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900">
                            <div class="flex items-center">
                                <img class="w-8 h-8 rounded-full mr-2 object-cover" src="{{ $trainer->image_url }}" alt="{{ $trainer->full_name }}">
                                <span class="trainer-id-display">{{ $trainer->user_id }}</span>
                            </div>
                        </div>
                        <div class="px-4 py-3 w-[20%] text-sm text-gray-700 trainer-name-display">
                            <span>{{ $trainer->full_name }}</span>
                        </div>
                        <div class="px-4 py-3 w-[15%] text-sm text-gray-700 trainer-email-display">
                            {{ $trainer->email }}
                        </div>
                        <div class="px-4 py-3 w-[15%] text-sm text-gray-700 trainer-salary-display">
                            {{ $trainer->salary }} VND
                        </div>
                        <div class="px-4 py-3 w-[10%] text-sm text-gray-700 trainer-specialty-display">
                            {{ $trainer->specialty }}
                        </div>
                        <div class="px-4 py-3 flex-1 text-sm text-gray-700 trainer-schedule-display">
                            {{ $trainer->schedule_display }}
                        </div>
                        <div class="px-4 py-3 w-[15%] text-sm text-right">
                            @if ($trainer->status == 'active')
                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800 trainer-status-badge" data-status-id="active">
                                        Đang hoạt động
                                    </span>
                            @else
                            <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-gray-200 text-gray-800 trainer-status-badge" data-status-id="inactive">
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
    </div>
</div>

{{-- ================================================================= --}}
{{-- =================== HTML CHO CÁC MODAL ============ --}}
{{-- ================================================================= --}}

{{-- ----------------- MODAL 1: THÊM HLV (Layout Mới) ----------------- --}}
<div id="addTrainerModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">

        <h2 class="text-3xl font-bold text-center mb-6
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
            bg-clip-text text-transparent">
            THÊM HUẤN LUYỆN VIÊN
        </h2>

        <form id="addTrainerForm"> {{-- THÊM ID CHO FORM --}}
            {{-- Phần Thông tin cá nhân --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin cá nhân</h3>
            <div class="flex space-x-6 mb-6">
                {{-- Cột ảnh (Trái) --}}
                <div class="w-40 flex-shrink-0 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="add-image_url_preview" src="https://via.placeholder.com/160x160.png?text=Image" alt="Avatar" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" class="w-full flex items-center justify-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Upload ảnh
                    </button>
                    <input type="file" id="add-image_url" class="hidden">
                </div>

                {{-- Cột thông tin (Phải) --}}
                <div class="flex-1 flex flex-col space-y-4">

                    {{-- Hàng Họ và tên (Label w-24) --}}
                    <div class="flex items-center">
                        <label for="add-full_name" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Họ và tên</label>
                        <input type="text" id="add-full_name" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    {{-- Hàng Ngày sinh + Giới tính --}}
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label for="add-birth_date" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Ngày sinh</label>
                            <input type="text" id="add-birth_date" placeholder="01/01/2000" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        {{-- SỬA: Thay thế label w-16 cho Giới tính để căn thẳng cột với SĐT bên dưới --}}
                        <div class="flex items-center flex-1">
                            <label class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">Giới tính</label>
                            <div class="flex items-center space-x-4 flex-1">
                                <label class="flex items-center">
                                    <input type="radio" name="add-gender" value="Nam" class="form-radio text-blue-600 focus:ring-1 focus:ring-black" checked>
                                    <span class="ml-2 text-sm text-gray-700">Nam</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="add-gender" value="Nữ" class="form-radio text-pink-600 focus:ring-1 focus:ring-black">
                                    <span class="ml-2 text-sm text-gray-700">Nữ</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Hàng Mật khẩu + SĐT (SỬA: Kích thước input bằng nhau, nhãn căn chỉnh) --}}
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label for="add-password" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Mật khẩu</label>
                            <input type="password" id="add-password" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div class="flex items-center flex-1">
                            <label for="add-phone" class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">SĐT</label>
                            <input type="text" id="add-phone" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    {{-- Hàng Email --}}
                    <div class="flex items-center">
                        <label for="add-email" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="add-email" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    {{-- Hàng Địa chỉ --}}
                    <div class="flex items-center">
                        <label for="add-address" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Địa chỉ</label>
                        <input type="text" id="add-address" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                </div>
            </div>

            {{-- Phần Công việc --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Công việc</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div class="flex items-center">
                    <label for="add-specialty" class="text-sm font-medium text-gray-700 mr-3 flex-shrink-0">Chuyên môn</label>
                    <input type="text" id="add-specialty" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div class="flex items-center">
                    <label for="add-experience_years" class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Số năm kinh nghiệm</label>
                    <input type="number" id="add-experience_years" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div class="flex items-center">
                    <label for="add-salary" class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Lương (VNĐ)</label>
                    <input type="text" id="add-salary" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
            </div>

            {{-- Các hàng 1 cột --}}
            <div class="flex flex-col space-y-4">

                {{-- Lịch làm việc (Input) --}}
                <div class="flex items-center">
                    <label for="add-work_schedule" class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Lịch làm việc</label>
                    <input type="text" id="add-work_schedule" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>

                {{-- Chi nhánh làm việc (Multiselect) --}}
                <div class="flex items-center">
                    <label for="add-branch_id" class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Chi nhánh làm việc</label>
                    <div class="relative custom-multiselect flex-1" data-select-id="add-branch_id">
                        <select id="add-branch_id" name="add_branch_id[]" multiple class="hidden">
                            @foreach($branches as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                            <span class="custom-multiselect-display text-gray-500">Chọn chi nhánh...</span>
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <div class="p-2 relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </span>
                                <input type="text" class="custom-multiselect-search w-full pl-11 pr-4 py-2 bg-gray-100 border-0 rounded-2xl focus:outline-none focus:ring-1 focus:ring-black" placeholder="Tìm kiếm ...">
                            </div>
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                @foreach($branches as $value => $label)
                                <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $value }}">
                                    <div class="flex items-center space-x-3 w-full pointer-events-none">
                                        <span class="text-sm font-medium text-gray-900 w-[80px]">{{ $value }}</span>
                                        <span class="text-sm text-gray-600 flex-1">{{ $label }}</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nút bấm --}}
            <div class="flex justify-center space-x-4 mt-8">
                <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                    Hủy
                </button>
                <button id="addTrainerBtn" type="submit" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Thêm thông tin
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ----------------- MODAL 2: QUẢN LÝ HLV (Layout Mới) ----------------- --}}
<div id="manageTrainerModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">

        <h2 class="text-3xl font-bold text-center mb-6
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
            bg-clip-text text-transparent">
            QUẢN LÝ HUẤN LUYỆN VIÊN
        </h2>

        <form>
            {{-- Phần Thông tin cá nhân --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin cá nhân</h3>
            <div class="flex space-x-6 mb-6">
                {{-- Cột ảnh (Trái) --}}
                <div class="w-40 flex-shrink-0 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="manage-image_url_preview" src="https://via.placeholder.com/160x160.png?text=Image" alt="Avatar" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" class="w-full flex items-center justify-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Upload ảnh
                    </button>
                    <input type="file" id="manage-image_url" class="hidden">
                </div>

                {{-- Cột thông tin (Phải - ĐÃ CHỈNH SỬA) --}}
                <div class="flex-1 flex flex-col space-y-4">

                    {{-- Hàng ID + Họ và tên (SỬA: Kích thước input bằng nhau, nhãn căn chỉnh) --}}
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label for="manage-user_id" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">ID</label>
                            <input type="text" id="manage-user_id" class="flex-1 border border-gray-300 rounded-2xl shadow-sm bg-gray-100 px-4 py-2.5" readonly>
                        </div>
                        <div class="flex items-center flex-1">
                            <label for="manage-full_name" class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">Họ và tên</label>
                            <input type="text" id="manage-full_name" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    {{-- Hàng Ngày sinh + Giới tính (SỬA: Kích thước input bằng nhau, nhãn căn chỉnh) --}}
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label for="manage-birth_date" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Ngày sinh</label>
                            <input type="text" id="manage-birth_date" placeholder="01/01/2000" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div class="flex items-center flex-1">
                            <label class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">Giới tính</label>
                            <div class="flex items-center space-x-4 flex-1">
                                <label class="flex items-center">
                                    <input type="radio" name="manage-gender" value="Nam" class="form-radio text-blue-600 focus:ring-1 focus:ring-black">
                                    <span class="ml-2 text-sm text-gray-700">Nam</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="manage-gender" value="Nữ" class="form-radio text-pink-600 focus:ring-1 focus:ring-black">
                                    <span class="ml-2 text-sm text-gray-700">Nữ</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Hàng Mật khẩu + SĐT (SỬA: Kích thước input bằng nhau, nhãn căn chỉnh) --}}
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label for="manage-password" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Mật khẩu</label>
                            <input type="password" id="manage-password" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div class="flex items-center flex-1">
                            <label for="manage-phone" class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">SĐT</label>
                            <input type="text" id="manage-phone" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    {{-- Hàng Email --}}
                    <div class="flex items-center">
                        <label for="manage-email" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="manage-email" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    {{-- Hàng Địa chỉ --}}
                    <div class="flex items-center">
                        <label for="manage-address" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Địa chỉ</label>
                        <input type="text" id="manage-address" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                </div>
            </div>

            {{-- Phần Công việc (Giữ nguyên) --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Công việc</h3>

            {{-- SỬA 4: Sửa layout 3 cột --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div class="flex items-center">
                    <label for="manage-specialty" class="text-sm font-medium text-gray-700 mr-3 flex-shrink-0">Chuyên môn</label>
                    <input type="text" id="manage-specialty" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div class="flex items-center">
                    <label for="manage-experience_years" class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Số năm kinh nghiệm</label>
                    <input type="number" id="manage-experience_years" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div class="flex items-center">
                    <label for="manage-salary" class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Lương (VNĐ)</label>
                    <input type="text" id="manage-salary" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
            </div>

            {{-- Các hàng 1 cột (Giữ nguyên) --}}
            <div class="flex flex-col space-y-4">

                {{-- SỬA 5: Lịch làm việc (Input) --}}
                <div class="flex items-center">
                    <label for="manage-work_schedule" class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Lịch làm việc</label>
                    <input type="text" id="manage-work_schedule" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>

                <div class="flex items-center">
                    <label for="manage-branch_id" class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Chi nhánh làm việc</label>
                    <div class="relative custom-multiselect flex-1" data-select-id="manage-branch_id">
                        <select id="manage-branch_id" name="manage_branch_id[]" multiple class="hidden">
                            @foreach($branches as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                            <span class="custom-multiselect-display text-gray-500">Chọn chi nhánh...</span>
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <div class="p-2 relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                    </svg>
                                </span>
                                <input type="text" class="custom-multiselect-search w-full pl-11 pr-4 py-2 bg-gray-100 border-0 rounded-2xl focus:outline-none focus:ring-1 focus:ring-black" placeholder="Tìm kiếm ...">
                            </div>
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                @foreach($branches as $value => $label)
                                <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $value }}">
                                    <div class="flex items-center space-x-3 w-full pointer-events-none">
                                        <span class="text-sm font-medium text-gray-900 w-[80px]">{{ $value }}</span>
                                        <span class="text-sm text-gray-600 flex-1">{{ $label }}</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <label for="manage-status" class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Trạng thái</label>
                    <div class="relative custom-multiselect flex-1" data-select-id="manage-status" data-type="single">
                        <select id="manage-status" name="manage_status" class="hidden">
                            @foreach($status_options as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                            <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                @foreach($status_options as $value => $label)
                                <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $value }}">
                                    <div class="flex items-center space-x-3 w-full pointer-events-none">
                                        <span class="text-sm font-medium text-gray-900">{{ $label }}</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Nút bấm --}}
            <div class="flex justify-center space-x-4 mt-8">
                <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                    Hủy
                </button>
                <button type="submit" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Lưu thông tin
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

{{-- ================================================================= --}}
{{-- =================== JAVASCRIPT (ĐÃ SỬA VÀ THÊM LOGIC) ============ --}}
{{-- ================================================================= --}}

@push('scripts')
<script>
    // --- DỮ LIỆU MOCK TỪ PHP ---
    const MOCK_TRAINERS = @json($trainers_data);
    const MOCK_STATUS_OPTIONS = @json($status_options);
    const MOCK_BRANCHES = @json($branches);

    // --- CƠ CHẾ QUẢN LÝ DỮ LIỆU ẢO ---
    let trainerMap = new Map();
    MOCK_TRAINERS.forEach(t => trainerMap.set(t.user_id, t));
    let trainerIdCounter = 5; // HLV0005 là ID lớn nhất hiện tại

    // Hàm tạo ID HLV mới (ví dụ: HLV0006)
    function generateNewTrainerId() {
        trainerIdCounter++;
        return 'HLV' + String(trainerIdCounter).padStart(4, '0');
    }

    // Hàm render một dòng HLV mới vào bảng chính
    function renderTrainerRow(trainerData, isEven) {
        const statusText = MOCK_STATUS_OPTIONS[trainerData.status] || trainerData.status;
        const isActive = trainerData.status === 'active';

        const newRow = document.createElement('tr');
        newRow.classList.add('transition', 'duration-150', 'modal-trigger', 'trainer-row');

        // Gán tất cả các data-* attributes
        for (const key in trainerData) {
            if (Object.prototype.hasOwnProperty.call(trainerData, key)) {
                let value = trainerData[key];
                if (key === 'work_schedule') {
                    // Gán giá trị thực cho work_schedule
                    newRow.dataset.work_schedule = value;
                    // Gán giá trị hiển thị cho schedule_display (nếu cần hiển thị rút gọn)
                    newRow.dataset.schedule_display = trainerData.schedule_display || value;
                } else if (key === 'schedule_display') {
                    // Bỏ qua vì đã xử lý ở trên
                } else {
                    newRow.dataset[key] = value;
                }
            }
        }

        // Cấu trúc HTML của dòng
        newRow.innerHTML = `
        <td colspan="7" class="p-0">
            <div class="flex w-full rounded-lg items-center
                    ${isEven ? 'bg-white' : 'bg-[#1976D2]/10'}
                    shadow-sm overflow-hidden">

                <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900">
                    <div class="flex items-center">
                        <img class="w-8 h-8 rounded-full mr-2 object-cover" src="${trainerData.image_url}" alt="${trainerData.full_name}">
                        <span class="trainer-id-display">${trainerData.user_id}</span>
                    </div>
                </div>
                <div class="px-4 py-3 w-[20%] text-sm text-gray-700 trainer-name-display">
                    <span>${trainerData.full_name}</span>
                </div>
                <div class="px-4 py-3 w-[15%] text-sm text-gray-700 trainer-email-display">
                    ${trainerData.email}
                </div>
                <div class="px-4 py-3 w-[15%] text-sm text-gray-700 trainer-salary-display">
                    ${trainerData.salary} VND
                </div>
                <div class="px-4 py-3 w-[10%] text-sm text-gray-700 trainer-specialty-display">
                    ${trainerData.specialty}
                </div>
                <div class="px-4 py-3 flex-1 text-sm text-gray-700 trainer-schedule-display">
                    ${trainerData.schedule_display || trainerData.work_schedule}
                </div>
                <div class="px-4 py-3 w-[15%] text-sm text-right">
                    <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full
                        ${isActive ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800'} trainer-status-badge" data-status-id="${trainerData.status}">
                        ${statusText}
                    </span>
                </div>
            </div>
        </td>
    `;

        // Gán sự kiện click cho dòng mới (để mở modal quản lý)
        newRow.addEventListener('click', handleTrainerRowClick);

        return newRow;
    }


    // --- CUSTOM MULTISELECT SCRIPT (Giữ nguyên) ---

    /**
     * Cập nhật văn bản hiển thị
     */
    function updateMultiselectDisplay(multiselectContainer) {
        const hiddenSelect = multiselectContainer.querySelector('select');
        const displaySpan = multiselectContainer.querySelector('.custom-multiselect-display');
        const selectedOptions = Array.from(hiddenSelect.selectedOptions);

        if (selectedOptions.length === 0 || (selectedOptions.length === 1 && selectedOptions[0].value === "")) {
            const placeholder = displaySpan.dataset.placeholder || 'Chọn...';
            displaySpan.textContent = placeholder;
            displaySpan.classList.add('text-gray-500');
        } else {
            // Hiển thị text (ví dụ: "Chi nhánh 1 (Quận 1)")
            displaySpan.textContent = selectedOptions.map(opt => opt.text).join(', ');
            displaySpan.classList.remove('text-gray-500');
        }
    }

    /**
     * Đặt (set) giá trị cho custom multiselect
     */
    function setCustomMultiselectValues(multiselectContainer, valuesString, delimiter = ',') {
        if (!multiselectContainer) return;

        const hiddenSelect = multiselectContainer.querySelector('select');
        const optionsList = multiselectContainer.querySelector('.custom-multiselect-list');
        const selectedValues = valuesString ? String(valuesString).split(delimiter).map(v => v.trim()) : [];

        // 1. Reset tất cả các lựa chọn cũ
        Array.from(hiddenSelect.options).forEach(option => option.selected = false);
        if (optionsList) {
            optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
                li.classList.remove('bg-blue-100');
            });
        }

        // 2. Đặt các giá trị mới (so khớp bằng VALUE)
        selectedValues.forEach(value => {
            const trimmedValue = value.trim();

            const option = hiddenSelect.querySelector(`option[value="${trimmedValue}"]`);
            if (option) {
                option.selected = true;
            }

            if (optionsList) {
                const li = optionsList.querySelector(`.custom-multiselect-option[data-value="${trimmedValue}"]`);
                if (li) {
                    li.classList.add('bg-blue-100');
                }
            }
        });

        // 3. Cập nhật lại text hiển thị
        updateMultiselectDisplay(multiselectContainer);
    }

    /**
     * Khởi tạo tất cả các component '.custom-multiselect'
     */
    function initializeCustomMultiselects() {
        document.querySelectorAll('.custom-multiselect').forEach(container => {
            const trigger = container.querySelector('.custom-multiselect-trigger');
            const panel = container.querySelector('.custom-multiselect-panel');
            const searchInput = container.querySelector('.custom-multiselect-search');
            const optionsList = container.querySelector('.custom-multiselect-list');
            const hiddenSelect = container.querySelector('select');
            const displaySpan = container.querySelector('.custom-multiselect-display');

            if (displaySpan && !displaySpan.dataset.placeholder) {
                displaySpan.dataset.placeholder = displaySpan.textContent;
            }

            // 1. Mở/đóng dropdown
            if (trigger) {
                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    document.querySelectorAll('.custom-multiselect-panel').forEach(p => {
                        if (p !== panel) p.classList.add('hidden');
                    });
                    if (panel) panel.classList.toggle('hidden');
                });
            }

            // 2. Xử lý khi chọn một mục
            if (optionsList) {
                optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
                    li.addEventListener('click', (e) => {
                        e.stopPropagation();

                        const value = li.dataset.value;
                        const option = hiddenSelect.querySelector(`option[value="${value}"]`);

                        if (container.dataset.type === 'single') {
                            // === LOGIC CHO SINGLE-SELECT ===
                            hiddenSelect.value = value;
                            optionsList.querySelectorAll('.custom-multiselect-option').forEach(otherLi => {
                                otherLi.classList.remove('bg-blue-100');
                            });
                            li.classList.add('bg-blue-100');
                            if (panel) panel.classList.add('hidden');
                        } else {
                            // === LOGIC CHO MULTI-SELECT ===
                            if(option) {
                                option.selected = !option.selected;
                                li.classList.toggle('bg-blue-100', option.selected);
                            }
                        }

                        updateMultiselectDisplay(container);
                    });
                });
            }

            // 3. Xử lý tìm kiếm (Nếu có searchInput)
            if (searchInput) {
                searchInput.addEventListener('keyup', () => {
                    const filter = searchInput.value.toLowerCase();
                    if (optionsList) {
                        optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
                            const key = li.dataset.value.toLowerCase();
                            const label = li.textContent.toLowerCase();
                            if (key.includes(filter) || label.includes(filter)) {
                                li.style.display = '';
                            } else {
                                li.style.display = 'none';
                            }
                        });
                    }
                });
            }

            // Cập nhật hiển thị ban đầu
            updateMultiselectDisplay(container);
        });
    }

    // Đóng tất cả dropdown khi click ra ngoài
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.custom-multiselect')) {
            document.querySelectorAll('.custom-multiselect-panel').forEach(panel => {
                panel.classList.add('hidden');
            });
        }
    });


    // --- SCRIPT QUẢN LÝ MODAL VÀ DỮ LIỆU ---
    document.addEventListener('DOMContentLoaded', function() {

        initializeCustomMultiselects();
        const addModal = document.getElementById('addTrainerModal');
        const manageModal = document.getElementById('manageTrainerModal');
        const addForm = document.getElementById('addTrainerForm');
        const trainerListBody = document.getElementById('trainer-list-body');
        const openAddBtn = document.getElementById('openAddModalBtn');
        const rowTriggers = document.querySelectorAll('.trainer-row');
        const closeTriggers = document.querySelectorAll('.close-modal');
        const modalContainers = document.querySelectorAll('.modal-container');

        function openModal(modal) {
            if (modal) {
                modal.classList.remove('hidden');
            }
        }

        function closeModal(modal) {
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Hàm xử lý khi nhấn vào dòng (mở modal quản lý)
        window.handleTrainerRowClick = function() {
            const row = this;
            const data = row.dataset;

            // Điền dữ liệu text
            document.getElementById('manage-user_id').value = data.userId;
            document.getElementById('manage-full_name').value = data.fullName;
            document.getElementById('manage-birth_date').value = data.birthDate;
            document.getElementById('manage-password').value = data.password;
            document.getElementById('manage-phone').value = data.phone;
            document.getElementById('manage-email').value = data.email;
            document.getElementById('manage-address').value = data.address;
            document.getElementById('manage-specialty').value = data.specialty;
            document.getElementById('manage-experience_years').value = data.experienceYears;
            document.getElementById('manage-salary').value = data.salary;
            document.getElementById('manage-image_url_preview').src = data.imageUrl;

            // Set radio
            const genderRadio = document.querySelector(`input[name="manage-gender"][value="${data.gender}"]`);
            if (genderRadio) {
                genderRadio.checked = true;
            }

            // Set value cho input Lịch làm việc
            document.getElementById('manage-work_schedule').value = data.workSchedule;

            // Set multi-select cho Chi nhánh (dùng , )
            const branchContainer = document.querySelector('.custom-multiselect[data-select-id="manage-branch_id"]');
            setCustomMultiselectValues(branchContainer, data.branchId, ',');

            // Set single-select cho Trạng thái (dùng , )
            const statusContainer = document.querySelector('.custom-multiselect[data-select-id="manage-status"]');
            setCustomMultiselectValues(statusContainer, data.status, ',');

            openModal(manageModal);
        };

        // 1. Mở modal "Thêm HLV" và reset form
        if (openAddBtn) {
            openAddBtn.addEventListener('click', function() {
                addForm.reset();
                document.querySelector('input[name="add-gender"][value="Nam"]').checked = true; // Set Nam mặc định
                document.getElementById('add-image_url_preview').src = 'https://via.placeholder.com/160x160.png?text=Image'; // Reset ảnh
                setCustomMultiselectValues(document.querySelector('.custom-multiselect[data-select-id="add-branch_id"]'), '');
                openModal(addModal);
            });
        }

        // 2. Mở modal "Quản lý HLV" khi nhấn vào dòng (khởi tạo ban đầu)
        rowTriggers.forEach(row => {
            row.addEventListener('click', handleTrainerRowClick);
        });

        addForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const branchSelect = document.getElementById('add-branch_id');
            const selectedBranches = Array.from(branchSelect.selectedOptions).map(opt => opt.value);

            const newTrainer = {
                user_id: '3', // Nếu user đã tồn tại, chỗ này đang để cố định do chưa có api thêm user
                specialty: document.getElementById('add-specialty').value,
                experience_years: document.getElementById('add-experience_years').value,
                salary: document.getElementById('add-salary').value,
                work_schedule: document.getElementById('add-work_schedule').value,
                branch_id: '2', // Cũng cố định do chưa có crud branch
                status: 'active',
            };

            // Validation đơn giản
            if (!newTrainer.user_id || !newTrainer.specialty) {
                alert('Vui lòng điền đầy đủ thông tin.');
                return;
            }

            try {
                const response = await fetch('/admin/trainers', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(newTrainer)
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new alert(result.message || "Lỗi server");
                }

                // Render lên bảng sau khi tạo thành công
                const isEven = (trainerListBody.children.length % 2 !== 0);
                const newRow = renderTrainerRow(result.data, isEven);
                trainerListBody.prepend(newRow);

                closeModal(addModal);
                addForm.reset();

                alert(`Thêm huấn luyện viên thành công: ${result.data.user_id}`);

            } catch (error) {
                console.error("Lỗi:", error);
                alert("Không thể thêm HLV: " + error.message);
            }
        });

        // 4. Đóng modal (Hủy, nền mờ, Escape)
        closeTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const modal = this.closest('.modal-container');
                closeModal(modal);
            });
        });
        modalContainers.forEach(container => {
            container.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this);
                }
            });
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal(addModal);
                closeModal(manageModal);
            }
        });
    });


</script>
@endpush
