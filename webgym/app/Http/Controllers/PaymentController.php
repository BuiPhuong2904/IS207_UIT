<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;

use App\Models\User;
use App\Models\PackageRegistration;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderInvoiceMail;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function vnpayReturn(Request $request)
    {
        if (!$request->has('vnp_ResponseCode')) {
            return redirect()->route('checkout')->with('error', 'Lỗi thanh toán');
        }

        // CHUẨN CHÍNH CHỦ VNPAY
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

        $refCode = $input['vnp_TxnRef'];

        $order = null;
        $registration = null;
        $payment = null;

        if (Str::startsWith($refCode, 'ORD')) {
            // Trường hợp 1: Mua sản phẩm (Có tạo Order)
            $order = Order::where('order_code', $refCode)->first();
            if ($order) {
                $payment = Payment::where('order_id', $order->order_id)->first();
            }
        } elseif (Str::startsWith($refCode, 'REG')) {
            // Trường hợp 2: Chỉ mua gói tập (Không có Order, chỉ có PackageRegistration)
            $regId = str_replace('REG-', '', $refCode);
            $registration = PackageRegistration::where('registration_id', $regId)->first();
            if ($registration) {
                $payment = Payment::where('package_registration_id', $registration->registration_id)->first();
            }
        }

        // Nếu không tìm thấy đối tượng nào
        if ((!$order && !$registration) || !$payment) {
            Log::error('VNPAY Return - Không tìm thấy đơn hàng/thanh toán', ['refCode' => $refCode]);
            return redirect()->route('checkout')->with('error', 'Đơn hàng hoặc thông tin thanh toán không tồn tại.');
        }

        // Nếu đã thanh toán rồi thì redirect luôn
        if ($payment->status === 'completed') {
            return redirect()->route('order.thankyou', $refCode);
        }

        // Xử lý kết quả trả về từ VNPAY
        if ($input['vnp_ResponseCode'] === '00') {
            // --- THANH TOÁN THÀNH CÔNG ---
            
            // Cập nhật Payment
            $payment->update([
                'status'       => 'completed',
                'method'       => 'vnpay',
                'payment_date' => now('Asia/Ho_Chi_Minh'),
            ]);

            // Cập nhật Order
            if ($order) {
                $order->update(['status' => 'pending']);
            }

            // --- GỬI EMAIL ---
            try {
                $hasProduct    = $order ? true : false;
                $hasMembership = $registration ? true : false;

                $targetType = 'order';
                if ($hasMembership && !$hasProduct) $targetType = 'membership';
                if ($hasMembership && $hasProduct)  $targetType = 'combined';

                $mailItems = [];

                // Lấy items từ Order 
                if ($hasProduct) {
                    $order->load(['user', 'details.product.product']); 

                    foreach ($order->details as $detail) {
                        // Lấy variant từ quan hệ
                        $variant = $detail->product; 
                        $productParent = $variant ? $variant->product : null;

                        $mailItems[] = [
                            'name'           => $productParent ? $productParent->name : 'Sản phẩm',
                            'variant'        => $variant ? ($variant->color ?? $variant->size ?? '') : '', 
                            'quantity'       => $detail->quantity,
                            'unit_price'     => $detail->unit_price,
                            'discount_value' => $detail->discount_value,
                            'weight'         => $variant ? $variant->weight : null,
                            'unit'           => $variant ? $variant->unit : null,
                            'type'           => 'order'
                        ];
                    }
                }

                $mainObj = $order ?? $registration;
                $user    = $mainObj->user; 
                
                $address = $order ? $order->shipping_address : ($user->address ?? 'N/A');

                $shippingFee = 30000;
                $totalAmount = $payment->amount;
                
                $discountValue = $order ? $order->discount_value : 0;
                $promotionCode = $order ? $order->promotion_code : null;
                
                $subtotal = $totalAmount + $discountValue - $shippingFee;

                $mailData = [
                    'order_code'     => $refCode,
                    'customer_name'  => $user->full_name ?? 'Khách hàng vãng lai',
                    'email'          => $user->email,
                    'phone_number'   => $user->phone_number ?? '',
                    'address'        => $address,
                    'total_amount'   => $totalAmount,
                    'payment_method' => 'VNPAY', 
                    'date'           => now('Asia/Ho_Chi_Minh')->format('d/m/Y H:i'),
                    'items'          => $mailItems,
                    'target_type'    => $targetType,
                    'subtotal'       => $subtotal,
                    'discount_value' => $discountValue,
                    'promotion_code' => $promotionCode,
                ];

                if ($user && $user->email) {
                    Mail::to($user->email)->send(new OrderInvoiceMail($mailData));
                }

            } catch (\Exception $e) {
                Log::error("LỖI GỬI EMAIL VNPAY: " . $e->getMessage());
            }

            // Cập nhật PackageRegistration
            if ($registration) {
                $registration->update(['status' => 'active']);
            }

            return redirect()->route('order.thankyou', $refCode)
                ->with('success', 'Thanh toán VNPAY thành công!');

        } else {
            // --- THANH TOÁN THẤT BẠI ---
            
            $payment->update(['status' => 'failed']);
            
            if ($order) {
                $order->update(['status' => 'cancelled']);
            }

            if ($registration) {
                $registration->update(['status' => 'pending']);
            }

            return redirect()->route('checkout')
                ->with('error', 'Giao dịch thanh toán bị hủy hoặc thất bại.');
        }
    }
}
