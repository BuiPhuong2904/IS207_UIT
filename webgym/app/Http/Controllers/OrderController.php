<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\PackageRegistration;
use App\Models\MembershipPackage;
use App\Models\Cart;
use App\Models\CartItem;
use App\Helpers\PromotionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.store');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'         => 'required|string|max:255',
            'phone_number'      => 'required|string|max:20',
            'address'           => 'required|string',
            'email'             => 'required|email',
            'payment_method'    => 'required|in:cod,vnpay,momo',
            'cart_items'        => 'required|json',
            'total_amount'      => 'required|numeric|min:0',
            'promotion_code'    => 'nullable|string|max:30',
            'apartment_details' => 'nullable|string',
        ]);

        $cartItems = json_decode($request->cart_items, true);
        if (empty($cartItems)) {
            return back()->withErrors(['cart_items' => 'Giỏ hàng trống!'])->withInput();
        }

        // Tính lại subtotal
        $subtotal = collect($cartItems)->sum(fn($i) => ($i['unit_price'] ?? 0) * ($i['quantity'] ?? 1));

        // Xác thực lại mã giảm giá (bắt buộc, chống cheat)
        $promotionDiscount = 0;
        $validPromotionCode = null;

        if ($request->filled('promotion_code')) {
            $result = PromotionHelper::validateAndApply(
                $request->promotion_code,
                $cartItems,
                $subtotal,
                Auth::id()
            );

            if (!$result['success']) {
                return back()
                    ->withErrors(['promotion_code' => $result['message']])
                    ->withInput();
            }

            $promotionDiscount = $result['discount'];
            $validPromotionCode = $result['promotion_code'];
        }

        // Tính tổng cuối cùng
        $itemDiscount = collect($cartItems)->sum(fn($i) => ($i['discount_value'] ?? 0) * ($i['quantity'] ?? 1));
        $finalTotal = $subtotal - $itemDiscount - $promotionDiscount + 30000;

        // Chống cheat tiền
        if (abs($finalTotal - $request->total_amount) > 100) {
            return back()
                ->withErrors(['total_amount' => 'Số tiền không hợp lệ. Vui lòng tải lại trang!'])
                ->withInput();
        }

        $orderCode = null;

        try {
            DB::transaction(function () use (
                $request, $cartItems, $subtotal, $itemDiscount,
                $promotionDiscount, $validPromotionCode, $finalTotal, &$orderCode
            ) {
                // Tạo mã đơn đẹp, không trùng: ORD20251212000123
                $todayPrefix = 'ORD' . date('Ymd');
                $lastOrder = Order::where('order_code', 'like', $todayPrefix . '%')
                    ->orderBy('order_id', 'desc')
                    ->first();

                $nextNumber = $lastOrder
                    ? ((int)substr($lastOrder->order_code, -6)) + 1
                    : 1;

                $orderCode = $todayPrefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

                // Tạo đơn hàng – chỉ dùng đúng các cột có trong model
                $order = Order::create([
                    'user_id'           => Auth::id(),
                    'order_date'        => now(),
                    'order_code'        => $orderCode,
                    'total_amount'      => $finalTotal,
                    'status'            => 'pending',
                    'shipping_address'  => $request->address .
                        ($request->apartment_details ? ', ' . $request->apartment_details : ''),
                    'discount_value'    => $itemDiscount + $promotionDiscount,
                    'promotion_code'    => $validPromotionCode,
                ]);

                // Tạo chi tiết đơn hàng (sản phẩm vật lý)
                foreach ($cartItems as $item) {
                    if (empty($item['type']) || $item['type'] !== 'membership') {
                        OrderDetail::create([
                            'order_id'       => $order->order_id,
                            'variant_id'     => $item['variant_id'] ?? null,
                            'quantity'       => $item['quantity'] ?? 1,
                            'unit_price'     => $item['unit_price'],
                            'discount_value' => $item['discount_value'] ?? 0,
                        ]);
                    }
                }

                // Tạo đăng ký gói tập
                foreach ($cartItems as $item) {
                    if (!empty($item['type']) && $item['type'] === 'membership') {
                        $package = MembershipPackage::findOrFail($item['package_id']);

                        $startDate = Carbon::now();
                        $endDate = $package->duration_months > 0
                            ? $startDate->copy()->addMonths($package->duration_months)
                            : $startDate->copy();

                        PackageRegistration::create([
                            'user_id'     => Auth::id(),
                            'package_id'  => $package->package_id,
                            'order_id'    => $order->order_id,     // liên kết với đơn hàng
                            'start_date'  => $startDate,
                            'end_date'    => $endDate,
                            'status'      => 'active',
                        ]);
                    }
                }

                // Tạo bản ghi thanh toán
                Payment::create([
                    'user_id'      => Auth::id(),
                    'order_id'     => $order->order_id,
                    'payment_code' => $orderCode,
                    'amount'       => $finalTotal,
                    'method'       => $request->payment_method,
                    'status'       => 'pending',
                ]);

                // XÓA GIỎ HÀNG SAU KHI THÀNH CÔNG
                $cart = Cart::where('user_id', Auth::id())->first();
                if ($cart) {
                    CartItem::where('cart_id', $cart->cart_id)->delete();
                    $cart->delete();
                }
            });

            // XỬ LÝ SAU KHI TẠO ĐƠN THÀNH CÔNG
            if ($request->payment_method === 'cod') {
                Order::where('order_code', $orderCode)->update(['status' => 'processing']);
                Payment::where('payment_code', $orderCode)->update([
                    'status'       => 'completed',
                    'payment_date' => now(),
                ]);

                return redirect()
                    ->route('order.thankyou', $orderCode)
                    ->with('success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ sớm.');
            }

            if ($request->payment_method === 'vnpay') {
                $vnpayUrl = $this->createVnpayUrl($orderCode, $finalTotal, $request->ip());
                return redirect()->away($vnpayUrl);
            }

            return back()->with('error', 'Phương thức thanh toán chưa hỗ trợ.');

        } catch (\Exception $e) {
            Log::error('Checkout failed: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request' => $request->all()
            ]);

            return back()
                ->withErrors(['error' => 'Đặt hàng thất bại. Vui lòng thử lại.'])
                ->withInput();
        }
    }

    public function thankYou($orderCode)
    {
        $order = Order::with(['details.product', 'payment'])
            ->where('order_code', $orderCode)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $registrations = PackageRegistration::where('user_id', Auth::id())
            ->where('created_at', '>=', now()->subMinutes(15))
            ->with('package')
            ->latest()
            ->get();

        return view('user.thankyou', compact('order', 'registrations'));
    }

    // Tính lại tổng tiền
    private function recalculateTotal(array $cartItems, ?string $promotionCode): array
    {
        $subtotal = 0;
        $itemDiscountTotal = 0;

        foreach ($cartItems as $item) {
            $price    = (float)($item['unit_price'] ?? 0);
            $discount = (float)($item['discount_value'] ?? 0);
            $qty      = (int)($item['quantity'] ?? 1);

            $subtotal         += $price * $qty;
            $itemDiscountTotal += $discount * $qty;
        }

        $promotionDiscount = 0;
        if (!empty($promotionCode)) {
            $result = PromotionHelper::validateAndApply($promotionCode, $cartItems, $subtotal);
            if ($result['success']) {
                $promotionDiscount = (float)$result['discount'];
            }
        }

        $shippingFee = 30000;
        $finalTotal  = $subtotal - $itemDiscountTotal - $promotionDiscount + $shippingFee;
        $finalTotal  = round($finalTotal, 0);

        return [
            'subtotal'            => $subtotal,
            'item_discount'       => $itemDiscountTotal,
            'promotion_discount'  => $promotionDiscount,
            'shipping_fee'        => $shippingFee,
            'total'               => (int)$finalTotal,
        ];
    }

    // Tạo URL thanh toán VNPAY
    private function createVnpayUrl(string $orderCode, float $amount, string $ipAddr): string
    {
        $vnp_TmnCode    = config('services.vnpay.tmn_code');
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $vnp_Url        = config('services.vnpay.url');
        $vnp_ReturnUrl  = route('payment.vnpay.return');

        $inputData = [
            'vnp_Version'    => '2.1.0',
            'vnp_Command'    => 'pay',
            'vnp_TmnCode'    => $vnp_TmnCode,
            'vnp_Amount'     => $amount * 100,
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode'   => 'VND',
            'vnp_IpAddr'     => $ipAddr,
            'vnp_Locale'     => 'vn',
            'vnp_OrderInfo'  => "Thanh toan don hang $orderCode tai GRYND",
            'vnp_OrderType'  => 'other',
            'vnp_ReturnUrl'  => $vnp_ReturnUrl,
            'vnp_TxnRef'     => $orderCode,
        ];

        ksort($inputData);


        $hashdata = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 0) {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            }
            $i = 1;
        }

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); // không strtoupper

        $query = http_build_query($inputData);

        $fullUrl = $vnp_Url . "?" . $query . '&vnp_SecureHash=' . $vnpSecureHash;

        \Log::info('VNPAY URL:', ['url' => $fullUrl]);

        return $fullUrl;
    }
}
