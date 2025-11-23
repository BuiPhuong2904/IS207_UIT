@extends('layouts.ad_layout')

@section('title', 'Quản lý huấn luyện viên')

@section('content')

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
        Thêm HLV
    </button>
</div>

{{-- Bảng danh sách HLV --}}
<div class="bg-white p-6 rounded-lg shadow-xl">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Danh sách huấn luyện viên</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border-separate border-spacing-y-2">
            <thead class="bg-gray-50 font-montserrat text-[#1f1d1d] text-xs font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left uppercase w-[10%]">Mã HLV</th>
                    <th class="px-4 py-3 text-left uppercase w-[15%]">Họ và tên</th>
                    <th class="px-4 py-3 text-left uppercase w-[20%]">Email</th>
                    <th class="px-4 py-3 text-left uppercase w-[10%]">lương (VND)</th>
                    <th class="px-4 py-3 text-left uppercase w-[10%]">Chuyên môn</th>
                    <th class="px-4 py-3 text-left uppercase flex-1">Lịch làm việc</th>
                    <th class="px-4 py-3 text-center uppercase w-[15%]">Trạng thái</th>
                </tr>
            </thead>
            <tbody id="trainer-list-body">
                @foreach ($trainers as $trainer)
                <tr class="transition duration-150 cursor-pointer modal-trigger trainer-row"
                    id="row-{{ $trainer->user_id }}"
                    data-user_id="{{ $trainer->user_id }}"
                    data-full_name="{{ $trainer->user->full_name ?? '' }}"
                    data-email="{{ $trainer->user->email ?? '' }}"
                    data-salary="{{ $trainer->salary }}"
                    data-specialty="{{ $trainer->specialty }}"
                    data-work_schedule="{{ $trainer->work_schedule }}"
                    data-status="{{ $trainer->status }}"
                    data-birth_date="{{ $trainer->user->dob ?? '' }}" 
                    data-gender="{{ $trainer->user->gender ?? 'Nam' }}"
                    data-phone="{{ $trainer->user->phone ?? '' }}"
                    data-address="{{ $trainer->user->address ?? '' }}"
                    data-password="{{ $trainer->user->password ?? '' }}"
                    data-experience_years="{{ $trainer->experience_years }}"
                    data-branch_id="{{ $trainer->branch_id }}"
                    data-image_url="{{ $trainer->user->image_url ?? asset('images/default-avatar.png') }}"
                >
                    <td colspan="7" class="p-0">
                        <div class="flex w-full rounded-lg items-center {{ $loop->even ? 'bg-white' : 'bg-[#1976D2]/10' }} shadow-sm overflow-hidden trainer-row-content">
                            
                            <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full mr-2 object-cover" src="{{ $trainer->user->image_url ?? asset('images/default-avatar.png') }}" alt="Avatar">
                                    <span>HLV{{ str_pad($trainer->user_id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700">
                                <span>{{ $trainer->user->full_name ?? 'Chưa có tên' }}</span>
                            </div>
                            <div class="px-4 py-3 w-[20%] text-sm text-gray-700">
                                {{ $trainer->user->email ?? '-' }}
                            </div>
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700">
                                {{ number_format($trainer->salary, 0, ',', '.') }}
                            </div>
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700">
                                {{ $trainer->specialty }}
                            </div>
                            <div class="px-4 py-3 flex-1 text-sm text-gray-700 truncate" title="{{ $trainer->work_schedule }}">
                                {{ $trainer->work_schedule ?: '—' }}
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-center">
                                @if ($trainer->status == 'active')
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

{{-- ----------------- MODAL 1: THÊM HLV (ĐÃ CHUYỂN SANG CUSTOM DROPDOWN) ----------------- --}}
<div id="addTrainerModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/50">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent">
            THÊM HUẤN LUYỆN VIÊN
        </h2>
        
        <form id="addTrainerForm">
            {{-- Phần Thông tin cá nhân --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin cá nhân</h3>
            <div class="flex space-x-6 mb-6">
                {{-- Cột ảnh (Trái) --}}
                <div class="w-40 flex-shrink-0 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="add-image_url_preview" src="{{ asset('images/default-avatar.png') }}" alt="Avatar" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="add-upload-btn" class="w-full flex items-center justify-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        Upload ảnh
                    </button>
                    <input type="file" id="add-image_url" class="hidden" accept="image/*">
                </div>
                
                {{-- Cột thông tin (Phải) --}}
                <div class="flex-1 flex flex-col space-y-4">
                    {{-- Hàng Họ và tên --}}
                    <div class="flex items-center">
                        <label for="add-full_name" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Họ và tên <span class="text-red-500">*</span></label>
                        <input type="text" id="add-full_name" required class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    {{-- Hàng Ngày sinh + Giới tính --}}
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label for="add-birth_date" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Ngày sinh</label>
                            <input type="date" id="add-birth_date" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
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
                    
                    {{-- Hàng Mật khẩu + SĐT --}}
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label for="add-password" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Mật khẩu <span class="text-red-500">*</span></label>
                            <input type="password" id="add-password" required placeholder="Tạo mật khẩu" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div class="flex items-center flex-1">
                            <label for="add-phone" class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">SĐT</label>
                            <input type="text" id="add-phone" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    {{-- Hàng Email --}}
                    <div class="flex items-center">
                        <label for="add-email" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="add-email" required class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
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
                    <label for="add-specialty" class="text-sm font-medium text-gray-700 mr-3 flex-shrink-0">Chuyên môn <span class="text-red-500">*</span></label>
                    <input type="text" id="add-specialty" required class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div class="flex items-center">
                    <label for="add-experience_years" class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Kinh nghiệm (năm)</label>
                    <input type="number" id="add-experience_years" min="0" value="0" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div class="flex items-center">
                    <label for="add-salary" class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Lương (VNĐ) <span class="text-red-500">*</span></label>
                    <input type="number" id="add-salary" required min="0" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
            </div>

            <div class="flex flex-col space-y-4">
                {{-- Lịch làm việc --}}
                <div class="flex items-center">
                    <label for="add-work_schedule" class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Lịch làm việc</label>
                    <textarea id="add-work_schedule" rows="2" placeholder="VD: Ca sáng 06:00 - 14:00 (T2-T7)" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
                </div>
                
                {{-- Chi nhánh làm việc (Custom Dropdown) --}}
                <div class="flex items-center relative">
                    <label class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Chi nhánh <span class="text-red-500">*</span></label>
                    
                    {{-- Custom Select Structure (Dùng class từ File 1) --}}
                    <div class="relative custom-multiselect flex-1" data-select-id="add-branch-custom" data-type="single">
                        <select id="add-branch-custom-hidden-select" name="add_branch" required class="hidden">
                            <option value="">-- Chọn chi nhánh --</option>
                            @foreach($branches as $branch) 
                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                            <span class="custom-multiselect-display text-gray-500">-- Chọn chi nhánh --</span>
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                <li class="px-3 py-2 cursor-pointer custom-multiselect-option" data-value="">
                                    <div class="flex items-center space-x-3 w-full pointer-events-none"><span class="text-sm font-medium text-gray-500">-- Chọn chi nhánh --</span></div>
                                </li>
                                @foreach($branches as $branch) 
                                <li class="px-3 py-2 cursor-pointer custom-multiselect-option" data-value="{{ $branch->branch_id }}">
                                    <div class="flex items-center space-x-3 w-full pointer-events-none"><span class="text-sm font-medium text-gray-900">{{ $branch->branch_name }}</span></div>
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
                    Thêm thông tin
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ----------------- MODAL 2: QUẢN LÝ HLV (ĐÃ CHUYỂN SANG CUSTOM DROPDOWN) ----------------- --}}
<div id="manageTrainerModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/50">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent">
            QUẢN LÝ HUẤN LUYỆN VIÊN
        </h2>
        
        <form id="manageTrainerForm">
            <input type="hidden" id="current-trainer_id">
            <input type="hidden" id="manage-current-password">

            {{-- Phần Thông tin cá nhân --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin cá nhân</h3>
            <div class="flex space-x-6 mb-6">
                {{-- Cột ảnh (Trái) --}}
                <div class="w-40 flex-shrink-0 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="manage-image_url_preview" src="" alt="Avatar" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="manage-upload-btn" class="w-full flex items-center justify-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        Upload ảnh
                    </button>
                    <input type="file" id="manage-image_url_input" class="hidden" accept="image/*">
                </div>
                
                {{-- Cột thông tin (Phải) --}}
                <div class="flex-1 flex flex-col space-y-4">

                    {{-- Hàng ID + Họ và tên --}}
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label for="manage-user_id" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">ID</label>
                            <input type="text" id="manage-user_id" class="flex-1 border border-gray-300 rounded-2xl shadow-sm bg-gray-100 px-4 py-2.5" disabled>
                        </div>
                        <div class="flex items-center flex-1">
                            <label for="manage-full_name" class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">Họ tên <span class="text-red-500">*</span></label>
                            <input type="text" id="manage-full_name" required class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    {{-- Hàng Ngày sinh + Giới tính --}}
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label for="manage-birth_date" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Ngày sinh</label>
                            <input type="date" id="manage-birth_date" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div class="flex items-center flex-1"> 
                            <label class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">Giới tính</label>
                            <div class="flex items-center space-x-4 flex-1"> 
                                <label class="flex items-center">
                                    <input type="radio" name="manage-gender" value="Nam" id="manage-gender-male" class="form-radio text-blue-600 focus:ring-1 focus:ring-black">
                                    <span class="ml-2 text-sm text-gray-700">Nam</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="manage-gender" value="Nữ" id="manage-gender-female" class="form-radio text-pink-600 focus:ring-1 focus:ring-black">
                                    <span class="ml-2 text-sm text-gray-700">Nữ</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Hàng Mật khẩu + SĐT --}}
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label for="manage-password" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Mật khẩu</label>
                            <input type="password" id="manage-password" placeholder="Nhập nếu muốn đổi" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                        <div class="flex items-center flex-1">
                            <label for="manage-phone" class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">SĐT</label>
                            <input type="text" id="manage-phone" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    {{-- Hàng Email --}}
                    <div class="flex items-center">
                        <label for="manage-email" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="manage-email" required class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    {{-- Hàng Địa chỉ --}}
                    <div class="flex items-center">
                        <label for="manage-address" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Địa chỉ</label>
                        <input type="text" id="manage-address" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                </div>
            </div>

            {{-- Phần Công việc --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Công việc</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div class="flex items-center">
                    <label for="manage-specialty" class="text-sm font-medium text-gray-700 mr-3 flex-shrink-0">Chuyên môn <span class="text-red-500">*</span></label>
                    <input type="text" id="manage-specialty" required class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div class="flex items-center">
                    <label for="manage-experience_years" class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Kinh nghiệm (năm)</label>
                    <input type="number" id="manage-experience_years" min="0" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div class="flex items-center">
                    <label for="manage-salary" class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Lương (VNĐ) <span class="text-red-500">*</span></label>
                    <input type="number" id="manage-salary" required min="0" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
            </div>

            <div class="flex flex-col space-y-4">

                {{-- Lịch làm việc --}}
                <div class="flex items-center">
                    <label for="manage-work_schedule_input" class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Lịch làm việc</label>
                    <textarea id="manage-work_schedule_input" rows="2" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
                </div>
                
                {{-- Chi nhánh làm việc (Custom Dropdown) --}}
                <div class="flex items-center relative">
                    <label class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Chi nhánh <span class="text-red-500">*</span></label>
                    
                    {{-- Custom Select Structure (Dùng class từ File 1) --}}
                    <div class="relative custom-multiselect flex-1" data-select-id="manage-branch-custom" data-type="single">
                        <select id="manage-branch-custom-hidden-select" name="manage_branch_id" required class="hidden">
                            @foreach($branches as $branch)
                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                            <span class="custom-multiselect-display text-gray-500">Chọn chi nhánh...</span>
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                @foreach($branches as $branch)
                                <li class="px-3 py-2 cursor-pointer custom-multiselect-option" data-value="{{ $branch->branch_id }}">
                                    <div class="flex items-center space-x-3 w-full pointer-events-none"><span class="text-sm font-medium text-gray-900">{{ $branch->branch_name }}</span></div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Trạng thái (Custom Dropdown) --}}
                <div class="flex items-center relative">
                    <label class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Trạng thái</label>
                    
                    {{-- Custom Select Structure (Dùng class từ File 1) --}}
                    <div class="relative custom-multiselect flex-1" data-select-id="manage-status-custom" data-type="single">
                        <select id="manage-status-custom-hidden-select" name="manage_status" class="hidden">
                            <option value="active">Đang hoạt động</option>
                            <option value="inactive">Nghỉ việc</option>
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                            <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                <li class="px-3 py-2 cursor-pointer custom-multiselect-option" data-value="active">
                                    <div class="flex items-center space-x-3 w-full pointer-events-none"><span class="text-sm font-medium text-gray-900">Đang hoạt động</span></div>
                                </li>
                                <li class="px-3 py-2 cursor-pointer custom-multiselect-option" data-value="inactive">
                                    <div class="flex items-center space-x-3 w-full pointer-events-none"><span class="text-sm font-medium text-gray-900">Nghỉ việc</span></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Nút bấm --}}
            <div class="flex justify-between mt-8">
                <button type="button" id="btn-delete-trainer" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 font-medium">
                    Xóa HLV
                </button>
                <div class="flex space-x-4">
                    <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                        Hủy
                    </button>
                    <button type="submit" class="px-8 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Lưu thông tin
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@push('scripts')
<style>
/* === SỬA LỖI GHI ĐÈ VÀ ÁP DỤNG MÀU HOVER #999999 - 50% === */

/* Cài đặt cơ bản (Giữ nguyên) */
.custom-multiselect-option { 
    @apply bg-white text-gray-900; 
}
.custom-multiselect-option span { 
    @apply text-gray-900; 
}

/* 1. Màu HOVER (Cho mục CHƯA được chọn) */

.custom-multiselect-option:hover:not(.bg-blue-100) { 
    background-color:  rgba(153, 153, 153, 0.2); !important; 
    color: #1f1d1d !important; 
}
.custom-multiselect-option:hover:not(.bg-blue-100) span { 
    color: #1f1d1d !important; 
}

/* 2. Màu SELECTED (Cho mục ĐÃ được chọn) */
/* Đảm bảo mục đã chọn (bg-blue-100) giữ màu xanh của nó */
.custom-multiselect-option.bg-blue-100 { 
    /* Dùng màu xanh nhạt (blue-100) cho trạng thái SELECTED */
    @apply bg-blue-100 text-gray-900; 
    background-color: #DBEAFE !important; 
    color: #1f1d1d !important;
}
.custom-multiselect-option.bg-blue-100 span { 
    @apply text-gray-900; 
    color: #1f1d1d !important;
}

</style>

<script>
// --- SCRIPT CUSTOM SELECT (ĐỒNG BỘ TỪ FILE 1) ---
function updateMultiselectDisplay(container) {
    const hiddenSelect = container.querySelector('select');
    const displaySpan = container.querySelector('.custom-multiselect-display');
    const selected = Array.from(hiddenSelect.selectedOptions);
    
    let placeholder = 'Chọn...';
    // Đặt placeholder tùy thuộc vào data-select-id trong File 2
    if (container.dataset.selectId === 'manage-status-custom') placeholder = 'Chọn trạng thái...';
    if (container.dataset.selectId === 'add-branch-custom' || container.dataset.selectId === 'manage-branch-custom') placeholder = 'Chọn chi nhánh...';

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

    // Cập nhật giá trị cho thẻ <select> ẩn
    Array.from(hiddenSelect.options).forEach(opt => opt.selected = false);
    selectedValues.forEach(val => {
        const opt = hiddenSelect.querySelector(`option[value="${val}"]`);
        if (opt) opt.selected = true;
    });

    // Cập nhật giao diện (li element)
    if(optionsList) optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => li.classList.remove('bg-blue-100'));
    selectedValues.forEach(val => {
        if (optionsList) {
            const li = optionsList.querySelector(`.custom-multiselect-option[data-value="${val}"]`);
            // Sử dụng class bg-blue-100 để kích hoạt style selected trong CSS (Đồng bộ với File 1)
            if (li) li.classList.add('bg-blue-100');
        }
    });

    updateMultiselectDisplay(container);
}

