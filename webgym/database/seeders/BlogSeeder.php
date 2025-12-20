<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
        $posts = [
            // NHÓM 1: KHUYẾN MÃI (Tag: khuyen-mai)
            [
                'title' => 'Giáng Sinh An Lành - Tặng Thẻ Tập 1 Tháng',
                'summary' => 'Món quà sức khỏe ý nghĩa dành tặng bạn và người thân mùa Noel này.',
                'content' => '<p>Đăng ký gói tập từ 6 tháng trở lên trong dịp Giáng sinh (20/12 - 25/12) để nhận ngay voucher tập thử 1 tháng miễn phí cho bạn bè...</p>',
                'author_id' => 1,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 12), 
                'tags' => 'khuyen-mai', 
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1765634784/noel_rnildf.jpg',
            ],
            [
                'title' => 'Siêu Sale Cuối Năm: Giảm 50% Gói PT 1-1',
                'summary' => 'Cơ hội duy nhất trong năm để sở hữu HLV cá nhân với mức giá không tưởng.',
                'content' => '<p>Chương trình Year End Sale bùng nổ! Giảm ngay 50% cho 50 khách hàng đầu tiên đăng ký gói PT 30 buổi...</p>',
                'author_id' => 2,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 15),
                'tags' => 'khuyen-mai', 
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1765635185/sale_rosyxq.jpg',
            ],
            [
                'title' => 'Check-in Liền Tay - Nhận Ngay Quà Tặng',
                'summary' => 'Chụp ảnh check-in tại cây thông Noel GRYND để nhận bình nước thể thao cao cấp.',
                'content' => '<p>Chỉ cần chụp ảnh check-in và đăng lên Facebook kèm hashtag #GRYND_Xmas, bạn sẽ nhận được một bình nước...</p>',
                'author_id' => 1,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 18),
                'tags' => 'khuyen-mai',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1766214503/anh1_u919ih.jpg',
            ],
            [
                'title' => 'Flash Sale 12.12: Săn Deal Gói Tập Chỉ Từ 199k',
                'summary' => 'Duy nhất ngày 12/12, mở bán 100 gói tập trải nghiệm 2 tuần giá cực sốc.',
                'content' => '<p>Cơ hội trải nghiệm phòng tập 5 sao với giá bình dân. Đặt lịch hẹn ngay hôm nay để giữ chỗ...</p>',
                'author_id' => 2,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 10),
                'tags' => 'khuyen-mai',
                'image_url' => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Ưu Đãi Nhóm: Tập Càng Đông - Giá Càng Rẻ',
                'summary' => 'Rủ hội bạn thân đi tập để nhận ưu đãi giảm thêm 15% cho tổng hóa đơn.',
                'content' => '<p>Đăng ký nhóm từ 3 người trở lên sẽ được giảm trực tiếp 15% và tặng thêm 1 tuần tập miễn phí...</p>',
                'author_id' => 1,
                'is_published' => false,
                'published_at' => Carbon::create(2025, 12, 22),
                'tags' => 'khuyen-mai',
                'image_url' => 'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?q=80&w=800&auto=format&fit=crop',
            ],

            // NHÓM 2: KIẾN THỨC TẬP LUYỆN (Tag: kien-thuc)
            [
                'title' => 'Bí kíp giữ dáng mùa tiệc tùng cuối năm',
                'summary' => 'Làm sao để tận hưởng các bữa tiệc Tất niên mà không lo tăng cân mất kiểm soát?',
                'content' => '<p>Mẹo nhỏ: Uống nước trước khi ăn, ưu tiên đạm và rau xanh, hạn chế đồ uống có cồn...</p>',
                'author_id' => 4,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 5),
                'tags' => 'kien-thuc', 
                'image_url' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Top 5 bài tập Cardio đốt mỡ cấp tốc đón Tết',
                'summary' => 'Lấy lại vóc dáng thon gọn chỉ trong 4 tuần với lịch tập Cardio cường độ cao.',
                'content' => '<p>Hướng dẫn chi tiết lịch tập HIIT 20 phút mỗi ngày giúp đốt cháy calo hiệu quả ngay tại nhà...</p>',
                'author_id' => 5,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 1),
                'tags' => 'kien-thuc',
                'image_url' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Tại sao nên tập Gym vào mùa đông?',
                'summary' => 'Đừng để thời tiết lạnh làm bạn lười biếng. Mùa đông chính là thời điểm vàng để đốt mỡ.',
                'content' => '<p>Khi trời lạnh, cơ thể cần tiêu tốn nhiều năng lượng hơn để giữ ấm, từ đó giúp quá trình đốt calo diễn ra mạnh mẽ hơn...</p>',
                'author_id' => 6,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 8),
                'tags' => 'kien-thuc',
                'image_url' => 'https://images.unsplash.com/photo-1574680096145-d05b474e2155?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Thực Đơn Eat Clean 7 Ngày Cho Dân Văn Phòng',
                'summary' => 'Gợi ý thực đơn chuẩn bị nhanh, gọn, đủ chất cho người bận rộn muốn giảm cân.',
                'content' => '<p>Thứ 2: Ức gà nướng + Khoai lang. Thứ 3: Salad cá ngừ + Trứng luộc. Thứ 4: Bún gạo lứt...</p>',
                'author_id' => 5,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 14),
                'tags' => 'kien-thuc',
                'image_url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Uống Whey Protein Thời Điểm Nào Là Tốt Nhất?',
                'summary' => 'Tối ưu hóa việc phát triển cơ bắp bằng cách nạp protein đúng thời điểm vàng.',
                'content' => '<p>Sáng sớm sau khi ngủ dậy và ngay sau khi tập luyện là 2 thời điểm cơ thể cần nạp protein nhanh nhất...</p>',
                'author_id' => 6,
                'is_published' => false,
                'published_at' => Carbon::create(2025, 12, 29),
                'tags' => 'kien-thuc',
                'image_url' => 'https://images.unsplash.com/photo-1593095948071-474c5cc2989d?q=80&w=800&auto=format&fit=crop',
            ],

            // NHÓM 3: THÔNG BÁO (Tag: thong-bao)
            [
                'title' => 'Lịch hoạt động Tết Dương Lịch 2026',
                'summary' => 'Thông báo về thời gian mở cửa phòng tập trong dịp nghỉ lễ sắp tới.',
                'content' => '<p>Phòng tập vẫn mở cửa bình thường vào ngày 01/01/2026 nhưng khung giờ sẽ thay đổi: 8:00 - 18:00...</p>',
                'author_id' => 1,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 19),
                'tags' => 'thong-bao',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1766214395/tet_c1a8j6.jpg',
            ],
            [
                'title' => 'Bảo Trì Hệ Thống Phòng Xông Hơi',
                'summary' => 'Thông báo tạm ngưng dịch vụ Sauna để nâng cấp thiết bị.',
                'content' => '<p>Khu vực xông hơi ướt (Steam) sẽ tạm đóng cửa bảo trì vào ngày 10/12. Khu vực xông khô vẫn hoạt động bình thường...</p>',
                'author_id' => 1,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 5),
                'tags' => 'thong-bao',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1765636584/spa_hfchpi.jpg',
            ],
            [
                'title' => 'Workshop: Yoga & Thiền Định Cuối Tuần',
                'summary' => 'Mời hội viên tham gia buổi workshop miễn phí về kỹ thuật thở và thiền định.',
                'content' => '<p>Buổi workshop sẽ diễn ra vào sáng Chủ Nhật tuần này với sự hướng dẫn của Master Yoga Ấn Độ...</p>',
                'author_id' => 2,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 15),
                'tags' => 'thong-bao',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1766214721/anh3_ujs63q.jpg',
            ],
            [
                'title' => 'Cập Nhật Nội Quy Phòng Tập Mới Nhất 2026',
                'summary' => 'Một số thay đổi nhỏ trong quy định check-in và sử dụng khăn tập.',
                'content' => '<p>Kể từ ngày 01/01/2026, hội viên vui lòng mang theo thẻ từ hoặc quét mã QR trên ứng dụng để vào cửa...</p>',
                'author_id' => 1,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 1),
                'tags' => 'thong-bao',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762340414/home_nulk3t.jpg',
            ],

            // NHÓM 4: CÂU CHUYỆN KHÁCH HÀNG (Tag: story)
            [
                'title' => 'Hành trình giảm 15kg trong 3 tháng của chị Lan',
                'summary' => 'Câu chuyện đầy cảm hứng về sự kiên trì và nỗ lực thay đổi bản thân.',
                'content' => '<p>Từng tự ti về ngoại hình sau sinh, chị Lan đã tìm lại sự tự tin nhờ sự đồng hành của đội ngũ PT tại GRYND...</p>',
                'author_id' => 7,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 9),
                'tags' => 'story',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762341274/blog_2_uugz6s.jpg',
            ],
            [
                'title' => 'Từ Chàng Trai Gầy Gò Đến Body 6 Múi Săn Chắc',
                'summary' => 'Minh Tuấn và hành trình tăng 10kg cơ nạc đầy ngoạn mục.',
                'content' => '<p>Không ai tin Tuấn có thể thay đổi nhanh đến vậy chỉ sau 6 tháng kiên trì tập luyện và ăn uống khoa học...</p>',
                'author_id' => 4,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 16),
                'tags' => 'story',
                'image_url' => 'https://images.unsplash.com/photo-1583454110551-21f2fa2afe61?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Yoga Đã Giúp Tôi Chữa Lành Cơn Đau Lưng Như Thế Nào?',
                'summary' => 'Chia sẻ của bác Hùng (55 tuổi) về hiệu quả tuyệt vời của Yoga trị liệu.',
                'content' => '<p>Sau nhiều năm chịu đựng cơn đau lưng mãn tính, bác Hùng đã tìm thấy niềm vui sống nhờ các bài tập Yoga nhẹ nhàng...</p>',
                'author_id' => 5,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 12),
                'tags' => 'story',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762341272/blog_1_shlvij.jpg',
            ],
            [
                'title' => 'Cặp Đôi Cùng Tiến: Giảm Cân Để Kịp Ngày Cưới',
                'summary' => 'Thanh và Tùng đã cùng nhau giảm tổng cộng 20kg để có bộ ảnh cưới lung linh nhất.',
                'content' => '<p>Tình yêu chính là động lực lớn nhất giúp cả hai vượt qua những buổi tập Cardio mệt nhoài...</p>',
                'author_id' => 6,
                'is_published' => true,
                'published_at' => Carbon::create(2025, 12, 16),
                'tags' => 'story',
                'image_url' => 'https://res.cloudinary.com/dna9qbejm/image/upload/v1766214674/anh2_ae2ie7.jpg',
            ],
        ];

        // Chèn dữ liệu vào bảng
        foreach ($posts as $post) {
            $post['slug'] = Str::slug($post['title']);
            DB::table('blog_post')->insert($post);
        }
    }
}