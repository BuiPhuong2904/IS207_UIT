@extends('layouts.ad_layout')

@section('title', 'Quản lý cửa hàng')

@section('content')

@php
// Dữ liệu mẫu (Đã làm sạch ký tự khoảng trắng không hợp lệ)
// **SỬA ĐỔI: Thêm ID cho Biến thể (variant_id) để mô phỏng dữ liệu thực tế**
$products = [
    (object)[
        'product_id' => 'SP0001', 'product_name' => 'Cục tạ', 'category_id' => 'CAT01', 'brand' => 'Brand A', 'origin' => 'Việt Nam',
        'image_url' => 'https://via.placeholder.com/80x60/F0E68C/000000?text=Ta', 'status' => 'active',
        // THÊM: variant_id, color, size, price, stock, promo, promo_price, weight, unit, image_url (giả)
        'variants' => [
            (object)['variant_id' => 'BT0001', 'name' => 'Xanh/2kg', 'color' => 'Xanh', 'size' => 'k', 'price' => 120000, 'stock' => 100, 'promo' => 'Không', 'promo_price' => 0, 'weight' => 2, 'unit' => 'kg', 'status' => 'active', 'image_url' => 'https://via.placeholder.com/160x160/F0E68C/000000?text=Ta+Xanh'],
            (object)['variant_id' => 'BT0002', 'name' => 'Đỏ/2kg', 'color' => 'Đỏ', 'size' => 'k', 'price' => 125000, 'stock' => 50, 'promo' => 'Có', 'promo_price' => 112500, 'weight' => 2, 'unit' => 'kg', 'status' => 'active', 'image_url' => 'https://via.placeholder.com/160x160/FF6347/FFFFFF?text=Ta+Do'],
        ],
        'description' => 'Mô tả cho cục tạ 1...', 'slug' => 'cuc-ta-1'
    ],

    (object)[
        'product_id' => 'SP0002', 'product_name' => 'Bóng tập Yoga', 'category_id' => 'CAT01', 'brand' => 'Brand A', 'origin' => 'Trung Quốc',
        'image_url' => 'https://via.placeholder.com/80x60/2E8B57/FFFFFF?text=Bong', 'status' => 'active',
        // THÊM: variant_id, color, size, price, stock, promo, promo_price, weight, unit, image_url (giả)
        'variants' => [
            (object)['variant_id' => 'BT0003', 'name' => 'Xanh/5kg', 'color' => 'Xanh', 'size' => 'l', 'price' => 250000, 'stock' => 80, 'promo' => 'Không', 'promo_price' => 0, 'weight' => 5, 'unit' => 'kg', 'status' => 'active', 'image_url' => 'https://via.placeholder.com/160x160/2E8B57/FFFFFF?text=Bong+Xanh'],
            (object)['variant_id' => 'BT0004', 'name' => 'Vàng/5kg', 'color' => 'Vàng', 'size' => 'l', 'price' => 250000, 'stock' => 70, 'promo' => 'Có', 'promo_price' => 200000, 'weight' => 5, 'unit' => 'kg', 'status' => 'active', 'image_url' => 'https://via.placeholder.com/160x160/FFD700/000000?text=Bong+Vang'],
            (object)['variant_id' => 'BT0005', 'name' => 'Đen/10kg', 'color' => 'Đen', 'size' => 'm', 'price' => 500000, 'stock' => 20, 'promo' => 'Có', 'promo_price' => 400000, 'weight' => 10, 'unit' => 'kg', 'status' => 'active', 'image_url' => 'https://via.placeholder.com/160x160/000000/FFFFFF?text=Bong+Den'],
        ],
        'description' => 'Mô tả cho bóng tập...', 'slug' => 'bong-tap'
    ],
    (object)[
        'product_id' => 'SP0003', 'product_name' => 'Khăn Microfiber', 'category_id' => 'CAT02', 'brand' => 'Brand B', 'origin' => 'Việt Nam',
        'image_url' => 'https://via.placeholder.com/80x60/98FB98/000000?text=Khan', 'status' => 'active',
        'variants' => [
            (object)['variant_id' => 'BT0006', 'name' => 'Xanh/1kg', 'color' => 'Xanh', 'size' => 'l', 'price' => 50000, 'stock' => 200, 'promo' => 'Không', 'promo_price' => 0, 'weight' => 1, 'unit' => 'kg', 'status' => 'active', 'image_url' => 'https://via.placeholder.com/160x160/98FB98/000000?text=Khan+Xanh'],
        ],
        'description' => 'Mô tả cho khăn...', 'slug' => 'khan-tap'
    ],
    (object)[
        'product_id' => 'SP0005', 'product_name' => 'Bình nước giữ nhiệt', 'category_id' => 'CAT03', 'brand' => 'Brand C', 'origin' => 'Hàn Quốc',
        'image_url' => 'https://via.placeholder.com/80x60/FFB6C1/000000?text=Binh', 'status' => 'inactive',
        'variants' => [
            (object)['variant_id' => 'BT0007', 'name' => 'Hồng/1kg', 'color' => 'Hồng', 'size' => 'l', 'price' => 300000, 'stock' => 0, 'promo' => 'Không', 'promo_price' => 0, 'weight' => 1, 'unit' => 'kg', 'status' => 'inactive', 'image_url' => 'https://via.placeholder.com/160x160/FFB6C1/000000?text=Binh+Hong'],
        ],
        'description' => 'Mô tả cho bình nước...', 'slug' => 'binh-nuoc'
    ],
];

$categories = [ 'CAT01' => 'Dụng cụ tập', 'CAT02' => 'Phụ kiện', 'CAT03' => 'Đồ dùng khác' ];
$brands = [ 'Brand A' => 'Brand A', 'Brand B' => 'Brand B', 'Brand C' => 'Brand C' ];
$statuses = [ 'active' => 'Còn hàng', 'inactive' => 'Hết hàng' ];

$variant_colors = ['Vàng', 'Xanh', 'Trắng', 'Hồng', 'Đỏ', 'Đen'];
$variant_sizes = ['k', 'l', 'm'];
// SỬA: Thay thế danh sách khuyến mãi bằng Có/Không
$variant_promos = ['Có', 'Không']; 
@endphp

