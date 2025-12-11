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
    public function __construct()
    {
        $this->middleware('auth'); // Chỉ admin đăng nhập mới vào CRUD
    }

    // Trang danh sách thanh toán (giao diện admin)
    public function index()
    {
        $payments = Payment::with(['user', 'order'])->orderByDesc('payment_id')->paginate(15);
        return view('admin.payment', compact('payments')); // Giả sử view là admin/payment.blade.php, sửa nếu khác
    }

    // API: Lấy 1 thanh toán để edit modal
    public function show($id)
    {
        $payment = Payment::with('user')->findOrFail($id);
        return response()->json([
            'payment_id' => $payment->payment_id,
            'user_name' => $payment->user?->name ?? 'Khách vãng lai',
            'payment_type' => $payment->payment_type,
            'amount' => $payment->amount,
            'method' => $payment->method,
            'payment_date' => $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : null,
            'status' => $payment->status,
            'payment_code' => $payment->payment_code,
        ]);
    }

    // Cập nhật (chỉ update status, các field khác readonly)
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:completed,cancelled', // Chỉ cho phép completed/cancelled như blade
        ]);

        $payment->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật trạng thái thành công!'
        ]);
    }
}
