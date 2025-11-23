@extends('layouts.ad_layout')

@section('title', 'Quản lý cửa hàng')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- HEADER --}}
<div class="flex justify-between items-center mb-6">
    <div class="flex-1 max-w-md">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" id="searchInput" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-1 focus:ring-black" placeholder="Tìm kiếm ...">
        </div>
    </div>
    
    <div class="flex items-center">
        <div class="flex items-center space-x-3 text-sm text-gray-500 mr-4">
            <span class="font-medium">Hôm nay</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <button id="openAddProductModalBtn" class="flex items-center px-4 py-2 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 transition-colors shadow-md">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Thêm
        </button>
    </div>
</div>

{{-- PRODUCT TABLE --}}
<div class="bg-white p-6 rounded-lg shadow-xl">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Cửa hàng ONLINE</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border-separate border-spacing-y-2">
            <thead class="bg-gray-50 font-montserrat text-[#1f1d1d] text-xs font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left uppercase w-[5%]">ID</th>
                    <th class="px-4 py-3 text-left uppercase w-[15%]">Tên Sản Phẩm</th>
                    <th class="px-4 py-3 text-left uppercase w-[15%]">Loại</th> 
                    <th class="px-4 py-3 text-left uppercase w-[12%]">Thương hiệu</th>
                    <th class="px-4 py-3 text-left uppercase w-[10%]">Nguồn gốc</th>
                    <th class="px-4 py-3 text-left uppercase w-[10%]">Hình</th>
                    <th class="px-4 py-3 text-left uppercase flex-1">Biến thể</th>
                    <th class="px-4 py-3 text-center uppercase w-[10%]">Trạng thái</th>
                </tr>
            </thead>

            <tbody id="product-list-body">
                @forelse ($products as $product)
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
                >
                    <td colspan="8" class="p-0">
                        <div class="flex w-full rounded-lg items-center {{ $loop->even ? 'bg-white' : 'bg-blue-50' }} shadow-sm overflow-hidden">
                            <div class="px-4 py-3 w-[5%] text-sm font-medium text-gray-900">{{ $product->product_id }}</div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700">{{ $product->product_name }}</div>
                            <div class="px-4 py-3 w-[15%] text-sm text-gray-700">{{ $categories[$product->category_id] ?? 'N/A' }}</div>
                            <div class="px-4 py-3 w-[12%] text-sm text-gray-700">{{ $product->brand ?? 'N/A' }}</div>
                            <div class="px-4 py-3 w-[10%] text-sm text-gray-700">{{ $product->origin ?? 'N/A' }}</div>
                            <div class="px-4 py-3 w-[10%]">
                                <img src="{{ $product->image_url }}" onerror="this.src=''" class="w-16 h-12 object-cover rounded-md">
                            </div>
                            <div class="px-4 py-3 flex-1 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <div class="flex flex-col">
                                        @foreach ($product->variants as $variant)
                                        <a href="#" class="text-purple-600 font-medium hover:underline open-variant-modal-trigger"
                                            data-product-id="{{ $product->product_id }}"
                                            data-variant-id="{{ $variant->variant_id }}" 
                                            data-mode="manage">
                                            {{ $variant->color }} / {{ $variant->size }} - {{ number_format($variant->price) }}đ
                                        </a>
                                        @endforeach
                                    </div>
                                    <button class="open-variant-modal-trigger text-blue-500 hover:text-blue-700" data-product-id="{{ $product->product_id }}" data-mode="add">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="px-4 py-3 w-[10%] text-sm text-center">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold leading-5 rounded-full {{ $product->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                                    {{ $product->status == 'active' ? 'Còn hàng' : 'Hết hàng' }}
                                </span>
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

    @if($products instanceof \Illuminate\Contracts\Pagination\Paginator && $products->lastPage() > 1)
        <div class="mt-4 flex justify-center">
            {{ $products->links() }}
        </div>
    @endif
</div>

{{-- MODAL 1: THÊM SẢN PHẨM --}}
<div id="addProductModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-blue-800 to-blue-400 bg-clip-text text-transparent">THÊM SẢN PHẨM</h2>
        <form id="addProductForm" enctype="multipart/form-data"> 
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="add-image_url_preview" src="https://via.placeholder.com/160x160?text=Image" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="add-image-upload-btn" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">Upload ảnh</button>
                    <input type="file" name="image_url" id="add-image_url_input" class="hidden" accept="image/*">
                    <input type="hidden" id="add-image_url" name="default_image_url" value="https://via.placeholder.com/160x160?text=New">
                </div>
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên SP</label>
                        <input type="text" name="product_name" id="add-product_name" class="w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tên loại</label>
                            {{-- CUSTOM SELECT CATEGORY (INLINE) --}}
                            <div class="relative custom-multiselect" data-select-id="add-category_id" data-type="single">
                                <select id="add-category_id" name="category_id" class="hidden">
                                    <option value="" selected disabled>Chọn loại...</option>
                                    @foreach($categories as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none">
                                    <span class="custom-multiselect-display text-gray-500">Chọn loại...</span>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                                </button>
                                <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                    <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                        @foreach($categories as $id => $name)
                                            <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $id }}"><span class="text-sm text-gray-900">{{ $name }}</span></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Xuất xứ</label>
                            <input type="text" name="origin" id="add-origin" value="Việt Nam" class="w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thương hiệu</label>
                        <input type="text" name="brand" id="add-brand" class="w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-x-6 gap-y-4 items-start">
                <label class="col-span-2 block text-sm font-medium text-gray-700 pt-2.5">Mô tả</label>
                <div class="col-span-10">
                    <textarea name="description" id="add-description" rows="5" class="w-full border border-gray-300 rounded-2xl px-4 py-2.5"></textarea>
                </div>
                <label class="col-span-2 block text-sm font-medium text-gray-700 pt-2.5">Trạng thái</label>
                <div class="col-span-4">
                    {{-- CUSTOM SELECT STATUS (INLINE) --}}
                    <div class="relative custom-multiselect" data-select-id="add-product-status" data-type="single">
                        <select id="add-product-status" name="status" class="hidden">
                            @foreach($statuses as $id => $name)
                                <option value="{{ $id }}" {{ $id === 'active' ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none">
                            <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                @foreach($statuses as $id => $name)
                                    <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $id }}"><span class="text-sm text-gray-900">{{ $name }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="addProductFlash" class="mt-4"></div>
            <div class="flex justify-center space-x-4 mt-8">
                <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">Hủy</button>
                <button type="submit" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Lưu thông tin</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL 2: QUẢN LÝ SẢN PHẨM --}}