{{-- Header (Giữ nguyên) --}}
<div class="flex justify-between items-center mb-6">
    {{-- Thanh tìm kiếm --}}
    <div class="flex-1 max-w-md">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" class="w-full pl-10 pr-4 py-2.5 border border-[#999999]/50 rounded-2xl shadow-sm focus:outline-none focus:ring-1 focus:ring-black" placeholder="Tìm kiếm ...">
        </div>
    </div>

    <div class="flex items-center">
        <div class="flex items-center space-x-3 text-sm text-gray-500 mr-4">
            <span class="font-medium">Hôm nay</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        {{-- NÚT THÊM SẢN PHẨM --}}
        <button id="openAddProductModalBtn"
            class="flex items-center px-4 py-2 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 transition-colors duration-150 shadow-md">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v16m8-8H4"></path>
            </svg>
            Thêm
        </button>
    </div>
</div>

{{-- Bảng danh sách Cửa hàng ONLINE (ĐÃ THÊM ID CHO TBODY) --}}
<div class="bg-white p-6 rounded-lg shadow-xl">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Cửa hàng ONLINE</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border-separate border-spacing-y-2">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Mã sản phẩm</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[15%]">Tên sản phẩm</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Loại</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Thương hiệu</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Nguồn gốc</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-[10%]">Hình</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase flex-1">Biến thể</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase w-[12%]">Trạng thái</th>
                </tr>
            </thead>

            <tbody id="product-list-body">
                @foreach ($products as $product)
                {{-- ĐÃ SỬA: Thay đổi data-status sang data-product_status để tránh nhầm lẫn --}}
                <tr class="transition duration-150 cursor-pointer product-row-trigger"
                    data-product_id="{{ $product->product_id }}"
                    data-product_name="{{ $product->product_name }}"
                    data-category_id="{{ $product->category_id }}"
                    data-origin="{{ $product->origin }}"
                    data-brand="{{ $product->brand }}"
                    data-description="{{ $product->description }}"
                    data-product_status="{{ $product->status }}" 
                    data-slug="{{ $product->slug }}"
                    data-image_url="{{ $product->image_url }}"
                    data-variants='@json($product->variants)' {{-- CHUYỂN DỮ LIỆU BIẾN THỂ SANG JSON CHO JS --}}
                >
                    <td colspan="8" class="p-0">
                        <div class="flex w-full rounded-lg items-center
                                {{ $loop->even ? 'bg-white' : 'bg-[#1976D2]/10' }}
                                shadow-sm overflow-hidden">

                            <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900">
                                {{ $product->product_id }}
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700 product-name-display">
                                {{ $product->product_name }}
                            </div>
                            {{-- Hiển thị tên Loại --}}
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700">
                                {{ $categories[$product->category_id] ?? $product->category_id }}
                            </div>
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700">
                                {{ $product->brand }}
                            </div>
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700">
                                {{ $product->origin }}
                            </div>
                            <div class="px-4 py-3 w-[10%]">
                                <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" class="w-16 h-12 object-cover rounded-md product-image-display">
                            </div>

                            {{-- Biến thể (ĐÃ THÊM CLASS ĐỂ CẬP NHẬT DỄ HƠN) --}}
                            <div class="px-4 py-3 flex-1 text-sm text-gray-700 product-variants-display">
                                <div class="flex items-center space-x-2">
                                    <div class="flex flex-col variant-links-container">
                                        @foreach ($product->variants as $variant)
                                        <a href="#" class="text-purple-600 font-medium hover:underline open-variant-modal-trigger variant-link"
                                            data-product-id="{{ $product->product_id }}"
                                            data-variant-id="{{ $variant->variant_id }}" {{-- THÊM data-variant-id --}}
                                            data-mode="manage">
                                            {{ $variant->name }}
                                        </a>
                                        @endforeach
                                    </div>

                                    {{-- Nút Thêm (+) --}}
                                    <button class="open-variant-modal-trigger text-blue-500 hover:text-blue-700" data-product-id="{{ $product->product_id }}" data-mode="add">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <div class="px-4 py-3 w-[12%] text-sm text-right product-status-display">
                                @if ($product->status == 'active')
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-green-100 text-green-800 product-status-badge" data-status-id="active">
                                        Còn hàng
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-gray-200 text-gray-800 product-status-badge" data-status-id="inactive">
                                        Hết hàng
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
{{-- =================== HTML CHO CÁC MODAL (Giữ nguyên) ================= --}}
{{-- ================================================================= --}}

{{-- ----------------- MODAL 1: THÊM SẢN PHẨM (ĐÃ THÊM ID CHO FORM) ----------------- --}}
<div id="addProductModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl">

        <h2 class="text-3xl font-bold text-center mb-6
                bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
                bg-clip-text text-transparent">
            THÊM SẢN PHẨM
        </h2>

        <form>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Cột ảnh --}}
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="add-image_url_preview" src="https://via.placeholder.com/160x160.png?text=Image" alt="Product Image" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="add-image-upload-btn" class="flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Upload ảnh
                    </button>
                    <input type="file" id="add-image_url_input" class="hidden" accept="image/*">
                    {{-- THÊM INPUT ẨN CHO URL (DÙNG CHO MOCK DATA) --}}
                    <input type="hidden" id="add-image_url" value="https://via.placeholder.com/80x60/CCCCCC/000000?text=New">
                </div>

                {{-- Cột thông tin --}}
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <label for="add-product_name" class="block text-sm font-medium text-gray-700 mb-1">Tên SP</label>
                        <input type="text" id="add-product_name" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="add-category_id" class="block text-sm font-medium text-gray-700 mb-1">Tên loại</label>
                            <div class="relative custom-multiselect" data-select-id="add-category_id" data-type="single">
                                <select id="add-category_id" class="hidden">
                                    <option value="" selected disabled>Chọn loại...</option>
                                    @foreach($categories as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                                    <span class="custom-multiselect-display text-gray-500">Chọn loại...</span>
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                                </button>
                                <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                    <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                        @foreach($categories as $id => $name)
                                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $id }}" data-highlight-class="bg-blue-100/50">
                                            <span class="text-sm font-medium text-gray-900">{{ $name }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="add-origin" class="block text-sm font-medium text-gray-700 mb-1">Xuất xứ</label>
                            <input type="text" id="add-origin" value="Việt Nam" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div>
                        <label for="add-brand" class="block text-sm font-medium text-gray-700 mb-1">Thương hiệu</label>
                        <input type="text" id="add-brand" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-x-6 gap-y-4 items-start">
                {{-- Mô tả --}}
                <label for="add-description" class="col-span-2 block text-sm font-medium text-gray-700 whitespace-nowrap pr-2 pt-2.5">Mô tả</label>
                <div class="col-span-10">
                    <textarea id="add-description" rows="5" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
                </div>

                <div class="col-span-6"></div>
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

{{-- ----------------- MODAL 2: QUẢN LÝ SẢN PHẨM (ĐÃ THÊM ID CHO FORM) ----------------- --}}
<div id="manageProductModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl">

        <h2 class="text-3xl font-bold text-center mb-6
                bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
                bg-clip-text text-transparent">
            QUẢN LÝ CỬA HÀNG
        </h2>

        <form>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Cột ảnh --}}
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="manage-image_url_preview" src="https://via.placeholder.com/160x160.png?text=Image" alt="Product Image" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="manage-image-upload-btn" class="flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        Upload ảnh
                    </button>
                    <input type="file" id="manage-image_url_input" class="hidden" accept="image/*">
                    <input type="hidden" id="manage-image_url_hidden">
                </div>

                {{-- Cột thông tin --}}
                <div class="md:col-span-2 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="manage-product_id" class="block text-sm font-medium text-gray-700 mb-1">ID</label>
                            <input type="text" id="manage-product_id" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm bg-gray-100 px-4 py-2.5" readonly>
                        </div>
                        <div>
                            <label for="manage-product_name" class="block text-sm font-medium text-gray-700 mb-1">Tên SP</label>
                            <input type="text" id="manage-product_name" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="manage-category_id" class="block text-sm font-medium text-gray-700 mb-1">Tên loại</label>
                            <div class="relative custom-multiselect" data-select-id="manage-category_id" data-type="single">
                                <select id="manage-category_id" class="hidden">
                                       <option value="" selected disabled>Chọn loại...</option>
                                        @foreach($categories as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                </select>
                                <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                                    <span class="custom-multiselect-display text-gray-500">Chọn loại...</span>
                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                                </button>
                                <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                    <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                        @foreach($categories as $id => $name)
                                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $id }}" data-highlight-class="bg-blue-100/50">
                                            <span class="text-sm font-medium text-gray-900">{{ $name }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="manage-origin" class="block text-sm font-medium text-gray-700 mb-1">Xuất xứ</label>
                            <input type="text" id="manage-origin" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div>
                        <label for="manage-brand" class="block text-sm font-medium text-gray-700 mb-1">Thương hiệu</label>
                        <input type="text" id="manage-brand" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-x-6 gap-y-4 items-start">
                {{-- Mô tả --}}
                <label for="manage-description" class="col-span-2 block text-sm font-medium text-gray-700 whitespace-nowrap pr-2 pt-2.5">Mô tả</label>
                <div class="col-span-10">
                    <textarea id="manage-description" rows="5" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
                </div>

                {{-- Trạng thái --}}
                <label for="manage-status" class="col-span-2 block text-sm font-medium text-gray-700 whitespace-nowrap pr-2 pt-2.5">Trạng thái</label>
                <div class="relative custom-multiselect col-span-4" data-select-id="manage-status" data-type="single">
                    <select id="manage-status" class="hidden">
                           <option value="" selected disabled>Chọn trạng thái...</option>
                         @foreach($statuses as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                        <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                    </button>
                    <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                        <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                            @foreach($statuses as $id => $name)
                            <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $id }}" data-highlight-class="bg-blue-100/50">
                                <span class="text-sm font-medium text-gray-900">{{ $name }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-span-6"></div>
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

{{-- ----------------- MODAL 3: MODAL BIẾN THỂ ----------------- --}}
<div id="variantModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    {{-- Giữ max-w-7xl --}}
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-7xl">

        <div class="flex gap-8">

            {{-- === CỘT TRÁI: FORM (2-trong-1) - ĐÃ ĐỒNG BỘ INPUT WIDTH === --}}
            <div class="flex-1">

                {{-- === VIEW 1: QUẢN LÝ BIẾN THỂ (ĐÃ SỬA TOÀN BỘ GRID ĐỂ THẲNG HÀNG) === --}}
                <div id="manageVariantView">
                    <h2 class="text-3xl font-bold text-center mb-6
                                 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
                                 bg-clip-text text-transparent">
                        QUẢN LÝ BIẾN THỂ
                    </h2>

                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            {{-- Cột ảnh --}}
                            <div class="md:col-span-1 flex flex-col items-center">
                                <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                                    <img id="manage-variant-image-preview" src="https://via.placeholder.com/160x160.png?text=Image" alt="Variant Image" class="w-full h-full object-cover rounded-lg">
                                </div>
                                <button type="button" id="manage-variant-image-upload-btn" class="flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                    Upload ảnh
                                </button>
                                <input type="file" id="manage-variant-image-url-input" class="hidden" accept="image/*">
                                <input type="hidden" id="manage-variant-image-url">
                            </div>

                            {{-- Cột thông tin --}}
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-12 gap-x-6 gap-y-4 items-center">

                                    {{-- HÀNG 1: ID (Label 3 / Input 9) --}}
                                    <label for="manage-variant-id" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">ID</label>
                                    <input type="text" id="manage-variant-id" class="col-span-9 w-full border border-[#999999]/50 rounded-2xl shadow-sm bg-gray-100 px-4 py-2.5" readonly>

                                    {{-- HÀNG 2: Màu / Size (Label 3 / Input 3 | Label 3 / Input 3) --}}
                                    <label for="manage-variant-color" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Màu</label>
                                    <input type="text" id="manage-variant-color" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    <label for="manage-variant-size" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Size</label>
                                    <input type="text" id="manage-variant-size" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">

                                    {{-- HÀNG 3: Giá bán / Tồn kho (Label 3 / Input 3 | Label 3 / Input 3) --}}
                                    <label for="manage-variant-price" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Giá bán (VNĐ)</label>
                                    <input type="number" id="manage-variant-price" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    <label for="manage-variant-stock" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Tồn kho</label>
                                    <input type="number" id="manage-variant-stock" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">

                                    {{-- HÀNG 4: Áp dụng KM / Giá giảm (Label 3 / Dropdown 3 | Label 3 / Input 3) --}}
                                    <label for="manage-variant-promo" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Áp dụng KM</label>
                                    <div class="relative custom-multiselect col-span-3" data-select-id="manage-variant-promo" data-type="single">
                                        <select id="manage-variant-promo" class="hidden">
                                            <option value="Không" selected>Không</option>
                                            @foreach($variant_promos as $name)
                                                <option value="{{ $name }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                                            <span class="custom-multiselect-display text-gray-500">Chọn...</span>
                                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                                        </button>
                                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                                @foreach($variant_promos as $name)
                                                <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $name }}" data-highlight-class="bg-blue-100/50">
                                                    <span class="text-sm font-medium text-gray-900">{{ $name }}</span>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <label for="manage-variant-promo-price" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Giá giảm (VNĐ)</label>
                                    <input type="number" id="manage-variant-promo-price" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    
                                    {{-- HÀNG 5: Trọng lượng / Đơn vị tính (Label 3 / Input 3 | Label 3 / Input 3) --}}
                                    <label for="manage-variant-weight" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Trọng lượng</label>
                                    <input type="number" id="manage-variant-weight" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    <label for="manage-variant-unit" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Đơn vị tính</label>
                                    <input type="text" id="manage-variant-unit" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">

                                    {{-- HÀNG 6: Trạng thái (Label 3 / Dropdown 3 / Khoảng trống 6) --}}
                                    <label for="manage-variant-status" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Trạng thái</label>
                                    <div class="relative custom-multiselect col-span-3" data-select-id="manage-variant-status" data-type="single">
                                        <select id="manage-variant-status" class="hidden">
                                            <option value="" selected disabled>Chọn...</option>
                                            @foreach($statuses as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                                            <span class="custom-multiselect-display text-gray-500">Chọn...</span>
                                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                                        </button>
                                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                                @foreach($statuses as $id => $name)
                                                <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $id }}" data-highlight-class="bg-blue-100/50">
                                                    <span class="text-sm font-medium text-gray-900">{{ $name }}</span>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-span-6"></div>

                                </div>
                            </div>
                        </div>
                        {{-- Nút bấm --}}
                        <div class="flex justify-center space-x-4 mt-8">
                            <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">Hủy</button>
                            <button type="button" id="switchToAddeVariantBtn" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Thêm biến thể</button>
                            <button type="submit" class="px-8 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Lưu thông tin</button>
                        </div>
                    </form>
                </div>

                {{-- === VIEW 2: THÊM BIẾN THỂ === --}}
                <div id="addVariantView" class="hidden">
                    <h2 class="text-3xl font-bold text-center mb-6
                                 bg-gradient-to-r from-[#0D47A1] to-[#42A5F5]
                                 bg-clip-text text-transparent">
                        THÊM BIẾN THỂ
                    </h2>

                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            {{-- Cột ảnh --}}
                            <div class="md:col-span-1 flex flex-col items-center">
                                <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                                    <img id="add-variant-image-preview" src="https://via.placeholder.com/160x160.png?text=Image" alt="Variant Image" class="w-full h-full object-cover rounded-lg">
                                </div>
                                <button type="button" id="add-variant-image-upload-btn" class="flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                    Upload ảnh
                                </button>
                                <input type="file" id="add-variant-image-url-input" class="hidden" accept="image/*">
                                <input type="hidden" id="add-variant-image-url" value="https://via.placeholder.com/160x160.png?text=New+Variant">
                            </div>

                            {{-- Cột thông tin --}}
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-12 gap-x-6 gap-y-4 items-center">

                                    {{-- HÀNG 1: Màu / Size (Label 3 / Input 3 | Label 3 / Input 3) --}}
                                    <label for="add-variant-color" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Màu</label>
                                    <input type="text" id="add-variant-color" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    <label for="add-variant-size" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Size</label>
                                    <input type="text" id="add-variant-size" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">

                                    {{-- HÀNG 2: Giá bán / Tồn kho (Label 3 / Input 3 | Label 3 / Input 3) --}}
                                    <label for="add-variant-price" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Giá bán (VNĐ)</label>
                                    <input type="number" id="add-variant-price" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    <label for="add-variant-stock" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Tồn kho</label>
                                    <input type="number" id="add-variant-stock" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">

                                    {{-- HÀNG 3: Áp dụng KM / Giá giảm (Label 3 / Dropdown 3 | Label 3 / Input 3) --}}
                                    <label for="add-variant-promo" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Áp dụng KM</label>
                                    <div class="relative custom-multiselect col-span-3" data-select-id="add-variant-promo" data-type="single">
                                        <select id="add-variant-promo" class="hidden">
                                            <option value="Không" selected>Không</option>
                                            @foreach($variant_promos as $name)
                                                <option value="{{ $name }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                                            <span class="custom-multiselect-display text-gray-500">Chọn...</span>
                                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                                        </button>
                                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                                @foreach($variant_promos as $name)
                                                <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $name }}" data-highlight-class="bg-blue-100/50">
                                                    <span class="text-sm font-medium text-gray-900">{{ $name }}</span>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <label for="add-variant-promo-price" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Giá giảm (VNĐ)</label>
                                    <input type="number" id="add-variant-promo-price" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">

                                    {{-- HÀNG 4: Trọng lượng / Đơn vị tính (Label 3 / Input 3 | Label 3 / Input 3) --}}
                                    <label for="add-variant-weight" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Trọng lượng</label>
                                    <input type="number" id="add-variant-weight" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    <label for="add-variant-unit" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Đơn vị tính</label>
                                    <input type="text" id="add-variant-unit" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">

                                    {{-- THÊM HÀNG 5: Trạng thái --}}
                                    <label for="add-variant-status" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Trạng thái</label>
                                    <div class="relative custom-multiselect col-span-3" data-select-id="add-variant-status" data-type="single">
                                        <select id="add-variant-status" class="hidden">
                                            <option value="active" selected>Còn hàng</option>
                                            @foreach($statuses as $id => $name)
                                                <option value="{{ $id }}" {{ $id === 'active' ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-[#999999]/50 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-black">
                                            <span class="custom-multiselect-display text-gray-500">Chọn...</span>
                                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                                        </button>
                                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                                @foreach($statuses as $id => $name)
                                                <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $id }}" data-highlight-class="bg-blue-100/50">
                                                    <span class="text-sm font-medium text-gray-900">{{ $name }}</span>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-span-6"></div>

                                </div>
                            </div>

                        </div>
                        {{-- Nút bấm --}}
                        <div class="flex justify-center space-x-4 mt-8">
                            <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">Hủy</button>
                            <button type="button" id="switchBackToManageBtn" class="px-8 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Quay lại quản lý</button>
                            <button type="submit" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Thêm biến thể</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- === CỘT PHẢI: DANH SÁCH BIẾN THỂ (ĐÃ THÊM ID CHO CONTAINER) === --}}
            <div class="w-full max-w-[300px] h-full">
                <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">Các biến thể</h3>
                <div class="space-y-3 h-[500px] overflow-y-auto pr-2">

                    {{-- Item 1 (Xanh/2kg) --}}
                    <a href="#" class="block p-4 border rounded-lg shadow-sm hover:bg-gray-50 variant-list-item"
                        data-variant-id="BT0001"
                        data-color="Xanh"
                        data-size="k"
                        data-price="120000"
                        data-stock="100"
                        data-promo="Không"
                        data-promo-price="0"
                        data-weight="2"
                        data-unit="kg"
                        data-status="active"
                    >
                        <h4 class="font-bold text-gray-800">Xanh/2kg</h4>
                        <p class="text-sm text-gray-600">ID: BT0001</p>
                        <p class="text-sm text-gray-600">Màu: Xanh | Size: size k (2kg)</p>
                        <p class="text-sm text-gray-600">Giá bán: 120.000 VNĐ</p>
                        <p class="text-sm text-gray-600">Giá giảm: 0 VNĐ</p> {{-- GIÁ GIẢM CÙNG STYLE --}}
                    </a>

                    {{-- Item 2 (Đỏ/2kg) --}}
                    <a href="#" class="block p-4 border rounded-lg shadow-sm hover:bg-gray-50 variant-list-item"
                        data-variant-id="BT0002"
                        data-color="Đỏ"
                        data-size="k"
                        data-price="125000"
                        data-stock="50"
                        data-promo="Giảm 10%"
                        data-promo-price="112500"
                        data-weight="2"
                        data-unit="kg"
                        data-status="active"
                    >
                        <h4 class="font-bold text-gray-800">Đỏ/2kg</h4>
                        <p class="text-sm text-gray-600">ID: BT0002</p>
                        <p class="text-sm text-gray-600">Màu: Đỏ | Size: size k (2kg)</p>
                        <p class="text-sm text-gray-600">Giá bán: 125.000 VNĐ</p>
                        <p class="text-sm text-gray-600">Giá giảm: 112.500 VNĐ</p> {{-- GIÁ GIẢM CÙNG STYLE --}}
                    </a>

                    {{-- Item 3 (Biến thể thêm) --}}
                    <a href="#" class="block p-4 border rounded-lg shadow-sm hover:bg-gray-50 variant-list-item"
                        data-variant-id="BT0003"
                        data-color="Vàng"
                        data-size="l"
                        data-price="250000"
                        data-stock="80"
                        data-promo="Không"
                        data-promo-price="0"
                        data-weight="5"
                        data-unit="kg"
                        data-status="active"
                    >
                        <h4 class="font-bold text-gray-800">Vàng/5kg</h4>
                        <p class="text-sm text-gray-600">ID: BT0003</p>
                        <p class="text-sm text-gray-600">Giá bán: 250.000 VNĐ</p>
                        <p class="text-sm text-gray-600">Giá giảm: 0 VNĐ</p>
                    </a>

                    {{-- Item 4 (Biến thể thêm) --}}
                    <a href="#" class="block p-4 border rounded-lg shadow-sm hover:bg-gray-50 variant-list-item"
                        data-variant-id="BT0004"
                        data-color="Đen"
                        data-size="m"
                        data-price="500000"
                        data-stock="20"
                        data-promo="Giảm 20%"
                        data-promo-price="400000"
                        data-weight="10"
                        data-unit="kg"
                        data-status="active"
                    >
                        <h4 class="font-bold text-gray-800">Đen/10kg</h4>
                        <p class="text-sm text-gray-600">ID: BT0004</p>
                        <p class="text-sm text-gray-600">Giá bán: 500.000 VNĐ</p>
                        <p class="text-sm text-gray-600">Giá giảm: 400.000 VNĐ</p>
                    </a>

                    {{-- Item 5 (Biến thể thêm) --}}
                    <a href="#" class="block p-4 border rounded-lg shadow-sm hover:bg-gray-50 variant-list-item"
                        data-variant-id="BT0005"
                        data-color="Trắng"
                        data-size="k"
                        data-price="130000"
                        data-stock="60"
                        data-promo="Không"
                        data-promo-price="0"
                        data-weight="2"
                        data-unit="kg"
                        data-status="active"
                    >
                        <h4 class="font-bold text-gray-800">Trắng/2kg</h4>
                        <p class="text-sm text-gray-600">ID: BT0005</p>
                        <p class="text-sm text-gray-600">Giá bán: 130.000 VNĐ</p>
                        <p class="text-sm text-gray-600">Giá giảm: 0 VNĐ</p>
                    </a>

                </div>
            </div>

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

