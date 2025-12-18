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
                                        <p>Thời hạn: <strong>{{ $item['duration'] ?? '1' }} Tháng</strong></p>
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
                                {{-- Nút Xóa --}}
                                <button type="button" class="btn-delete-item text-red-500 hover:text-red-700 w-6 h-6 flex items-center justify-center transition">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6h-7l-1-2H7C6.4 4 6 4.4 6 5v1H4v2h1v12c0 1.1 0.9 2 2 2h10c1.1 0 2-0.9 2-2V8h1V6h-2zM9 18H8v-6h1v6zm4 0h-2v-6h2v6zm4 0h-2v-6h2v6z"/></svg>
                                </button>

                                {{-- Nút Tăng/Giảm SL (Chỉ hiện cho Product) --}}
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
                    <p class="text-center py-8 text-gray-500">Vui lòng <a href="{{ route('login') }}" class="text-blue-600 hover:underline">đăng nhập</a> để thanh toán.</p>
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
                    <span id="total_value" class="font-bold text-gray-900">0 VNĐ</span>
                </div>
            </div>

            <hr class="my-6">

            {{-- FORM COUPON --}}
            <div>
                <p class="text-sm font-semibold text-gray-700 mb-3">Mã giảm giá</p>

                <div id="coupon_input_container" class="flex space-x-2 transition-opacity duration-300">
                    <input type="text" id="coupon_input" placeholder="Nhập mã giảm giá" class="flex-1 py-2.5 px-4 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 uppercase" autocomplete="off" maxlength="20">
                    <button type="button" id="apply_coupon_btn" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors text-sm">Áp dụng</button>
                </div>

                {{-- Nơi hiển thị mã đã áp dụng --}}
                <div id="applied_coupon_tag" class="hidden mt-3"></div>
            </div>

            <p id="promo_message" class="text-xs mt-2 text-red-500 hidden"></p>

            {{-- FORM SUBMIT --}}
            <form id="proceed-to-checkout-form" method="POST" action="{{ route('checkout-detail') }}" class="mt-6">
                @csrf
                {{-- Input ẩn để truyền data sang Controller --}}
                <input type="hidden" name="cart_items" id="cart_items_input">
                <input type="hidden" name="promotion_code" id="promotion_code_input">
                <input type="hidden" name="total_amount" id="total_amount_input">

                <!-- <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phương thức thanh toán</label>
                    <select name="payment_method" class="w-full border border-gray-300 rounded-lg p-2.5">
                        <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                        <option value="vnpay">VNPAY</option>
                        <option value="momo">MoMo</option>
                    </select>
                </div> -->
                
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
        // 1. KHỞI TẠO DỮ LIỆU
        // Dữ liệu giỏ hàng
        let rawItems = @json($cart_items ?? []);
        const userId = {{ Auth::id() ?? 0 }};
        const csrfToken = '{{ csrf_token() }}';
        
        // Dữ liệu Khuyến mãi (được truyền từ Controller render View này)
        // Nếu Controller chưa truyền $promotions_data, mảng này sẽ rỗng
        const PROMOTIONS_DATA = @json($promotions_data ?? []); 

        const SHIPPING_FEE = 30000;
        let currentCouponCode = '';
        let couponDiscount = 0;

        // Map data ban đầu để đảm bảo có đủ trường cần thiết
        let ITEMS = rawItems.map(item => ({
            ...item,
            // Đảm bảo các giá trị số là number
            unit_price: Number(item.unit_price),
            final_price: Number(item.final_price),
            quantity: Number(item.quantity),
            discount_value: Number(item.discount_value || 0),
            // Tính lại item discount nếu chưa có
            item_discount: (item.unit_price > item.final_price) ? (item.unit_price - item.final_price) : 0
        }));

        // DOM Elements
        const subtotalEl = document.getElementById('subtotal_value');
        const discountEl = document.getElementById('discount_value');
        const totalEl = document.getElementById('total_value');
        const couponInput = document.getElementById('coupon_input');
        const applyCouponBtn = document.getElementById('apply_coupon_btn');
        const appliedCouponTag = document.getElementById('applied_coupon_tag');
        const promoMessage = document.getElementById('promo_message');
        const couponContainer = document.getElementById('coupon_input_container');
        const cartListContainer = document.getElementById('cart_item_list');

        // --- 2. HÀM ĐỊNH DẠNG TIỀN TỆ ---
        function formatCurrency(amount) {
            return Math.round(amount).toLocaleString('vi-VN') + ' VNĐ';
        }

        // --- 3. TÍNH TOÁN TỔNG ---
        function calculateTotals() {
            let subtotal = 0;
            let itemDiscountTotal = 0;

            ITEMS.forEach(item => {
                subtotal += item.unit_price * item.quantity;
                itemDiscountTotal += (item.item_discount) * item.quantity;
            });

            // Logic Coupon (Client-side check)
            let message = '';
            let isValidCoupon = false;
            let tempDiscount = 0;

            if (currentCouponCode) {
                // Tìm coupon trong danh sách (Dữ liệu từ controller)
                // Lưu ý: Đây là check nhanh ở frontend, backend sẽ check kỹ lại
                const promo = Array.isArray(PROMOTIONS_DATA) 
                    ? PROMOTIONS_DATA.find(p => p.code === currentCouponCode) 
                    : null;

                if (promo) {
                    if (subtotal >= promo.min_order_amount) {
                        let calc = 0;
                        if (promo.is_percent) {
                            calc = subtotal * (promo.discount_value / 100);
                            tempDiscount = Math.min(calc, promo.max_discount);
                        } else {
                            tempDiscount = promo.discount_value;
                        }
                        message = `Áp dụng mã ${currentCouponCode} thành công.`;
                        isValidCoupon = true;
                    } else {
                        message = `Mã này cần đơn tối thiểu ${formatCurrency(promo.min_order_amount)}`;
                    }
                } else {
                    // Nếu không có dữ liệu promo ở frontend, ta tạm chấp nhận code gửi lên backend check sau
                    // Hoặc báo lỗi nếu muốn chặt chẽ
                     message = `Mã giảm giá không hợp lệ hoặc đã hết hạn.`;
                }
            }

            if (!isValidCoupon) {
                couponDiscount = 0;
                // Nếu coupon không hợp lệ thì giữ mã để báo lỗi nhưng không trừ tiền
            } else {
                couponDiscount = tempDiscount;
            }

            const totalDiscount = itemDiscountTotal + couponDiscount;
            const total = subtotal - totalDiscount + SHIPPING_FEE;

            return { subtotal, totalDiscount, total, message, isValidCoupon };
        }

        // --- 4. CẬP NHẬT GIAO DIỆN ---
        function updateSummary() {
            const totals = calculateTotals();

            subtotalEl.textContent = formatCurrency(totals.subtotal);
            discountEl.textContent = (totals.totalDiscount > 0 ? '-' : '') + formatCurrency(totals.totalDiscount);
            totalEl.textContent = formatCurrency(totals.total);

            // Cập nhật input ẩn để submit form
            document.getElementById('total_amount_input').value = totals.total;

            // Xử lý UI Coupon
            if (totals.isValidCoupon && currentCouponCode) {
                couponContainer.classList.add('hidden');
                appliedCouponTag.classList.remove('hidden');
                appliedCouponTag.innerHTML = `
                    <div class="inline-flex items-center space-x-2 py-1.5 px-3 rounded-lg bg-blue-100 border border-blue-300">
                        <span class="font-bold text-sm text-gray-900">${currentCouponCode} -${formatCurrency(couponDiscount)}</span>
                        <button type="button" id="cancel_coupon_btn" class="text-gray-500 hover:text-red-500 font-bold px-1">x</button>
                    </div>`;
                
                // Gán sự kiện hủy coupon
                document.getElementById('cancel_coupon_btn').addEventListener('click', () => {
                    currentCouponCode = '';
                    updateSummary();
                });

                promoMessage.textContent = totals.message;
                promoMessage.className = "text-xs mt-2 text-green-600";
                promoMessage.classList.remove('hidden');
            } else {
                appliedCouponTag.classList.add('hidden');
                couponContainer.classList.remove('hidden');
                
                if (currentCouponCode && !totals.isValidCoupon) {
                    promoMessage.textContent = totals.message;
                    promoMessage.className = "text-xs mt-2 text-red-500";
                    promoMessage.classList.remove('hidden');
                } else {
                    promoMessage.classList.add('hidden');
                }
            }
        }

        // --- 5. SỰ KIỆN NÚT BẤM (Event Delegation) ---
        document.querySelector('.container').addEventListener('click', (e) => {
            const target = e.target.closest('button');
            if (!target) return;

            // Nút Tăng/Giảm SL
            if (target.classList.contains('btn-qty-plus')) updateQuantity(target, 1);
            if (target.classList.contains('btn-qty-minus')) updateQuantity(target, -1);
            
            // Nút Xóa
            if (target.classList.contains('btn-delete-item')) removeItem(target);
            
            // Nút Áp dụng Coupon
            if (target.id === 'apply_coupon_btn') {
                const code = couponInput.value.trim().toUpperCase();
                if(code) {
                    currentCouponCode = code;
                    updateSummary();
                }
            }
        });

        // --- 6. LOGIC GỌI API CẬP NHẬT ---
        function getVariantId(element) {
            return element.closest('[data-variant-id]').getAttribute('data-variant-id');
        }

        function updateQuantity(btn, delta) {
            const variantId = getVariantId(btn);
            const item = ITEMS.find(i => i.variant_id == variantId);
            if (!item) return;

            const newQty = item.quantity + delta;
            if (newQty < 1) return;

            // Gọi API
            fetch('/api/checkout/update', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ user_id: userId, item_id: variantId, quantity: newQty })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Update Local
                    item.quantity = newQty;
                    // Update UI SL
                    btn.parentElement.querySelector('.item-quantity').textContent = newQty;
                    // Recalculate
                    updateSummary();
                } else {
                    alert(data.message || 'Lỗi cập nhật');
                }
            });
        }

        function removeItem(btn) {
            if(!confirm('Xóa sản phẩm này?')) return;
            
            const variantId = getVariantId(btn);
            
            fetch('/api/checkout/remove', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ user_id: userId, item_id: variantId })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Xóa khỏi mảng
                    const idx = ITEMS.findIndex(i => i.variant_id == variantId);
                    if(idx > -1) ITEMS.splice(idx, 1);
                    
                    // Xóa khỏi DOM
                    btn.closest('[data-variant-id]').remove();
                    
                    // Nếu hết hàng
                    if(ITEMS.length === 0) {
                        cartListContainer.innerHTML = '<p class="text-center py-8 text-gray-500">Giỏ hàng trống</p>';
                    }
                    updateSummary();
                } else {
                    alert(data.message || 'Lỗi xóa sản phẩm');
                }
            });
        }

        // --- 7. SUBMIT FORM ---
        document.getElementById('proceed-to-checkout-form').addEventListener('submit', function() {
            // Cập nhật lại giá trị input hidden lần cuối trước khi gửi
            document.getElementById('cart_items_input').value = JSON.stringify(ITEMS);
            document.getElementById('promotion_code_input').value = currentCouponCode;
        });

        // Init
        updateSummary();
    });
</script>

@endsection