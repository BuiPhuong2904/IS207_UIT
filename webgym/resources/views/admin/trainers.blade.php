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
                    <th class="px-4 py-3 text-left uppercase w-[10%]">Lương (VND)</th>
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
                    
                    {{-- QUAN TRỌNG: Ép kiểu về Y-m-d ngay tại đây để JS Code 2 (gán thẳng) hoạt động được --}}
                    @php
                        $rawDate = $trainer->user->birth_date ?? $trainer->user->dob;
                        $formattedDate = $rawDate ? \Carbon\Carbon::parse($rawDate)->format('Y-m-d') : '';
                    @endphp
                    data-birth_date="{{ $formattedDate }}" 
                    
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

{{-- ----------------- MODAL 1: THÊM HLV ----------------- --}}
<div id="addTrainerModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/50">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent">
            THÊM HUẤN LUYỆN VIÊN
        </h2>
        <form id="addTrainerForm">
            {{-- Thông tin cá nhân --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin cá nhân</h3>
            <div class="flex space-x-6 mb-6">
                <div class="w-40 flex-shrink-0 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="add-image_url_preview" src="{{ asset('images/default-avatar.png') }}" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="add-upload-btn" class="w-full px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">Upload ảnh</button>
                    <input type="file" id="add-image_url" class="hidden" accept="image/*">
                </div>
                <div class="flex-1 flex flex-col space-y-4">
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Họ và tên <span class="text-red-500">*</span></label>
                        <input type="text" id="add-full_name" required class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Ngày sinh</label>
                            <input type="date" id="add-birth_date" class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                        </div>
                        <div class="flex items-center flex-1"> 
                            <label class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">Giới tính</label>
                            <div class="flex items-center space-x-4 flex-1"> 
                                <label class="flex items-center"><input type="radio" name="add-gender" value="Nam" class="mr-2" checked> Nam</label>
                                <label class="flex items-center"><input type="radio" name="add-gender" value="Nữ" class="mr-2"> Nữ</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Mật khẩu <span class="text-red-500">*</span></label>
                            <input type="password" id="add-password" required class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                        </div>
                        <div class="flex items-center flex-1">
                            <label class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">SĐT</label>
                            <input type="text" id="add-phone" class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="add-email" required class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                    </div>
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Địa chỉ</label>
                        <input type="text" id="add-address" class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                    </div>
                </div>
            </div>

            {{-- Thông tin công việc --}}
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Công việc</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div class="flex items-center">
                    <label class="text-sm font-medium text-gray-700 mr-3 flex-shrink-0">Chuyên môn <span class="text-red-500">*</span></label>
                    <input type="text" id="add-specialty" required class="w-full border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                </div>
                <div class="flex items-center">
                    <label class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Kinh nghiệm</label>
                    <input type="number" id="add-experience_years" min="0" value="0" class="w-full border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                </div>
                <div class="flex items-center">
                    <label class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Lương <span class="text-red-500">*</span></label>
                    <input type="number" id="add-salary" required min="0" class="w-full border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                </div>
            </div>

            <div class="flex flex-col space-y-4">
                <div class="flex items-center">
                    <label class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Lịch làm việc</label>
                    <textarea id="add-work_schedule" rows="2" class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5"></textarea>
                </div>
                
                {{-- CUSTOM SELECT: CHI NHÁNH --}}
                <div class="flex items-center relative">
                    <label class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Chi nhánh <span class="text-red-500">*</span></label>
                    <div class="relative custom-multiselect flex-1" data-select-id="add-branch-custom" data-type="single">
                        <select id="add-branch-custom-hidden-select" class="hidden">
                            <option value="">-- Chọn chi nhánh --</option>
                            @foreach($branches as $branch) 
                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none">
                            <span class="custom-multiselect-display text-gray-500">-- Chọn chi nhánh --</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                @foreach($branches as $branch) 
                                <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $branch->branch_id }}"><span class="text-sm text-gray-900">{{ $branch->branch_name }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center space-x-4 mt-8">
                <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg">Hủy</button>
                <button type="submit" class="px-8 py-2 bg-green-500 text-white rounded-lg">Thêm thông tin</button>
            </div>
        </form>
    </div>
</div>

