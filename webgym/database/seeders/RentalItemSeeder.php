<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- Đã thêm

class RentalItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa sạch dữ liệu
        // Phải xóa bảng "con" (rental_item) trước, rồi mới xóa bảng "cha" (rental_transaction)
        DB::table('rental_transaction')->truncate();
        DB::table('rental_item')->truncate();

        // Tạo rental_item
        DB::table('rental_item')->insert([
            // === 1. Khăn tắm lớn (3 chi nhánh) ===
            [
                'item_name' => 'Khăn tắm lớn',
                'image_url' => null,
                'description' => 'Khăn tắm cotton 100%, kích thước 70x140cm, mềm mại, thấm hút tốt.',
                'rental_fee' => 20000.00,
                'quantity_total' => 50,
                'quantity_available' => 50,
                'status' => 'active',
                'branch_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Khăn tắm lớn',
                'image_url' => null,
                'description' => 'Khăn tắm cotton 100%, kích thước 70x140cm, mềm mại, thấm hút tốt.',
                'rental_fee' => 20000.00,
                'quantity_total' => 50,
                'quantity_available' => 50,
                'status' => 'active',
                'branch_id' => 2, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Khăn tắm lớn',
                'image_url' => null,
                'description' => 'Khăn tắm cotton 100%, kích thước 70x140cm, mềm mại, thấm hút tốt.',
                'rental_fee' => 20000.00,
                'quantity_total' => 50,
                'quantity_available' => 50,
                'status' => 'active',
                'branch_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // === 2. Bóng Massage (3 chi nhánh) ===
            [
                'item_name' => 'Bóng Massage',
                'image_url' => null,
                'description' => 'Bóng massage cao su non, đường kính 8cm, dùng để xoa bóp cơ bắp.',
                'rental_fee' => 15000.00,
                'quantity_total' => 40,
                'quantity_available' => 40,
                'status' => 'active',
                'branch_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Bóng Massage',
                'image_url' => null,
                'description' => 'Bóng massage cao su non, đường kính 8cm, dùng để xoa bóp cơ bắp.',
                'rental_fee' => 15000.00,
                'quantity_total' => 40,
                'quantity_available' => 40,
                'status' => 'active',
                'branch_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Bóng Massage',
                'image_url' => null,
                'description' => 'Bóng massage cao su non, đường kính 8cm, dùng để xoa bóp cơ bắp.',
                'rental_fee' => 15000.00,
                'quantity_total' => 40,
                'quantity_available' => 40,
                'status' => 'active',
                'branch_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // === 3. Tủ đựng đồ (3 chi nhánh) ===
            [
                'item_name' => 'Tủ đựng đồ cá nhân',
                'image_url' => null,
                'description' => 'Tủ đựng đồ cá nhân bằng nhựa ABS, có khóa an toàn.',
                'rental_fee' => 50000.00,
                'quantity_total' => 50,
                'quantity_available' => 50,
                'status' => 'active',
                'branch_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Tủ đựng đồ cá nhân',
                'image_url' => null,
                'description' => 'Tủ đựng đồ cá nhân bằng nhựa ABS, có khóa an toàn.',
                'rental_fee' => 50000.00,
                'quantity_total' => 50,
                'quantity_available' => 50,
                'status' => 'active',
                'branch_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Tủ đựng đồ cá nhân',
                'image_url' => null,
                'description' => 'Tủ đựng đồ cá nhân bằng nhựa ABS, có khóa an toàn.',
                'rental_fee' => 50000.00,
                'quantity_total' => 50,
                'quantity_available' => 50,
                'status' => 'active',
                'branch_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // === 4. Găng tay Boxing (2 chi nhánh) ===
            [
                'item_name' => 'Găng tay Boxing (10oz)',
                'image_url' => null,
                'description' => 'Găng tay (găng A) dành cho học viên lớp Boxing/Kickboxing.',
                'rental_fee' => 30000.00,
                'quantity_total' => 30,
                'quantity_available' => 30,
                'status' => 'active',
                'branch_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Găng tay Boxing (12oz)',
                'image_url' => null,
                'description' => 'Găng tay (găng B) dành cho học viên lớp Boxing/Kickboxing.',
                'rental_fee' => 30000.00,
                'quantity_total' => 40,
                'quantity_available' => 40,
                'status' => 'active',
                'branch_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // === 5. Thảm tập Yoga (2 chi nhánh) ===
            [
                'item_name' => 'Thảm tập Yoga (Loại dày)',
                'image_url' => null,
                'description' => 'Thảm TPE 8mm cao cấp cho lớp Yoga/Pilates, chống trượt.',
                'rental_fee' => 15000.00,
                'quantity_total' => 30,
                'quantity_available' => 30,
                'status' => 'active',
                'branch_id' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Thảm tập Yoga (Loại dày)',
                'image_url' => null,
                'description' => 'Thảm TPE 8mm cao cấp cho lớp Yoga/Pilates, chống trượt.',
                'rental_fee' => 15000.00,
                'quantity_total' => 30,
                'quantity_available' => 30,
                'status' => 'active',
                'branch_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // === 6. Đai lưng (2 chi nhánh) ===
            [
                'item_name' => 'Đai lưng da (Cỡ M)',
                'image_url' => null,
                'description' => 'Đai lưng da cứng, bản 10mm, hỗ trợ Squat/Deadlift nặng.',
                'rental_fee' => 25000.00,
                'quantity_total' => 30,
                'quantity_available' => 30,
                'status' => 'active',
                'branch_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Đai lưng da (Cỡ L)',
                'image_url' => null,
                'description' => 'Đai lưng da cứng, bản 10mm, hỗ trợ Squat/Deadlift nặng.',
                'rental_fee' => 25000.00,
                'quantity_total' => 20,
                'quantity_available' => 20,
                'status' => 'active',
                'branch_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // === 7. Con lăn giãn cơ (2 chi nhánh) ===
            [
                'item_name' => 'Con lăn giãn cơ',
                'image_url' => null,
                'description' => 'Con lăn EVA cứng, hỗ trợ giãn cơ sau tập luyện.',
                'rental_fee' => 15000.00,
                'quantity_total' => 25,
                'quantity_available' => 25,
                'status' => 'active',
                'branch_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'item_name' => 'Con lăn giãn cơ',
                'image_url' => null,
                'description' => 'Con lăn EVA cứng, hỗ trợ giãn cơ sau tập luyện.',
                'rental_fee' => 15000.00,
                'quantity_total' => 35,
                'quantity_available' => 35,
                'status' => 'active',
                'branch_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}