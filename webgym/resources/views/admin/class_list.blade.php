@extends('layouts.ad_layout')

@section('title', 'Danh sách lớp học')

@section('content')

{{-- DỮ LIỆU DUMMY VÀ CONFIGS --}}
@php
    // Dữ liệu giả cho Lớp (ĐÃ XÓA trainer_id và trainer_name khỏi cấu trúc lớp)
    $classes = [
        (object)['class_id' => 'LO0001', 'class_name' => 'Lớp Yoga', 'type' => 'Yoga', 'max_capacity' => 20, 'description' => 'Nơi tâm trí tĩnh lặng và cơ thể được thả lỏng, thích hợp cho người mới bắt đầu.', 'is_active' => true, 'image_url' => 'https://via.placeholder.com/128x128.png?text=Yoga'],
        (object)['class_id' => 'LO0002', 'class_name' => 'Lớp Gym', 'type' => 'Gym', 'max_capacity' => 25, 'description' => 'Cảm nhận từng thớ cơ mạnh mẽ hơn với cường độ tập trung bình.', 'is_active' => true, 'image_url' => 'https://via.placeholder.com/128x128.png?text=Gym'],
        (object)['class_id' => 'LO0003', 'class_name' => 'Lớp Cardio', 'type' => 'Cardio', 'max_capacity' => 20, 'description' => 'Chinh phục sức bền của bạn, bao gồm các bài tập HIIT cường độ cao trong 45 phút.', 'is_active' => true, 'image_url' => 'https://via.placeholder.com/128x128.png?text=Cardio'],
        (object)['class_id' => 'LO0004', 'class_name' => 'Lớp Zumba', 'type' => 'Zumba', 'max_capacity' => 30, 'description' => 'Vừa tập vừa vui, đốt mỡ cực nhanh.', 'is_active' => false, 'image_url' => 'https://via.placeholder.com/128x128.png?text=Zumba'],
        (object)['class_id' => 'LO0005', 'class_name' => 'Lớp Boxing', 'type' => 'Boxing', 'max_capacity' => 25, 'description' => 'Giải tỏa căng thẳng cực đã. Tập luyện kỹ thuật đấm bốc và phản xạ.', 'is_active' => true, 'image_url' => 'https://via.placeholder.com/128x128.png?text=Boxing'],
    ];

    // Dữ liệu giả cho Popup Danh sách đăng ký (Giữ nguyên)
    $registrations = [
        'LO0001' => [ // Yoga
            (object)['user_name' => 'Sơn Tùng MTP', 'registration_date' => '12/11/2025', 'status' => 'Hoàn thành'],
            (object)['user_name' => 'Lan Ngọc', 'registration_date' => '12/11/2025', 'status' => 'Hết hạn'],
        ],
        'LO0002' => [ // Gym
            (object)['user_name' => 'Trấn Thành', 'registration_date' => '12/11/2025', 'status' => 'Hoàn thành'],
            (object)['user_name' => 'Anh Tú', 'registration_date' => '12/11/2025', 'status' => 'Hoàn thành'],
        ],
        'LO0003' => [], // Cardio
        'LO0004' => [
            (object)['user_name' => 'Liên Bỉnh Phát', 'registration_date' => '12/11/2025', 'status' => 'Hoàn thành'],
        ],
        'LO0005' => [], // Boxing
    ];
    
    // Dữ liệu cho các dropdown
    $class_types = ['Yoga', 'Gym', 'Cardio', 'Zumba', 'Boxing'];
    $status_options = [ '1' => 'Đang hoạt động', '0' => 'Dừng hoạt động'];

@endphp

{{-- Header --}}
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
        Thêm lớp
    </button>
</div>

