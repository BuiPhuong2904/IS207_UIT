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
            // 14 TRAINER 
            // CN Võ Thị Sáu 
            [
                'user_id' => 11, // Trần Văn Hoàng
                'specialty' => 'Gym, Calisthenics',
                'experience_years' => 4,
                'salary' => 16000000.00,
                'work_schedule' => 'Ca sáng: 6:00 - 14:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 1,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 12, // Nguyễn Thị Kim Anh
                'specialty' => 'Dance, Zumba',
                'experience_years' => 3,
                'salary' => 14000000.00,
                'work_schedule' => 'Ca tối: 18:00 - 22:00 (Thứ 2, 4, 6)',
                'branch_id' => 1,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // CN Lý Thường Kiệt
            [
                'user_id' => 13, // Lê Minh Hùng
                'specialty' => 'Gym, Powerlifting',
                'experience_years' => 5,
                'salary' => 18000000.00,
                'work_schedule' => 'Ca chiều: 14:00 - 22:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 2,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 14, // Võ Thị Hồng
                'specialty' => 'Yoga, Thiền',
                'experience_years' => 4,
                'salary' => 16000000.00,
                'work_schedule' => 'Ca sáng: 8:00 - 16:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 2,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // CN Linh Xuân
            [
                'user_id' => 15, // Phạm Hoàng Long
                'specialty' => 'Gym, PT 1-1',
                'experience_years' => 6,
                'salary' => 19000000.00,
                'work_schedule' => 'Ca sáng: 6:00 - 14:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 3,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 16, // Đặng Thu Thảo
                'specialty' => 'Pilates, Phục hồi',
                'experience_years' => 3,
                'salary' => 15000000.00,
                'work_schedule' => 'Ca tối: 17:00 - 21:00 (Thứ 3, 5, 7)',
                'branch_id' => 3,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // CN Điện Biên
            [
                'user_id' => 17, // Hoàng Văn Trung
                'specialty' => 'Gym, Cardio',
                'experience_years' => 5,
                'salary' => 17000000.00,
                'work_schedule' => 'Ca sáng: 6:00 - 14:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 4,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 18, // Ngô Bảo Châu
                'specialty' => 'Yoga',
                'experience_years' => 4,
                'salary' => 16000000.00,
                'work_schedule' => 'Ca tối: 18:00 - 22:00 (Thứ 2 - Thứ 6)',
                'branch_id' => 4,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // CN Hoàng Diệu
            [
                'user_id' => 19, // Vũ Tuấn Kiệt
                'specialty' => 'Boxing',
                'experience_years' => 6,
                'salary' => 20000000.00,
                'work_schedule' => 'Ca chiều: 14:00 - 22:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 5,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 20, // Hà Kiều Trang
                'specialty' => 'Pilates',
                'experience_years' => 3,
                'salary' => 15000000.00,
                'work_schedule' => 'Ca sáng: 8:00 - 16:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 5,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // CN Trung Hòa 
            [
                'user_id' => 21, // Nguyễn Minh Quân
                'specialty' => 'Gym, Weight Training',
                'experience_years' => 7,
                'salary' => 21000000.00,
                'work_schedule' => 'Ca chiều: 14:00 - 22:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 6,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 22, // Lý Thanh Thảo
                'specialty' => 'Zumba, Aerobics',
                'experience_years' => 4,
                'salary' => 15000000.00,
                'work_schedule' => 'Ca tối: 17:00 - 21:00 (Thứ 3, 5, 7)',
                'branch_id' => 6,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // CN Phước Ninh
            [
                'user_id' => 23, // Đinh Tiến Đạt
                'specialty' => 'Gym, HIIT',
                'experience_years' => 5,
                'salary' => 18000000.00,
                'work_schedule' => 'Ca chiều: 14:00 - 22:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 7,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 24, // Mai Phương Anh
                'specialty' => 'Yoga, Stretching',
                'experience_years' => 3,
                'salary' => 15000000.00,
                'work_schedule' => 'Ca sáng: 7:00 - 15:00 (Thứ 2 - Thứ 7)',
                'branch_id' => 7,
                'status' => 'Đang làm việc',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}