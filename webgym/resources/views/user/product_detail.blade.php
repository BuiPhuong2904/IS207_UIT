@extends('user.layouts.user_layout')

@section('title', $product->product_name . ' - GRYND')

@section('content')

<!-- Product Detail Section -->
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
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('product') }}?category={{ $product->category->slug ?? '' }}" class="ml-1 text-sm font-normal text-gray-700 hover:text-blue-600" id="breadcrumb-category">
                        {{ $product->category->category_name ?? 'Chung' }}
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-bold text-gray-900 md:ml-2 truncate max-w-[200px]">
                        {{ $product->product_name }}
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Product Details -->
    <section class="bg-white py-8 font-['Roboto']">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-7 gap-12">
                
                <!-- Hình ảnh sản phẩm -->
                <div id="product-gallery" class="w-full lg:col-span-3">
                    <div class="relative aspect-square w-full overflow-hidden rounded-[24px] mb-6 bg-[#F4F4F4]">
                        <img id="main-image" src="{{ $product->image_url }}" 
                            alt="{{ $product->product_name }}" 
                            class="w-full h-full object-cover object-center mix-blend-multiply transition-opacity duration-300"
                            onerror="this.src='https://via.placeholder.com/600?text=No+Image'">
                    </div>

                    <div class="flex items-center justify-between gap-4 relative">
                        <button id="prev-btn" class="hidden w-10 h-10 shrink-0 items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:bg-[#9d1c30] hover:text-white hover:border-[#9d1c30] transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>

                        <div class="flex-1 overflow-hidden">
                            <div id="thumbnail-track" class="flex gap-4 transition-transform duration-300 ease-out" style="width: 100%;">
                                <!-- Ảnh gốc -->
                                <div class="thumb-item active w-[calc(33.33%-11px)] shrink-0 aspect-square rounded-[16px] overflow-hidden border-2 border-[#9d1c30] p-1 cursor-pointer transition-all" 
                                    onclick="changeImage(this, '{{ $product->image_url }}')">
                                    <div class="w-full h-full rounded-[10px] overflow-hidden bg-[#F4F4F4]">
                                        <img src="{{ $product->image_url }}" class="w-full h-full object-cover mix-blend-multiply" onerror="this.src='https://via.placeholder.com/150'">
                                    </div>
                                </div>
                                <!-- Loop ảnh các biến thể -->
                                @php 
                                    $variantImages = $product->variants->whereNotNull('image_url')->unique('image_url');
                                @endphp
                                @foreach($variantImages as $variant)
                                    @if($variant->image_url != $product->image_url)
                                    <div class="thumb-item w-[calc(33.33%-11px)] shrink-0 aspect-square rounded-[16px] overflow-hidden border-2 border-transparent p-1 cursor-pointer hover:border-gray-300 transition-all" 
                                        onclick="changeImage(this, '{{ $variant->image_url }}')">
                                        <div class="w-full h-full rounded-[10px] overflow-hidden bg-[#F4F4F4]">
                                            <img src="{{ $variant->image_url }}" class="w-full h-full object-cover mix-blend-multiply" onerror="this.src='https://via.placeholder.com/150'">
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <button id="next-btn" class="hidden w-10 h-10 shrink-0 items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:bg-[#9d1c30] hover:text-white hover:border-[#9d1c30] transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Thông tin sản phẩm -->
                <div class="flex flex-col pt-2 font-montserrat lg:col-span-4">
                    <h1 class="text-[40px] leading-tight font-extrabold text-[#350504] mb-2 tracking-tight drop-shadow-[0_4px_4px_rgba(0,0,0,0.25)]">
                        {{ $product->product_name }}
                    </h1>
                    
                    <div class="flex items-center mb-3 space-x-2">
                        <div class="flex text-yellow-400 text-lg">
                            @for($i=0; $i<5; $i++) <span>★</span> @endfor
                        </div>
                        <span class="text-sm text-gray-600 font-semibold mt-0.5">5/5</span>
                    </div>

                    <!-- Giá tiền Dynamic -->
                    <div class="flex items-center space-x-3 mb-5" id="price-container">
                        <span id="dynamic-price" class="text-[32px] font-extrabold text-[#590807]">
                            @if($minPrice == $maxPrice)
                                {{ number_format($minPrice, 0, ',', '.') }} VNĐ
                            @else
                                {{ number_format($minPrice, 0, ',', '.') }} - {{ number_format($maxPrice, 0, ',', '.') }} VNĐ
                            @endif
                        </span>
                    </div>

                    <div class="text-gray-500 text-sm mb-4 leading-relaxed font-normal font-open-sans">
                        <p>{!! nl2br(e($product->description)) !!}</p>
                    </div>
                    <hr class="border-gray-300 my-3"> 

                    <!-- Color Selector -->
                    @if($colors->count() > 0)
                    <div class="mb-4 relative group/slider">
                        <h4 class="text-sm font-medium text-gray-500 mb-3 font-open-sans">Màu sắc</h4>
                        <div class="relative flex items-center">
                            <button id="color-prev-btn" class="hidden absolute left-0 z-10 w-8 h-full bg-gradient-to-r from-white via-white/80 to-transparent items-center justify-start hover:text-[#8B1D28] transition-colors">
                                <svg class="w-5 h-5 bg-white rounded-full shadow-sm border border-gray-200 p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <div id="color-scroll-container" class="flex gap-3 overflow-x-auto scroll-smooth px-1 py-1 w-full no-scrollbar">
                                @foreach($colors as $key => $color)
                                <label class="cursor-pointer shrink-0">
                                    <input type="radio" name="color_id" value="{{ $color }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}> 
                                    <span class="block px-6 py-2 text-sm font-medium bg-[#F3F4F6] text-gray-600 rounded-full border border-transparent 
                                    hover:bg-gray-200 
                                    peer-checked:bg-white peer-checked:border-[#8B1D28] peer-checked:text-[#8B1D28] 
                                    peer-checked:hover:bg-white peer-checked:hover:text-[#8B1D28] transition-all whitespace-nowrap">
                                        {{ $color }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                            <button id="color-next-btn" class="hidden absolute right-0 z-10 w-8 h-full bg-gradient-to-l from-white via-white/80 to-transparent items-center justify-end hover:text-[#8B1D28] transition-colors">
                                <svg class="w-5 h-5 bg-white rounded-full shadow-sm border border-gray-200 p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>
                    <hr class="border-gray-300 my-3"> 
                    @endif

                    <!-- Size Selector -->
                    @if($sizes->count() > 0)
                    <div class="mb-4 relative group/slider">
                        <div class="flex justify-between items-end mb-3">
                            <h4 class="text-sm font-medium text-gray-500 font-open-sans">Kích thước / Trọng lượng</h4>
                        </div>
                        <div class="relative flex items-center">
                            <button id="size-prev-btn" class="hidden absolute left-0 z-10 w-8 h-full bg-gradient-to-r from-white via-white/80 to-transparent items-center justify-start hover:text-[#8B1D28] transition-colors">
                                <svg class="w-5 h-5 bg-white rounded-full shadow-sm border border-gray-200 p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <div id="size-scroll-container" class="flex gap-3 overflow-x-auto scroll-smooth px-1 py-1 w-full no-scrollbar">
                                @foreach($sizes as $key => $size)
                                <label class="cursor-pointer shrink-0">
                                    <input type="radio" name="size_id" value="{{ $size }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                                    <span class="block px-6 py-2 text-sm font-medium bg-[#F3F4F6] text-gray-600 rounded-full border border-transparent 
                                    hover:bg-gray-200 
                                    peer-checked:bg-white peer-checked:border-[#8B1D28] peer-checked:text-[#8B1D28] 
                                    peer-checked:hover:bg-white peer-checked:hover:text-[#8B1D28] transition-all whitespace-nowrap">
                                        {{ $size }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                            <button id="size-next-btn" class="absolute right-0 z-10 w-8 h-full bg-gradient-to-l from-white via-white/80 to-transparent flex items-center justify-end hover:text-[#8B1D28] transition-colors">
                                <svg class="w-5 h-5 bg-white rounded-full shadow-sm border border-gray-200 p-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                        <p id="stock-display" class="text-xs text-gray-400 mt-2 font-open-sans ml-1">Kho: Đang kiểm tra...</p>
                    </div>
                    <hr class="border-gray-300 my-3"> 
                    @endif

                    <!-- Quantity Selector -->
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-500 mb-3 font-open-sans">Số lượng</h4>
                        <div class="flex items-center bg-[#F3F4F6] rounded-[8px] w-fit px-1 h-10">
                            <button type="button" id="decrease-btn" class="px-3 text-gray-600 hover:text-black transition-colors text-xl font-medium focus:outline-none cursor-pointer select-none">-</button>
                            <input type="number" id="quantity-input" value="1" min="1" class="w-10 text-center bg-transparent border-none focus:ring-0 text-sm font-bold text-gray-800 p-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <button type="button" id="increase-btn" class="px-3 text-gray-600 hover:text-black transition-colors text-xl font-medium focus:outline-none cursor-pointer select-none">+</button>
                        </div>
                    </div>
                    <hr class="border-gray-300 my-3"> 

                    <!-- Action Buttons -->
                    <div class="flex gap-4 mt-2 font-open-sans">
                        <button id="btn-add-to-cart" class="group flex-1 py-3 px-4 border border-[#A5032C] text-[#A5032C] bg-white font-bold rounded-[8px] hover:bg-red-50 transition-all flex items-center justify-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Thêm vào giỏ hàng
                        </button>
                        <button id="btn-buy-now" class="flex-1 py-3 px-4 bg-[#A5032C] text-white font-bold rounded-[8px] hover:bg-[#850A1E] transition-all shadow-md hover:shadow-lg text-sm">
                            Mua ngay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chi tiết & Đánh giá -->
    <div class="bg-white p-6 mt-5 mb-6 pt-10 font-open-sans shadow-sm">
        <div class="flex w-full border-b border-gray-200 mb-8">
            <button id="tab-details" onclick="switchTab('details')" class="w-1/2 pb-4 text-lg font-bold text-gray-900 border-b-2 border-blue-500 -mb-[1px] text-center transition-all duration-300">
                Chi tiết sản phẩm
            </button>
            <button id="tab-reviews" onclick="switchTab('reviews')" class="w-1/2 pb-4 text-lg font-normal text-gray-400 border-b-2 border-transparent hover:text-gray-600 text-center transition-all duration-300">
                Đánh giá sản phẩm
            </button>
        </div>

        <div class="w-full lg:w-11/12 mx-auto min-h-[300px]"> 
            <!-- Chi tiết -->
            <div id="content-details" class="flex flex-col gap-y-6 text-[15px] animate-fade-in">
                <div class="grid grid-cols-1 md:grid-cols-[200px_1fr] gap-2">
                    <span class="text-gray-500 font-normal">Mã sản phẩm</span>
                    <span class="text-gray-900 font-medium">SP-000{{ $product->product_id }}</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-[200px_1fr] gap-2">
                    <span class="text-gray-500 font-normal">Thương hiệu</span>
                    <span class="text-gray-900 font-medium">{{ $product->brand ?? 'Đang cập nhật' }}</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-[200px_1fr] gap-2">
                    <span class="text-gray-500 font-normal">Xuất xứ</span>
                    <span class="text-gray-900 font-medium">{{ $product->origin ?? 'Đang cập nhật' }}</span>
                </div>
                @if($colors->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-[200px_1fr] gap-2">
                    <span class="text-gray-500 font-normal">Màu sắc</span>
                    <span class="text-gray-900 font-medium">{{ $colors->implode(', ') }}</span>
                </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-[200px_1fr] gap-2">
                    <span class="text-gray-500 font-normal">Kích thước/Trọng lượng</span>
                    <span class="text-gray-900 font-medium">{{ $sizes->count() > 0 ? $sizes->implode(', ') : '' }}</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-[200px_1fr] gap-2 mt-2">
                    <span class="text-gray-500 font-normal pt-1">Mô tả</span>
                    <div class="text-gray-800 leading-relaxed space-y-4 text-justify">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Đánh giá -->
            <div id="content-reviews" class="hidden animate-fade-in">
                <div class="flex justify-between items-center mb-6 font-open-sans">
                    <h3 class="text-xl font-bold text-gray-900">Tất cả đánh giá</h3>
                    <div class="flex gap-3 relative">
                        <button class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        </button>
                        <div class="relative">
                            <button onclick="toggleSortDropdown()" class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-800 rounded-full text-sm font-medium hover:bg-gray-200 transition-colors">
                                <span id="sort-text">Gần đây</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div id="sort-dropdown-menu" class="hidden absolute right-0 top-full mt-2 w-32 bg-white rounded-[12px] shadow-xl border border-gray-100 z-10 overflow-hidden animate-fade-in">
                                <ul class="py-1 text-sm text-gray-700">
                                    <li><button onclick="selectSortOption('Gần đây')" class="block w-full text-left px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 transition-colors">Gần đây</button></li>
                                    <li><button onclick="selectSortOption('Tất cả')" class="block w-full text-left px-4 py-2.5 hover:bg-blue-50 hover:text-blue-600 transition-colors">Tất cả</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="border border-gray-200 rounded-[16px] p-6 bg-white hover:shadow-sm transition-shadow">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex text-yellow-400 text-sm">★★★★★</div>
                            <button class="text-gray-400 hover:text-gray-600">•••</button>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Anh Tú</h4>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">“Sản phẩm đúng như mô tả — hoàn thiện tốt, bề mặt sơn mịn, cầm chắc tay. Giao hàng nhanh, đóng gói cẩn thận.”</p>
                        <p class="text-xs text-gray-400">Ngày: 27/10/2025</p>
                    </div>
                    <div class="border border-gray-200 rounded-[16px] p-6 bg-white hover:shadow-sm transition-shadow">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex text-yellow-400 text-sm">★★★★★</div>
                            <button class="text-gray-400 hover:text-gray-600">•••</button>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Lan Ngọc</h4>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">“Tạ nhẹ, thiết kế gọn đẹp phù hợp để tập ở nhà. Sản phẩm chắc chắn và dễ vệ sinh.”</p>
                        <p class="text-xs text-gray-400">Ngày: 27/10/2025</p>
                    </div>
                    <div class="border border-gray-200 rounded-[16px] p-6 bg-white hover:shadow-sm transition-shadow">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex text-yellow-400 text-sm">★★★★★</div>
                            <button class="text-gray-400 hover:text-gray-600">•••</button>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Quân AP</h4>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">“Đã dùng được 2 tháng, vẫn như mới. Sơn không tróc, tay cầm không bị mài mòn dù dùng nhiều.”</p>
                        <p class="text-xs text-gray-400">Ngày: 27/10/2025</p>
                    </div>
                    <div class="border border-gray-200 rounded-[16px] p-6 bg-white hover:shadow-sm transition-shadow">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex text-yellow-400 text-sm">★★★★★</div>
                            <button class="text-gray-400 hover:text-gray-600">•••</button>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Thành Cry</h4>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">“Tổng thể tốt: thiết kế đẹp, bám sàn tốt, không bị lăn. Mình trừ nửa sao vì đợt giao có chậm 1 ngày nhưng shop có báo trước.”</p>
                        <p class="text-xs text-gray-400">Ngày: 27/10/2025</p>
                    </div>
                </div>

                <div class="text-center">
                    <button class="px-8 py-2 border border-gray-300 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-200 hover:border-gray-500 hover:text-gray-900 transition-colors">Xem thêm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Có thể bạn cũng thích -->
<div class="container mx-auto px-4 pb-8 pt-0 -mt-8 relative z-10">
    <h2 class="text-2xl font-bold text-left text-black mb-6 font-['Montserrat'] uppercase">
        Có thể bạn cũng thích
    </h2>
    
    <div id="related-products-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($relatedProducts as $related)
        @php
            // Tính toán giá cho từng sản phẩm liên quan ngay 
            $rVariant = $related->variants->first();
            $rPrice = 0; $rOriginalPrice = null; $rDiscount = 0;

            if ($rVariant) {
                $rPrice = $rVariant->price;
                if ($rVariant->is_discounted && $rVariant->discount_price > 0) {
                    $rPrice = $rVariant->discount_price;
                    $rOriginalPrice = $rVariant->price;
                    if ($rOriginalPrice > 0) {
                        $rDiscount = round((($rOriginalPrice - $rPrice) / $rOriginalPrice) * 100);
                    }
                }
            }
        @endphp
        
        <div class="group flex flex-col rounded-[20px] border border-gray-200 bg-white p-4 shadow-sm transition-all hover:shadow-lg hover:-translate-y-1">
            <div class="relative w-full aspect-square overflow-hidden rounded-[16px] bg-gray-100 mb-4">
                <a href="{{ route('product.detail', ['slug' => $related->slug]) }}">
                    <img src="{{ $related->image_url }}" class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105" onerror="this.src='https://via.placeholder.com/300'">
                </a>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 font-['Montserrat'] truncate">
                    <a href="{{ route('product.detail', ['slug' => $related->slug]) }}">{{ $related->product_name }}</a>
                </h3>
                <div class="flex items-center mt-2 space-x-3">
                    @if($rDiscount > 0)
                        <p class="text-lg font-bold text-red-800 font-open-sans">
                            {{ number_format($rPrice, 0, ',', '.') }} VNĐ
                        </p>
                        <span class="inline-flex items-center justify-center rounded-lg bg-red-50 px-2.5 py-0.5 text-xs font-bold text-red-500">
                            -{{ $rDiscount }}%
                        </span>
                        </div> 
                        <p class="text-sm text-gray-400 line-through italic mt-1">
                            {{ number_format($rOriginalPrice, 0, ',', '.') }} VNĐ
                        </p>
                    @else
                        <p class="text-lg font-bold text-red-800 font-open-sans">
                            {{ number_format($rPrice, 0, ',', '.') }} VNĐ
                        </p>
                        </div> 
                    @endif
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="text-center mt-10">
        <button id="load-more-related-btn" class="px-8 py-2 border border-gray-300 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-200 hover:border-gray-500 hover:text-gray-900 transition-colors">
            Xem thêm
        </button>
    </div>
</div>

{{-- Script JS --}}
<script>
    // Global functions
    function switchTab(tabName) {
        const tabDetails = document.getElementById('tab-details');
        const tabReviews = document.getElementById('tab-reviews');
        const contentDetails = document.getElementById('content-details');
        const contentReviews = document.getElementById('content-reviews');

        const activeClasses = ['font-bold', 'text-gray-900', 'border-blue-500'];
        const inactiveClasses = ['font-normal', 'text-gray-400', 'border-transparent'];

        if (tabName === 'details') {
            tabDetails.classList.add(...activeClasses); tabDetails.classList.remove(...inactiveClasses);
            tabReviews.classList.remove(...activeClasses); tabReviews.classList.add(...inactiveClasses);
            contentDetails.classList.remove('hidden'); contentReviews.classList.add('hidden');
        } else {
            tabReviews.classList.add(...activeClasses); tabReviews.classList.remove(...inactiveClasses);
            tabDetails.classList.remove(...activeClasses); tabDetails.classList.add(...inactiveClasses);
            contentReviews.classList.remove('hidden'); contentDetails.classList.add('hidden');
        }
    }

    function toggleSortDropdown() {
        const menu = document.getElementById('sort-dropdown-menu');
        if (menu) menu.classList.toggle('hidden');
    }

    function selectSortOption(text) {
        const sortText = document.getElementById('sort-text');
        if (sortText) sortText.innerText = text;
        toggleSortDropdown();
    }
    
    function changeImage(element, newSrc) {
        const mainImg = document.getElementById('main-image');
        if(!mainImg) return;
        mainImg.style.opacity = 0;
        setTimeout(() => { mainImg.src = newSrc; mainImg.style.opacity = 1; }, 150);
        document.querySelectorAll('.thumb-item').forEach(el => {
            el.classList.remove('border-[#9d1c30]', 'active');
            el.classList.add('border-transparent', 'hover:border-gray-300');
        });
        if(element) {
            const activeThumb = element.classList.contains('thumb-item') ? element : element.closest('.thumb-item');
            if(activeThumb) {
                activeThumb.classList.remove('border-transparent', 'hover:border-gray-300');
                activeThumb.classList.add('border-[#9d1c30]', 'active');
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        
        // 1. Logic Biến thể & Giá
        const productVariants = @json($product->variants);
        let selectedColor = document.querySelector('input[name="color_id"]:checked')?.value || null;
        let selectedSize = document.querySelector('input[name="size_id"]:checked')?.value || null;

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
        }

        function updateProductInfo() {
            let matchedVariant = productVariants.find(v => v.color == selectedColor && v.size == selectedSize);
            if (!matchedVariant && selectedColor && !selectedSize) matchedVariant = productVariants.find(v => v.color == selectedColor);
            if (!matchedVariant && !selectedColor && selectedSize) matchedVariant = productVariants.find(v => v.size == selectedSize);
            if (productVariants.length === 1) matchedVariant = productVariants[0];

            const priceContainer = document.getElementById('price-container');
            const stockElement = document.getElementById('stock-display');
            const addToCartBtn = document.getElementById('btn-add-to-cart');

            if (matchedVariant) {
                if (matchedVariant.is_discounted == 1 && matchedVariant.discount_price > 0) {
                    let percent = 0;
                    if(matchedVariant.price > 0) percent = Math.round(((matchedVariant.price - matchedVariant.discount_price) / matchedVariant.price) * 100);
                    priceContainer.innerHTML = `<span class="text-[32px] font-extrabold text-[#590807]">${formatCurrency(matchedVariant.discount_price)}</span><span class="text-xl text-gray-400 line-through font-bold decoration-2">${formatCurrency(matchedVariant.price)}</span><span class="inline-flex items-center justify-center rounded-lg bg-red-50 px-2.5 py-0.5 text-xs font-bold text-red-500">-${percent}%</span>`;
                } else {
                    priceContainer.innerHTML = `<span class="text-[32px] font-extrabold text-[#590807]">${formatCurrency(matchedVariant.price)}</span>`;
                }

                if(stockElement) stockElement.innerText = `Kho: ${matchedVariant.stock}`;
                if (matchedVariant.stock > 0) {
                    addToCartBtn.disabled = false;
                    addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    addToCartBtn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg> Thêm vào giỏ hàng`;
                } else {
                    addToCartBtn.disabled = true;
                    addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    addToCartBtn.innerText = "Tạm hết hàng";
                }
                if (matchedVariant.image_url) changeImage(null, matchedVariant.image_url);
            } else {
                priceContainer.innerHTML = `<span class="text-[32px] font-extrabold text-[#590807]">Liên hệ</span>`;
                if(stockElement) stockElement.innerText = "Kho: --";
                addToCartBtn.disabled = true;
                addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                addToCartBtn.innerText = "Sản phẩm tạm hết hàng";
            }
        }

        document.querySelectorAll('input[name="color_id"]').forEach(input => {
            input.addEventListener('change', (e) => { selectedColor = e.target.value; updateProductInfo(); });
        });
        document.querySelectorAll('input[name="size_id"]').forEach(input => {
            input.addEventListener('change', (e) => { selectedSize = e.target.value; updateProductInfo(); });
        });

        // 2. Logic Load More Related Products 
        const loadMoreBtn = document.getElementById('load-more-related-btn');
        const relatedGrid = document.getElementById('related-products-grid');
        let relatedSkip = 4; 
        const currentCatId = {{ $product->category_id }};
        const currentProdId = {{ $product->product_id }};

        if(loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const btn = this;
                btn.innerText = "Đang tải...";
                btn.disabled = true;

                fetch(`{{ route('api.related_products') }}?category_id=${currentCatId}&product_id=${currentProdId}&skip=${relatedSkip}`)
                .then(response => response.json())
                .then(data => {
                    if(data.products.length > 0) {
                        data.products.forEach(prod => {
                            // Logic hiển thị giá
                            let priceHtml = '';
                            if (prod.discount > 0) {
                                priceHtml = `
                                    <p class="text-lg font-bold text-red-800 font-open-sans">
                                        ${prod.price}
                                    </p>
                                    <span class="inline-flex items-center justify-center rounded-lg bg-red-50 px-2.5 py-0.5 text-xs font-bold text-red-500">
                                        -${prod.discount}%
                                    </span>
                                    </div>
                                    <p class="text-sm text-gray-400 line-through italic mt-1">
                                        ${prod.originalPrice}
                                    </p>
                                `;
                            } else {
                                priceHtml = `
                                    <p class="text-lg font-bold text-red-800 font-open-sans">
                                        ${prod.price}
                                    </p>
                                    </div>
                                `;
                            }

                            const html = `
                            <div class="group flex flex-col rounded-[20px] border border-gray-200 bg-white p-4 shadow-sm transition-all hover:shadow-lg hover:-translate-y-1">
                                <div class="relative w-full aspect-square overflow-hidden rounded-[16px] bg-gray-100 mb-4">
                                    <a href="${prod.detail_url}">
                                        <img src="${prod.image}" class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-105" onerror="this.src='https://via.placeholder.com/300'">
                                    </a>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 font-['Montserrat'] truncate">
                                        <a href="${prod.detail_url}">${prod.name}</a>
                                    </h3>
                                    <div class="flex items-center mt-2 space-x-3">
                                        ${priceHtml}
                                </div>
                            </div>`;
                            relatedGrid.insertAdjacentHTML('beforeend', html);
                        });
                        relatedSkip += 4;
                        btn.innerText = "Xem thêm";
                        btn.disabled = false;
                    } 
                    
                    if(!data.hasMore || data.products.length === 0) {
                        btn.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.error(err);
                    btn.innerText = "Lỗi tải trang";
                });
            });
        }

        // Misc Logic
        const input = document.getElementById('quantity-input');
        const decreaseBtn = document.getElementById('decrease-btn');
        const increaseBtn = document.getElementById('increase-btn');
        if(decreaseBtn && input) decreaseBtn.addEventListener('click', () => { let val = parseInt(input.value)||0; if(val>1) input.value=val-1; });
        if(increaseBtn && input) increaseBtn.addEventListener('click', () => { let val = parseInt(input.value)||0; input.value=val+1; });

        window.addEventListener('click', function(e) {
            const menu = document.getElementById('sort-dropdown-menu');
            const button = document.querySelector('button[onclick="toggleSortDropdown()"]'); 
            if (menu && button && !menu.contains(e.target) && !button.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        function setupScrollSlider(containerId, prevBtnId, nextBtnId) {
            const container = document.getElementById(containerId);
            const prev = document.getElementById(prevBtnId);
            const next = document.getElementById(nextBtnId);
            if (container && prev && next) {
                const checkScroll = () => {
                    if (container.scrollLeft > 0) prev.classList.remove('hidden'); else prev.classList.add('hidden');
                    if (container.scrollLeft + container.clientWidth < container.scrollWidth - 1) next.classList.remove('hidden'); else next.classList.add('hidden');
                };
                next.addEventListener('click', () => container.scrollBy({ left: 150, behavior: 'smooth' }));
                prev.addEventListener('click', () => container.scrollBy({ left: -150, behavior: 'smooth' }));
                container.addEventListener('scroll', checkScroll);
                setTimeout(checkScroll, 100);
            }
        }
        setupScrollSlider('color-scroll-container', 'color-prev-btn', 'color-next-btn');
        setupScrollSlider('size-scroll-container', 'size-prev-btn', 'size-next-btn');

        updateProductInfo();
    });
    
    const track = document.getElementById('thumbnail-track');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    if (track && track.children.length > 3) {
        const itemsToShow = 3; let currentIndex = 0; const totalItems = track.children.length;
        prevBtn.classList.remove('hidden'); nextBtn.classList.remove('hidden');
        function updateSlider() {
            const translateValue = -(currentIndex * (100 / itemsToShow)); 
            track.style.transform = `translateX(calc(${translateValue}% - ${currentIndex * 1.33}rem))`; 
        }
        nextBtn.addEventListener('click', () => { if (currentIndex < totalItems - itemsToShow) { currentIndex++; updateSlider(); } });
        prevBtn.addEventListener('click', () => { if (currentIndex > 0) { currentIndex--; updateSlider(); } });
    } else if (track) {
        track.classList.add('justify-start');
    }
</script>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

@endsection