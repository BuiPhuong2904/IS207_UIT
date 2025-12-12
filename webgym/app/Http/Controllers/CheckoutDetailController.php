<?php

namespace App\Http\Controllers;

use App\Helpers\PromotionHelper;
use Illuminate\Http\Request;

class CheckoutDetailController extends Controller
{
    public function index(Request $request)
    {
        $cart_items = json_decode($request->input('cart_items'), true) ?? [];
        $promotion_code = strtoupper(trim($request->input('promotion_code', '')));

        // Tính tổng phụ (giá gốc)
        $subtotal_amount = collect($cart_items)->sum(fn($i) => ($i['unit_price'] ?? 0) * ($i['quantity'] ?? 1));
        $item_discount_total = collect($cart_items)->sum(fn($i) => ($i['discount_value'] ?? 0) * ($i['quantity'] ?? 1));

        $promotion_discount = 0;
        $promo_message = '';
        $applied_promo = null;

        if ($promotion_code) {
            $result = PromotionHelper::validateAndApply($promotion_code, $cart_items, $subtotal_amount);

            if ($result['success']) {
                $applied_promo = $result['promo'];
                $calc = $applied_promo['is_percent']
                    ? $subtotal_amount * ($applied_promo['discount_value'] / 100)
                    : $applied_promo['discount_value'];

                $promotion_discount = min($calc, $applied_promo['max_discount']);
                $promo_message = "Đã áp dụng mã {$promotion_code}: {$applied_promo['title']}";
            } else {
                $promo_message = $result['message'];
            }
        }

        $shipping_fee = 30000;
        $total_amount = $subtotal_amount - $item_discount_total - $promotion_discount + $shipping_fee;

        return view('user.checkout-detail', [
            'cart_items'           => $cart_items,
            'promotion_code'       => $promotion_code,
            'applied_promo'        => $applied_promo,
            'promo_message'        => $promo_message,

            'subtotal_amount'      => $subtotal_amount,
            'item_discount_total'  => $item_discount_total,
            'promotion_discount'   => $promotion_discount,
            'shipping_fee'         => $shipping_fee,
            'total_amount'         => $total_amount,
        ]);
    }
}