{{-- Bảng danh sách lớp --}}
<div class="bg-white p-6 rounded-lg shadow-xl">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Danh sách lớp học</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border-separate border-spacing-y-2">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Mã lớp</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[15%]">Tên lớp</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Loại lớp</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Sĩ số tối đa</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[30%]">Mô tả</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-[10%]">Danh sách</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase w-[15%]">Trạng thái</th>
                </tr>
            </thead>

            <tbody id="class-list-body"> {{-- THÊM ID CHO TBODY --}}
                @foreach ($classes as $class)
                <tr class="transition duration-150 cursor-pointer modal-trigger"
                    data-class_id="{{ $class->class_id }}"
                    data-class_name="{{ $class->class_name }}"
                    data-type="{{ $class->type }}"
                    data-max_capacity="{{ $class->max_capacity }}"
                    data-description="{{ $class->description }}"
                    data-is_active="{{ $class->is_active ? '1' : '0' }}"
                    data-image_url="{{ $class->image_url }}">
                    
                    <td colspan="7" class="p-0"> 
                        <div class="class-row-content flex w-full rounded-lg items-center
                                {{ $loop->even ? 'bg-white' : 'bg-[#1976D2]/10' }}
                                shadow-sm overflow-hidden">
                            
                            {{-- Cột 1: Mã lớp (w-[10%]) --}}
                            <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900 class-id-display">
                                {{ $class->class_id }}
                            </div>

                            {{-- Cột 2: Tên lớp (w-[15%]) --}}
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700 class-name-display">
                                {{ $class->class_name }}
                            </div>

                            {{-- Cột 3: Loại lớp (w-[10%]) --}}
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700 class-type-display">
                                {{ $class->type }}
                            </div>

                            {{-- Cột 4: Sĩ số tối đa (w-[10%]) --}}
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700 class-capacity-display">
                                {{ $class->max_capacity }}
                            </div>

                            {{-- Cột 5: Mô tả (w-[30%]) --}}
                            <div class="px-4 py-3 w-[30%] text-sm text-gray-700 truncate class-description-display" title="{{ $class->description }}">
                                {{ $class->description }}
                            </div>

                            {{-- CỘT 6: NÚT DANH SÁCH (w-[10%]) --}}
                            <div class="px-4 py-3 w-[10%] text-sm text-center">
                                <button type="button"
                                        class="px-4 py-1 bg-blue-500 text-white rounded-md text-sm font-medium hover:bg-blue-600 open-registrations-modal">
                                    Xem
                                </button>
                            </div>

                            {{-- CỘT 7: Trạng thái (w-[15%]) --}}
                            <div class="px-4 py-3 w-[15%] text-sm text-right">
                                @if ($class->is_active)
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800 class-status-badge" data-status-id="1">
                                        Đang hoạt động
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-gray-200 text-gray-800 class-status-badge" data-status-id="0">
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
    </div>
</div>

{{-- ================================================================= --}}
{{-- =================== HTML CHO CÁC MODAL ============ --}}
{{-- ================================================================= --}}

{{-- ----------------- MODAL 1: THÊM LỚP ----------------- --}}
<div id="addClassModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl">
        
        <h2 class="text-2xl font-bold text-center mb-6
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
            bg-clip-text text-transparent">
            THÊM LỚP
            
        </h2>
        
        <form id="addClassForm"> {{-- THÊM ID CHO FORM --}}
            <div class="mb-4">
                <span class="text-lg font-semibold text-blue-700">Thông tin lớp</span>
            </div>

            <div class="flex space-x-6">
                {{-- Cột ảnh (Trái) --}}
                <div class="flex flex-col items-center w-32">
                    <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="add-image_url_preview" src="https://via.placeholder.com/128x128.png?text=Image" alt="Class image" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="add-upload-btn" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 w-full">
                        Upload ảnh
                    </button>
                    <input type="file" id="add-image_url_input" class="hidden" accept="image/*">
                    {{-- INPUT ẨN LƯU URL MOCK --}}
                    <input type="hidden" id="add-image_url" value="https://via.placeholder.com/128x128.png?text=New">
                </div>

                {{-- Cột thông tin (Phải) --}}
                <div class="flex-1 flex flex-col space-y-4">
                    
                    {{-- Hàng Tên lớp --}}
                    <div class="flex items-center">
                        <label for="add-class_name" class="w-24 text-sm font-medium text-gray-700">Tên lớp</label>
                        <input type="text" id="add-class_name" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    {{-- Hàng Loại lớp --}}
                    <div class="flex items-center">
                        <label for="add-type" class="w-24 text-sm font-medium text-gray-700">Loại lớp</label>
                        <div class="relative custom-multiselect flex-1" data-select-id="add-type" data-type="single">
                            <select id="add-type" class="hidden">
                                <option value="" selected disabled>Chọn loại lớp...</option>
                                @foreach($class_types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                                <span class="custom-multiselect-display text-gray-500">Chọn loại lớp...</span>
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                    @foreach($class_types as $type)
                                    <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $type }}" data-highlight-class="bg-[#1976D2]/50">
                                        <span class="text-sm font-medium text-gray-900">{{ $type }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Hàng Sức chứa --}}
                    <div class="flex items-center">
                        <label for="add-max_capacity" class="w-24 text-sm font-medium text-gray-700">Sức chứa</label>
                        <input type="number" id="add-max_capacity" value="20" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                </div>
            </div>

            {{-- Hàng Mô tả --}}
            <div class="mt-4 flex items-start space-x-6">
                <label for="add-description" class="w-32 text-sm font-medium text-gray-700 pt-2.5">Mô tả</label>
                <textarea id="add-description" rows="4" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black resize-none"></textarea>
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

