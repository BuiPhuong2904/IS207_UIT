<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa sạch dữ liệu
        // Phải xóa các bảng "con" (tham chiếu đến class_id) trước
        DB::table('class_registration')->truncate();
        DB::table('class_schedule')->truncate();

        // Xóa bảng "cha"
        DB::table('class')->truncate();

        // Tạo lớp
        DB::table('class')->insert([
            // 1. Lớp Yoga
            [
                'class_name' => 'Lớp Yoga',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340664/class_yoga_pnqj0e.jpg',
                'type' => 'mind_body',
                'max_capacity' => 20,
                'description' => 'Nơi tâm trí tĩnh lặng và cơ thể được thả lỏng, phục hồi năng lượng.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 2. Lớp Gym
            [
                'class_name' => 'Lớp Gym',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340660/class_gym_zqcmwl.jpg',
                'type' => 'strength',
                'max_capacity' => 15,
                'description' => 'Cảm nhận từng thớ cơ mạnh mẽ hơn, định hình vóc dáng sắc nét.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 3. Lớp Cardio
            [
                'class_name' => 'Lớp Cardio Cycling',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340669/class_cardio_nhx24a.jpg',
                'type' => 'cardio',
                'max_capacity' => 20,
                'description' => 'Chạy, nhảy và đẩy nhịp tim lên cao nhất để chinh phục sức bền của bạn.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 4. Lớp Zumba
            [
                'class_name' => 'Lớp Zumba',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340666/class_zumba_mdctb7.jpg',
                'type' => 'cardio',
                'max_capacity' => 25,
                'description' => 'Vừa tập vừa vui, đốt mỡ cực nhanh qua điệu nhảy sôi động.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 5. Lớp Boxing
            [
                'class_name' => 'Lớp Boxing',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340668/class_boxing_jgare2.jpg',
                'type' => 'combat',
                'max_capacity' => 12,
                'description' => 'Tung cú đấm dứt khoát, né đòn nhanh nhẹn và giải tỏa căng thẳng cực đã.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 6. Lớp HIIT
            [
                'class_name' => 'Lớp HIIT',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340662/class_HIIT_hziu98.jpg',
                'type' => 'cardio',
                'max_capacity' => 20,
                'description' => 'Đốt mỡ ngay cả khi đã nghỉ tập. Hiệu quả tối đa trong thời gian ngắn nhất.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 7. Lớp Pilates
            [
                'class_name' => 'Lớp Pilates',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340663/class_pilates_b1irhb.jpg',
                'type' => 'mind_body',
                'max_capacity' => 15,
                'description' => 'Siết chặt cơ lõi, kiểm soát từng chuyển động chậm rãi để có một tư thế chuẩn.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}