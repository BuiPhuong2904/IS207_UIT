<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tắt kiểm tra khóa ngoại để truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Xóa sạch dữ liệu
        DB::table('order_detail')->truncate();
        DB::table('order')->truncate();

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Giả định hôm nay 
        $today = Carbon::parse('2025-12-15 09:30:00');

        // === ĐƠN HÀNG 1: ĐÃ HOÀN THÀNH (COMPLETED) ===
        // User 25 (Vũ Thị Ngọc) mua đồ tập Yoga
        $order1_details = [
            [
                'variant_id' => 2, // Thảm tập Yoga (Tím) - 399k
                'quantity' => 1,
                'unit_price' => 399000.00,
                'discount_value' => 0,
                'final_price' => (399000.00 * 1) - 0,
            ],
            [
                'variant_id' => 30, // Quần Legging Nữ (Xám, M) - 450k
                'quantity' => 1,
                'unit_price' => 450000.00,
                'discount_value' => 0,
                'final_price' => (450000.00 * 1) - 0,
            ]
        ];
        $order1_total_amount = collect($order1_details)->sum('final_price'); // 849.000
        $order1_total_discount = 0;
        
        $order1_id = DB::table('order')->insertGetId([
            'user_id' => 25, // Vũ Thị Ngọc
            'order_code' => 'GYM-20251110-ABC111',
            'order_date' => $today->copy()->subDays(5),
            'total_amount' => $order1_total_amount - $order1_total_discount,
            'status' => 'completed',
            'shipping_address' => 'Số 22, Đường Trần Phú, Phường Điện Biên, Thành phố Hà Nội',
            'discount_value' => $order1_total_discount,
            'promotion_code' => null,
            'created_at' => $today->copy()->subDays(5),
            'updated_at' => $today->copy()->subDays(4),
        ]);
        foreach ($order1_details as &$detail) {
            $detail['order_id'] = $order1_id;
        }
        DB::table('order_detail')->insert($order1_details);

        // === ĐƠN HÀNG 2: ĐANG XỬ LÝ (PROCESSING) ===
        // User 28 (Lý Văn Sang) mua thực phẩm bổ sung
        $order2_details = [
            [
                'variant_id' => 16, // Whey Protein (Vị Choco, 5 Lbs) - 1.550k
                'quantity' => 1,
                'unit_price' => 1550000.00, 
                'discount_value' => 0,
                'final_price' => (1550000.00 * 1) - 0,
            ],
            [
                'variant_id' => 17, // C4 Pre-Workout (Icy Blue) - 750k
                'quantity' => 1,
                'unit_price' => 750000.00,
                'discount_value' => 0,
                'final_price' => (750000.00 * 1) - 0,
            ]
        ];
        
        $order2_subtotal = collect($order2_details)->sum('final_price'); // 2.300.000
        $order2_total_discount = 100000.00; // Giảm 100k toàn đơn
        
        $order2_id = DB::table('order')->insertGetId([
            'user_id' => 28, // Lý Văn Sang
            'order_code' => 'GYM-20251114-DEF222',
            'order_date' => $today->copy()->subDay(),
            'total_amount' => $order2_subtotal - $order2_total_discount, // 2.200.000
            'status' => 'processing',
            'shipping_address' => 'Số 55, Đường Hùng Vương, Phường Vĩnh Trung, Thành phố Đà Nẵng',
            'discount_value' => $order2_total_discount,
            'promotion_code' => 'SALE100K',
            'created_at' => $today->copy()->subDay(),
            'updated_at' => $today->copy()->subDay(),
        ]);
        foreach ($order2_details as &$detail) {
            $detail['order_id'] = $order2_id;
        }
        DB::table('order_detail')->insert($order2_details);

        // === ĐƠN HÀNG 3: ĐANG CHỜ (PENDING) ===
        // User 27 (Trần Thị Quỳnh) mua 3 món (tạ, dây, túi)
        $order3_details = [
            [
                'variant_id' => 1, // Tạ Kettebell (Hồng, 4kg) - 220k
                'quantity' => 2,
                'unit_price' => 220000.00,
                'discount_value' => 0,
                'final_price' => (220000.00 * 2) - 0, // 440.000
            ],
            [
                'variant_id' => 4, // Dây nhảy (Đỏ) - 149k
                'quantity' => 1,
                'unit_price' => 149000.00, 
                'discount_value' => 0, 
                'final_price' => (149000.00 * 1) - 0, // 149.000
            ],
            [
                'variant_id' => 38, // Túi đựng đồ (Xám) - 320k
                'quantity' => 1,
                'unit_price' => 320000.00,
                'discount_value' => 0,
                'final_price' => (320000.00 * 1) - 0, // 320.000
            ]
        ];
        
        $order3_total_amount = collect($order3_details)->sum('final_price'); // 909.000
        $order3_total_discount = 0;
        
        $order3_id = DB::table('order')->insertGetId([
            'user_id' => 27, // Trần Thị Quỳnh
            'order_code' => 'GYM-20251115-GHI333',
            'order_date' => $today, 
            'total_amount' => $order3_total_amount - $order3_total_discount,
            'status' => 'pending',
            'shipping_address' => 'Số 44, Đường Phan Đình Phùng, Phường Tân Định, TP.HCM',
            'discount_value' => $order3_total_discount,
            'promotion_code' => null,
            'created_at' => $today,
            'updated_at' => $today,
        ]);
        foreach ($order3_details as &$detail) {
            $detail['order_id'] = $order3_id;
        }
        DB::table('order_detail')->insert($order3_details);

        // === ĐƠN HÀNG 4: ĐÃ HỦY (CANCELLED) ===
        // User 32 (Trịnh Văn Bình) mua 1 món 
        $order4_details = [
            [
                'variant_id' => 17, // C4 Pre-Workout (Icy Blue) - 750k
                'quantity' => 1,
                'unit_price' => 750000.00,
                'discount_value' => 0,
                'final_price' => (750000.00 * 1) - 0,
            ]
        ];
        
        $order4_total_amount = collect($order4_details)->sum('final_price'); // 750.000
        $order4_total_discount = 0;
        
        $order4_id = DB::table('order')->insertGetId([
            'user_id' => 32, // Trịnh Văn Bình
            'order_code' => 'GYM-20251108-JKL444',
            'order_date' => $today->copy()->subWeek(), 
            'total_amount' => $order4_total_amount - $order4_total_discount,
            'status' => 'cancelled',
            'shipping_address' => 'Số 99, Đường Phạm Văn Đồng, Phường Mai Dịch, Thành phố Hà Nội',
            'discount_value' => $order4_total_discount,
            'promotion_code' => null,
            'created_at' => $today->copy()->subWeek(),
            'updated_at' => $today->copy()->subWeek()->addDay(),
        ]);
        foreach ($order4_details as &$detail) {
            $detail['order_id'] = $order4_id;
        }
        DB::table('order_detail')->insert($order4_details);

        // === ĐƠN HÀNG 5: (COMPLETED) ===
        // User 26 (Đỗ Văn Phúc) mua găng tay và bình nước
        $order5_details = [
            [
                'variant_id' => 39, // Găng tay tập Gym (L) - 250k
                'quantity' => 1,
                'unit_price' => 250000.00,
                'discount_value' => 0,
                'final_price' => (250000.00 * 1) - 0,
            ],
            [
                'variant_id' => 37, // Bình nước La Pro (Đen, 1500ml) - 149k
                'quantity' => 1,
                'unit_price' => 149000.00,
                'discount_value' => 0,
                'final_price' => (149000.00 * 1) - 0,
            ]
        ];
        $order5_total_amount = collect($order5_details)->sum('final_price'); // 399.000
        $order5_total_discount = 0;
        
        $order5_id = DB::table('order')->insertGetId([
            'user_id' => 26, // Đỗ Văn Phúc
            'order_code' => 'GYM-20251108-MNO555',
            'order_date' => $today->copy()->subWeek(),
            'total_amount' => $order5_total_amount - $order5_total_discount,
            'status' => 'completed',
            'shipping_address' => 'Số 33, Đường Lý Thái Tổ, Phường Hàng Trống, Thành phố Hà Nội',
            'discount_value' => $order5_total_discount,
            'promotion_code' => null,
            'created_at' => $today->copy()->subWeek(),
            'updated_at' => $today->copy()->subWeek()->addDays(2), 
        ]);
        foreach ($order5_details as &$detail) {
            $detail['order_id'] = $order5_id;
        }
        DB::table('order_detail')->insert($order5_details);

        // === ĐƠN HÀNG 6: (COMPLETED) ===
        // User 29 (Phan Thị Thảo) mua 2 hộp TPCN
        $order6_details = [
            [
                'variant_id' => 18, // Dầu cá Omega 3 - 450k
                'quantity' => 2,
                'unit_price' => 450000.00,
                'discount_value' => 0,
                'final_price' => (450000.00 * 2) - 0, // 900.000
            ],
            [
                'variant_id' => 19, // Vitamin Opti-Men - 550k
                'quantity' => 1,
                'unit_price' => 550000.00,
                'discount_value' => 0,
                'final_price' => (550000.00 * 1) - 0, // 550.000
            ]
        ];
        $order6_subtotal = collect($order6_details)->sum('final_price'); // 1.450.000
        $order6_total_discount = 30000.00; // Giảm 30k (freeship)
        
        $order6_id = DB::table('order')->insertGetId([
            'user_id' => 29, // Phan Thị Thảo
            'order_code' => 'GYM-20251113-PQR666',
            'order_date' => $today->copy()->subDays(2),
            'total_amount' => $order6_subtotal - $order6_total_discount, // 1.420.000
            'status' => 'completed',
            'shipping_address' => 'Số 66, Đường Trần Hưng Đạo, Phường Sài Gòn, TP.HCM',
            'discount_value' => $order6_total_discount,
            'promotion_code' => 'FREESHIP',
            'created_at' => $today->copy()->subDays(2),
            'updated_at' => $today->copy()->subDay(),
        ]);
        foreach ($order6_details as &$detail) {
            $detail['order_id'] = $order6_id;
        }
        DB::table('order_detail')->insert($order6_details);

        // === ĐƠN HÀNG 7: (PROCESSING) ===
        // User 30 (Võ Văn Tiến) mua đồ tập 
        $order7_details = [
            [
                'variant_id' => 40, // Đai lưng (L) - 380k
                'quantity' => 1,
                'unit_price' => 380000.00,
                'discount_value' => 0,
                'final_price' => (380000.00 * 1) - 0, // 380.000
            ],
            [
                'variant_id' => 41, // Băng bảo vệ gối - 180k
                'quantity' => 2, 
                'unit_price' => 180000.00,
                'discount_value' => 0,
                'final_price' => (180000.00 * 2) - 0, // 360.000
            ],
            [
                'variant_id' => 13, // Tạ lục giác (10kg) - 289k
                'quantity' => 2,
                'unit_price' => 289000.00,
                'discount_value' => 0,
                'final_price' => (289000.00 * 2) - 0, // 578.000
            ]
        ];
        $order7_total_amount = collect($order7_details)->sum('final_price'); // 380 + 360 + 578 = 1.318.000
        $order7_total_discount = 0;
        
        $order7_id = DB::table('order')->insertGetId([
            'user_id' => 30, // Võ Văn Tiến
            'order_code' => 'GYM-20251114-STU777',
            'order_date' => $today->copy()->subDay(),
            'total_amount' => $order7_total_amount - $order7_total_discount, // 1.318.000
            'status' => 'processing',
            'shipping_address' => 'Số 77, Đường Lê Lợi, Phường Thạch Thang, Thành phố Đà Nẵng',
            'discount_value' => $order7_total_discount,
            'promotion_code' => null,
            'created_at' => $today->copy()->subDay(),
            'updated_at' => $today->copy()->subDay(),
        ]);
        foreach ($order7_details as &$detail) {
            $detail['order_id'] = $order7_id;
        }
        DB::table('order_detail')->insert($order7_details);

        // === ĐƠN HÀNG 8: (PENDING) ===
        // User 31 (Đặng Thị Uyên) mua 1 set đồ
        $order8_details = [
            [
                'variant_id' => 31, // Quần Legging (Xám, L) - 450k
                'quantity' => 1,
                'unit_price' => 450000.00,
                'discount_value' => 0,
                'final_price' => (450000.00 * 1) - 0,
            ],
            [
                'variant_id' => 27, // Áo Thun (Trắng, L) - 450k
                'quantity' => 1,
                'unit_price' => 450000.00,
                'discount_value' => 0,
                'final_price' => (450000.00 * 1) - 0,
            ],
            [
                'variant_id' => 33, // Set 4 Vớ - 120k
                'quantity' => 1,
                'unit_price' => 120000.00,
                'discount_value' => 0,
                'final_price' => (120000.00 * 1) - 0,
            ]
        ];
        $order8_total_amount = collect($order8_details)->sum('final_price'); // 1.020.000
        $order8_total_discount = 0;
        
        $order8_id = DB::table('order')->insertGetId([
            'user_id' => 31, // Đặng Thị Uyên
            'order_code' => 'GYM-20251115-VWX888',
            'order_date' => $today->copy()->subHour(), 
            'total_amount' => $order8_total_amount - $order8_total_discount,
            'status' => 'pending',
            'shipping_address' => 'Số 88, Đường Nguyễn Huệ, Phường Sài Gòn, TP.HCM',
            'discount_value' => $order8_total_discount,
            'promotion_code' => null,
            'created_at' => $today->copy()->subHour(),
            'updated_at' => $today->copy()->subHour(),
        ]);
        foreach ($order8_details as &$detail) {
            $detail['order_id'] = $order8_id;
        }
        DB::table('order_detail')->insert($order8_details);

        // === ĐƠN HÀNG 9: (CANCELLED) ===
        // User 33 (Huỳnh Thị Cẩm) mua Mass Gainer rồi hủy
        $order9_details = [
            [
                'variant_id' => 20, // Mass Gainer (12 Lbs) - 1.8M
                'quantity' => 1,
                'unit_price' => 1800000.00,
                'discount_value' => 0,
                'final_price' => (1800000.00 * 1) - 0,
            ]
        ];
        $order9_total_amount = collect($order9_details)->sum('final_price'); // 1.800.000
        $order9_total_discount = 0;
        
        $order9_id = DB::table('order')->insertGetId([
            'user_id' => 33, // Huỳnh Thị Cẩm
            'order_code' => 'GYM-20251112-YZA999',
            'order_date' => $today->copy()->subDays(3),
            'total_amount' => $order9_total_amount - $order9_total_discount,
            'status' => 'cancelled',
            'shipping_address' => 'Số 100, Đường Lý Chính Thắng, Phường Võ Thị Sáu, TP.HCM',
            'discount_value' => $order9_total_discount,
            'promotion_code' => null,
            'created_at' => $today->copy()->subDays(3),
            'updated_at' => $today->copy()->subDays(3),
        ]);
        foreach ($order9_details as &$detail) {
            $detail['order_id'] = $order9_id;
        }
        DB::table('order_detail')->insert($order9_details);

        // === ĐƠN HÀNG 10: (COMPLETED) ===
        // User 34 (Nguyễn Văn Hùng) mua 1 đôi giày 
        $order10_details = [
            [
                'variant_id' => 23, // Giày Nike Metcon (Size 42) - 2.8M
                'quantity' => 1,
                'unit_price' => 2800000.00,
                'discount_value' => 0,
                'final_price' => (2800000.00 * 1) - 0,
            ]
        ];
        $order10_subtotal = collect($order10_details)->sum('final_price'); // 2.800.000
        $order10_total_discount = 200000.00; // Giảm 200k
        
        $order10_id = DB::table('order')->insertGetId([
            'user_id' => 34, // Nguyễn Văn Hùng
            'order_code' => 'GYM-20251105-BCD000',
            'order_date' => $today->copy()->subDays(10),
            'total_amount' => $order10_subtotal - $order10_total_discount, // 2.600.000
            'status' => 'completed',
            'shipping_address' => 'Số 111, Đường Trần Quang Khải, Phường Tân Định, TP.HCM',
            'discount_value' => $order10_total_discount,
            'promotion_code' => 'BIGSALE',
            'created_at' => $today->copy()->subDays(10),
            'updated_at' => $today->copy()->subDays(7),
        ]);
        foreach ($order10_details as &$detail) {
            $detail['order_id'] = $order10_id;
        }
        DB::table('order_detail')->insert($order10_details);

        // === ĐƠN HÀNG 11: (PROCESSING) - (Giảm giá TỪNG MÓN) ===
        $order11_details = [
            [
                'variant_id' => 16, // Whey (Choco, 5 Lbs) - 1.550k
                'quantity' => 1,
                'unit_price' => 1550000.00,
                'discount_value' => 0, 
                'final_price' => (1550000.00 * 1) - 0,
            ],
            [
                'variant_id' => 7, // Bộ 2 tạ tay Vinyl (Xanh, 1kg) - 150k
                'quantity' => 1,
                'unit_price' => 150000.00,
                'discount_value' => 50000.00, // <-- Giảm riêng 50k
                'final_price' => (150000.00 * 1) - 50000.00, // 100.000
            ]
        ];
        $order11_total_amount = collect($order11_details)->sum('final_price'); // 1.550.000 + 100.000 = 1.650.000
        $order11_total_discount = 0;
        
        $order11_id = DB::table('order')->insertGetId([
            'user_id' => 25, // Vũ Thị Ngọc
            'order_code' => 'GYM-20251116-NEW001',
            'order_date' => $today->copy()->subDay(),
            'total_amount' => $order11_total_amount - $order11_total_discount,
            'status' => 'processing',
            'shipping_address' => 'Số 22, Đường Trần Phú, Phường Điện Biên, Thành phố Hà Nội',
            'discount_value' => $order11_total_discount,
            'promotion_code' => null,
            'created_at' => $today->copy()->subDay(),
            'updated_at' => $today->copy()->subDay(),
        ]);
        foreach ($order11_details as &$detail) {
            $detail['order_id'] = $order11_id;
        }
        DB::table('order_detail')->insert($order11_details);

        // === ĐƠN HÀNG 12: (COMPLETED) - (Giảm giá TỪNG MÓN) ===
        $order12_details = [
            [
                'variant_id' => 28, // Quần Short (L) - 350k
                'quantity' => 1,
                'unit_price' => 350000.00,
                'discount_value' => 0,
                'final_price' => (350000.00 * 1) - 0,
            ],
            [
                'variant_id' => 21, // Thanh Protein (Hộp 20) - 1.2M
                'quantity' => 1,
                'unit_price' => 1200000.00,
                'discount_value' => 100000.00, // <-- Giảm riêng 100k
                'final_price' => (1200000.00 * 1) - 100000.00, // 1.100.000
            ]
        ];
        $order12_total_amount = collect($order12_details)->sum('final_price'); // 350.000 + 1.100.000 = 1.450.000
        $order12_total_discount = 0; 
        
        $order12_id = DB::table('order')->insertGetId([
            'user_id' => 32, // Trịnh Văn Bình
            'order_code' => 'GYM-20251111-NEW002',
            'order_date' => $today->copy()->subDays(4),
            'total_amount' => $order12_total_amount - $order12_total_discount,
            'status' => 'completed',
            'shipping_address' => 'Số 99, Đường Phạm Văn Đồng, Phường Mai Dịch, Thành phố Hà Nội',
            'discount_value' => $order12_total_discount,
            'promotion_code' => null,
            'created_at' => $today->copy()->subDays(4),
            'updated_at' => $today->copy()->subDays(2),
        ]);
        foreach ($order12_details as &$detail) {
            $detail['order_id'] = $order12_id;
        }
        DB::table('order_detail')->insert($order12_details);

    }
}