{{-- ----------------- MODAL 2: QUẢN LÝ ----------------- --}}
<div id="manageClassModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl">
        
        <h2 class="text-2xl font-bold text-center mb-6
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
            bg-clip-text text-transparent">
            QUẢN LÝ DANH SÁCH LỚP
        </h2>
        
        <form id="manageClassForm"> {{-- THÊM ID CHO FORM QUẢN LÝ --}}
            <div class="mb-4">
                <span class="text-lg font-semibold text-blue-700">Thông tin lớp</span>
            </div>

            <div class="flex space-x-6">
                {{-- Cột ảnh (Trái) --}}
                <div class="flex flex-col items-center w-32">
                    <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="manage-image_url_preview" src="https://via.placeholder.com/128x128.png?text=Image" alt="Class image" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="manage-upload-btn" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 w-full">
                        Upload ảnh
                    </button>
                    <input type="file" id="manage-image_url_input" class="hidden" accept="image/*">
                    {{-- INPUT ẨN LƯU URL MOCK --}}
                    <input type="hidden" id="manage-image_url_hidden"> 
                </div>

                {{-- Cột thông tin (Phải) --}}
                <div class="flex-1 flex flex-col space-y-4">
                    
                    {{-- Hàng ID --}}
                    <div class="flex items-center">
                        <label for="manage-class_id" class="w-24 text-sm font-medium text-gray-700">ID</label>
                        <input type="text" id="manage-class_id" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm bg-gray-100 px-4 py-2.5" readonly>
                    </div>

                    {{-- Hàng Tên lớp --}}
                    <div class="flex items-center">
                        <label for="manage-class_name" class="w-24 text-sm font-medium text-gray-700">Tên lớp</label>
                        <input type="text" id="manage-class_name" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    {{-- Hàng đặc biệt: Loại lớp + Sức chứa --}}
                    <div class="flex items-center space-x-4">
                        {{-- Mục Loại lớp --}}
                        <div class="flex items-center flex-1">
                            <label for="manage-type" class="w-24 text-sm font-medium text-gray-700">Loại lớp</label>
                            <div class="relative custom-multiselect flex-1" data-select-id="manage-type" data-type="single">
                                <select id="manage-type-select" class="hidden">
                                    <option value="" selected disabled>Chọn...</option>
                                    @foreach($class_types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                                    <span class="custom-multiselect-display text-gray-500">Chọn...</span>
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                                <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                    <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                        @foreach($class_types as $type)
                                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $type }}" data-highlight-class="bg-blue-500/50">
                                            <span class="text-sm font-medium text-gray-900">{{ $type }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- Mục Sức chứa --}}
                        <div class="flex items-center">
                            <label for="manage-max_capacity" class="text-sm font-medium text-gray-700 mr-2">Sức chứa</label>
                            <input type="number" id="manage-max_capacity" class="w-20 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Hàng Mô tả --}}
            <div class="mt-4 flex items-start space-x-6">
                <label for="manage-description" class="w-32 text-sm font-medium text-gray-700 pt-2.5">Mô tả</label>
                <textarea id="manage-description" rows="4" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black resize-none"></textarea>
            </div>

            {{-- Hàng Trạng thái --}}
            <div class="mt-4 flex items-center space-x-6">
                <label for="manage-is_active" class="w-32 text-sm font-medium text-gray-700">Trạng thái</label>
                <div class="relative custom-multiselect w-52" data-select-id="manage-is_active" data-type="single">
                    <select id="manage-is_active-select" class="hidden">
                               <option value="" selected disabled>Chọn trạng thái...</option>
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
                                <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $value }}" data-highlight-class="bg-blue-500/50">
                                    <span class="text-sm font-medium text-gray-900">{{ $label }}</span>
                                </li>
                            @endforeach
                        </ul>
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


