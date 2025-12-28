<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa sạch dữ liệu
        // Phải xóa bảng (đăng ký) trước, vì nó tham chiếu đến schedule_id
        DB::table('class_registration')->truncate();
        DB::table('class_schedule')->truncate();

        $today = Carbon::parse('2025-12-22');

        // Tạo lịch học
        DB::table('class_schedule')->insert([

            // Thứ 2
            [
                'class_id' => 6, // Lớp HIIT
                'date' => $today->copy(),
                'start_time' => '06:00:00',
                'end_time' => '07:00:00',
                'trainer_id' => 8,  // Trương Minh Khanh (HIIT, 6:00-14:00)
                'branch_id' => 7,   // Chi nhánh Phước Ninh (ĐN)
                'room' => 'Studio 1',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 7, // Lớp Pilates
                'date' => $today->copy(),
                'start_time' => '08:00:00',
                'end_time' => '09:00:00',
                'trainer_id' => 9,  // Lê Thị Linh (Pilates, 8:00-16:00)
                'branch_id' => 3,   // Chi nhánh Linh Xuân (HCM)
                'room' => 'Studio 2',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 2, // Lớp Gym
                'date' => $today->copy(),
                'start_time' => '18:00:00',
                'end_time' => '19:00:00',
                'trainer_id' => 5,  // Phạm Văn Dũng (Gym, 14:00-22:00)
                'branch_id' => 1,   // Chi nhánh Võ Thị Sáu (HCM)
                'room' => 'Gym Floor',
                'status' => 'completed',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Thứ 3
            [
                'class_id' => 2, // Lớp Gym
                'date' => $today->copy()->addDays(1),
                'start_time' => '07:00:00',
                'end_time' => '08:00:00',
                'trainer_id' => 17, // Hoàng Văn Trung (Gym/Cardio, 6:00-14:00)
                'branch_id' => 4,   // Chi nhánh Điện Biên (HN)
                'room' => 'Gym Floor',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 4, // Lớp Zumba
                'date' => $today->copy()->addDays(1),
                'start_time' => '18:00:00',
                'end_time' => '19:00:00',
                'trainer_id' => 7,  // Nguyễn Thị Giang (Zumba, T3,5,7)
                'branch_id' => 2,   // Chi nhánh Lý Thường Kiệt (HCM)
                'room' => 'Studio 1',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 5, // Lớp Boxing
                'date' => $today->copy()->addDays(1),
                'start_time' => '19:00:00',
                'end_time' => '20:00:00',
                'trainer_id' => 19, // Vũ Tuấn Kiệt (Boxing, 14:00-22:00)
                'branch_id' => 5,   // Chi nhánh Hoàng Diệu (HN)
                'room' => 'Boxing Ring',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Thứ 4
            [
                'class_id' => 1, // Lớp Yoga
                'date' => $today->copy()->addDays(2),
                'start_time' => '07:00:00',
                'end_time' => '08:00:00',
                'trainer_id' => 24, // Mai Phương Anh (Yoga, 7:00-15:00)
                'branch_id' => 7,   // Chi nhánh Phước Ninh (ĐN)
                'room' => 'Studio 2',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 1, // Lớp Yoga
                'date' => $today->copy()->addDays(2),
                'start_time' => '18:00:00',
                'end_time' => '19:00:00',
                'trainer_id' => 18, // Ngô Bảo Châu (Yoga, 18:00-22:00)
                'branch_id' => 4,   // Chi nhánh Điện Biên (HN)
                'room' => 'Studio 1',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 2, // Lớp Gym
                'date' => $today->copy()->addDays(2),
                'start_time' => '20:00:00',
                'end_time' => '21:00:00',
                'trainer_id' => 10, // Phạm Văn Minh (Cardio/Gym, 14:00-22:00)
                'branch_id' => 1,   // Chi nhánh Võ Thị Sáu (HCM)
                'room' => 'Gym Floor',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Thứ 5
            [
                'class_id' => 7, // Lớp Pilates
                'date' => $today->copy()->addDays(3),
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
                'trainer_id' => 20, // Hà Kiều Trang (Pilates, 8:00-16:00)
                'branch_id' => 5,   // Chi nhánh Hoàng Diệu (HN)
                'room' => 'Studio 2',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 4, // Lớp Zumba
                'date' => $today->copy()->addDays(3),
                'start_time' => '18:30:00',
                'end_time' => '19:30:00',
                'trainer_id' => 22, // Lý Thanh Thảo (Zumba, T3,5,7)
                'branch_id' => 6,   // Chi nhánh Trung Hòa (HN)
                'room' => 'Studio 1',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 3, // Lớp Cardio
                'date' => $today->copy()->addDays(3),
                'start_time' => '18:00:00',
                'end_time' => '19:00:00',
                'trainer_id' => 10, // Phạm Văn Minh (Cardio, 14:00-22:00)
                'branch_id' => 1,   // Chi nhánh Võ Thị Sáu (HCM)
                'room' => 'Studio 1',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Thứ 6
            [
                'class_id' => 6, // Lớp HIIT
                'date' => $today->copy()->addDays(4),
                'start_time' => '06:00:00',
                'end_time' => '07:00:00',
                'trainer_id' => 8,  // Trương Minh Khanh (HIIT, 6:00-14:00)
                'branch_id' => 7,   // Chi nhánh Phước Ninh (ĐN)
                'room' => 'Studio 1',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 1, // Lớp Yoga
                'date' => $today->copy()->addDays(4),
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
                'trainer_id' => 14, // Võ Thị Hồng (Yoga, 8:00-16:00)
                'branch_id' => 2,   // Chi nhánh Lý Thường Kiệt (HCM)
                'room' => 'Studio 2',
                'status' => 'cancelled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 5, // Lớp Boxing
                'date' => $today->copy()->addDays(4),
                'start_time' => '19:00:00',
                'end_time' => '20:00:00',
                'trainer_id' => 6,  // Ngô Văn Đông (Boxing, 13:00-21:00)
                'branch_id' => 4,   // Chi nhánh Điện Biên (HN)
                'room' => 'Boxing Ring',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Thứ 7
            [
                'class_id' => 2, // Lớp Gym
                'date' => $today->copy()->addDays(5),
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
                'trainer_id' => 15, // Phạm Hoàng Long (Gym, 6:00-14:00)
                'branch_id' => 3,   // Chi nhánh Linh Xuân (HCM)
                'room' => 'Gym Floor',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 4, // Lớp Zumba
                'date' => $today->copy()->addDays(5),
                'start_time' => '18:00:00',
                'end_time' => '19:00:00',
                'trainer_id' => 7,  // Nguyễn Thị Giang (Zumba, T3,5,7)
                'branch_id' => 2,   // Chi nhánh Lý Thường Kiệt (HCM)
                'room' => 'Studio 1',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Chủ Nhật
            [
                'class_id' => 1, // Lớp Yoga
                'date' => $today->copy()->addDays(6),
                'start_time' => '09:00:00',
                'end_time' => '11:00:00',
                'trainer_id' => 4,  // Lê Minh Châu (Yoga, có lịch CN 9:00-17:00)
                'branch_id' => 7,   // Chi nhánh Phước Ninh (ĐN)
                'room' => 'Studio 1',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 5, // Lớp Boxing
                'date' => $today->copy()->addDays(6),
                'start_time' => '16:00:00',
                'end_time' => '17:00:00',
                'trainer_id' => 6,
                'branch_id' => 5,   // Chi nhánh Hoàng Diệu (HN)
                'room' => 'Boxing Ring',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'class_id' => 2, // Lớp Gym 
                'date' => $today->copy()->addDays(6),
                'start_time' => '17:00:00',
                'end_time' => '18:00:00',
                'trainer_id' => 5,
                'branch_id' => 2,   // Chi nhánh Lý Thường Kiệt (HCM)
                'room' => 'Gym Floor',
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}