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
        (object)['user_name' => 'Sơn Tùng MTP', 'registration_date' => '12/11/2025', 'status' => 'Hoàn thành'],
        (object)['user_name' => 'Trấn Thành', 'registration_date' => '12/11/2025', 'status' => 'Hoàn thành'],
        (object)['user_name' => 'Anh Tú', 'registration_date' => '12/11/2025', 'status' => 'Hoàn thành'],
        (object)['user_name' => 'Liên Bỉnh Phát', 'registration_date' => '12/11/2025', 'status' => 'Hoàn thành'],
        (object)['user_name' => 'Lan Ngọc', 'registration_date' => '12/11/2025', 'status' => 'Hết hạn'],
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
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[20%]">Tên lớp</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Loại lớp</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Sĩ số tối đa</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[25%]">Mô tả</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-[10%]">Danh sách</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase w-[15%]">Trạng thái</th>
                </tr>
            </thead>

            <tbody>
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
                        <div class="flex w-full rounded-lg items-center
                                {{ $loop->even ? 'bg-white' : 'bg-[#1976D2]/10' }}
                                shadow-sm overflow-hidden">
                            
                            {{-- Cột 1: Mã lớp (w-[10%]) --}}
                            <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900">
                                {{ $class->class_id }}
                            </div>

                            {{-- Cột 2: Tên lớp (w-[20%]) --}}
                            <div class="px-4 py-3 w-[20%] text-sm text-gray-700">
                                {{ $class->class_name }}
                            </div>

                            {{-- Cột 3: Loại lớp (w-[10%]) --}}
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700">
                                {{ $class->type }}
                            </div>

                            {{-- Cột 4: Sĩ số tối đa (w-[10%]) --}}
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700">
                                {{ $class->max_capacity }}
                            </div>

                            {{-- Cột 5: Mô tả (w-[25%]) --}}
                            <div class="px-4 py-3 w-[25%] text-sm text-gray-700 truncate" title="{{ $class->description }}">
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
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800">
                                        Đang hoạt động
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-gray-200 text-gray-800">
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
{{-- =================== HTML CHO CÁC MODAL (ĐÃ NÂNG CẤP) ============ --}}
{{-- ================================================================= --}}

{{-- ----------------- MODAL 1: THÊM LỚP (ĐÃ BỎ HLV) ----------------- --}}
<div id="addClassModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl">
        
        <h2 class="text-2xl font-bold text-center mb-6
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
            bg-clip-text text-transparent">
            THÊM LỚP
        </h2>
        
        <form>
            <div class="mb-4">
                <span class="text-lg font-semibold text-blue-700">Thông tin lớp</span>
            </div>

            <div class="flex space-x-6">
                {{-- Cột ảnh (Trái) --}}
                <div class="flex flex-col items-center w-32">
                    <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="add-image_url_preview" src="https://via.placeholder.com/128x128.png?text=Image" alt="Class image" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 w-full">
                        Upload ảnh
                    </button>
                    <input type="file" id="add-image_url" class="hidden">
                </div>

                {{-- Cột thông tin (Phải) --}}
                <div class="flex-1 flex flex-col space-y-4">
                    
                    {{-- Hàng Tên lớp --}}
                    <div class="flex items-center">
                        <label for="add-class_name" class="w-24 text-sm font-medium text-gray-700">Tên lớp</label>
                        <input type="text" id="add-class_name" value="AaaBbCcc" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    {{-- Hàng Loại lớp --}}
                    <div class="flex items-center">
                        <label for="add-type" class="w-24 text-sm font-medium text-gray-700">Loại lớp</label>
                        <div class="relative custom-multiselect flex-1" data-select-id="add-type" data-type="single">
                            <select id="add-type" class="hidden">
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
                    
                    {{-- Hàng Tên HLV (ĐÃ BỎ) --}}

                </div>
            </div>

            {{-- Hàng Mô tả --}}
            <div class="mt-4 flex items-start space-x-6">
                <label for="add-description" class="w-32 text-sm font-medium text-gray-700 pt-2.5">Mô tả</label>
                <textarea id="add-description" rows="4" class="flex-1 border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black resize-none">AaaBbCcc</textarea>
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

