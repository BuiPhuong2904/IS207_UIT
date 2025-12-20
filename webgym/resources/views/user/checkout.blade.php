@extends('user.layouts.user_layout')

@section('title', 'GRYND - Thanh toán')

@section('content')

<div class="container mx-auto px-4 py-8 font-['Roboto']">

    {{-- BREADCRUMB --}}
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

        {{-- DANH SÁCH SẢN PHẨM --}}
        <main class="lg:col-span-3 bg-white p-6 rounded-lg shadow-xl border border-gray-100">
            <h1 class="text-3xl font-bold text-gray-900 mb-8 font-['Montserrat']">Đơn hàng của tôi</h1>
            
            <div class="space-y-4" id="cart_item_list">
                @auth
                    @forelse($cart_items ?? [] as $item)
                    <div class="flex items-start border-b border-gray-200 pb-4 last:border-b-0 last:pb-0" data-variant-id="{{ $item['variant_id'] }}">
                        <div class="w-20 h-20 flex-shrink-0 mr-4">
                            <img src="{{ $item['image_url'] ?? 'https://via.placeholder.com/80' }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover rounded-lg">
                        </div>
                        
                        <div class="flex-1 flex flex-col justify-between"> 
                            <div>
                                <p class="font-bold text-gray-800">{{ $item['name'] }}</p>
                            </div>
                            
                            <div class="flex flex-col items-start text-sm text-gray-500">
                                @if( ($item['type'] ?? '') === 'membership' )
                                    <p>Thời hạn: <strong>{{ $item['duration'] ?? 'N/A' }}</strong></p>
                                @else
                                    <p>Size: {{ $item['size'] ?? 'N/A' }} | Màu: {{ $item['color'] ?? 'N/A' }}</p>
                                @endif
                            </div>

                            <div class="h-4"></div>

                            <div class="flex items-end">
                                <p class="text-xl font-bold text-gray-900">
                                    {{ number_format($item['final_price'], 0, ',', '.') }} VNĐ
                                </p>
                                @if( ($item['unit_price'] ?? 0) > ($item['final_price'] ?? 0) )
                                    <p class="text-sm text-gray-400 line-through ml-2 mb-0.5">
                                        {{ number_format($item['unit_price'], 0, ',', '.') }} VNĐ
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col items-end justify-between h-20 text-gray-500">
                            {{-- Nút xóa item --}}
                            <button type="button" class="btn-delete-item text-red-500 hover:text-red-700 w-6 h-6 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6h-7l-1-2H7C6.4 4 6 4.4 6 5v1H4v2h1v12c0 1.1 0.9 2 2 2h10c1.1 0 2-0.9 2-2V8h1V6h-2zM9 18H8v-6h1v6zm4 0h-2v-6h2v6zm4 0h-2v-6h2v6z"/></svg>
                            </button>
                            
                            {{-- Nút tăng giảm số lượng (chỉ cho sản phẩm) --}}
                            @if( ($item['type'] ?? '') !== 'membership' )
                            <div class="flex items-center border border-gray-300 rounded-full px-1 py-0.5 mt-auto">
                                <button type="button" class="btn-qty-minus w-7 h-7 flex items-center justify-center text-xl text-gray-600 hover:text-gray-900">-</button>
                                <span class="item-quantity text-base font-semibold px-2">{{ $item['quantity'] }}</span>
                                <button type="button" class="btn-qty-plus w-7 h-7 flex items-center justify-center text-xl text-gray-600 hover:text-gray-900">+</button>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                        <p class="text-center py-8 text-gray-500">Giỏ hàng trống</p>
                    @endforelse
                @else
                    <p class="text-center py-8 text-gray-500">Vui lòng đăng nhập để xem giỏ hàng</p>
                @endauth
            </div>
        </main>

        {{-- CỘT THANH TOÁN --}}
        <aside class="lg:col-span-2 bg-white p-6 rounded-lg shadow-xl h-fit sticky top-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Thông tin thanh toán</h2>

            <div class="space-y-3 text-gray-700">
                <div class="flex justify-between items-center text-base">
                    <span>Tổng phụ</span>
                    <span id="subtotal_value" class="font-semibold">0 VNĐ</span>
                </div>
                
                <div class="flex justify-between items-center text-base">
                    <span>Giảm giá</span>
                    <span id="discount_value" class="font-semibold">0 VNĐ</span>
                </div>
                
                <div class="flex justify-between items-center text-base border-b border-gray-200 pb-3">
                    <span>Phí vận chuyển</span>
                    <span id="shipping_fee_value" class="font-semibold">30.000 VNĐ</span>
                </div>
                
                <div class="flex justify-between items-center text-xl pt-3">
                    <span class="font-bold">Tổng cộng</span>
                    <span id="total_value" class="font-bold text-blue-600">0 VNĐ</span>
                </div>
            </div>
            
            <hr class="my-6">

            {{-- KHU VỰC NHẬP MÃ GIẢM GIÁ --}}
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3">Mã giảm giá</p>

                {{-- Input: Ẩn đi nếu đã áp dụng mã thành công --}}
                <div id="coupon_input_container" class="flex space-x-2 transition-opacity duration-300 {{ ($applied_promo ?? false) ? 'hidden' : '' }}">
                    <input type="text" id="coupon_input" 
                           value="{{ ($applied_promo ?? false) ? '' : ($promotion_code ?? '') }}"
                           placeholder="Nhập mã giảm giá" 
                           class="flex-1 py-2.5 px-4 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 uppercase" 
                           autocomplete="off" maxlength="20">
                    <button type="button" id="apply_coupon_btn" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors text-sm">Áp dụng</button>
                </div>
                
                {{-- Tag hiển thị mã đã áp dụng --}}
                <div id="applied_coupon_tag" class="{{ ($applied_promo ?? false) ? '' : 'hidden' }} mt-3">
                    @if($applied_promo ?? false)
                        <div class="inline-flex items-center space-x-2 py-1.5 px-3 rounded-lg bg-blue-100 border border-blue-300">
                            <svg class="w-5 h-5 text-blue-800" fill="currentColor" viewBox="0 0 24 24"><path d="M22 10V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v4c1.1 0 2 .9 2 2s-.9 2-2 2v4c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-4c-1.1 0-2-.9-2-2s.9-2 2-2zM6 17v-2h12v2H6zm0-4v-2h12v2H6z"/></svg>
                            <span class="font-bold text-sm text-gray-900">{{ strtoupper($promotion_code ?? '') }}</span>
                            <button type="button" id="cancel_coupon_btn" class="w-5 h-5 flex items-center justify-center text-gray-500 hover:text-red-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Hiển thị thông báo từ Server --}}
            <p id="promo_message" class="text-xs mt-2 {{ !empty($promo_message) ? (($applied_promo ?? false) ? 'text-green-600' : 'text-red-500') : 'hidden' }}">
                {{ $promo_message ?? '' }}
            </p>
            
            {{-- FORM SUBMIT CHÍNH --}}
            <form id="proceed-to-checkout-form" method="POST" action="{{ route('checkout-detail') }}" class="mt-6">
                @csrf
                <input type="hidden" name="cart_items" id="cart_items_input">
                <input type="hidden" name="promotion_code" id="promotion_code_input" value="{{ $promotion_code ?? '' }}">
                <input type="hidden" name="total_amount" id="total_amount_input">

                {{-- Thông tin user ẩn --}}
                <input type="hidden" name="full_name" value="{{ Auth::user()->full_name ?? '' }}">
                <input type="hidden" name="email" value="{{ Auth::user()->email ?? '' }}">
                <input type="hidden" name="phone_number" value="{{ Auth::user()->phone ?? '' }}">
                <input type="hidden" name="address" value="{{ Auth::user()->address ?? '' }}">

                <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white text-lg font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-lg">
                    Tiến hành thanh toán
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>
        </aside>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // 1. NHẬN DỮ LIỆU TỪ CONTROLLER
        let rawItems = @json($cart_items ?? []);
        const userId = {{ Auth::id() ?? 0 }};
        const csrfToken = '{{ csrf_token() }}';
        
        // Các biến xử lý Coupon từ Server
        let currentCouponCode = @json($promotion_code ?? '');
        let serverDiscount    = @json($promotion_discount ?? 0); 
        let isServerApplied   = @json(isset($applied_promo) && $applied_promo ? true : false);

        const SHIPPING_FEE = 30000;

        // Map data để đảm bảo tính toán đúng kiểu số
        let ITEMS = rawItems.map(item => {
            return {
                ...item,
                unit_price: Number(item.unit_price),
                final_price: Number(item.final_price),
                quantity: Number(item.quantity),
                discount_value: Number(item.discount_value || 0),
                // Tính lại item discount nếu chưa có
                item_discount: (Number(item.unit_price) > Number(item.final_price)) ? (Number(item.unit_price) - Number(item.final_price)) : 0
            };
        });

        // DOM Elements
        const couponInput = document.getElementById('coupon_input');
        const applyCouponBtn = document.getElementById('apply_coupon_btn');
        const cancelCouponBtn = document.getElementById('cancel_coupon_btn'); // Có thể null nếu chưa render
        const promoMessage = document.getElementById('promo_message');
        const mainContainer = document.querySelector('main');
        
        // --- HÀM FORMAT TIỀN ---
        function formatCurrency(amount) {
            return Math.round(amount).toLocaleString('vi-VN') + ' VNĐ'; 
        }

        // --- 2. TÍNH TOÁN TỔNG (Logic UI) ---
        function calculateTotals() {
            let subtotal = 0;
            let itemDiscountTotal = 0;

            ITEMS.forEach(item => {
                subtotal += item.unit_price * item.quantity;
                itemDiscountTotal += (item.item_discount) * item.quantity;
            });

            // Nếu Server đã áp dụng mã thành công, dùng giá trị từ Server
            // Nếu không, coi như coupon discount = 0
            let couponDiscount = isServerApplied ? serverDiscount : 0;

            const totalDiscount = itemDiscountTotal + couponDiscount;
            const total = subtotal - totalDiscount + SHIPPING_FEE;

            return { subtotal, totalDiscount, total, couponDiscount };
        }
        
        // --- 3. CẬP NHẬT GIAO DIỆN ---
        function updateSummary() {
            const totals = calculateTotals();

            document.getElementById('subtotal_value').textContent = formatCurrency(totals.subtotal);
            document.getElementById('discount_value').textContent = (totals.totalDiscount > 0 ? '-' : '') + formatCurrency(totals.totalDiscount);
            document.getElementById('total_value').textContent = formatCurrency(totals.total);
            
            const discountSpan = document.getElementById('discount_value');
            if (totals.totalDiscount > 0) discountSpan.classList.add('text-green-600');
            else discountSpan.classList.remove('text-green-600');

            // Cập nhật input ẩn cho Form Submit
            document.getElementById('total_amount_input').value = totals.total;
            document.getElementById('cart_items_input').value = JSON.stringify(ITEMS);
            document.getElementById('promotion_code_input').value = currentCouponCode;
        }

        // --- 4. HÀM XỬ LÝ COUPON (RELOAD TRANG) ---
        function applyCoupon() {
            const code = couponInput.value.trim().toUpperCase();
            if (!code) return;

            // Reload trang với tham số promotion_code để Controller xử lý
            const url = new URL(window.location.href);
            url.searchParams.set('promotion_code', code);
            window.location.href = url.toString();
        }

        function cancelCoupon() {
            // Reload trang và bỏ tham số promotion_code
            const url = new URL(window.location.href);
            url.searchParams.delete('promotion_code');
            window.location.href = url.toString();
        }
        
        // --- 5. LOGIC API (GIỮ NGUYÊN) ---
        function getVariantId(element) {
            return element.closest('[data-variant-id]').getAttribute('data-variant-id');
        }

        function updateQuantity(button, delta) {
            const variantId = getVariantId(button);
            const item = ITEMS.find(i => i.variant_id == variantId);
            if(!item) return; 
            
            if (item.type === 'membership') return; // Không chỉnh số lượng gói tập

            let newQty = item.quantity + delta;
            if (newQty < 1) return;

            // Gọi API cập nhật
            fetch('/api/checkout/update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ user_id: userId, item_id: variantId, quantity: newQty })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    item.quantity = newQty;
                    // Update UI text số lượng
                    button.parentElement.querySelector('.item-quantity').textContent = newQty;
                    // Tính lại tiền
                    updateSummary();
                } else {
                    alert(data.message || 'Lỗi cập nhật');
                }
            });
        }

        function deleteItem(button) {
            if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) return;
            
            const variantId = getVariantId(button);
            
            fetch('/api/checkout/remove', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ user_id: userId, item_id: variantId })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const itemIndex = ITEMS.findIndex(i => i.variant_id == variantId);
                    if(itemIndex > -1) ITEMS.splice(itemIndex, 1);
                    
                    button.closest('[data-variant-id]').remove();
                    updateSummary();

                    if (ITEMS.length === 0) {
                        document.getElementById('cart_item_list').innerHTML = '<p class="text-center py-8 text-gray-500">Giỏ hàng của bạn đang trống.</p>';
                    }
                } else {
                    alert(data.message || 'Lỗi xóa');
                }
            });
        }
        
        // --- 6. EVENT LISTENERS ---
        mainContainer.addEventListener('click', (e) => {
            const target = e.target.closest('button');
            if (!target) return;

            if (target.classList.contains('btn-qty-plus')) {
                updateQuantity(target, 1);
            } else if (target.classList.contains('btn-qty-minus')) {
                updateQuantity(target, -1);
            } else if (target.classList.contains('btn-delete-item')) {
                deleteItem(target);
            }
        });
        
        if(applyCouponBtn) {
            applyCouponBtn.addEventListener('click', applyCoupon);
        }
        
        if(cancelCouponBtn) {
            cancelCouponBtn.addEventListener('click', cancelCoupon);
        }

        if(couponInput) {
            couponInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault(); 
                    applyCoupon();
                }
            });
        }

        document.getElementById('proceed-to-checkout-form').onsubmit = function() {
            // Update lần cuối trước khi submit form
            document.getElementById('cart_items_input').value = JSON.stringify(ITEMS);
            document.getElementById('promotion_code_input').value = currentCouponCode;
        };
        
        // Init view
        updateSummary();
    });
</script>

@endsection