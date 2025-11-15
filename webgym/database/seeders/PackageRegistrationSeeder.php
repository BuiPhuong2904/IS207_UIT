<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Thư viện Carbon để xử lý ngày tháng

class PackageRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa sạch dữ liệu 
        DB::table('payment')->truncate();
        DB::table('class_registration')->truncate();
        DB::table('package_registration')->truncate();

        $today = Carbon::parse('2025-11-14');

        // Tạo lượt đăng ký
        DB::table('package_registration')->insert([
            // GÓI CÒN HẠN (ACTIVE)

            // 1. Gói Năm
            [
                'user_id' => 11,
                'package_id' => 3,
                'start_date' => $today->copy(),
                'end_date' => $today->copy()->addMonths(12),
                'status' => 'active',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            // 2. Gói Quý
            [
                'user_id' => 12,
                'package_id' => 2,
                'start_date' => $today->copy()->subMonths(1)->subDays(15), 
                'end_date' => $today->copy()->addMonths(1)->addDays(15), 
                'status' => 'active',
                'created_at' => $today->copy()->subMonths(1)->subDays(15),
                'updated_at' => $today,
            ],
            // 3. Gói Tháng
            [
                'user_id' => 13,
                'package_id' => 1,
                'start_date' => $today->copy()->subDays(25), 
                'end_date' => $today->copy()->addDays(5),
                'status' => 'active',
                'created_at' => $today->copy()->subDays(25),
                'updated_at' => $today,
            ],
            // 4. Gói PT Cá Nhân
            [
                'user_id' => 14, 
                'package_id' => 4, 
                'start_date' => $today->copy()->subDays(10),
                'end_date' => $today->copy()->addDays(20),
                'status' => 'active',
                'created_at' => $today->copy()->subDays(10),
                'updated_at' => $today,
            ],
            // 5. Gói Quý 
            [
                'user_id' => 15, 
                'package_id' => 2,
                'start_date' => $today->copy()->subDays(50),
                'end_date' => $today->copy()->addDays(40),
                'status' => 'active',
                'created_at' => $today->copy()->subDays(50),
                'updated_at' => $today,
            ],
            // 6. Gói Năm
            [
                'user_id' => 16, 
                'package_id' => 3,
                'start_date' => $today->copy()->subMonths(6),
                'end_date' => $today->copy()->addMonths(6),
                'status' => 'active',
                'created_at' => $today->copy()->subMonths(6),
                'updated_at' => $today,
            ],
            // 7. Gói 10 Buổi
            [
                'user_id' => 17,
                'package_id' => 6,
                'start_date' => $today->copy(),
                'end_date' => $today->copy()->addMonths(3),
                'status' => 'active',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            // 8. Gói PT Cá Nhân
            [
                'user_id' => 18,
                'package_id' => 4,
                'start_date' => $today->copy(),
                'end_date' => $today->copy()->addMonths(1),
                'status' => 'active',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            // 9. Gói Tập Lẻ 
            [
                'user_id' => 19, 
                'package_id' => 5,
                'start_date' => $today->copy(),
                'end_date' => $today->copy()->addDay(1),
                'status' => 'active',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            // 10. Gói Quý 
            [
                'user_id' => 20, 
                'package_id' => 2,
                'start_date' => $today->copy()->subMonths(2),
                'end_date' => $today->copy()->addMonths(1),
                'status' => 'active',
                'created_at' => $today->copy()->subMonths(2),
                'updated_at' => $today,
            ],

            // GÓI ĐÃ HẾT HẠN (EXPIRED/COMPLETED)
            
            // 11. Gói đã hết hạn 1 tháng trước 
            [
                'user_id' => 11,
                'package_id' => 1, 
                'start_date' => $today->copy()->subMonths(2),
                'end_date' => $today->copy()->subMonths(1),
                'status' => 'expired',
                'created_at' => $today->copy()->subMonths(2),
                'updated_at' => $today->copy()->subMonths(1),
            ],
            // 12. Gói PT đã hoàn thành
            [
                'user_id' => 14,
                'package_id' => 4, 
                'start_date' => $today->copy()->subMonths(3),
                'end_date' => $today->copy()->subMonths(2),
                'status' => 'completed',
                'created_at' => $today->copy()->subMonths(3),
                'updated_at' => $today->copy()->subMonths(2),
            ],
        ]);
    }
}