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
                    <span class="ml-1 text-sm font-bold text-gray-900 md:ml-2">Chung</span>
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
                    
                    <div class="relative w-full aspect-square overflow-hidden rounded-[16px] bg-gray-100">
                        <a href="">
                            <img class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                                src=""
                                alt="">
                        </a>
                    </div>

                    <div class="mt-4">
                        
                        <h3 class="text-base font-bold text-gray-500 font-['Montserrat']">
                            <a href="">
                                Tên sản phẩm mẫu
                            </a>
                        </h3>

                        <div class="flex items-center mt-2 space-x-3">
                            
                            <p class="text-sm font-bold text-gray-900 font-open-sans">
                                119.000 VNĐ
                            </p>

                            <span class="inline-flex items-center justify-center rounded-lg bg-red-50 px-2.5 py-0.5 text-xs font-bold text-red-500">
                                -%
                            </span>
                        </div>

                        <p class="text-sm text-gray-400 line-through italic mt-1">
                            182.000 VNĐ
                        </p>
                    </div>

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

<!-- JavaScript Section -->
<script>
    // ==============================================================
    // 1. MOCK DATA
    // ==============================================================
    const products = [
        { id: 1, name: "Khăn tập", category: "dung-cu", price: "119.000 VNĐ", originalPrice: "182.000 VNĐ", discount: 35, image: "https://via.placeholder.com/400" },
        { id: 2, name: "Thảm tập Yoga", category: "dung-cu", price: "399.000 VNĐ", originalPrice: "665.000 VNĐ", discount: 40, image: "https://via.placeholder.com/400" },
        { id: 3, name: "Whey Protein Gold", category: "thuc-pham", price: "1.500.000 VNĐ", originalPrice: null, discount: 0, image: "https://via.placeholder.com/400" },
        { id: 4, name: "Áo thun thể thao", category: "quan-ao", price: "250.000 VNĐ", originalPrice: "300.000 VNĐ", discount: 15, image: "https://via.placeholder.com/400" },
        { id: 5, name: "Tạ tay 5kg", category: "dung-cu", price: "110.000 VNĐ", originalPrice: "122.000 VNĐ", discount: 10, image: "https://via.placeholder.com/400" },
        { id: 6, name: "Bình nước", category: "phu-kien", price: "149.000 VNĐ", originalPrice: "165.000 VNĐ", discount: 10, image: "https://via.placeholder.com/400" },
        { id: 7, name: "Băng đô thể thao", category: "phu-kien", price: "50.000 VNĐ", originalPrice: null, discount: 0, image: "https://via.placeholder.com/400" }
    ];

    // ==============================================================
    // 2. STATE
    // ==============================================================
    const ITEMS_PER_PAGE = 9; 
    let currentPage = 1;
    let currentCategory = "all"; 
    let minPrice = 0;
    let maxPrice = Infinity;
    let currentPromotion = "all"; 

    // ==============================================================
    // 3. HELPER
    // ==============================================================
    function parsePrice(priceString) {
        if (!priceString) return 0;
        return parseInt(priceString.replace(/\D/g, ''));
    }

    // ==============================================================
    // 4. RENDER APP
    // ==============================================================
    function renderApp() {
        const grid = document.getElementById('product-grid');
        const title = document.getElementById('category-title');
        const pagination = document.getElementById('pagination');
        
        // --- LỌC SẢN PHẨM (GIỮ NGUYÊN) ---
        const filteredProducts = products.filter(p => {
            const matchCategory = (currentCategory === 'all') || (p.category === currentCategory);
            const productPrice = parsePrice(p.price);
            const matchPrice = (productPrice >= minPrice) && (productPrice <= maxPrice);
            let matchPromotion = true;
            if (currentPromotion === 'on_sale') matchPromotion = p.discount > 0;
            else if (currentPromotion === 'no_sale') matchPromotion = p.discount === 0;
            return matchCategory && matchPrice && matchPromotion;
        });

        const totalPages = Math.ceil(filteredProducts.length / ITEMS_PER_PAGE);
        if (currentPage > totalPages) currentPage = 1;

        const start = (currentPage - 1) * ITEMS_PER_PAGE;
        const end = start + ITEMS_PER_PAGE;
        const productsToDisplay = filteredProducts.slice(start, end);

        grid.innerHTML = ''; 

        // --- [PHẦN THAY ĐỔI QUAN TRỌNG Ở ĐÂY] ---
        // Dòng này sẽ tạo ra string kiểu: "http://domain/san-pham"
        const baseUrl = "{{ route('product_detail') }}".replace(/\/$/, ""); 

        if (productsToDisplay.length === 0) {
            grid.innerHTML = `<div class="col-span-full flex flex-col items-center justify-center py-12 text-gray-500"><p>Không tìm thấy sản phẩm nào.</p></div>`;
        } 
        else {
            productsToDisplay.forEach(product => {
                
                // 2. Tạo đường dẫn chi tiết kèm ID (Ví dụ: .../san-pham/1)
                const detailUrl = `${baseUrl}/${product.id}`;

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
                            <a href="${detailUrl}">
                                ${product.name}
                            </a>
                        </h3>

                        <div class="flex items-center mt-2 space-x-3">
                            <p class="text-lg font-bold text-gray-900 font-open-sans">
                                ${product.price}
                            </p>
                            ${product.discount > 0 ? `
                            <span class="inline-flex items-center justify-center rounded-lg bg-red-50 px-2.5 py-0.5 text-xs font-bold text-red-500">
                                -${product.discount}%
                            </span>` : ''}
                        </div>

                        ${product.originalPrice ? `
                        <p class="text-sm text-gray-400 line-through italic mt-1">
                            ${product.originalPrice}
                        </p>` : ''}
                    </div>

                </div>`;
                grid.insertAdjacentHTML('beforeend', html);
            });
        }

        const categoryMap = { 'all': 'Chung', 'dung-cu': 'Dụng cụ tập luyện', 'thuc-pham': 'Thực phẩm bổ sung', 'quan-ao': 'Quần áo thể thao', 'phu-kien': 'Phụ kiện thể thao' };
        title.innerText = categoryMap[currentCategory] || 'Sản phẩm';
        renderPagination(totalPages);
    }

    // ==============================================================
    // 5. EVENTS
    // ==============================================================
    
    // 5A. Khuyến mãi Radio
    const saleRadios = document.querySelectorAll('input[name="filter_sale"]');
    saleRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                currentPromotion = this.value;
                currentPage = 1;
                renderApp();
            }
        });
    });

    // 5B. Áp dụng Giá
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
        minPrice = minVal;
        maxPrice = maxVal;
        currentPage = 1; 
        renderApp();     
    });

    // 5C. Xóa Tất Cả (RESET) 
    const btnClearAll = document.getElementById('btn-clear-all');
    btnClearAll.addEventListener('click', function() {
        // Reset State
        minPrice = 0;
        maxPrice = Infinity;
        currentPromotion = "all";
        currentPage = 1;
        // Reset UI
        document.getElementById('price-min').value = "";
        document.getElementById('price-max').value = "";
        errorMsg.classList.add('hidden');
        saleRadios.forEach(radio => radio.checked = false);
        // Render
        renderApp();
    });

    // 5D. Chuyển trang
    function changePage(page) {
        currentPage = page;
        renderApp(); 
        document.getElementById('category-title').scrollIntoView({ behavior: 'smooth' }); 
    }

    // 5E. Danh mục Sidebar
    const links = document.querySelectorAll('.category-link');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            currentCategory = this.getAttribute('data-category');
            currentPage = 1;
            links.forEach(l => {
                l.className = 'category-link group flex justify-between items-center text-base transition-colors text-gray-600 hover:text-blue-600';
                l.querySelector('svg').setAttribute('class', 'w-4 h-4 transition-colors text-gray-400 group-hover:text-blue-600');
            });
            this.className = 'category-link group flex justify-between items-center text-base transition-colors text-blue-600 font-bold';
            this.querySelector('svg').setAttribute('class', 'w-4 h-4 transition-colors text-blue-600');
            renderApp();
        });
    });

    // 5F. Render Phân trang
    function renderPagination(totalPages) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = ''; 
        if (totalPages <= 1) return; 
        const prevDisabled = currentPage === 1 ? 'pointer-events-none opacity-50' : '';
        pagination.insertAdjacentHTML('beforeend', `
            <a href="#" onclick="changePage(${currentPage - 1}); return false;" class="${prevDisabled} mr-4 flex items-center px-3 py-2 text-gray-600 hover:text-[#1976D2] transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> Trước
            </a>`);
        let pagesHTML = '<div class="flex items-center space-x-2">';
        for (let i = 1; i <= totalPages; i++) {
            if (i === currentPage) {
                pagesHTML += `<span class="inline-flex items-center justify-center w-9 h-9 text-sm font-bold text-white bg-[#1976D2] rounded-full shadow-md cursor-default">${i}</span>`;
            } 
            else {
                pagesHTML += `<a href="#" onclick="changePage(${i}); return false;" class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-gray-700 rounded-full hover:bg-gray-100 transition-colors">${i}</a>`;
            }
        }
        pagesHTML += '</div>';
        pagination.insertAdjacentHTML('beforeend', pagesHTML);
        const nextDisabled = currentPage === totalPages ? 'pointer-events-none opacity-50' : '';
        pagination.insertAdjacentHTML('beforeend', `
            <a href="#" onclick="changePage(${currentPage + 1}); return false;" class="${nextDisabled} ml-4 flex items-center px-3 py-2 text-gray-600 hover:text-[#1976D2] transition-colors">
                Sau <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>`);
    }

    // INIT
    renderApp();
</script>

@endsection