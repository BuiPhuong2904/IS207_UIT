@extends('user.layouts.user_layout')

@section('title', 'GRYND - Thanh toán')

@section('content')

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

            <div class="space-y-4" id="cart_item_list">
                @auth
                    @forelse($cart_items ?? [] as $item)
                    <div class="flex items-start border-b border-gray-200 pb-4 last:border-b-0 last:pb-0" data-id="{{ $item['id'] ?? $loop->index }}">
                        <div class="w-20 h-20 flex-shrink-0 mr-4">
                            <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover rounded-lg">
                        </div>

                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <p class="font-bold text-gray-800">{{ $item['name'] }}</p>
                            </div>

                            <div class="flex flex-col items-start text-sm text-gray-500">
                                @if( ($item['type'] ?? '') === 'membership' )
                                    <p>Thời hạn: <strong>{{ $item['duration'] ?? 'N/A' }}</strong></p>
                                @else
                                    <p>Size: {{ $item['size'] ?? 'N/A' }}</p>
                                    <p>Color: {{ $item['color'] ?? 'N/A' }}</p>
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
                            <button type="button" class="btn-delete-item text-red-500 hover:text-red-700 w-6 h-6 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6h-7l-1-2H7C6.4 4 6 4.4 6 5v1H4v2h1v12c0 1.1 0.9 2 2 2h10c1.1 0 2-0.9 2-2V8h1V6h-2zM9 18H8v-6h1v6zm4 0h-2v-6h2v6zm4 0h-2v-6h2v6z"/></svg>
                            </button>

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
                    <span id="total_value" class="font-bold text-gray-900 text-blue-600">0 VNĐ</span>
                </div>
            </div>

            <hr class="my-6">

            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3">Mã giảm giá</p>

                <div id="coupon_input_container" class="flex space-x-2 transition-opacity duration-300">
                    <input type="text" id="coupon_input" placeholder="Nhập mã giảm giá" class="flex-1 py-2.5 px-4 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 uppercase" autocomplete="off" maxlength="20">
                    <button type="button" id="apply_coupon_btn" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors text-sm">Áp dụng</button>
                </div>

                <div id="applied_coupon_tag" class="hidden mt-3">
                    </div>
            </div>

            <p id="promo_message" class="text-xs mt-2 text-red-500 hidden"></p>

            <form id="proceed-to-checkout-form" method="POST" action="{{ route('checkout-detail') }}" class="mt-6">
                @csrf
                <input type="hidden" name="cart_items" id="cart_items_input">
                <input type="hidden" name="promotion_code" id="promotion_code_input">

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
    document.addEventListener('DOMContentLoaded', function () {
        let ITEMS = @json($cart_items ?? []);
        let currentCouponCode = '';
        let couponDiscount = 0;
        const cartItemListContainer = document.getElementById('cart_item_list');
        const couponInput = document.getElementById('coupon_input');
        const applyCouponBtn = document.getElementById('apply_coupon_btn');
        const promoMessage = document.getElementById('promo_message');
        const appliedCouponTag = document.getElementById('applied_coupon_tag');
        const couponInputContainer = document.getElementById('coupon_input_container');

        // Hàm format tiền
        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', { maximumSignificantDigits: 3 }).format(amount) + 'đ';
        }

        // Hàm tính tổng (sửa để lấy couponDiscount từ backend, subtotal và item_discount từ local)
        function calculateTotals(code = '') {
            const subtotal = ITEMS.reduce((sum, item) => sum + (item.unit_price || 0) * (item.quantity || 1), 0);
            const itemDiscountTotal = ITEMS.reduce((sum, item) => sum + ((item.discount_value || 0) * (item.quantity || 1)), 0);
            const totalDiscount = itemDiscountTotal + couponDiscount;
            const total = subtotal - totalDiscount + 30000; // shipping_fee fixed
            return { subtotal, totalDiscount, total, message: '', itemDiscountTotal, couponDiscount };
        }

        // Hàm render tag mã giảm giá (giữ nguyên từ code gốc của bạn, giả sử bạn có)
        function renderAppliedCoupon(code) {
            appliedCouponTag.innerHTML = `
            <span class="inline-flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                ${code} -${formatCurrency(couponDiscount)}
                <button type="button" onclick="cancelCoupon()" class="ml-2 text-green-600 hover:text-green-800">×</button>
            </span>`;
            appliedCouponTag.classList.remove('hidden');
        }

        // Hàm cập nhật UI tổng tiền (giữ nguyên)
        function updateSummary(totals) {
            document.getElementById('subtotal_value').textContent = formatCurrency(totals.subtotal);
            document.getElementById('discount_value').textContent = (totals.totalDiscount > 0 ? '-' : '') + formatCurrency(totals.totalDiscount);
            document.getElementById('total_value').textContent = formatCurrency(totals.total);

            const discountSpan = document.getElementById('discount_value');
            if (totals.totalDiscount > 0) discountSpan.classList.add('text-red-600');
            else discountSpan.classList.remove('text-red-600');

            // UI Handling cho coupon (giữ nguyên)
            if (currentCouponCode) {
                couponInputContainer.classList.add('hidden');
                renderAppliedCoupon(currentCouponCode);

                promoMessage.textContent = totals.message;
                promoMessage.classList.add('text-green-600');
                promoMessage.classList.remove('text-red-500', 'hidden');
            } else {
                appliedCouponTag.innerHTML = '';
                appliedCouponTag.classList.add('hidden');
                couponInputContainer.classList.remove('hidden');
                couponInput.value = '';

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

        // --- ACTIONS ---
        async function applyCoupon() {
            const code = couponInput.value.toUpperCase().trim();
            if (!code) return;

            applyCouponBtn.disabled = true;
            applyCouponBtn.textContent = 'Đang kiểm tra...';

            try {
                const response = await fetch('/api/apply-promotion', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        promotion_code: code,
                        cart_items: JSON.stringify(ITEMS)  // Sửa lỗi JSON
                    })
                });

                const data = await response.json();

                if (data.success) {
                    currentCouponCode = data.promotion_code;
                    couponDiscount = data.discount;

                    const totals = calculateTotals();
                    totals.message = data.message;
                    updateSummary(totals);
                } else {
                    currentCouponCode = '';
                    couponDiscount = 0;

                    const totals = calculateTotals();
                    totals.message = data.message;
                    updateSummary(totals);
                }
            } catch (error) {
                console.error(error);
                promoMessage.textContent = 'Lỗi kết nối, vui lòng thử lại';
                promoMessage.classList.add('text-red-500');
                promoMessage.classList.remove('hidden');
            } finally {
                applyCouponBtn.disabled = false;
                applyCouponBtn.textContent = 'Áp dụng';
            }
        }

        function cancelCoupon() {
            const oldCode = currentCouponCode;
            currentCouponCode = '';
            couponDiscount = 0;
            const totals = calculateTotals();
            totals.message = `Mã ${oldCode} đã được hủy bỏ.`;
            updateSummary(totals);
        }

        function getItemIndex(element) {
            const itemContainer = element.closest('.flex.items-start');
            if (itemContainer === null) return -1;
            const allItemContainers = Array.from(document.querySelectorAll('#cart_item_list > .flex.items-start'));
            return allItemContainers.findIndex(el => el === itemContainer);
        }

        function updateQuantity(button, delta) {
            const itemIndex = getItemIndex(button);
            if(itemIndex === -1 || itemIndex >= ITEMS.length) return;

            if (ITEMS[itemIndex].type === 'membership') return;

            const itemContainer = button.closest('.flex.items-start');
            const quantitySpan = itemContainer.querySelector('.item-quantity');

            let currentQty = parseInt(quantitySpan.textContent);
            let newQty = currentQty + delta;

            if (newQty < 1) newQty = 1;

            if (newQty !== currentQty) {
                quantitySpan.textContent = newQty;
                ITEMS[itemIndex].quantity = newQty;
                const totals = calculateTotals(currentCouponCode);
                updateSummary(totals);
            }
        }

        function deleteItem(button) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                const itemToDeleteIndex = getItemIndex(button);
                if(itemToDeleteIndex === -1 || itemToDeleteIndex >= ITEMS.length) return;

                const itemContainer = button.closest('.flex.items-start');
                ITEMS.splice(itemToDeleteIndex, 1);
                itemContainer.remove();

                const totals = calculateTotals(currentCouponCode);
                updateSummary(totals);

                if (ITEMS.length === 0) {
                    cartItemListContainer.innerHTML = '<p class="text-center py-8 text-gray-500">Giỏ hàng của bạn đang trống.</p>';
                }
            }
        }

        // Sự kiện click (giữ nguyên)
        const mainContainer = document.querySelector('.container'); // Hoặc document.body nếu không có .container
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

        applyCouponBtn.addEventListener('click', applyCoupon);
        couponInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyCoupon();
            }
        });

        document.getElementById('proceed-to-checkout-form').onsubmit = function() {
            document.getElementById('cart_items_input').value = JSON.stringify(ITEMS);
            document.getElementById('promotion_code_input').value = currentCouponCode;
        };

        // Khởi tạo
        const initialTotals = calculateTotals(currentCouponCode);
        updateSummary(initialTotals);
    });
</script>

@endsection