/* === BẮT ĐẦU: SCROLLBAR STYLES (#999999 - [50] | Đã loại bỏ lệnh ẩn hoàn toàn) === */
/* Kích thước và màu sắc cho WebKit (Chrome/Safari/Edge) */
.space-y-3.h-\[500px\].overflow-y-auto::-webkit-scrollbar,
#variant-sidebar-list::-webkit-scrollbar {
    width: 8px; /* Chiều rộng thanh cuộn dọc */
}
.space-y-3.h-\[500px\].overflow-y-auto::-webkit-scrollbar-track,
#variant-sidebar-list::-webkit-scrollbar-track {
    background: transparent; /* Nền của track */
}
.space-y-3.h-\[500px\].overflow-y-auto::-webkit-scrollbar-thumb,
#variant-sidebar-list::-webkit-scrollbar-thumb {
    /* Màu #999999 với độ mờ 50% (50/255 = 0.5) */
    background: rgba(153, 153, 153, 0.5);
    border-radius: 4px;
}
.space-y-3.h-\[500px\].overflow-y-auto::-webkit-scrollbar-thumb:hover,
#variant-sidebar-list::-webkit-scrollbar-thumb:hover {
    background: #777777; /* Màu khi hover (tăng độ đậm) */
}
/* === KẾT THÚC: SCROLLBAR STYLES === */

