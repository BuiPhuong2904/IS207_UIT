{{-- resources/views/admin/store.blade.php --}}
@extends('layouts.ad_layout')

@section('title', 'Quản lý cửa hàng')

@section('content')

@php
$products = $products ?? collect([]);
$categories = $categories ?? [];
$statuses = $statuses ?? ['active' => 'Còn hàng', 'inactive' => 'Hết hàng'];
@endphp

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Header --}}
<div class="flex justify-between items-center mb-6 font-['Roboto']">
    <div class="flex-1 max-w-md">
        <div class="relative shadow-md rounded-2xl">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" id="searchInput" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Tìm kiếm sản phẩm...">
        </div>
    </div>

    <div class="flex items-center">
        <button id="openAddProductModalBtn"
                class="flex items-center px-5 py-2.5 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-colors duration-150 shadow-md">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Thêm sản phẩm
        </button>
    </div>
</div>

{{-- Bảng danh sách sản phẩm --}}
<div class="bg-white p-8 rounded-2xl shadow-xl font-['Roboto']">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Quản lý Sản phẩm</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border-separate border-spacing-y-2">
            <thead class="bg-gray-100 rounded-lg shadow-sm">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-[8%] rounded-l-lg">Mã SP</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-[18%]">Tên sản phẩm</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-[10%]">Loại</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-[10%]">Thương hiệu</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-[10%]">Nguồn gốc</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-[10%]">Hình ảnh</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase flex-1">Biến thể</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase w-[10%] rounded-r-lg">Trạng thái</th>
            </tr>
            </thead>
            <tbody id="productTableBody">
            @forelse($products as $product)
            <tr class="transition duration-150 cursor-pointer product-row"
                data-product='@json($product->load('variants'))'>
            <td colspan="8" class="p-0">
                <div class="flex w-full rounded-xl items-center {{ $loop->even ? 'bg-white' : 'bg-gray-50' }} shadow-md hover:shadow-lg transition-shadow border border-gray-200">
                    <div class="px-4 py-4 w-[8%] text-sm font-medium text-gray-800">{{ $product->product_id }}</div>
                    <div class="px-4 py-4 w-[18%] text-sm text-gray-700 font-medium">{{ $product->product_name }}</div>
                    <div class="px-4 py-4 w-[10%] text-sm text-gray-700">{{ $categories[$product->category_id] ?? 'N/A' }}</div>
                    <div class="px-4 py-4 w-[10%] text-sm text-gray-700">{{ $product->brand ?? 'N/A' }}</div>
                    <div class="px-4 py-4 w-[10%] text-sm text-gray-700">{{ $product->origin ?? 'N/A' }}</div>
                    <div class="px-4 py-4 w-[10%]">
                        <img src="{{ $product->image_url }}"
                             onerror="this.src='https://via.placeholder.com/80x60?text=No+Image'"
                             class="w-16 h-12 object-cover rounded-md border" alt="Product">
                    </div>
                    <div class="px-4 py-4 flex-1 text-sm text-gray-700">
                        @if($product->variants && $product->variants->count())
                        @foreach($product->variants->take(3) as $variant)
                        <a href="#" class="text-blue-600 hover:underline text-xs block open-variant-trigger"
                           data-product-id="{{ $product->product_id }}"
                           data-variant-id="{{ $variant->variant_id }}">
                            {{ $variant->color }} / {{ $variant->size }} - {{ number_format($variant->price) }}đ
                        </a>
                        @endforeach
                        @if($product->variants->count() > 3)
                        <span class="text-xs text-gray-500">... và {{ $product->variants->count() - 3 }} biến thể khác</span>
                        @endif
                        @else
                        <span class="text-xs text-gray-500">Chưa có biến thể</span>
                        @endif
                    </div>
                    <div class="px-4 py-4 w-[10%] text-right">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $statuses[$product->status] ?? 'N/A' }}
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
</div>

