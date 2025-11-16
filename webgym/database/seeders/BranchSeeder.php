<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB; 

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa sạch dữ liệu
        DB::table('branch')->truncate();

        // Tạo branch
        DB::table('branch')->insert([
            // 3 chi nhánh Hồ Chí Minh 
            [
                'branch_name' => 'Chi nhánh Võ Thị Sáu',
                'address' => '23/8, Đường Cách Mạng Tháng 8, Phường Võ Thị Sáu, TP.HCM',
                'phone' => '0909123456',
                'manager_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branch_name' => 'Chi nhánh Lý Thường Kiệt',
                'address' => 'Số 77, Đường Lý Thường Kiệt, Phường 14, TP.HCM',
                'phone' => '0912345678',
                'manager_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branch_name' => 'Chi nhánh Linh Xuân',
                'address' => 'Số 12B, Khu phố 4, Phường Linh Xuân, TP.HCM',
                'phone' => '0938123456',
                'manager_id' => 1, 
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 3 chi nhánh Hà Nội 
            [
                'branch_name' => 'Chi nhánh Điện Biên', 
                'address' => 'Số 22, Đường Trần Phú, Phường Điện Biên, Thành phố Hà Nội',
                'phone' => '0901234567',
                'manager_id' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branch_name' => 'Chi nhánh Hoàng Diệu',
                'address' => 'Số 34, Đường Hoàng Diệu, Phường Điện Biên, Thành phố Hà Nội',
                'phone' => '0902345678',
                'manager_id' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'branch_name' => 'Chi nhánh Trung Hòa',
                'address' => 'Số 56, Đường Trung Kính, Phường Trung Hòa, Thành phố Hà Nội',
                'phone' => '0909123456',
                'manager_id' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 1 chi nhánh Đà Nẵng
            [
                'branch_name' => 'Chi nhánh Đà Nẵng',
                'address' => 'Số 101, Đường Lê Hồng Phong, Phường Phước Ninh, Thành phố Đà Nẵng',
                'phone' => '0987654321',
                'manager_id' => 3, 
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}