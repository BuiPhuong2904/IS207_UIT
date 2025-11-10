@extends('user.layouts.user_layout')

@section('title', 'GRYND - Trang chủ')

@section('content')

    <div class="flex flex-col md:flex-row justify-center gap-10 px-6 py-16 max-w-7xl mx-auto">

        <main class="flex-1 bg-white p-8 rounded-lg shadow-md">
            
            <!-- Tiêu đề bài viết -->
            <h2 class="text-3xl font-bold mb-4 text-[#0D47A1] font-[Montserrat]">
                Chế Độ Dinh Dưỡng Cho Người Tập Gym
            </h2>
            
            <p class="text-[#333333] font-[Open_Sans]">
                Tập gym không chỉ là rèn luyện cơ thể mà còn phụ thuộc rất nhiều vào chế độ dinh dưỡng. Dinh dưỡng đúng cách giúp cơ bắp phát triển, phục hồi nhanh hơn, duy trì năng lượng và tối ưu hóa hiệu quả luyện tập. Bài viết này sẽ cung cấp cho bạn một hướng dẫn toàn diện về các thực phẩm, bữa ăn và thói quen dinh dưỡng cần thiết cho người tập gym.
            </p>

            <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341274/blog_2_uugz6s.jpg"
                alt="Chế Độ Dinh Dưỡng Cho Người Tập Gym" 
                class="w-full rounded-lg mb-8 shadow-md">
            
            <!-- 1. Vai trò của dinh dưỡng trong tập gym -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 text-[#1976D2] font-open-sans">
                    1. Vai trò của dinh dưỡng trong tập gym
                </h3>
                
                <p class="text-[#333333] font-[Open_Sans]">
                    Khi luyện tập, cơ thể bạn không chỉ đốt năng lượng mà còn phá vỡ các sợi cơ. Dinh dưỡng hợp lý giúp:
                </p>

                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Cung cấp năng lượng: Carbohydrate là nguồn nhiên liệu chính để tập luyện, giúp duy trì sức bền và sức mạnh trong suốt buổi tập.
                    </li>
                    <li>
                        Hỗ trợ phục hồi cơ bắp: Protein giúp sửa chữa các sợi cơ bị tổn thương, đồng thời tăng cường sự phát triển cơ bắp.
                    </li>
                    <li>
                        Cân bằng hormone: Các chất béo lành mạnh tham gia vào việc sản xuất hormone quan trọng như testosterone và estrogen, ảnh hưởng trực tiếp đến sự phát triển cơ bắp và sức khỏe tổng thể.
                    </li>
                    <li>
                        Tối ưu hóa sức khỏe tổng thể: Vitamin và khoáng chất hỗ trợ hệ miễn dịch, giảm viêm, duy trì năng lượng và sức bền.
                    </li>
                </ul>

                <p class="text-[#333333] font-[Open_Sans]">
                    Không có chế độ dinh dưỡng hợp lý, việc tập gym sẽ khó đạt hiệu quả tối đa, thậm chí có thể gây mệt mỏi, chấn thương hoặc tăng cân không kiểm soát.
                </p>
            </section>

            <!-- 2. Các nhóm thực phẩm quan trọng -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 text-[#1976D2] font-open-sans">2. Các nhóm thực phẩm quan trọng</h3>
                
                <h4 class="text-xl text-[#5c5c5c] font-open-sans font-semibold">2.1 Protein - Xây dựng và phục hồi cơ bắp</h4>

                <p class="text-[#333333] font-[Open_Sans]">
                    Protein là thành phần thiết yếu cho sự phát triển cơ bắp và phục hồi sau tập luyện. Các nguồn protein chất lượng cao bao gồm:
                </p>

                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Thịt nạc: Ức gà, thịt bò nạc, thịt lợn nạc.
                    </li>
                    <li>
                        Hải sản: Cá hồi, cá ngừ, tôm, cua.
                    </li>
                    <li>
                        Trứng: Nguồn protein hoàn chỉnh, giàu leucine - acid amin quan trọng cho cơ bắp.
                    </li>
                    <li>
                        Sữa và sản phẩm từ sữa: Sữa tách béo, sữa chua Hy Lạp, phô mai ít béo.
                    </li>
                    <li>
                        Nguồn thực vật: Đậu hũ, đậu nành, các loại đậu, hạt chia, quinoa.
                    </li>
                </ul>

                <p class="text-[#333333] font-[Open_Sans]">
                    Lời khuyên: Người tập gym nên tiêu thụ khoảng 1,6-2,2g protein/kg trọng lượng cơ thể mỗi ngày, chia đều vào các bữa ăn để cơ thể hấp thụ hiệu quả.<br><br>
                </p>

                <h4 class="text-xl text-[#5c5c5c] font-open-sans font-semibold">2.2 Carbohydrate - Nguồn năng lượng chính</h4>

                <p class="text-[#333333] font-[Open_Sans]">
                    Carbohydrate là nhiên liệu chính cho cơ bắp hoạt động, đặc biệt trong các bài tập cường độ cao như HIIT hoặc nâng tạ nặng.
                </p>

                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Carbohydrate phức tạp: Gạo lứt, yến mạch, khoai lang, quinoa. Giúp duy trì năng lượng lâu dài và ổn định đường huyết.
                    </li>
                    <li>
                        Carbohydrate đơn giản: Trái cây như chuối, táo, dứa. Dùng trước hoặc sau tập luyện để nhanh chóng bổ sung glycogen cho cơ bắp.
                    </li>
                </ul>

                <p class="text-[#333333] font-[Open_Sans]">
                    Lời khuyên: Tùy vào mục tiêu tăng cơ hay giảm mỡ, lượng carb nên chiếm 40-60% tổng năng lượng hàng ngày.<br><br>
                </p>                

                <h4 class="text-xl text-[#5c5c5c] font-open-sans font-semibold">2.3 Chất béo lành mạnh - Hormone và năng lượng</h4>
                <p class="text-[#333333] font-[Open_Sans]">
                    Chất béo lành mạnh không chỉ cung cấp năng lượng mà còn hỗ trợ sản xuất hormone và bảo vệ tim mạch:
                </p>
                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Nguồn omega-3: Cá hồi, cá mòi, hạt chia, hạt lanh. Giúp giảm viêm và hỗ trợ phục hồi cơ bắp.
                    </li>
                    <li>
                        Nguồn omega-6 và chất béo đơn: Dầu olive, dầu dừa, bơ, các loại hạt.
                    </li>
                </ul>
                <p class="text-[#333333] font-[Open_Sans]">
                    Lời khuyên: Chất béo nên chiếm 20-30% tổng năng lượng, ưu tiên các loại không bão hòa và hạn chế chất béo bão hòa từ đồ chiên, thực phẩm chế biến sẵn.<br><br>
                </p> 

                <h4 class="text-xl text-[#5c5c5c] font-open-sans font-semibold">2.4 Vitamin và khoáng chất - Tối ưu hóa sức khỏe</h4>
                <p class="text-[#333333] font-[Open_Sans]">
                    Tập gym làm cơ thể tiêu hao nhiều chất dinh dưỡng, do đó cần bổ sung:
                </p>
                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Vitamin nhóm B: Hỗ trợ chuyển hóa năng lượng từ thức ăn.
                    </li>
                    <li>
                        Vitamin D: Giúp hấp thụ canxi, tăng sức khỏe xương.
                    </li>
                    <li>
                        Canxi và Magie: Tăng cường co duỗi cơ, giảm chuột rút.
                    </li>
                    <li>
                        Kali và Natri: Duy trì cân bằng điện giải, ngăn mệt mỏi cơ bắp.
                    </li>
                </ul>
                <p class="text-[#333333] font-[Open_Sans]">
                    Bổ sung từ rau xanh, trái cây tươi, các loại hạt và sữa sẽ giúp cơ thể khỏe mạnh và năng lượng ổn định.
                </p>                 

            </section>

            <!-- 3. Thời điểm ăn uống lý tưởng cho người tập gym -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 text-[#1976D2] font-open-sans">3. Thời điểm ăn uống lý tưởng cho người tập gym</h3>
                
                <p class="text-[#333333] font-[Open_Sans]">
                    Thời điểm ăn uống ảnh hưởng lớn đến hiệu quả tập luyện và phục hồi:
                </p>

                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Trước tập (30-60 phút): Ăn nhẹ giàu carbohydrate và protein dễ tiêu, như chuối + sữa chua, yến mạch + sữa tách béo.
                    </li>
                    <li>
                        Sau tập (30-60 phút): Bổ sung protein nhanh hấp thu và carbs để phục hồi glycogen. Ví dụ: shake protein + trái cây hoặc ức gà + khoai lang.
                    </li>
                    <li>
                        Các bữa chính còn lại: Ăn cân bằng giữa protein, carbs và chất béo lành mạnh, kèm rau củ tươi.
                    </li>
                </ul>

                <p class="text-[#333333] font-[Open_Sans]">
                    Thói quen ăn uống đều đặn giúp cơ thể luôn có năng lượng và cơ bắp phục hồi tối ưu.
                </p>
            </section>

            <!-- 4. Nước - Yếu tố quan trọng không thể bỏ qua -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 text-[#1976D2] font-open-sans">4. Nước - Yếu tố quan trọng không thể bỏ qua</h3>
                
                <p class="text-[#333333] font-[Open_Sans]">
                    Uống đủ nước rất quan trọng cho người tập gym:
                </p>

                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Giúp cơ bắp hoạt động hiệu quả.
                    </li>
                    <li>
                        Ngăn ngừa mệt mỏi và chuột rút.
                    </li>
                    <li>
                        Hỗ trợ quá trình chuyển hóa chất dinh dưỡng và loại bỏ chất thải.
                    </li>
                </ul>

                <p class="text-[#333333] font-[Open_Sans]">
                    Lời khuyên: Uống 1,5-2 lít nước/ngày, tăng lượng nếu tập luyện cường độ cao hoặc thời tiết nóng.
                </p>
            </section>

            <!-- 5. Thực phẩm nên tránh -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 text-[#1976D2] font-open-sans">5. Thực phẩm nên tránh</h3>

                <ul class="list-disc pl-8 text-justify mb-2 font-open-sans text-[#333333]">
                    <li>
                        Đồ ngọt, nước có ga: Dễ tăng mỡ, ít dinh dưỡng.
                    </li>
                    <li>
                        Đồ chiên rán, thức ăn nhanh: Chứa nhiều chất béo xấu, gây viêm và giảm hiệu quả luyện tập.
                    </li>
                    <li>
                        Rượu bia: Ảnh hưởng đến phục hồi cơ bắp và hormone.
                    </li>
                </ul>

                <p class="text-[#333333] font-[Open_Sans]">
                    Hạn chế những thực phẩm này sẽ giúp bạn đạt mục tiêu tập luyện nhanh hơn và duy trì sức khỏe lâu dài.
                </p>
            </section>

            <!-- Kết luận -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2 text-[#1976D2] font-open-sans">Kết luận</h3>
                <p class="text-[#333333] font-[Open_Sans]">
                    Chế độ dinh dưỡng đóng vai trò then chốt trong việc tối ưu hóa kết quả tập gym. Một chế độ hợp lý giúp cơ bắp phát triển, phục hồi nhanh, duy trì năng lượng và cải thiện sức khỏe tổng thể. Kết hợp thực phẩm giàu protein, carbohydrate phức tạp, chất béo lành mạnh, vitamin và khoáng chất, cùng với thói quen ăn uống đúng giờ, sẽ giúp bạn đạt hiệu quả tập luyện tối đa và duy trì một cơ thể khỏe mạnh, cân đối.
                </p>
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