<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class PromotionTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa sạch dữ liệu
        DB::table('promotion_target')->truncate();

        // Tạo promotion_target
        DB::table('promotion_target')->insert([

            // Mã 1 'BLACKFRIDAY': Giảm 30% cho gói 3 tháng trở lên
            // Gán vào Gói Quý (ID 2), Gói Năm (ID 3)
            [
                'promotion_id' => 1,
                'target_type' => 'membership_package',
                'target_id' => 2, // Gói Quý
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'promotion_id' => 1,
                'target_type' => 'membership_package',
                'target_id' => 3, // Gói Năm
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mã 3 'WHEY10': Giảm 10% Thực Phẩm Bổ Sung
            // Gán vào ProductCategory (ID 2)
            [
                'promotion_id' => 3,
                'target_type' => 'product_category',
                'target_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mã 4 'PT15': Giảm 15% Gói PT Cá Nhân
            // Gán vào MembershipPackage (ID 4)
            [
                'promotion_id' => 4,
                'target_type' => 'membership_package',
                'target_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mã 6 'GEARUP20': Giảm 20% Quần Áo Thể Thao
            // Gán vào ProductCategory (ID 3)
            [
                'promotion_id' => 6,
                'target_type' => 'product_category',
                'target_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mã 8 'YEARLY500K': Giảm 500k Gói Tập Năm
            // Gán vào MembershipPackage (ID 3)
            [
                'promotion_id' => 8,
                'target_type' => 'membership_package',
                'target_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Mã 10 'FLASH11': Giảm 50% Gói Tháng
            // Gán vào MembershipPackage (ID 1)
            [
                'promotion_id' => 10,
                'target_type' => 'membership_package',
                'target_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mã 11 'PK15': Giảm 15% Phụ Kiện
            // Gán vào ProductCategory (ID 4)
            [
                'promotion_id' => 11,
                'target_type' => 'product_category',
                'target_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mã 12 'STUDENT20': Giảm 20% Gói Tháng
            // Gán vào MembershipPackage (ID 1)
            [
                'promotion_id' => 12,
                'target_type' => 'membership_package',
                'target_id' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mã 14 'NEWYEAR26': Giảm 200k cho Gói Quý và Gói Năm
            [
                'promotion_id' => 14,
                'target_type' => 'membership_package',
                'target_id' => 2, // Gói Quý
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'promotion_id' => 14,
                'target_type' => 'membership_package',
                'target_id' => 3, // Gói Năm
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mã 16 'OPENINGHN': Giảm 30% Gói Năm
            [
                'promotion_id' => 16,
                'target_type' => 'membership_package',
                'target_id' => 3, // Gói Năm
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mã 19 'BACK2SCHOOL': Giảm 150k Gói Quý
            [
                'promotion_id' => 19,
                'target_type' => 'membership_package',
                'target_id' => 2, // Gói Quý
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Mã 18 'WOMEN20': Giảm 20% cho khách hàng Nữ
            // (Đây là logic, nhưng ta có thể gán nó cho 'user' và 'gender' = 'Nữ',
            // hoặc đơn giản là để code xử lý. Ở đây ta sẽ gán vào 'user' mà không có ID)
            [
                'promotion_id' => 18,
                'target_type' => 'user_gender', // 1 kiểu target_type đặc biệt
                'target_id' => null, // Code sẽ hiểu target_type này là check 'Nữ'
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}