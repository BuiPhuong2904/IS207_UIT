<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function vnpayReturn(Request $request)
    {
        if (!$request->has('vnp_ResponseCode')) {
            return redirect()->route('checkout')->with('error', 'Lỗi thanh toán');
        }

        // CHUẨN CHÍNH CHỦ VNPAY – ĐÃ TEST VỚI URL CỦA BẠN
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $input = $request->all();
        $vnp_SecureHash = $input['vnp_SecureHash'] ?? '';
        unset($input['vnp_SecureHash']);
        ksort($input);

        $hashData = "";
        $i = 0;
        foreach ($input as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $checkHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if (strcasecmp($checkHash, $vnp_SecureHash) !== 0) {
            Log::error('VNPAY Return - Chữ ký không hợp lệ', [
                'computed' => $checkHash,
                'received' => $vnp_SecureHash,
                'hashData' => $hashData
            ]);
            return redirect()->route('checkout')->with('error', 'Chữ ký không hợp lệ');
        }

        $orderCode = $input['vnp_TxnRef'];
        $order     = Order::where('order_code', $orderCode)->first();
        $payment   = Payment::where('payment_code', $orderCode)->first();

        if (!$order || !$payment) {
            return redirect()->route('checkout')->with('error', 'Đơn hàng không tồn tại');
        }

        if ($payment->status === 'completed') {
            return redirect()->route('order.thankyou', $orderCode);
        }

        if ($input['vnp_ResponseCode'] === '00') {
            $order->update(['status' => 'processing']);
            $payment->update([
                'status'       => 'completed',
                'method'       => 'vnpay',
                'payment_date' => now(),
            ]);

            return redirect()->route('order.thankyou', $orderCode)
                ->with('success', 'Thanh toán VNPAY thành công! Đơn hàng đang được xử lý.');
        } else {
            $payment->update(['status' => 'failed']);
            $order->update(['status' => 'cancelled']);
            return redirect()->route('checkout')
                ->with('error', 'Thanh toán thất bại');
        }
    }
}
