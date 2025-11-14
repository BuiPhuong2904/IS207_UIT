<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa sạch dữ liệu
        DB::table('class_registration')->truncate();

        // Tạo class_registration
        DB::table('class_registration')->insert([
            
            // --- CÁC LỚP ĐÃ HOÀN THÀNH (Status: attended) ---
            
            // Schedule 1: HIIT (3 người)
            [
                'user_id' => 25,
                'schedule_id' => 1,
                'status' => 'attended',
                'created_at' => now()->subDays(3),
                'updated_at' => now(),
            ],
            [
                'user_id' => 26, 
                'schedule_id' => 1,
                'status' => 'attended',
                'created_at' => now()->subDays(2),
                'updated_at' => now(),
            ],
            [
                'user_id' => 27,
                'schedule_id' => 1,
                'status' => 'attended',
                'created_at' => now()->subDays(2), 
                'updated_at' => now(),
            ],
            
            // Schedule 2: Pilates (2 người)
            [
                'user_id' => 28,
                'schedule_id' => 2,
                'status' => 'attended',
                'created_at' => now()->subDays(4), 
                'updated_at' => now(),
            ],
            [
                'user_id' => 29,
                'schedule_id' => 2,
                'status' => 'attended',
                'created_at' => now()->subDays(3), 
                'updated_at' => now(),
            ],

            // Schedule 3: Gym (2 người)
            [
                'user_id' => 30, 
                'schedule_id' => 3,
                'status' => 'attended',
                'created_at' => now()->subDays(1), 
                'updated_at' => now(),
            ],
            [
                'user_id' => 31, 
                'schedule_id' => 3,
                'status' => 'attended',
                'created_at' => now()->subDays(2), 
                'updated_at' => now(),
            ],

            // --- CÁC LỚP BỊ HỦY (Status: cancelled) ---

            // Schedule 14: Yoga
            [
                'user_id' => 25, 
                'schedule_id' => 14,
                'status' => 'cancelled', 
                'created_at' => now()->subDays(1), 
                'updated_at' => now(),
            ],
            [
                'user_id' => 33, 
                'schedule_id' => 14,
                'status' => 'cancelled',
                'created_at' => now()->subDays(2), 
                'updated_at' => now(),
            ],

            // --- CÁC LỚP SẮP DIỄN RA (Status: registered) ---

            // Schedule 5: Zumba (4 người)
            [
                'user_id' => 25,
                'schedule_id' => 5,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'user_id' => 27,
                'schedule_id' => 5,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'user_id' => 29,
                'schedule_id' => 5,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'user_id' => 34, 
                'schedule_id' => 5,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            // Schedule 6: Boxing (2 người)
            [
                'user_id' => 26,
                'schedule_id' => 6,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'user_id' => 32,
                'schedule_id' => 6,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            // Schedule 8: Yoga (3 người)
            [
                'user_id' => 31,
                'schedule_id' => 8,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'user_id' => 33,
                'schedule_id' => 8,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
             [
                'user_id' => 28,
                'schedule_id' => 8,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            // Schedule 11: Zumba (2 người)
            [
                'user_id' => 25,
                'schedule_id' => 11,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'user_id' => 27, 
                'schedule_id' => 11,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],

            // Schedule 19: Yoga (CN), (3 người)
            [
                'user_id' => 26,
                'schedule_id' => 19,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'user_id' => 28,
                'schedule_id' => 19,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'user_id' => 30, 
                'schedule_id' => 19,
                'status' => 'registered',
                'created_at' => now(), 
                'updated_at' => now(),
            ],

        ]);
    }
}