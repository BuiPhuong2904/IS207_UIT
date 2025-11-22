{{-- resources/views/admin/store.blade.php (ĐÃ SỬA LỖI AJAX/FORM DATA) --}}
@extends('layouts.ad_layout')

@section('title', 'Quản lý cửa hàng')

@section('content')

{{-- KHỐI PHP CŨ ĐƯỢC GIỮ LẠI ĐỂ ĐẢM BẢO CÁC BIẾN PHP ĐƯỢC TRUYỀN VẪN CÓ SẴN --}}
@php
// Giả định $products là Paginator object từ Controller
// Ví dụ: $products = $products ?? \App\Models\Product::paginate(10); 
$products = $products ?? collect([]);
$categories = $categories ?? []; // Ví dụ: ['CAT01' => 'Dụng cụ tập', ...]
$statuses = $statuses ?? ['active' => 'Còn hàng', 'inactive' => 'Hết hàng'];
$variant_promos = ['Có', 'Không']; // Cần khai báo để render dropdown

// Lấy thông tin phân trang từ đối tượng Paginator nếu có
$paginationData = $products instanceof \Illuminate\Contracts\Pagination\Paginator ? $products : null;
@endphp

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Header (Trùng với File 2) --}}
<div class="flex justify-between items-center mb-6">
    {{-- Thanh tìm kiếm --}}
    <div class="flex-1 max-w-md">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" id="searchInput" class="w-full pl-10 pr-4 py-2.5 border border-[#999999]/50 rounded-2xl shadow-sm focus:outline-none focus:ring-1 focus:ring-black" placeholder="Tìm kiếm ...">
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

{{-- Bảng danh sách Cửa hàng ONLINE (Trùng với File 2 về cấu trúc) --}}
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
                @forelse ($products as $product)
                {{-- Giữ các data-* attribute của File 1, nhưng thêm class của File 2/mode mới --}}
                <tr class="transition duration-150 cursor-pointer product-row-trigger product-row"
                    data-product_id="{{ $product->product_id }}"
                    data-product_name="{{ $product->product_name }}"
                    data-category_id="{{ $product->category_id }}"
                    data-origin="{{ $product->origin ?? '' }}"
                    data-brand="{{ $product->brand ?? '' }}"
                    data-description="{{ $product->description }}"
                    data-product_status="{{ $product->status }}" 
                    data-slug="{{ $product->slug ?? '' }}"
                    data-image_url="{{ $product->image_url }}"
                    data-product='@json($product->load('variants'))' {{-- Giữ lại data-product cho logic JS cũ --}}
                >
                    <td colspan="8" class="p-0">
                        <div class="flex w-full rounded-lg items-center 
                                {{ $loop->even ? 'bg-white' : 'bg-[#1976D2]/10' }}
                                shadow-sm overflow-hidden product-row-content">
                            
                            <div class="px-4 py-3 w-[10%] text-sm font-medium text-gray-900">
                                {{ $product->product_id }}
                            </div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700 product-name-display">
                                {{ $product->product_name }}
                            </div>
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700 category-name-display">
                                {{ $categories[$product->category_id] ?? 'N/A' }} 
                            </div>
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700">
                                {{ $product->brand ?? 'N/A' }}
                            </div>
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700">
                                {{ $product->origin ?? 'N/A' }}
                            </div>
                            <div class="px-4 py-3 w-[10%]">
                                <img src="{{ $product->image_url }}" 
                                    onerror="this.src='https://via.placeholder.com/80x60/CCCCCC/000000?text=Image'"
                                    alt="{{ $product->product_name }}" class="w-16 h-12 object-cover rounded-md product-image-display">
                            </div>

                            {{-- Biến thể (Trùng với File 1/2) --}}
                            <div class="px-4 py-3 flex-1 text-sm text-gray-700 product-variants-display">
                                <div class="flex items-center space-x-2">
                                    <div class="flex flex-col variant-links-container">
                                        @foreach ($product->variants as $variant)
                                        {{-- SỬA: Thay đổi class để tương thích với JS cũ của File 2/mode mới của File 1 --}}
                                        <a href="#" class="text-purple-600 font-medium hover:underline open-variant-modal-trigger open-variant-trigger variant-link"
                                            data-product-id="{{ $product->product_id }}"
                                            data-variant-id="{{ $variant->variant_id }}" 
                                            data-mode="manage" {{-- Dùng data-mode để kích hoạt logic quản lý --}}
                                        >
                                            {{ $variant->color }} / {{ $variant->size }} - {{ number_format($variant->price) }}đ
                                        </a>
                                        @endforeach
                                    </div>
                                    
                                    {{-- Nút Thêm (+) --}}
                                    <button class="open-variant-modal-trigger text-blue-500 hover:text-blue-700 open-variant-trigger" data-product-id="{{ $product->product_id }}" data-mode="add">
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
                @empty
                <tr><td colspan="8" class="text-center py-8 text-gray-500">Chưa có sản phẩm nào</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PHÂN TRANG: THÊM VÀO ĐÂY --}}
    @if ($paginationData && $paginationData->lastPage() > 1)
        <div class="mt-4 flex justify-center">
            {{ $paginationData->links() }}
        </div>
    @endif
</div>

---

{{-- =================== HTML CHO CÁC MODAL (Trùng với File 2 về cấu trúc) ================= --}}

{{-- ----------------- MODAL 1: THÊM SẢN PHẨM ----------------- --}}
<div id="addProductModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl">
        
        <h2 class="text-3xl font-bold text-center mb-6 
                bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] 
                bg-clip-text text-transparent">
            THÊM SẢN PHẨM
        </h2>
        
        <form id="addProductForm" enctype="multipart/form-data"> 
            @csrf
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
                    {{-- SỬA: Thêm name="image_url" cho input file --}}
                    <input type="file" name="image_url" id="add-image_url_input" class="hidden" accept="image/*">
                    {{-- SỬA: Thêm name="default_image_url" cho input hidden --}}
                    <input type="hidden" id="add-image_url" name="default_image_url" value="https://via.placeholder.com/80x60/CCCCCC/000000?text=New">
                </div>

                {{-- Cột thông tin --}}
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <label for="add-product_name" class="block text-sm font-medium text-gray-700 mb-1">Tên SP</label>
                        {{-- SỬA: Thêm name="product_name" --}}
                        <input type="text" name="product_name" id="add-product_name" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="add-category_id" class="block text-sm font-medium text-gray-700 mb-1">Tên loại</label>
                            <div class="relative custom-multiselect" data-select-id="add-category_id" data-type="single">
                                {{-- SỬA: Thêm name="category_id" --}}
                                <select id="add-category_id" name="category_id" class="hidden">
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
                            {{-- SỬA: Thêm name="origin" --}}
                            <input type="text" name="origin" id="add-origin" value="Việt Nam" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div>
                        <label for="add-brand" class="block text-sm font-medium text-gray-700 mb-1">Thương hiệu</label>
                        {{-- SỬA: Thêm name="brand" --}}
                        <input type="text" name="brand" id="add-brand" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-x-6 gap-y-4 items-start">
                {{-- Mô tả --}}
                <label for="add-description" class="col-span-2 block text-sm font-medium text-gray-700 whitespace-nowrap pr-2 pt-2.5">Mô tả</label>
                <div class="col-span-10">
                    {{-- SỬA: Thêm name="description" --}}
                    <textarea name="description" id="add-description" rows="5" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
                </div>

                {{-- Trạng thái --}}
                <label for="add-product-status" class="col-span-2 block text-sm font-medium text-gray-700 whitespace-nowrap pr-2 pt-2.5">Trạng thái</label>
                <div class="relative custom-multiselect col-span-4" data-select-id="add-product-status" data-type="single">
                    {{-- SỬA: Thêm name="status" --}}
                    <select id="add-product-status" name="status" class="hidden">
                        @foreach($statuses as $id => $name)
                        <option value="{{ $id }}" {{ $id === 'active' ? 'selected' : '' }}>{{ $name }}</option>
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

            <div id="addProductFlash" class="mt-4"></div>
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

