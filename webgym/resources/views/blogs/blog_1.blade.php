@extends('user.layouts.user_layout')

@section('title', 'GRYND - Trang chủ')

@section('content')

    <div class="flex flex-col md:flex-row justify-center gap-10 px-6 py-16 max-w-7xl mx-auto">

        <main class="flex-1 bg-white p-8 rounded-lg shadow-md">

            <!-- Tiêu đề bài viết -->
            <h2 class="text-3xl font-bold mb-4" style="color: #0D47A1; font-family: 'Montserrat', sans-serif;">
                5 Lợi Ích Của Việc Tập Yoga Hàng Ngày
            </h2>
            
            <p class="mb-8" style="color: #333333; font-family: 'Open Sans', sans-serif;">
                Yoga, một phương pháp tập luyện cổ xưa xuất phát từ Ấn Độ, 
                đã trở thành một phần quan trọng trong lối sống hiện đại 
                nhờ những lợi ích vượt trội mà nó mang lại cho cả cơ thể lẫn tâm trí. 
                Tập yoga không chỉ đơn thuần là những động tác uốn dẻo mà còn là một hành trình kết hợp giữa hơi thở, 
                tinh thần và cơ thể. Dưới đây là 5 lợi ích nổi bật mà việc tập yoga hàng ngày có thể mang đến cho bạn.
            </p>

            <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341272/blog_1_shlvij.jpg" 
                alt="Yoga" 
                class="w-full rounded-lg mb-8 shadow-md">
            
            <!-- Lợi ích 1 -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2" style="color: #1976D2; font-family: 'Open Sans', sans-serif;">
                    1. Cải thiện sự linh hoạt và sức mạnh cơ bắp
                </h3>
                
                <p class="mb-2 text-justify">
                    Một trong những lợi ích dễ nhận thấy nhất khi tập yoga là khả năng tăng cường linh hoạt và sức mạnh cơ bắp. 
                    Các động tác yoga đòi hỏi cơ thể uốn dẻo, kéo giãn và giữ thăng bằng, 
                    từ đó giúp các cơ, khớp và dây chằng trở nên dẻo dai hơn.
                </p>

                <ul class="list-disc pl-8 text-justify mb-2">
                    <li>
                        Linh hoạt: Tập yoga hàng ngày giúp các khớp vận động trơn tru, giảm nguy cơ chấn thương, 
                        đồng thời cải thiện tư thế cơ thể. Các động tác như “Downward Dog” hay “Cobra Pose” giúp kéo giãn lưng, 
                        cổ và chân, giúp cơ thể cảm thấy nhẹ nhàng và linh hoạt hơn.
                    </li>
                    <li>
                        Sức mạnh: Yoga không chỉ tập trung vào linh hoạt mà còn tăng cường sức mạnh cho các nhóm cơ chính, 
                        bao gồm cơ lưng, cơ bụng và cơ chân. Các động tác giữ thăng bằng lâu như “Plank” hay “Warrior” 
                        giúp phát triển sức mạnh tĩnh, đồng thời hỗ trợ cải thiện sức bền.
                    </li>
                </ul>

                <p class="text-justify">
                    Theo các nghiên cứu, việc tập luyện thường xuyên có thể giúp tăng sức mạnh cơ bắp lên đến 20% chỉ sau vài tuần, 
                    đồng thời giảm căng thẳng cơ thể và mệt mỏi.
                </p>
            </section>

            <!-- Lợi ích 2 -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2" style="color: #1976D2; font-family: 'Open Sans', sans-serif;">2. Giảm căng thẳng và lo âu</h3>
                
                <p class="mb-2 text-justify">
                    Một trong những lý do chính mà nhiều người tìm đến yoga là để giảm căng thẳng. 
                    Trong cuộc sống hiện đại, áp lực từ công việc, học tập và các mối quan hệ khiến tinh thần 
                    dễ rơi vào trạng thái lo âu, mệt mỏi. Yoga giúp cân bằng cảm xúc thông qua các bài tập thở 
                    và thiền định.
                </p>

                <ul class="list-disc pl-8 text-justify mb-2">
                    <li>
                        Bài tập thở (Pranayama): Kiểm soát hơi thở giúp làm dịu hệ thần kinh, 
                        giảm nhịp tim và hạ huyết áp. Hơi thở chậm và sâu làm cơ thể thư giãn, 
                        đồng thời giúp tâm trí tập trung và bình tĩnh hơn.
                    </li>
                    <li>
                        Thiền định: Yoga không chỉ là thể chất mà còn là tinh thần. 
                        Thiền định giúp bạn làm quen với việc quan sát suy nghĩ mà không phán xét, 
                        từ đó giảm cảm giác lo âu, căng thẳng.
                    </li>
                </ul>

                <p class="text-justify">
                    Nhiều nghiên cứu khoa học đã chứng minh rằng tập yoga thường xuyên có thể giảm mức cortisol (hormone căng thẳng) 
                    trong cơ thể, giúp cải thiện tâm trạng và tạo cảm giác hạnh phúc lâu dài.
                </p>
            </section>

            <!-- Lợi ích 3 -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2" style="color: #1976D2; font-family: 'Open Sans', sans-serif;">3. Hỗ trợ sức khỏe tim mạch</h3>
                
                <p class="mb-2 text-justify">
                    Yoga còn được coi là một phương pháp hiệu quả để bảo vệ sức khỏe tim mạch. 
                    Mặc dù không phải là bài tập cardio cường độ cao, nhưng yoga giúp tăng tuần hoàn máu, 
                    giảm huyết áp và kiểm soát nhịp tim.
                </p>

                <ul class="list-disc pl-8 text-justify mb-2">
                    <li>
                        Tăng tuần hoàn máu: Các động tác uốn dẻo và đảo ngược cơ thể (inversions) 
                        giúp máu lưu thông tốt hơn, cải thiện oxy hóa các cơ quan trong cơ thể.
                    </li>
                    <li>
                        Giảm huyết áp: Nhiều nghiên cứu cho thấy tập yoga đều đặn có thể giảm huyết áp tâm thu 
                        và tâm trương, hỗ trợ ngăn ngừa các bệnh tim mạch.
                    </li>
                    <li>
                        Cân bằng nhịp tim: Nhờ việc điều hòa hơi thở và thư giãn cơ thể, yoga giúp tim đập đều hơn, 
                        giảm nguy cơ các vấn đề liên quan đến tim.
                    </li>
                </ul>

                <p class="text-justify">
                    Việc kết hợp yoga với chế độ ăn uống lành mạnh có thể giúp bạn duy trì trái tim khỏe mạnh 
                    và kéo dài tuổi thọ.
                </p>
            </section>

            <!-- Lợi ích 4 -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2" style="color: #1976D2; font-family: 'Open Sans', sans-serif;">4. Cải thiện chất lượng giấc ngủ</h3>
                
                <p class="mb-2 text-justify">
                    Giấc ngủ đóng vai trò quan trọng trong việc hồi phục cơ thể và tinh thần. 
                    Tập yoga hàng ngày giúp cơ thể thư giãn và chuẩn bị tốt hơn cho giấc ngủ, 
                    đặc biệt là những người gặp khó khăn trong việc đi vào giấc ngủ.
                </p>

                <ul class="list-disc pl-8 text-justify mb-2">
                    <li>
                        Giảm căng cơ: Các bài tập yoga giúp giảm mệt mỏi cơ bắp và căng thẳng, 
                        từ đó giúp cơ thể dễ dàng chìm vào giấc ngủ sâu hơn.
                    </li>
                    <li>
                        Thư giãn tinh thần: Kết hợp thiền và thở sâu trước khi đi ngủ giúp tâm trí không còn bận rộn với lo lắng 
                        hay suy nghĩ tiêu cực.
                    </li>
                    <li>
                        Cân bằng nhịp sinh học: Tập yoga vào buổi tối giúp điều hòa nhịp sinh học, 
                        cải thiện chu kỳ giấc ngủ và nâng cao chất lượng nghỉ ngơi.
                    </li>
                </ul>

                <p class="text-justify">
                    Các nghiên cứu cho thấy người tập yoga thường xuyên có thời gian ngủ trung bình dài hơn 
                    và ít gặp tình trạng thức giấc giữa đêm.
                </p>
            </section>

            <!-- Lợi ích 5 -->
            <section class="mb-8">
                <h3 class="text-2xl font-semibold mb-2" style="color: #1976D2; font-family: 'Open Sans', sans-serif;">5. Tăng cường sự tập trung và minh mẫn</h3>
                
                <p class="mb-2 text-justify">
                    Yoga không chỉ tác động đến cơ thể mà còn giúp trí óc minh mẫn và tập trung hơn. 
                    Việc kết hợp các động tác thể chất với thiền và thở giúp não bộ hoạt động hiệu quả, 
                    tăng khả năng tập trung và sáng tạo.
                </p>

                <ul class="list-disc pl-8 text-justify mb-2">
                    <li>
                        Cải thiện trí nhớ: Thực hành yoga giúp tăng lưu lượng máu lên não, 
                        hỗ trợ các chức năng nhận thức và trí nhớ.
                    </li>
                    <li>
                        Giảm stress thần kinh: Yoga giúp hệ thần kinh cân bằng, giảm căng thẳng và lo âu, 
                        từ đó cải thiện khả năng ra quyết định và xử lý thông tin.
                    </li>
                    <li>
                        Tăng sự tập trung: Bằng việc học cách điều hòa hơi thở và chú ý vào từng động tác, 
                        bạn sẽ rèn luyện khả năng tập trung lâu dài, áp dụng hiệu quả vào công việc và học tập.
                    </li>
                </ul>

                <p class="text-justify">
                    Người tập yoga đều đặn thường báo cáo rằng họ cảm thấy tinh thần minh mẫn hơn, 
                    ít mệt mỏi và dễ dàng đối phó với áp lực hàng ngày.
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
            <h4 class="text-xl font-semibold mb-2 font-open-sans text-[#1976D2]">Bài Viết Khác</h4>
            <ul class="space-y-3">
                <li><a href="{{ route('blog1') }}" class="font-open-sans text-[#333333] hover:text-[#145ea8]">5 Lợi Ích Của Việc Tập Yoga Hàng Ngày</a></li>
                <li><a href="{{ route('blog2') }}" class="font-open-sans text-[#333333] hover:text-[#145ea8]">Chế Độ Dinh Dưỡng Cho Người Tập Gym</a></li>
                <li><a href="{{ route('blog3') }}" class="font-open-sans text-[#333333] hover:text-[#145ea8]">10 Bài Tập Cardio Hiệu Quả Tại Nhà</a></li>
                <li><a href="#" class="font-open-sans text-[#333333] hover:text-[#145ea8]">Lợi Ích Của Thiền Và Yoga</a></li>
            </ul>
        </aside>

    </div>

@endsection