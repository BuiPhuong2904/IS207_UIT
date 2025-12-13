<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Trang danh sách thanh toán (giao diện admin)
    public function index(Request $request)
    {
        // Khởi tạo Query Builder
        $query = Payment::with(['user', 'order']);

        // 1. Lọc theo Khoảng thời gian (Ngày thanh toán)
        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        // 2. Lọc theo Số tiền (Amount)
        if ($request->filled('price_from')) {
            $query->where('amount', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $query->where('amount', '<=', $request->price_to);
        }

        // 3. Lọc theo Trạng thái
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Sắp xếp và Phân trang (giữ lại tham số lọc trên URL khi bấm trang 2, 3...)
        $payments = $query->orderBy('payment_id', 'desc')
                        ->paginate(10)
                        ->appends($request->all());
        
        return view('admin.payment', compact('payments')); 
    }

    // API: Lấy 1 thanh toán để edit modal
    public function show($id)
    {
        $payment = Payment::with('user')->findOrFail($id);
        
        return response()->json([
            'payment_id'   => $payment->payment_id,
            'payment_code' => $payment->payment_code,
            
            // Lấy thông tin User
            // Sử dụng full_name theo DB schema của bạn
            'user_name'    => $payment->user ? $payment->user->full_name : 'Khách vãng lai',
            
            // Lấy số điện thoại để hiển thị trong Modal
            'user_phone'   => $payment->user ? $payment->user->phone : 'Chưa cập nhật',
            
            'payment_type' => $payment->payment_type,
            'amount'       => $payment->amount,
            'method'       => $payment->method,
            
            // Format ngày giờ đầy đủ cho chi tiết
            'payment_date' => $payment->payment_date ? Carbon::parse($payment->payment_date)->format('Y-m-d H:i:s') : null,
            
            'status'       => $payment->status,
        ]);
    }

    // Cập nhật (chỉ update status)
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:completed,cancelled,pending,refunded', 
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