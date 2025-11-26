@extends('user.layouts.user_layout')

@section('title', 'GRYND - Thanh toán')

@section('content')

{{-- DỮ LIỆU GIẢ (MOCK DATA) ĐƯỢC CHÈN TRỰC TIẾP VÀÀO BLADE --}}
<?php
// Dữ liệu giỏ hàng - ĐÃ SỬA THÀNH $cart_items và keys theo CSDL
$cart_items = [
    // Sản phẩm 1: Hàng hóa (Product) -> order_detail.variant_id
    [
        'variant_id' => 12, // Thêm ID sản phẩm biến thể
        'name' => 'Tạ tập gym', 
        'type' => 'product', 
        'size' => '2kg', 
        'color' => 'Light Green', 
        'final_price' => 110000, // Giá cuối cùng sau khi giảm giá riêng của item
        'unit_price' => 110000, // Giá gốc (cart_item.unit_price)
        'discount_value' => 0, // Giá trị giảm giá riêng của item này
        'quantity' => 1, // cart_item.quantity
        'image_url' => 'https://via.placeholder.com/80x80/90EE90/FFFFFF?text=TA+GYM'
    ],
    // Sản phẩm 2: Hàng hóa (Product) (Có giảm giá riêng)
    [
        'variant_id' => 25,
        'name' => 'Tạ Kettlebell', 
        'type' => 'product',
        'size' => '5kg', 
        'color' => 'Pink', 
        'final_price' => 149000, 
        'unit_price' => 170000, 
        'discount_value' => 21000, 
        'quantity' => 2, 
        'image_url' => 'https://via.placeholder.com/80x80/90B0EE/FFFFFF?text=BELL'
    ],
    // Sản phẩm 3: Gói tập (Membership) -> package_registration.package_id
    [
        'package_id' => 5, // Thêm ID gói tập
        'name' => 'Gói Tập Gym VIP', 
        'type' => 'membership', 
        'duration' => '3 tháng', 
        'final_price' => 2000000, 
        'unit_price' => 2500000, 
        'discount_value' => 500000, 
        'quantity' => 1, 
        'image_url' => 'https://via.placeholder.com/80x80/FFA500/FFFFFF?text=VIP+GYM'
    ],
    // Sản phẩm 4: Hàng hóa (Product) (Có giảm giá riêng)
    [
        'variant_id' => 38,
        'name' => 'Quần tập dài', 
        'type' => 'product',
        'size' => 'L', 
        'color' => 'White', 
        'final_price' => 206000, 
        'unit_price' => 250000, 
        'discount_value' => 44000, 
        'quantity' => 1, 
        'image_url' => 'https://via.placeholder.com/80x80/374151/FFFFFF?text=PANTS'
    ]
];

// DỮ LIỆU MOCK CHO MÃ GIẢM GIÁ - ĐÃ SỬA THÀNH $promotions_data
$promotions_data = [
    'SALE30' => [
        'discount_value' => 30, // promotion.discount_value
        'is_percent' => true, // promotion.is_percent
        'min_order_amount' => 500000, // promotion.min_order_amount
        'max_discount' => 50000, // promotion.max_discount
        'title' => 'Sale cuối năm 30%', // promotion.title
        'description' => 'Giảm 30% tối đa 50K cho đơn từ 500K' // promotion.description
    ],
    'FREESHIP' => [
        'discount_value' => 30000, 
        'is_percent' => false, 
        'min_order_amount' => 0, 
        'max_discount' => 30000, 
        'title' => 'Miễn phí vận chuyển',
        'description' => 'Miễn phí vận chuyển 30K'
    ],
    'TEST10K' => [
        'discount_value' => 10000, 
        'is_percent' => false, 
        'min_order_amount' => 100000, 
        'max_discount' => 10000, 
        'title' => 'Giảm thẳng 10K',
        'description' => 'Giảm thẳng 10K cho đơn từ 100K'
    ],
    'FAIL200' => [
        'discount_value' => 20, 
        'is_percent' => true, 
        'min_order_amount' => 2000000, 
        'max_discount' => 100000, 
        'title' => 'Sale lớn 2M',
        'description' => 'Giảm 20% tối đa 100K (Đơn hàng cần 2M)'
    ], 
];

