<?php

namespace App\Http\Controllers;

use App\Helpers\PromotionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutDetailController extends Controller
{
    public function index(Request $request)
    {
        $cart_items = json_decode($request->input('cart_items'), true) ?? [];
        $promotion_code = strtoupper(trim($request->input('promotion_code', '')));

        // TÍNH SUBTOTAL TỪ CART_ITEMS
        $subtotal_amount = collect($cart_items)->sum(function ($item) {
            return ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 1);
        });

        $item_discount_total = collect($cart_items)->sum(function ($item) {
            return ($item['discount_value'] ?? 0) * ($item['quantity'] ?? 1);
        });

        $promotion_discount = 0;
        $promo_message = '';
        $applied_promo = null;

        if ($promotion_code) {
            $result = PromotionHelper::validateAndApply(
                $promotion_code,
                $cart_items,
                $subtotal_amount,
                Auth::id()
            );

            if ($result['success']) {
                $applied_promo = $result;
                $promotion_discount = $result['discount'];
                $promo_message = $result['message'];
            } else {
                $promo_message = $result['message'];
            }
        }

        $shipping_fee = 30000;
        $total_amount = $subtotal_amount - $item_discount_total - $promotion_discount + $shipping_fee;

        return view('user.checkout-detail', compact(
            'cart_items',
            'promotion_code',
            'applied_promo',
            'promo_message',
            'subtotal_amount',           // TRUYỀN BIẾN NÀY
            'item_discount_total',
            'promotion_discount',
            'shipping_fee',
            'total_amount'
        ));
    }
}
