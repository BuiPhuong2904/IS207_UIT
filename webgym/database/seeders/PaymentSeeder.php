<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tắt kiểm tra khóa ngoại để truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        DB::table('payment')->truncate();

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Lấy ngày từ các seeder khác
        $today_reg = Carbon::parse('2025-11-14');
        $today_order = Carbon::parse('2025-11-17 09:30:00');

        DB::table('payment')->insert([
            
            // --- 12 THANH TOÁN CHO GÓI TẬP (từ PackageRegistrationSeeder) ---
            // (user_id 11-20 trong file PackageRegistrationSeeder)
            [
                'user_id' => 11,
                'payment_code' => 'PAY-REG-20251114-001',
                'payment_type' => 'membership',
                'amount' => 4599000.00, // Gói 3 (Năm)
                'method' => 'VNPay',
                'payment_date' => $today_reg,
                'status' => 'completed',
                'order_id' => null,
                'package_registration_id' => 1,
                'created_at' => $today_reg,
                'updated_at' => $today_reg,
            ],
            [
                'user_id' => 12,
                'payment_code' => 'PAY-REG-20250930-002',
                'payment_type' => 'membership',
                'amount' => 1199000.00, // Gói 2 (Quý)
                'method' => 'Momo',
                'payment_date' => $today_reg->copy()->subMonths(1)->subDays(15),
                'status' => 'completed',
                'order_id' => null,
                'package_registration_id' => 2,
                'created_at' => $today_reg->copy()->subMonths(1)->subDays(15),
                'updated_at' => $today_reg->copy()->subMonths(1)->subDays(15),
            ],
            [
                'user_id' => 13,
                'payment_code' => 'PAY-REG-20251020-003',
                'payment_type' => 'membership',
                'amount' => 399000.00, // Gói 1 (Tháng)
                'method' => 'Tiền mặt',
                'payment_date' => $today_reg->copy()->subDays(25),
                'status' => 'completed',
                'order_id' => null,
                'package_registration_id' => 3,
                'created_at' => $today_reg->copy()->subDays(25),
                'updated_at' => $today_reg->copy()->subDays(25),
            ],
            [
                'user_id' => 14,
                'payment_code' => 'PAY-REG-20251104-004',
                'payment_type' => 'membership',
                'amount' => 1599000.00, // Gói 4 (PT)
                'method' => 'VNPay',
                'payment_date' => $today_reg->copy()->subDays(10),
                'status' => 'completed',
                'order_id' => null,
                'package_registration_id' => 4,
                'created_at' => $today_reg->copy()->subDays(10),
                'updated_at' => $today_reg->copy()->subDays(10),
            ],
            [
                'user_id' => 15,
                'payment_code' => 'PAY-REG-20250925-005',
                'payment_type' => 'membership',
                'amount' => 1199000.00, // Gói 2 (Quý)
                'method' => 'Momo',
                'payment_date' => $today_reg->copy()->subDays(50),
                'status' => 'completed',
                'order_id' => null,
                'package_registration_id' => 5,
                'created_at' => $today_reg->copy()->subDays(50),
                'updated_at' => $today_reg->copy()->subDays(50),
            ],
            [
                'user_id' => 16,
                'payment_code' => 'PAY-REG-20250514-006',
                'payment_type' => 'membership',
                'amount' => 4599000.00, // Gói 3 (Năm)
                'method' => 'VNPay',
                'payment_date' => $today_reg->copy()->subMonths(6),
                'status' => 'completed',
                'order_id' => null,
                'package_registration_id' => 6,
                'created_at' => $today_reg->copy()->subMonths(6),
                'updated_at' => $today_reg->copy()->subMonths(6),
            ],
            [
                'user_id' => 17,
                'payment_code' => 'PAY-REG-20251114-007',
                'payment_type' => 'membership',
                'amount' => 800000.00, // Gói 6 (10 Buổi)
                'method' => 'VNPay',
                'payment_date' => $today_reg,
                'status' => 'completed',
                'order_id' => null,
                'package_registration_id' => 7,
                'created_at' => $today_reg,
                'updated_at' => $today_reg,
            ],
            [
                'user_id' => 18,
                'payment_code' => 'PAY-REG-20251114-008',
                'payment_type' => 'membership',
                'amount' => 1599000.00, // Gói 4 (PT)
                'method' => 'VNPay',
                'payment_date' => $today_reg,
                'status' => 'completed',
                'order_id' => null,
                'package_registration_id' => 8,
                'created_at' => $today_reg,
                'updated_at' => $today_reg,
            ],
            [
                'user_id' => 19,
                'payment_code' => 'PAY-REG-20251114-009',
                'payment_type' => 'membership',
                'amount' => 50000.00, // Gói 5 (Tập Lẻ)
                'method' => 'Tiền mặt',
                'payment_date' => $today_reg,
                'status' => 'completed',
                'order_id' => null,
                'package_registration_id' => 9,
                'created_at' => $today_reg,
                'updated_at' => $today_reg,
            ],
            [
                'user_id' => 20,
                'payment_code' => 'PAY-REG-20250914-010',
                'payment_type' => 'membership',
                'amount' => 1199000.00, // Gói 2 (Quý)
                'method' => 'Momo',
                'payment_date' => $today_reg->copy()->subMonths(2),
                'status' => 'completed',
                'order_id' => null,
                'package_registration_id' => 10,
                'created_at' => $today_reg->copy()->subMonths(2),
                'updated_at' => $today_reg->copy()->subMonths(2),
            ],
            [
                'user_id' => 11,
                'payment_code' => 'PAY-REG-20250914-011',
                'payment_type' => 'membership',
                'amount' => 399000.00, // Gói 1 (Hết hạn)
                'method' => 'VNPay',
                'payment_date' => $today_reg->copy()->subMonths(2),
                'status' => 'completed',
                'order_id' => null,
                'package_registration_id' => 11,
                'created_at' => $today_reg->copy()->subMonths(2),
                'updated_at' => $today_reg->copy()->subMonths(2),
            ],
            [
                'user_id' => 14,
                'payment_code' => 'PAY-REG-20250814-012',
                'payment_type' => 'membership',
                'amount' => 1599000.00, // Gói 4 (Hết hạn)
                'method' => 'Momo',
                'payment_date' => $today_reg->copy()->subMonths(3),
                'status' => 'completed',
                'order_id' => null,
                'package_registration_id' => 12,
                'created_at' => $today_reg->copy()->subMonths(3),
                'updated_at' => $today_reg->copy()->subMonths(3),
            ],

            // --- 12 THANH TOÁN CHO ĐƠN HÀNG (từ OrderSeeder) ---
            
            [
                'user_id' => 25,
                'payment_code' => 'PAY-ORD-20251110-001',
                'payment_type' => 'order',
                'amount' => 849000.00, // Order 1
                'method' => 'VNPay',
                'payment_date' => $today_order->copy()->subDays(5),
                'status' => 'completed',
                'order_id' => 1,
                'package_registration_id' => null,
                'created_at' => $today_order->copy()->subDays(5),
                'updated_at' => $today_order->copy()->subDays(5),
            ],
            [
                'user_id' => 28,
                'payment_code' => 'PAY-ORD-20251114-002',
                'payment_type' => 'order',
                'amount' => 2200000.00, // Order 2
                'method' => 'VNPay',
                'payment_date' => $today_order->copy()->subDay(),
                'status' => 'completed',
                'order_id' => 2,
                'package_registration_id' => null,
                'created_at' => $today_order->copy()->subDay(),
                'updated_at' => $today_order->copy()->subDay(),
            ],
            [
                'user_id' => 27,
                'payment_code' => 'PAY-ORD-20251115-003',
                'payment_type' => 'order',
                'amount' => 909000.00, // Order 3
                'method' => 'VNPay',
                'payment_date' => $today_order,
                'status' => 'pending', // Đơn hàng đang pending
                'order_id' => 3,
                'package_registration_id' => null,
                'created_at' => $today_order,
                'updated_at' => $today_order,
            ],
            [
                'user_id' => 32,
                'payment_code' => 'PAY-ORD-20251108-004',
                'payment_type' => 'order',
                'amount' => 750000.00, // Order 4
                'method' => 'VNPay',
                'payment_date' => $today_order->copy()->subWeek(),
                'status' => 'failed', // Đơn hàng bị cancelled
                'order_id' => 4,
                'package_registration_id' => null,
                'created_at' => $today_order->copy()->subWeek(),
                'updated_at' => $today_order->copy()->subWeek(),
            ],
            [
                'user_id' => 26,
                'payment_code' => 'PAY-ORD-20251108-005',
                'payment_type' => 'order',
                'amount' => 399000.00, // Order 5
                'method' => 'COD', // Giao hàng thu tiền
                'payment_date' => $today_order->copy()->subWeek()->addDays(2), // Thanh toán khi nhận hàng
                'status' => 'completed',
                'order_id' => 5,
                'package_registration_id' => null,
                'created_at' => $today_order->copy()->subWeek(),
                'updated_at' => $today_order->copy()->subWeek()->addDays(2),
            ],
            [
                'user_id' => 29,
                'payment_code' => 'PAY-ORD-20251113-006',
                'payment_type' => 'order',
                'amount' => 1420000.00, // Order 6
                'method' => 'Momo',
                'payment_date' => $today_order->copy()->subDays(2),
                'status' => 'completed',
                'order_id' => 6,
                'package_registration_id' => null,
                'created_at' => $today_order->copy()->subDays(2),
                'updated_at' => $today_order->copy()->subDays(2),
            ],
            [
                'user_id' => 30,
                'payment_code' => 'PAY-ORD-20251114-007',
                'payment_type' => 'order',
                'amount' => 1318000.00, // Order 7
                'method' => 'VNPay',
                'payment_date' => $today_order->copy()->subDay(),
                'status' => 'completed', // Đã thanh toán, đang processing
                'order_id' => 7,
                'package_registration_id' => null,
                'created_at' => $today_order->copy()->subDay(),
                'updated_at' => $today_order->copy()->subDay(),
            ],
            [
                'user_id' => 31,
                'payment_code' => 'PAY-ORD-20251115-008',
                'payment_type' => 'order',
                'amount' => 1020000.00, // Order 8
                'method' => 'VNPay',
                'payment_date' => $today_order->copy()->subHour(),
                'status' => 'pending', // Đơn hàng đang pending
                'order_id' => 8,
                'package_registration_id' => null,
                'created_at' => $today_order->copy()->subHour(),
                'updated_at' => $today_order->copy()->subHour(),
            ],
            [
                'user_id' => 33,
                'payment_code' => 'PAY-ORD-20251112-009',
                'payment_type' => 'order',
                'amount' => 1800000.00, // Order 9
                'method' => 'VNPay',
                'payment_date' => $today_order->copy()->subDays(3),
                'status' => 'failed', // Đơn hàng bị cancelled
                'order_id' => 9,
                'package_registration_id' => null,
                'created_at' => $today_order->copy()->subDays(3),
                'updated_at' => $today_order->copy()->subDays(3),
            ],
            [
                'user_id' => 34,
                'payment_code' => 'PAY-ORD-20251105-010',
                'payment_type' => 'order',
                'amount' => 2600000.00, // Order 10
                'method' => 'VNPay',
                'payment_date' => $today_order->copy()->subDays(10),
                'status' => 'completed',
                'order_id' => 10,
                'package_registration_id' => null,
                'created_at' => $today_order->copy()->subDays(10),
                'updated_at' => $today_order->copy()->subDays(10),
            ],
            [
                'user_id' => 25,
                'payment_code' => 'PAY-ORD-20251116-011',
                'payment_type' => 'order',
                'amount' => 1650000.00, // Order 11
                'method' => 'VNPay',
                'payment_date' => $today_order->copy()->subDay(),
                'status' => 'completed', // Đã thanh toán, đơn đang 'processing'
                'order_id' => 11,
                'package_registration_id' => null,
                'created_at' => $today_order->copy()->subDay(),
                'updated_at' => $today_order->copy()->subDay(),
            ],
            [
                'user_id' => 32,
                'payment_code' => 'PAY-ORD-20251111-012',
                'payment_type' => 'order',
                'amount' => 1450000.00, // Order 12
                'method' => 'Momo',
                'payment_date' => $today_order->copy()->subDays(4),
                'status' => 'completed', // Đơn đã 'completed'
                'order_id' => 12,
                'package_registration_id' => null,
                'created_at' => $today_order->copy()->subDays(4),
                'updated_at' => $today_order->copy()->subDays(4),
            ],

        ]);
    }
}