</style>
<script>
// Dữ liệu mock PHP được chuyển đổi thành JSON
const MOCK_PRODUCTS_DATA = @json($products);
const MOCK_CATEGORIES_DATA = @json($categories);
const MOCK_STATUS_DATA = @json($statuses);
const DEFAULT_IMAGE = 'https://via.placeholder.com/160x160.png?text=Image';

// Biến toàn cục để lưu trữ dữ liệu sản phẩm/biến thể (dạng Map để dễ truy cập)
let productMap = new Map();
let variantIdCounter = 7; // Bắt đầu từ BT0008 (BT0001-BT0007 đã dùng)
let productIdCounter = 5; // Bắt đầu từ SP0006 (SP0001-SP0005 đã dùng)

// Khởi tạo Map từ dữ liệu PHP
MOCK_PRODUCTS_DATA.forEach(product => {
    product.variants = product.variants.map(v => ({
        ...v,
        price: v.price / 1000, // Chuyển sang K (ví dụ)
        promo_price: v.promo_price / 1000 // Chuyển sang K (ví dụ)
    }));
    productMap.set(product.product_id, product);
});

// --- START: CUSTOM MULTISELECT SCRIPT (Giữ nguyên) ---

/**
 * Cập nhật văn bản hiển thị
 */
function updateMultiselectDisplay(multiselectContainer) {
    const hiddenSelect = multiselectContainer.querySelector('select');
    const displaySpan = multiselectContainer.querySelector('.custom-multiselect-display');
    const selectedOptions = Array.from(hiddenSelect.selectedOptions);

    // Đảm bảo placeholder
    const placeholder = displaySpan.dataset.placeholder || 'Chọn...';

    if (selectedOptions.length === 0 || (selectedOptions.length === 1 && selectedOptions[0].value === "")) {
        displaySpan.textContent = placeholder;
        displaySpan.classList.add('text-gray-500');
    } else {
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
    if (optionsList) {
        optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
            const highlightClass = li.dataset.highlightClass || 'bg-blue-100';
            li.classList.remove(highlightClass);
        });
    }
    Array.from(hiddenSelect.options).forEach(option => option.selected = false);

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
        const optionsList = container.querySelector('.custom-multiselect-list');
        const hiddenSelect = container.querySelector('select');
        const displaySpan = container.querySelector('.custom-multiselect-display');

        if (displaySpan) {
            displaySpan.dataset.placeholder = displaySpan.textContent;
        }

        // 1. Mở/đóng dropdown
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
                        // Cập nhật giá trị của select ẩn
                        Array.from(hiddenSelect.options).forEach(opt => {
                             opt.selected = (opt.value === value);
                        });

                        optionsList.querySelectorAll('.custom-multiselect-option').forEach(otherLi => {
                            const otherHighlightClass = otherLi.dataset.highlightClass || 'bg-blue-100/50';
                            otherLi.classList.remove(otherHighlightClass);
                        });
                        li.classList.add(highlightClass);
                        if (panel) {
                            panel.classList.add('hidden');
                        }
                    } else {
                        // === LOGIC CHO MULTI-SELECT ===
                        if(option) {
                            option.selected = !option.selected;
                            li.classList.toggle(highlightClass, option.selected);
                        }
                    }

                    updateMultiselectDisplay(container);

                    // KÍCH HOẠT EVENT NẾU CÓ THAY ĐỔI ĐỂ TẮT/BẬT INPUT GIÁ GIẢM
                    if (hiddenSelect.id.includes('-promo')) {
                          const event = new Event('change', { bubbles: true });
                          hiddenSelect.dispatchEvent(event);
                    }
                });
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