{{-- ----------------- MODAL 3: DANH SÁCH NGƯỜI ĐĂNG KÝ (ĐÃ THÊM ID CHO TBODY) ----------------- --}}
<div id="registrationsModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl">
        
        <h2 class="text-2xl font-bold text-center mb-6
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
            bg-clip-text text-transparent">
            DANH SÁCH ĐĂNG KÝ LỚP <span id="registration-class-name"></span>
        </h2>
        
        <div class="max-h-[60vh] overflow-y-auto">
            <table class="min-w-full">
                {{-- Header Bảng --}}
                <thead class="sticky top-0 bg-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 w-[40%]">Tên</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 w-[30%]">Ngày đăng kí</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 w-[30%]">Trạng thái</th>
                    </tr>
                </thead>
                {{-- Dữ liệu Bảng --}}
                <tbody id="registration-list-body">
                    {{-- Dữ liệu sẽ được render bằng JS --}}
                </tbody>
            </table>
            <p id="no-registration-message" class="p-4 text-center text-gray-500 hidden">Chưa có ai đăng ký lớp này.</p>
        </div>

        {{-- Nút đóng --}}
        <div class="flex justify-center mt-8">
            <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                Đóng
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
/* === CUSTOM STYLES CHO CUSTOM SELECT COMPONENT (Dùng @apply Tailwind) === */

