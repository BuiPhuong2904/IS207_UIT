<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa sạch dữ liệu
        DB::table('trainer')->truncate();

        // Tạo trainer
        DB::table('trainer')->insert([
            // User ID 4: Lê Minh Châu (Yoga)
            [
                'user_id' => 4,
                'specialty' => 'Yoga',
                'experience_years' => 7,
                'salary' => 20000000.00,
                'work_schedule' => 'Thứ 2, 4, 6 (18:00 - 22:00) | Chủ Nhật (9:00 - 17:00)',
                'branch_id' => 7, // Chi nhánh Phước Ninh, Đà Nẵng
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // User ID 5: Phạm Văn Dũng (Gym)
            [
                'user_id' => 5,
                'specialty' => 'Gym',
                'experience_years' => 5,
                'salary' => 18000000.00,
                'work_schedule' => 'Ca tối: 14:00 - 22:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 1, // Chi nhánh Võ Thị Sáu, TP.HCM
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // User ID 6: Ngô Văn Đông (Boxing)
            [
                'user_id' => 6,
                'specialty' => 'Boxing',
                'experience_years' => 8,
                'salary' => 22000000.00,
                'work_schedule' => 'Ca chiều: 13:00 - 21:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 4, // Chi nhánh Điện Biên, Hà Nội
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // User ID 7: Nguyễn Thị Giang (Zumba)
            [
                'user_id' => 7,
                'specialty' => 'Zumba',
                'experience_years' => 4,
                'salary' => 15000000.00,
                'work_schedule' => 'Ca tối: 17:00 - 21:00 (Thứ 3, 5, 7)',
                'branch_id' => 2, // Chi nhánh Lý Thường Kiệt, TP.HCM
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // User ID 8: Trương Minh Khanh (HIIT)
            [
                'user_id' => 8,
                'specialty' => 'HIIT',
                'experience_years' => 6,
                'salary' => 20000000.00,
                'work_schedule' => 'Ca sáng: 6:00 - 14:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 7, // Chi nhánh Phước Ninh, Đà Nẵng
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // User ID 9: Lê Thị Linh (Pilates)
            [
                'user_id' => 9,
                'specialty' => 'Pilates',
                'experience_years' => 5,
                'salary' => 18000000.00,
                'work_schedule' => 'Ca sáng: 8:00 - 16:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 3, // Chi nhánh Linh Xuân, TP.HCM
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // User ID 10: Phạm Văn Minh (Cardio)
            [
                'user_id' => 10,
                'specialty' => 'Cardio',
                'experience_years' => 3,
                'salary' => 15000000.00,
                'work_schedule' => 'Ca tối: 14:00 - 22:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 1, // Chi nhánh Võ Thị Sáu, TP.HCM
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}