{{-- ----------------- MODAL 2: QUẢN LÝ (ĐÃ BỎ HLV) ----------------- --}}
<div id="manageClassModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl">
        
        <h2 class="text-2xl font-bold text-center mb-6
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
            bg-clip-text text-transparent">
            QUẢN LÝ DANH SÁCH LỚP
        </h2>
        
        <form>
            <div class="mb-4">
                <span class="text-lg font-semibold text-blue-700">Thông tin lớp</span>
            </div>

            <div class="flex space-x-6">
                {{-- Cột ảnh (Trái) --}}
                <div class="flex flex-col items-center w-32">
                    <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="manage-image_url_preview" src="https://via.placeholder.com/128x128.png?text=Image" alt="Class image" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 w-full">
                        Upload ảnh
                    </button>
                    <input type="file" id="manage-image_url" class="hidden">
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
                                <select id="manage-type" class="hidden">
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
                    
                    {{-- ĐÃ XÓA: Hàng Tên HLV --}}
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
                    <select id="manage-is_active" class="hidden">
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


{{-- ----------------- MODAL 3: DANH SÁCH NGƯỜI ĐĂNG KÝ (GIỮ NGUYÊN) ----------------- --}}
<div id="registrationsModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl">
        
        <h2 class="text-2xl font-bold text-center mb-6
            bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
            bg-clip-text text-transparent">
            DANH SÁCH NGƯỜI ĐĂNG KÝ
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
                <tbody>
                    @foreach($registrations as $reg)
                    <tr class="{{ $loop->even ? 'bg-white' : 'bg-blue-100/50' }}">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $reg->user_name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $reg->registration_date }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if ($reg->status == 'Hoàn thành')
                                <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800">
                                    Hoàn thành
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-gray-200 text-gray-800">
                                    Hết hạn
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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

