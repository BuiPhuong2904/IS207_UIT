@extends('layouts.ad_layout')

@section('title', 'Quản lý huấn luyện viên')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="bg-white rounded-2xl shadow-sm p-6">
    
    {{-- HEADER & BUTTONS --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-montserrat text-2xl text-black font-semibold">Danh sách huấn luyện viên</h1>
        
        <div class="flex items-center space-x-4 font-open-sans">
            {{-- Dropdown lọc --}}
            <div class="flex items-center text-black cursor-pointer hover:text-gray-900">
                <span class="mr-1 text-sm font-medium">Trạng thái</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            {{-- Nút Thêm HLV --}}
            <button id="openAddModalBtn" class="bg-[#28A745] hover:bg-[#218838] text-white px-4 py-2 rounded-full flex items-center text-sm font-semibold transition-colors shadow-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Thêm HLV
            </button>
        </div>
    </div>

    {{-- TABLE CONTENT --}}
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse table-auto font-open-sans">
            
            <thead class="font-montserrat text-[#1f1d1d] text-sm text-center">
                <tr>
                    <th class="py-4 px-4 w-[10%] truncate">Mã HLV</th>
                    <th class="py-4 px-4 w-[15%] truncate">Họ và tên</th>
                    <th class="py-4 px-4 w-[20%] truncate">Email</th>
                    <th class="py-4 px-4 w-[10%] truncate">Lương (VND)</th>
                    <th class="py-4 px-4 w-[10%] truncate">Chuyên môn</th>
                    <th class="py-4 px-4 flex-1 truncate">Lịch làm việc</th>
                    <th class="py-4 px-4 w-[15%] truncate">Trạng thái</th>
                </tr>
            </thead>

            <tbody id="trainer-list-body" class="text-sm text-gray-700 text-center">
                @foreach ($trainers as $trainer)
                    @php
                        $isOdd = $loop->odd;
                        $rowBg = $isOdd ? 'bg-[#1976D2]/20' : 'bg-white';
                        $roundLeft = $isOdd ? 'rounded-l-xl' : '';
                        $roundRight = $isOdd ? 'rounded-r-xl' : '';
                        
                        // Xử lý ngày tháng
                        $rawDate = $trainer->user->birth_date ?? $trainer->user->dob;
                        $formattedDate = $rawDate ? \Carbon\Carbon::parse($rawDate)->format('Y-m-d') : '';
                    @endphp

                    <tr class="{{ $rowBg }} cursor-pointer transition-colors modal-trigger group"
                        id="row-{{ $trainer->user_id }}"
                        data-user_id="{{ $trainer->user_id }}"
                        data-full_name="{{ $trainer->user->full_name ?? '' }}"
                        data-email="{{ $trainer->user->email ?? '' }}"
                        data-salary="{{ $trainer->salary }}"
                        data-specialty="{{ $trainer->specialty }}"
                        data-work_schedule="{{ $trainer->work_schedule }}"
                        data-status="{{ $trainer->status }}"
                        data-birth_date="{{ $formattedDate }}" 
                        data-gender="{{ $trainer->user->gender ?? 'Nam' }}"
                        data-phone="{{ $trainer->user->phone ?? '' }}"
                        data-address="{{ $trainer->user->address ?? '' }}"
                        data-password="{{ $trainer->user->password ?? '' }}"
                        data-experience_years="{{ $trainer->experience_years }}"
                        data-branch_id="{{ $trainer->branch_id }}"
                        data-image_url="{{ $trainer->user->image_url ?? asset('images/default-avatar.png') }}"
                    >
                        {{-- Mã HLV--}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundLeft }} font-medium">
                            HLV{{ str_pad($trainer->user_id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        {{-- Họ tên --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            {{ $trainer->user->full_name ?? 'Chưa có tên' }}
                        </td>

                        {{-- Email --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $trainer->user->email ?? '-' }}
                        </td>

                        {{-- Lương --}}
                        <td class="py-4 px-4 truncate align-middle font-medium">
                            {{ number_format($trainer->salary, 0, ',', '.') }}
                        </td>

                        {{-- Chuyên môn --}}
                        <td class="py-4 px-4 truncate align-middle">
                            {{ $trainer->specialty }}
                        </td>

                        {{-- Lịch làm việc --}}
                        <td class="py-4 px-4 align-middle text-left max-w-xs truncate" title="{{ $trainer->work_schedule }}">
                            {{ $trainer->work_schedule ?: '—' }}
                        </td>

                        {{-- Trạng thái --}}
                        <td class="py-4 px-4 truncate align-middle {{ $roundRight }}">
                            @if ($trainer->status == 'active')
                                <span class="bg-[#28A745]/10 text-[#28A745]/70 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                                    Hoạt động
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-500 py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                                    Nghỉ việc
                                </span>
                            @endif
                        </td>
                    </tr>
                    
                    {{-- Dòng rỗng tạo khoảng cách --}}
                    <tr class="h-2"></tr> 
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
             {{ $trainers->links() }} 
        </div>
    </div>
</div>

{{-- ----------------- MODAL 1: THÊM HLV ----------------- --}}
<div id="addTrainerModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40 transition-opacity">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto transform transition-all scale-100">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
            THÊM HUẤN LUYỆN VIÊN
        </h2>
        <form id="addTrainerForm">
            {{-- Thông tin cá nhân --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">Thông tin cá nhân</h3>
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
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Mật khẩu <span class="text-red-500">*</span></label>
                            <input type="password" id="add-password" required class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="flex items-center flex-1">
                            <label class="w-16 flex-shrink-0 text-sm font-semibold text-gray-700">SĐT</label>
                            <input type="text" id="add-phone" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="add-email" required class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Địa chỉ</label>
                        <input type="text" id="add-address" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            {{-- Thông tin công việc --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">Công việc</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div class="flex items-center">
                    <label class="text-sm font-semibold text-gray-700 mr-3 flex-shrink-0">Chuyên môn <span class="text-red-500">*</span></label>
                    <input type="text" id="add-specialty" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="flex items-center">
                    <label class="text-sm font-semibold text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Kinh nghiệm</label>
                    <input type="number" id="add-experience_years" min="0" value="0" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="flex items-center">
                    <label class="text-sm font-semibold text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Lương <span class="text-red-500">*</span></label>
                    <input type="number" id="add-salary" required min="0" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>

            <div class="flex flex-col space-y-4">
                <div class="flex items-center">
                    <label class="w-40 flex-shrink-0 text-sm font-semibold text-gray-700">Lịch làm việc</label>
                    <textarea id="add-work_schedule" rows="2" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                </div>
                
                {{-- CUSTOM SELECT: CHI NHÁNH --}}
                <div class="flex items-center relative">
                    <label class="w-40 flex-shrink-0 text-sm font-semibold text-gray-700">Chi nhánh <span class="text-red-500">*</span></label>
                    <div class="relative custom-multiselect flex-1" data-select-id="add-branch-custom" data-type="single">
                        <select id="add-branch-custom-hidden-select" class="hidden">
                            <option value="">-- Chọn chi nhánh --</option>
                            @foreach($branches as $branch) 
                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-xl text-left px-4 py-2.5 flex items-center justify-between focus:ring-2 focus:ring-blue-500 outline-none">
                            <span class="custom-multiselect-display text-gray-500">-- Chọn chi nhánh --</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                @foreach($branches as $branch) 
                                <li class="px-4 py-2.5 hover:bg-blue-50 cursor-pointer custom-multiselect-option transition-colors border-b border-gray-50 last:border-0" data-value="{{ $branch->branch_id }}">
                                    <span class="text-sm font-medium text-gray-700">{{ $branch->branch_name }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center space-x-3 mt-8 pt-4 border-t border-gray-100">
                <button type="button" class="close-modal px-6 py-2.5 bg-[#6c757d] hover:bg-[#5a6268] text-white font-semibold rounded-lg transition-colors focus:outline-none">
                    Hủy
                </button>
                <button type="submit" class="px-6 py-2.5 bg-[#28A745] hover:bg-[#218838] text-white font-semibold rounded-lg transition-colors focus:outline-none shadow-md">
                    Thêm thông tin
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ----------------- MODAL 2: QUẢN LÝ HLV ----------------- --}}
<div id="manageTrainerModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/40">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto transform transition-all">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
            QUẢN LÝ HUẤN LUYỆN VIÊN
        </h2>
        <form id="manageTrainerForm">
            <input type="hidden" id="current-trainer_id">
            <input type="hidden" id="manage-current-password">

            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">Thông tin cá nhân</h3>
            <div class="flex space-x-6 mb-6">
                <div class="w-40 flex-shrink-0 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-100 rounded-2xl flex items-center justify-center mb-3 border-2 border-dashed border-gray-300 overflow-hidden">
                        <img id="manage-image_url_preview" src="" class="w-full h-full object-cover">
                    </div>
                    <button type="button" id="manage-upload-btn" class="w-full px-4 py-2 bg-blue-50 text-blue-600 text-sm font-semibold rounded-lg hover:bg-blue-100 transition-colors">Upload ảnh</button>
                    <input type="file" id="manage-image_url_input" class="hidden" accept="image/*">
                </div>
                <div class="flex-1 flex flex-col space-y-4">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">ID</label>
                            <input type="text" id="manage-user_id" class="flex-1 bg-gray-100 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-500 font-mono" disabled>
                        </div>
                        <div class="flex items-center flex-1">
                            <label class="w-16 flex-shrink-0 text-sm font-semibold text-gray-700">Họ tên <span class="text-red-500">*</span></label>
                            <input type="text" id="manage-full_name" required class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Ngày sinh</label>
                            <input type="date" id="manage-birth_date" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="flex items-center flex-1"> 
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Giới tính</label>
                            <div class="flex items-center space-x-4 flex-1"> 
                                <label class="flex items-center cursor-pointer"><input type="radio" name="manage-gender" value="Nam" id="manage-gender-male" class="mr-2 accent-blue-600"> Nam</label>
                                <label class="flex items-center cursor-pointer"><input type="radio" name="manage-gender" value="Nữ" id="manage-gender-female" class="mr-2 accent-blue-600"> Nữ</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Mật khẩu</label>
                            <input type="password" id="manage-password" placeholder="Nhập nếu muốn đổi" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="flex items-center flex-1">
                            <label class="w-16 flex-shrink-0 text-sm font-semibold text-gray-700">SĐT</label>
                            <input type="text" id="manage-phone" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="manage-email" required class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-semibold text-gray-700">Địa chỉ</label>
                        <input type="text" id="manage-address" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>
            </div>

            <h3 class="text-xl font-semibold text-blue-700 mb-4 font-montserrat">Công việc</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div class="flex items-center">
                    <label class="text-sm font-semibold text-gray-700 mr-3 flex-shrink-0">Chuyên môn <span class="text-red-500">*</span></label>
                    <input type="text" id="manage-specialty" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="flex items-center">
                    <label class="text-sm font-semibold text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Kinh nghiệm</label>
                    <input type="number" id="manage-experience_years" min="0" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="flex items-center">
                    <label class="text-sm font-semibold text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Lương <span class="text-red-500">*</span></label>
                    <input type="number" id="manage-salary" required min="0" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
            </div>
            <div class="flex flex-col space-y-4">
                <div class="flex items-center">
                    <label class="w-40 flex-shrink-0 text-sm font-semibold text-gray-700">Lịch làm việc</label>
                    <textarea id="manage-work_schedule_input" rows="2" class="flex-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-blue-500 outline-none resize-none"></textarea>
                </div>
                
                {{-- CUSTOM SELECT: CHI NHÁNH (MANAGE) --}}
                <div class="flex items-center relative">
                    <label class="w-40 flex-shrink-0 text-sm font-semibold text-gray-700">Chi nhánh <span class="text-red-500">*</span></label>
                    <div class="relative custom-multiselect flex-1" data-select-id="manage-branch-custom" data-type="single">
                        <select id="manage-branch-custom-hidden-select" class="hidden">
                            <option value="" disabled>Chọn chi nhánh...</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-xl text-left px-4 py-2.5 flex items-center justify-between focus:ring-2 focus:ring-blue-500 outline-none">
                            <span class="custom-multiselect-display text-gray-500">Chọn chi nhánh...</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                @foreach($branches as $branch)
                                <li class="px-4 py-2.5 hover:bg-blue-50 cursor-pointer custom-multiselect-option transition-colors border-b border-gray-50 last:border-0" data-value="{{ $branch->branch_id }}">
                                    <span class="text-sm font-medium text-gray-700">{{ $branch->branch_name }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- CUSTOM SELECT: TRẠNG THÁI (MANAGE) --}}
                <div class="flex items-center relative">
                    <label class="w-40 flex-shrink-0 text-sm font-semibold text-gray-700">Trạng thái</label>
                    <div class="relative custom-multiselect flex-1" data-select-id="manage-status-custom" data-type="single"> 
                        <select id="manage-status-custom-hidden-select" class="hidden">
                            <option value="active">Đang hoạt động</option>
                            <option value="inactive">Nghỉ việc</option>
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-xl text-left px-4 py-2.5 flex items-center justify-between focus:ring-2 focus:ring-blue-500 outline-none">
                            <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden">
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                <li class="px-4 py-2.5 hover:bg-green-50 cursor-pointer custom-multiselect-option border-b border-gray-50" data-value="active">
                                    <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span><span class="text-sm font-medium text-gray-900">Đang hoạt động</span></div>
                                </li>
                                <li class="px-4 py-2.5 hover:bg-gray-50 cursor-pointer custom-multiselect-option" data-value="inactive">
                                    <div class="flex items-center"><span class="w-2 h-2 rounded-full bg-gray-400 mr-2"></span><span class="text-sm font-medium text-gray-900">Nghỉ việc</span></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mt-8 pt-4 border-t border-gray-100">
                <button type="button" id="btn-delete-trainer" class="px-5 py-2.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 font-semibold transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Xóa HLV
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
<style>
    /* === CUSTOM STYLES CHO CUSTOM SELECT COMPONENT === */
    .custom-multiselect-option { @apply bg-white text-gray-700 transition-all duration-200 ease-in-out; }
    
    /* Hover */
    .custom-multiselect-option:hover:not(.bg-blue-100) { @apply bg-blue-50 text-gray-900; }
    
    /* Selected */
    .custom-multiselect-option.bg-blue-100 { @apply bg-blue-100 text-blue-800 font-medium; }
</style>

<script>
    // --- 1. CUSTOM MULTISELECT LOGIC ---
    function updateMultiselectDisplay(container) {
        if (!container) return;
        const select = container.querySelector('select');
        const display = container.querySelector('.custom-multiselect-display');
        const selected = select.options[select.selectedIndex];
        const placeholder = display.dataset.placeholder || 'Chọn...';
        
        if (!selected || selected.value === "") {
            display.textContent = placeholder;
            display.classList.add('text-gray-500');
        } else {
            display.textContent = selected.text;
            display.classList.remove('text-gray-500');
        }
    }

    function setCustomMultiselectValues(container, value) {
        if (!container) return;
        const select = container.querySelector('select');
        const valStr = String(value).trim();
        
        Array.from(select.options).forEach(opt => opt.selected = (String(opt.value).trim() === valStr));
        
        const list = container.querySelector('.custom-multiselect-list');
        if (list) {
            list.querySelectorAll('.custom-multiselect-option').forEach(li => {
                li.classList.remove('bg-blue-100');
                if (String(li.dataset.value).trim() === valStr) li.classList.add('bg-blue-100');
            });
        }
        updateMultiselectDisplay(container);
    }

    function initializeCustomMultiselects() {
        document.querySelectorAll('.custom-multiselect').forEach(container => {
            const trigger = container.querySelector('.custom-multiselect-trigger');
            const panel = container.querySelector('.custom-multiselect-panel');
            const list = container.querySelector('.custom-multiselect-list');
            const select = container.querySelector('select');
            const display = container.querySelector('.custom-multiselect-display');

            if (display) display.dataset.placeholder = display.textContent;

            trigger?.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('.custom-multiselect-panel').forEach(p => { if(p !== panel) p.classList.add('hidden'); });
                panel?.classList.toggle('hidden');
            });

            list?.querySelectorAll('.custom-multiselect-option').forEach(li => {
                li.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const val = li.dataset.value;
                    Array.from(select.options).forEach(opt => opt.selected = (opt.value === val));
                    list.querySelectorAll('.custom-multiselect-option').forEach(l => l.classList.remove('bg-blue-100'));
                    li.classList.add('bg-blue-100');
                    panel?.classList.add('hidden');
                    updateMultiselectDisplay(container);
                });
            });
            updateMultiselectDisplay(container);
        });
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.custom-multiselect')) document.querySelectorAll('.custom-multiselect-panel').forEach(p => p.classList.add('hidden'));
        });
    }

    // --- 2. MAIN APP LOGIC ---
    document.addEventListener('DOMContentLoaded', function () {
        initializeCustomMultiselects();

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const addModal = document.getElementById('addTrainerModal');
        const manageModal = document.getElementById('manageTrainerModal');
        const addForm = document.getElementById('addTrainerForm');
        const manageForm = document.getElementById('manageTrainerForm');
        const defaultAvatar = '{{ asset('images/default-avatar.png') }}';

        // Logic Preview Ảnh
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

        // Helpers Modal
        function closeModal(m) { m.classList.add('hidden'); m.classList.remove('flex'); }
        function openModal(m) { m.classList.remove('hidden'); m.classList.add('flex'); }

        document.querySelectorAll('.close-modal').forEach(b => b.addEventListener('click', () => closeModal(b.closest('.modal-container'))));
        document.querySelectorAll('.modal-container').forEach(m => m.addEventListener('click', e => e.target === m && closeModal(m)));

        // Open ADD Modal
        document.getElementById('openAddModalBtn').onclick = () => {
            addForm.reset();
            document.getElementById('add-image_url_preview').src = defaultAvatar;
            setCustomMultiselectValues(document.querySelector('[data-select-id="add-branch-custom"]'), '');
            openModal(addModal);
        };

        // Open MANAGE Modal (Click row)
        document.getElementById('trainer-list-body').addEventListener('click', e => {
            const row = e.target.closest('tr.modal-trigger');
            if (!row) return;
            const d = row.dataset;
            
            document.getElementById('current-trainer_id').value = d.user_id;
            document.getElementById('manage-user_id').value = 'HLV' + String(d.user_id).padStart(4, '0');
            document.getElementById('manage-full_name').value = d.full_name || '';
            document.getElementById('manage-email').value = d.email || '';
            document.getElementById('manage-phone').value = d.phone || '';
            document.getElementById('manage-address').value = d.address || '';
            document.getElementById('manage-birth_date').value = d.birth_date || '';
            
            if(d.gender === 'Nữ') document.getElementById('manage-gender-female').checked = true;
            else document.getElementById('manage-gender-male').checked = true;

            document.getElementById('manage-specialty').value = d.specialty || '';
            document.getElementById('manage-experience_years').value = d.experience_years || 0;
            document.getElementById('manage-salary').value = d.salary || '';
            document.getElementById('manage-work_schedule_input').value = d.work_schedule || '';
            
            setCustomMultiselectValues(document.querySelector('[data-select-id="manage-branch-custom"]'), d.branch_id);
            setCustomMultiselectValues(document.querySelector('[data-select-id="manage-status-custom"]'), d.status);
            
            document.getElementById('manage-image_url_preview').src = d.image_url || defaultAvatar;
            
            openModal(manageModal);
        });

        // --- SUBMIT ADD FORM ---
        addForm.onsubmit = async (e) => {
            e.preventDefault();
            const fd = new FormData();
            fd.append('full_name', document.getElementById('add-full_name').value);
            fd.append('email', document.getElementById('add-email').value);
            fd.append('password', document.getElementById('add-password').value);
            fd.append('phone', document.getElementById('add-phone').value);
            fd.append('address', document.getElementById('add-address').value);
            fd.append('gender', document.querySelector('input[name="add-gender"]:checked').value);
            fd.append('dob', document.getElementById('add-birth_date').value);
            fd.append('specialty', document.getElementById('add-specialty').value);
            fd.append('experience_years', document.getElementById('add-experience_years').value);
            fd.append('salary', document.getElementById('add-salary').value);
            fd.append('work_schedule', document.getElementById('add-work_schedule').value);
            fd.append('branch_id', document.getElementById('add-branch-custom-hidden-select').value);
            fd.append('status', 'active');
            if(document.getElementById('add-image_url').files[0]) fd.append('image_file', document.getElementById('add-image_url').files[0]);

            try {
                const res = await fetch('/admin/trainers', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd });
                const json = await res.json();
                if(!res.ok) {
                    let msg = 'Lỗi thêm: ';
                    if(json.errors) msg += Object.values(json.errors).join('\n');
                    else msg += json.message;
                    alert(msg);
                } else {
                    alert('Thêm thành công!');
                    location.reload();
                }
            } catch (err) { alert('Lỗi server'); console.error(err); }
        };

        // --- SUBMIT MANAGE FORM ---
        manageForm.onsubmit = async (e) => {
            e.preventDefault();
            const id = document.getElementById('current-trainer_id').value;
            const fd = new FormData();
            fd.append('_method', 'PUT');
            fd.append('full_name', document.getElementById('manage-full_name').value);
            fd.append('email', document.getElementById('manage-email').value);
            fd.append('phone', document.getElementById('manage-phone').value);
            fd.append('address', document.getElementById('manage-address').value);
            fd.append('gender', document.querySelector('input[name="manage-gender"]:checked').value);
            fd.append('dob', document.getElementById('manage-birth_date').value);

            const pass = document.getElementById('manage-password').value;
            if(pass) fd.append('password', pass);

            fd.append('specialty', document.getElementById('manage-specialty').value);
            fd.append('experience_years', document.getElementById('manage-experience_years').value);
            fd.append('salary', document.getElementById('manage-salary').value);
            fd.append('work_schedule', document.getElementById('manage-work_schedule_input').value);
            fd.append('branch_id', document.getElementById('manage-branch-custom-hidden-select').value);
            fd.append('status', document.getElementById('manage-status-custom-hidden-select').value);

            if(document.getElementById('manage-image_url_input').files[0]) fd.append('image_file', document.getElementById('manage-image_url_input').files[0]);

            try {
                const res = await fetch(`/admin/trainers/${id}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, body: fd });
                const json = await res.json();
                if(!res.ok) {
                    let msg = 'Lỗi cập nhật: ';
                    if(json.errors) msg += Object.values(json.errors).join('\n');
                    else msg += json.message;
                    alert(msg);
                } else {
                    alert('Cập nhật thành công!');
                    location.reload();
                }
            } catch (err) { alert('Lỗi server'); console.error(err); }
        };

        // --- DELETE ACTION ---
        document.getElementById('btn-delete-trainer').onclick = async () => {
            if(!confirm('Xóa HLV này?')) return;
            try {
                const res = await fetch(`/admin/trainers/${document.getElementById('current-trainer_id').value}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' } });
                if(res.ok) { alert('Xóa thành công!'); location.reload(); }
                else alert('Lỗi xóa');
            } catch { alert('Lỗi server'); }
        };
    });
</script>
@endpush