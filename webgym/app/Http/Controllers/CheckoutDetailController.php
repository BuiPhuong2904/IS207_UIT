<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;

class CheckoutDetailController extends Controller
{
    /**
     * Hiển thị trang Thanh toán (Checkout).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Controller chỉ trả về View mà không truyền data.
        // Toàn bộ logic và data được chuyển sang View Blade.
        return view('user.checkout-detail');
    }
}