<div id="manageProductModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl">
        <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-blue-800 to-blue-400 bg-clip-text text-transparent">QUẢN LÝ CỬA HÀNG</h2>
        <form id="manageProductForm" enctype="multipart/form-data"> 
            @csrf @method('PUT')
            <input type="hidden" id="manage-product_id" name="product_id">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="md:col-span-1 flex flex-col items-center">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                        <img id="manage-image_url_preview" src="https://via.placeholder.com/160x160?text=Image" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <button type="button" id="manage-image-upload-btn" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">Upload ảnh</button>
                    <input type="file" id="manage-image_url_input" class="hidden" name="image_url" accept="image/*">
                    <input type="hidden" id="manage-image_url_hidden" name="default_image_url">
                </div>
                <div class="md:col-span-2 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ID</label>
                            <input type="text" id="manage-product_id_display" class="w-full border border-gray-300 bg-gray-100 rounded-2xl px-4 py-2.5" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tên SP</label>
                            <input type="text" id="manage-product_name" name="product_name" class="w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tên loại</label>
                            {{-- CUSTOM SELECT CATEGORY (INLINE) --}}
                            <div class="relative custom-multiselect" data-select-id="manage-category_id" data-type="single">
                                <select id="manage-category_id" name="category_id" class="hidden">
                                    <option value="" selected disabled>Chọn loại...</option>
                                    @foreach($categories as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none">
                                    <span class="custom-multiselect-display text-gray-500">Chọn loại...</span>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                                </button>
                                <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                    <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                        @foreach($categories as $id => $name)
                                            <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $id }}"><span class="text-sm text-gray-900">{{ $name }}</span></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Xuất xứ</label>
                            <input type="text" id="manage-origin" name="origin" class="w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Thương hiệu</label>
                        <input type="text" id="manage-brand" name="brand" class="w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-x-6 gap-y-4 items-start">
                <label class="col-span-2 block text-sm font-medium text-gray-700 pt-2.5">Mô tả</label>
                <div class="col-span-10">
                    <textarea id="manage-description" name="description" rows="5" class="w-full border border-gray-300 rounded-2xl px-4 py-2.5"></textarea>
                </div>
                <label class="col-span-2 block text-sm font-medium text-gray-700 pt-2.5">Trạng thái</label>
                <div class="col-span-4">
                    {{-- CUSTOM SELECT STATUS (INLINE) --}}
                    <div class="relative custom-multiselect" data-select-id="manage-status" data-type="single">
                        <select id="manage-status" name="status" class="hidden">
                            <option value="" selected disabled>Chọn trạng thái...</option>
                            @foreach($statuses as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none">
                            <span class="custom-multiselect-display text-gray-500">Chọn trạng thái...</span>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                            <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                @foreach($statuses as $id => $name)
                                    <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $id }}"><span class="text-sm text-gray-900">{{ $name }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="editProductFlash" class="mt-4"></div>
            <div class="flex justify-between items-center mt-8">
                <button type="button" id="deleteProductBtn" class="px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 font-medium">Xóa sản phẩm</button>
                <div class="flex space-x-4">
                    <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">Hủy</button>
                    <button type="submit" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Lưu thông tin</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL 3: BIẾN THỂ --}}
