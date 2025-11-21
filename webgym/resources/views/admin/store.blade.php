@extends('layouts.ad_layout')

@section('title', 'Quản lý cửa hàng')

@section('content')

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

    <div class="flex items-center space-x-6">
        <div class="flex items-center space-x-3 text-sm text-gray-500">
            <span class="font-medium">Hôm nay</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        <button id="openAddProductModalBtn"
                class="flex items-center px-5 py-2.5 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition shadow-md">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Thêm sản phẩm
        </button>
    </div>
</div>

{{-- Bảng sản phẩm --}}
<div class="bg-white p-8 rounded-2xl shadow-xl font-['Roboto']">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Danh sách sản phẩm</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border-separate border-spacing-y-2">
            <thead class="bg-gray-100 rounded-lg shadow-sm">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-[10%] rounded-l-lg">Mã SP</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-[20%]">Tên sản phẩm</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-[12%]">Loại</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-[12%]">Thương hiệu</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-[12%]">Nguồn gốc</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase w-[10%]">Hình</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase flex-1">Biến thể</th>
                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase w-[12%] rounded-r-lg">Trạng thái</th>
            </tr>
            </thead>
            <tbody id="productTableBody">
            @foreach($products as $product)
            <tr class="transition duration-150 cursor-pointer hover:bg-blue-50 product-row-trigger"
                data-product_id="{{ $product->product_id }}"
                data-product_name="{{ $product->product_name }}"
                data-category_id="{{ $product->category_id }}"
                data-origin="{{ $product->origin ?? '' }}"
                data-brand="{{ $product->brand ?? '' }}"
                data-description="{{ $product->description ?? '' }}"
                data-status="{{ $product->status }}"
                data-slug="{{ $product->slug ?? '' }}"
                data-image_url="{{ $product->image_url ?? asset('images/default.png') }}"
                data-variants="{{ json_encode($product->variants) }}"
            >
                <td colspan="8" class="p-0">
                    <div class="flex w-full rounded-xl items-center {{ $loop->even ? 'bg-white' : 'bg-gray-50' }} shadow-md hover:shadow-lg transition-shadow overflow-hidden border border-gray-200">
                        <div class="px-4 py-4 w-[10%] text-sm font-medium text-gray-900">{{ $product->product_id }}</div>
                        <div class="px-4 py-4 w-[20%] text-sm font-medium text-gray-800 flex items-center space-x-3">
                            <img src="{{ $product->image_url ?? asset('images/default.png') }}" class="w-10 h-10 rounded object-cover">
                            <span>{{ $product->product_name }}</span>
                        </div>
                        <div class="px-4 py-4 w-[12%] text-sm text-gray-700">{{ $product->category?->category_name ?? '—' }}</div>
                        <div class="px-4 py-4 w-[12%] text-sm text-gray-700">{{ $product->brand ?? '—' }}</div>
                        <div class="px-4 py-4 w-[12%] text-sm text-gray-700">{{ $product->origin ?? '—' }}</div>
                        <div class="px-4 py-4 w-[10%]">
                            <img src="{{ $product->image_url ?? asset('images/default.png') }}" class="w-12 h-12 rounded-lg object-cover shadow">
                        </div>
                        <div class="px-4 py-4 flex-1 text-center">
                            <button onclick="openVariantModal('{{ $product->product_id }}', '{{ $product->product_name }}', this.closest('tr').dataset.variants)"
                                    class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 text-xs font-bold rounded-full hover:bg-blue-200 transition shadow-sm">
                                {{ $product->variants->count() }} biến thể
                            </button>
                        </div>
                        <div class="px-4 py-4 w-[12%] text-right">
                                <span class="inline-flex px-4 py-2 rounded-full text-xs font-bold
                                    {{ $product->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                                    {{ $product->status == 'active' ? 'Còn hàng' : 'Hết hàng' }}
                                </span>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-6 flex justify-center">{{ $products->links() }}</div>
    </div>
</div>

{{-- Modal Thêm sản phẩm --}}
<div id="addProductModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-y-auto">
        <h2 class="text-3xl font-bold text-center mb-8 bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">
            THÊM SẢN PHẨM MỚI
        </h2>
        <form id="addProductForm" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex flex-col items-center">
                    <img id="add-image-preview" src="https://via.placeholder.com/256x256.png?text=Chọn+ảnh" class="w-64 h-64 rounded-2xl object-cover mb-4 shadow-lg border-4 border-dashed border-gray-300">
                    <button type="button" id="add-upload-btn" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Chọn ảnh</button>
                    <input type="file" id="add-image_input" name="image_url" accept="image/*" class="hidden">
                </div>
                <div class="md:col-span-2 space-y-6">
                    <input type="text" name="product_name" required placeholder="Tên sản phẩm *" class="w-full px-4 py-3 border rounded-2xl">
                    <input type="text" name="slug" placeholder="Slug (tự động nếu bỏ trống)" class="w-full px-4 py-3 border rounded-2xl">
                    <select name="category_id" required class="w-full px-4 py-3 border rounded-2xl">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="brand" placeholder="Thương hiệu" class="w-full px-4 py-3 border rounded-2xl">
                    <input type="text" name="origin" placeholder="Xuất xứ" class="w-full px-4 py-3 border rounded-2xl">
                    <textarea name="description" required rows="5" placeholder="Mô tả sản phẩm *" class="w-full px-4 py-3 border rounded-2xl"></textarea>
                    <div class="flex justify-end space-x-4 pt-6">
                        <button type="button" class="close-modal px-8 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600">Hủy</button>
                        <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 shadow-lg">Thêm sản phẩm</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal Sửa sản phẩm --}}
<div id="manageProductModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[95vh] overflow-y-auto">
        <h2 class="text-3xl font-bold text-center mb-8 bg-gradient-to-r from-blue-600 to-cyan-500 bg-clip-text text-transparent">
            CHỈNH SỬA SẢN PHẨM
        </h2>
        <form id="manageProductForm" enctype="multipart/form-data">
            <input type="hidden" id="manage-product_id">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex flex-col items-center">
                    <img id="manage-image-preview" src="" class="w-64 h-64 rounded-2xl object-cover mb-4 shadow-lg border-4 border-dashed border-gray-300">
                    <button type="button" id="manage-upload-btn" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Đổi ảnh</button>
                    <input type="file" id="manage-image_input" name="image_url" accept="image/*" class="hidden">
                </div>
                <div class="md:col-span-2 space-y-6">
                    <input type="text" id="manage-product_name" name="product_name" required class="w-full px-4 py-3 border rounded-2xl">
                    <input type="text" id="manage-slug" name="slug" class="w-full px-4 py-3 border rounded-2xl">
                    <select id="manage-category_id" name="category_id" required class="w-full px-4 py-3 border rounded-2xl">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <input type="text" id="manage-brand" name="brand" class="w-full px-4 py-3 border rounded-2xl">
                    <input type="text" id="manage-origin" name="origin" class="w-full px-4 py-3 border rounded-2xl">
                    <textarea id="manage-description" name="description" required rows="5" class="w-full px-4 py-3 border rounded-2xl"></textarea>
                    <div class="flex justify-between items-center pt-6">
                        <button type="button" id="btn-delete-product" class="px-8 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700">Xóa sản phẩm</button>
                        <div class="space-x-4">
                            <button type="button" class="close-modal px-8 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600">Hủy</button>
                            <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 shadow-lg">Lưu thay đổi</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal Biến thể --}}
<div id="variantModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-7xl max-h-[95vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold">Biến thể - <span id="variant-product-name" class="text-blue-600"></span></h3>
            <button class="close-modal text-gray-500 hover:text-gray-700">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <button id="addVariantBtn" class="mb-6 px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-lg">
            + Thêm biến thể mới
        </button>
        <div id="variantList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>
    </div>
</div>

{{-- Form Biến thể – image_url là UPLOAD FILE --}}
<div id="variantFormModal" class="modal-container hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60">
    <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-3xl">
        <h3 id="variantFormTitle" class="text-2xl font-bold text-center mb-8 text-blue-600">Thêm biến thể mới</h3>
        <form id="variantForm" enctype="multipart/form-data">
            <input type="hidden" id="variant_id">
            <input type="hidden" id="variant_product_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Ảnh biến thể -->
                <div class="md:col-span-2 flex flex-col items-center">
                    <img id="variant-image-preview" src="https://via.placeholder.com/300x300.png?text=Ảnh+biến+thể"
                         class="w-80 h-80 rounded-2xl object-cover mb-4 shadow-lg border-4 border-dashed border-gray-300">
                    <button type="button" id="variant-upload-btn" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                        Chọn ảnh biến thể
                    </button>
                    <input type="file" id="variant-image_input" name="image_url" accept="image/*" class="hidden">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Màu sắc *</label>
                    <input type="text" id="variant_color" required placeholder="Đen, Trắng..." class="w-full px-4 py-3 border rounded-2xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kích thước / Size *</label>
                    <input type="text" id="variant_size" required placeholder="M, L, 500g, 1kg..." class="w-full px-4 py-3 border rounded-2xl">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trọng lượng (nếu có)</label>
                    <input type="number" step="0.01" id="variant_weight" placeholder="0.5, 1, 2..." class="w-full px-4 py-3 border rounded-2xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Đơn vị</label>
                    <input type="text" id="variant_unit" value="kg" class="w-full px-4 py-3 border rounded-2xl">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Giá bán *</label>
                    <input type="number" id="variant_price" required min="0" class="w-full px-4 py-3 border rounded-2xl">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tồn kho *</label>
                    <input type="number" id="variant_stock" required min="0" class="w-full px-4 py-3 border rounded-2xl">
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" id="variant_is_discounted" class="w-5 h-5 text-blue-600 rounded">
                        <span class="text-lg font-medium">Có khuyến mãi</span>
                    </label>
                </div>

                <div class="md:col-span-2" id="discountPriceWrapper" style="display:none;">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Giá khuyến mãi (nhỏ hơn giá bán)</label>
                    <input type="number" id="variant_discount_price" min="0" class="w-full px-4 py-3 border rounded-2xl">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Trạng thái *</label>
                    <select id="variant_status" class="w-full px-4 py-3 border rounded-2xl">
                        <option value="active">Còn hàng</option>
                        <option value="inactive">Hết hàng</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex justify-center space-x-6">
                <button type="button" class="close-modal px-8 py-3 bg-gray-500 text-white rounded-xl hover:bg-gray-600">Hủy</button>
                <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 shadow-lg">
                    Lưu biến thể
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentProductId = null;

        const openModal = m => m.classList.replace('hidden', 'flex');
        const closeModal = m => m.classList.replace('flex', 'hidden');

        document.querySelectorAll('.close-modal, .modal-container').forEach(el => {
            el.addEventListener('click', e => {
                if (e.target.classList.contains('modal-container') || e.target.classList.contains('close-modal')) {
                    closeModal(el.closest('.modal-container'));
                }
            });
        });

        // Upload ảnh preview
        document.getElementById('add-upload-btn').onclick = () => document.getElementById('add-image_input').click();
        document.getElementById('add-image_input').onchange = e => e.target.files[0] && (document.getElementById('add-image-preview').src = URL.createObjectURL(e.target.files[0]));

        document.getElementById('manage-upload-btn').onclick = () => document.getElementById('manage-image_input').click();
        document.getElementById('manage-image_input').onchange = e => e.target.files[0] && (document.getElementById('manage-image-preview').src = URL.createObjectURL(e.target.files[0]));

        // MỞ MODAL THÊM SẢN PHẨM
        document.getElementById('openAddProductModalBtn').onclick = () => {
            document.getElementById('addProductForm').reset();
            document.getElementById('add-image-preview').src = 'https://via.placeholder.com/256x256.png?text=Chọn+ảnh';
            openModal(document.getElementById('addProductModal'));
        };

        // CLICK DÒNG → MỞ MODAL SỬA
        document.querySelectorAll('.product-row-trigger').forEach(row => {
            row.addEventListener('click', function (e) {
                if (e.target.closest('button')) return;
                const d = this.dataset;
                currentProductId = d.product_id;

                document.getElementById('manage-product_id').value = d.product_id;
                document.getElementById('manage-product_name').value = d.product_name;
                document.getElementById('manage-slug').value = d.slug || '';
                document.getElementById('manage-category_id').value = d.category_id;
                document.getElementById('manage-brand').value = d.brand || '';
                document.getElementById('manage-origin').value = d.origin || '';
                document.getElementById('manage-description').value = d.description || '';
                document.getElementById('manage-image-preview').src = d.image_url;

                openModal(document.getElementById('manageProductModal'));
            });
        });

        // MỞ MODAL BIẾN THỂ
        window.openVariantModal = (productId, productName, variantJson) => {
            currentProductId = productId;
            document.getElementById('variant-product-name').textContent = productName;
            renderVariants(JSON.parse(variantJson));
            openModal(document.getElementById('variantModal'));
        };

        function renderVariants(variants) {
            const container = document.getElementById('variantList');
            container.innerHTML = variants.length === 0
                ? '<p class="text-center text-gray-500 col-span-3">Chưa có biến thể nào</p>'
                : '';

            variants.forEach(v => {
                const name = `${v.color}/${v.weight}${v.unit}`;
                const card = document.createElement('div');
                card.className = 'border-2 border-gray-200 rounded-2xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 bg-white';
                card.innerHTML = `
                <div class="flex justify-center mb-4">
                    <img src="${v.image_url || 'https://via.placeholder.com/180x180.png?text=' + name}" class="w-48 h-48 object-cover rounded-xl shadow-lg">
                </div>
                <div class="text-center space-y-3">
                    <h4 class="text-xl font-bold text-blue-600">${name}</h4>
                    <div class="text-sm space-y-1">
                        <div><strong>Giá bán:</strong> ${Number(v.price).toLocaleString()}₫
                            ${v.promo === 'Có' ? `<span class="text-red-600 font-bold">→ ${Number(v.promo_price).toLocaleString()}₫</span>` : ''}
                        </div>
                        <div><strong>Tồn kho:</strong> ${v.stock}</div>
                        <div><strong>Trạng thái:</strong>
                            <span class="${v.status === 'active' ? 'text-green-600' : 'text-gray-600'} font-medium">
                                ${v.status === 'active' ? 'Còn hàng' : 'Hết hàng'}
                            </span>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t flex justify-around text-sm font-medium">
                        <button onclick="editVariant(${v.variant_id}, '${v.color}', ${v.weight}, '${v.unit}', ${v.price}, ${v.stock}, '${v.promo}', ${v.promo_price || 0}, '${v.status}')"
                                class="text-blue-600 hover:text-blue-800">Sửa</button>
                        <button onclick="deleteVariant(${v.variant_id})"
                                class="text-red-600 hover:text-red-800">Xóa</button>
                    </div>
                </div>
            `;
                container.appendChild(card);
            });
        }

        // MỞ FORM BIẾN THỂ
        document.getElementById('addVariantBtn').onclick = () => {
            document.getElementById('variantForm').reset();
            document.getElementById('variantFormTitle').textContent = 'Thêm biến thể mới';
            document.getElementById('variant_id').value = '';
            document.getElementById('variant_product_id').value = currentProductId;
            document.getElementById('variant_unit').value = 'kg';
            document.getElementById('variant_promo_price').value = 0;
            document.getElementById('variant_promo_price').readOnly = true;
            document.getElementById('variant_promo_price').classList.add('bg-gray-100');
            openModal(document.getElementById('variantFormModal'));
        };

        window.editVariant = (id, color, weight, unit, price, stock, promo, promoPrice, status) => {
            document.getElementById('variant_id').value = id;
            document.getElementById('variant_product_id').value = currentProductId;
            document.getElementById('variant_color').value = color;
            document.getElementById('variant_weight').value = weight;
            document.getElementById('variant_unit').value = unit;
            document.getElementById('variant_price').value = price;
            document.getElementById('variant_stock').value = stock;
            document.getElementById('variant_promo').value = promo;
            document.getElementById('variant_promo_price').value = promoPrice || 0;
            document.getElementById('variant_status').value = status;

            const input = document.getElementById('variant_promo_price');
            if (promo === 'Có') {
                input.readOnly = false;
                input.classList.remove('bg-gray-100');
            } else {
                input.readOnly = true;
                input.classList.add('bg-gray-100');
            }

            document.getElementById('variantFormTitle').textContent = 'Chỉnh sửa biến thể';
            openModal(document.getElementById('variantFormModal'));
        };

        document.getElementById('variant_promo').addEventListener('change', function () {
            const input = document.getElementById('variant_promo_price');
            if (this.value === 'Có') {
                input.readOnly = false;
                input.classList.remove('bg-gray-100');
            } else {
                input.readOnly = true;
                input.classList.add('bg-gray-100');
                input.value = 0;
            }
        });

        // ===================================================================
        // TẤT CẢ CÁC HÀM GỌI API ĐƯỢC GOM DƯỚI ĐÂY – DỄ SỬA, DỄ ĐỌC
        // ===================================================================

        // THÊM SẢN PHẨM
        document.getElementById('addProductForm').onsubmit = async e => {
            e.preventDefault();
            const formData = new FormData(e.target);
            formData.append('status', 1);
            if (document.getElementById('add-image_input').files[0]) {
                formData.append('image_url', document.getElementById('add-image_input').files[0]);
            }
            console.log(formData);
            await fetch('/admin/store/products', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }, body: formData })
                .then(r => r.json())
                .then(json => { alert(json.message); if (json.success) location.reload(); })
                .catch(() => alert('Lỗi server!'));
        };

        // SỬA SẢN PHẨM
        document.getElementById('manageProductForm').onsubmit = async e => {
            e.preventDefault();
            const id = document.getElementById('manage-product_id').value;
            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('product_name', document.getElementById('manage-product_name').value);
            formData.append('status',1);
            formData.append('category_id', document.getElementById('manage-category_id').value);
            formData.append('brand', document.getElementById('manage-brand').value);
            formData.append('origin', document.getElementById('manage-origin').value);
            formData.append('description', document.getElementById('manage-description').value);
            if (document.getElementById('manage-image_input').files[0]) {
                formData.append('image_url', document.getElementById('manage-image_input').files[0]);
            }

            await fetch(`/admin/store/products/${id}`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }, body: formData })
                .then(r => r.json())
                .then(json => { alert(json.message); if (json.success) location.reload(); })
                .catch(() => alert('Lỗi server!'));
        };

        // XÓA SẢN PHẨM
        document.getElementById('btn-delete-product').onclick = async () => {
            if (!confirm('Xóa sản phẩm này? Không thể khôi phục!')) return;
            const id = document.getElementById('manage-product_id').value;
            await fetch(`/admin/store/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken } })
                .then(r => r.json())
                .then(json => { alert(json.message); if (json.success) location.reload(); });
        };

        // THÊM / SỬA BIẾN THỂ
        document.getElementById('variantForm').onsubmit = async e => {
            e.preventDefault();
            const id = document.getElementById('variant_id').value;
            const productId = document.getElementById('variant_product_id').value;

            const formData = new FormData();
            formData.append('color', document.getElementById('variant_color').value.trim());
            formData.append('weight', document.getElementById('variant_weight').value);
            formData.append('unit', document.getElementById('variant_unit').value.trim() || 'kg');
            formData.append('price', document.getElementById('variant_price').value);
            formData.append('stock', document.getElementById('variant_stock').value);
            formData.append('promo', document.getElementById('variant_promo').value);
            formData.append('promo_price', document.getElementById('variant_promo').value === 'Có' ? document.getElementById('variant_promo_price').value : 0);
            formData.append('status', document.getElementById('variant_status').value);
            if (id) formData.append('_method', 'PUT');

            const url = id ? `/admin/store/products/${productId}/variants/${id}` : `/admin/store/products/${productId}/variants`;

            await fetch(url, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }, body: formData })
                .then(r => r.json())
                .then(json => { alert(json.message); closeModal(document.getElementById('variantFormModal')); location.reload(); })
                .catch(() => alert('Lỗi server!'));
        };

        // XÓA BIẾN THỂ
        window.deleteVariant = async id => {
            if (!confirm('Xóa biến thể này?')) return;
            await fetch(`/admin/store/${currentProductId}/variants/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken } })
                .then(() => location.reload());
        };
    });
</script>
@endpush

@endsection