function initializeCustomMultiselects() {
    document.querySelectorAll('.custom-multiselect').forEach(container => {
        const trigger = container.querySelector('.custom-multiselect-trigger');
        const panel = container.querySelector('.custom-multiselect-panel');
        const optionsList = container.querySelector('.custom-multiselect-list');
        const hiddenSelect = container.querySelector('select'); 
        const displaySpan = container.querySelector('.custom-multiselect-display');
        
        if (displaySpan && !displaySpan.dataset.placeholder) displaySpan.dataset.placeholder = displaySpan.textContent;

        if (trigger) {
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                // Đóng tất cả các panel khác
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
                        // Xóa lựa chọn cũ
                        Array.from(hiddenSelect.options).forEach(o => o.selected = false);
                        if (option) option.selected = true;
                        
                        // Cập nhật class selected (bg-blue-100)
                        optionsList.querySelectorAll('.custom-multiselect-option').forEach(o => o.classList.remove('bg-blue-100'));
                        li.classList.add('bg-blue-100');
                        if (panel) panel.classList.add('hidden'); 
                    }
                    // Trigger change event trên hidden select để kích hoạt validation/listeners khác
                    hiddenSelect.dispatchEvent(new Event('change'));
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
// --- END SCRIPT CUSTOM SELECT ---


// --- MAIN LOGIC: CRUD AJAX (ĐÃ SỬA LỖI ĐỂ DÙNG CUSTOM SELECT) ---
document.addEventListener('DOMContentLoaded', function () {
    
    // Khởi tạo Custom Selects
    initializeCustomMultiselects(); 
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const addModal = document.getElementById('addTrainerModal');
    const manageModal = document.getElementById('manageTrainerModal');
    const addForm = document.getElementById('addTrainerForm');
    const manageForm = document.getElementById('manageTrainerForm');
    const defaultAvatar = '{{ asset('images/default-avatar.png') }}';

    // ... (Giữ nguyên setupPreview và Modal Helpers) ...

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
    setupPreview('add-upload-btn', 'add-image_url', 'add-image_url_preview');
    setupPreview('manage-upload-btn', 'manage-image_url_input', 'manage-image_url_preview');

    // Helpers Modal
    function openModal(m) { m.classList.remove('hidden'); m.classList.add('flex'); }
    function closeModal(m) { m.classList.add('hidden'); m.classList.remove('flex'); }

    document.querySelectorAll('.close-modal').forEach(btn =>
        btn.addEventListener('click', () => closeModal(btn.closest('.modal-container')))
    );
    document.querySelectorAll('.modal-container').forEach(m =>
        m.addEventListener('click', e => e.target === m && closeModal(m))
    );
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal(addModal);
            closeModal(manageModal);
        }
    });

    // Mở modal thêm (Add)
    document.getElementById('openAddModalBtn')?.addEventListener('click', () => {
        addForm.reset();
        document.querySelector('input[name="add-gender"][value="Nam"]').checked = true;
        document.getElementById('add-image_url_preview').src = defaultAvatar;
        document.getElementById('add-birth_date').value = ''; 
        
        // Reset Custom Selects
        setCustomMultiselectValues(document.querySelector('.custom-multiselect[data-select-id="add-branch-custom"]'), '');

        openModal(addModal);
    });

    // Click dòng → mở modal sửa (Manage)
    document.getElementById('trainer-list-body').addEventListener('click', e => {
        const row = e.target.closest('tr.modal-trigger');
        if (!row) return;

        const d = row.dataset;
        const trainerId = d.user_id;

        // ... (Thông tin cá nhân: Giữ nguyên) ...
        document.getElementById('manage-user_id').value = 'HLV' + String(trainerId).padStart(4, '0');
        document.getElementById('current-trainer_id').value = trainerId;
        document.getElementById('manage-full_name').value = d.full_name || '';
        document.getElementById('manage-email').value = d.email || '';
        document.getElementById('manage-phone').value = d.phone || '';
        document.getElementById('manage-address').value = d.address || '';
        
        // Xử lý ngày sinh (Giữ nguyên)
        if (d.birth_date) {
            if (d.birth_date.includes('/')) {
                const parts = d.birth_date.split('/');
                if (parts.length === 3) document.getElementById('manage-birth_date').value = `${parts[2]}-${parts[1]}-${parts[0]}`;
            } else {
                document.getElementById('manage-birth_date').value = d.birth_date;
            }
        } else {
            document.getElementById('manage-birth_date').value = '';
        }
        
        document.getElementById('manage-password').value = ''; 
        document.getElementById('manage-current-password').value = d.password || ''; 
        const gender = d.gender || 'Nam';
        document.getElementById('manage-gender-male').checked = (gender === 'Nam');
        document.getElementById('manage-gender-female').checked = (gender === 'Nữ');
        document.getElementById('manage-image_url_preview').src = d.image_url || defaultAvatar;

        // ... (Thông tin công việc: Giữ nguyên) ...
        document.getElementById('manage-specialty').value = d.specialty || '';
        document.getElementById('manage-experience_years').value = d.experience_years || 0;
        document.getElementById('manage-salary').value = d.salary || '';
        document.getElementById('manage-work_schedule_input').value = d.work_schedule || '';
        
        // Gán giá trị cho Custom Selects (ĐÃ SỬA)
        setCustomMultiselectValues(document.querySelector('.custom-multiselect[data-select-id="manage-branch-custom"]'), d.branch_id);
        setCustomMultiselectValues(document.querySelector('.custom-multiselect[data-select-id="manage-status-custom"]'), d.status);

        openModal(manageModal);
    });

    // === THÊM MỚI (AddForm Submit) ===
    addForm.onsubmit = async function (e) {
        e.preventDefault();

        // Lấy giá trị từ Custom Select Chi nhánh (ĐÃ SỬA)
        const branchId = document.getElementById('add-branch-custom-hidden-select').value;
        
        const fullName = document.getElementById('add-full_name').value.trim();
        const email = document.getElementById('add-email').value.trim();
        const password = document.getElementById('add-password').value.trim();
        const specialty = document.getElementById('add-specialty').value.trim();
        const salary = document.getElementById('add-salary').value;
        const birthDateInput = document.getElementById('add-birth_date').value;

        if (!fullName || !email || !password || !specialty || !salary || !branchId) {
            alert('Vui lòng điền đầy đủ các trường bắt buộc (có dấu *) và chọn Chi nhánh.');
            return;
        }

        const formData = new FormData();
        
        // 1. Dữ liệu User 
        formData.append('full_name', fullName);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('phone', document.getElementById('add-phone').value.trim());
        formData.append('address', document.getElementById('add-address').value.trim());
        formData.append('gender', document.querySelector('input[name="add-gender"]:checked').value);
        
        if (birthDateInput) {
            const [yyyy, mm, dd] = birthDateInput.split('-');
            formData.append('dob', `${dd}/${mm}/${yyyy}`);
        } else {
            formData.append('dob', '');
        }

        // 2. Dữ liệu Trainer
        formData.append('specialty', specialty);
        formData.append('experience_years', document.getElementById('add-experience_years').value || 0);
        formData.append('salary', salary);
        formData.append('work_schedule', document.getElementById('add-work_schedule').value.trim());
        formData.append('branch_id', branchId); // ĐÃ SỬA
        formData.append('status', 'active');
        
        if (document.getElementById('add-image_url').files[0]) {
            formData.append('image_file', document.getElementById('add-image_url').files[0]);
        }
        
        try {
            const res = await fetch('/admin/trainers', { 
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });

            const json = await res.json();
            
            if (!res.ok) {
                let errorMsg = 'Lỗi khi thêm HLV.';
                if (json.errors) {
                    errorMsg += '\n' + Object.values(json.errors).flat().join('\n');
                } else if (json.message) {
                    errorMsg += '\n' + json.message;
                }
                alert(errorMsg);
                return;
            }
            
            alert(json.message || 'Thêm thành công!');
            if (json.success) location.reload();
        } catch (err) {
            console.error(err);
            alert('Lỗi server: Vui lòng kiểm tra kết nối mạng hoặc server logs.');
        }
    };

    // === SỬA (ManageForm Submit) ===
    manageForm.onsubmit = async function (e) {
        e.preventDefault();

        const id = document.getElementById('current-trainer_id').value;
        if (!id) return alert('Không có ID HLV!');
        
        // Lấy giá trị từ Custom Select (ĐÃ SỬA)
        const branchId = document.getElementById('manage-branch-custom-hidden-select').value;
        const status = document.getElementById('manage-status-custom-hidden-select').value;

        const fullName = document.getElementById('manage-full_name').value.trim();
        const email = document.getElementById('manage-email').value.trim();
        const specialty = document.getElementById('manage-specialty').value.trim();
        const salary = document.getElementById('manage-salary').value;

        if (!fullName || !email || !specialty || !salary) {
            alert('Vui lòng điền đầy đủ các trường bắt buộc (có dấu *).');
            return;
        }

        const formData = new FormData();
        formData.append('_method', 'PUT'); 
        
        const birthDateInput = document.getElementById('manage-birth_date').value; 
        if (birthDateInput) {
            const [yyyy, mm, dd] = birthDateInput.split('-');
            formData.append('dob', `${dd}/${mm}/${yyyy}`);
        }
        
        // 1. Dữ liệu User
        formData.append('full_name', fullName);
        formData.append('email', email);
        formData.append('password', document.getElementById('manage-password').value.trim() || document.getElementById('manage-current-password').value);
        formData.append('phone', document.getElementById('manage-phone').value.trim());
        formData.append('address', document.getElementById('manage-address').value.trim());
        formData.append('gender', document.querySelector('input[name="manage-gender"]:checked').value);
        
        // 2. Dữ liệu Trainer
        formData.append('specialty', specialty);
        formData.append('experience_years', document.getElementById('manage-experience_years').value);
        formData.append('salary', salary);
        formData.append('work_schedule', document.getElementById('manage-work_schedule_input').value.trim()); 
        formData.append('branch_id', branchId); // ĐÃ SỬA
        formData.append('status', status); // ĐÃ SỬA

        if (document.getElementById('manage-image_url_input').files[0]) {
            formData.append('image_file', document.getElementById('manage-image_url_input').files[0]);
        }

        try {
            const res = await fetch(`/admin/trainers/${id}`, {
                method: 'POST', 
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData
            });
            
            const json = await res.json();
            
            if (!res.ok) {
                let errorMsg = 'Lỗi khi cập nhật HLV.';
                if (json.errors) errorMsg += '\n' + Object.values(json.errors).flat().join('\n');
                else if (json.message) errorMsg += '\n' + json.message;
                alert(errorMsg);
                return;
            }

            alert(json.message || 'Cập nhật thành công!');
            if (json.success) location.reload();
        } catch (err) {
            console.error('Lỗi fetch:', err);
            alert('Lỗi server: Vui lòng kiểm tra kết nối mạng hoặc server logs.');
        }
    };

    // === XÓA ===
    document.getElementById('btn-delete-trainer')?.addEventListener('click', async () => {
        if (!confirm('Xóa HLV này? Không thể khôi phục!')) return;
        const id = document.getElementById('current-trainer_id').value;

        try {
            const res = await fetch(`/admin/trainers/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            
            const json = await res.json();
            
            if (!res.ok) {
                alert(json.message || 'Lỗi khi xóa HLV.');
                return;
            }
            
            alert(json.message || 'Xóa thành công!');
            if (json.success) location.reload();
        } catch (err) {
            console.error('Lỗi khi xóa HLV:', err);
            alert('Lỗi server');
        }
    });
});
</script>
@endpush