// Hàm tính toán tổng tiền - ĐÃ ĐỔI TÊN HÀM VÀ BIẾN
function calculateOrderTotals($cart_items, $promotion_code = null) {
    global $promotions_data;

    // Tính Tổng phụ (dựa trên giá gốc 'unit_price')
    $subtotal_amount = array_sum(array_map(fn($item) => $item['unit_price'] * $item['quantity'], $cart_items));
    // Tính Tổng giảm giá riêng của từng item (dựa trên 'discount_value' của item)
    $item_discount_total = array_sum(array_map(fn($item) => $item['discount_value'] * $item['quantity'], $cart_items));
    
    $promotion_discount = 0; // Giảm giá từ mã khuyến mãi (orders.promotion_code)
    $shipping_fee = 30000;
    $promo_message = '';

    if ($promotion_code && isset($promotions_data[$promotion_code])) {
        $promo = $promotions_data[$promotion_code];
        
        // Kiểm tra điều kiện đơn hàng tối thiểu
        if ($subtotal_amount >= $promo['min_order_amount']) {
            if ($promo['is_percent']) {
                $calculated_discount = $subtotal_amount * ($promo['discount_value'] / 100);
                $promotion_discount = min($calculated_discount, $promo['max_discount']);
                $promo_message = "Áp dụng thành công mã {$promotion_code} ({$promo['title']}): Giảm tối đa " . number_format($promo['max_discount'], 0, ',', '.') . " VNĐ."; 
            } else {
                $promotion_discount = $promo['discount_value'];
                $promo_message = "Áp dụng thành công mã {$promotion_code} ({$promo['title']}): Giảm " . number_format($promo['discount_value'], 0, ',', '.') . " VNĐ."; 
            }
        } else {
            $promo_message = "Mã {$promotion_code} chỉ áp dụng cho đơn hàng từ " . number_format($promo['min_order_amount'], 0, ',', '.') . " VNĐ. (Nội dung: {$promo['description']})";
        }
    } else if ($promotion_code) {
        $promo_message = "Mã giảm giá \"{$promotion_code}\" không hợp lệ.";
    }

    $total_discount = $item_discount_total + $promotion_discount;
    // total_amount = subtotal_amount (giá gốc) - total_discount + shipping_fee
    $total_amount = $subtotal_amount - $total_discount + $shipping_fee; // orders.total_amount

    return [
        'subtotal_amount' => $subtotal_amount, 
        'item_discount_total' => $item_discount_total, 
        'promotion_discount' => $promotion_discount, 
        'total_discount' => $total_discount, 
        'shipping_fee' => $shipping_fee, 
        'total_amount' => $total_amount, 
        'promo_message' => $promo_message,
    ];
}

// Tính toán lần đầu khi tải trang (không có mã) - ĐÃ ĐỔI TÊN BIẾN
$initial_totals = calculateOrderTotals($cart_items);
$subtotal_amount = $initial_totals['subtotal_amount'];
$total_discount = $initial_totals['total_discount'];
$shipping_fee = $initial_totals['shipping_fee'];
$total_amount = $initial_totals['total_amount'];

// Chuẩn bị dữ liệu cho JavaScript - ĐÃ ĐỔI TÊN BIẾN
$items_json = json_encode($cart_items);
$promotions_json = json_encode($promotions_data);
?>