{{-- ----------------- MODAL 2: QUẢN LÝ HLV ----------------- --}}
<div id="manageTrainerModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center bg-black/50">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent">QUẢN LÝ HUẤN LUYỆN VIÊN</h2>
        <form id="manageTrainerForm">
            <input type="hidden" id="current-trainer_id">
            <input type="hidden" id="manage-current-password">

            <h3 class="text-xl font-semibold text-blue-700 mb-4">Thông tin cá nhân</h3>
            <div class="flex space-x-6 mb-6">
                <div class="w-40 flex-shrink-0 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="manage-image_url_preview" src="" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="manage-upload-btn" class="w-full px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">Upload ảnh</button>
                    <input type="file" id="manage-image_url_input" class="hidden" accept="image/*">
                </div>
                <div class="flex-1 flex flex-col space-y-4">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">ID</label>
                            <input type="text" id="manage-user_id" class="flex-1 border border-gray-300 rounded-2xl px-4 py-2.5 bg-gray-100" disabled>
                        </div>
                        <div class="flex items-center flex-1">
                            <label class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">Họ tên <span class="text-red-500">*</span></label>
                            <input type="text" id="manage-full_name" required class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Ngày sinh</label>
                            <input type="date" id="manage-birth_date" class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                        </div>
                        <div class="flex items-center flex-1"> 
                            <label class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">Giới tính</label>
                            <div class="flex items-center space-x-4 flex-1"> 
                                <label class="flex items-center"><input type="radio" name="manage-gender" value="Nam" id="manage-gender-male" class="mr-2"> Nam</label>
                                <label class="flex items-center"><input type="radio" name="manage-gender" value="Nữ" id="manage-gender-female" class="mr-2"> Nữ</label>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center flex-1">
                            <label class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Mật khẩu</label>
                            <input type="password" id="manage-password" placeholder="Nhập nếu muốn đổi" class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                        </div>
                        <div class="flex items-center flex-1">
                            <label class="w-16 flex-shrink-0 text-sm font-medium text-gray-700">SĐT</label>
                            <input type="text" id="manage-phone" class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                        </div>
                    </div>
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="manage-email" required class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                    </div>
                    <div class="flex items-center">
                        <label class="w-24 flex-shrink-0 text-sm font-medium text-gray-700">Địa chỉ</label>
                        <input type="text" id="manage-address" class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                    </div>
                </div>
            </div>

            <h3 class="text-xl font-semibold text-blue-700 mb-4">Công việc</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div class="flex items-center">
                    <label class="text-sm font-medium text-gray-700 mr-3 flex-shrink-0">Chuyên môn <span class="text-red-500">*</span></label>
                    <input type="text" id="manage-specialty" required class="w-full border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                </div>
                <div class="flex items-center">
                    <label class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Kinh nghiệm</label>
                    <input type="number" id="manage-experience_years" min="0" class="w-full border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                </div>
                <div class="flex items-center">
                    <label class="text-sm font-medium text-gray-700 mr-3 whitespace-nowrap flex-shrink-0">Lương <span class="text-red-500">*</span></label>
                    <input type="number" id="manage-salary" required min="0" class="w-full border border-[#999999]/50 rounded-2xl px-4 py-2.5">
                </div>
            </div>
            <div class="flex flex-col space-y-4">
                <div class="flex items-center">
                    <label class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Lịch làm việc</label>
                    <textarea id="manage-work_schedule_input" rows="2" class="flex-1 border border-[#999999]/50 rounded-2xl px-4 py-2.5"></textarea>
                </div>
                
                {{-- CUSTOM SELECT: CHI NHÁNH (MANAGE) --}}
                <div class="flex items-center relative">
                    <label class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Chi nhánh <span class="text-red-500">*</span></label>
                    <div class="relative custom-multiselect flex-1" data-select-id="manage-branch-custom" data-type="single">
                        <select id="manage-branch-custom-hidden-select" class="hidden">
                            <option value="" disabled>Chọn chi nhánh...</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none">
                            <span class="custom-multiselect-display text-gray-500">Chọn chi nhánh...</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                @foreach($branches as $branch)
                                <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $branch->branch_id }}"><span class="text-sm text-gray-900">{{ $branch->branch_name }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- CUSTOM SELECT: TRẠNG THÁI (MANAGE) --}}
                <div class="flex items-center relative">
                    <label class="w-40 flex-shrink-0 text-sm font-medium text-gray-700">Trạng thái</label>
                    <div class="relative custom-multiselect flex-1" data-select-id="manage-status-custom" data-type="single">
                        <select id="manage-status-custom-hidden-select" class="hidden">
                            <option value="active">Đang hoạt động</option>
                            <option value="inactive">Nghỉ việc</option>
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none">
                            <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="active"><span class="text-sm text-gray-900">Đang hoạt động</span></li>
                                <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="inactive"><span class="text-sm text-gray-900">Nghỉ việc</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <button type="button" id="btn-delete-trainer" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg">Xóa HLV</button>
                <div class="flex space-x-4">
                    <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg">Hủy</button>
                    <button type="submit" class="px-8 py-2 bg-blue-500 text-white rounded-lg">Lưu thông tin</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<style>
    /* === CUSTOM STYLES CHO CUSTOM SELECT COMPONENT === */
    .custom-multiselect-option {
        @apply bg-white text-gray-900 transition-all duration-200 ease-in-out;
    }
    .custom-multiselect-option span {
        @apply text-gray-900;
    }

    /* 1. Màu HOVER (Cho mục CHƯA được chọn) */
    .custom-multiselect-option:hover:not(.bg-blue-100) {
        background-color: rgba(153, 153, 153, 0.2) !important; 
        color: #1a202c !important;
    }
    .custom-multiselect-option:hover:not(.bg-blue-100) span {
        color: #1a202c !important;
    }

    /* 2. Màu SELECTED (Cho mục ĐÃ được chọn) */
    .custom-multiselect-option.bg-blue-100 { 
        @apply bg-blue-100 text-gray-900;
        background-color: #DBEAFE !important; /* Màu xanh nhạt blue-100 */
        color: #1a202c !important;
    }
    .custom-multiselect-option.bg-blue-100 span { 
        color: #1a202c !important;
    }
