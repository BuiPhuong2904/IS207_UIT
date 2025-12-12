<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

// Models
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PackageRegistration;
use App\Models\MembershipPackage;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\CartItem;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // 1. Lấy dữ liệu
        $cart_items = json_decode($request->input('cart_items'), true);
        $user = Auth::user();
        
        // Validate
        $request->validate([
            'full_name'      => 'required|string',
            'phone_number'   => 'required|string',
            'address'        => 'required|string',
            'payment_method' => 'required|in:cod,momo,vnpay',
        ]);

        if (empty($cart_items)) return redirect()->route('home')->with('error', 'Dữ liệu trống!');

        DB::beginTransaction();
        try {
            $orderId = null;
            $registrationId = null; 
            $trackingCode = null; 
            
            $totalAmount = $request->input('total_amount');
            $paymentCode = 'PAY-' . strtoupper(Str::random(10));

            // --- PHÂN LOẠI ITEM TRONG GIỎ ---
            $hasMembership = collect($cart_items)->contains('type', 'membership');
            $hasProduct    = collect($cart_items)->contains('type', 'product');

            // 1. XỬ LÝ GÓI TẬP (Lưu vào package_registration)
            if ($hasMembership) {
                // Lấy item gói tập ra 
                $packageItem = collect($cart_items)->firstWhere('type', 'membership');
                $package = MembershipPackage::findOrFail($packageItem['package_id']);

                // Tính thời hạn
                $months = (int) filter_var($packageItem['duration'] ?? '1', FILTER_SANITIZE_NUMBER_INT);
                if($months <= 0) $months = 1;

                $registration = PackageRegistration::create([
                    'user_id'    => $user->id,
                    'package_id' => $package->package_id,
                    'start_date' => Carbon::now(),
                    'end_date'   => Carbon::now()->addMonths($months),
                    'status'     => 'pending', // Chờ thanh toán
                ]);

                $registrationId = $registration->registration_id;
                
                // Nếu chỉ mua gói tập -> Tracking code là mã đăng ký
                if (!$hasProduct) {
                    $trackingCode = 'REG-' . $registrationId;
                }
            } 

            // 2. XỬ LÝ SẢN PHẨM (Lưu vào orders)
            if ($hasProduct) {
                // Gom địa chỉ
                $full_address = $request->address . ($request->apartment_details ? ', '.$request->apartment_details : '');
                
                $order = Order::create([
                    'user_id'          => $user->id,
                    'order_code'       => 'ORD-' . strtoupper(Str::random(8)),
                    'order_date'       => Carbon::now(),
                    'total_amount'     => $hasMembership ? 0 : $totalAmount, 
                    'total_amount'     => $totalAmount, 
                    'status'           => 'pending',
                    'shipping_address' => $full_address,
                    'promotion_code'   => $request->input('promotion_code'),
                    // 'discount_value' => ...
                ]);

                $orderId = $order->order_id;
                $trackingCode = $order->order_code; 

                // Lưu chi tiết đơn hàng
                foreach ($cart_items as $item) {
                    if (($item['type'] ?? '') === 'product') {
                        OrderDetail::create([
                            'order_id'       => $orderId,
                            'variant_id'     => $item['variant_id'],
                            'quantity'       => $item['quantity'],
                            'unit_price'     => $item['unit_price'],
                            'discount_value' => $item['discount_value'] ?? 0,
                            'final_price'    => $item['final_price'],
                        ]);
                    }
                }

                // Xóa giỏ hàng sau khi tạo đơn thành công
                $this->clearUserCart($user->id);
            }

            // 3. TẠO THANH TOÁN (Payment)
            // Xác định loại thanh toán
            $paymentType = 'order';
            if ($hasMembership && !$hasProduct) $paymentType = 'membership_registration';
            if ($hasMembership && $hasProduct)  $paymentType = 'combined';

            Payment::create([
                'user_id'                 => $user->id,
                'payment_code'            => $paymentCode,
                'payment_type'            => $paymentType,
                'amount'                  => $totalAmount,
                'method'                  => $request->payment_method,
                'payment_date'            => Carbon::now(), 
                'status'                  => 'pending',
                
                // Khóa ngoại (Nullable trong DB)
                'order_id'                => $orderId,          
                'package_registration_id' => $registrationId,   
            ]);

            DB::commit(); // Lưu tất cả

            // Chuyển hướng
            return redirect()->route('order.thankyou', ['order_code' => $trackingCode]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // Trang cảm ơn - Hiển thị dựa trên mã
    public function thankYou($order_code)
    {
        $data = ['order_code' => $order_code];

        // Nếu là đơn hàng sản phẩm
        if (str_starts_with($order_code, 'ORD-')) {
            $data['order'] = Order::with('details.product')
                ->where('order_code', $order_code)->first();
            $data['type'] = 'product';
        } 
        // Nếu là đăng ký gói tập
        elseif (str_starts_with($order_code, 'REG-')) {
            $regId = str_replace('REG-', '', $order_code);
            $data['registration'] = PackageRegistration::with('package')
                ->where('registration_id', $regId)->first();
            $data['type'] = 'membership';
        }

        return view('user.thankyou', $data);
    }

    private function clearUserCart($userId)
    {
        $cart = Cart::where('user_id', $userId)->where('status', 'active')->first();
        if ($cart) {
            CartItem::where('cart_id', $cart->cart_id)->delete();
        }
    }
}