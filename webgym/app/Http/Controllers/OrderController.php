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
            'full_name'      => 'required|string|max:255',
            'phone_number'   => 'required|string|max:20',
            'address'        => 'required|string',
            'email'          => 'required|email',
            'payment_method' => 'required|in:cod,momo,vnpay',
            'cart_items'     => 'required|json',
            'total_amount'   => 'required|numeric|min:0',
            'promotion_code' => 'nullable|string|max:30',
            'apartment_details' => 'nullable|string',
        ]);

        $cartItems = json_decode($request->cart_items, true);
        if (empty($cartItems)) {
            return back()->withErrors(['cart_items' => 'Giỏ hàng trống!'])->withInput();
        }

        // Tính lại tổng tiền
        $totals = $this->recalculateTotal($cartItems, $request->promotion_code);
        $recalculatedTotal = $totals['total'];

        if (abs($recalculatedTotal - $request->total_amount) > 100) {
            return back()
                ->withErrors(['total_amount' => 'Số tiền không hợp lệ. Vui lòng tải lại trang!'])
                ->withInput($request->except('total_amount'));
        }

        $orderCode = null;

        try {
            DB::transaction(function () use ($request, $cartItems, $totals, &$orderCode) {
                // 1. Tạo Order
                $order = Order::create([
                    'user_id'          => Auth::id(),
                    'order_date'       => now(),
                    'order_code'       => 'ORD-' . strtoupper(uniqid()),
                    'total_amount'     => $totals['total'],
                    'status'           => 'pending',
                    'shipping_address' => $request->address . ($request->apartment_details ? ', ' . $request->apartment_details : ''),
                    'discount_value'   => $totals['item_discount'] + $totals['promotion_discount'],
                    'promotion_code'   => $request->promotion_code ?? null,
                ]);

                $orderCode = $order->order_code;
                $lastRegistrationId = null;

                // 2. Tạo OrderDetail (sản phẩm vật lý)
                foreach ($cartItems as $item) {
                    if (empty($item['type']) || $item['type'] !== 'membership') {
                        OrderDetail::create([
                            'order_id'       => $order->order_id,
                            'variant_id'     => $item['variant_id'],
                            'quantity'       => $item['quantity'] ?? 1,
                            'unit_price'     => (float)$item['unit_price'],
                            'discount_value' => (float)($item['discount_value'] ?? 0),
                            'final_price'    => (float)($item['final_price'] ?? $item['unit_price']),
                        ]);
                    }
                }

                // 3. Tạo PackageRegistration (gói tập)
                foreach ($cartItems as $item) {
                    if (!empty($item['type']) && $item['type'] === 'membership') {
                        $package = MembershipPackage::findOrFail($item['package_id']);

                        $startDate = Carbon::now();
                        $endDate = $package->duration_months == 0
                            ? $startDate->copy()->endOfDay()
                            : $startDate->copy()->addMonths($package->duration_months);

                        $reg = PackageRegistration::create([
                            'user_id'     => Auth::id(),
                            'package_id'  => $package->package_id,
                            'start_date'  => $startDate,
                            'end_date'    => $endDate,
                            'status'      => 'active',
                        ]);

                        $lastRegistrationId = $reg->registration_id;
                    }
                }

                // 4. Tạo Payment - method động
                Payment::create([
                    'user_id'                 => Auth::id(),
                    'payment_type'            => 'order',
                    'payment_code'            => $order->order_code, // ← quan trọng: dùng làm TxnRef
                    'amount'                  => $order->total_amount,
                    'method'                  => $request->payment_method, // cod | vnpay | momo
                    'payment_date'            => null,
                    'status'                  => 'pending',
                    'order_id'                => $order->order_id,
                    'package_registration_id'=> $lastRegistrationId,
                ]);

                // 5. Xóa giỏ hàng
                $cart = Cart::where('user_id', Auth::id())->first();
                if ($cart) {
                    CartItem::where('cart_id', $cart->cart_id)->delete();
                }
            });

            // Sau khi tạo đơn thành công → xử lý theo phương thức thanh toán
            if ($request->payment_method === 'cod') {
                // Cập nhật trạng thái đơn hàng và payment giống hệt VNPAY thành công
                $order   = Order::where('order_code', $orderCode)->firstOrFail();
                $payment = Payment::where('payment_code', $orderCode)->firstOrFail();

                $order->update([
                    'status' => 'processing'   // hoặc 'confirmed' tùy flow của bạn
                ]);

                $payment->update([
                    'status'       => 'processing',   // COD coi như đã thanh toán ngay
                    'method'       => 'cod',
                    'payment_date' => now(),
                ]);

                return redirect()
                    ->route('order.thankyou', $orderCode)
                    ->with('success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ giao hàng sớm nhất .');
            } elseif ($request->payment_method === 'vnpay') {
                $vnpayUrl = $this->createVnpayUrl($orderCode, $totals['total'], $request->ip());
                return redirect()->away($vnpayUrl);   // ← redirect thẳng sang VNPAY
            }

            // momo để sau nếu cần
            return back()->withErrors(['error' => 'Phương thức thanh toán chưa hỗ trợ.']);

        } catch (\Exception $e) {
            Log::error('Checkout failed: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request' => $request->all(),
            ]);

            return back()
                ->withErrors(['error' => 'Có lỗi xảy ra. Vui lòng thử lại.'])
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