{{-- ----------------- MODAL 2: QUẢN LÝ SẢN PHẨM ----------------- --}}
<div id="manageProductModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl">
        
        <h2 class="text-3xl font-bold text-center mb-6 
                bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] 
                bg-clip-text text-transparent">
            QUẢN LÝ CỬA HÀNG
        </h2>
        
        <form id="manageProductForm" enctype="multipart/form-data"> 
            @csrf
            @method('PUT')
            <input type="hidden" id="manage-product_id" name="product_id">
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
                    {{-- SỬA: Thêm name="image_url" cho input file --}}
                    <input type="file" id="manage-image_url_input" class="hidden" name="image_url" accept="image/*">
                    {{-- SỬA: Thêm name="default_image_url" cho input hidden --}}
                    <input type="hidden" id="manage-image_url_hidden" name="default_image_url">
                </div>

                {{-- Cột thông tin --}}
                <div class="md:col-span-2 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="manage-product_id" class="block text-sm font-medium text-gray-700 mb-1">ID</label>
                            {{-- SỬA: Thêm ID _display cho input ID --}}
                            <input type="text" id="manage-product_id_display" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm bg-gray-100 px-4 py-2.5" readonly>
                        </div>
                        <div>
                            <label for="manage-product_name" class="block text-sm font-medium text-gray-700 mb-1">Tên SP</label>
                            {{-- SỬA: Thêm name="product_name" --}}
                            <input type="text" id="manage-product_name" name="product_name" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="manage-category_id" class="block text-sm font-medium text-gray-700 mb-1">Tên loại</label>
                            <div class="relative custom-multiselect" data-select-id="manage-category_id" data-type="single">
                                {{-- SỬA: Thêm name="category_id" --}}
                                <select id="manage-category_id" name="category_id" class="hidden">
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
                            {{-- SỬA: Thêm name="origin" --}}
                            <input type="text" id="manage-origin" name="origin" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                        </div>
                    </div>

                    <div>
                        <label for="manage-brand" class="block text-sm font-medium text-gray-700 mb-1">Thương hiệu</label>
                        {{-- SỬA: Thêm name="brand" --}}
                        <input type="text" id="manage-brand" name="brand" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-x-6 gap-y-4 items-start">
                {{-- Mô tả --}}
                <label for="manage-description" class="col-span-2 block text-sm font-medium text-gray-700 whitespace-nowrap pr-2 pt-2.5">Mô tả</label>
                <div class="col-span-10">
                    {{-- SỬA: Thêm name="description" --}}
                    <textarea id="manage-description" name="description" rows="5" class="w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black"></textarea>
                </div>
                
                {{-- Trạng thái --}}
                <label for="manage-status" class="col-span-2 block text-sm font-medium text-gray-700 whitespace-nowrap pr-2 pt-2.5">Trạng thái</label>
                <div class="relative custom-multiselect col-span-4" data-select-id="manage-status" data-type="single">
                    {{-- SỬA: Thêm name="status" --}}
                    <select id="manage-status" name="status" class="hidden">
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

            <div id="editProductFlash" class="mt-4"></div>
            {{-- Nút bấm --}}
            <div class="flex justify-between items-center mt-8">
                <button type="button" id="deleteProductBtn" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 font-medium">
                    Xóa sản phẩm
                </button>
                <div class="flex space-x-4">
                    <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                        Hủy
                    </button>
                    <button type="submit" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                        Lưu thông tin
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ----------------- MODAL 3: MODAL BIẾN THỂ ----------------- --}}
<div id="variantModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-7xl"> 
        
        <div class="flex gap-8">
            
            {{-- === CỘT TRÁI: FORM (2-trong-1) === --}}
            <div class="flex-1">
                <input type="hidden" id="current-product-id"> 
                
                {{-- === VIEW 1: QUẢN LÝ BIẾN THỂ === --}}
                <div id="manageVariantView">
                    <h2 class="text-3xl font-bold text-center mb-6 
                               bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] 
                               bg-clip-text text-transparent">
                        QUẢN LÝ BIẾN THỂ
                    </h2>
                    
                    <form id="manageVariantForm" enctype="multipart/form-data"> 
                        @csrf
                        @method('PUT')
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
                                {{-- SỬA: Thêm name="image_file" cho input file --}}
                                <input type="file" id="manage-variant-image-url-input" class="hidden" name="image_file" accept="image/*"> 
                                {{-- SỬA: Thêm name="image_url" cho input hidden --}}
                                <input type="hidden" id="manage-variant-image-url" name="image_url">
                            </div>

                            {{-- Cột thông tin --}}
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-12 gap-x-6 gap-y-4 items-center">
                                    
                                    {{-- HÀNG 1: ID (Label 3 / Input 9) --}}
                                    <label for="manage-variant-id" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">ID</label>
                                    <input type="text" id="manage-variant-id" class="col-span-9 w-full border border-[#999999]/50 rounded-2xl shadow-sm bg-gray-100 px-4 py-2.5" readonly>

                                    {{-- HÀNG 2: Màu / Size (Label 3 / Input 3 | Label 3 / Input 3) --}}
                                    <label for="manage-variant-color" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Màu *</label>
                                    {{-- SỬA: Thêm name="color" --}}
                                    <input type="text" id="manage-variant-color" name="color" required class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    <label for="manage-variant-size" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Size *</label>
                                    {{-- SỬA: Thêm name="size" --}}
                                    <input type="text" id="manage-variant-size" name="size" required class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    
                                    {{-- HÀNG 3: Giá bán / Tồn kho (Label 3 / Input 3 | Label 3 / Input 3) --}}
                                    <label for="manage-variant-price" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Giá bán (VNĐ) *</label>
                                    {{-- SỬA: Thêm name="price" --}}
                                    <input type="number" id="manage-variant-price" name="price" required min="0.01" step="0.01" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    <label for="manage-variant-stock" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Tồn kho *</label>
                                    {{-- SỬA: Thêm name="stock" --}}
                                    <input type="number" id="manage-variant-stock" name="stock" required min="0" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">

                                    {{-- HÀNG 4: Áp dụng KM / Giá giảm --}}
                                    <label for="manage-variant-promo" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Áp dụng KM</label>
                                    <div class="relative custom-multiselect col-span-3" data-select-id="manage-variant-promo" data-type="single">
                                        <select id="manage-variant-promo" name="promo_status" class="hidden"> {{-- THÊM name="promo_status" để gửi dữ liệu --}}
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
                                    {{-- SỬA: Thêm name="discount_price" --}}
                                    <input type="number" id="manage-variant-promo-price" name="discount_price" min="0" step="0.01" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 bg-gray-100" readonly>
                                    
                                    {{-- HÀNG 5: Trọng lượng / Đơn vị tính (Label 3 / Input 3 | Label 3 / Input 3) --}}
                                    <label for="manage-variant-weight" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Trọng lượng</label>
                                    {{-- SỬA: Thêm name="weight" --}}
                                    <input type="number" id="manage-variant-weight" name="weight" step="0.01" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    <label for="manage-variant-unit" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Đơn vị tính</label>
                                    {{-- SỬA: Thêm name="unit" --}}
                                    <input type="text" id="manage-variant-unit" name="unit" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">

                                    {{-- HÀNG 6: Trạng thái (Label 3 / Dropdown 3 / Khoảng trống 6) --}}
                                    <label for="manage-variant-status" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Trạng thái *</label>
                                    <div class="relative custom-multiselect col-span-3" data-select-id="manage-variant-status" data-type="single">
                                        {{-- SỬA: Thêm name="status" --}}
                                        <select id="manage-variant-status" name="status" required class="hidden">
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

                        <div id="manageVariantFlash" class="mt-4"></div>
                        {{-- Nút bấm --}}
                        <div class="flex justify-between space-x-4 mt-8">
                            <button type="button" id="deleteVariantBtn" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 font-medium">Xóa biến thể</button>
                            <div class="flex space-x-4">
                                <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">Hủy</button>
                                <button type="button" id="switchToAddeVariantBtn" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Thêm biến thể</button>
                                <button type="submit" class="px-8 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Lưu thông tin</button>
                            </div>
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
                    
                    <form id="addVariantForm" enctype="multipart/form-data"> 
                        @csrf
                        {{-- SỬA: Thêm name="product_id" --}}
                        <input type="hidden" id="add-variant-product-id" name="product_id">
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
                                {{-- SỬA: Thêm name="image_file" cho input file --}}
                                <input type="file" id="add-variant-image-url-input" class="hidden" name="image_file" accept="image/*"> 
                                {{-- SỬA: Thêm name="image_url" cho input hidden --}}
                                <input type="hidden" id="add-variant-image-url" name="image_url" value="https://via.placeholder.com/160x160.png?text=New+Variant">
                            </div>

                            {{-- Cột thông tin --}}
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-12 gap-x-6 gap-y-4 items-center">
                                    
                                    {{-- HÀNG 1: Màu / Size (Label 3 / Input 3 | Label 3 / Input 3) --}}
                                    <label for="add-variant-color" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Màu *</label>
                                    {{-- SỬA: Thêm name="color" --}}
                                    <input type="text" id="add-variant-color" name="color" required class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    <label for="add-variant-size" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Size *</label>
                                    {{-- SỬA: Thêm name="size" --}}
                                    <input type="text" id="add-variant-size" name="size" required class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    
                                    {{-- HÀNG 2: Giá bán / Tồn kho (Label 3 / Input 3 | Label 3 / Input 3) --}}
                                    <label for="add-variant-price" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Giá bán (VNĐ) *</label>
                                    {{-- SỬA: Thêm name="price" --}}
                                    <input type="number" id="add-variant-price" name="price" required min="0.01" step="0.01" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    <label for="add-variant-stock" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Tồn kho *</label>
                                    {{-- SỬA: Thêm name="stock" --}}
                                    <input type="number" id="add-variant-stock" name="stock" required min="0" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">

                                    {{-- HÀNG 3: Áp dụng KM / Giá giảm --}}
                                    <label for="add-variant-promo" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Áp dụng KM</label>
                                    <div class="relative custom-multiselect col-span-3" data-select-id="add-variant-promo" data-type="single">
                                        <select id="add-variant-promo" name="promo_status" class="hidden"> {{-- THÊM name="promo_status" để gửi dữ liệu --}}
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
                                    {{-- SỬA: Thêm name="discount_price" --}}
                                    <input type="number" id="add-variant-promo-price" name="discount_price" min="0" step="0.01" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 bg-gray-100" readonly>

                                    {{-- HÀNG 4: Trọng lượng / Đơn vị tính (Label 3 / Input 3 | Label 3 / Input 3) --}}
                                    <label for="add-variant-weight" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Trọng lượng</label>
                                    {{-- SỬA: Thêm name="weight" --}}
                                    <input type="number" id="add-variant-weight" name="weight" step="0.01" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">
                                    <label for="add-variant-unit" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Đơn vị tính</label>
                                    {{-- SỬA: Thêm name="unit" --}}
                                    <input type="text" id="add-variant-unit" name="unit" class="col-span-3 w-full border border-[#999999]/50 rounded-2xl shadow-sm px-4 py-2.5 focus:outline-none focus:ring-1 focus:ring-black">

                                    {{-- THÊM HÀNG 5: Trạng thái --}}
                                    <label for="add-variant-status" class="col-span-3 block text-sm font-medium text-gray-700 whitespace-nowrap text-left pr-4">Trạng thái *</label>
                                    <div class="relative custom-multiselect col-span-3" data-select-id="add-variant-status" data-type="single">
                                        {{-- SỬA: Thêm name="status" --}}
                                        <select id="add-variant-status" name="status" required class="hidden">
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
                        <div id="addVariantFlash" class="mt-4"></div>
                        {{-- Nút bấm --}}
                        <div class="flex justify-center space-x-4 mt-8">
                            <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">Hủy</button>
                            <button type="button" id="switchBackToManageBtn" class="px-8 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Quay lại quản lý</button>
                            <button type="submit" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Thêm biến thể</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- === CỘT PHẢI: DANH SÁCH BIẾN THỂ (Giữ nguyên) === --}}
            <div class="w-full max-w-[300px] h-full">
                <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">Các biến thể (<span id="variant-product-name">...</span>)</h3>
                {{-- Dùng ID variant-sidebar-list của File 1 --}}
                <div id="variant-sidebar-list" class="space-y-3 h-[500px] overflow-y-auto pr-2">
                    {{-- Dữ liệu Biến thể sẽ được render bằng JavaScript (AJAX) --}}
                    
                </div>
            </div>

        </div>
        
    </div>