{{-- ================================================================= --}}
{{-- =================== JAVASCRIPT (KHÔNG THAY ĐỔI) ================== --}}
{{-- ================================================================= --}}

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
// --- START: CUSTOM MULTISELECT SCRIPT ---

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
        // Hiển thị text
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
    const selectedValues = valuesString ? valuesString.split(delimiter) : [];
    
    // 1. Reset tất cả các lựa chọn cũ
    if (optionsList) { // Thêm kiểm tra null
        optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
            const highlightClass = li.dataset.highlightClass || 'bg-blue-100/50';
            li.classList.remove(highlightClass);
        });
    }
    // Bỏ chọn tất cả option trong select gốc
    Array.from(hiddenSelect.options).forEach(option => option.selected = false);


    // 2. Đặt các giá trị mới (so khớp bằng VALUE)
    selectedValues.forEach(value => {
        const trimmedValue = value.trim();
        
        const option = hiddenSelect.querySelector(`option[value="${trimmedValue}"]`);
        if (option) {
            option.selected = true;
        }
        
        if (optionsList) { // Thêm kiểm tra null
            const li = optionsList.querySelector(`.custom-multiselect-option[data-value="${trimmedValue}"]`);
            if (li) {
                const highlightClass = li.dataset.highlightClass || 'bg-blue-100/50';
                li.classList.add(highlightClass);
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
        
        if (displaySpan) {
            // Lưu lại placeholder gốc
            if (!displaySpan.dataset.placeholder) { // Chỉ đặt nếu chưa có
                displaySpan.dataset.placeholder = displaySpan.textContent;
            }
        }

        // 1. Mở/đóng dropdown
        if (trigger) {
            trigger.addEventListener('click', (e) => {
                e.stopPropagation();
                // Đóng tất cả các panel khác
                document.querySelectorAll('.custom-multiselect-panel').forEach(p => {
                    if (p !== panel) p.classList.add('hidden');
                });
                if (panel) { // Thêm kiểm tra null
                    panel.classList.toggle('hidden');
                }
            });
        }

        // 2. Xử lý khi chọn một mục
        if (optionsList) {
            optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
                li.addEventListener('click', (e) => {
                    e.stopPropagation();
                    
                    const value = li.dataset.value;
                    const option = hiddenSelect.querySelector(`option[value="${value}"]`);
                    const highlightClass = li.dataset.highlightClass || 'bg-blue-100/50';

                    if (container.dataset.type === 'single') {
                        // === LOGIC CHO SINGLE-SELECT ===
                        hiddenSelect.value = value;
                        // Bỏ highlight tất cả
                        optionsList.querySelectorAll('.custom-multiselect-option').forEach(otherLi => {
                            const otherHighlightClass = otherLi.dataset.highlightClass || 'bg-blue-100/50';
                            otherLi.classList.remove(otherHighlightClass);
                        });
                        // Highlight cái được chọn
                        li.classList.add(highlightClass);
                        if (panel) { // Thêm kiểm tra null
                            panel.classList.add('hidden'); // Tự động đóng
                        }
                    } else {
                        // === LOGIC CHO MULTI-SELECT ===
                        if(option) {
                            option.selected = !option.selected;
                            li.classList.toggle(highlightClass, option.selected);
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
                if (optionsList) { // Thêm kiểm tra null
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
        
        // Khởi tạo giá trị hiển thị ban đầu
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

// --- END: CUSTOM MULTISELECT SCRIPT ---


// --- SCRIPT QUẢN LÝ MODAL (ĐÃ CẬP NHẬT CHO LỚP HỌC) ---
document.addEventListener('DOMContentLoaded', function() {
    
    // Khởi tạo tất cả dropdown tùy chỉnh
    initializeCustomMultiselects();

    // Lấy các phần tử modal
    const addModal = document.getElementById('addClassModal');
    const manageModal = document.getElementById('manageClassModal');
    const registrationsModal = document.getElementById('registrationsModal');

    // Lấy các nút kích hoạt
    const openAddBtn = document.getElementById('openAddModalBtn');
    const classRows = document.querySelectorAll('tr.modal-trigger');
    const openRegButtons = document.querySelectorAll('.open-registrations-modal'); // Nút "Xem"

    // Lấy tất cả các nút đóng modal
    const closeTriggers = document.querySelectorAll('.close-modal');
    const modalContainers = document.querySelectorAll('.modal-container');

    // Hàm mở modal
    function openModal(modal) {
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    // Hàm đóng modal
    function closeModal(modal) {
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    // --- SỰ KIỆN MỞ MODAL ---

    // 1. Mở modal "Thêm lớp"
    if (openAddBtn) {
        openAddBtn.addEventListener('click', function() {
            // (Bạn có thể thêm logic reset form "Thêm" ở đây nếu muốn)
            openModal(addModal);
        });
    }

    // 2. Mở modal "Quản lý" khi nhấn vào DÒNG
    classRows.forEach(row => {
        row.addEventListener('click', function(e) {
            
            // Nếu click vào nút "Xem" (hoặc bất kỳ nút nào bên trong), thì dừng lại
            if (e.target.closest('button')) {
                e.stopPropagation();
                return;
            }

            const data = this.dataset;

            // Điền dữ liệu text/image (form "Quản lý")
            document.getElementById('manage-class_id').value = data.class_id;
            document.getElementById('manage-class_name').value = data.class_name;
            document.getElementById('manage-max_capacity').value = data.max_capacity;
            document.getElementById('manage-description').value = data.description;
            document.getElementById('manage-image_url_preview').src = data.image_url;

            // === SET GIÁ TRỊ CHO CUSTOM DROPDOWN ===
            
            // Set single-select cho Loại lớp
            const typeContainer = document.querySelector('.custom-multiselect[data-select-id="manage-type"]');
            setCustomMultiselectValues(typeContainer, data.type, ',');

            // Trainer ID đã bị loại bỏ khỏi modal/data-attribute, nên không cần set ở đây.

            // Set single-select cho Trạng thái
            const statusContainer = document.querySelector('.custom-multiselect[data-select-id="manage-is_active"]');
            setCustomMultiselectValues(statusContainer, data.is_active, ',');

            openModal(manageModal);
        });
    });

    // 3. Mở modal "Danh sách đăng ký" khi nhấn nút "Xem"
    openRegButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation(); // Ngăn sự kiện click lan ra <tr>
            // (Sau này bạn có thể thêm logic lấy data.class_id để fetch đúng danh sách)
            openModal(registrationsModal);
        });
    });


    // --- SỰ KIỆN ĐÓNG MODAL ---

    // 1. Đóng modal khi nhấn nút "Hủy" hoặc "Đóng"
    closeTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modal = this.closest('.modal-container');
            closeModal(modal);
        });
    });

    // 2. Đóng modal khi nhấn vào nền mờ
    modalContainers.forEach(container => {
        container.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this);
            }
        });
    });

    // 3. Đóng modal khi nhấn phím Escape
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