<div class="container mx-auto px-4 py-8 font-['Roboto']">

    <nav class="flex mb-10" aria-label="Breadcrumb">
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
                    <a href="{{ route('product') }}" class="ml-1 text-sm font-normal text-gray-700 hover:text-blue-600">Cửa hàng</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-bold text-gray-900 md:ml-2">Thanh toán</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

        <main class="lg:col-span-3 bg-white p-6 rounded-lg shadow-xl border border-gray-100">
            <h1 class="text-3xl font-bold text-gray-900 mb-8 font-['Montserrat']">Đơn hàng của tôi</h1>
            
            {{-- THÊM ID VÀO CONTAINER DANH SÁCH SẢN PHẨM --}}
            <div class="space-y-4" id="cart_item_list">
                
                {{-- Dùng Blade loop để render danh sách sản phẩm - ĐÃ DÙNG BIẾN MỚI $cart_items --}}
                @foreach ($cart_items as $item)
                <div class="flex items-start border-b border-gray-200 pb-4 last:border-b-0 last:pb-0">
                    <div class="w-20 h-20 flex-shrink-0 mr-4">
                        <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover rounded-lg">
                    </div>
                    
                    {{-- KHỐI THÔNG TIN SẢN PHẨM --}}
                    <div class="flex-1 flex flex-col justify-between"> 
                        
                        {{-- HÀNG 1: Tên sản phẩm --}}
                        <div>
                            <p class="font-bold text-gray-800">{{ $item['name'] }}</p>
                        </div>
                        
                        {{-- HÀNG GIỮA: Size/Color HOẶC Thời hạn (Dùng các keys đã đổi tên) --}}
                        <div class="flex flex-col items-start text-sm text-gray-500">
                            @if (isset($item['type']) && $item['type'] === 'membership')
                                <p>Thời hạn: {{ $item['duration'] ?? 'N/A' }}</p>
                            @else
                                <p>Size: {{ $item['size'] ?? 'N/A' }}</p>
                                <p>Color: {{ $item['color'] ?? 'N/A' }}</p>
                            @endif
                        </div>

                        {{-- KHOẢNG TRỐNG (Dòng trắng) --}}
                        <div class="h-4"></div>

                        {{-- HÀNG 3: Giá sản phẩm (Giá hiện tại và Giá gốc gạch ngang) --}}
                        <div class="flex items-end">
                            {{-- 1. Giá ĐÃ GIẢM (final_price) --}}
                            <p class="text-xl font-bold text-gray-900">
                                {{ number_format($item['final_price'], 0, ',', '.') }} VNĐ
                            </p>
                            
                            {{-- 2. Giá GỐC (unit_price) --}}
                            @if (isset($item['unit_price']) && $item['unit_price'] > $item['final_price'])
                                <p class="text-sm text-gray-400 line-through ml-2 mb-0.5">
                                    {{ number_format($item['unit_price'], 0, ',', '.') }} VNĐ
                                </p>
                            @endif
                        </div>
                        
                    </div>
                    {{-- KHỐI QUẢN LÝ TƯƠNG TÁC (Nút xóa và Số lượng) --}}
                    <div class="flex flex-col items-end justify-between h-20 text-gray-500">
                        
                        {{-- NÚT XÓA --}}
                        <button class="btn-delete-item text-red-500 hover:text-red-700 w-6 h-6 flex items-center justify-center">
                            {{-- Icon thùng rác --}}
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6h-7l-1-2H7C6.4 4 6 4.4 6 5v1H4v2h1v12c0 1.1 0.9 2 2 2h10c1.1 0 2-0.9 2-2V8h1V6h-2zM9 18H8v-6h1v6zm4 0h-2v-6h2v6zm4 0h-2v-6h2v6z"/></svg>
                        </button>
                        
                        {{-- KHỐI SỐ LƯỢNG HOẶC THÔNG BÁO --}}
                        @if (isset($item['type']) && $item['type'] === 'membership')
                            
                        @else
                            {{-- HIỂN THỊ HÀNG HÓA --}}
                            <div class="flex items-center border border-gray-300 rounded-full px-1 py-0.5 mt-auto">
                                <button class="btn-qty-minus w-7 h-7 flex items-center justify-center text-xl text-gray-600 hover:text-gray-900">-</button>
                                <span class="item-quantity text-base font-semibold px-2">{{ $item['quantity'] }}</span>
                                <button class="btn-qty-plus w-7 h-7 flex items-center justify-center text-xl text-gray-600 hover:text-gray-900">+</button>
                            </div>
                        @endif
                        
                    </div>
                </div>
                @endforeach
                
            </div>
        </main>

        <aside class="lg:col-span-2 bg-white p-6 rounded-lg shadow-xl h-fit sticky top-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Thông tin thanh toán</h2>

            {{-- Summary Details --}}
            <div class="space-y-3 text-gray-700">
                
                {{-- 1. TỔNG PHỤ (SUBTOTAL) - Dùng biến mới $subtotal_amount --}}
                <div class="flex justify-between items-center text-base">
                    <span>Tổng phụ</span>
                    <span id="subtotal_value" class="font-semibold">{{ number_format($subtotal_amount, 0, ',', '.') }} VNĐ</span>
                </div>
                
                {{-- 2. GIẢM GIÁ (TOTAL DISCOUNT) - Dùng biến mới $total_discount --}}
                <div class="flex justify-between items-center text-base">
                    <span>Giảm giá</span>
                    {{-- Thẻ này sẽ được cập nhật bởi JS --}}
                    @if ($total_discount > 0)
                        <span id="discount_value" class="text-red-600 font-semibold">-{{ number_format($total_discount, 0, ',', '.') }} VNĐ</span>
                    @else
                        <span id="discount_value" class="font-semibold">0 VNĐ</span>
                    @endif
                </div>
                
                {{-- 3. PHÍ VẬN CHUYỂN (SHIPPING FEE) --}}
                <div class="flex justify-between items-center text-base border-b border-gray-200 pb-3">
                    <span>Phí vận chuyển</span>
                    <span id="shipping_fee_value" class="font-semibold">{{ number_format($shipping_fee, 0, ',', '.') }} VNĐ</span>
                </div>
                
                {{-- 4. TỔNG CỘNG (TOTAL) - Dùng biến mới $total_amount --}}
                <div class="flex justify-between items-center text-xl pt-3">
                    <span class="font-bold">Tổng cộng</span>
                    <span id="total_value" class="font-bold text-gray-900">{{ number_format($total_amount, 0, ',', '.') }} VNĐ</span>
                </div>
                
            </div>
            
            <hr class="my-6"> 

            {{-- ---------------------------------------------------- --}}
            {{-- KHỐI QUẢN LÝ MÃ GIẢM GIÁ --}}
            {{-- ---------------------------------------------------- --}}
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3">Mã giảm giá</p>

                {{-- TRẠNG THÁI 1: Ô NHẬP MÃ --}}
                <div id="coupon_input_container" class="flex space-x-2 transition-opacity duration-300">
                    <input type="text" id="coupon_input" placeholder="Nhập mã giảm giá" class="flex-1 py-2.5 px-4 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 uppercase" autocomplete="off">
                    <button id="apply_coupon_btn" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors text-sm">Áp dụng</button>
                </div>
                
                {{-- TRẠNG THÁI 2: TICKET MINI ĐÃ ÁP DỤNG (Dùng cho JS hiển thị) --}}
                <div id="applied_coupon_tag" class="hidden mt-3">
                    {{-- Mã giảm giá sẽ được chèn vào đây bằng JS --}}
                </div>
            </div>

            {{-- KHỐI HIỂN THỊ THÔNG BÁO MÃ GIẢM GIÁ --}}
            <p id="promo_message" class="text-xs mt-2 text-red-500 hidden"></p>
            
            {{-- Checkout Button --}}
            <button class="mt-6 w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white text-lg font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                Tiến hành thanh toán
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </aside>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // Lấy dữ liệu từ PHP đã được encode sang JSON - ĐÃ ĐỔI TÊN BIẾN
        let CART_ITEMS = JSON.parse('{!! $items_json !!}');
        const PROMOTIONS_DATA = JSON.parse('{!! $promotions_json !!}');
        const SHIPPING_FEE = parseFloat({{ $shipping_fee }});
        
        // DOM Elements (Giữ nguyên tên)
        const couponInput = document.getElementById('coupon_input');
        const applyCouponBtn = document.getElementById('apply_coupon_btn');
        const promoMessage = document.getElementById('promo_message');
        const appliedCouponTag = document.getElementById('applied_coupon_tag');
        const couponInputContainer = document.getElementById('coupon_input_container');
        const cartItemListContainer = document.getElementById('cart_item_list'); 
        const mainContainer = document.querySelector('main'); 
        
        // Biến lưu trữ mã giảm giá đang được áp dụng - ĐÃ ĐỔI TÊN BIẾN
        let currentPromotionCode = ''; 

        // --- HÀM TẠO GIAO DIỆN TICKET MINI --- 
        function renderAppliedCoupon(code) {
            const displayCode = code.toUpperCase();
            const colorBase = 'bg-blue-100'; 
            const textColor = 'text-blue-800'; 
            const buttonClass = 'text-gray-500 hover:text-gray-700'; 

            appliedCouponTag.innerHTML = `
                <div class="inline-flex items-center space-x-2 py-1.5 px-3 rounded-lg ${colorBase} border border-blue-300">
                    
                    <svg class="w-5 h-5 ${textColor}" fill="currentColor" viewBox="0 0 24 24"><path d="M22 10V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v4c1.1 0 2 .9 2 2s-.9 2-2 2v4c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-4c-1.1 0-2-.9-2-2s.9-2 2-2zM6 17v-2h12v2H6zm0-4v-2h12v2H6z"/></svg>
                    
                    <span class="font-bold text-sm text-gray-900">${displayCode}</span>
                    
                    <button id="cancel_coupon_btn" class="w-5 h-5 flex items-center justify-center ${buttonClass}">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `;
            appliedCouponTag.classList.remove('hidden');

            document.getElementById('cancel_coupon_btn').addEventListener('click', cancelCoupon);
        }

        // --- CÁC HÀM XỬ LÝ TỔNG TIỀN VÀ GIẢM GIÁ ---

        function formatCurrency(amount) {
            return Math.round(amount).toLocaleString('vi-VN') + ' VNĐ'; 
        }

        // ĐÃ ĐỔI TÊN BIẾN VÀ KEYS TRONG HÀM NÀY
        function calculateTotalsJS(currentItems, promotionCode) {
            let subtotalAmount = 0; // Tổng tiền hàng (Giá gốc * Số lượng)
            let itemDiscountTotal = 0;

            currentItems.forEach(item => {
                // SỬ DỤNG unit_price VÀ quantity
                if(item && item.unit_price && item.quantity) {
                    subtotalAmount += item.unit_price * item.quantity;
                    // SỬ DỤNG discount_value
                    itemDiscountTotal += (item.discount_value || 0) * item.quantity;
                }
            });

            let promotionDiscount = 0;
            let message = '';
            
            let tempPromotionCode = '';

            const promo = PROMOTIONS_DATA[promotionCode];

            if (promo) {
                // SỬ DỤNG subtotalAmount để kiểm tra điều kiện min_order_amount
                if (subtotalAmount >= promo.min_order_amount) {
                    let calculatedDiscount = 0;
                    if (promo.is_percent) {
                        calculatedDiscount = subtotalAmount * (promo.discount_value / 100);
                        promotionDiscount = Math.min(calculatedDiscount, promo.max_discount);
                        message = `Áp dụng thành công mã ${promotionCode}. (${promo.title || 'Giảm giá thành công'})`;
                    } else {
                        promotionDiscount = promo.discount_value;
                        message = `Áp dụng thành công mã ${promotionCode}. (${promo.title || 'Giảm giá thành công'})`;
                    }
                    tempPromotionCode = promotionCode;
                } else {
                    message = `Mã "${promotionCode}" chỉ áp dụng cho đơn hàng từ ${formatCurrency(promo.min_order_amount)}. (Nội dung: ${promo.description || 'Kiểm tra điều kiện'})`;
                    promotionDiscount = 0;
                    tempPromotionCode = currentPromotionCode; // Giữ lại mã cũ nếu không thỏa mãn điều kiện
                }
            } else if (promotionCode) {
                message = `Mã giảm giá "${promotionCode}" không hợp lệ.`;
                tempPromotionCode = ''; 
            } else {
                promotionDiscount = 0;
                tempPromotionCode = ''; 
            }
            
            currentPromotionCode = tempPromotionCode; // Cập nhật biến toàn cục

            const totalDiscount = itemDiscountTotal + promotionDiscount;
            // total_amount = subtotal_amount - total_discount + SHIPPING_FEE
            const totalAmount = subtotalAmount - totalDiscount + SHIPPING_FEE;

            return { subtotalAmount, totalDiscount, totalAmount, message, itemDiscountTotal, promotionDiscount };
        }
        
        // ĐÃ ĐỔI TÊN BIẾN KHI CẬP NHẬT GIAO DIỆN
        function updateSummary(totals) {
            document.getElementById('subtotal_value').textContent = formatCurrency(totals.subtotalAmount);
            document.getElementById('discount_value').textContent = (totals.totalDiscount > 0 ? '-' : '') + formatCurrency(totals.totalDiscount);
            document.getElementById('total_value').textContent = formatCurrency(totals.totalAmount);
            
            const discountSpan = document.getElementById('discount_value');
            if (totals.totalDiscount > 0) {
                 discountSpan.classList.add('text-red-600');
            } else {
                 discountSpan.classList.remove('text-red-600');
            }
            
            // Cập nhật giao diện mã giảm giá
            if (currentPromotionCode) {
                couponInputContainer.classList.add('hidden');
                renderAppliedCoupon(currentPromotionCode);
                
                promoMessage.textContent = totals.message;
                promoMessage.classList.add('text-green-600');
                promoMessage.classList.remove('text-red-500', 'hidden');
            } else {
                appliedCouponTag.innerHTML = '';
                appliedCouponTag.classList.add('hidden');
                couponInputContainer.classList.remove('hidden');
                couponInput.value = '';

                // Hiển thị thông báo lỗi/hủy nếu có
                if (totals.message) {
                    promoMessage.textContent = totals.message;
                    promoMessage.classList.remove('hidden');
                    if (totals.message.includes('thành công') || totals.message.includes('đã được hủy bỏ') || totals.message.includes('Mã chỉ áp dụng cho đơn hàng từ')) {
                        promoMessage.classList.add('text-gray-500');
                        promoMessage.classList.remove('text-red-500', 'text-green-600');
                    } else {
                        promoMessage.classList.add('text-red-500');
                        promoMessage.classList.remove('text-green-600');
                    }
                } else {
                    promoMessage.classList.add('hidden');
                }
            }
        }

        // ĐÃ ĐỔI TÊN BIẾN
        function applyCoupon() {
            const code = couponInput.value.toUpperCase().trim();
            const totals = calculateTotalsJS(CART_ITEMS, code);
            updateSummary(totals);
        }

        // ĐÃ ĐỔI TÊN BIẾN
        function cancelCoupon() {
            const oldCode = currentPromotionCode;
            currentPromotionCode = ''; 
            const totals = calculateTotalsJS(CART_ITEMS, '');
            totals.message = `Mã ${oldCode} đã được hủy bỏ.`;
            updateSummary(totals);
        }
        
        // --- HÀM XỬ LÝ SỐ LƯỢNG VÀ XÓA SẢN PHẨM --- 
        
        function getItemIndex(element) {
            const itemContainer = element.closest('.flex.items-start'); 
            if (itemContainer === null) return -1;
            
            const allItemContainers = Array.from(document.querySelectorAll('#cart_item_list > .flex.items-start'));
            
            return allItemContainers.findIndex(el => el === itemContainer);
        }

        function updateQuantity(button, delta) {
            const itemIndex = getItemIndex(button);
            if(itemIndex === -1 || itemIndex >= CART_ITEMS.length) return; 
            
            if (CART_ITEMS[itemIndex].type === 'membership') return;

            const itemContainer = button.closest('.flex.items-start');
            const quantitySpan = itemContainer.querySelector('.item-quantity');
            
            if (!quantitySpan) return; 

            let currentQty = parseInt(quantitySpan.textContent);
            let newQty = currentQty + delta;
            
            if (newQty < 1) newQty = 1;

            if (newQty !== currentQty) {
                // Cập nhật DOM
                quantitySpan.textContent = newQty;
                
                // CẬP NHẬT DỮ LIỆU GỐC TRONG MẢNG CART_ITEMS
                CART_ITEMS[itemIndex].quantity = newQty; 
                
                const totals = calculateTotalsJS(CART_ITEMS, currentPromotionCode);
                updateSummary(totals);
            }
        }

        function deleteItem(button) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                
                const itemToDeleteIndex = getItemIndex(button);
                
                if(itemToDeleteIndex === -1 || itemToDeleteIndex >= CART_ITEMS.length) return; 
                
                const itemContainer = button.closest('.flex.items-start'); 
                
                // XÓA DỮ LIỆU KHỎI MẢNG CART_ITEMS
                CART_ITEMS.splice(itemToDeleteIndex, 1);
                
                // XÓA DOM
                itemContainer.remove();
                
                const totals = calculateTotalsJS(CART_ITEMS, currentPromotionCode);
                updateSummary(totals);

                if (CART_ITEMS.length === 0) {
                    cartItemListContainer.innerHTML = '<p class="text-center py-8 text-gray-500">Giỏ hàng của bạn đang trống.</p>';
                }
            }
        }
        
        // --- EVENT DELEGATION ---
        mainContainer.addEventListener('click', (e) => {
            const target = e.target.closest('button');
            if (!target) return;

            if (target.classList.contains('btn-qty-plus') || target.classList.contains('btn-qty-minus')) {
                const delta = target.classList.contains('btn-qty-plus') ? 1 : -1;
                updateQuantity(target, delta);
            } else if (target.classList.contains('btn-delete-item')) {
                deleteItem(target);
            }
        });
        
        applyCouponBtn.addEventListener('click', applyCoupon);
        
        couponInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); 
                applyCoupon();
            }
        });
        
        updateSummary(calculateTotalsJS(CART_ITEMS, currentPromotionCode));
    });
</script>

@endsection
