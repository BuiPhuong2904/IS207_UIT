<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders');
    }


    // Trang success sau khi thanh toán (COD hoặc callback VNPay/MoMo)
    public function success($order_id)
    {
        $order = Order::findOrFail($order_id);

        // Kiểm tra quyền (nếu có đăng nhập)
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return redirect()->route('order.history')
            ->with('payment_success', "Thanh toán thành công! Đơn hàng #{$order->order_code} đã được xác nhận.");
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'      => 'required',
            'phone_number'   => 'required',
            'email'          => 'required|email',
            'address'        => 'required',
            'payment_method' => 'required|in:vnpay,momo,cod',
            'cart_items'     => 'required',
        ]);

        $cart_items     = json_decode($request->cart_items, true);
        $promotion_code = strtoupper(trim($request->promotion_code ?? ''));

        // Tính tiền (đã có PromotionHelper validate)
        $subtotal = collect($cart_items)->sum(fn($i) => $i['unit_price'] * $i['quantity']);
        $item_discount = collect($cart_items)->sum(fn($i) => ($i['discount_value'] ?? 0) * $i['quantity']);

        $promo_discount = 0;
        if ($promotion_code) {
            $result = \App\Helpers\PromotionHelper::validateAndApply($promotion_code, $cart_items, $subtotal);
            $promo_discount = $result['success'] ? $result['discount'] : 0;
        }

        $shipping_fee = 30000;
        $total = $subtotal - $item_discount - $promo_discount + $shipping_fee;

        // Tạo mã đơn + mã thanh toán
        $order_code = 'ORD' . now()->format('Ymd') . str_pad(Order::count() + 1, 4, '0', STR_PAD_LEFT);
        $payment_code = strtoupper($request->payment_method) . now()->format('YmdHis') . rand(100, 999);

        DB::beginTransaction();
        try {
            // 1. Tạo Order (pending)
            $order = Order::create([
                'user_id'          => 1,
                'order_code'       => $order_code,
                'order_date'       => now(),
                'total_amount'     => $total,
                'status'           => 'pending',
                'shipping_address' => $request->address . ($request->apartment_details ? ', ' . $request->apartment_details : ''),
                'discount_value'   => $item_discount + $promo_discount,
                'promotion_code'   => $promotion_code ?: null,
            ]);

            // 2. Tạo Payment (pending)
            $payment = \App\Models\Payment::create([
                'user_id'      => Auth::id() ?? null,
                'order_id'     => $order->order_id,
                'payment_code' => $payment_code,
                'amount'       => $total,
                'method'       => $request->payment_method,
                'status'       => 'pending',
                'payment_date' => now(),
            ]);

            // 3. Lưu tạm giỏ hàng vào session để dùng sau (nếu cần)
            session([
                'pending_order_id' => $order->order_id,
                'pending_payment_id' => $payment->payment_id,
                'cart_items' => $cart_items,
            ]);

            DB::commit();

            // 4. Redirect sang cổng thanh toán
            if ($request->payment_method === 'vnpay') {
                return redirect()->route('payment.vnpay.create', $payment->payment_id);
            } elseif ($request->payment_method === 'momo') {
                return redirect()->route('payment.momo.create', $payment->payment_id);
            } elseif ($request->payment_method === 'cod') {
                // COD → coi như thành công luôn
                return redirect()->route('order.success', $order->order_id);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại!');
        }
    }
}
