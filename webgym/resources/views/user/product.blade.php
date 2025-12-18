@extends('user.layouts.user_layout')

@section('title', 'GRYND - Cửa hàng')

@section('content')

<div class="container mx-auto px-4 py-8">

    <!-- Breadcrumb -->
    <nav class="flex mb-6 font-['Roboto']" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-normal text-gray-700 hover:text-blue-600">
                    Trang Chủ
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('product') }}" class="ml-1 text-sm font-normal text-gray-700 hover:text-blue-600">Cửa Hàng</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-bold text-gray-900 md:ml-2" id="breadcrumb-category">Chung</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Filter and Products Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <!-- Filter Sidebar -->
        <aside class="lg:col-span-1 bg-white p-6 rounded-lg shadow-sm h-fit sticky top-8">
            
            <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-200">
                <h3 class="text-xl font-bold text-gray-900 font-['Montserrat']">Bộ lọc</h3>
                <button class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
                    </svg>
                </button>
            </div>

            <div class="mb-8 font-open-sans">
                <ul class="space-y-4" id="category-list">
                    
                    <li>
                        <a href="#" data-category="all" class="category-link group flex justify-between items-center text-base transition-colors text-blue-600 font-bold">
                            <span class="font-medium">Chung</span>
                            <svg class="w-4 h-4 transition-colors text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>

                    <li>
                        <a href="#" data-category="dung-cu" class="category-link group flex justify-between items-center text-base transition-colors text-gray-600 hover:text-blue-600">
                            <span class="font-medium">Dụng cụ tập luyện</span>
                            <svg class="w-4 h-4 transition-colors text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>

                    <li>
                        <a href="#" data-category="thuc-pham" class="category-link group flex justify-between items-center text-base transition-colors text-gray-600 hover:text-blue-600">
                            <span class="font-medium">Thực phẩm bổ sung</span>
                            <svg class="w-4 h-4 transition-colors text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>

                    <li>
                        <a href="#" data-category="quan-ao" class="category-link group flex justify-between items-center text-base transition-colors text-gray-600 hover:text-blue-600">
                            <span class="font-medium">Quần áo thể thao</span>
                            <svg class="w-4 h-4 transition-colors text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>

                    <li>
                        <a href="#" data-category="phu-kien" class="category-link group flex justify-between items-center text-base transition-colors text-gray-600 hover:text-blue-600">
                            <span class="font-medium">Phụ kiện thể thao</span>
                            <svg class="w-4 h-4 transition-colors text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="pt-6 border-t border-gray-200 mb-6 font-open-sans">
                <div class="flex items-center justify-between mb-4 cursor-pointer group">
                    <h4 class="text-base font-bold text-gray-700">Khoảng giá</h4>
                </div>
                <div class="flex items-center space-x-2 mb-3">

                    <!-- Giá từ - đến -->
                    <div class="relative w-1/2">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-sm">₫</span>
                        <input type="number" id="price-min" placeholder="TỪ" class="w-full pl-6 pr-2 py-2 border border-gray-300 rounded-[10px] text-sm focus:ring-blue-500 focus:border-blue-500 text-center">
                    </div>
                    <span class="text-gray-400">-</span>
                    <div class="relative w-1/2">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 text-sm">₫</span>
                        <input type="number" id="price-max" placeholder="ĐẾN" class="w-full pl-6 pr-2 py-2 border border-gray-300 rounded-[10px] text-sm focus:ring-blue-500 focus:border-blue-500 text-center">
                    </div>
                </div>

                <p id="price-error" class="text-red-500 text-xs mb-3 hidden">
                    Vui lòng điền khoảng giá phù hợp!
                </p>

                <button id="btn-apply-price" class="w-full bg-white text-[#1976D2] py-2 
                        rounded-[10px] font-semibold border-1 border-[#1976D2] 
                        hover:bg-[#1565C0] hover:text-white hover:border-[#1565C0]
                        transition-all shadow-md hover:shadow-lg">
                    ÁP DỤNG
                </button>
            </div>

            <div class="pt-6 border-t border-gray-200 font-open-sans">
                <div class="flex items-center justify-between mb-4 cursor-pointer group">
                    <h4 class="text-base font-bold text-gray-700">Khuyến mãi</h4>
                </div>
                <div class="space-y-3 font-open-sans">
                    <label class="flex items-center space-x-3 text-gray-600 cursor-pointer hover:text-blue-600">
                        <input type="radio" name="filter_sale" value="on_sale" class="form-radio h-4 w-4 text-[#1976D2] border-gray-300 focus:ring-blue-500">
                        <span>Đang giảm giá</span>
                    </label>
                    
                    <label class="flex items-center space-x-3 text-gray-600 cursor-pointer hover:text-blue-600">
                        <input type="radio" name="filter_sale" value="no_sale" class="form-radio h-4 w-4 text-[#1976D2] border-gray-300 focus:ring-blue-500">
                        <span>Không giảm giá</span>
                    </label>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-200 mt-6 font-open-sans">
                <button id="btn-clear-all" class="w-full bg-white text-[#1976D2] py-2 
                        rounded-[10px] font-semibold border-1 border-[#1976D2] 
                        hover:bg-[#1565C0] hover:text-white hover:border-[#1565C0]
                        transition-all shadow-md hover:shadow-lg">
                    XÓA TẤT CẢ
                </button>
            </div>

        </aside>

        <!-- Main Products Grid -->
        <main class="lg:col-span-3">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6 font-['Montserrat']" id="category-title">Chung</h2>

            <!-- Products Grid -->
            <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 font-open-sans">

                <div class="group flex flex-col rounded-[20px] border border-gray-200 bg-white p-4 shadow-sm transition-all hover:shadow-lg hover:-translate-y-1">

                </div>

            </div>

            <!-- Pagination -->
            <nav id="pagination" class="flex items-center justify-center border-t border-gray-200 pt-8 mt-10 font-open-sans">
    
                <a href="?page=PREV" 
                class="mr-4 flex items-center px-3 py-2 text-gray-600 hover:text-[#1976D2] transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Trước
                </a>

                <div class="flex items-center space-x-2">
                    
                    <span class="inline-flex items-center justify-center w-9 h-9 text-sm font-bold text-white bg-[#1976D2] rounded-full shadow-md cursor-default">
                        1
                    </span>

                    <a href="?page=2" class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-gray-700 rounded-full hover:bg-gray-100 transition-colors">
                        2
                    </a>
                    
                    <span class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-gray-400">
                        ...
                    </span>
                    
                    <a href="?page=10" class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-gray-700 rounded-full hover:bg-gray-100 transition-colors">
                        10
                    </a>

                </div>

                <a href="?page=NEXT" 
                class="ml-4 flex items-center px-3 py-2 text-gray-600 hover:text-[#1976D2] transition-colors">
                    Sau
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>

            </nav>

        </main>

    </div>
</div>

<script>
    // Lấy tham số search từ URL trình duyệt 
    const urlParams = new URLSearchParams(window.location.search);
    let currentSearch = urlParams.get('search') || '';

    // Đặt các biến trạng thái lọc và phân trang
    let currentPage = 1;
    let currentCategory = { slug: 'all', name: 'Tất cả sản phẩm' };    
    let minPrice = "";
    let maxPrice = "";
    let currentPromotion = "all"; 

    // URL cơ sở cho API
    const API_URL = "{{ url('/api/products') }}";
    const CATEGORY_API_URL = "{{ url('/api/categories') }}";
    const PRODUCT_DETAIL_URL = "{{ route('product.detail', ['slug' => 'placeholder']) }}".replace('/placeholder', '');

    // Khởi tạo các sự kiện
    document.addEventListener('DOMContentLoaded', () => {
        // Hiển thị thông báo nếu đang tìm kiếm
        if(currentSearch) {
            document.getElementById('category-title').innerHTML = `Kết quả tìm kiếm: <span class="text-blue-600">"${currentSearch}"</span>`;
            document.getElementById('breadcrumb-category').innerText = "Tìm kiếm";
        }

        loadCategories();
        fetchProducts(); 

        // XÓA NỘI DUNG THANH TÌM KIẾM 
        const searchInputs = document.querySelectorAll('input[name="search"]');
        searchInputs.forEach(input => {
            input.value = ''; 
        });
    });

    // Tải danh mục từ API
    async function loadCategories() {
        try {
            const response = await fetch(CATEGORY_API_URL);
            const data = await response.json();
            const categories = data.categories;
            
            const list = document.getElementById('category-list');
            // Giữ lại mục "Chung"
            let html = `
                <li>
                    <a href="#" data-slug="all" data-name="Tất cả sản phẩm" class="category-link group flex justify-between items-center text-base transition-colors text-blue-600 font-bold">
                        <span class="font-medium">Chung</span>
                        <svg class="w-4 h-4 transition-colors text-blue-600" fill="none" stroke="currentColor" 
                            viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </li>
            `;

            categories.forEach(cat => {
                html += `
                    <li>
                        <a href="#" data-slug="${cat.slug}" data-name="${cat.category_name}" class="category-link group flex justify-between 
                            items-center text-base transition-colors text-gray-600 hover:text-blue-600">
                            <span class="font-medium">${cat.category_name}</span>
                            <svg class="w-4 h-4 transition-colors text-gray-400 group-hover:text-blue-600" fill="none" 
                                stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </li>
                `;
            });
            list.innerHTML = html;
            setupCategoryEvents(); // Gán sự kiện click 
        } catch (error) {
            console.error('Lỗi tải danh mục:', error);
        }
    }

    // Tải sản phẩm từ API
    async function fetchProducts() {
        const grid = document.getElementById('product-grid');
        const title = document.getElementById('category-title');
        const breadcrumb = document.getElementById('breadcrumb-category');
        const pagination = document.getElementById('pagination');

        if (currentSearch && currentSearch.trim() !== "") {
            // Nếu đang có từ khóa tìm kiếm -> Hiển thị kết quả tìm kiếm
            title.innerHTML = `Kết quả tìm kiếm: <span class="text-blue-600">"${currentSearch}"</span>`;
            breadcrumb.innerText = "Tìm kiếm";
        } else {
            // Nếu không tìm kiếm -> Hiển thị tên danh mục hiện tại
            title.innerText = currentCategory.name;
            breadcrumb.innerText = currentCategory.name;
        }

        // Hiển thị loading 
        grid.innerHTML = '<p class="col-span-full text-center py-10">Đang tải sản phẩm...</p>';

        try {
            // Xây dựng URL API với các tham số lọc
            let url = `${API_URL}?page=${currentPage}`;

            if (currentSearch) url += `&search=${encodeURIComponent(currentSearch)}`;
            
            if (currentCategory.slug !== 'all') url += `&category=${currentCategory.slug}`;
            if (minPrice) url += `&min_price=${minPrice}`;
            if (maxPrice) url += `&max_price=${maxPrice}`;
            if (currentPromotion !== 'all') url += `&sale=${currentPromotion}`;

            // Gọi API
            const response = await fetch(url);
            const result = await response.json();
            const products = result.products; 
            const meta = result.pagination;  

            // // Render tiêu đề
            // title.innerText = currentCategory.name;
            // document.getElementById('breadcrumb-category').innerText = currentCategory.name;

            // Render sản phẩm
            grid.innerHTML = '';
            if (products.length === 0) {
                grid.innerHTML = `<div class="col-span-full flex flex-col items-center justify-center py-12 text-gray-500"><p>Không tìm thấy sản phẩm nào.</p></div>`;
            } else {
                products.forEach(product => {
                    const detailUrl = `${PRODUCT_DETAIL_URL}/${product.slug}`;
                    const html = `
                    <div class="group flex flex-col rounded-[20px] border border-gray-200 bg-white p-4 shadow-sm transition-all hover:shadow-lg hover:-translate-y-1">
                        <div class="relative w-full aspect-square overflow-hidden rounded-[16px] bg-gray-100">
                            <a href="${detailUrl}">
                                <img class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105" 
                                     src="${product.image}" alt="${product.name}">
                            </a>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-bold text-gray-900 font-['Montserrat']">
                                <a href="${detailUrl}">${product.name}</a>
                            </h3>
                            <div class="flex items-center mt-2 space-x-3">
                                <p class="text-lg font-bold text-red-800 font-open-sans">${product.price}</p>
                                ${product.discount > 0 ? `
                                <span class="inline-flex items-center justify-center rounded-lg bg-red-50 px-2.5 py-0.5 text-xs font-bold text-red-500">-${product.discount}%</span>` : ''}
                            </div>
                            ${product.originalPrice ? `
                            <p class="text-sm text-gray-400 line-through italic mt-1">${product.originalPrice}</p>` : ''}
                        </div>
                    </div>`;
                    grid.insertAdjacentHTML('beforeend', html);
                });
            }

            // Render phân trang
            renderPagination(meta.last_page, meta.current_page);

        } catch (error) {
            console.error('Lỗi tải sản phẩm:', error);
            grid.innerHTML = '<p class="col-span-full text-center text-red-500 py-10">Lỗi khi tải dữ liệu.</p>';
        }
    }

    // Gán sự kiện cho danh mục
    function setupCategoryEvents() {
        const links = document.querySelectorAll('.category-link');
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                // Update UI active state
                links.forEach(l => {
                    l.className = 'category-link group flex justify-between items-center text-base transition-colors text-gray-600 hover:text-blue-600';
                    l.querySelector('svg').setAttribute('class', 'w-4 h-4 transition-colors text-gray-400 group-hover:text-blue-600');
                });
                this.className = 'category-link group flex justify-between items-center text-base transition-colors text-blue-600 font-bold';
                this.querySelector('svg').setAttribute('class', 'w-4 h-4 transition-colors text-blue-600');

                // Update State & Fetch
                currentCategory.slug = this.getAttribute('data-slug');
                currentCategory.name = this.getAttribute('data-name');
                currentPage = 1;
                fetchProducts();
            });
        });
    }

    // Lọc Khuyến mãi
    const saleRadios = document.querySelectorAll('input[name="filter_sale"]');
    saleRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                currentPromotion = this.value;
                currentPage = 1;
                fetchProducts();
            }
        });
    });

    //  Áp dụng Giá
    const btnApplyPrice = document.getElementById('btn-apply-price');
    const errorMsg = document.getElementById('price-error');
    btnApplyPrice.addEventListener('click', function() {
        const minInput = document.getElementById('price-min').value;
        const maxInput = document.getElementById('price-max').value;
        const minVal = minInput ? Number(minInput) : 0;
        const maxVal = maxInput ? Number(maxInput) : Infinity;

        if (maxInput !== '' && minVal > maxVal) {
            errorMsg.classList.remove('hidden');
            return; 
        } else {
            errorMsg.classList.add('hidden'); 
        }
        minPrice = minInput; // Gửi giá trị gốc lên API
        maxPrice = maxInput;
        currentPage = 1; 
        fetchProducts(); 
    });

    // Xóa Tất Cả
    const btnClearAll = document.getElementById('btn-clear-all');
    btnClearAll.addEventListener('click', function() {
        minPrice = "";
        maxPrice = "";
        currentPromotion = "all";
        currentCategory = { slug: 'all', name: 'Tất cả sản phẩm' };
        currentSearch = "";
        currentPage = 1;
        
        document.getElementById('price-min').value = "";
        document.getElementById('price-max').value = "";
        errorMsg.classList.add('hidden');
        saleRadios.forEach(radio => radio.checked = false);

        window.history.pushState({}, document.title, "{{ route('product') }}");
        
        fetchProducts();
    });

    // Chuyển trang
    window.changePage = function(page) { // Gán vào window 
        if (page < 1) return;
        currentPage = page;
        fetchProducts();
        document.getElementById('category-title').scrollIntoView({ behavior: 'smooth' }); 
    }

    // Render HTML Phân trang
    function renderPagination(totalPages, current) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = ''; 
        if (totalPages <= 1) return; 

        const prevDisabled = current === 1 ? 'pointer-events-none opacity-50' : '';
        const nextDisabled = current === totalPages ? 'pointer-events-none opacity-50' : '';

        let html = `
            <a href="#" onclick="changePage(${current - 1}); return false;" class="${prevDisabled} mr-4 flex items-center px-3 py-2 text-gray-600 hover:text-[#1976D2] transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Trước
            </a>
            <div class="flex items-center space-x-2">`;

        for (let i = 1; i <= totalPages; i++) {
            if (i === current) {
                html += `<span class="inline-flex items-center justify-center w-9 h-9 text-sm font-bold text-white bg-[#1976D2] rounded-full shadow-md cursor-default">${i}</span>`;
            } else {
                html += `<a href="#" onclick="changePage(${i}); return false;" class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-gray-700 rounded-full hover:bg-gray-100 transition-colors">${i}</a>`;
            }
        }

        html += `</div>
            <a href="#" onclick="changePage(${current + 1}); return false;" class="${nextDisabled} ml-4 flex items-center px-3 py-2 text-gray-600 hover:text-[#1976D2] transition-colors">
                Sau <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>`;
        
        pagination.innerHTML = html;
    }
</script>

@endsection