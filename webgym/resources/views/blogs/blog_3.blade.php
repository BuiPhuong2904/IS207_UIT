@extends('user.layouts.user_layout')

@section('title', 'GRYND - Trang chủ')

@section('content')

    <div class="flex flex-col md:flex-row justify-center gap-10 px-6 py-16 max-w-7xl mx-auto">

        <main class="flex-1 bg-white p-8 rounded-lg shadow-md">
            
            <!-- Tiêu đề bài viết -->
            <h2 class="text-3xl font-bold mb-4" style="color: #0D47A1; font-family: 'Montserrat', sans-serif;">
                10 Bài Tập Cardio Hiệu Quả Tại Nhà
            </h2>
            
            <p class="mb-8" style="color: #333333; font-family: 'Open Sans', sans-serif;">
                Cardio là một phần quan trọng trong bất kỳ chương trình luyện tập nào, giúp cải thiện sức khỏe tim mạch, tăng sức bền, đốt cháy calo và hỗ trợ giảm cân. Tuy nhiên, không phải ai cũng có thời gian hoặc điều kiện đến phòng gym. May mắn thay, có rất nhiều bài tập cardio đơn giản mà bạn có thể thực hiện ngay tại nhà mà không cần thiết bị phức tạp. Dưới đây là 10 bài tập cardio hiệu quả, kèm hướng dẫn chi tiết và lợi ích của từng bài.
            </p>

            <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341270/blog_3_nravn8.jpg"
                alt="10 Bài Tập Cardio Hiệu Quả Tại Nhà" 
                class="w-full rounded-lg mb-8 shadow-md">
            
            <!-- 1. Nhảy dây -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 font-open-sans text-[#1976D2]">
                    1. Nhảy dây
                </h3>
                <h4 class="text-base text-[#333333] font-open-sans">Hướng dẫn thực hiện:</h4>                
                <ol class="list-decimal pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Chọn dây nhảy có chiều dài phù hợp.
                    </li>
                    <li>
                        Đứng thẳng, hai chân đặt sát nhau, giữ dây ở hai tay.
                    </li>
                    <li>
                        Nhún gót chân bật dây qua đầu và nhảy qua dây.
                    </li>
                    <li>
                        Giữ nhịp đều, cố gắng nhảy liên tục 1-2 phút, nghỉ 30 giây và lặp lại 3-5 lần.
                    </li>
                </ol>

                <h4 class="text-base text-[#333333] font-open-sans">Lợi ích:</h4>
                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Tăng nhịp tim và sức bền.
                    </li>
                    <li>
                        Cải thiện sự phối hợp tay chân.
                    </li>
                    <li>
                        Đốt cháy calo nhanh chóng, hỗ trợ giảm mỡ toàn thân.
                    </li>
                </ul>
            </section>

            <!-- 2. Jumping Jacks (Nhảy mở rộng tay chân) -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 font-open-sans text-[#1976D2]">2. Jumping Jacks (Nhảy mở rộng tay chân)</h3>
                <h4 class="text-base text-[#333333] font-open-sans">Hướng dẫn thực hiện:</h4>                
                <ol class="list-decimal pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Đứng thẳng, chân khép, hai tay buông theo thân.
                    </li>
                    <li>
                        Nhảy lên, dang chân rộng, đồng thời đưa tay lên qua đầu.
                    </li>
                    <li>
                        Nhảy trở lại tư thế ban đầu.
                    </li>
                    <li>
                        Lặp lại liên tục 30-60 giây, 3-4 hiệp.
                    </li>
                </ol>

                <h4 class="text-base text-[#333333] font-open-sans">Lợi ích:</h4>
                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Kích hoạt toàn bộ cơ thể.
                    </li>
                    <li>
                        Tăng nhịp tim và sức bền tim mạch.
                    </li>
                    <li>
                        Không cần dụng cụ, dễ thực hiện tại nhà.
                    </li>
                </ul>
            </section>

            <!-- 3. Mountain Climbers (Leo núi) -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 font-open-sans text-[#1976D2]">3. Mountain Climbers (Leo núi)</h3>
                <h4 class="text-base text-[#333333] font-open-sans">Hướng dẫn thực hiện:</h4>                
                <ol class="list-decimal pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Bắt đầu ở tư thế plank, tay thẳng dưới vai, cơ thể thẳng từ đầu đến gót.
                    </li>
                    <li>
                        Kéo gối phải lên ngực, giữ nhịp nhanh.
                    </li>
                    <li>
                        Đổi chân, gối trái lên ngực, tay vẫn giữ plank.
                    </li>
                    <li>
                        Thực hiện nhanh, liên tục trong 30-60 giây, nghỉ 15-30 giây, lặp lại 3-5 hiệp.
                    </li>
                </ol>

                <h4 class="text-base text-[#333333] font-open-sans">Lợi ích:</h4>
                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Tăng nhịp tim, đốt mỡ hiệu quả.
                    </li>
                    <li>
                        Kết hợp tập cơ bụng, vai, chân và hông.
                    </li>
                    <li>
                        Tốt cho sức bền và linh hoạt toàn thân.
                    </li>
                </ul>
            </section>

            <!-- 4. High Knees (Chạy nâng gối cao) -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 font-open-sans text-[#1976D2]">4. High Knees (Chạy nâng gối cao)</h3>
                <h4 class="text-base text-[#333333] font-open-sans">Hướng dẫn thực hiện:</h4>                
                <ol class="list-decimal pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Đứng thẳng, hai chân rộng bằng vai.
                    </li>
                    <li>
                        Chạy tại chỗ, nâng gối lên ngang hông hoặc cao hơn.
                    </li>
                    <li>
                        Dùng tay phối hợp nhịp chạy.
                    </li>
                    <li>
                        Thực hiện liên tục 30-45 giây, nghỉ 15 giây, lặp lại 3-4 hiệp.
                    </li>
                </ol>

                <h4 class="text-base text-[#333333] font-open-sans">Lợi ích:</h4>
                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Cải thiện sức mạnh chân và tim mạch.
                    </li>
                    <li>
                        Tăng cường tốc độ phản xạ và sự linh hoạt.
                    </li>
                    <li>
                        Hỗ trợ đốt cháy calo nhanh chóng.
                    </li>
                </ul>
            </section>

            <!-- 5. Burpees -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 font-open-sans text-[#1976D2]">5. Burpees</h3>
                <h4 class="text-base text-[#333333] font-open-sans">Hướng dẫn thực hiện:</h4>                
                <ol class="list-decimal pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Đứng thẳng, chân rộng bằng vai.
                    </li>
                    <li>
                        Hạ người xuống tư thế squat, đặt tay xuống sàn.
                    </li>
                    <li>
                        Nhảy chân ra sau vào tư thế plank.
                    </li>
                    <li>
                        Thực hiện 1 hít đất (tùy chọn).
                    </li>
                    <li>
                        Nhảy chân về tư thế squat và bật nhảy lên cao.
                    </li>
                    <li>
                        Lặp lại 10-15 lần, nghỉ 30 giây, 3 hiệp.
                    </li>
                </ol>

                <h4 class="text-base text-[#333333] font-open-sans">Lợi ích:</h4>
                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Bài tập toàn thân, tác động đến tay, chân, bụng và lưng.
                    </li>
                    <li>
                        Tăng nhịp tim nhanh, đốt cháy calo hiệu quả.
                    </li>
                    <li>
                        Nâng cao sức mạnh, sức bền và khả năng chịu đựng.
                    </li>
                </ul>
            </section>

            <!-- 6. Skater Hops (Nhảy sang ngang kiểu trượt băng) -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 font-open-sans text-[#1976D2]">6. Skater Hops (Nhảy sang ngang kiểu trượt băng)</h3>
                <h4 class="text-base text-[#333333] font-open-sans">Hướng dẫn thực hiện:</h4>                
                <ol class="list-decimal pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Đứng thẳng, chân rộng bằng vai.
                    </li>
                    <li>
                        Nhảy sang trái, chân phải ra sau, tay phải chạm gần chân trái.
                    </li>
                    <li>
                        Nhảy sang phải, chân trái ra sau, tay trái chạm gần chân phải.
                    </li>
                    <li>
                        Lặp lại nhanh, liên tục trong 30-60 giây, 3-4 hiệp.
                    </li>
                </ol>

                <h4 class="text-base text-[#333333] font-open-sans">Lợi ích:</h4>
                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Tăng sức mạnh chân, cơ mông và hông.
                    </li>
                    <li>
                        Nâng cao sự cân bằng và linh hoạt.
                    </li>
                    <li>
                        Đốt cháy calo và cải thiện tim mạch.
                    </li>
                </ul>
            </section>

            <!-- 7. Jump Squats (Squat nhảy) -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 font-open-sans text-[#1976D2]">7. Jump Squats (Squat nhảy)</h3>
                <h4 class="text-base text-[#333333] font-open-sans">Hướng dẫn thực hiện:</h4>                
                <ol class="list-decimal pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Đứng thẳng, chân rộng bằng vai.
                    </li>
                    <li>
                        Hạ người xuống tư thế squat, mông hạ thấp.
                    </li>
                    <li>
                        Bật nhảy lên cao, tiếp đất nhẹ nhàng về tư thế squat.
                    </li>
                    <li>
                        Thực hiện 12-15 lần/hiệp, 3-4 hiệp.
                    </li>
                </ol>

                <h4 class="text-base text-[#333333] font-open-sans">Lợi ích:</h4>
                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Tăng sức mạnh và cơ bắp chân.
                    </li>
                    <li>
                        Cải thiện khả năng nhảy và linh hoạt.
                    </li>
                    <li>
                        Tăng nhịp tim, hỗ trợ giảm mỡ.
                    </li>
                </ul>
            </section>

            <!-- 8. Butt Kicks (Gót chân chạm mông) -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 font-open-sans text-[#1976D2]">8. Butt Kicks (Gót chân chạm mông)</h3>
                <h4 class="text-base text-[#333333] font-open-sans">Hướng dẫn thực hiện:</h4>                
                <ol class="list-decimal pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Chạy tại chỗ, gót chân cố gắng chạm mông.
                    </li>
                    <li>
                        Dùng tay phối hợp, giữ nhịp đều.
                    </li>
                    <li>
                        Thực hiện 30-60 giây, nghỉ 15-30 giây, lặp lại 3-4 hiệp.
                    </li>
                </ol>

                <h4 class="text-base text-[#333333] font-open-sans">Lợi ích:</h4>
                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Tăng cường cơ gân kheo và bắp chân.
                    </li>
                    <li>
                        Kích hoạt tim mạch nhẹ nhàng.
                    </li>
                    <li>
                        Làm nóng cơ thể trước các bài tập cường độ cao.
                    </li>
                </ul>
            </section>

            <!-- 9. Plank Jacks -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 font-open-sans text-[#1976D2]">9. Plank Jacks</h3>
                <h4 class="text-base text-[#333333] font-open-sans">Hướng dẫn thực hiện:</h4>                
                <ol class="list-decimal pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Bắt đầu ở tư thế plank, tay thẳng dưới vai.
                    </li>
                    <li>
                        Nhảy hai chân sang hai bên như động tác jumping jack.
                    </li>
                    <li>
                        Trở về tư thế plank ban đầu, lặp lại liên tục 30-45 giây.
                    </li>
                    <li>
                        Nghỉ 15 giây, thực hiện 3-4 hiệp.
                    </li>
                </ol>

                <h4 class="text-base text-[#333333] font-open-sans">Lợi ích:</h4>
                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Kết hợp tập bụng, vai, chân và tim mạch.
                    </li>
                    <li>
                        Tăng sức bền cơ thể toàn diện.
                    </li>
                    <li>
                        Đốt cháy calo nhanh, cải thiện sự linh hoạt.
                    </li>
                </ul>
            </section>            

            <!-- 10. Shadow Boxing (Đấm không đối thủ) -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 font-open-sans text-[#1976D2]">10. Shadow Boxing (Đấm không đối thủ)</h3>
                <h4 class="text-base text-[#333333] font-open-sans">Hướng dẫn thực hiện:</h4>                
                <ol class="list-decimal pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Đứng thẳng, chân rộng bằng vai, tay nắm hờ.
                    </li>
                    <li>
                        Thực hiện các động tác đấm thẳng, móc, thụt hoặc phản xạ theo nhịp.
                    </li>
                    <li>
                        Duy trì nhịp nhanh liên tục 1-2 phút, nghỉ 30 giây, 3-4 hiệp.
                    </li>
                </ol>

                <h4 class="text-base text-[#333333] font-open-sans">Lợi ích:</h4>
                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Tăng sức mạnh cánh tay, vai và cơ bụng.
                    </li>
                    <li>
                        Cải thiện tim mạch, phản xạ và tốc độ.
                    </li>
                    <li>
                        Giải tỏa căng thẳng, tăng sự linh hoạt toàn thân.
                    </li>
                </ul>
            </section>

            <!-- Tác giả -->
            <p class="text-sm font-open-sans text-[#707070] text-right italic">
                Tác giả: <strong>Nguyễn Văn A</strong><br>
                Ngày đăng: 10/09/2025
            </p>

        </main>

        <!-- Bài viết khác -->
        <aside class="w-full md:w-1/3 bg-white p-6 rounded-lg shadow-md self-start sticky top-24">
            <h4 class="text-xl font-semibold mb-4 font-open-sans text-[#1976D2] bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-[length:100%_3px] bg-no-repeat bg-bottom inline-block">
                Bài Viết Khác
            </h4>
            <ul class="space-y-3">
                <!-- Bài viết 1 -->
                <li class="flex items-center border-b border-gray-200 pb-2">
                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341272/blog_1_shlvij.jpg" 
                         alt="Yoga" 
                         class="w-15 h-15 mr-3 rounded object-cover flex-shrink-0">
                    <a href="{{ route('blog1') }}" class="font-open-sans text-[#333333] hover:text-[#145ea8]">
                        5 Lợi Ích Của Việc Tập Yoga Hàng Ngày
                    </a>
                </li>
                <!-- Bài viết 2 -->
                <li class="flex items-center border-b border-gray-200 pb-2">
                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341274/blog_2_uugz6s.jpg"
                         alt="Gym" 
                         class="w-15 h-15 mr-3 rounded object-cover flex-shrink-0">
                    <a href="{{ route('blog2') }}" class="font-open-sans text-[#333333] hover:text-[#145ea8]">
                        Chế Độ Dinh Dưỡng Cho Người Tập Gym
                    </a>
                </li>
                <!-- Bài viết 3 -->
                <li class="flex items-center border-b border-gray-200 pb-2">
                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341270/blog_3_nravn8.jpg"
                         alt="Cardio" 
                         class="w-15 h-15 mr-3 rounded object-cover flex-shrink-0">
                    <a href="{{ route('blog3') }}" class="font-open-sans text-[#333333] hover:text-[#145ea8]">
                        10 Bài Tập Cardio Hiệu Quả Tại Nhà
                    </a>
                </li>
                <!-- Bài viết 4 -->
                <li class="flex items-center pb-2">
                    <img src="{{ asset('images/about/blog_4.jpg') }}" 
                         alt="Thiền & Yoga" 
                         class="w-15 h-15 mr-3 rounded object-cover flex-shrink-0">
                    <a href="#" class="font-open-sans text-[#333333] hover:text-[#145ea8]">
                        Lợi Ích Của Thiền Và Yoga
                    </a>
                </li>
                <!-- Bài viết 5 -->
                <li class="flex items-center pb-2">
                    <img src="{{ asset('images/about/blog_5.jpg') }}" 
                         alt="Thiền & Yoga" 
                         class="w-15 h-15 mr-3 rounded object-cover flex-shrink-0">
                    <a href="#" class="font-open-sans text-[#333333] hover:text-[#145ea8]">
                        Bài Tập Stretching Giúp Giảm Đau Cơ Và Tăng Linh Hoạt
                    </a>
                </li>
                <!-- Bài viết 6 -->
                <li class="flex items-center pb-2">
                    <img src="{{ asset('images/about/blog_6.jpg') }}" 
                         alt="Thiền & Yoga" 
                         class="w-15 h-15 mr-3 rounded object-cover flex-shrink-0">
                    <a href="#" class="font-open-sans text-[#333333] hover:text-[#145ea8]">
                        Các Bài Tập Toàn Thân Hiệu Quả Chỉ Với 30 Phút Mỗi Ngày
                    </a>
                </li>
            </ul>
        </aside>


    </div>

@endsection