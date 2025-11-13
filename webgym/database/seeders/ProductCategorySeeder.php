<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa sạch dữ liệu
        DB::table('product_category')->truncate();

        // Tạo product_category
        DB::table('product_category')->insert([
            // 4 loại sp
            [
                'category_name' => 'Dụng cụ tập luyện',
                'slug' => 'dung-cu-tap-luyen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Thực phẩm bổ sung',
                'slug' => 'thuc-pham-bo-sung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Quần áo thể thao',
                'slug' => 'quan-ao-the-thao',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_name' => 'Phụ kiện thể thao',
                'slug' => 'phu-kien-the-thao',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
