<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MembershipPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa sạch dữ liệu
        DB::table('membership_package')->truncate();

        // Tạo membership_package
        DB::table('membership_package')->insert([
            // Gói 1: Gói Tháng
            [
                'package_name' => 'Gói Tháng',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340544/home_icon_1_vwnrex.png',
                'description' => 'Thời hạn: 30 ngày. Tập không giới hạn. Hỗ trợ PT hướng dẫn. Miễn phí tủ đồ.',
                'duration_months' => 1,
                'price' => 399000.00,
                'slug' => Str::slug('Gói Tháng'),
                'status' => 'active',
                'is_featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Gói 2: Gói Quý
            [
                'package_name' => 'Gói Quý',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340552/home_icon_5_ogsfnh.png',
                'description' => 'Thời hạn: 90 ngày. Tập không giới hạn. Tặng 1 buổi PT cá nhân. Ưu đãi mua sản phẩm.',
                'duration_months' => 3,
                'price' => 1199000.00,
                'slug' => Str::slug('Gói Quý'),
                'status' => 'active',
                'is_featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Gói 3: Gói Năm
            [
                'package_name' => 'Gói Năm',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340545/home_icon_3_i7thpr.png',
                'description' => 'Thời hạn: 365 ngày. Tặng 5 buổi PT/Năm. Giảm 10% các dịch vụ. Ưu tiên đặt lịch.',
                'duration_months' => 12,
                'price' => 4599000.00,
                'slug' => Str::slug('Gói Năm'),
                'status' => 'active',
                'is_featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Gói 4: Gói PT Cá Nhân
            [
                'package_name' => 'Gói PT Cá Nhân',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340551/home_icon_4_bnbmxh.png',
                'description' => 'Thời hạn: 30 ngày. Huấn luyện viên cá nhân. Có giáo trình tập riêng. Tư vấn chế độ ăn riêng.',
                'duration_months' => 1,
                'price' => 1599000.00,
                'slug' => Str::slug('Gói PT Cá Nhân'),
                'status' => 'active',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Gói 5: Gói Tập Lẻ
            [
                'package_name' => 'Gói Tập Lẻ 1 Ngày',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1763028674/ticket_arlacs.png',
                'description' => 'Thời hạn: 1 ngày. Không giới hạn khu vực. Dành cho khách tập thử. Dịch vụ tiện ích đầy đủ',
                'duration_months' => 0,
                'price' => 50000.00,
                'slug' => Str::slug('Gói Tập Lẻ 1 Ngày'),
                'status' => 'active',
                'is_featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Gói 6: Gói 10 Buổi
            [
                'package_name' => 'Gói 10 Buổi Tập',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1763028907/checklist_p1cciw.png',
                'description' => 'Thời hạn: 3 tháng. Gồm 10 lượt tập linh hoạt. Dành cho người bận rộn. Tiết kiệm chi phí.',
                'duration_months' => 3,
                'price' => 800000.00,
                'slug' => Str::slug('Gói 10 Buổi Tập'),
                'status' => 'active',
                'is_featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Gói 7: Gói Nửa Năm
            [
                'package_name' => 'Gói Nửa Năm',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1763318632/calendar_nhu9mk.png',
                'is_featured' => false,
                'description' => 'Thời hạn: 6 tháng. Tập không giới hạn. Tặng 2 buổi PT cá nhân. Ưu đãi dịch vụ đi kèm.',
                'duration_months' => 6,
                'price' => 2299000.00,
                'slug' => Str::slug('Gói Nửa Năm'),
                'status' => 'active',
                'is_featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Gói 8: Gói Sinh Viên
            [
                'package_name' => 'Gói Sinh Viên',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1763318792/graduate_wblu56.png',
                'is_featured' => false,
                'description' => 'Thời hạn: 30 ngày. Dành riêng cho HSSV. Tập không giới hạn. Hỗ trợ người mới.',
                'duration_months' => 1,
                'price' => 299000.00,
                'slug' => Str::slug('Gói Sinh Viên'),
                'status' => 'active',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}