<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Xóa sạch dữ liệu cũ
        DB::table('blog_post')->truncate();

        // 2. Tạo dữ liệu mẫu
        DB::table('blog_post')->insert([
            // --- BÀI VIẾT CỦA ADMIN (Thông báo, Khuyến mãi) ---
            [
                'title' => 'Thông báo lịch nghỉ Tết Nguyên Đán 2025',
                'slug' => Str::slug('Thông báo lịch nghỉ Tết Nguyên Đán 2025'),
                'summary' => 'Kính gửi quý hội viên, phòng tập xin thông báo lịch nghỉ tết và thời gian hoạt động trở lại.',
                'content' => '<p>Phòng tập sẽ bắt đầu nghỉ tết từ ngày 28/01/2025 đến hết ngày 05/02/2025. Chúc quý hội viên một năm mới An Khang Thịnh Vượng.</p>',
                'author_id' => 1, // Admin Nguyễn Văn An
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'tags' => 'thong-bao, lich-nghi',
                'image_url' => null,
            ],
            [
                'title' => 'Chương trình khuyến mãi: Chào hè rực rỡ - Giảm 30%',
                'slug' => Str::slug('Chương trình khuyến mãi: Chào hè rực rỡ - Giảm 30%'),
                'summary' => 'Ưu đãi đặc biệt dành cho các gói tập 1 năm đăng ký trong tháng này.',
                'content' => '<p>Đăng ký ngay hôm nay để nhận ưu đãi giảm giá 30% và tặng kèm túi thể thao cao cấp.</p>',
                'author_id' => 2, // Admin Trần Thị Bích
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'tags' => 'khuyen-mai, uu-dai',
                'image_url' => null,
            ],

            // --- BÀI VIẾT CỦA TRAINER (Kiến thức tập luyện, Dinh dưỡng) ---
            [
                'title' => '5 bài tập Cardio đốt mỡ thừa hiệu quả tại nhà',
                'slug' => Str::slug('5 bài tập Cardio đốt mỡ thừa hiệu quả tại nhà'),
                'summary' => 'Hướng dẫn chi tiết các bài tập Cardio đơn giản nhưng mang lại hiệu quả cao giúp bạn lấy lại vóc dáng.',
                'content' => '<p>Chi tiết về bài tập Jumping Jack, Burpees, Mountain Climbers...</p>',
                'author_id' => 4, // Trainer Lê Minh Châu
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'tags' => 'cardio, giam-can, tap-tai-nha',
                'image_url' => null,
            ],
            [
                'title' => 'Chế độ ăn Eat Clean cho người mới bắt đầu',
                'slug' => Str::slug('Chế độ ăn Eat Clean cho người mới bắt đầu'),
                'summary' => 'Tìm hiểu về nguyên tắc ăn Eat Clean và thực đơn mẫu trong 7 ngày.',
                'content' => '<p>Eat Clean không phải là ăn kiêng khắt khe mà là lựa chọn thực phẩm sạch, chế biến đơn giản...</p>',
                'author_id' => 5, // Trainer Phạm Văn Dũng
                'is_published' => true,
                'published_at' => now()->subDays(15),
                'tags' => 'dinh-duong, eat-clean, healthy',
                'image_url' => null,
            ],
            [
                'title' => 'Lợi ích của việc tập Yoga vào buổi sáng',
                'slug' => Str::slug('Lợi ích của việc tập Yoga vào buổi sáng'),
                'summary' => 'Tại sao bạn nên dành 30 phút mỗi sáng để tập Yoga? Cùng tìm hiểu nhé.',
                'content' => '<p>Tập Yoga buổi sáng giúp đánh thức cơ thể, cải thiện hô hấp và tăng cường sự tập trung...</p>',
                'author_id' => 7, // Trainer Nguyễn Thị Giang
                'is_published' => true,
                'published_at' => now()->subDays(20),
                'tags' => 'yoga, suc-khoe, thu-gian',
                'image_url' => null,
            ],
            [
                'title' => 'Sai lầm thường gặp khi tập Squat',
                'slug' => Str::slug('Sai lầm thường gặp khi tập Squat'),
                'summary' => 'Squat là vua của các bài tập chân, nhưng tập sai có thể gây chấn thương nghiêm trọng.',
                'content' => '<p>Các lỗi phổ biến: đầu gối quá mũi chân, lưng không thẳng, không gồng core...</p>',
                'author_id' => 6, // Trainer Ngô Văn Đông
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'tags' => 'gym, kien-thuc, squat',
                'image_url' => null,
            ],
            
            // --- BÀI VIẾT NHÁP (Chưa publish) ---
            [
                'title' => 'Hướng dẫn sử dụng máy chạy bộ đúng cách (Bản nháp)',
                'slug' => Str::slug('Hướng dẫn sử dụng máy chạy bộ đúng cách'),
                'summary' => 'Bài viết đang soạn thảo...',
                'content' => null,
                'author_id' => 4, // Trainer Lê Minh Châu
                'is_published' => false,
                'published_at' => null,
                'tags' => 'thiet-bi, huong-dan',
                'image_url' => null,
            ],
             [
                'title' => 'Thực phẩm bổ sung: Nên hay không? (Chờ duyệt)',
                'slug' => Str::slug('Thực phẩm bổ sung: Nên hay không?'),
                'summary' => 'Phân tích ưu nhược điểm của Whey Protein, BCAA...',
                'content' => '<p>Nội dung chi tiết đang được cập nhật...</p>',
                'author_id' => 8, // Trainer Trương Minh Khanh
                'is_published' => false,
                'published_at' => null,
                'tags' => 'supplements, dinh-duong',
                'image_url' => null,
            ],
        ]);
    }
}