{{-- ==================== MODAL: THÊM SẢN PHẨM ==================== --}}
<div id="addProductModal" class="modal-container fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-2xl w-full mx-4 font-['Roboto'] relative">
        <button class="close-modal absolute top-4 right-6 text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Thêm sản phẩm mới</h2>
        <form id="addProductForm" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên sản phẩm *</label>
                    <input type="text" name="product_name" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Loại *</label>
                    <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                        @foreach($categories as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Thương hiệu</label>
                    <input type="text" name="brand" class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nguồn gốc</label>
                    <input type="text" name="origin" class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả *</label>
                    <textarea name="description" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-xl"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái *</label>
                    <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                        <option value="active">Còn hàng</option>
                        <option value="inactive">Hết hàng</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hình ảnh</label>
                    <div class="flex items-center space-x-4">
                        <img id="addImagePreview" src="https://via.placeholder.com/150?text=Image" class="w-32 h-32 object-cover rounded-lg border">
                        <button type="button" id="addImageBtn" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Chọn ảnh</button>
                        <input type="file" name="image_url" id="addImageInput" accept="image/*" class="hidden">
                    </div>
                </div>
            </div>
            <div id="addProductFlash" class="mt-4"></div>
            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" class="close-modal px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300">Hủy</button>
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700">Thêm sản phẩm</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL: SỬA SẢN PHẨM ==================== --}}
<div id="editProductModal" class="modal-container fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-2xl w-full mx-4 font-['Roboto'] relative">
        <button class="close-modal absolute top-4 right-6 text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Chỉnh sửa sản phẩm</h2>
        <form id="editProductForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="edit-product_id">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên sản phẩm *</label>
                    <input type="text" id="edit-product_name" name="product_name" required class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Loại *</label>
                    <select id="edit-category_id" name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                        @foreach($categories as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Thương hiệu</label>
                    <input type="text" id="edit-brand" name="brand" class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nguồn gốc</label>
                    <input type="text" id="edit-origin" name="origin" class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả *</label>
                    <textarea id="edit-description" name="description" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-xl"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái *</label>
                    <select id="edit-status" name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-xl">
                        <option value="active">Còn hàng</option>
                        <option value="inactive">Hết hàng</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hình ảnh</label>
                    <div class="flex items-center space-x-4">
                        <img id="editImagePreview" src="" class="w-32 h-32 object-cover rounded-lg border">
                        <button type="button" id="editImageBtn" class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Đổi ảnh</button>
                        <input type="file" name="image_url" id="editImageInput" accept="image/*" class="hidden">
                    </div>
                </div>
            </div>
            <div id="editProductFlash" class="mt-4"></div>
            <div class="flex justify-between items-center mt-6">
                <button type="button" id="deleteProductBtn" class="px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700">Xóa sản phẩm</button>
                <div class="flex space-x-4">
                    <button type="button" class="close-modal px-6 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300">Hủy</button>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL: QUẢN LÝ BIẾN THỂ ==================== --}}