/* Màu Hover: Xám (#999999) 50% opacity */
.custom-multiselect-option:hover {
    @apply bg-[#999999]/50 text-gray-900; 
}
.custom-multiselect-option:hover span {
    @apply text-gray-900; 
}

/* Màu Selected: Xanh Blue 50% opacity */
.custom-multiselect-option.bg-blue-100 {
    @apply bg-blue-500/50 text-gray-900; 
}
.custom-multiselect-option.bg-blue-100 span {
    @apply text-gray-900; 
}

/* Khi hover lên mục đã chọn, áp dụng style hover xám 50% */
.custom-multiselect-option.bg-blue-100:hover {
    @apply bg-[#999999]/50 text-gray-900;
}

/* Đảm bảo trạng thái ban đầu của option */
.custom-multiselect-option {
    @apply bg-white text-gray-900;
}
</style>
<script>
// --- DỮ LIỆU MOCK TỪ PHP ---
const MOCK_CLASSES = @json($classes);
const MOCK_REGISTRATIONS_DATA = @json($registrations);
const MOCK_STATUS_OPTIONS = @json($status_options);
const CLASS_TYPES = @json($class_types);

// --- CƠ CHẾ QUẢN LÝ DỮ LIỆU ẢO ---
const DEFAULT_IMAGE = 'https://via.placeholder.com/128x128.png?text=Image';

let classMap = new Map();
MOCK_CLASSES.forEach(c => classMap.set(c.class_id, {
    ...c,
    is_active: c.is_active === true, // Đảm bảo là boolean
    registrations: MOCK_REGISTRATIONS_DATA[c.class_id] || [] // Thêm danh sách đăng ký vào Class Object
}));
let classIdCounter = 5; // LO0005 là ID lớn nhất hiện tại

// Hàm tạo ID lớp mới
function generateNewClassId() {
    classIdCounter++;
    return 'LO' + String(classIdCounter).padStart(4, '0');
}

// Hàm render một dòng đăng ký (cho modal 3)
function renderRegistrationRow(reg, index) {
    const isEven = index % 2 === 0;
    const isCompleted = reg.status === 'Hoàn thành';
    return `
        <tr class="${isEven ? 'bg-white' : 'bg-blue-100/50'}">
            <td class="px-4 py-3 text-sm text-gray-900">${reg.user_name}</td>
            <td class="px-4 py-3 text-sm text-gray-700">${reg.registration_date}</td>
            <td class="px-4 py-3 text-sm">
                <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full 
                    ${isCompleted ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800'}">
                    ${reg.status}
                </span>
            </td>
        </tr>
    `;
}

// Hàm render danh sách đăng ký (cho modal 3)
function renderRegistrationList(classData) {
    const listBody = document.getElementById('registration-list-body');
    const noMessage = document.getElementById('no-registration-message');
    const classTitle = document.getElementById('registration-class-name');

    classTitle.textContent = classData.class_name;
    listBody.innerHTML = '';

    if (classData.registrations && classData.registrations.length > 0) {
        let html = classData.registrations.map((reg, index) => renderRegistrationRow(reg, index)).join('');
        listBody.innerHTML = html;
        noMessage.classList.add('hidden');
    } else {
        noMessage.classList.remove('hidden');
    }
}

// Hàm cập nhật nội dung HTML của dòng hiện tại (dùng khi SỬA)
function updateClassRowContent(row, updatedData) {
    const rowContent = row.querySelector('.class-row-content');
    const isActive = updatedData.is_active === true || updatedData.is_active === '1'; // Phải dùng === '1' vì giá trị từ select là string
    const statusText = isActive ? MOCK_STATUS_OPTIONS['1'] : MOCK_STATUS_OPTIONS['0'];

    // Cập nhật data attributes trên dòng (quan trọng cho lần nhấp tiếp theo)
    row.dataset.class_name = updatedData.class_name;
    row.dataset.type = updatedData.type;
    row.dataset.max_capacity = updatedData.max_capacity;
    row.dataset.description = updatedData.description;
    row.dataset.is_active = isActive ? '1' : '0';
    row.dataset.image_url = updatedData.image_url; 

    // Cập nhật các cell hiển thị
    rowContent.querySelector('.class-name-display').textContent = updatedData.class_name;
    rowContent.querySelector('.class-type-display').textContent = updatedData.type;
    rowContent.querySelector('.class-capacity-display').textContent = updatedData.max_capacity;
    
    const descElement = rowContent.querySelector('.class-description-display');
    descElement.textContent = updatedData.description;
    descElement.title = updatedData.description; // Cập nhật tooltip

    const statusBadge = rowContent.querySelector('.class-status-badge');
    statusBadge.textContent = statusText;
    statusBadge.dataset.statusId = isActive ? '1' : '0';
    
    // Cập nhật class trạng thái
    if (isActive) {
        statusBadge.classList.remove('bg-gray-200', 'text-gray-800');
        statusBadge.classList.add('bg-green-100', 'text-green-800');
    } else {
        statusBadge.classList.remove('bg-green-100', 'text-green-800');
        statusBadge.classList.add('bg-gray-200', 'text-gray-800');
    }
}


// Hàm render một dòng lớp học mới vào bảng chính
function renderClassRow(classData, isEven) {
    const statusText = classData.is_active ? MOCK_STATUS_OPTIONS['1'] : MOCK_STATUS_OPTIONS['0'];
    const isActive = classData.is_active;
    
    const newRow = document.createElement('tr');
    newRow.classList.add('transition', 'duration-150', 'cursor-pointer', 'modal-trigger');
    
    // Đảm bảo gán data attributes cho dòng mới
    newRow.dataset.class_id = classData.class_id;
    newRow.dataset.class_name = classData.class_name;
    newRow.dataset.type = classData.type;
    newRow.dataset.max_capacity = classData.max_capacity;
    newRow.dataset.description = classData.description;
    newRow.dataset.is_active = isActive ? '1' : '0';
    newRow.dataset.image_url = classData.image_url;

    newRow.innerHTML = `
        <td colspan="7" class="p-0"> 
            <div class="class-row-content flex w-full rounded-lg items-center
                    ${isEven ? 'bg-white' : 'bg-[#1976D2]/10'}
                    shadow-sm overflow-hidden">
                
                <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900 class-id-display">${classData.class_id}</div>
                <div class="px-4 py-3 w-[15%] text-sm text-gray-700 class-name-display">${classData.class_name}</div>
                <div class="px-4 py-3 w-[10%] text-sm text-gray-700 class-type-display">${classData.type}</div>
                <div class="px-4 py-3 w-[10%] text-sm text-gray-700 class-capacity-display">${classData.max_capacity}</div>
                <div class="px-4 py-3 w-[30%] text-sm text-gray-700 truncate class-description-display" title="${classData.description}">${classData.description}</div>

                <div class="px-4 py-3 w-[10%] text-sm text-center">
                    <button type="button"
                            class="px-4 py-1 bg-blue-500 text-white rounded-md text-sm font-medium hover:bg-blue-600 open-registrations-modal">
                        Xem
                    </button>
                </div>

                <div class="px-4 py-3 w-[15%] text-sm text-right">
                    <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full ${isActive ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800'} class-status-badge" data-status-id="${isActive ? '1' : '0'}">
                        ${statusText}
                    </span>
                </div>
            </div>
        </td>
    `;

    // Gán sự kiện cho dòng mới và nút bên trong
    newRow.addEventListener('click', handleClassRowClick);
    newRow.querySelector('.open-registrations-modal').addEventListener('click', handleOpenRegistrationsClick); 

    return newRow;
}


// --- SCRIPT CUSTOM MULTISELECT (GIỮ NGUYÊN) ---

function updateMultiselectDisplay(multiselectContainer) {
    const hiddenSelect = multiselectContainer.querySelector('select');
    const displaySpan = multiselectContainer.querySelector('.custom-multiselect-display');
    const selectedOptions = Array.from(hiddenSelect.selectedOptions);
    
    if (selectedOptions.length === 0 || (selectedOptions.length === 1 && selectedOptions[0].value === "")) {
        const placeholder = displaySpan.dataset.placeholder || 'Chọn...';
        displaySpan.textContent = placeholder;
        displaySpan.classList.add('text-gray-500');
    } else {
        displaySpan.textContent = selectedOptions.map(opt => opt.text).join(', ');
        displaySpan.classList.remove('text-gray-500');
    }
}

function setCustomMultiselectValues(multiselectContainer, valuesString, delimiter = ',') {
    if (!multiselectContainer) return;

    const hiddenSelect = multiselectContainer.querySelector('select');
    const optionsList = multiselectContainer.querySelector('.custom-multiselect-list');
    const selectedValues = valuesString ? String(valuesString).split(delimiter).map(v => v.trim()) : []; 
    
    // Xóa tất cả các lựa chọn hiện tại trên UI và logic
    if (optionsList) { 
        optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
            const highlightClass = li.dataset.highlightClass || 'bg-blue-100/50';
            li.classList.remove(highlightClass);
        });
    }
    Array.from(hiddenSelect.options).forEach(option => option.selected = false);

    // Set các giá trị mới
    selectedValues.forEach(value => {
        const trimmedValue = value.trim();
        
        const option = hiddenSelect.querySelector(`option[value="${trimmedValue}"]`);
        if (option) {
            option.selected = true;
        }
        
        if (optionsList) { 
            const li = optionsList.querySelector(`.custom-multiselect-option[data-value="${trimmedValue}"]`);
            if (li) {
                const highlightClass = li.dataset.highlightClass || 'bg-blue-100/50';
                li.classList.add(highlightClass);
            }
        }
    });

    updateMultiselectDisplay(multiselectContainer);
}