</style>

<script>
    // --- 1. CUSTOM MULTISELECT LOGIC (Từ Code 1) ---
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

    // --- 2. MAIN APP LOGIC (Y chang Logic Code 2 cũ) ---
    document.addEventListener('DOMContentLoaded', function () {
        // Khởi tạo custom select ngay lập tức
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
            // Reset custom select UI
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
            
            // LOGIC CŨ: Gán thẳng giá trị từ data attribute vào input
            // (Vì ở Blade đã ép kiểu Y-m-d nên input date sẽ hiểu và hiện đúng)
            document.getElementById('manage-birth_date').value = d.birth_date || '';
            
            if(d.gender === 'Nữ') document.getElementById('manage-gender-female').checked = true;
            else document.getElementById('manage-gender-male').checked = true;

            document.getElementById('manage-specialty').value = d.specialty || '';
            document.getElementById('manage-experience_years').value = d.experience_years || 0;
            document.getElementById('manage-salary').value = d.salary || '';
            document.getElementById('manage-work_schedule_input').value = d.work_schedule || '';
            
            // Set value cho custom selects
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
            
            // SỬA LỖI: Gửi thẳng định dạng YYYY-MM-DD để Laravel validate thành công
            fd.append('dob', document.getElementById('add-birth_date').value);
            
            fd.append('specialty', document.getElementById('add-specialty').value);
            fd.append('experience_years', document.getElementById('add-experience_years').value);
            fd.append('salary', document.getElementById('add-salary').value);
            fd.append('work_schedule', document.getElementById('add-work_schedule').value);
            
            // Lấy value từ hidden select của custom dropdown
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
            
            // SỬA LỖI: Gửi thẳng định dạng YYYY-MM-DD
            fd.append('dob', document.getElementById('manage-birth_date').value);

            const pass = document.getElementById('manage-password').value;
            if(pass) fd.append('password', pass);

            fd.append('specialty', document.getElementById('manage-specialty').value);
            fd.append('experience_years', document.getElementById('manage-experience_years').value);
            fd.append('salary', document.getElementById('manage-salary').value);
            fd.append('work_schedule', document.getElementById('manage-work_schedule_input').value);
            
            // Lấy value từ hidden select của custom dropdown
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