</div>

@endsection

@push('scripts')
<style>
/* === CUSTOM STYLES CHO CUSTOM SELECT COMPONENT (Dùng @apply Tailwind) - GIỮ NGUYÊN TỪ FILE 1/2 === */

/* Màu Hover: Xám (#999999) 50% opacity */
.custom-multiselect-option:hover {
    background-color: rgba(153, 153, 153, 0.5); 
    color: #1a202c; 
}
.custom-multiselect-option:hover span {
    color: #1a202c; 
}

/* Màu Selected: Xanh Blue 50% opacity */
.custom-multiselect-option.bg-blue-100 {
    background-color: rgba(59, 130, 246, 0.5);
    color: #1a202c;
}
.custom-multiselect-option.bg-blue-100 span {
    color: #1a202c;
}

/* Khi hover lên mục đã chọn, áp dụng style hover xám 50% */
.custom-multiselect-option.bg-blue-100:hover {
    background-color: rgba(153, 153, 153, 0.5);
    color: #1a202c;
}

/* Đảm bảo trạng thái ban đầu của option */
.custom-multiselect-option {
    background-color: white;
    color: #1a202c;
}

/* === BẮT ĐẦU: SCROLLBAR STYLES (#999999 - [50]) - GIỮ NGUYÊN TỪ FILE 1/2 === */
/* Kích thước và màu sắc cho WebKit (Chrome/Safari/Edge) */
#variant-sidebar-list::-webkit-scrollbar {
    width: 8px; /* Chiều rộng thanh cuộn dọc */
}
#variant-sidebar-list::-webkit-scrollbar-track {
    background: transparent; /* Nền của track */
}
#variant-sidebar-list::-webkit-scrollbar-thumb {
    /* Màu #999999 với độ mờ 50% (50/255 = 0.5) */
    background: rgba(153, 153, 153, 0.5); 
    border-radius: 4px;
}
#variant-sidebar-list::-webkit-scrollbar-thumb:hover {
    background: #777777; /* Màu khi hover (tăng độ đậm) */
}
/* === KẾT THÚC: SCROLLBAR STYLES === */

</style>