// --- SCRIPT QUẢN LÝ MODAL (ĐÃ CẬP NHẬT) ---
document.addEventListener('DOMContentLoaded', function() {

    initializeCustomMultiselects();

    const addProductModal = document.getElementById('addProductModal');
    const manageProductModal = document.getElementById('manageProductModal');
    const variantModal = document.getElementById('variantModal');

// Hàm tạo ID mới (tạm thời)
function generateNewId(prefix, counter) {
    return prefix + String(counter).padStart(4, '0');
}

// Hàm format tiền tệ (cho display)
function formatCurrency(amount) {
    if (typeof amount !== 'number') return '0 VNĐ';
    return amount.toLocaleString('vi-VN') + ' VNĐ';
}

// Hàm render một biến thể trong cột phải (sidebar)
function renderVariantListItem(variant, productId) {
    const promoPriceDisplay = formatCurrency(variant.promo_price * 1000); // Nhân 1000 lại để hiển thị
    const listItem = document.createElement('a');
    listItem.href = '#';
    listItem.classList.add('block', 'p-4', 'border', 'rounded-lg', 'shadow-sm', 'hover:bg-gray-50', 'variant-list-item');
    listItem.dataset.variantId = variant.variant_id;
    listItem.dataset.productId = productId;
    listItem.dataset.color = variant.color;
    listItem.dataset.size = variant.size;
    listItem.dataset.price = variant.price;
    listItem.dataset.stock = variant.stock;
    listItem.dataset.promo = variant.promo;
    listItem.dataset.promoPrice = variant.promo_price;
    listItem.dataset.weight = variant.weight;
    listItem.dataset.unit = variant.unit;
    listItem.dataset.status = variant.status;
    listItem.dataset.imageUrl = variant.image_url;

    // Gán sự kiện click cho item mới
    listItem.addEventListener('click', handleVariantListItemClick);

    listItem.innerHTML = `
        <h4 class="font-bold text-gray-800">${variant.name}</h4>
        <p class="text-sm text-gray-600">ID: ${variant.variant_id}</p>
        <p class="text-sm text-gray-600">Màu: ${variant.color} | Size: ${variant.size} (${variant.weight}${variant.unit})</p>
        <p class="text-sm text-gray-600">Giá bán: ${formatCurrency(variant.price * 1000)}</p>
        <p class="text-sm text-gray-600 variant-promo-price-display">Giá giảm: ${promoPriceDisplay}</p>
    `;
    return listItem;
}

// Hàm render lại danh sách biến thể trong modal (cột phải)
function renderVariantList(productId) {
    const listContainer = document.getElementById('variant-sidebar-list');
    listContainer.innerHTML = ''; // Xóa nội dung cũ

    const product = productMap.get(productId);
    if (product && product.variants) {
        document.getElementById('variant-product-name').textContent = product.product_name; // Cập nhật tên sản phẩm
        // Đảo ngược thứ tự để hiển thị biến thể mới nhất ở trên cùng
        [...product.variants].reverse().forEach(variant => {
            const listItem = renderVariantListItem(variant, productId);
            listContainer.appendChild(listItem);
        });
    } else {
        document.getElementById('variant-product-name').textContent = 'Không có sản phẩm';
    }
}

    // --- LOGIC CHO MODAL 3: BIẾN THỂ (PHỨC TẠP) ---

    function showVariantView(viewToShow) {
        if (viewToShow === 'add') {
            addVariantView.classList.remove('hidden');
            manageVariantView.classList.add('hidden');
            document.querySelector('#addVariantView form').reset();
            document.querySelectorAll('#addVariantView .custom-multiselect').forEach(sel => {
                setCustomMultiselectValues(sel, '');
            });
        } else if (viewToShow === 'manage') {
            addVariantView.classList.add('hidden');
            manageVariantView.classList.remove('hidden');
        }
    }

    function populateManageVariantForm(data) {
        // Điền input text
        document.getElementById('manage-variant-id').value = data.variantId || '';
        document.getElementById('manage-variant-price').value = data.price || '';
        document.getElementById('manage-variant-stock').value = data.stock || '';
        document.getElementById('manage-variant-promo-price').value = data.promoPrice || '';
        document.getElementById('manage-variant-weight').value = data.weight || '';
        document.getElementById('manage-variant-unit').value = data.unit || '';
        document.getElementById('manage-variant-color').value = data.color || '';
        document.getElementById('manage-variant-size').value = data.size || '';


        // ĐẶT GIÁ TRỊ CUSTOM SELECT
        setCustomMultiselectValues(document.querySelector('[data-select-id="manage-variant-status"]'), data.status);
        setCustomMultiselectValues(document.querySelector('[data-select-id="manage-variant-promo"]'), data.promo);
    }

    // 1. Kích hoạt khi nhấn (link "Xanh/2kg" hoặc dấu "+") trong bảng
    variantModalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const mode = this.dataset.mode;
            const productId = this.dataset.productId;

            // Xóa highlight cũ
            document.querySelectorAll('.variant-list-item').forEach(item => item.classList.remove('bg-gray-100'));

            if (mode === 'add') {
                showVariantView('add');
            } else {
                showVariantView('manage');
                // Tự động load dữ liệu của variant đầu tiên trong danh sách (mock data)
                const firstVariant = document.querySelector('.variant-list-item');
                 if (firstVariant) {
                    populateManageVariantForm(firstVariant.dataset);
                    firstVariant.classList.add('bg-gray-100');
                }
            }

            openModal(variantModal);
        });
    });

    // 2. Kích hoạt khi nhấn vào 1 biến thể trong cột phải (sidebar)
    variantListItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.variant-list-item').forEach(i => i.classList.remove('bg-gray-100'));
            this.classList.add('bg-gray-100');

            const data = this.dataset;
            populateManageVariantForm(data);
            showVariantView('manage');
        });
    });

    // 3. Kích hoạt chuyển đổi view (từ QL sang Thêm và ngược lại)
    if (switchToAddBtn) {
        switchToAddBtn.addEventListener('click', function() {
            showVariantView('add');
        });
    }

