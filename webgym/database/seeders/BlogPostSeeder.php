<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa sạch dữ liệu
        DB::table('blog_post')->truncate();

        $today = Carbon::parse('2025-11-14');

        // Tạo blog_post
        DB::table('blog_post')->insert([

            // Bài 1: Lợi ích Yoga
            [
                'title' => '5 Lợi Ích Của Việc Tập Yoga Hàng Ngày',
                'slug' => Str::slug('5 Lợi Ích Của Việc Tập Yoga Hàng Ngày'),
                'summary' => 'Khám phá cách yoga có thể cải thiện sức khỏe thể chất và tinh thần của bạn.',
                'content' => '<h3>1. Cải thiện sự dẻo dai</h3><p>Tập yoga hàng ngày giúp kéo giãn cơ bắp, tăng phạm vi chuyển động của khớp...</p><h3>2. Giảm căng thẳng</h3><p>Yoga tập trung vào hơi thở và thiền định, giúp làm dịu hệ thần kinh...</p><p>...</p>',
                'author_id' => 4,
                'is_published' => true,
                'published_at' => $today->copy()->subDays(10), 
                'tags' => 'yoga, sức khỏe, dẻo dai, tinh thần',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762341272/blog_1_shlvij.jpg',
                'created_at' => $today->copy()->subDays(10),
                'updated_at' => $today->copy()->subDays(10),
            ],
            // Bài 2: Dinh dưỡng
            [
                'title' => 'Chế Độ Dinh Dưỡng Cho Người Tập Gym',
                'slug' => Str::slug('Chế Độ Dinh Dưỡng Cho Người Tập Gym'),
                'summary' => 'Tìm hiểu những thực phẩm tốt nhất để hỗ trợ quá trình tập luyện của bạn.',
                'content' => '<h3>Macro là gì? (Protein, Carbs, Fat)</h3><p>Một chế độ ăn cân bằng cho người tập gym cần đảm bảo đủ 3 yếu tố đa lượng này. Protein để xây cơ, Carbs để cung cấp năng lượng, và Fat tốt để hỗ trợ hormone...</p>',
                'author_id' => 5,
                'is_published' => true,
                'published_at' => $today->copy()->subDays(5),
                'tags' => 'dinh dưỡng, ăn uống, protein, macro',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762341274/blog_2_uugz6s.jpg',
                'created_at' => $today->copy()->subDays(5),
                'updated_at' => $today->copy()->subDays(5),
            ],
            // Bài 3: Cardio
            [
                'title' => '10 Bài Tập Cardio Hiệu Quả Tại Nhà',
                'slug' => Str::slug('10 Bài Tập Cardio Hiệu Quả Tại Nhà'),
                'summary' => 'Các bài tập đơn giản giúp bạn đốt cháy calo và cải thiện sức khỏe tim mạch.',
                'content' => '<h3>Không cần dụng cụ, chỉ cần bạn!</h3><p>Dưới đây là 10 bài tập cardio bạn có thể thực hiện ngay tại nhà:</p><ol><li>Jumping Jacks</li><li>Burpees</li><li>High Knees</li><li>...</li></ol>',
                'author_id' => 10,
                'is_published' => true,
                'published_at' => $today->copy()->subDays(2),
                'tags' => 'cardio, tại nhà, giảm cân, tim mạch',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762341270/blog_3_nravn8.jpg',
                'created_at' => $today->copy()->subDays(2),
                'updated_at' => $today->copy()->subDays(2),
            ],

            // Bài 4: Về HIIT
            [
                'title' => 'HIIT Là Gì? Hướng Dẫn Bài Tập HIIT Cho Người Mới Bắt Đầu',
                'slug' => Str::slug('HIIT Là Gì Hướng Dẫn Bài Tập HIIT Cho Người Mới Bắt Đầu'),
                'summary' => 'Tập luyện cường độ cao ngắt quãng (HIIT) là cách nhanh nhất để đốt mỡ. Đây là hướng dẫn cho người mới.',
                'content' => '<h3>HIIT (High-Intensity Interval Training)</h3><p>Đây là phương pháp tập luyện bao gồm các khoảng thời gian tập luyện cường độ cao xen kẽ với các khoảng thời gian nghỉ ngơi ngắn...</p><h3>Bài tập mẫu:</h3><ul><li>20s Burpees</li><li>10s nghỉ</li><li>20s Jumping Jacks</li><li>10s nghỉ</li></ul>',
                'author_id' => 8,
                'is_published' => true,
                'published_at' => $today->copy()->subDays(15),
                'tags' => 'workout, hiit, cardio, giảm cân',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340662/class_HIIT_hziu98.jpg',
                'created_at' => $today->copy()->subDays(15),
                'updated_at' => $today->copy()->subDays(15),
            ],
            // Bài 5: Bài thông báo (Admin)
            [
                'title' => 'THÔNG BÁO: Khuyến mãi Black Friday - Giảm 30% Gói Tập',
                'slug' => Str::slug('Thông Báo Khuyến mãi Black Friday Giảm 30% Gói Tập'),
                'summary' => 'Cơ hội lớn nhất năm! Đăng ký Gói Năm ngay hôm nay để nhận ưu đãi giảm 30%, áp dụng từ 20/11 đến 30/11.',
                'content' => '<h3>Black Friday Đã Đến!</h3><p>Nhân dịp Black Friday, phòng gym xin gửi tặng quý hội viên chương trình khuyến mãi SỐC NHẤT NĂM. Giảm 30% Gói Tập 12 Tháng khi đăng ký trong tháng 11...</p>',
                'author_id' => 1,
                'is_published' => true,
                'published_at' => $today,
                'tags' => 'khuyến mãi, thông báo, black friday',
                'image_url' => null,
                'created_at' => $today,
                'updated_at' => $today,
            ],
            // Bài 6: Bài về Pilates
            [
                'title' => 'Pilates 101: Tại Sao Bộ Môn Này Lại Hot Đến Vậy?',
                'slug' => Str::slug('Pilates 101 Tại Sao Bộ Môn Này Lại Hot Đến Vậy'),
                'summary' => 'Pilates không chỉ dành cho phái nữ. Nó giúp tăng cường sức mạnh cơ lõi (core) và cải thiện vóc dáng đáng kể.',
                'content' => '<h3>Pilates là gì?</h3><p>Pilates là một phương pháp tập luyện tập trung vào việc tăng cường sức mạnh cơ bắp, đặc biệt là cơ lõi (core), cải thiện tư thế và sự linh hoạt...</p>',
                'author_id' => 9, 
                'is_published' => true,
                'published_at' => $today->copy()->addDays(5), // Sẽ đăng trong 5 ngày nữa
                'tags' => 'pilates, core, vóc dáng',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340663/class_pilates_b1irhb.jpg',
                'created_at' => $today,
                'updated_at' => $today,
            ],
            // Bài 7: Bài nháp (Draft)
            [
                'title' => '[Bản nháp] Kỹ thuật đấm Boxing cơ bản',
                'slug' => Str::slug('Bản nháp Kỹ thuật đấm Boxing cơ bản'),
                'summary' => 'Hướng dẫn kỹ thuật đấm jab, cross, hook cho người mới.',
                'content' => '<h3>1. Đấm thẳng (Jab)</h3><p>...</p><h3>2. Đấm móc (Hook)</h3><p>...</p>',
                'author_id' => 6,
                'is_published' => false,
                'published_at' => null, // Chưa đăng
                'tags' => 'boxing, kỹ thuật, người mới',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340668/class_boxing_jgare2.jpg',
                'created_at' => $today->copy()->subDays(1),
                'updated_at' => $today,
            ],
        ]);
    }
}