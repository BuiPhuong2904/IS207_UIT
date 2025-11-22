@extends('layouts.ad_layout')

@section('title', 'Quản lý huấn luyện viên')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Header (Giữ nguyên File 1) --}}
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

{{-- Bảng danh sách HLV (Sử dụng dữ liệu thực từ Controller: $trainers, $branches) --}}
{{-- LƯU Ý: Cần đảm bảo biến $trainers và $branches được truyền từ Controller --}}
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
            <tbody id="trainer-list-body"> {{-- Dùng ID từ File 1 --}}
                @foreach ($trainers ?? [] as $trainer) {{-- Dùng $trainers từ File 2 --}}
                {{-- Data attributes được lấy từ File 2 (có chỉnh sửa) --}}
                <tr class="transition duration-150 cursor-pointer modal-trigger trainer-row"
                    id="row-{{ $trainer->user_id }}"
                    data-user_id="{{ $trainer->user_id }}"
                    data-full_name="{{ $trainer->user->full_name ?? '' }}"
                    data-email="{{ $trainer->user->email ?? '' }}"
                    data-salary="{{ $trainer->salary }}"
                    data-specialty="{{ $trainer->specialty }}"
                    data-work_schedule="{{ $trainer->work_schedule }}"
                    data-status="{{ $trainer->status }}"
                    data-birth_date="{{ $trainer->user->dob ?? '01/01/2000' }}" {{-- Đổi dob sang birth_date (File 1) --}}
                    data-gender="{{ $trainer->user->gender ?? 'Nam' }}"
                    data-phone="{{ $trainer->user->phone ?? '' }}"
                    data-address="{{ $trainer->user->address ?? '' }}"
                    data-password="{{ $trainer->user->password ?? 'AaaBbbCcc' }}"
                    data-experience_years="{{ $trainer->experience_years }}"
                    data-branch_id="{{ $trainer->branch_id }}"
                    data-image_url="{{ $trainer->user->image_url ?? asset('images/default-avatar.png') }}"
                >
                    <td colspan="7" class="p-0">
                        <div class="flex w-full rounded-lg items-center
                                {{ $loop->even ? 'bg-white' : 'bg-[#1976D2]/10' }}
                                shadow-sm overflow-hidden trainer-row-content">
                            
                            <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900 trainer-id-cell">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full mr-2 object-cover trainer-image-display" src="{{ $trainer->user->image_url ?? 'https://via.placeholder.com/40' }}" alt="{{ $trainer->user->full_name ?? 'N/A' }}">
                                    <span class="trainer-id-display">HLV{{ str_pad($trainer->user_id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                            <div class="px-4 py-3 w-[20%] text-sm text-gray-700 trainer-name-display">
                                <span>{{ $trainer->user->full_name ?? 'Chưa có tên' }}</span>
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700 trainer-email-display">
                                {{ $trainer->user->email ?? '-' }}
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700 trainer-salary-display">
                                {{ number_format($trainer->salary, 0, ',', '.') }} VND
                            </div>
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700 trainer-specialty-display">
                                {{ $trainer->specialty }}
                            </div>
                            <div class="px-4 py-3 flex-1 text-sm text-gray-700 trainer-schedule-display" title="{{ $trainer->work_schedule }}">
                                {{ $trainer->work_schedule ?: '—' }}
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-right trainer-status-cell">
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
        
        {{-- Phân trang (Lấy từ File 2) --}}
        <div class="mt-6 flex justify-center">
              {{ $trainers->links() ?? '' }} 
        </div>
    </div>
</div>

{{-- ----------------- MODAL 1: THÊM HLV (Layout File 1 - Đã sửa Multiselect) ----------------- --}}
<div id="addTrainerModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/50">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        
        <h2 class="text-3xl font-bold text-center mb-6
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
            bg-clip-text text-transparent">
            THÊM HUẤN LUYỆN VIÊN
        </h2>
        
        <form id="addTrainerForm"> {{-- ID từ File 1 --}}
            {{-- Phần Thông tin cá nhân --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin cá nhân</h3>
            <div class="flex space-x-6 mb-6">
                {{-- Cột ảnh (Trái) --}}
                <div class="w-40 flex-shrink-0 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="add-image_url_preview" src="{{ asset('images/default-avatar.png') }}" alt="Avatar" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="add-upload-btn" class="w-full flex items-center justify-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
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
                            <input type="date" id="add-birth_date" placeholder="01/01/2000" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
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
                            <input type="password" id="add-password" required placeholder="Tạo mật khẩu tạm" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
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
                    <label for="add-experience_years" class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Số năm kinh nghiệm</label>
                    <input type="number" id="add-experience_years" min="0" value="0" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div class="flex items-center">
                    <label for="add-salary" class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Lương (VNĐ) <span class="text-red-500">*</span></label>
                    <input type="number" id="add-salary" required min="0" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
            </div>

            {{-- Các hàng 1 cột (Đã sửa lại thành select/textarea đơn giản để khớp logic File 2) --}}
            <div class="flex flex-col space-y-4">
                
                {{-- Lịch làm việc (Input Text -> Textarea/Select) --}}
                <div class="flex items-center">
                    <label for="add-work_schedule" class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Lịch làm việc</label>
                    {{-- Dùng textarea để nhập lịch làm việc tự do --}}
                    <textarea id="add-work_schedule" rows="2" placeholder="VD: Ca sáng 06:00 - 14:00 (T2-T7)" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
                </div>
                
                {{-- Chi nhánh làm việc (Multiselect -> Select Đơn) --}}
                <div class="flex items-center">
                    <label for="add-branch_id" class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Chi nhánh làm việc <span class="text-red-500">*</span></label>
                    <select id="add-branch_id" required class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        <option value="">-- Chọn chi nhánh --</option>
                        {{-- Dùng $branches từ Controller (File 2) --}}
                        @foreach($branches ?? [] as $branch) 
                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                        @endforeach
                    </select>
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

{{-- ----------------- MODAL 2: QUẢN LÝ HLV (Layout File 1 - Đã sửa Multiselect) ----------------- --}}
<div id="manageTrainerModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/50">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        
        <h2 class="text-3xl font-bold text-center mb-6
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
            bg-clip-text text-transparent">
            QUẢN LÝ HUẤN LUYỆN VIÊN
        </h2>
        
        <form id="manageTrainerForm"> {{-- ID từ File 1/File 2 --}}
            <input type="hidden" id="current-trainer_id">
            <input type="hidden" id="manage-current-password">

            {{-- Phần Thông tin cá nhân --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin cá nhân</h3>
            <div class="flex space-x-6 mb-6">
                {{-- Cột ảnh (Trái) --}}
                <div class="w-40 flex-shrink-0 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="manage-image_url_preview" src="https://via.placeholder.com/160x160.png?text=Image" alt="Avatar" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="manage-upload-btn" class="w-full flex items-center justify-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Upload ảnh
                    </button>
                    <input type="file" id="manage-image_url_input" class="hidden" accept="image/*"> {{-- Đổi ID --}}
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
                            <label for="manage-full_name" class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">Họ và tên <span class="text-red-500">*</span></label>
                            <input type="text" id="manage-full_name" required class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    {{-- Hàng Ngày sinh + Giới tính --}}
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label for="manage-birth_date" class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Ngày sinh</label>
                            <input type="date" id="manage-birth_date" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"> {{-- Đổi type=text sang type=date --}}
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
                            <input type="password" id="manage-password" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
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
            
            {{-- Sửa layout 3 cột --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div class="flex items-center">
                    <label for="manage-specialty" class="text-sm font-medium text-gray-700 mr-3 flex-shrink-0">Chuyên môn <span class="text-red-500">*</span></label>
                    <input type="text" id="manage-specialty" required class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div class="flex items-center">
                    <label for="manage-experience_years" class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Số năm kinh nghiệm</label>
                    <input type="number" id="manage-experience_years" min="0" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
                <div class="flex items-center">
                    <label for="manage-salary" class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Lương (VNĐ) <span class="text-red-500">*</span></label>
                    <input type="number" id="manage-salary" required min="0" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                </div>
            </div>

            {{-- Các hàng 1 cột (Đã sửa lại thành select/textarea đơn giản để khớp logic File 2) --}}
            <div class="flex flex-col space-y-4">

                {{-- Lịch làm việc (Input Text) --}}
                <div class="flex items-center">
                    <label for="manage-work_schedule_input" class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Lịch làm việc</label>
                    {{-- Dùng textarea để nhập lịch làm việc tự do --}}
                    <textarea id="manage-work_schedule_input" rows="2" placeholder="VD: Ca sáng 06:00 - 14:00 (T2-T7)" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
                    <input type="hidden" id="manage-work_schedule"> {{-- Hidden field để lưu giá trị schedule cho tiện --}}
                </div>
                
                {{-- Chi nhánh làm việc (Select Đơn) --}}
                <div class="flex items-center">
                    <label for="manage-branch_id" class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Chi nhánh làm việc <span class="text-red-500">*</span></label>
                    <select id="manage-branch_id" required class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        @foreach($branches ?? [] as $branch)
                        <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Trạng thái (Select Đơn) --}}
                <div class="flex items-center">
                    <label for="manage-status" class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Trạng thái</label>
                    <select id="manage-status" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        <option value="active">Đang hoạt động</option>
                        <option value="inactive">Nghỉ việc</option>
                    </select>
                </div>
            </div>

            {{-- Nút bấm (ĐÃ THÊM NÚT XÓA Ở ĐÂY) --}}
            <div class="flex justify-between mt-8">
                <button type="button" id="btn-delete-trainer" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
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

{{-- Đưa script AJAX của File 2 vào cuối trang --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const addModal = document.getElementById('addTrainerModal');
        const manageModal = document.getElementById('manageTrainerModal');
        const addForm = document.getElementById('addTrainerForm');
        const manageForm = document.getElementById('manageTrainerForm');
        const defaultAvatar = '{{ asset('images/default-avatar.png') }}';


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
        setupPreview('add-upload-btn', 'add-image_url', 'add-image_url_preview');
        setupPreview('manage-upload-btn', 'manage-image_url_input', 'manage-image_url_preview'); // Đã đổi ID

        // === MODAL HELPER ===
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

        // === MỞ MODAL THÊM ===
        document.getElementById('openAddModalBtn')?.addEventListener('click', () => {
            addForm.reset();
            document.querySelector('input[name="add-gender"][value="Nam"]').checked = true;
            document.getElementById('add-image_url_preview').src = defaultAvatar;
            document.getElementById('add-birth_date').value = ''; // Reset ngày sinh type=date
            openModal(addModal);
        });

        // === CLICK DÒNG → MỞ MODAL SỬA (Kết hợp logic File 1 và File 2) ===
        document.getElementById('trainer-list-body').addEventListener('click', e => {
            const row = e.target.closest('tr.modal-trigger');
            if (!row) return;

            const d = row.dataset;
            const trainerId = d.user_id;

            // Ẩn/hiện nút Xóa HLV
            document.getElementById('btn-delete-trainer').style.display = 'block';

            // Ẩn/hiện trường ID (chỉ hiển thị trong modal quản lý)
            document.getElementById('manage-user_id').value = 'HLV' + String(trainerId).padStart(4, '0');
            document.getElementById('current-trainer_id').value = trainerId; // ID nguyên thủy (số)

            // 1. Thông tin cá nhân
            document.getElementById('manage-full_name').value = d.full_name || '';
            document.getElementById('manage-email').value = d.email || '';
            document.getElementById('manage-phone').value = d.phone || '';
            document.getElementById('manage-address').value = d.address || '';
            
            // Chuẩn hóa ngày tháng (DD/MM/YYYY -> YYYY-MM-DD)
            const birthDateParts = (d.birth_date || '01/01/2000').split('/');
            if (birthDateParts.length === 3) {
                // Kiểm tra xem đây có phải là date hợp lệ không (chỉ mang tính tương đối)
                const yyyy = birthDateParts[2];
                const mm = birthDateParts[1].padStart(2, '0');
                const dd = birthDateParts[0].padStart(2, '0');
                document.getElementById('manage-birth_date').value = `${yyyy}-${mm}-${dd}`;
            } else {
                document.getElementById('manage-birth_date').value = ''; 
            }
            
            document.getElementById('manage-password').value = d.password || 'AaaBbbCcc';
            document.getElementById('manage-current-password').value = d.password || 'AaaBbbCcc';

            // Giới tính
            const gender = d.gender || 'Nam';
            document.getElementById('manage-gender-male').checked = (gender === 'Nam');
            document.getElementById('manage-gender-female').checked = (gender === 'Nữ');
            
            // Ảnh
            document.getElementById('manage-image_url_preview').src = d.image_url || defaultAvatar;

            // 2. Thông tin công việc
            document.getElementById('manage-specialty').value = d.specialty || '';
            document.getElementById('manage-experience_years').value = d.experience_years || 0;
            document.getElementById('manage-salary').value = d.salary || '';
            
            // Lịch làm việc (Lấy data vào textarea)
            const workSchedule = d.work_schedule || '';
            document.getElementById('manage-work_schedule_input').value = workSchedule;
            document.getElementById('manage-work_schedule').value = workSchedule;

            // Chi nhánh và Trạng thái (Select box)
            document.getElementById('manage-branch_id').value = d.branch_id || '';
            document.getElementById('manage-status').value = d.status || 'active';


            openModal(manageModal);
        });

        // === THÊM MỚI (Logic AJAX File 2) ===
        addForm.onsubmit = async function (e) {
            e.preventDefault();

            const fullName = document.getElementById('add-full_name').value.trim();
            const email = document.getElementById('add-email').value.trim();
            const password = document.getElementById('add-password').value.trim();
            const specialty = document.getElementById('add-specialty').value.trim();
            const salary = document.getElementById('add-salary').value;
            const branchId = document.getElementById('add-branch_id').value;
            const birthDateInput = document.getElementById('add-birth_date').value;

            if (!fullName || !email || !password || !specialty || !salary || !branchId) {
                 alert('Vui lòng điền đầy đủ các trường bắt buộc (có dấu *).');
                 return;
            }

            const formData = new FormData();
            
            // 1. Dữ liệu User (để Controller tạo User trước)
            formData.append('full_name', fullName);
            formData.append('email', email);
            formData.append('password', password);
            formData.append('phone', document.getElementById('add-phone').value.trim());
            formData.append('address', document.getElementById('add-address').value.trim());
            formData.append('gender', document.querySelector('input[name="add-gender"]:checked').value);
            // Định dạng ngày sinh (YYYY-MM-DD -> DD/MM/YYYY)
            if (birthDateInput) {
                const [yyyy, mm, dd] = birthDateInput.split('-');
                formData.append('dob', `${dd}/${mm}/${yyyy}`);
            } else {
                 formData.append('dob', '');
            }


            // 2. Dữ liệu Trainer (sẽ dùng User ID vừa tạo)
            formData.append('specialty', specialty);
            formData.append('experience_years', document.getElementById('add-experience_years').value || 0);
            formData.append('salary', salary);
            formData.append('work_schedule', document.getElementById('add-work_schedule').value.trim());
            formData.append('branch_id', branchId);
            formData.append('status', 'active');
            
            if (document.getElementById('add-image_url').files[0]) {
                formData.append('image_file', document.getElementById('add-image_url').files[0]);
            }
            
            try {
                // Giả định Controller xử lý tạo cả User và Trainer
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
                    console.error('Lỗi khi thêm HLV:', json);
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

        // === SỬA (Logic AJAX File 2) ===
        manageForm.onsubmit = async function (e) {
            e.preventDefault();

            const id = document.getElementById('current-trainer_id').value;
            if (!id) return alert('Không có ID HLV!');
            
            const fullName = document.getElementById('manage-full_name').value.trim();
            const email = document.getElementById('manage-email').value.trim();
            const specialty = document.getElementById('manage-specialty').value.trim();
            const salary = document.getElementById('manage-salary').value;

            if (!fullName || !email || !specialty || !salary) {
                 alert('Vui lòng điền đầy đủ các trường bắt buộc (có dấu *).');
                 return;
            }

            const formData = new FormData();
            formData.append('_method', 'PUT'); // Laravel yêu cầu field này cho method PUT/PATCH
            
            // Lấy giá trị ngày sinh và đổi định dạng
            const birthDateInput = document.getElementById('manage-birth_date').value; // YYYY-MM-DD
            let dob = '';
            if (birthDateInput) {
                const [yyyy, mm, dd] = birthDateInput.split('-');
                dob = `${dd}/${mm}/${yyyy}`; // DD/MM/YYYY
            }
            
            // 1. Dữ liệu User
            formData.append('full_name', fullName);
            formData.append('email', email);
            formData.append('password', document.getElementById('manage-password').value.trim() || document.getElementById('manage-current-password').value);
            formData.append('phone', document.getElementById('manage-phone').value.trim());
            formData.append('address', document.getElementById('manage-address').value.trim());
            formData.append('gender', document.querySelector('input[name="manage-gender"]:checked').value);
            formData.append('dob', dob);
            
            // 2. Dữ liệu Trainer
            formData.append('specialty', specialty);
            formData.append('experience_years', document.getElementById('manage-experience_years').value);
            formData.append('salary', salary);
            // Lấy giá trị từ textarea Lịch làm việc
            formData.append('work_schedule', document.getElementById('manage-work_schedule_input').value.trim()); 
            formData.append('branch_id', document.getElementById('manage-branch_id').value);
            formData.append('status', document.getElementById('manage-status').value);

            if (document.getElementById('manage-image_url_input').files[0]) {
                formData.append('image_file', document.getElementById('manage-image_url_input').files[0]);
            }

            try {
                // Giả định Controller có logic cập nhật cả User và Trainer
                const res = await fetch(`/admin/trainers/${id}`, {
                    method: 'POST', // Dùng POST với _method=PUT
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    body: formData
                });
                
                const json = await res.json();
                
                if (!res.ok) {
                    let errorMsg = 'Lỗi khi cập nhật HLV.';
                    if (json.errors) {
                        errorMsg += '\n' + Object.values(json.errors).flat().join('\n');
                    } else if (json.message) {
                        errorMsg += '\n' + json.message;
                    }
                    console.error('Lỗi khi cập nhật HLV:', json);
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

        // === XÓA (Logic AJAX TƯƠNG TỰ File 2 ĐÃ ĐƯỢC THÊM) ===
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
                    let errorMsg = 'Lỗi khi xóa HLV.';
                    if (json.message) {
                         errorMsg += '\n' + json.message;
                    }
                    console.error('Lỗi khi xóa HLV:', json);
                    alert(errorMsg);
                    return;
                }
                
                alert(json.message || 'Xóa thành công!');
                if (json.success) location.reload();
            } catch (err) {
                console.error('Lỗi khi xóa HLV:', err);
                alert('Lỗi server – mở F12 → Network để xem chi tiết');
            }
        });
    });
</script>
@endpush