function initializeCustomMultiselects() {
    document.querySelectorAll('.custom-multiselect').forEach(container => {
        const trigger = container.querySelector('.custom-multiselect-trigger');
        const panel = container.querySelector('.custom-multiselect-panel');
        const optionsList = container.querySelector('.custom-multiselect-list');
        const hiddenSelect = container.querySelector('select');
        const displaySpan = container.querySelector('.custom-multiselect-display');
        
        if (displaySpan) {
            if (!displaySpan.dataset.placeholder) { 
                displaySpan.dataset.placeholder = displaySpan.textContent;
            }
        }

        if (trigger) {
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                document.querySelectorAll('.custom-multiselect-panel').forEach(p => {
                    if (p !== panel) p.classList.add('hidden');
                });
                if (panel) { 
                    panel.classList.toggle('hidden');
                }
            });
        }

        if (optionsList) {
            optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
                li.addEventListener('click', (e) => {
                    e.stopPropagation();
                    
                    const value = li.dataset.value;
                    const highlightClass = li.dataset.highlightClass || 'bg-blue-100/50';

                    if (container.dataset.type === 'single') {
                        // Set giá trị trong select ẩn
                        const option = hiddenSelect.querySelector(`option[value="${value}"]`);
                        Array.from(hiddenSelect.options).forEach(opt => opt.selected = false);
                        if(option) option.selected = true;

                        optionsList.querySelectorAll('.custom-multiselect-option').forEach(otherLi => {
                            const otherHighlightClass = otherLi.dataset.highlightClass || 'bg-blue-100/50';
                            otherLi.classList.remove(otherHighlightClass);
                        });
                        li.classList.add(highlightClass);
                        if (panel) { 
                            panel.classList.add('hidden'); 
                        }
                    } 
                    
                    updateMultiselectDisplay(container);
                });
            });
        }
        
        updateMultiselectDisplay(container);
    });
}

document.addEventListener('click', (e) => {
    if (!e.target.closest('.custom-multiselect')) {
        document.querySelectorAll('.custom-multiselect-panel').forEach(panel => {
            panel.classList.add('hidden');
        });
    }
});


// --- SCRIPT CHÍNH CHO LOGIC ỨNG DỤNG ---