<div id="variantModal" class="modal-container fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-5xl mx-4 font-['Roboto'] flex flex-col max-h-screen">
        <div class="p-6 border-b flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Quản lý biến thể</h2>
            <button class="close-modal text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="flex flex-1 overflow-hidden">
            <input type="hidden" id="variant-product-id">
            <!-- Danh sách biến thể -->
            <div class="w-1/2 p-6 border-r overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Danh sách biến thể</h3>
                    <button id="showAddVariantForm" class="px-4 py-2 bg-green-600 text-white rounded-xl text-sm hover:bg-green-700">+ Thêm mới</button>
                </div>
                <div id="variantList" class="space-y-3"></div>
            </div>
            <!-- Form thêm/sửa biến thể -->
            <div class="w-1/2 p-6 overflow-y-auto">
                <h3 id="variant-form-title" class="text-xl font-bold mb-6">Thêm biến thể mới</h3>

                <!-- Form Thêm -->
                <form id="addVariantForm" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <input type="hidden" id="add-variant-product-id" name="product_id">
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium mb-1">Màu sắc *</label><input type="text" name="color" required class="w-full px-4 py-2 border rounded-xl"></div>
                        <div><label class="block text-sm font-medium mb-1">Kích thước *</label><input type="text" name="size" required class="w-full px-4 py-2 border rounded-xl"></div>
                        <div><label class="block text-sm font-medium mb-1">Giá *</label><input type="number" name="price" required min="0" class="w-full px-4 py-2 border rounded-xl"></div>
                        <div><label class="block text-sm font-medium mb-1">Giá khuyến mãi</label><input type="number" name="discount_price" min="0" class="w-full px-4 py-2 border rounded-xl"></div>
                        <div><label class="block text-sm font-medium mb-1">Tồn kho *</label><input type="number" name="stock" required min="0" class="w-full px-4 py-2 border rounded-xl"></div>
                        <div><label class="block text-sm font-medium mb-1">Trạng thái *</label>
                            <select name="status" required class="w-full px-4 py-2 border rounded-xl">
                                <option value="active">Còn hàng</option>
                                <option value="inactive">Hết hàng</option>
                            </select>
                        </div>
                        <div><label class="block text-sm font-medium mb-1">Trọng lượng</label><input type="number" name="weight" step="0.01" class="w-full px-4 py-2 border rounded-xl"></div>
                        <div><label class="block text-sm font-medium mb-1">Đơn vị</label><input type="text" name="unit" class="w-full px-4 py-2 border rounded-xl"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Hình ảnh biến thể</label>
                        <div class="flex items-center space-x-4">
                            <img id="addVariantPreview" src="https://via.placeholder.com/150?text=Image" class="w-32 h-32 object-cover rounded-lg border">
                            <button type="button" id="addVariantImageBtn" class="px-4 py-2 bg-blue-600 text-white rounded-xl">Chọn ảnh</button>
                            <input type="file" name="image_url" id="addVariantImageInput" accept="image/*" class="hidden">
                        </div>
                    </div>
                    <div id="addVariantFlash" class="mt-4"></div>
                    <div class="flex justify-end space-x-4">
                        <button type="button" id="cancelAddVariant" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-xl">Hủy</button>
                        <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700">Thêm biến thể</button>
                    </div>
                </form>

                <!-- Form Sửa -->
                <form id="manageVariantForm" enctype="multipart/form-data" class="space-y-5 hidden">
                    @csrf
                    <input type="hidden" id="manage-variant-id">
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium mb-1">Màu sắc *</label><input type="text" id="manage-color" name="color" required class="w-full px-4 py-2 border rounded-xl"></div>
                        <div><label class="block text-sm font-medium mb-1">Kích thước *</label><input type="text" id="manage-size" name="size" required class="w-full px-4 py-2 border rounded-xl"></div>
                        <div><label class="block text-sm font-medium mb-1">Giá *</label><input type="number" id="manage-price" name="price" required min="0" class="w-full px-4 py-2 border rounded-xl"></div>
                        <div><label class="block text-sm font-medium mb-1">Giá khuyến mãi</label><input type="number" id="manage-discount_price" name="discount_price" min="0" class="w-full px-4 py-2 border rounded-xl"></div>
                        <div><label class="block text-sm font-medium mb-1">Tồn kho *</label><input type="number" id="manage-stock" name="stock" required min="0" class="w-full px-4 py-2 border rounded-xl"></div>
                        <div><label class="block text-sm font-medium mb-1">Trạng thái *</label>
                            <select id="manage-status" name="status" required class="w-full px-4 py-2 border rounded-xl">
                                <option value="active">Còn hàng</option>
                                <option value="inactive">Hết hàng</option>
                            </select>
                        </div>
                        <div><label class="block text-sm font-medium mb-1">Trọng lượng</label><input type="number" id="manage-weight" name="weight" step="0.01" class="w-full px-4 py-2 border rounded-xl"></div>
                        <div><label class="block text-sm font-medium mb-1">Đơn vị</label><input type="text" id="manage-unit" name="unit" class="w-full px-4 py-2 border rounded-xl"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Hình ảnh biến thể</label>
                        <div class="flex items-center space-x-4">
                            <img id="manageVariantPreview" src="" class="w-32 h-32 object-cover rounded-lg border">
                            <button type="button" id="manageVariantImageBtn" class="px-4 py-2 bg-blue-600 text-white rounded-xl">Đổi ảnh</button>
                            <input type="file" name="image_url" id="manageVariantImageInput" accept="image/*" class="hidden">
                        </div>
                    </div>
                    <div id="manageVariantFlash" class="mt-4"></div>
                    <div class="flex justify-between mt-6">
                        <button type="button" id="deleteVariantBtn" class="px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700">Xóa biến thể</button>
                        <div class="flex space-x-4">
                            <button type="button" class="close-modal px-6 py-3 bg-gray-200 text-gray-700 rounded-xl">Hủy</button>
                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function showFlash(el, msg, success = true) {
            el.innerHTML = `<div class="p-3 rounded-xl ${success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">${msg}</div>`;
            setTimeout(() => el.innerHTML = '', 5000);
        }

        function setupImage(btn, input, preview) {
            btn.onclick = () => input.click();
            input.onchange = e => {
                if (e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = ev => preview.src = ev.target.result;
                    reader.readAsDataURL(e.target.files[0]);
                }
            };
        }

        // Mở modal thêm
        document.getElementById('openAddProductModalBtn').onclick = () => {
            document.getElementById('addProductModal').classList.remove('hidden');
            document.getElementById('addProductForm').reset();
            document.getElementById('addImagePreview').src = 'https://via.placeholder.com/150?text=Image';
        };

        // Mở modal sửa
        document.querySelectorAll('.product-row').forEach(row => {
            row.onclick = function(e) {
                if (e.target.closest('.open-variant-trigger')) return;
                const product = JSON.parse(this.dataset.product);
                const modal = document.getElementById('editProductModal');
                modal.classList.remove('hidden');

                document.getElementById('edit-product_id').value = product.product_id;
                document.getElementById('edit-product_name').value = product.product_name;
                document.getElementById('edit-brand').value = product.brand || '';
                document.getElementById('edit-origin').value = product.origin || '';
                document.getElementById('edit-description').value = product.description;
                document.getElementById('edit-category_id').value = product.category_id;
                document.getElementById('edit-status').value = product.status;
                document.getElementById('editImagePreview').src = product.image_url || 'https://via.placeholder.com/150?text=Image';
            };
        });

        // Thêm sản phẩm
        document.getElementById('addProductForm').onsubmit = async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const flash = document.getElementById('addProductFlash');
            try {
                const res = await fetch('/admin/store/products', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }, body: formData });
                const data = await res.json();
                showFlash(flash, data.message, data.success);
                if (data.success) setTimeout(() => location.reload(), 1500);
            } catch { showFlash(flash, 'Lỗi kết nối', false); }
        };

        // Sửa sản phẩm
        document.getElementById('editProductForm').onsubmit = async function(e) {
            e.preventDefault();
            const id = document.getElementById('edit-product_id').value;
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            const flash = document.getElementById('editProductFlash');
            try {
                const res = await fetch(`/admin/store/products/${id}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }, body: formData });
                const data = await res.json();
                showFlash(flash, data.message, data.success);
                if (data.success) setTimeout(() => location.reload(), 1500);
            } catch { showFlash(flash, 'Lỗi kết nối', false); }
        };

        // Xóa sản phẩm
        document.getElementById('deleteProductBtn').onclick = async function() {
            if (!confirm('Xóa sản phẩm này?')) return;
            const id = document.getElementById('edit-product_id').value;
            const flash = document.getElementById('editProductFlash');
            try {
                const res = await fetch(`/admin/store/products/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken } });
                const data = await res.json();
                showFlash(flash, data.message, data.success);
                if (data.success) setTimeout(() => location.reload(), 1500);
            } catch { showFlash(flash, 'Lỗi kết nối', false); }
        };

        // Mở modal biến thể
        document.querySelectorAll('.open-variant-trigger').forEach(el => {
            el.onclick = async function(e) {
                e.preventDefault();
                const productId = this.dataset.productId;
                document.getElementById('variant-product-id').value = productId;
                document.getElementById('add-variant-product-id').value = productId;
                document.getElementById('variantModal').classList.remove('hidden');

                const res = await fetch(`/admin/store/products/${productId}/variants`);
                const data = await res.json();
                if (data.success) renderVariants(data.variants);
            };
        });

        function renderVariants(variants) {
            const container = document.getElementById('variantList');
            container.innerHTML = variants.length ? '' : '<p class="text-gray-500">Chưa có biến thể</p>';
            variants.forEach(v => {
                const div = document.createElement('div');
                div.className = 'p-4 bg-white rounded-lg shadow cursor-pointer hover:bg-gray-50 variant-item';
                div.dataset.variant = JSON.stringify(v);
                div.innerHTML = `
                <div class="flex justify-between">
                    <div>
                        <strong>${v.color} / ${v.size}</strong><br>
                        <small>${Number(v.price).toLocaleString('vi-VN')}đ • Tồn: ${v.stock}</small>
                    </div>
                    <span class="text-xs px-2 py-1 rounded ${v.status === 'active' ? 'bg-green-100' : 'bg-red-100'}">
                        ${v.status === 'active' ? 'Còn hàng' : 'Hết hàng'}
                    </span>
                </div>
            `;
                div.onclick = () => loadVariant(v);
                container.appendChild(div);
            });
        }

        function loadVariant(v) {
            document.getElementById('variant-form-title').textContent = 'Chỉnh sửa biến thể';
            document.getElementById('addVariantForm').classList.add('hidden');
            document.getElementById('manageVariantForm').classList.remove('hidden');

            document.getElementById('manage-variant-id').value = v.variant_id;
            document.getElementById('manage-color').value = v.color;
            document.getElementById('manage-size').value = v.size;
            document.getElementById('manage-price').value = v.price;
            document.getElementById('manage-discount_price').value = v.discount_price || '';
            document.getElementById('manage-stock').value = v.stock;
            document.getElementById('manage-status').value = v.status;
            document.getElementById('manage-weight').value = v.weight || '';
            document.getElementById('manage-unit').value = v.unit || '';
            document.getElementById('manageVariantPreview').src = v.image_url || 'https://via.placeholder.com/150?text=Image';
        }

        document.getElementById('showAddVariantForm').onclick = () => {
            document.getElementById('variant-form-title').textContent = 'Thêm biến thể mới';
            document.getElementById('addVariantForm').classList.remove('hidden');
            document.getElementById('manageVariantForm').classList.add('hidden');
            document.getElementById('addVariantForm').reset();
            document.getElementById('addVariantPreview').src = 'https://via.placeholder.com/150?text=Image';
        };

        document.getElementById('cancelAddVariant').onclick = () => {
            document.getElementById('showAddVariantForm').click();
        };

        // Upload ảnh
        setupImage(document.getElementById('addImageBtn'), document.getElementById('addImageInput'), document.getElementById('addImagePreview'));
        setupImage(document.getElementById('editImageBtn'), document.getElementById('editImageInput'), document.getElementById('editImagePreview'));
        setupImage(document.getElementById('addVariantImageBtn'), document.getElementById('addVariantImageInput'), document.getElementById('addVariantPreview'));
        setupImage(document.getElementById('manageVariantImageBtn'), document.getElementById('manageVariantImageInput'), document.getElementById('manageVariantPreview'));

        // Đóng modal
        document.querySelectorAll('.close-modal').forEach(btn => {
            btn.onclick = () => btn.closest('.modal-container').classList.add('hidden');
        });

        // Các form biến thể (thêm/sửa/xóa) tương tự như trên – đã có đầy đủ ở phần trước
        // (Do độ dài, phần xử lý submit biến thể giữ nguyên như phiên bản trước – bạn chỉ cần copy phần JS xử lý addVariantForm, manageVariantForm, deleteVariantBtn từ tin nhắn trước vào đây)
        // Submit thêm biến thể
        document.getElementById('addVariantForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const productId = document.getElementById('add-variant-product-id').value;
            const formData = new FormData(this);
            const flash = document.getElementById('addVariantFlash');

            try {
                const res = await fetch(`/admin/store/products/${productId}/variants`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    body: formData
                });
                const data = await res.json();
                showFlash(flash, data.message, data.success);
                if (data.success) {
                    const vRes = await fetch(`/admin/store/products/${productId}/variants`);
                    const vData = await vRes.json();
                    renderVariants(vData.variants);
                    this.reset();
                }
            } catch (err) {
                showFlash(flash, 'Lỗi kết nối', false);
            }
        });

        // Submit sửa biến thể
        document.getElementById('manageVariantForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const productId = document.getElementById('variant-product-id').value;
            const variantId = document.getElementById('manage-variant-id').value;
            const formData = new FormData(this);
            formData.append('_method', 'PUT');
            const flash = document.getElementById('manageVariantFlash');

            try {
                const res = await fetch(`/admin/store/products/${productId}/variants/${variantId}`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    body: formData
                });
                const data = await res.json();
                showFlash(flash, data.message, data.success);
                if (data.success) {
                    const vRes = await fetch(`/admin/store/products/${productId}/variants`);
                    const vData = await vRes.json();
                    renderVariants(vData.variants);
                }
            } catch (err) {
                showFlash(flash, 'Lỗi kết nối', false);
            }
        });

        // Xóa biến thể
        document.getElementById('deleteVariantBtn').addEventListener('click', async function() {
            if (!confirm('Xóa biến thể này?')) return;
            const productId = document.getElementById('variant-product-id').value;
            const variantId = document.getElementById('manage-variant-id').value;
            const flash = document.getElementById('manageVariantFlash');

            try {
                const res = await fetch(`/admin/store/products/${productId}/variants/${variantId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                });
                const data = await res.json();
                showFlash(flash, data.message, data.success);
                if (data.success) {
                    const vRes = await fetch(`/admin/store/products/${productId}/variants`);
                    const vData = await vRes.json();
                    renderVariants(vData.variants);
                }
            } catch (err) {
                showFlash(flash, 'Lỗi kết nối', false);
            }
        });
    });
</script>
@endpush