<script>
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const CATEGORIES = @json($categories);
    const STATUSES = @json($statuses);
    const DEFAULT_IMAGE = 'https://via.placeholder.com/160x160.png?text=Image';


    // ------------------------------------------------------------------
    // --- CUSTOM MULTISELECT LOGIC (Giữ nguyên logic của File 1/2) ---
    // ------------------------------------------------------------------

    function updateMultiselectDisplay(multiselectContainer) {
        if (!multiselectContainer) return;
        const hiddenSelect = multiselectContainer.querySelector('select');
        const displaySpan = multiselectContainer.querySelector('.custom-multiselect-display');
        const selectedOption = hiddenSelect.options[hiddenSelect.selectedIndex];
        
        const placeholder = displaySpan.dataset.placeholder || 'Chọn...';

        if (!selectedOption || selectedOption.value === "") {
            displaySpan.textContent = placeholder;
            displaySpan.classList.add('text-gray-500');
        } else {
            displaySpan.textContent = selectedOption.text;
            displaySpan.classList.remove('text-gray-500');
        }
    }

    function setCustomMultiselectValues(multiselectContainer, value) {
        if (!multiselectContainer) return;
        const hiddenSelect = multiselectContainer.querySelector('select');
        const optionsList = multiselectContainer.querySelector('.custom-multiselect-list');
        // SỬA: Ép kiểu giá trị truyền vào thành chuỗi để so sánh nhất quán
        const valueToSet = String(value).trim(); 
        const highlightClass = 'bg-blue-100'; 

        Array.from(hiddenSelect.options).forEach(option => option.selected = (String(option.value).trim() === valueToSet));

        if (optionsList) {
            optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
                li.classList.remove(highlightClass);
                // SỬA: So sánh giá trị data-value
                if (String(li.dataset.value).trim() === valueToSet) { 
                    li.classList.add(highlightClass);
                }
            });
        }
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
                displaySpan.dataset.placeholder = displaySpan.textContent;
            }

            if (trigger) {
                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    document.querySelectorAll('.custom-multiselect-panel').forEach(p => {
                        if (p !== panel) p.classList.add('hidden');
                    });
                    if (panel) {  panel.classList.toggle('hidden'); }
                });
            }

            if (optionsList) {
                optionsList.querySelectorAll('.custom-multiselect-option').forEach(li => {
                    li.addEventListener('click', (e) => {
                        e.stopPropagation();
                        const value = li.dataset.value;
                        Array.from(hiddenSelect.options).forEach(opt => {
                            opt.selected = (opt.value === value);
                        });
                        optionsList.querySelectorAll('.custom-multiselect-option').forEach(otherLi => {
                            otherLi.classList.remove('bg-blue-100');
                        });
                        li.classList.add('bg-blue-100');
                        if (panel) { panel.classList.add('hidden'); }
                        
                        updateMultiselectDisplay(container);

                        // KÍCH HOẠT EVENT CHO LOGIC KM
                        if (hiddenSelect.id.includes('-promo')) {
                            const event = new Event('change', { bubbles: true });
                            hiddenSelect.dispatchEvent(event);
                        }
                    });
                });
            }
            updateMultiselectDisplay(container);
        });
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.custom-multiselect')) {
                document.querySelectorAll('.custom-multiselect-panel').forEach(panel => {
                    panel.classList.add('hidden');
                });
            }
        });
    }

    // ------------------------------------------------------------------
    // --- UTILITY FUNCTIONS (Giữ nguyên logic của File 1/2) ---
    // ------------------------------------------------------------------

    function formatCurrency(amount) {
        // Chuyển string/null/undefined thành number hoặc 0 để format được
        const number = (typeof amount === 'string' && amount.trim() !== '') ? parseFloat(amount) : amount;
        if (typeof number !== 'number' || isNaN(number)) return '0đ';
        // Sử dụng giá trị tuyệt đối để format không bị lỗi với số âm
        return Math.abs(number).toLocaleString('vi-VN', { maximumFractionDigits: 0 }) + 'đ'; 
    }

    function showFlash(el, msg, success = true) {
        el.innerHTML = `<div class="p-3 rounded-xl ${success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">${msg}</div>`;
        setTimeout(() => el.innerHTML = '', 5000);
    }

    function setupImage(btnId, inputId, previewId, hiddenId) {
        const btn = document.getElementById(btnId);
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const hidden = document.getElementById(hiddenId); 

        if(btn) btn.onclick = () => input.click();
        if(input) input.onchange = e => {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = ev => {
                    preview.src = ev.target.result;
                    // Bổ sung: Gán giá trị rỗng cho input ẩn để báo hiệu có file mới được chọn
                    if(hidden) hidden.value = ''; 
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        };
    }

    // Hàm mở/đóng modal
    function closeModal(modal) {
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }
    function openModal(modal) {
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    // Hàm render danh sách biến thể trong modal (cột phải)
    function renderVariants(productName, variants, productId, currentVariantId = null) {
        const listContainer = document.getElementById('variant-sidebar-list');
        const nameDisplay = document.getElementById('variant-product-name');
        
        nameDisplay.textContent = productName;
        listContainer.innerHTML = ''; 

        if (variants && variants.length) {
            variants.forEach(v => {
                // SỬA: Đảm bảo sử dụng tên thuộc tính đúng của model/API
                const isDiscounted = (v.discount_price && parseFloat(v.discount_price) > 0);
                const priceText = isDiscounted
                    ? `<span class="text-red-600 font-bold">${formatCurrency(v.discount_price)}</span> <span class="line-through text-gray-400">${formatCurrency(v.price)}</span>`
                    : formatCurrency(v.price);
                
                const listItem = document.createElement('a');
                listItem.href = '#';
                // SỬA: Thêm class `variant-list-item` để dễ dàng chọn và highlight
                listItem.classList.add('block', 'p-4', 'border', 'rounded-lg', 'shadow-sm', 'hover:bg-gray-50', 'variant-list-item'); 
                
                // Cấu trúc data attribute chuẩn bị cho việc populate form quản lý
                // Tận dụng v.variant_id và loadVariantIntoManageForm
                listItem.dataset.variantId = v.variant_id;
                listItem.dataset.productId = productId;
                listItem.dataset.color = v.color;
                listItem.dataset.size = v.size;
                listItem.dataset.price = v.price; // Giá gốc
                listItem.dataset.stock = v.stock;
                // SỬA: Dùng logic của File 1: promo là 'Có' hoặc 'Không'
                listItem.dataset.promo = isDiscounted ? 'Có' : 'Không'; 
                listItem.dataset.promoPrice = v.discount_price || 0; // Giá giảm
                listItem.dataset.weight = v.weight || ''; // Giữ nguyên giá trị rỗng nếu null
                listItem.dataset.unit = v.unit || '';
                listItem.dataset.status = v.status;
                listItem.dataset.imageUrl = v.image_url;
                
                // Tên hiển thị variant name (giả định)
                const variantName = v.color && v.size ? `${v.color} / ${v.size}` : (v.color || v.size || 'Biến thể');


                listItem.innerHTML = `
                    <h4 class="font-bold text-gray-800">${variantName}</h4>
                    <p class="text-sm text-gray-600">ID: ${v.variant_id} | Tồn: ${v.stock}</p>
                    <p class="text-sm text-gray-600">${priceText}</p>
                `;
                
                // Gán sự kiện click cho item
                listItem.addEventListener('click', handleVariantListItemClickFromAjax);

                listContainer.appendChild(listItem);
                
                // Highlight nếu là item hiện tại
                if (String(v.variant_id) === String(currentVariantId)) {
                    listItem.classList.add('bg-gray-100');
                }
            });
            
             // Cập nhật lại currentVariantId nếu nó không được truyền hoặc không tồn tại
             let initialVariantToLoad = variants.find(v => String(v.variant_id) === String(currentVariantId)) || variants[0];
            
             if (initialVariantToLoad) {
                 loadVariantIntoManageForm(initialVariantToLoad);
                 // Đảm bảo item đầu tiên/hiện tại được highlight
                 document.querySelector(`.variant-list-item[data-variant-id="${initialVariantToLoad.variant_id}"]`)?.classList.add('bg-gray-100');
              }

        } else {
            listContainer.innerHTML = '<p class="text-gray-500 p-4">Chưa có biến thể nào.</p>';
            // SỬA: Reset form quản lý khi không có biến thể nào để tránh lỗi
            document.getElementById('manageVariantForm').reset();
            document.getElementById('manage-variant-id').value = '';
        }

        // Đảm bảo Form quản lý biến thể hiện thị khi có biến thể
        if (variants.length > 0) {
            showVariantView('manage'); 
        } else {
             // Nếu không có biến thể, chuyển sang chế độ thêm
            showVariantView('add');
        }
    }


    // ------------------------------------------------------------------
    // --- CORE LOGIC HANDLERS (SỬA: Để khớp ID/Classes/Structure của File 2 nhưng giữ logic AJAX của File 1) ---
    // ------------------------------------------------------------------

    // Hàm load dữ liệu biến thể vào form quản lý
    function loadVariantIntoManageForm(v) {
        // SỬA: Chuyển đổi giá trị thành số nguyên/float hoặc chuỗi trước khi gán
        document.getElementById('manage-variant-id').value = v.variant_id || '';
        document.getElementById('manage-variant-price').value = parseFloat(v.price) || 0;
        document.getElementById('manage-variant-stock').value = parseInt(v.stock) || 0;
        document.getElementById('manage-variant-promo-price').value = parseFloat(v.discount_price) || 0;
        document.getElementById('manage-variant-weight').value = v.weight || '';
        document.getElementById('manage-variant-unit').value = v.unit || '';
        document.getElementById('manage-variant-color').value = v.color || '';
        document.getElementById('manage-variant-size').value = v.size || '';
        
        const imageUrl = v.image_url || DEFAULT_IMAGE;
        document.getElementById('manage-variant-image-preview').src = imageUrl;
        document.getElementById('manage-variant-image-url').value = imageUrl; 
        document.getElementById('manage-variant-image-url-input').value = ''; // Reset input file

        // ĐẶT GIÁ TRỊ CUSTOM SELECT
        setCustomMultiselectValues(document.querySelector('#manageVariantView [data-select-id="manage-variant-status"]'), v.status);
        // SỬA: Dùng logic của File 1: promo là 'Có' hoặc 'Không'
        const promoStatus = (v.discount_price && parseFloat(v.discount_price) > 0) ? 'Có' : 'Không'; 
        setCustomMultiselectValues(document.querySelector('#manageVariantView [data-select-id="manage-variant-promo"]'), promoStatus);

        // Kích hoạt logic bật/tắt input giá giảm (chủ động kích hoạt)
        const promoPriceInput = document.getElementById('manage-variant-promo-price');
        if (promoStatus === 'Có') {
            promoPriceInput.classList.remove('bg-gray-100');
            promoPriceInput.readOnly = false;
        } else {
            promoPriceInput.classList.add('bg-gray-100');
            promoPriceInput.readOnly = true;
        }


        // Highlight item trong sidebar
        document.querySelectorAll('.variant-list-item').forEach(i => i.classList.remove('bg-gray-100'));
        const currentItem = document.querySelector(`.variant-list-item[data-variant-id="${v.variant_id}"]`);
        if (currentItem) currentItem.classList.add('bg-gray-100');
    }

    // Hàm load dữ liệu sản phẩm vào form quản lý (tương tự handleProductRowClick của File 1)
    function handleProductRowClick(e) {
        // SỬA: Kiểm tra class open-variant-trigger của File 1 (vì File 2 dùng open-variant-modal-trigger và open-variant-trigger)
        if (e.target.closest('.open-variant-modal-trigger') || e.target.closest('.open-variant-trigger')) {
            return; // Bỏ qua nếu click vào nút/link biến thể
        }
        
        // Dùng data-* attribute của File 2 để populate
        const row = this;
        document.getElementById('manage-product_id').value = row.dataset.product_id;
        document.getElementById('manage-product_id_display').value = row.dataset.product_id; // Input display
        document.getElementById('manage-product_name').value = row.dataset.product_name;
        document.getElementById('manage-origin').value = row.dataset.origin;
        document.getElementById('manage-description').value = row.dataset.description;
        document.getElementById('manage-brand').value = row.dataset.brand; 
        
        // Ảnh
        const imageUrl = row.dataset.image_url ? row.dataset.image_url : DEFAULT_IMAGE;
        document.getElementById('manage-image_url_preview').src = imageUrl;
        document.getElementById('manage-image_url_hidden').value = imageUrl; 
        document.getElementById('manage-image_url_input').value = ''; // Reset input file

        setCustomMultiselectValues(document.querySelector('[data-select-id="manage-category_id"]'), row.dataset.category_id);
        setCustomMultiselectValues(document.querySelector('[data-select-id="manage-status"]'), row.dataset.product_status);
        
        // Đóng modal thêm sản phẩm (nếu đang mở) và mở modal quản lý
        closeModal(document.getElementById('addProductModal')); 
        // SỬA: Sử dụng ID của File 2 là manageProductModal
        openModal(document.getElementById('manageProductModal')); 
        
        // Reset flash message
        document.getElementById('editProductFlash').innerHTML = '';
    }

    // Hàm xử lý mở modal biến thể (từ bảng chính)
    async function handleVariantModalTriggerClick(e) {
        e.preventDefault();
        e.stopPropagation();

        const productId = this.dataset.productId;
        const mode = this.dataset.mode;
        const variantId = this.dataset.variantId; 

        document.getElementById('current-product-id').value = productId;
        document.getElementById('add-variant-product-id').value = productId;

        // Reset flash message
        document.getElementById('manageVariantFlash').innerHTML = '';
        document.getElementById('addVariantFlash').innerHTML = '';


        // Fetch danh sách biến thể
        try {
            // Dùng AJAX để lấy danh sách biến thể
            const res = await fetch(`/admin/store/products/${productId}/variants`);
            const data = await res.json();
            
            if (res.ok && data.success) {
                const productRow = document.querySelector(`.product-row-trigger[data-product_id="${productId}"]`);
                const productName = productRow ? productRow.dataset.product_name : 'Sản phẩm không tên';
                
                // Sử dụng variantId để highlight item tương ứng trong sidebar
                renderVariants(productName, data.variants, productId, variantId);
                
                if (mode === 'add') {
                    showVariantView('add');
                } else if (mode === 'manage' && variantId) {
                    const variantToLoad = data.variants.find(v => String(v.variant_id) === String(variantId));
                    if (variantToLoad) {
                        loadVariantIntoManageForm(variantToLoad);
                        showVariantView('manage');
                    } else {
                        // Fallback nếu không tìm thấy biến thể (lỗi data), chuyển sang chế độ thêm
                        showVariantView('add');
                        showFlash(document.getElementById('addVariantFlash'), 'Không tìm thấy biến thể. Vui lòng thêm mới.', false);
                    }
                } else if (mode === 'manage' && data.variants.length > 0) {
                         // Trường hợp chỉ click vào dòng (chưa chọn variant) và có variant, load cái đầu tiên
                    loadVariantIntoManageForm(data.variants[0]);
                    showVariantView('manage');
                }

                // SỬA: Đóng modal quản lý và mở modal biến thể
                closeModal(document.getElementById('manageProductModal')); 
                openModal(document.getElementById('variantModal'));
            } else {
                alert('Không thể tải danh sách biến thể: ' + (data.message || 'Lỗi server ' + res.status));
            }
        } catch (error) {
            console.error('Error fetching variants:', error);
            alert('Lỗi kết nối khi tải biến thể.');
        }
    }

    // Hàm xử lý click vào item trong sidebar (tương tự handleVariantListItemClick của File 1)
    function handleVariantListItemClickFromAjax() {
        // Dữ liệu đã được lưu trong dataset khi render
        const vData = this.dataset;
        
        // Tạo object tương thích với cấu trúc của loadVariantIntoManageForm
        const variant = {
            variant_id: vData.variantId,
            color: vData.color,
            size: vData.size,
            price: parseFloat(vData.price) || 0,
            discount_price: parseFloat(vData.promoPrice) || 0,
            stock: parseInt(vData.stock) || 0,
            weight: vData.weight,
            unit: vData.unit,
            status: vData.status,
            image_url: vData.imageUrl,
            is_discounted: vData.promo === 'Có'
        };

        loadVariantIntoManageForm(variant);
        showVariantView('manage');
        
        // Bỏ highlight tất cả và highlight item hiện tại
        document.querySelectorAll('.variant-list-item').forEach(i => i.classList.remove('bg-gray-100'));
        this.classList.add('bg-gray-100');
    }

    // Hàm chuyển đổi view trong modal biến thể
    function showVariantView(viewToShow) {
        document.getElementById('manageVariantView').classList.toggle('hidden', viewToShow === 'add');
        document.getElementById('addVariantView').classList.toggle('hidden', viewToShow === 'manage');
        
        // Reset form Thêm biến thể khi chuyển sang chế độ quản lý
        if (viewToShow === 'manage') {
            document.getElementById('addVariantForm').reset();
            document.getElementById('add-variant-image-preview').src = DEFAULT_IMAGE;
            document.getElementById('add-variant-image-url-input').value = '';
            document.getElementById('add-variant-promo-price').readOnly = true;
            document.getElementById('add-variant-promo-price').classList.add('bg-gray-100');
            document.getElementById('addVariantFlash').innerHTML = '';
             // Reset custom select cho trạng thái/khuyến mãi
            setCustomMultiselectValues(document.querySelector('#addVariantView [data-select-id="add-variant-status"]'), 'active');
            setCustomMultiselectValues(document.querySelector('#addVariantView [data-select-id="add-variant-promo"]'), 'Không');
        }
        
        // Reset form Quản lý biến thể khi chuyển sang chế độ thêm (chủ yếu là flash)
        if (viewToShow === 'add') {
             document.getElementById('manageVariantFlash').innerHTML = '';
             document.getElementById('manage-variant-image-url-input').value = '';
        }
    }

    // Hàm cập nhật lại giao diện bảng chính sau khi AJAX thành công (Logic tương tự File 1)
    async function refreshProductTable() {
        try {
            // SỬA: Thêm tham số `?page=` để giữ trang hiện tại khi refresh
            const currentPage = new URLSearchParams(window.location.search).get('page') || 1;
            const res = await fetch(`/admin/store?page=${currentPage}`); 
            const html = await res.text();
            
            if (res.ok) { 
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTbody = doc.getElementById('product-list-body');
                // Lấy phần phân trang mới
                const newPagination = doc.querySelector('.mt-4.flex.justify-center');

                if (newTbody) {
                    const currentTbody = document.getElementById('product-list-body');
                    if (currentTbody) {
                        currentTbody.innerHTML = newTbody.innerHTML;
                    }

                    // Cập nhật phần phân trang
                    const currentPaginationContainer = document.querySelector('.mt-4.flex.justify-center');
                    if (currentPaginationContainer && newPagination) {
                         currentPaginationContainer.innerHTML = newPagination.innerHTML;
                    } else if (currentPaginationContainer && !newPagination) {
                         currentPaginationContainer.innerHTML = '';
                    } else if (!currentPaginationContainer && newPagination) {
                         // Trường hợp ban đầu không có phân trang, nhưng sau khi thêm/sửa thì có
                         document.querySelector('.bg-white.p-6.rounded-lg.shadow-xl').appendChild(newPagination);
                    }


                    // Gán lại sự kiện cho các dòng mới
                    document.querySelectorAll('.product-row-trigger').forEach(row => {
                        row.removeEventListener('click', handleProductRowClick); // Tránh gán trùng
                        row.addEventListener('click', handleProductRowClick);
                    });
                    document.querySelectorAll('.open-variant-modal-trigger').forEach(trigger => {
                        trigger.removeEventListener('click', handleVariantModalTriggerClick); // Tránh gán trùng
                        trigger.addEventListener('click', handleVariantModalTriggerClick);
                    });
                }
            } else {
                console.error('API refresh product table trả về lỗi:', res.statusText);
                location.reload(); // Fallback: Reload trang nếu lỗi
            }
        } catch (error) {
            console.error('Error refreshing table:', error);
            location.reload(); // Fallback: Reload trang nếu lỗi
        }
    }


    // ------------------------------------------------------------------
    // --- LOGIC ĐÓNG/HỦY (SỬA LOGIC THEO FILE 2) ---
    // ------------------------------------------------------------------

    // Hàm reset form chi tiết (LẤY TỪ FILE 2)
    function resetModalForm(modalId) {
        if (modalId === 'addProductModal') {
            // Reset form Thêm Sản phẩm
            document.getElementById('addProductForm').reset();
            document.getElementById('add-image_url_input').value = ''; 
            document.getElementById('add-image_url_preview').src = DEFAULT_IMAGE;
            setCustomMultiselectValues(document.querySelector('[data-select-id="add-category_id"]'), '');
            setCustomMultiselectValues(document.querySelector('[data-select-id="add-product-status"]'), 'active');
            document.getElementById('addProductFlash').innerHTML = ''; 
        } else if (modalId === 'manageProductModal') {
            // Reset form Quản lý Sản phẩm (Chỉ reset flash/file input)
            document.getElementById('manageProductForm').reset(); // Reset form sẽ xóa giá trị
            // KHÔNG reset các input chính để giữ lại data nếu cần (File 2 không reset các input chính)
            document.getElementById('editProductFlash').innerHTML = '';
        } else if (modalId === 'variantModal') {
            // Reset form Thêm Biến thể và flash của cả 2 view
            document.getElementById('addVariantForm').reset();
            document.getElementById('add-variant-image-preview').src = DEFAULT_IMAGE;
            document.getElementById('add-variant-image-url-input').value = '';
            document.getElementById('addVariantFlash').innerHTML = '';
            setCustomMultiselectValues(document.querySelector('#addVariantView [data-select-id="add-variant-status"]'), 'active');
            setCustomMultiselectValues(document.querySelector('#addVariantView [data-select-id="add-variant-promo"]'), 'Không');
            showVariantView('manage'); // Chuyển về chế độ quản lý (mặc dù form quản lý có thể trống)
            document.getElementById('manageVariantFlash').innerHTML = '';
        }
    }

    // Hàm thực hiện reset và đóng modal (LẤY TỪ FILE 2)
    function resetAndCloseModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            // Chỉ reset form khi nhấn Hủy/thoát modal thêm hoặc modal biến thể
            if (modalId === 'addProductModal' || modalId === 'variantModal') {
                 resetModalForm(modalId); 
            }
            // Đối với manageProductModal, chỉ cần đóng, không reset data để lần sau mở có thể thấy data cũ
            // Tuy nhiên, để nhất quán, ta vẫn reset các trường không phải data chính (Flash, file input)
            if (modalId === 'manageProductModal') {
                 document.getElementById('manage-image_url_input').value = ''; // Reset file input
                 document.getElementById('editProductFlash').innerHTML = ''; // Reset flash
            }
            closeModal(modal);
        }
    }


    // Thiết lập listener cho từng modal container (LẤY TỪ FILE 2)
    function setupModalCloseListeners() {
        document.querySelectorAll('.modal-container').forEach(modal => {
            const modalId = modal.id;
            
            // 1. Click vào nút Hủy (class close-modal)
            modal.querySelectorAll('.close-modal').forEach(btn => {
                 btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation(); 
                    
                    // Nút Hủy thực hiện reset và đóng
                    resetAndCloseModal(modalId);
                 });
            });
            
            // 2. Click vào nền mờ (chính modal container)
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    e.preventDefault();
                    e.stopPropagation(); 
                    
                    // Nếu click nền, chỉ đóng, nhưng reset form Thêm và Biến thể để không giữ lại dở dang
                    if (modalId === 'addProductModal' || modalId === 'variantModal') {
                        resetAndCloseModal(modalId);
                    } else {
                        // Đối với manageProductModal, chỉ đóng và reset nhẹ (flash, file input)
                        if (modalId === 'manageProductModal') {
                             document.getElementById('manage-image_url_input').value = ''; // Reset file input
                             document.getElementById('editProductFlash').innerHTML = ''; // Reset flash
                        }
                        closeModal(modal);
                    }
                }
            });
            
            // Ngăn chặn click vào nội dung modal làm đóng modal
            modal.querySelector('.bg-white')?.addEventListener('click', function(e) {
                 e.stopPropagation();
            });
        });
        
        // 3. Escape key (LẤY TỪ FILE 2)
        document.addEventListener('keydown', function(e) {
             if (e.key === 'Escape') {
                 // Đóng modal trên cùng đang mở và reset nó
                 const openModals = Array.from(document.querySelectorAll('.modal-container.flex'));
                 if (openModals.length > 0) {
                     // Chọn modal trên cùng (modal cuối cùng được thêm vào DOM hoặc modal cuối cùng có class 'flex')
                     const topModal = openModals[openModals.length - 1];
                     resetAndCloseModal(topModal.id);
                 }
             }
        });
    }


    document.addEventListener('DOMContentLoaded', function() {
        
        initializeCustomMultiselects(); 

        // --- KHỞI TẠO LOGIC ĐÓNG/HỦY MODAL MỚI ---
        setupModalCloseListeners();

        // --- KHỞI TẠO LOGIC UPLOAD ẢNH CHO CÁC MODAL (Đã sửa lại ID/name) ---
        // SỬA: Đảm bảo hiddenId của add-image_url_input là add-image_url
        setupImage('add-image-upload-btn', 'add-image_url_input', 'add-image_url_preview', 'add-image_url');
        setupImage('manage-image-upload-btn', 'manage-image_url_input', 'manage-image_url_preview', 'manage-image_url_hidden');
        // SỬA: Đảm bảo hiddenId của add-variant-image-url-input là add-variant-image-url
        setupImage('add-variant-image-upload-btn', 'add-variant-image-url-input', 'add-variant-image-preview', 'add-variant-image-url');
        // SỬA: Đảm bảo hiddenId của manage-variant-image-url-input là manage-variant-image-url
        setupImage('manage-variant-image-upload-btn', 'manage-variant-image-url-input', 'manage-variant-image-preview', 'manage-variant-image-url');


        // --- GÁN SỰ KIỆN CHUNG CHO BẢNG & MODAL BIẾN THỂ (Giữ nguyên logic của File 1) ---
        
        // Gán sự kiện cho nút "Thêm" tổng (mở modal thêm sản phẩm)
        document.getElementById('openAddProductModalBtn').addEventListener('click', function() {
            // Sử dụng resetAndCloseModal để đảm bảo reset form trước khi mở (từ File 2)
            resetModalForm('addProductModal');
            openModal(document.getElementById('addProductModal'));
        });

        // Gán sự kiện cho các dòng sản phẩm (Mở Modal Quản lý Sản phẩm)
        document.querySelectorAll('.product-row-trigger').forEach(row => {
            row.addEventListener('click', handleProductRowClick);
        });

        // Gán sự kiện cho các nút/link mở Modal Biến thể
        document.querySelectorAll('.open-variant-modal-trigger').forEach(trigger => {
            trigger.addEventListener('click', handleVariantModalTriggerClick);
        });

        // Logic chuyển đổi view trong modal biến thể
        document.getElementById('switchToAddeVariantBtn').addEventListener('click', function() {
            showVariantView('add'); 
        });

        document.getElementById('switchBackToManageBtn').addEventListener('click', async function() {
             // Khi quay lại quản lý, cần đảm bảo form có dữ liệu của biến thể đầu tiên
            const currentProductId = document.getElementById('current-product-id').value;
             try {
                 const res = await fetch(`/admin/store/products/${currentProductId}/variants`);
                 const data = await res.json();
                 if (res.ok && data.success && data.variants.length > 0) {
                     loadVariantIntoManageForm(data.variants[0]);
                     showVariantView('manage');
                 } else {
                     showVariantView('add'); // Vẫn ở chế độ thêm nếu không có variant
                 }
             } catch (error) {
                 console.error('Error fetching variants on switch:', error);
                 showVariantView('add'); // Vẫn ở chế độ thêm nếu lỗi
             }
        });


        // --- LOGIC FORM SUBMIT (Giữ nguyên logic AJAX của File 1) ---

        // 1. FORM THÊM SẢN PHẨM
        document.getElementById('addProductForm').onsubmit = async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const flash = document.getElementById('addProductFlash');
            
            // SỬA: Đảm bảo chỉ có 1 trường ảnh hợp lệ được gửi
            const imageFileInput = document.getElementById('add-image_url_input'); // name="image_url"
            const currentImageUrl = document.getElementById('add-image_url').value; // name="default_image_url" (nên dùng default_image_url trong form)

            if (imageFileInput.files && imageFileInput.files.length > 0) {
                formData.delete('default_image_url'); 
            } else {
                // Nếu không có file mới, gửi URL hiện tại (nếu có, không cần gửi placeholder)
                if (currentImageUrl.includes('placeholder.com')) {
                    formData.delete('image_url');
                    formData.delete('default_image_url');
                } else {
                    formData.set('image_url', currentImageUrl);
                    formData.delete('default_image_url');
                }
            }


            try {
                // SỬA: Đã loại bỏ headers: { 'X-CSRF-TOKEN': CSRF_TOKEN } vì FormData đã bao gồm token
                const res = await fetch('/admin/store/products', { method: 'POST', body: formData });
                const data = await res.json();
                
                showFlash(flash, data.message, data.success);
                if (data.success) {
                    closeModal(document.getElementById('addProductModal'));
                    await refreshProductTable();
                } else if (data.errors) {
                    const errorMsg = Object.values(data.errors).map(e => e.join('<br>')).join('<br>');
                    showFlash(flash, errorMsg, false);
                } else if (res.status !== 200) {
                    showFlash(flash, `Lỗi Server: ${res.status} ${res.statusText}`, false);
                }
            } catch (err) { 
                console.error('Lỗi: ', err);
                showFlash(flash, 'Lỗi kết nối hoặc validation', false); 
            }
        };

        // 2. FORM QUẢN LÝ SẢN PHẨM
        document.getElementById('manageProductForm').onsubmit = async function(e) {
            e.preventDefault();
            const productId = document.getElementById('manage-product_id').value;
            const formData = new FormData(this);
            
            // Xử lý _method PUT (File 2 đã có input hidden cho PUT nhưng vẫn cần set)
            formData.set('_method', 'PUT'); 
            
            // SỬA: Đảm bảo chỉ có 1 trường ảnh hợp lệ được gửi
            const imageFileInput = document.getElementById('manage-image_url_input'); // name="image_url"
            const currentImageUrl = document.getElementById('manage-image_url_hidden').value; // name="default_image_url"

            if (imageFileInput.files && imageFileInput.files.length > 0) {
                // File mới được chọn, Controller sẽ nhận image_url (từ input file)
                formData.delete('default_image_url'); // Xóa trường URL cũ
            } else {
                // Không có file mới, Controller sẽ nhận image_url (từ input hidden)
                // Đổi tên trường hidden từ default_image_url sang image_url để tương thích với File 1
                formData.set('image_url', currentImageUrl);
                formData.delete('default_image_url');
            }


            const flash = document.getElementById('editProductFlash');
            try {
                // Phải dùng POST vì PUT không hỗ trợ multipart/form-data
                // SỬA: Đã loại bỏ headers: { 'X-CSRF-TOKEN': CSRF_TOKEN } vì FormData đã bao gồm token
                const res = await fetch(`/admin/store/products/${productId}`, { method: 'POST', body: formData });
                const data = await res.json();
                
                showFlash(flash, data.message, data.success);
                if (data.success) {
                    closeModal(document.getElementById('manageProductModal'));
                    await refreshProductTable();
                } else if (data.errors) {
                    const errorMsg = Object.values(data.errors).map(e => e.join('<br>')).join('<br>');
                    showFlash(flash, errorMsg, false);
                } else if (res.status !== 200) {
                    showFlash(flash, `Lỗi Server: ${res.status} ${res.statusText}`, false);
                }
            } catch (err) { 
                console.error('Lỗi: ', err);
                showFlash(flash, 'Lỗi kết nối hoặc validation', false); 
            }
        };

        // 3. XÓA SẢN PHẨM
        document.getElementById('deleteProductBtn').onclick = async function() {
            if (!confirm('Xóa sản phẩm này sẽ xóa tất cả biến thể liên quan. Bạn có chắc chắn?')) return;
            const productId = document.getElementById('manage-product_id').value;
            const flash = document.getElementById('editProductFlash');
            
            try {
                const res = await fetch(`/admin/store/products/${productId}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF_TOKEN } });
                const data = await res.json();
                
                showFlash(flash, data.message, data.success);
                if (data.success) {
                    closeModal(document.getElementById('manageProductModal'));
                    await refreshProductTable();
                } else if (res.status !== 200) {
                    showFlash(flash, `Lỗi Server: ${res.status} ${res.statusText}`, false);
                }
            } catch { showFlash(flash, 'Lỗi kết nối', false); }
        };

        // 4. FORM THÊM BIẾN THỂ (ĐÃ SỬA LỖI KHÔNG GỬI ĐƯỢC FILE VÀ THIẾU CSRF TOKEN)
        document.getElementById('addVariantForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const productId = document.getElementById('add-variant-product-id').value;
            const formData = new FormData(this);
            const flash = document.getElementById('addVariantFlash');
            
            // Xử lý logic Giá giảm/Promo (Đảm bảo giá giảm là 0 nếu chọn "Không")
            const promoStatus = document.querySelector('#addVariantView [data-select-id="add-variant-promo"] select').value;
            if (promoStatus === 'Không') {
                 formData.set('discount_price', 0);
            }
            
            // SỬA: Đảm bảo chỉ có 1 trường ảnh hợp lệ được gửi
            const imageFileInput = document.getElementById('add-variant-image-url-input'); // name="image_file"
            const currentImageUrl = document.getElementById('add-variant-image-url').value; // name="image_url"

            if (imageFileInput.files && imageFileInput.files.length > 0) {
                 formData.delete('image_url'); 
            } else {
                 formData.delete('image_file');
                 // Nếu không có file mới, gửi URL hiện tại
                 formData.set('image_url', currentImageUrl);
            }

            // SỬA: Xóa dòng set token cũ
            // formData.set('_token', CSRF_TOKEN); // Dòng này không cần thiết vì form đã có @csrf

            try {
                // SỬA: Đã loại bỏ headers: { 'X-CSRF-TOKEN': CSRF_TOKEN } vì FormData đã bao gồm token
                const res = await fetch(`/admin/store/products/${productId}/variants`, {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                
                showFlash(flash, data.message, data.success);
                if (data.success) {
                    // Tải lại variants trong modal và cập nhật bảng chính
                    const productRes = await fetch(`/admin/store/products/${productId}/variants`);
                    const productData = await productRes.json();
                    if (productRes.ok && productData.success) {
                         const productRow = document.querySelector(`.product-row-trigger[data-product_id="${productId}"]`);
                         const productName = productRow ? productRow.dataset.product_name : 'Sản phẩm không tên';
                         // Lấy ID biến thể vừa được thêm để highlight
                         const newVariantId = data.variant ? data.variant.variant_id : (productData.variants.length > 0 ? productData.variants[0].variant_id : null);
                         renderVariants(productName, productData.variants, productId, newVariantId); // Load lại và highlight biến thể mới
                    }
                    this.reset();
                    document.getElementById('add-variant-image-preview').src = DEFAULT_IMAGE;
                    document.getElementById('add-variant-image-url-input').value = '';
                    // Reset custom select cho trạng thái/khuyến mãi
                    setCustomMultiselectValues(document.querySelector('#addVariantView [data-select-id="add-variant-status"]'), 'active');
                    setCustomMultiselectValues(document.querySelector('#addVariantView [data-select-id="add-variant-promo"]'), 'Không');
                    showVariantView('manage'); // Chuyển sang chế độ quản lý
                    await refreshProductTable();
                } else if (data.errors) {
                    const errorMsg = Object.values(data.errors).map(e => e.join('<br>')).join('<br>');
                    showFlash(flash, errorMsg, false);
                } else if (res.status !== 200) {
                    showFlash(flash, `Lỗi Server: ${res.status} ${res.statusText}`, false);
                }
            } catch (err) {
                console.error('Lỗi: ', err);
                showFlash(flash, 'Lỗi kết nối hoặc validation', false);
            }
        });

        // 5. FORM QUẢN LÝ BIẾN THỂ (ĐÃ SỬA LỖI THIẾU CSRF TOKEN)
        document.getElementById('manageVariantForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const productId = document.getElementById('current-product-id').value;
            const variantId = document.getElementById('manage-variant-id').value;
            const formData = new FormData(this);
            formData.set('_method', 'PUT'); // Cần thiết cho update qua POST
            const flash = document.getElementById('manageVariantFlash');

            // Xử lý logic Giá giảm/Promo (Đảm bảo giá giảm là 0 nếu chọn "Không")
            const promoStatus = document.querySelector('#manageVariantView [data-select-id="manage-variant-promo"] select').value;
            if (promoStatus === 'Không') {
                 formData.set('discount_price', 0);
            }
            
            // SỬA: Đảm bảo chỉ có 1 trường ảnh hợp lệ được gửi
            const imageFileInput = document.getElementById('manage-variant-image-url-input'); // name="image_file"
            const currentImageUrl = document.getElementById('manage-variant-image-url').value; // name="image_url"

            if (imageFileInput.files && imageFileInput.files.length > 0) {
                 // File mới được chọn, Controller sẽ nhận image_file
                 formData.delete('image_url'); 
            } else {
                 // Không có file mới, Controller sẽ nhận image_url
                 formData.delete('image_file');
                 formData.set('image_url', currentImageUrl);
            }
            
            // SỬA: Xóa dòng set token cũ
            // formData.set('_token', CSRF_TOKEN); // Dòng này không cần thiết vì form đã có @csrf

            try {
                // Phải dùng POST vì PUT không hỗ trợ multipart/form-data
                // SỬA: Đã loại bỏ headers: { 'X-CSRF-TOKEN': CSRF_TOKEN } vì FormData đã bao gồm token
                const res = await fetch(`/admin/store/products/${productId}/variants/${variantId}`, {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                
                showFlash(flash, data.message, data.success);
                if (data.success) {
                    // Tải lại variants trong modal và cập nhật bảng chính
                    const productRes = await fetch(`/admin/store/products/${productId}/variants`);
                    const productData = await productRes.json();
                    if (productRes.ok && productData.success) {
                         const productRow = document.querySelector(`.product-row-trigger[data-product_id="${productId}"]`);
                         const productName = productRow ? productRow.dataset.product_name : 'Sản phẩm không tên';
                         renderVariants(productName, productData.variants, productId, data.variant.variant_id); // Load lại và highlight biến thể vừa sửa
                    }
                    await refreshProductTable();
                } else if (data.errors) {
                    const errorMsg = Object.values(data.errors).map(e => e.join('<br>')).join('<br>');
                    showFlash(flash, errorMsg, false);
                } else if (res.status !== 200) {
                    showFlash(flash, `Lỗi Server: ${res.status} ${res.statusText}`, false);
                }
            } catch (err) {
                console.error('Lỗi: ', err);
                showFlash(flash, 'Lỗi kết nối hoặc validation', false);
            }
        });

        // 6. XÓA BIẾN THỂ
        document.getElementById('deleteVariantBtn').addEventListener('click', async function() {
            if (!confirm('Xóa biến thể này?')) return;
            const productId = document.getElementById('current-product-id').value;
            const variantId = document.getElementById('manage-variant-id').value;
            const flash = document.getElementById('manageVariantFlash');

            try {
                const res = await fetch(`/admin/store/products/${productId}/variants/${variantId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }
                });
                const data = await res.json();
                
                showFlash(flash, data.message, data.success);
                if (data.success) {
                    // Tải lại variants trong modal và cập nhật bảng chính
                    const productRes = await fetch(`/admin/store/products/${productId}/variants`);
                    const productData = await productRes.json();
                    const productRow = document.querySelector(`.product-row-trigger[data-product_id="${productId}"]`);
                    const productName = productRow ? productRow.dataset.product_name : 'Sản phẩm không tên';
                    
                    // Load lại variants
                    if (productRes.ok && productData.success) {
                        renderVariants(productName, productData.variants, productId);
                    } else {
                        // Nếu API lỗi, chỉ hiển thị rỗng và chuyển sang chế độ thêm
                        renderVariants(productName, [], productId);
                    }
                    
                    await refreshProductTable();
                } else if (res.status !== 200) {
                    showFlash(flash, `Lỗi Server: ${res.status} ${res.statusText}`, false);
                }
            } catch (err) {
                console.error('Lỗi: ', err);
                showFlash(flash, 'Lỗi kết nối', false);
            }
        });

        // --- LOGIC TẮT/BẬT INPUT GIÁ GIẢM KHI CHỌN "CÓ/KHÔNG" ---
        document.querySelectorAll('#manage-variant-promo, #add-variant-promo').forEach(selectContainer => {
            const hiddenSelect = selectContainer.querySelector('select');
            hiddenSelect.addEventListener('change', function() {
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
            });
        });

        
    });
</script>
@endpush