// Khai báo các hàm xử lý sự kiện ở phạm vi toàn cục hoặc trên phạm vi addEventListener để có thể được gọi bởi các element render động.
function handleClassRowClick(e) {
    // Ngăn chặn mở modal quản lý nếu nhấn vào nút "Xem"
    if (e.target.closest('button')) {
        e.stopPropagation();
        return;
    }

    const row = this;
    const data = row.dataset;
    const manageModal = document.getElementById('manageClassModal');

    // Điền dữ liệu text/image (form "Quản lý")
    document.getElementById('manage-class_id').value = data.class_id;
    document.getElementById('manage-class_name').value = data.class_name;
    document.getElementById('manage-max_capacity').value = data.max_capacity;
    document.getElementById('manage-description').value = data.description;
    
    // Ảnh
    const imageUrl = data.image_url || DEFAULT_IMAGE;
    document.getElementById('manage-image_url_preview').src = imageUrl;
    document.getElementById('manage-image_url_hidden').value = imageUrl;

    // Set single-select cho Loại lớp (ID của select ẩn: manage-type-select)
    const typeContainer = document.querySelector('.custom-multiselect[data-select-id="manage-type"]');
    setCustomMultiselectValues(typeContainer, data.type, ',');

    // Set single-select cho Trạng thái (ID của select ẩn: manage-is_active-select)
    const statusContainer = document.querySelector('.custom-multiselect[data-select-id="manage-is_active"]');
    setCustomMultiselectValues(statusContainer, data.is_active, ',');

    openModal(manageModal);
}

function handleOpenRegistrationsClick(e) {
    e.stopPropagation(); 
    const row = this.closest('tr.modal-trigger');
    const classId = row.dataset.class_id;
    const classData = classMap.get(classId); // Lấy data từ Map dữ liệu ảo
    const registrationsModal = document.getElementById('registrationsModal');

    if (classData) {
          renderRegistrationList(classData);
          openModal(registrationsModal);
    } else {
        // Dùng dữ liệu trống cho lớp mới chưa có trong MOCK_REGISTRATIONS_DATA ban đầu
        renderRegistrationList({class_name: row.dataset.class_name, registrations: []});
        openModal(registrationsModal);
    }
}

// **ĐÃ SỬA DÒNG NÀY**
function openModal(modal) {
    if (modal) {
        // *** DÒNG ĐÃ SỬA: Đảm bảo thêm class 'flex' để căn giữa ***
        modal.classList.remove('hidden');
        modal.classList.add('flex'); 
        // *************************************************************
        modal.querySelector(':scope > div').focus();
    }
}

// **ĐÃ SỬA DÒNG NÀY**
function closeModal(modal) {
    if (modal) {
        // **Quan trọng: Loại bỏ lớp 'flex' khi đóng**
        modal.classList.remove('flex'); 
        modal.classList.add('hidden');
    }
}

