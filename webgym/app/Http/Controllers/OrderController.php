<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;

// Models
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PackageRegistration;
use App\Models\MembershipPackage;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\CartItem;

use App\Helpers\PromotionHelper; 

class OrderController extends Controller
{
    // 1. DANH SÁCH ĐƠN HÀNG (ADMIN)
    public function index(Request $request)
    {
        $query = Order::with(['user', 'details.product.product']); // Eager loading

        // Lọc theo Ngày
        if ($request->filled('date_from')) {
            $query->whereDate('order_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('order_date', '<=', $request->date_to);
        }

        // Lọc theo Giá
        if ($request->filled('price_from')) {
            $query->where('total_amount', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $query->where('total_amount', '<=', $request->price_to);
        }

        // Lọc theo Trạng thái
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('order_date', 'desc')
                        ->paginate(10)
                        ->appends($request->all());

        return view('admin.orders', compact('orders'));
    }

    // 2. CẬP NHẬT TRẠNG THÁI (ADMIN)
    public function update(Request $request, $id)
    {
        $order = Order::where('order_code', $id)->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Không tìm thấy đơn hàng!');
        }

        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'address' => 'nullable|string',
        ]);

        $order->status = $request->input('status');
        if ($request->has('address')) {
            $order->shipping_address = $request->input('address');
        }
        $order->save();

