<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // thư viện Carbon để xử lý ngày tháng

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::parse('2025-11-13');

        // Xóa sạch dữ liệu
        DB::table('promotion')->truncate();

        // Tạo promotion
        DB::table('promotion')->insert([

            // (Active)

            // 1. Black Friday
            [
                'code' => 'BLACKFRIDAY',
                'title' => 'Black Friday Giảm Sốc 30%',
                'description' => 'Giảm 30% cho tất cả các gói tập từ 3 tháng trở lên.',
                'discount_value' => 30,
                'is_percent' => true,
                'start_date' => $today->copy()->subDays(3), 
                'end_date' => $today->copy()->addDays(17),
                'min_order_amount' => 1000000,
                'max_discount' => 500000,
                'usage_limit' => 500,
                'per_user_limit' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 2. Chào bạn mới 
            [
                'code' => 'WELCOME100K',
                'title' => 'Chào Bạn Mới Giảm 100k',
                'description' => 'Giảm 100k cho gói tập đầu tiên của hội viên mới.',
                'discount_value' => 100000,
                'is_percent' => false,
                'start_date' => null,
                'end_date' => null,
                'min_order_amount' => 300000,
                'max_discount' => null,
                'usage_limit' => null,
                'per_user_limit' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 3. Giảm giá Whey (Áp dụng cho danh mục)
            [
                'code' => 'WHEY10',
                'title' => 'Giảm 10% Thực Phẩm Bổ Sung',
                'description' => 'Áp dụng cho tất cả sản phẩm trong danh mục "Thực phẩm bổ sung".',
                'discount_value' => 10,
                'is_percent' => true,
                'start_date' => $today->copy()->startOfMonth(), 
                'end_date' => $today->copy()->endOfMonth(),
                'min_order_amount' => 500000,
                'max_discount' => 150000,
                'usage_limit' => null,
                'per_user_limit' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 4. Giảm giá Gói PT 
            [
                'code' => 'PT15',
                'title' => 'Ưu Đãi Tập PT - Giảm 15%',
                'description' => 'Giảm ngay 15% khi đăng ký Gói PT Cá Nhân.',
                'discount_value' => 15,
                'is_percent' => true,
                'start_date' => $today->copy(),
                'end_date' => $today->copy()->addDays(10),
                'min_order_amount' => null,
                'max_discount' => 300000,
                'usage_limit' => 100,
                'per_user_limit' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 5. Mừng sinh nhật 
            [
                'code' => 'HAPPYBIRTHDAY',
                'title' => 'Quà Tặng Sinh Nhật 15%',
                'description' => 'Giảm 15% cho 1 hóa đơn bất kỳ trong tháng sinh nhật của bạn.',
                'discount_value' => 15,
                'is_percent' => true,
                'start_date' => null,
                'end_date' => null,
                'min_order_amount' => null,
                'max_discount' => 200000,
                'usage_limit' => null,
                'per_user_limit' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 6. Giảm giá Quần áo (Danh mục)
            [
                'code' => 'GEARUP20',
                'title' => 'Giảm 20% Quần Áo Thể Thao',
                'description' => 'Lên đồ tập luyện với ưu đãi 20% cho danh mục "Quần áo thể thao".',
                'discount_value' => 20,
                'is_percent' => true,
                'start_date' => $today->copy()->startOfMonth(),
                'end_date' => $today->copy()->endOfMonth(),
                'min_order_amount' => 300000,
                'max_discount' => 100000,
                'usage_limit' => null,
                'per_user_limit' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 7. Freeship cho đơn hàng
            [
                'code' => 'FREESHIP',
                'title' => 'Miễn Phí Vận Chuyển',
                'description' => 'Miễn phí vận chuyển cho đơn hàng sản phẩm (không áp dụng gói tập) từ 500k.',
                'discount_value' => 30000, 
                'is_percent' => false,
                'start_date' => null,
                'end_date' => null,
                'min_order_amount' => 500000,
                'max_discount' => 30000,
                'usage_limit' => null,
                'per_user_limit' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 8. Giảm giá Gói Năm 
            [
                'code' => 'YEARLY500K',
                'title' => 'Giảm 500k Gói Tập Năm',
                'description' => 'Giảm ngay 500.000đ khi đăng ký Gói Năm.',
                'discount_value' => 500000,
                'is_percent' => false,
                'start_date' => null,
                'end_date' => null,
                'min_order_amount' => 4000000,
                'max_discount' => null,
                'usage_limit' => null,
                'per_user_limit' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 9. Giới thiệu bạn bè
            [
                'code' => 'BANBE',
                'title' => 'Giới Thiệu Bạn Bè - Nhận 100k',
                'description' => 'Bạn và người được giới thiệu cùng nhận voucher 100k.',
                'discount_value' => 100000,
                'is_percent' => false,
                'start_date' => null,
                'end_date' => null,
                'min_order_amount' => null,
                'max_discount' => null,
                'usage_limit' => null,
                'per_user_limit' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 10. Flash Sale
            [
                'code' => 'FLASH11',
                'title' => 'FLASH SALE 11.11',
                'description' => 'Giảm 50% Gói Tháng (Chỉ 50 suất). Nhanh tay kẻo lỡ!',
                'discount_value' => 50,
                'is_percent' => true,
                'start_date' => $today->copy()->subDays(2), 
                'end_date' => $today->copy(),
                'min_order_amount' => null,
                'max_discount' => 200000,
                'usage_limit' => 50,
                'per_user_limit' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             // 11. Giảm giá Phụ kiện
            [
                'code' => 'PK15',
                'title' => 'Giảm 15% Phụ Kiện',
                'description' => 'Giảm 15% cho găng tay, bình lắc, dây nhảy.',
                'discount_value' => 15,
                'is_percent' => true,
                'start_date' => null,
                'end_date' => null,
                'min_order_amount' => 100000,
                'max_discount' => 50000,
                'usage_limit' => null,
                'per_user_limit' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 12. Giảm giá cho Học sinh - Sinh viên
            [
                'code' => 'STUDENT20',
                'title' => 'Ưu Đãi HSSV Giảm 20%',
                'description' => 'Giảm 20% Gói Tháng (yêu cầu thẻ HSSV).',
                'discount_value' => 20,
                'is_percent' => true,
                'start_date' => null,
                'end_date' => null,
                'min_order_amount' => null,
                'max_discount' => 100000,
                'usage_limit' => null,
                'per_user_limit' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // (Upcoming)

            // 13. Giáng Sinh
            [
                'code' => 'XMAS20',
                'title' => 'Giáng Sinh An Lành - Giảm 20%',
                'description' => 'Ưu đãi Giáng Sinh cho tất cả sản phẩm và gói tập.',
                'discount_value' => 20,
                'is_percent' => true,
                'start_date' => Carbon::parse('2025-12-01'),
                'end_date' => Carbon::parse('2025-12-25'),
                'min_order_amount' => 500000,
                'max_discount' => 200000,
                'usage_limit' => null,
                'per_user_limit' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 14. Chào Năm Mới 2026
            [
                'code' => 'NEWYEAR26',
                'title' => 'Chào 2026 - Giảm 200k',
                'description' => 'Giảm 200k cho Gói Quý và Gói Năm.',
                'discount_value' => 200000,
                'is_percent' => false,
                'start_date' => Carbon::parse('2026-01-01'),
                'end_date' => Carbon::parse('2026-01-10'),
                'min_order_amount' => 1000000,
                'max_discount' => null,
                'usage_limit' => 200,
                'per_user_limit' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 15. Tết Nguyên Đán
            [
                'code' => 'TET2026',
                'title' => 'Khai Xuân Giáp Tuất - Giảm 15%',
                'description' => 'Lì xì đầu năm giảm 15% toàn bộ cửa hàng.',
                'discount_value' => 15,
                'is_percent' => true,
                'start_date' => Carbon::parse('2026-01-25'),
                'end_date' => Carbon::parse('2026-02-05'),
                'min_order_amount' => null,
                'max_discount' => 250000,
                'usage_limit' => null,
                'per_user_limit' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             // 16. Khai trương chi nhánh mới
            [
                'code' => 'OPENINGHN',
                'title' => 'Khai Trương Chi Nhánh Trung Hòa',
                'description' => 'Giảm 30% Gói Năm cho 100 hội viên đầu tiên tại chi nhánh Trung Hòa, Hà Nội.',
                'discount_value' => 30,
                'is_percent' => true,
                'start_date' => Carbon::parse('2025-11-20'),
                'end_date' => Carbon::parse('2025-12-20'),
                'min_order_amount' => null,
                'max_discount' => 1500000,
                'usage_limit' => 100,
                'per_user_limit' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // (Expired)

            // 17. Sale 10.10
            [
                'code' => 'SALE1010',
                'title' => 'Siêu Sale 10.10 (Đã Hết Hạn)',
                'description' => 'Giảm 101k cho đơn từ 500k.',
                'discount_value' => 101000,
                'is_percent' => false,
                'start_date' => Carbon::parse('2025-10-10'),
                'end_date' => Carbon::parse('2025-10-12'),
                'min_order_amount' => 500000,
                'max_discount' => null,
                'usage_limit' => 1010,
                'per_user_limit' => 1,
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 18. Mừng 20/10
            [
                'code' => 'WOMEN20',
                'title' => 'Mừng Ngày Phụ Nữ 20/10',
                'description' => 'Giảm 20% cho khách hàng Nữ.',
                'discount_value' => 20,
                'is_percent' => true,
                'start_date' => Carbon::parse('2025-10-18'),
                'end_date' => Carbon::parse('2025-10-21'),
                'min_order_amount' => null,
                'max_discount' => 200000,
                'usage_limit' => null,
                'per_user_limit' => 1,
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 19. Back to School
            [
                'code' => 'BACK2SCHOOL',
                'title' => 'Tựu Trường Giảm 150k (Hết Hạn)',
                'description' => 'Giảm 150k Gói Quý cho HSSV.',
                'discount_value' => 150000,
                'is_percent' => false,
                'start_date' => Carbon::parse('2025-08-25'),
                'end_date' => Carbon::parse('2025-09-10'),
                'min_order_amount' => 1000000,
                'max_discount' => null,
                'usage_limit' => 300,
                'per_user_limit' => 1,
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 20. Khuyến mãi Test
            [
                'code' => 'TESTCODE',
                'title' => 'Mã Test (Không Hoạt Động)',
                'description' => 'Mã này dùng để test, đã tắt.',
                'discount_value' => 10000,
                'is_percent' => false,
                'start_date' => null,
                'end_date' => null,
                'min_order_amount' => null,
                'max_discount' => null,
                'usage_limit' => null,
                'per_user_limit' => null,
                'is_active' => false, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}