<div id="variantModal" class="modal-container hidden fixed inset-0 z-50 items-center justify-center">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-7xl"> 
        <div class="flex gap-8">
            <div class="flex-1">
                <input type="hidden" id="current-product-id"> 
                
                {{-- VIEW: QUẢN LÝ BIẾN THỂ --}}
                <div id="manageVariantView">
                    <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-blue-800 to-blue-400 bg-clip-text text-transparent">QUẢN LÝ BIẾN THỂ</h2>
                    <form id="manageVariantForm" enctype="multipart/form-data"> 
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="md:col-span-1 flex flex-col items-center">
                                <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                                    <img id="manage-variant-image-preview" src="https://via.placeholder.com/160x160?text=Image" class="w-full h-full object-cover rounded-lg">
                                </div>
                                <button type="button" id="manage-variant-image-upload-btn" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">Upload ảnh</button>
                                <input type="file" id="manage-variant-image_url_input" class="hidden" name="image_file" accept="image/*"> 
                                <input type="hidden" id="manage-variant-image_url" name="image_url">
                            </div>
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-12 gap-x-6 gap-y-4 items-center">
                                    <label class="col-span-3 block text-sm font-medium text-gray-700">ID</label>
                                    <input type="text" id="manage-variant-id" class="col-span-9 w-full border border-gray-300 bg-gray-100 rounded-2xl px-4 py-2.5" readonly>

                                    <label class="col-span-3 block text-sm font-medium text-gray-700">Màu *</label>
                                    <input type="text" id="manage-variant-color" name="color" required class="col-span-3 w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                                    <label class="col-span-3 block text-sm font-medium text-gray-700 pl-4">Size *</label>
                                    <input type="text" id="manage-variant-size" name="size" required class="col-span-3 w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                                    
                                    <label class="col-span-3 block text-sm font-medium text-gray-700">Giá bán *</label>
                                    <input type="number" id="manage-variant-price" name="price" required min="0" step="0.01" class="col-span-3 w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                                    <label class="col-span-3 block text-sm font-medium text-gray-700 pl-4">Tồn kho *</label>
                                    <input type="number" id="manage-variant-stock" name="stock" required min="0" class="col-span-3 w-full border border-gray-300 rounded-2xl px-4 py-2.5">

                                    <label class="col-span-3 block text-sm font-medium text-gray-700">Áp dụng KM</label>
                                    <div class="col-span-3">
                                        {{-- CUSTOM SELECT PROMO (INLINE) --}}
                                        <div class="relative custom-multiselect" data-select-id="manage-variant-promo" data-type="single">
                                            <select id="manage-variant-promo" name="promo_status" class="hidden">
                                                <option value="Không" selected>Không</option>
                                                @foreach($variant_promos as $name)
                                                    <option value="{{ $name }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none">
                                                <span class="custom-multiselect-display text-gray-500">Chọn...</span>
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                                            </button>
                                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                                    @foreach($variant_promos as $name)
                                                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $name }}"><span class="text-sm text-gray-900">{{ $name }}</span></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="col-span-3 block text-sm font-medium text-gray-700 pl-4">Giá giảm</label>
                                    <input type="number" id="manage-variant-promo-price" name="discount_price" min="0" step="0.01" class="col-span-3 w-full border border-gray-300 bg-gray-100 rounded-2xl px-4 py-2.5" readonly>
                                    
                                    <label class="col-span-3 block text-sm font-medium text-gray-700">Trọng lượng</label>
                                    <input type="number" id="manage-variant-weight" name="weight" step="0.01" class="col-span-3 w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                                    <label class="col-span-3 block text-sm font-medium text-gray-700 pl-4">Đơn vị</label>
                                    <input type="text" id="manage-variant-unit" name="unit" class="col-span-3 w-full border border-gray-300 rounded-2xl px-4 py-2.5">

                                    <label class="col-span-3 block text-sm font-medium text-gray-700">Trạng thái *</label>
                                    <div class="col-span-3">
                                        {{-- CUSTOM SELECT STATUS VARIANT (INLINE) --}}
                                        <div class="relative custom-multiselect" data-select-id="manage-variant-status" data-type="single">
                                            <select id="manage-variant-status" name="status" class="hidden">
                                                <option value="" selected disabled>Chọn...</option>
                                                @foreach($statuses as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none">
                                                <span class="custom-multiselect-display text-gray-500">Chọn...</span>
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                                            </button>
                                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                                    @foreach($statuses as $id => $name)
                                                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $id }}"><span class="text-sm text-gray-900">{{ $name }}</span></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="manageVariantFlash" class="mt-4"></div>
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

                {{-- VIEW: THÊM BIẾN THỂ --}}
                <div id="addVariantView" class="hidden">
                    <h2 class="text-3xl font-bold text-center mb-6 bg-gradient-to-r from-blue-800 to-blue-400 bg-clip-text text-transparent">THÊM BIẾN THỂ</h2>
                    <form id="addVariantForm" enctype="multipart/form-data"> 
                        @csrf
                        <input type="hidden" id="add-variant-product-id" name="product_id">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="md:col-span-1 flex flex-col items-center">
                                <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                                    <img id="add-variant-image-preview" src="https://via.placeholder.com/160x160?text=Image" class="w-full h-full object-cover rounded-lg">
                                </div>
                                <button type="button" id="add-variant-image-upload-btn" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600">Upload ảnh</button>
                                <input type="file" id="add-variant-image_url_input" class="hidden" name="image_file" accept="image/*"> 
                                <input type="hidden" id="add-variant-image_url" name="image_url" value="https://via.placeholder.com/160x160?text=New+Variant">
                            </div>
                            <div class="md:col-span-2">
                                <div class="grid grid-cols-12 gap-x-6 gap-y-4 items-center">
                                    <label class="col-span-3 block text-sm font-medium text-gray-700">Màu *</label>
                                    <input type="text" id="add-variant-color" name="color" required class="col-span-3 w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                                    <label class="col-span-3 block text-sm font-medium text-gray-700 pl-4">Size *</label>
                                    <input type="text" id="add-variant-size" name="size" required class="col-span-3 w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                                    
                                    <label class="col-span-3 block text-sm font-medium text-gray-700">Giá bán *</label>
                                    <input type="number" id="add-variant-price" name="price" required min="0" step="0.01" class="col-span-3 w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                                    <label class="col-span-3 block text-sm font-medium text-gray-700 pl-4">Tồn kho *</label>
                                    <input type="number" id="add-variant-stock" name="stock" required min="0" class="col-span-3 w-full border border-gray-300 rounded-2xl px-4 py-2.5">

                                    <label class="col-span-3 block text-sm font-medium text-gray-700">Áp dụng KM</label>
                                    <div class="col-span-3">
                                        {{-- CUSTOM SELECT PROMO ADD --}}
                                        <div class="relative custom-multiselect" data-select-id="add-variant-promo" data-type="single">
                                            <select id="add-variant-promo" name="promo_status" class="hidden">
                                                <option value="Không" selected>Không</option>
                                                @foreach($variant_promos as $name)
                                                    <option value="{{ $name }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none">
                                                <span class="custom-multiselect-display text-gray-500">Chọn...</span>
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                                            </button>
                                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                                    @foreach($variant_promos as $name)
                                                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $name }}"><span class="text-sm text-gray-900">{{ $name }}</span></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="col-span-3 block text-sm font-medium text-gray-700 pl-4">Giá giảm</label>
                                    <input type="number" id="add-variant-promo-price" name="discount_price" min="0" step="0.01" class="col-span-3 w-full border border-gray-300 bg-gray-100 rounded-2xl px-4 py-2.5" readonly>

                                    <label class="col-span-3 block text-sm font-medium text-gray-700">Trọng lượng</label>
                                    <input type="number" id="add-variant-weight" name="weight" step="0.01" class="col-span-3 w-full border border-gray-300 rounded-2xl px-4 py-2.5">
                                    <label class="col-span-3 block text-sm font-medium text-gray-700 pl-4">Đơn vị</label>
                                    <input type="text" id="add-variant-unit" name="unit" class="col-span-3 w-full border border-gray-300 rounded-2xl px-4 py-2.5">

                                    <label class="col-span-3 block text-sm font-medium text-gray-700">Trạng thái *</label>
                                    <div class="col-span-3">
                                        {{-- CUSTOM SELECT STATUS ADD --}}
                                        <div class="relative custom-multiselect" data-select-id="add-variant-status" data-type="single">
                                            <select id="add-variant-status" name="status" class="hidden">
                                                <option value="" disabled>Chọn...</option>
                                                @foreach($statuses as $id => $name)
                                                    <option value="{{ $id }}" {{ $id == 'active' ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="custom-multiselect-trigger w-full bg-white border border-gray-300 rounded-2xl shadow-sm text-left px-4 py-2.5 flex items-center justify-between focus:outline-none">
                                                <span class="custom-multiselect-display text-gray-500">Chọn...</span>
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                                            </button>
                                            <div class="custom-multiselect-panel hidden absolute z-20 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                                <ul class="custom-multiselect-list max-h-48 overflow-y-auto">
                                                    @foreach($statuses as $id => $name)
                                                        <li class="px-3 py-2 hover:bg-gray-100 cursor-pointer custom-multiselect-option" data-value="{{ $id }}"><span class="text-sm text-gray-900">{{ $name }}</span></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="addVariantFlash" class="mt-4"></div>
                        <div class="flex justify-center space-x-4 mt-8">
                            <button type="button" class="close-modal px-8 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">Hủy</button>
                            <button type="button" id="switchBackToManageBtn" class="px-8 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Quay lại quản lý</button>
                            <button type="submit" class="px-8 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Thêm biến thể</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- CỘT PHẢI: DANH SÁCH BIẾN THỂ --}}
            <div class="w-full max-w-[300px] h-full">
                <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">Các biến thể (<span id="variant-product-name">...</span>)</h3>
                <div id="variant-sidebar-list" class="space-y-3 h-[500px] overflow-y-auto pr-2"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    .custom-multiselect-option:hover { background-color: rgba(153, 153, 153, 0.5); color: #1a202c; }
    .custom-multiselect-option.bg-blue-100 { background-color: rgba(59, 130, 246, 0.5); color: #1a202c; }
    .custom-multiselect-option.bg-blue-100:hover { background-color: rgba(153, 153, 153, 0.5); }
    .custom-multiselect-option { background-color: white; color: #1a202c; }
    #variant-sidebar-list::-webkit-scrollbar { width: 8px; }
    #variant-sidebar-list::-webkit-scrollbar-track { background: transparent; }
    #variant-sidebar-list::-webkit-scrollbar-thumb { background: rgba(153, 153, 153, 0.5); border-radius: 4px; }
    #variant-sidebar-list::-webkit-scrollbar-thumb:hover { background: #777777; }
</style>

<script>
    const DEFAULT_IMAGE = 'https://via.placeholder.com/160x160?text=Image';

    // --- CUSTOM MULTISELECT LOGIC ---
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
                    if (select.id.includes('-promo')) select.dispatchEvent(new Event('change', { bubbles: true }));
                });
            });
            updateMultiselectDisplay(container);

            if (select.name === 'promo_status') { 
                select.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.custom-multiselect')) document.querySelectorAll('.custom-multiselect-panel').forEach(p => p.classList.add('hidden'));
        });
    }

    // --- UTILS ---
    function formatCurrency(amount) {
        const num = (typeof amount === 'string' && amount.trim() !== '') ? parseFloat(amount) : amount;
        return (typeof num !== 'number' || isNaN(num)) ? '0đ' : Math.abs(num).toLocaleString('vi-VN', { maximumFractionDigits: 0 }) + 'đ';
    }

    function showFlash(el, msg, success = true) {
        el.innerHTML = `<div class="p-3 rounded-xl ${success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">${msg}</div>`;
        setTimeout(() => el.innerHTML = '', 5000);
    }

    function setupImage(btnId, inputId, previewId, hiddenId) {
        const btn = document.getElementById(btnId), input = document.getElementById(inputId);
        const preview = document.getElementById(previewId), hidden = document.getElementById(hiddenId);
        if(btn) btn.onclick = () => input.click();
        if(input) input.onchange = e => {
            if (e.target.files?.[0]) {
                const r = new FileReader();
                r.onload = ev => { preview.src = ev.target.result; if(hidden) hidden.value = ''; };
                r.readAsDataURL(e.target.files[0]);
            }
        };
    }

    function closeModal(modal) { modal?.classList.remove('flex'); modal?.classList.add('hidden'); }
    function openModal(modal) { modal?.classList.remove('hidden'); modal?.classList.add('flex'); }

    function renderVariants(productName, variants, productId, currentVariantId = null) {
        const list = document.getElementById('variant-sidebar-list');
        document.getElementById('variant-product-name').textContent = productName;
        list.innerHTML = '';

        if (variants?.length) {
            variants.forEach(v => {
                const isDiscounted = (v.discount_price && parseFloat(v.discount_price) > 0);
                const priceText = isDiscounted ? `<span class="text-red-600 font-bold">${formatCurrency(v.discount_price)}</span> <span class="line-through text-gray-400">${formatCurrency(v.price)}</span>` : formatCurrency(v.price);
                const name = (v.color && v.size) ? `${v.color} / ${v.size}` : (v.color || v.size || 'Biến thể');
                
                const item = document.createElement('a');
                item.href = '#';
                item.className = 'block p-4 border rounded-lg shadow-sm hover:bg-gray-50 variant-list-item';
                Object.assign(item.dataset, { 
                    variantId: v.variant_id, productId, color: v.color, size: v.size, price: v.price, 
                    stock: v.stock, promo: isDiscounted ? 'Có' : 'Không', promoPrice: v.discount_price || 0, 
                    weight: v.weight || '', unit: v.unit || '', status: v.status, imageUrl: v.image_url 
                });
                item.innerHTML = `<h4 class="font-bold text-gray-800">${name}</h4><p class="text-sm text-gray-600">ID: ${v.variant_id} | Tồn: ${v.stock}</p><p class="text-sm text-gray-600">${priceText}</p>`;
                item.addEventListener('click', handleVariantListItemClick);
                list.appendChild(item);
                if (String(v.variant_id) === String(currentVariantId)) item.classList.add('bg-gray-100');
            });
            const initVar = variants.find(v => String(v.variant_id) === String(currentVariantId)) || variants[0];
            if (initVar) loadVariantIntoManageForm(initVar);
            showVariantView('manage');
        } else {
            list.innerHTML = '<p class="text-gray-500 p-4">Chưa có biến thể nào.</p>';
            document.getElementById('manageVariantForm').reset();
            showVariantView('add');
        }
    }

    // --- CORE HANDLERS ---
    function loadVariantIntoManageForm(v) {
        document.getElementById('manage-variant-id').value = v.variant_id || '';
        document.getElementById('manage-variant-price').value = parseFloat(v.price) || 0;
        document.getElementById('manage-variant-stock').value = parseInt(v.stock) || 0;
        document.getElementById('manage-variant-promo-price').value = parseFloat(v.discount_price) || 0;
        document.getElementById('manage-variant-weight').value = v.weight || '';
        document.getElementById('manage-variant-unit').value = v.unit || '';
        document.getElementById('manage-variant-color').value = v.color || '';
        document.getElementById('manage-variant-size').value = v.size || '';
        
        const img = v.image_url || DEFAULT_IMAGE;
        document.getElementById('manage-variant-image-preview').src = img;
        document.getElementById('manage-variant-image_url').value = img;
        document.getElementById('manage-variant-image_url_input').value = '';

        setCustomMultiselectValues(document.querySelector('#manageVariantView [data-select-id="manage-variant-status"]'), v.status);
        const promoStatus = (v.discount_price && parseFloat(v.discount_price) > 0) ? 'Có' : 'Không';
        setCustomMultiselectValues(document.querySelector('#manageVariantView [data-select-id="manage-variant-promo"]'), promoStatus);
        
        const promoInput = document.getElementById('manage-variant-promo-price');
        promoInput.classList.toggle('bg-gray-100', promoStatus !== 'Có');
        promoInput.readOnly = (promoStatus !== 'Có');

        document.querySelectorAll('.variant-list-item').forEach(i => i.classList.remove('bg-gray-100'));
        document.querySelector(`.variant-list-item[data-variant-id="${v.variant_id}"]`)?.classList.add('bg-gray-100');
    }

    function handleProductRowClick(e) {
        if (e.target.closest('.open-variant-modal-trigger')) return;
        const d = this.dataset;
        document.getElementById('manage-product_id').value = d.product_id;
        document.getElementById('manage-product_id_display').value = d.product_id;
        document.getElementById('manage-product_name').value = d.product_name;
        document.getElementById('manage-origin').value = d.origin;
        document.getElementById('manage-description').value = d.description;
        document.getElementById('manage-brand').value = d.brand;
        
        const img = d.image_url || DEFAULT_IMAGE;
        document.getElementById('manage-image_url_preview').src = img;
        document.getElementById('manage-image_url_hidden').value = img;
        document.getElementById('manage-image_url_input').value = '';

        setCustomMultiselectValues(document.querySelector('[data-select-id="manage-category_id"]'), d.category_id);
        setCustomMultiselectValues(document.querySelector('[data-select-id="manage-status"]'), d.product_status);
        
        closeModal(document.getElementById('addProductModal'));
        openModal(document.getElementById('manageProductModal'));
        document.getElementById('editProductFlash').innerHTML = '';
    }

    async function handleVariantModalTriggerClick(e) {
        e.preventDefault(); e.stopPropagation();
        const { productId, mode, variantId } = this.dataset;
        document.getElementById('current-product-id').value = productId;
        document.getElementById('add-variant-product-id').value = productId;
        document.getElementById('manageVariantFlash').innerHTML = '';
        document.getElementById('addVariantFlash').innerHTML = '';

        try {
            const res = await fetch(`/admin/store/products/${productId}/variants`);
            const data = await res.json();
            if (res.ok && data.success) {
                const name = document.querySelector(`.product-row-trigger[data-product_id="${productId}"]`)?.dataset.product_name || 'SP';
                renderVariants(name, data.variants, productId, variantId);
                
                if (mode === 'add') showVariantView('add');
                else if (mode === 'manage' && !variantId && data.variants.length > 0) loadVariantIntoManageForm(data.variants[0]);
                
                closeModal(document.getElementById('manageProductModal'));
                openModal(document.getElementById('variantModal'));
            } else alert('Lỗi tải biến thể');
        } catch { alert('Lỗi kết nối'); }
    }

    function handleVariantListItemClick() {
        const d = this.dataset;
        loadVariantIntoManageForm({
            variant_id: d.variantId, color: d.color, size: d.size, price: d.price, 
            discount_price: d.promoPrice, stock: d.stock, weight: d.weight, unit: d.unit, 
            status: d.status, image_url: d.imageUrl
        });
        showVariantView('manage');
    }

    function showVariantView(view) {
        document.getElementById('manageVariantView').classList.toggle('hidden', view === 'add');
        document.getElementById('addVariantView').classList.toggle('hidden', view === 'manage');
        if (view === 'manage') {
            document.getElementById('addVariantForm').reset();
            document.getElementById('add-variant-image-preview').src = DEFAULT_IMAGE;
            setCustomMultiselectValues(document.querySelector('#addVariantView [data-select-id="add-variant-status"]'), 'active');
            setCustomMultiselectValues(document.querySelector('#addVariantView [data-select-id="add-variant-promo"]'), 'Không');
        } else {
            document.getElementById('manageVariantFlash').innerHTML = '';
        }
    }

    async function refreshProductTable() {
        try {
            const page = new URLSearchParams(location.search).get('page') || 1;
            const res = await fetch(`/admin/store?page=${page}`);
            const html = await res.text();
            const doc = new DOMParser().parseFromString(html, 'text/html');
            const newBody = doc.getElementById('product-list-body');
            if (newBody) {
                document.getElementById('product-list-body').innerHTML = newBody.innerHTML;
                document.querySelectorAll('.product-row-trigger').forEach(r => r.addEventListener('click', handleProductRowClick));
                document.querySelectorAll('.open-variant-modal-trigger').forEach(t => t.addEventListener('click', handleVariantModalTriggerClick));
            }
        } catch { location.reload(); }
    }

    // --- INIT ---
    document.addEventListener('DOMContentLoaded', function() {
        initializeCustomMultiselects();
        
        setupImage('add-image-upload-btn', 'add-image_url_input', 'add-image_url_preview', 'add-image_url');
        setupImage('manage-image-upload-btn', 'manage-image_url_input', 'manage-image_url_preview', 'manage-image_url_hidden');
        setupImage('add-variant-image-upload-btn', 'add-variant-image_url_input', 'add-variant-image-preview', 'add-variant-image_url');
        setupImage('manage-variant-image-upload-btn', 'manage-variant-image_url_input', 'manage-variant-image-preview', 'manage-variant-image_url');

        document.getElementById('openAddProductModalBtn').onclick = () => {
            document.getElementById('addProductForm').reset();
            document.getElementById('add-image_url_preview').src = DEFAULT_IMAGE;
            setCustomMultiselectValues(document.querySelector('[data-select-id="add-category_id"]'), '');
            setCustomMultiselectValues(document.querySelector('[data-select-id="add-product-status"]'), 'active');
            openModal(document.getElementById('addProductModal'));
        };

        document.querySelectorAll('.product-row-trigger').forEach(r => r.addEventListener('click', handleProductRowClick));
        document.querySelectorAll('.open-variant-modal-trigger').forEach(t => t.addEventListener('click', handleVariantModalTriggerClick));

        document.getElementById('switchToAddeVariantBtn').onclick = () => showVariantView('add');
        document.getElementById('switchBackToManageBtn').onclick = () => showVariantView('manage');

        // Close Modals
        document.querySelectorAll('.modal-container').forEach(m => {
            m.addEventListener('click', e => { if(e.target === m) closeModal(m); });
            m.querySelectorAll('.close-modal').forEach(b => b.onclick = () => closeModal(m));
        });
        document.onkeydown = e => { if(e.key === 'Escape') document.querySelectorAll('.modal-container.flex').forEach(closeModal); };

        // Logic Promo Change
        document.querySelectorAll('#manage-variant-promo select, #add-variant-promo select').forEach(s => {
            s.addEventListener('change', function() {
                const isAdd = this.id.includes('add-');
                const input = document.getElementById(isAdd ? 'add-variant-promo-price' : 'manage-variant-promo-price');
                const yes = this.value === 'Có';
                input.classList.toggle('bg-gray-100', !yes);
                input.readOnly = !yes;
                if(!yes) input.value = 0;
            });
        });

        // --- FORMS SUBMIT ---
        const handleForm = async (id, url, method, flashId, modalId, isVariant = false) => {
            document.getElementById(id).onsubmit = async function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                if(method === 'PUT') fd.set('_method', 'PUT');
                
                // Logic ảnh đặc thù
                const prefix = id.includes('manage') ? 'manage' : 'add';
                const vPrefix = isVariant ? '-variant' : '';
                const fileIn = document.getElementById(`${prefix}${vPrefix}-image_url_input`);
                const hiddenIn = document.getElementById(`${prefix}${vPrefix}-image_url${isVariant && prefix === 'manage' ? '' : (prefix === 'manage' ? '_hidden' : '')}`);
                
                if(fileIn.files.length) fd.delete('default_image_url'); 
                else { 
                    if(isVariant) fd.delete('image_file'); 
                    fd.set('image_url', hiddenIn.value); 
                }
                
                // Fix Variant Promo Price
                if(isVariant && document.querySelector(`#${prefix}VariantView [data-select-id$="-promo"] select`).value === 'Không') {
                    fd.set('discount_price', 0);
                }

                const flash = document.getElementById(flashId);
                try {
                    const res = await fetch(url(this), { method: 'POST', body: fd });
                    const data = await res.json();
                    showFlash(flash, data.message, data.success);
                    
                    if (data.success) {
                        showFlash(flash, data.message, true);

                        setTimeout(async () => {
                            if (isVariant) {
                                const pid = document.getElementById('current-product-id').value;
                                const resV = await fetch(`/admin/store/products/${pid}/variants`);
                                const dataV = await resV.json();
                                const name = document.querySelector(`.product-row-trigger[data-product_id="${pid}"]`)?.dataset.product_name;
                                renderVariants(name, dataV.variants, pid, data.variant?.variant_id);
                                if(prefix === 'add') {
                                    document.getElementById(id).reset();

                                    const imgPreviewId = id.replace('Form', '-image-preview');
                                    const imgInputId = id.replace('Form', '-image_url_input');

                                    if(document.getElementById(imgPreviewId)) document.getElementById(imgPreviewId).src = DEFAULT_IMAGE;
                                    if(document.getElementById(imgInputId)) document.getElementById(imgInputId).value = '';

                                    const promoSelectContainer = document.querySelector(`#${prefix}VariantView [data-select-id$="-promo"]`);
                                    if(promoSelectContainer) setCustomMultiselectValues(promoSelectContainer, 'Không');
                                }
                            } else {
                                closeModal(document.getElementById(modalId));
                            }
                            await refreshProductTable();
                        }, 1500);
                    } else if(data.errors) {
                        showFlash(flash, Object.values(data.errors).flat().join('<br>'), false);
                    }
                } catch { showFlash(flash, 'Lỗi kết nối', false); }
            };
        };

        handleForm('addProductForm', () => '/admin/store/products', 'POST', 'addProductFlash', 'addProductModal');
        handleForm('manageProductForm', () => `/admin/store/products/${document.getElementById('manage-product_id').value}`, 'PUT', 'editProductFlash', 'manageProductModal');
        handleForm('addVariantForm', () => `/admin/store/products/${document.getElementById('add-variant-product-id').value}/variants`, 'POST', 'addVariantFlash', 'variantModal', true);
        handleForm('manageVariantForm', () => `/admin/store/products/${document.getElementById('current-product-id').value}/variants/${document.getElementById('manage-variant-id').value}`, 'PUT', 'manageVariantFlash', 'variantModal', true);

        // DELETE ACTIONS
        const handleDelete = (btnId, urlFn, flashId, modalId) => {
            document.getElementById(btnId).onclick = async () => {
                if(!confirm('Bạn chắc chắn muốn xóa?')) return;
                try {
                    const res = await fetch(urlFn(), { method: 'DELETE', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }});
                    const data = await res.json();
                    showFlash(document.getElementById(flashId), data.message, data.success);
                    if(data.success) {
                        if(modalId) closeModal(document.getElementById(modalId));
                        await refreshProductTable();
                        // Nếu xóa biến thể thì reload sidebar
                        if(btnId === 'deleteVariantBtn') {
                             const pid = document.getElementById('current-product-id').value;
                             const resV = await fetch(`/admin/store/products/${pid}/variants`);
                             const dataV = await resV.json();
                             renderVariants('', dataV.variants, pid);
                        }
                    }
                } catch { alert('Lỗi kết nối'); }
            };
        };

        handleDelete('deleteProductBtn', () => `/admin/store/products/${document.getElementById('manage-product_id').value}`, 'editProductFlash', 'manageProductModal');
        handleDelete('deleteVariantBtn', () => `/admin/store/products/${document.getElementById('current-product-id').value}/variants/${document.getElementById('manage-variant-id').value}`, 'manageVariantFlash', null);

        // --- LOGIC TẮT/BẬT INPUT GIÁ GIẢM ---
        function setupPromoLogic(containerId, inputId) {
            // Tìm container của custom select dựa trên data-select-id
            const container = document.querySelector(`[data-select-id="${containerId}"]`);
            if (!container) return;

            const hiddenSelect = container.querySelector('select');
            const priceInput = document.getElementById(inputId);

            // Hàm xử lý chính: Kiểm tra giá trị và bật/tắt input
            const toggleInput = () => {
                const isPromo = hiddenSelect.value === 'Có'; // Kiểm tra nếu chọn 'Có'
                
                if (isPromo) {
                    // TRƯỜNG HỢP: CÓ KHUYẾN MÃI
                    priceInput.readOnly = false; // Cho phép nhập
                    priceInput.classList.remove('bg-gray-100'); // Xóa nền xám
                    priceInput.classList.add('bg-white'); // Thêm nền trắng
                } else {
                    // TRƯỜNG HỢP: KHÔNG KHUYẾN MÃI
                    priceInput.readOnly = true; // Khóa nhập
                    priceInput.classList.remove('bg-white');
                    priceInput.classList.add('bg-gray-100'); // Thêm nền xám (disabled look)
                    priceInput.value = 0; // Reset giá trị về 0
                }
            };

            // 1. Lắng nghe sự kiện thay đổi (khi người dùng chọn menu)
            hiddenSelect.addEventListener('change', toggleInput);

            // 2. Chạy logic này ngay lập tức (để áp dụng cho dữ liệu vừa load lên)
            // Dùng MutationObserver để theo dõi khi value của select thay đổi bằng JS (lúc load modal)
            const observer = new MutationObserver(toggleInput);
            observer.observe(hiddenSelect, { attributes: true, childList: true, subtree: true });
        }

        // Kích hoạt logic cho cả 2 modal (Thêm và Sửa)
        setupPromoLogic('add-variant-promo', 'add-variant-promo-price');
        setupPromoLogic('manage-variant-promo', 'manage-variant-promo-price');
    });
</script>
@endpush