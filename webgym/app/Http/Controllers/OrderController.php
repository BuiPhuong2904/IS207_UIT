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

        // Tính lại tổng tiền (đã chuẩn như CheckoutDetailController)
        $totals = $this->recalculateTotal($cartItems, $request->promotion_code);
        $recalculatedTotal = $totals['total'];

        // Chống cheat – nới lỏng 1 chút để tránh lỗi float 0.01đ
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
                            'variant_id'     => $item['variant_id'],           // ← đúng key frontend gửi
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

                // 4. Tạo Payment (COD)
                Payment::create([
                    'user_id'                 => Auth::id(),
                    'payment_type'            => 'order',
                    'payment_code'            => $order->order_code,
                    'amount'                  => $order->total_amount,
                    'method'                  => 'cod',
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

            return redirect()
                ->route('order.thankyou', $orderCode)
                ->with('success', 'Đặt hàng thành công!');

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

    // Trang cảm ơn
    public function thankYou($orderCode)
    {
        $order = Order::with(['details.product', 'payment'])
            ->where('order_code', $orderCode)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Lấy gói tập vừa mua (trong 15 phút gần nhất)
        $registrations = PackageRegistration::where('user_id', Auth::id())
            ->where('created_at', '>=', now()->subMinutes(15))
            ->with('package')
            ->latest()
            ->get();

        return view('user.thankyou', compact('order', 'registrations'));
    }

    // Hàm tính lại tổng tiền (dùng PromotionHelper)
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
            $result = PromotionHelper::validateAndApply($promotionCode, $cartItems, $subtotal); // ← dùng subtotal gốc
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
}
