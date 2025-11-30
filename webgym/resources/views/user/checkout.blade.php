@extends('user.layouts.user_layout')

@section('title', 'GRYND - Thanh toán')

@section('content')
<div class="container mx-auto px-4 py-8 font-['Roboto']">
    <nav class="flex mb-10" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li><a href="{{ url('/') }}" class="text-sm text-gray-700 hover:text-blue-600">Trang Chủ</a></li>
            <li><div class="flex items-center"><svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 6 10"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg><a href="{{ route('product') }}" class="ml-1 text-sm text-gray-700 hover:text-blue-600">Cửa hàng</a></div></li>
            <li aria-current="page"><div class="flex items-center"><svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 6 10"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg><span class="ml-1 text-sm font-bold text-gray-900">Thanh toán</span></div></li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <!-- Danh sách sản phẩm -->
        <main class="lg:col-span-3 bg-white p-6 rounded-lg shadow-xl border">
            <h1 class="text-3xl font-bold text-gray-900 mb-8 font-['Montserrat']">Đơn hàng của tôi</h1>

            <div class="space-y-4" id="cart_item_list">
                @auth
                @forelse($cart_items ?? [] as $item)
                <div class="flex items-start border-b border-gray-200 pb-4 last:border-b-0" data-id="{{ $item['id'] ?? $loop->index }}">
                    <div class="w-20 h-20 flex-shrink-0 mr-4">
                        <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-800">{{ $item['name'] }}</p>
                        @if(($item['type'] ?? '') === 'membership')
                        <p class="text-sm text-gray-500">Thời hạn: {{ $item['duration'] ?? 'N/A' }}</p>
                        @else
                        <p class="text-sm text-gray-500">Size: {{ $item['size'] ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">Color: {{ $item['color'] ?? 'N/A' }}</p>
                        @endif
                        <div class="flex items-end mt-3">
                            <p class="text-xl font-bold text-gray-900">
                                {{ number_format($item['final_price'], 0, ',', '.') }} đ
                            </p>
                            @if(($item['unit_price'] ?? 0) > ($item['final_price'] ?? 0))
                            <p class="text-sm text-gray-400 line-through ml-2">
                                {{ number_format($item['unit_price'], 0, ',', '.') }} đ
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col items-end justify-between h-20 text-gray-500">
                        <button type="button" class="btn-delete-item text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6h-7l-1-2H7C6.4 4 6 4.4 6 5v1H4v2h1v12c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V8h1V6h-2zM9 18H8v-6h1v6zm4 0h-2v-6h2v6zm4 0h-2v-6h2v6z"/></svg>
                        </button>
                        @if(($item['type'] ?? '') !== 'membership')
                        <div class="flex items-center border border-gray-300 rounded-full px-1 py-0.5 mt-auto">
                            <button type="button" class="btn-qty-minus w-7 h-7 text-xl">-</button>
                            <span class="item-quantity text-base font-semibold px-2">{{ $item['quantity'] }}</span>
                            <button type="button" class="btn-qty-plus w-7 h-7 text-xl">+</button>
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

        <!-- Tóm tắt thanh toán -->
        <aside class="lg:col-span-2 bg-white p-6 rounded-lg shadow-xl border">
            <h2 class="text-2xl font-bold mb-6">Tóm tắt đơn hàng</h2>

            <div class="space-y-3 text-gray-700">
                <div class="flex justify-between">
                    <span>Tổng phụ</span>
                    <span id="subtotal_value">0 đ</span>
                </div>
                <div class="flex justify-between">
                    <span>Giảm giá</span>
                    <span id="discount_value" class="text-red-600">0 đ</span>
                </div>
                <div class="flex justify-between">
                    <span>Phí vận chuyển</span>
                    <span id="shipping_value">30.000 đ</span>
                </div>
                <div class="flex justify-between text-xl font-bold pt-4 border-t">
                    <span>Tổng cộng</span>
                    <span id="total_value" class="text-blue-600">0 đ</span>
                </div>
            </div>

            <!-- Mã giảm giá -->
            <div class="mt-6">
                <div id="coupon_input_container">
                    <div class="flex gap-2">
                        <input type="text" id="coupon_input" placeholder="Nhập mã giảm giá" class="flex-1 px-4 py-3 border rounded-lg uppercase" maxlength="20">
                        <button type="button" id="apply_coupon_btn" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Áp dụng</button>
                    </div>
                </div>

                <div id="applied_coupon_tag" class="hidden mt-3 flex items-center justify-between bg-green-50 border border-green-200 rounded-lg p-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M22 10V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v4c1.1 0 2 .9 2 2s-.9 2-2 2v4c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-4c-1.1 0-2-.9-2-2s.9-2 2-2zM6 17v-2h12v2H6zm0-4v-2h12v2H6z"/></svg>
                        <span id="applied_code_display" class="font-bold text-green-800"></span>
                    </div>
                    <button type="button" id="cancel_coupon_btn" class="text-green-700 hover:text-green-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <p id="promo_message" class="mt-3 text-sm hidden"></p>
            </div>

            <!-- Nút tiến hành thanh toán -->
            <form id="proceed-to-checkout-form" method="POST" action="{{ route('checkout-detail') }}" class="mt-8">
                @csrf
                <input type="hidden" name="cart_items" id="cart_items_input">
                <input type="hidden" name="promotion_code" id="promotion_code_input">

                <button type="submit" class="w-full py-4 bg-blue-600 text-white text-lg font-bold rounded-lg hover:bg-blue-700 shadow-lg transition">
                    Tiến hành thanh toán →
                </button>
            </form>
        </aside>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.CART_ITEMS = @json($cart_items ?? []);
        let currentPromotionCode = '';

        const SHIPPING_FEE = 30000;

        // Elements
        const cartItemList = document.getElementById('cart_item_list');
        const subtotalEl = document.getElementById('subtotal_value');
        const discountEl = document.getElementById('discount_value');
        const totalEl = document.getElementById('total_value');
        const couponInput = document.getElementById('coupon_input');
        const applyBtn = document.getElementById('apply_coupon_btn');
        const cancelBtn = document.getElementById('cancel_coupon_btn');
        const appliedTag = document.getElementById('applied_coupon_tag');
        const appliedCodeDisplay = document.getElementById('applied_code_display');
        const couponInputContainer = document.getElementById('coupon_input_container');
        const promoMessage = document.getElementById('promo_message');

        // Format tiền
        const formatVND = (num) => num.toLocaleString('vi-VN') + ' đ';

        // Tính toán tổng
        function calculateTotals() {
            let subtotal = 0;
            let itemDiscount = 0;

            CART_ITEMS.forEach(item => {
                const price = item.unit_price || 0;
                const qty = item.quantity || 1;
                const discountPerItem = item.discount_value || 0;

                subtotal += price * qty;
                itemDiscount += discountPerItem * qty;
            });

            let promoDiscount = 0;
            if (currentPromotionCode) {
                promoDiscount = 0; // Tạm tính client, server validate lại
            }

            const totalDiscount = itemDiscount + promoDiscount;
            const total = subtotal - totalDiscount + SHIPPING_FEE;

            return { subtotal, itemDiscount, promoDiscount, totalDiscount, total };
        }

        // Cập nhật giao diện
        function updateSummary() {
            const t = calculateTotals();
            subtotalEl.textContent = formatVND(t.subtotal);
            discountEl.textContent = t.totalDiscount > 0 ? '-' + formatVND(t.totalDiscount) : '0 đ';
            totalEl.textContent = formatVND(t.total);
        }

        applyBtn.onclick = () => {
            const code = couponInput.value.trim().toUpperCase();
            if (!code) return;

            currentPromotionCode = code;
            appliedCodeDisplay.textContent = code;
            appliedTag.classList.remove('hidden');
            couponInputContainer.classList.add('hidden');
            promoMessage.classList.add('hidden');
            updateSummary();
        };

        cancelBtn.onclick = () => {
            currentPromotionCode = '';
            couponInput.value = '';
            appliedTag.classList.add('hidden');
            couponInputContainer.classList.remove('hidden');
            promoMessage.classList.add('hidden');
            updateSummary();
        };

        document.addEventListener('click', function(e) {
            if (e.target.matches('.btn-qty-plus, .btn-qty-minus')) {
                const btn = e.target;
                const container = btn.closest('.flex.items-start');
                const qtySpan = container.querySelector('.item-quantity');
                const index = Array.from(cartItemList.children).indexOf(container);

                if (index === -1) return;

                let qty = parseInt(qtySpan.textContent);
                qty = btn.classList.contains('btn-qty-plus') ? qty + 1 : qty - 1;
                if (qty < 1) qty = 1;

                qtySpan.textContent = qty;
                CART_ITEMS[index].quantity = qty;
                updateSummary();
            }

            if (e.target.closest('.btn-delete-item')) {
                if (confirm('Xóa sản phẩm khỏi giỏ hàng?')) {
                    const container = e.target.closest('.flex.items-start');
                    const index = Array.from(cartItemList.children).indexOf(container);
                    CART_ITEMS.splice(index, 1);
                    container.remove();
                    updateSummary();
                }
            }
        });

        document.getElementById('proceed-to-checkout-form').onsubmit = function() {
            document.getElementById('cart_items_input').value = JSON.stringify(CART_ITEMS);
            document.getElementById('promotion_code_input').value = currentPromotionCode;
        };

        updateSummary();
    });
</script>
@endsection