        return redirect()->back()->with('success', 'Cập nhật đơn hàng thành công!');
    }

    // 3. TẠO ĐƠN HÀNG (USER CHECKOUT)
    public function store(Request $request)
    {
        try {
            // --- A. VALIDATE DỮ LIỆU ĐẦU VÀO ---
            $request->validate([
                'full_name'       => 'required|string|max:255',
                'phone_number'    => 'required|string|max:20',
                'address'         => 'required|string',
                'email'           => 'required|email',
                'payment_method'  => 'required|in:cod,vnpay,momo',
                'cart_items'      => 'required|json',
                'total_amount'    => 'required|numeric|min:0',
                'promotion_code'  => 'nullable|string|max:30',
                'apartment_details' => 'nullable|string',
            ]);

            $user = Auth::user();
            $cartItems = json_decode($request->input('cart_items'), true);

            if (empty($cartItems)) {
                return back()->withErrors(['cart_items' => 'Giỏ hàng trống!'])->withInput();
            }

            // --- B. TÍNH TOÁN LẠI GIÁ (BACKEND SECURITY) ---
            // Tránh user sửa HTML để gửi giá sai lên server
            $subtotal = collect($cartItems)->sum(fn($i) => ($i['unit_price'] ?? 0) * ($i['quantity'] ?? 1));
            
            // Xử lý khuyến mãi
            $promotionDiscount = 0;
            $validPromotionCode = null;

            if ($request->filled('promotion_code')) {
                // Giả sử class PromotionHelper tồn tại và hoạt động đúng
                if (class_exists('App\Helpers\PromotionHelper')) {
                    $result = PromotionHelper::validateAndApply(
                        $request->promotion_code,
                        $cartItems,
                        $subtotal,
                        $user->id
                    );

                    if (!$result['success']) {
                        return back()->withErrors(['promotion_code' => $result['message']])->withInput();
                    }
                    $promotionDiscount = $result['discount'];
                    $validPromotionCode = $result['promotion_code'];
                }
            }

            // Tổng item discount (nếu có giảm giá riêng từng sản phẩm)
            $itemDiscount = collect($cartItems)->sum(fn($i) => ($i['discount_value'] ?? 0) * ($i['quantity'] ?? 1));
            
            // Phí ship cứng (hoặc tính theo logic của bạn)
            $shippingFee = 30000;
            
            // Công thức: Subtotal - Giảm giá SP - Voucher + Ship
            // Lưu ý: Nếu mua Membership online thường không mất ship, logic này bạn tự cân nhắc
            $calculatedTotal = $subtotal - $itemDiscount - $promotionDiscount + $shippingFee;

            // Kiểm tra chênh lệch giá (cho phép sai số nhỏ do làm tròn)
            if (abs($calculatedTotal - $request->total_amount) > 1000) {
                return back()
                    ->withErrors(['total_amount' => 'Giá trị đơn hàng thay đổi. Vui lòng tải lại trang!'])
                    ->withInput();
            }

            // --- C. XỬ LÝ DATABASE (TRANSACTION) ---
            DB::beginTransaction();

            $orderId = null;
            $registrationId = null;
            $mainTrackingCode = null; // Mã dùng để track chung (ưu tiên mã đơn hàng)
            
            // Tạo mã Payment Code duy nhất
            $paymentCode = 'PAY-' . strtoupper(Str::random(10));
            
            // Phân loại Cart
            $hasMembership = collect($cartItems)->contains('type', 'membership');
            $hasProduct    = collect($cartItems)->contains('type', 'product'); // hoặc check nếu type != membership

            // 1. TẠO ORDER (Nếu có sản phẩm vật lý)
            if ($hasProduct) {
                // Tạo mã đơn hàng chuẩn
                $todayPrefix = 'ORD' . date('Ymd');
                $lastOrder = Order::where('order_code', 'like', $todayPrefix . '%')->orderBy('order_id', 'desc')->first();
                $nextNumber = $lastOrder ? ((int)substr($lastOrder->order_code, -6)) + 1 : 1;
                $orderCode = $todayPrefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

                $fullAddress = $request->address . ($request->apartment_details ? ', ' . $request->apartment_details : '');

                $order = Order::create([
                    'user_id'          => $user->id,
                    'order_code'       => $orderCode,
                    'order_date'       => now(),
                    'total_amount'     => $calculatedTotal, // Order giữ tổng tiền thanh toán
                    'status'           => 'pending',
                    'shipping_address' => $fullAddress,
                    'promotion_code'   => $validPromotionCode,
                    'discount_value'   => $itemDiscount + $promotionDiscount,
                ]);

                $orderId = $order->order_id;
                $mainTrackingCode = $orderCode;

                // Lưu Order Detail
                foreach ($cartItems as $item) {
                    if (($item['type'] ?? '') !== 'membership') {
                        OrderDetail::create([
                            'order_id'       => $orderId,
                            'variant_id'     => $item['variant_id'] ?? null,
                            'quantity'       => $item['quantity'] ?? 1,
                            'unit_price'     => $item['unit_price'],
                            'discount_value' => $item['discount_value'] ?? 0,
                            'final_price'    => $item['final_price'] ?? ($item['unit_price'] - ($item['discount_value']??0)),
                        ]);
                    }
                }
            }

            // 2. TẠO PACKAGE REGISTRATION (Nếu có gói tập)
            if ($hasMembership) {
                foreach ($cartItems as $item) {
                    if (($item['type'] ?? '') === 'membership') {
                        $package = MembershipPackage::findOrFail($item['package_id']);
                        $months = (int) filter_var($item['duration'] ?? '1', FILTER_SANITIZE_NUMBER_INT);
                        if ($months <= 0) $months = 1;

                        $registration = PackageRegistration::create([
                            'user_id'    => $user->id,
                            'package_id' => $package->package_id,
                            'start_date' => Carbon::now(),
                            'end_date'   => Carbon::now()->addMonths($months),
                            'status'     => 'pending', // Chờ thanh toán
                            // Nếu muốn link gói tập vào order (để biết gói này thuộc đơn nào)
                            'order_id'   => $orderId, 
                        ]);

                        // Lưu lại ID đăng ký cuối cùng để gán vào Payment (nếu cần)
                        $registrationId = $registration->registration_id;
                    }
                }

                // Nếu chỉ mua gói tập (không có SP), Tracking Code là REG-...
                if (!$hasProduct) {
                    $mainTrackingCode = 'REG-' . $registrationId; // Lấy cái cuối hoặc tạo mã riêng
                    // Nếu không có Order, ta coi Payment Amount là toàn bộ bill
                }
            }

            // 3. TẠO PAYMENT
            $paymentType = 'order';
            if ($hasMembership && !$hasProduct) $paymentType = 'membership_registration';
            if ($hasMembership && $hasProduct)  $paymentType = 'combined';

            Payment::create([
                'user_id'                 => $user->id,
                'payment_code'            => $paymentCode,
                'payment_type'            => $paymentType,
                'amount'                  => $calculatedTotal,
                'method'                  => $request->payment_method,
                'payment_date'            => Carbon::now(),
                'status'                  => 'pending',
                'order_id'                => $orderId,       // Nullable
                'package_registration_id' => $registrationId, // Nullable
            ]);

            // 4. XÓA GIỎ HÀNG
            $this->clearUserCart($user->id);

            DB::commit();

            // --- D. XỬ LÝ THANH TOÁN (REDIRECT) ---
            
            // TH1: COD 
            if ($request->payment_method === 'cod') {
                if ($orderId) {
                    Order::where('order_id', $orderId)->update(['status' => 'pending']);
                }
                // Update payment status (COD thường chưa thu tiền ngay nên để pending hoặc xử lý theo nghiệp vụ)
                // Payment::where('payment_code', $paymentCode)->update(['status' => 'pending']); 

                return redirect()->route('order.thankyou', ['order_code' => $mainTrackingCode])
                                 ->with('success', 'Đặt hàng thành công!');
            }

            // TH2: VNPAY
            if ($request->payment_method === 'vnpay') {
                // Dùng mã Payment Code hoặc Order Code để gửi sang VNPAY
                $vnpayUrl = $this->createVnpayUrl($mainTrackingCode, $calculatedTotal, $request->ip());
                return redirect()->away($vnpayUrl);
            }

            return back()->with('error', 'Phương thức thanh toán chưa hỗ trợ.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Failed: ' . $e->getMessage());
            return back()->with('error', 'Lỗi hệ thống: ' . $e->getMessage())->withInput();
        }
    }

    // 4. TRANG CẢM ƠN / CHI TIẾT ĐƠN VỪA ĐẶT
    public function thankYou($orderCode)
    {
        $data = ['order_code' => $orderCode];
        $userId = Auth::id();

        // Logic hiển thị tùy thuộc vào mã đơn
        if (str_starts_with($orderCode, 'ORD')) {
            $data['order'] = Order::with('details.product')
                ->where('order_code', $orderCode)
                ->where('user_id', $userId)
                ->first();
            $data['type'] = 'product_combined';
        } 
        elseif (str_starts_with($orderCode, 'REG')) {
            $regId = str_replace('REG-', '', $orderCode);
            $data['registration'] = PackageRegistration::with('package')
                ->where('registration_id', $regId)
                ->where('user_id', $userId)
                ->first();
            $data['type'] = 'membership';
        }

        return view('user.thankyou', $data);
    }

    // --- HELPER FUNCTIONS ---

    private function clearUserCart($userId)
    {
        $cart = Cart::where('user_id', $userId)->where('status', 'active')->first();
        if ($cart) {
            CartItem::where('cart_id', $cart->cart_id)->delete();
            $cart->delete(); // Hoặc giữ cart header, chỉ xóa item tùy logic
        }
    }

    private function createVnpayUrl(string $refCode, float $amount, string $ipAddr): string
    {
        $vnp_TmnCode    = config('services.vnpay.tmn_code');
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $vnp_Url        = config('services.vnpay.url');
        // Route trả về sau khi thanh toán xong
        $vnp_ReturnUrl  = route('payment.vnpay.return'); 

        $inputData = [
            'vnp_Version'    => '2.1.0',
            'vnp_Command'    => 'pay',
            'vnp_TmnCode'    => $vnp_TmnCode,
            'vnp_Amount'     => $amount * 100, // VNPAY tính đơn vị đồng
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode'   => 'VND',
            'vnp_IpAddr'     => $ipAddr,
            'vnp_Locale'     => 'vn',
            'vnp_OrderInfo'  => "Thanh toan don hang $refCode",
            'vnp_OrderType'  => 'other',
            'vnp_ReturnUrl'  => $vnp_ReturnUrl,
            'vnp_TxnRef'     => $refCode, // Mã tham chiếu (Order Code)
        ];

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }
}