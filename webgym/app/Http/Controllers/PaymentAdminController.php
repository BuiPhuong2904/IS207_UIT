<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Helpers\PromotionHelper;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentAdminController extends Controller
{
public function index()
{
    return view('admin.payment');
}

}
