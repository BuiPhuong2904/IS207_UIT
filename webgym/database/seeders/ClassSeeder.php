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
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1763133604/yoga_gq9qkv.jpg', // Từ ảnh blog
                'trainer_id' => 4,
                'type' => 'Lớp Nhóm',
                'max_capacity' => 20,
                'description' => 'Nơi tâm trí tĩnh lặng và cơ thể được thả lỏng, phục hồi năng lượng.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 2. Lớp Gym
            [
                'class_name' => 'Lớp Gym',
                'image_url' => 'https://placehold.co/800x400/EF4444/FFFFFF?text=Gym', // Placeholder
                'trainer_id' => 5,
                'type' => 'Lớp Nhóm',
                'max_capacity' => 15,
                'description' => 'Cảm nhận từng thớ cơ mạnh mẽ hơn, định hình vóc dáng sắc nét.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 3. Lớp Cardio
            [
                'class_name' => 'Lớp Cardio',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1763133603/cardio_n39sxp.jpg', // Từ ảnh blog
                'trainer_id' => 10,
                'type' => 'Lớp Nhóm',
                'max_capacity' => 20,
                'description' => 'Chạy, nhảy và đẩy nhịp tim lên cao nhất để chinh phục sức bền của bạn.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 4. Lớp Zumba
            [
                'class_name' => 'Lớp Zumba',
                'image_url' => 'https://placehold.co/800x400/F59E0B/FFFFFF?text=Zumba', // Placeholder
                'trainer_id' => 7,
                'type' => 'Lớp Nhóm',
                'max_capacity' => 25,
                'description' => 'Vừa tập vừa vui, đốt mỡ cực nhanh qua điệu nhảy sôi động.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 5. Lớp Boxing
            [
                'class_name' => 'Lớp Boxing',
                'image_url' => 'https://placehold.co/800x400/3B82F6/FFFFFF?text=Boxing', // Placeholder
                'trainer_id' => 6,
                'type' => 'Lớp Nhóm',
                'max_capacity' => 12,
                'description' => 'Tung cú đấm dứt khoát, né đòn nhanh nhẹn và giải tỏa căng thẳng cực đã.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 6. Lớp HIIT
            [
                'class_name' => 'Lớp HIIT',
                'image_url' => 'https://placehold.co/800x400/E11D48/FFFFFF?text=HIIT', // Placeholder
                'trainer_id' => 8,
                'type' => 'Lớp Nhóm',
                'max_capacity' => 20,
                'description' => 'Đốt mỡ ngay cả khi đã nghỉ tập. Hiệu quả tối đa trong thời gian ngắn nhất.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 7. Lớp Pilates
            [
                'class_name' => 'Lớp Pilates',
                'image_url' => 'https://placehold.co/800x400/10B981/FFFFFF?text=Pilates', // Placeholder
                'trainer_id' => 9,
                'type' => 'Lớp Nhóm',
                'max_capacity' => 15,
                'description' => 'Siết chặt cơ lõi, kiểm soát từng chuyển động chậm rãi để có một tư thế chuẩn.',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}