// Hàm xử lý Upload Ảnh
function handleImageUpload(inputElementId, previewElementId, hiddenElementId) {
    const input = document.getElementById(inputElementId);
    const preview = document.getElementById(previewElementId);
    const hidden = document.getElementById(hiddenElementId);

    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                hidden.value = e.target.result; // Lưu Base64 URL vào input ẩn
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    
    initializeCustomMultiselects();

    // Lấy các phần tử modal
    const addModal = document.getElementById('addClassModal');
    const manageModal = document.getElementById('manageClassModal');
    const registrationsModal = document.getElementById('registrationsModal');

    // Lấy các form và tbody
    const addForm = document.getElementById('addClassForm');
    const manageForm = document.getElementById('manageClassForm');
    const classListBody = document.getElementById('class-list-body');


    // --- LOGIC UPLOAD ẢNH ---
    const addImageInput = document.getElementById('add-image_url_input');
    const addImagePreview = document.getElementById('add-image_url_preview');
    const addImageHidden = document.getElementById('add-image_url');
    const addUploadBtn = document.getElementById('add-upload-btn');

    const manageImageInput = document.getElementById('manage-image_url_input');
    const manageImagePreview = document.getElementById('manage-image_url_preview');
    const manageImageHidden = document.getElementById('manage-image_url_hidden');
    const manageUploadBtn = document.getElementById('manage-upload-btn');

    // Logic cho modal Thêm
    addUploadBtn.addEventListener('click', () => addImageInput.click());
    handleImageUpload('add-image_url_input', 'add-image_url_preview', 'add-image_url');

    // Logic cho modal Quản lý/Sửa
    manageUploadBtn.addEventListener('click', () => manageImageInput.click());
    handleImageUpload('manage-image_url_input', 'manage-image_url_preview', 'manage-image_url_hidden');


    // --- KHỞI TẠO SỰ KIỆN CHO CÁC DÒNG CÓ SẴN ---
    document.querySelectorAll('tr.modal-trigger').forEach(row => {
        row.addEventListener('click', handleClassRowClick);
    });
    
    document.querySelectorAll('.open-registrations-modal').forEach(button => {
        button.addEventListener('click', handleOpenRegistrationsClick);
    });


    // --- XỬ LÝ SỰ KIỆN SUBMIT FORM THÊM LỚP ---
    addForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const className = document.getElementById('add-class_name').value;
        const typeSelect = document.getElementById('add-type'); 
        const classType = typeSelect.value; 
        const maxCapacity = parseInt(document.getElementById('add-max_capacity').value) || 0;
        const description = document.getElementById('add-description').value;
        const imageUrl = addImageHidden.value; // Lấy URL từ input ẩn

        if (!className || !classType || maxCapacity <= 0) {
            alert('Vui lòng nhập Tên lớp, chọn Loại lớp và Sức chứa (> 0).');
            return;
        }

        const newClass = {
            class_id: generateNewClassId(),
            class_name: className,
            type: classType, 
            max_capacity: maxCapacity,
            description: description,
            is_active: true, 
            image_url: imageUrl,
            registrations: [], 
        };

        // 1. Cập nhật Map dữ liệu ảo
        classMap.set(newClass.class_id, newClass);

        // 2. Render và chèn dòng mới vào **đầu** bảng
        const isEven = (classListBody.children.length % 2 !== 0); 
        const newRow = renderClassRow(newClass, isEven); 
        classListBody.prepend(newRow); 
        
        // 3. Đóng modal và reset form
        closeModal(addModal);
        addForm.reset();
        setCustomMultiselectValues(document.querySelector('.custom-multiselect[data-select-id="add-type"]'), ''); 
        addImagePreview.src = DEFAULT_IMAGE;
        addImageHidden.value = DEFAULT_IMAGE; // Reset hidden input
        
        console.log(`Đã thêm lớp học: ${className} (ID: ${newClass.class_id})`);
        alert(`Đã thêm lớp học: ${className} (ID: ${newClass.class_id})`);
    });
    
    // --- XỬ LÝ SỰ KIỆN SUBMIT FORM SỬA LỚP ---
    manageForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const classId = document.getElementById('manage-class_id').value;
        const row = document.querySelector(`tr[data-class_id="${classId}"]`);

        if (!row) {
            alert('Không tìm thấy lớp để cập nhật.');
            return;
        }

        const className = document.getElementById('manage-class_name').value;
        const typeSelect = document.getElementById('manage-type-select');
        const classType = typeSelect.value;
        const maxCapacity = parseInt(document.getElementById('manage-max_capacity').value) || 0;
        const description = document.getElementById('manage-description').value;
        const isActiveSelect = document.getElementById('manage-is_active-select');
        const isActive = isActiveSelect.value;
        const imageUrl = document.getElementById('manage-image_url_hidden').value; // Lấy URL từ input ẩn

        if (!className || !classType || maxCapacity <= 0) {
            alert('Vui lòng nhập Tên lớp, chọn Loại lớp và Sức chứa (> 0).');
            return;
        }
        
        // Lấy object hiện tại để giữ lại registrations
        const currentClassData = classMap.get(classId) || {};

        const updatedData = {
            class_id: classId,
            class_name: className,
            type: classType,
            max_capacity: maxCapacity,
            description: description,
            is_active: isActive === '1', // Chuyển lại thành boolean
            image_url: imageUrl,
            registrations: currentClassData.registrations || [],
        };

        // 1. Cập nhật Map dữ liệu ảo
        classMap.set(classId, updatedData);

        // 2. Cập nhật nội dung hiển thị trên bảng
        updateClassRowContent(row, updatedData);

        // 3. Đóng modal
        closeModal(manageModal);
        alert(`Đã lưu thông tin cập nhật cho lớp ${classId} - ${updatedData.class_name}.`);
    });
    
    // --- LOGIC MỞ/ĐÓNG MODAL CHUNG (ĐÃ SỬA) ---

    const openAddBtn = document.getElementById('openAddModalBtn');
    if (openAddBtn) {
        openAddBtn.addEventListener('click', function() {
            // Reset form thêm khi mở
            addForm.reset();
            setCustomMultiselectValues(document.querySelector('.custom-multiselect[data-select-id="add-type"]'), '');
            addImagePreview.src = DEFAULT_IMAGE;
            addImageHidden.value = 'https://via.placeholder.com/128x128.png?text=New';
            openModal(addModal);
        });
    }

    const closeTriggers = document.querySelectorAll('.close-modal');
    const modalContainers = document.querySelectorAll('.modal-container');

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
            closeModal(registrationsModal);
        }
    });

});
</script>

@endpush