// Hàm xử lý khi click vào dòng sản phẩm trong bảng chính (mở modal quản lý)
function handleProductRowClick(e) {
    if (e.target.closest('.open-variant-modal-trigger')) {
        return; // Bỏ qua nếu click vào nút/link biến thể
    }
    
    const data = this.dataset;
    
    document.getElementById('manage-product_id').value = data.product_id;
    document.getElementById('manage-product_name').value = data.product_name;
    document.getElementById('manage-origin').value = data.origin;
    document.getElementById('manage-description').value = data.description;
    document.getElementById('manage-brand').value = data.brand; // Input text
    
    // Ảnh
    const imageUrl = data.image_url ? data.image_url : DEFAULT_IMAGE;
    document.getElementById('manage-image_url_preview').src = imageUrl;
    document.getElementById('manage-image_url_hidden').value = imageUrl; // Cập nhật input ẩn

    setCustomMultiselectValues(document.querySelector('[data-select-id="manage-category_id"]'), data.category_id);
    // LƯU Ý: Đổi data-status thành data-product_status trong PHP để tránh nhầm lẫn.
    setCustomMultiselectValues(document.querySelector('[data-select-id="manage-status"]'), data.product_status);
    
    openModal(manageProductModal);
}

// Hàm chuyển đổi view trong modal biến thể
function showVariantView(viewToShow) {
    if (viewToShow === 'add') {
        addVariantView.classList.remove('hidden');
        manageVariantView.classList.add('hidden');
        document.querySelector('#addVariantForm').reset();
        document.getElementById('add-variant-image-preview').src = DEFAULT_IMAGE;
        document.getElementById('add-variant-image-url').value = DEFAULT_IMAGE;
        
        // Cập nhật select trạng thái mặc định cho form thêm
        setCustomMultiselectValues(document.querySelector('#addVariantView [data-select-id="add-variant-status"]'), 'active');
        setCustomMultiselectValues(document.querySelector('#addVariantView [data-select-id="add-variant-promo"]'), 'Không');
        document.getElementById('add-variant-promo-price').value = 0;
        document.getElementById('add-variant-promo-price').classList.add('bg-gray-100');
        document.getElementById('add-variant-promo-price').readOnly = true;
    } else if (viewToShow === 'manage') {
        addVariantView.classList.add('hidden');
        manageVariantView.classList.remove('hidden');
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

    // --- KHỞI TẠO LOGIC UPLOAD ẢNH CHO CÁC MODAL ---
    
    // 1. Modal Thêm Sản phẩm
    document.getElementById('add-image-upload-btn').addEventListener('click', () => document.getElementById('add-image_url_input').click());
    handleImageUpload('add-image_url_input', 'add-image_url_preview', 'add-image_url');

    // 2. Modal Quản lý Sản phẩm
    document.getElementById('manage-image-upload-btn').addEventListener('click', () => document.getElementById('manage-image_url_input').click());
    handleImageUpload('manage-image_url_input', 'manage-image_url_preview', 'manage-image_url_hidden');

    // 3. Modal Thêm Biến thể
    document.getElementById('add-variant-image-upload-btn').addEventListener('click', () => document.getElementById('add-variant-image-url-input').click());
    handleImageUpload('add-variant-image-url-input', 'add-variant-image-preview', 'add-variant-image-url');
    
    // 4. Modal Quản lý Biến thể
    document.getElementById('manage-variant-image-upload-btn').addEventListener('click', () => document.getElementById('manage-variant-image-url-input').click());
    handleImageUpload('manage-variant-image-url-input', 'manage-variant-image-preview', 'manage-variant-image-url');


    // Gán lại sự kiện cho các trigger/link ban đầu (từ PHP)
    document.getElementById('openAddProductModalBtn').addEventListener('click', function() {
        document.querySelector('#addProductModal form').reset();
        document.getElementById('add-image_url_preview').src = DEFAULT_IMAGE;
        document.getElementById('add-image_url').value = 'https://via.placeholder.com/80x60/CCCCCC/000000?text=New';
        setCustomMultiselectValues(document.querySelector('[data-select-id="add-category_id"]'), '');
        setCustomMultiselectValues(document.querySelector('[data-select-id="add-product-status"]'), 'active');
        openModal(addProductModal);
    });

    document.querySelectorAll('.product-row-trigger').forEach(row => {
        row.addEventListener('click', handleProductRowClick);
    });

    document.querySelectorAll('.open-variant-modal-trigger').forEach(trigger => {
        trigger.addEventListener('click', handleVariantModalTriggerClick);
    });

    // Cần render lại list cho item đầu tiên để có item để click
    const firstProduct = productMap.values().next().value;
    if (firstProduct) {
        renderVariantList(firstProduct.product_id); 
    }
    
    // Gán sự kiện click cho các item đã được render lần đầu (nếu có)
    document.querySelectorAll('.variant-list-item').forEach(item => {
        item.addEventListener('click', handleVariantListItemClick);
    });

    // Logic chuyển đổi view trong modal biến thể
    document.getElementById('switchToAddeVariantBtn').addEventListener('click', function() {
        showVariantView('add'); 
    });

    document.getElementById('switchBackToManageBtn').addEventListener('click', function() {
        showVariantView('manage');
    });

    // --- XỬ LÝ SỰ KIỆN SUBMIT FORM ---

    // 1. FORM THÊM SẢN PHẨM
    addProductForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Lấy dữ liệu
        const newProductId = generateNewId('SP', ++productIdCounter);
        const productName = document.getElementById('add-product_name').value;
        const categoryId = document.getElementById('add-category_id').value;
        const origin = document.getElementById('add-origin').value;
        const brand = document.getElementById('add-brand').value;
        const description = document.getElementById('add-description').value;
        const imageUrl = document.getElementById('add-image_url').value;
        const status = document.getElementById('add-product-status').value;
        const categoryName = MOCK_CATEGORIES_DATA[categoryId] || categoryId;

        if (!productName || !categoryId) {
            alert('Vui lòng nhập Tên SP và chọn Tên loại.');
            return;
        }

        const newProduct = {
            product_id: newProductId,
            product_name: productName,
            category_id: categoryId,
            brand: brand,
            origin: origin,
            image_url: imageUrl,
            status: status,
            variants: [], // Sản phẩm mới chưa có biến thể
            description: description,
            slug: productName.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '')
        };

        // Cập nhật Map dữ liệu ảo
        productMap.set(newProduct.product_id, newProduct);

        // Render dòng mới vào bảng
        const newRow = renderProductRow(newProduct);
        document.getElementById('product-list-body').prepend(newRow);

        closeModal(addProductModal);
        alert(`Đã thêm sản phẩm: ${productName} (ID: ${newProductId})`);
    });

    // 2. FORM THÊM BIẾN THỂ
    addVariantForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const currentProductId = document.getElementById('current-product-id').value;
        const product = productMap.get(currentProductId);

        if (!product) {
            alert('Lỗi: Không tìm thấy sản phẩm.');
            return;
        }

        // Lấy dữ liệu
        const newVariantId = generateNewId('BT', ++variantIdCounter);
        const color = document.getElementById('add-variant-color').value;
        const size = document.getElementById('add-variant-size').value;
        const price = parseInt(document.getElementById('add-variant-price').value) || 0;
        const stock = parseInt(document.getElementById('add-variant-stock').value) || 0;
        const promo = document.getElementById('add-variant-promo').value;
        const weight = document.getElementById('add-variant-weight').value;
        const unit = document.getElementById('add-variant-unit').value;
        const status = document.getElementById('add-variant-status').value;
        const imageUrl = document.getElementById('add-variant-image-url').value;
        // SỬA: Lấy giá giảm thủ công
        const promoPrice = parseInt(document.getElementById('add-variant-promo-price').value) || 0; 


        if (!color || !size || price <= 0 || stock < 0) {
            alert('Vui lòng nhập đầy đủ Màu, Size, Giá bán (>0) và Tồn kho (>=0).');
            return;
        }
        
        // Kiểm tra logic giá giảm
        if (promo === 'Có' && promoPrice >= price) {
             alert('Giá giảm phải nhỏ hơn Giá bán khi áp dụng Khuyến mãi.');
             return;
        }
        if (promo === 'Không' && promoPrice > 0) {
             alert('Không thể có Giá giảm khi không áp dụng Khuyến mãi. Vui lòng đặt Giá giảm về 0 hoặc chọn "Có".');
             return;
        }


        const variantName = `${color}/${weight}${unit}`;

        const newVariant = {
            variant_id: newVariantId,
            name: variantName,
            color: color,
            size: size,
            price: price / 1000, // Lưu với đơn vị K (như mock data)
            stock: stock,
            promo: promo,
            promo_price: promoPrice / 1000, // Lưu với đơn vị K (như mock data)
            weight: weight,
            unit: unit,
            status: status,
            image_url: imageUrl
        };

        // Cập nhật Map dữ liệu ảo
        product.variants.push(newVariant);
        // Đặt lại trạng thái sản phẩm nếu cần (logic giữ nguyên)
        if (status === 'active' && product.status === 'inactive') {
            product.status = 'active';
        } else if (status === 'inactive') {
            const hasActiveVariant = product.variants.some(v => v.status === 'active');
            product.status = hasActiveVariant ? 'active' : 'inactive';
        }
        
        // Cập nhật hiển thị trạng thái sản phẩm trong bảng chính
        const productRow = document.querySelector(`.product-row-trigger[data-product_id="${currentProductId}"]`);
        if (productRow) {
             productRow.dataset.product_status = product.status;
             const badge = productRow.querySelector('.product-status-badge');
             badge.classList.remove('bg-green-100', 'text-green-800', 'bg-gray-200', 'text-gray-800');
             badge.classList.add(product.status === 'active' ? 'bg-green-100' : 'bg-gray-200');
             badge.classList.add(product.status === 'active' ? 'text-green-800' : 'text-gray-800');
             badge.textContent = MOCK_STATUS_DATA[product.status];
        }
        
        // Render lại danh sách biến thể trong modal (cột phải)
        renderVariantList(currentProductId);

        // Cập nhật link biến thể trong bảng chính
        updateProductRowVariantLinks(currentProductId, product.variants);

        // Chuyển về chế độ quản lý sau khi thêm thành công
        showVariantView('manage'); 
        alert(`Đã thêm biến thể: ${variantName} (ID: ${newVariantId}) cho sản phẩm ${product.product_name}`);
    });

    // 3. FORM QUẢN LÝ SẢN PHẨM (Mô phỏng lưu)
    manageProductForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const productId = document.getElementById('manage-product_id').value;
        const product = productMap.get(productId);

        if (!product) {
            alert('Lỗi: Không tìm thấy sản phẩm cần quản lý.');
            return;
        }

        // Lấy dữ liệu mới
        const newProductName = document.getElementById('manage-product_name').value;
        const newCategoryId = document.getElementById('manage-category_id').value;
        const newOrigin = document.getElementById('manage-origin').value;
        const newBrand = document.getElementById('manage-brand').value;
        const newDescription = document.getElementById('manage-description').value;
        const newStatus = document.getElementById('manage-status').value;
        const newImageUrl = document.getElementById('manage-image_url_hidden').value; // Lấy từ input ẩn

        // Cập nhật Map
        product.product_name = newProductName;
        product.category_id = newCategoryId;
        product.origin = newOrigin;
        product.brand = newBrand;
        product.description = newDescription;
        product.status = newStatus;
        product.image_url = newImageUrl;
        
        // Cập nhật hiển thị trong bảng chính
        const productRow = document.querySelector(`.product-row-trigger[data-product_id="${productId}"]`);
        if (productRow) {
            // Cập nhật dataset
            productRow.dataset.product_name = newProductName;
            productRow.dataset.category_id = newCategoryId;
            productRow.dataset.origin = newOrigin;
            productRow.dataset.brand = newBrand;
            productRow.dataset.description = newDescription;
            productRow.dataset.product_status = newStatus;
            productRow.dataset.image_url = newImageUrl;
            
            // Cập nhật nội dung hiển thị
            productRow.querySelector('.product-name-display').textContent = newProductName;
            productRow.querySelector('.category-name-display').textContent = MOCK_CATEGORIES_DATA[newCategoryId] || newCategoryId;
            productRow.querySelector('.product-image-display').src = newImageUrl;

            const badge = productRow.querySelector('.product-status-badge');
            badge.dataset.statusId = newStatus;
            badge.textContent = MOCK_STATUS_DATA[newStatus];
            badge.classList.remove('bg-green-100', 'text-green-800', 'bg-gray-200', 'text-gray-800');
            badge.classList.add(newStatus === 'active' ? 'bg-green-100' : 'bg-gray-200');
            badge.classList.add(newStatus === 'active' ? 'text-green-800' : 'text-gray-800');
        }

        closeModal(manageProductModal);
        alert(`Đã lưu thông tin sản phẩm: ${newProductName} (ID: ${productId})`);
    });

    // 4. FORM QUẢN LÝ BIẾN THỂ (Mô phỏng lưu)
    manageVariantForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const productId = document.getElementById('current-product-id').value;
        const variantId = document.getElementById('manage-variant-id').value;
        const product = productMap.get(productId);

        if (!product || !variantId) {
            alert('Lỗi: Không tìm thấy sản phẩm hoặc biến thể.');
            return;
        }

        const variantIndex = product.variants.findIndex(v => v.variant_id === variantId);
        if (variantIndex === -1) {
            alert('Lỗi: Không tìm thấy biến thể.');
            return;
        }

        // Lấy dữ liệu mới
        const newColor = document.getElementById('manage-variant-color').value;
        const newSize = document.getElementById('manage-variant-size').value;
        const newPrice = parseInt(document.getElementById('manage-variant-price').value) || 0;
        const newStock = parseInt(document.getElementById('manage-variant-stock').value) || 0;
        const newPromo = document.getElementById('manage-variant-promo').value;
        const newWeight = document.getElementById('manage-variant-weight').value;
        const newUnit = document.getElementById('manage-variant-unit').value;
        const newStatus = document.getElementById('manage-variant-status').value;
        const newImageUrl = document.getElementById('manage-variant-image-url').value;
        // SỬA: Lấy giá giảm thủ công
        const newPromoPrice = parseInt(document.getElementById('manage-variant-promo-price').value) || 0; 


        if (!newColor || !newSize || newPrice <= 0 || newStock < 0) {
            alert('Vui lòng nhập đầy đủ Màu, Size, Giá bán (>0) và Tồn kho (>=0).');
            return;
        }

        // Kiểm tra logic giá giảm
        if (newPromo === 'Có' && newPromoPrice >= newPrice) {
             alert('Giá giảm phải nhỏ hơn Giá bán khi áp dụng Khuyến mãi.');
             return;
        }
        if (newPromo === 'Không' && newPromoPrice > 0) {
             alert('Không thể có Giá giảm khi không áp dụng Khuyến mãi. Vui lòng đặt Giá giảm về 0 hoặc chọn "Có".');
             return;
        }

        const newVariantName = `${newColor}/${newWeight}${newUnit}`;

        // Cập nhật Map
        product.variants[variantIndex] = {
            ...product.variants[variantIndex], // Giữ lại các thuộc tính cũ
            name: newVariantName,
            color: newColor,
            size: newSize,
            price: newPrice / 1000,
            stock: newStock,
            promo: newPromo,
            promo_price: newPromoPrice / 1000,
            weight: newWeight,
            unit: newUnit,
            status: newStatus,
            image_url: newImageUrl
        };
        
        // Cập nhật lại trạng thái sản phẩm chính nếu cần (logic giữ nguyên)
        if (newStatus === 'active' && product.status === 'inactive') {
            product.status = 'active';
        } else if (newStatus === 'inactive') {
            const hasActiveVariant = product.variants.some(v => v.status === 'active');
            product.status = hasActiveVariant ? 'active' : 'inactive';
        }

        // Render lại danh sách biến thể trong modal (cột phải)
        renderVariantList(productId);
        // Cập nhật link biến thể trong bảng chính
        updateProductRowVariantLinks(productId, product.variants);
        // Cập nhật trạng thái sản phẩm trong bảng chính
        const productRow = document.querySelector(`.product-row-trigger[data-product_id="${productId}"]`);
        if (productRow) {
             productRow.dataset.product_status = product.status;
             const badge = productRow.querySelector('.product-status-badge');
             badge.textContent = MOCK_STATUS_DATA[product.status];
             badge.classList.remove('bg-green-100', 'text-green-800', 'bg-gray-200', 'text-gray-800');
             badge.classList.add(product.status === 'active' ? 'bg-green-100' : 'bg-gray-200');
             badge.classList.add(product.status === 'active' ? 'text-green-800' : 'text-gray-800');
        }

        // Tự động chọn lại item vừa chỉnh sửa
        const updatedItem = document.querySelector(`.variant-list-item[data-variant-id="${variantId}"]`);
        if (updatedItem) {
             updatedItem.classList.add('bg-gray-100');
        }

        alert(`Đã lưu thông tin biến thể: ${newVariantName} (ID: ${variantId})`);
    });

    // --- LOGIC TẮT/BẬT INPUT GIÁ GIẢM KHI CHỌN "CÓ/KHÔNG" ---
    document.querySelectorAll('#manage-variant-promo, #add-variant-promo').forEach(select => {
        select.addEventListener('change', function() {
            const isAddForm = this.id.includes('add-');
            const promoPriceInput = document.getElementById(isAddForm ? 'add-variant-promo-price' : 'manage-variant-promo-price');
            const isPromo = this.value === 'Có';

            if (isPromo) {
                promoPriceInput.classList.remove('bg-gray-100');
                promoPriceInput.readOnly = false;
            } else {
                promoPriceInput.classList.add('bg-gray-100');
                promoPriceInput.readOnly = true;
                promoPriceInput.value = 0; // Reset về 0 khi chọn Không
            }

            const data = this.dataset;

            document.getElementById('manage-product_id').value = data.product_id;
            document.getElementById('manage-product_name').value = data.product_name;
            document.getElementById('manage-origin').value = data.origin;
            document.getElementById('manage-description').value = data.description;
            document.getElementById('manage-brand').value = data.brand; // Input text

            const img = document.getElementById('manage-image_url');
            img.src = data.image_url ? data.image_url : 'https://via.placeholder.com/160x160.png?text=Image';

            setCustomMultiselectValues(document.querySelector('[data-select-id="manage-category_id"]'), data.category_id);
            setCustomMultiselectValues(document.querySelector('[data-select-id="manage-status"]'), data.status);

            openModal(manageProductModal);
        });
    });

    // --- LOGIC ĐÓNG MODAL CHUNG ---

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
            closeModal(addProductModal);
            closeModal(manageProductModal);
            closeModal(variantModal);
        }
    });
});
</script>
@endpush
