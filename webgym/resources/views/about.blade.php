@extends('user.layouts.user_layout')

@section('title', 'GRYND - Trang chủ')

@section('content')
    <section>
        <img src="{{ asset('images/about/about.jpg') }}"
            alt="Grynd Gym"
            class="w-full h-64 object-cover object-[center_65%]">
    </section>

    <div class="flex">

        <aside class="w-64 h-fit sticky top-24 m-4 bg-white px-6 py-8 flex flex-col 
                    border border-gray-300 rounded-xl shadow-lg">
            
            <h2 class="text-xl font-bold mb-6 font-montserrat text-[#0D47A1]">Về GRYND</h2>
            <nav class="space-y-3">
                <a href="#about" class="block text-gray-600 hover:text-blue-600 font-medium">Về GRYND</a>
                <a href="#history" class="block text-gray-600 hover:text-blue-600 font-medium">Lịch sử</a>
                <a href="#mission" class="block text-gray-600 hover:text-blue-600 font-medium">Sứ mệnh</a>
                <a href="#vision" class="block text-gray-600 hover:text-blue-600 font-medium">Tầm nhìn</a>
                <a href="#branches" class="block text-gray-600 hover:text-blue-600 font-medium">Các chi nhánh</a>
                <a href="#services" class="block text-gray-600 hover:text-blue-600 font-medium">Dịch vụ</a>
                <a href="#products" class="block text-gray-600 hover:text-blue-600 font-medium">Sản phẩm</a>
                <a href="#values" class="block text-gray-600 hover:text-blue-600 font-medium">Giá trị cốt lõi</a>
                <a href="#help" class="block text-gray-600 hover:text-blue-600 font-medium">Triết lý hoạt động</a>
                <a href="#contact" class="block text-gray-600 hover:text-blue-600 font-medium">Liên hệ</a>
            </nav>
        </aside>

        <main class="flex-1 px-10 py-10">
            <section id="about" class="mb-16 scroll-mt-24">
                <h2 class="text-2xl font-extrabold pb-2 mb-4 border-b-2 border-blue-600 font-montserrat text-[#292929]">Về GRYND</h2>
                <p class="text-base leading-relaxed text-justify font-open-sans text-[#333333]">
                    <strong>GRYND</strong> được thành lập vào năm <strong>2025</strong> bởi một nhóm huấn luyện viên thể hình và chuyên gia dinh dưỡng giàu kinh nghiệm, 
                    cùng chia sẻ chung một ước mơ và khát vọng về xây dựng một môi trường tập luyện chuyên nghiệp, 
                    hiện đại và tràn đầy cảm hứng dành cho tất cả những ai yêu thích thể thao và mong muốn cải thiện sức khỏe. 
                    Với tầm nhìn trở thành hệ thống phòng gym hàng đầu Việt Nam, <strong>GRYND</strong> cam kết mang đến cho khách hàng những trải nghiệm tập luyện tốt nhất, 
                    kết hợp giữa công nghệ tiên tiến, thiết bị hiện đại và đội ngũ huấn luyện viên tận tâm, chuyên nghiệp.
                </p>
            </section>

            <section id="history" class="mb-16 scroll-mt-24">
                <h2 class="text-2xl font-extrabold pb-2 mb-4 border-b-2 border-blue-600 font-montserrat text-[#292929]">Lịch sử</h2>
                <p class="text-base leading-relaxed text-justify font-open-sans text-[#333333]">
                    Khởi đầu khiêm tốn từ một phòng tập nhỏ với diện tích chưa đến 200m², <strong>GRYND</strong> đã không ngừng nỗ lực đổi mới và phát triển, 
                    chú trọng cả về cơ sở vật chất lẫn chất lượng dịch vụ. Nhờ vào tinh thần tận tâm, sự chuyên nghiệp của đội ngũ huấn luyện viên cùng phương pháp huấn luyện khoa học, 
                    <strong>GRYND</strong> nhanh chóng trở thành một thương hiệu được đông đảo học viên tin tưởng và yêu mến. Đến nay, <strong>GRYND</strong> đã phát triển thành một chuỗi trung tâm thể hình uy tín, 
                    phục vụ hàng chục nghìn học viên trên khắp cả nước, góp phần lan tỏa lối sống lành mạnh, năng động và tích cực đến cộng đồng. 
                    Chỉ trong vài tháng ngắn ngủi, chúng tôi đã tổ chức hàng chục sự kiện thể thao và 
                    trở thành đối tác chiến lược của nhiều thương hiệu quốc tế như <em>Optimum Nutrition</em> và <em>GymShark</em>.
                </p>
            </section>

            <section id="mission" class="mb-16 scroll-mt-24">
                <h2 class="text-2xl font-extrabold pb-2 mb-4 border-b-2 border-blue-600 font-montserrat text-[#292929]">Sứ mệnh</h2>
                <p class="text-base leading-relaxed text-justify font-open-sans text-[#333333]">
                    <strong>GRYND</strong> mang trong mình sứ mệnh cao cả là giúp mọi người học cách yêu thương 
                    và trân trọng bản thân hơn thông qua việc rèn luyện cả thể chất lẫn tinh thần. 
                    Chúng tôi tin rằng tập luyện không chỉ đơn thuần là để có một vóc dáng đẹp, 
                    mà quan trọng hơn là để có một cơ thể khỏe mạnh, một tinh thần tích cực và một lối sống tràn đầy năng lượng. 
                    Mỗi buổi tập, mỗi giọt mồ hôi rơi xuống là một bước tiến nhỏ trên hành trình hoàn thiện chính mình — hành trình hướng đến sự tự tin, 
                    kiên cường và hạnh phúc hơn mỗi ngày.<br><br>

                    Sứ mệnh ấy được <strong>GRYND</strong> thể hiện rõ nét thông qua ba giá trị cốt lõi. 
                    Trước hết, chúng tôi mong muốn truyền cảm hứng về một lối sống lành mạnh đến mọi người, 
                    giúp mỗi cá nhân nhận ra tầm quan trọng của việc chăm sóc sức khỏe thể chất và tinh thần. 
                    Tiếp đến, Grynd cam kết mang đến một môi trường tập luyện chuyên nghiệp, tiện nghi và an toàn, 
                    nơi mỗi học viên có thể yên tâm phát triển bản thân trong không gian năng động và hiện đại. 
                    Cuối cùng, chúng tôi luôn nỗ lực đồng hành cùng từng hội viên trên hành trình thay đổi bản thân, 
                    không chỉ với vai trò là người hướng dẫn mà còn là người bạn, người truyền động lực, giúp họ vượt qua giới hạn và đạt được mục tiêu mong muốn.<br><br>

                    Với sứ mệnh và giá trị ấy, <strong>GRYND</strong> không chỉ là một trung tâm thể hình - mà còn là nơi khơi nguồn năng lượng tích cực, 
                    nuôi dưỡng tinh thần và tạo nên những thay đổi bền vững cho cuộc sống của mỗi người.
                </p>
            </section>

            <section id="vision" class="mb-16 scroll-mt-24">
                <h2 class="text-2xl font-extrabold pb-2 mb-4 border-b-2 border-blue-600 font-montserrat text-[#292929]">Tầm nhìn</h2>
                <p class="text-base leading-relaxed text-justify font-open-sans text-[#333333]">
                    Tầm nhìn đến năm 2030, <strong>GRYND</strong> đặt mục tiêu trở thành chuỗi phòng gym hàng đầu khu vực Đông Nam Á, 
                    không chỉ về quy mô mà còn về chất lượng dịch vụ và trải nghiệm hội viên. 
                    Chúng tôi hướng tới việc xây dựng một hệ sinh thái thể thao toàn diện, 
                    nơi công nghệ và con người hòa quyện để mang lại giá trị tối ưu cho sức khỏe và phong cách sống của mỗi cá nhân.<br><br>

                    <strong>GRYND</strong> sẽ phát triển hệ thống quản lý thông minh, giúp vận hành chuỗi phòng gym hiệu quả, 
                    minh bạch và đồng bộ trên toàn khu vực. Đồng thời, chúng tôi tập trung đầu tư vào ứng dụng di động kết nối hội viên, 
                    nơi mỗi người dùng có thể theo dõi tiến trình luyện tập, đặt lịch huấn luyện, giao lưu với cộng đồng 
                    và nhận tư vấn trực tiếp từ các chuyên gia.<br><br>

                    Một điểm nhấn khác trong chiến lược phát triển của <strong>GRYND</strong> là việc ứng dụng trí tuệ nhân tạo (AI) vào huấn luyện cá nhân hóa. 
                    Công nghệ này cho phép phân tích dữ liệu sức khỏe, thói quen luyện tập và mục tiêu riêng của từng hội viên, 
                    từ đó thiết kế các chương trình tập luyện và dinh dưỡng phù hợp nhất, giúp họ đạt hiệu quả nhanh chóng và an toàn.<br><br>

                    Hơn cả một phòng gym, <strong>GRYND</strong> mong muốn trở thành người bạn đồng hành trong hành trình chinh phục giới hạn bản thân. 
                    Mỗi hội viên khi đến với Grynd sẽ cảm nhận được sự khác biệt - được quan tâm, được thấu hiểu 
                    và được chăm sóc như một vận động viên thực thụ.<br><br>

                    Với tinh thần đổi mới không ngừng và khát vọng vươn tầm khu vực, 
                    <strong>GRYND</strong> cam kết mang đến một trải nghiệm thể thao hiện đại, 
                    năng động và đầy cảm hứng, góp phần định hình phong cách sống khỏe mạnh, 
                    tích cực cho thế hệ mới tại Đông Nam Á.
                </p>
            </section>

            <section id="branches" class="mb-16 scroll-mt-24">
                <h2 class="text-2xl font-extrabold pb-2 mb-4 border-b-2 border-blue-600 font-montserrat text-[#292929]">Các chi nhánh</h2>
                <ul class="list-disc list-inside leading-relaxed">
                    <li>Grynd Quận 1 - 45 Nguyễn Thị Minh Khai, TP.HCM</li>
                    <li>Grynd Thủ Đức - 88 Võ Văn Ngân, TP.Thủ Đức</li>
                    <li>Grynd Hà Nội - 27 Láng Hạ, Quận Đống Đa</li>
                    <li>Grynd Đà Nẵng - 102 Lê Duẩn, Quận Hải Châu</li>
                </ul>
            </section>

            <section id="services" class="mb-16 scroll-mt-24">
                <h2 class="text-2xl font-extrabold pb-2 mb-4 border-b-2 border-blue-600 font-montserrat text-[#292929]">Dịch vụ</h2>
                <p class="text-base leading-relaxed text-justify font-open-sans text-[#333333]">
                    ● Gym - Cardio - Weight Training: Rèn luyện sức mạnh, đốt mỡ và tăng cơ toàn thân.<br>
                    ● Yoga - Zumba - Kickboxing - Pilates: Cân bằng tinh thần, linh hoạt cơ thể, giải tỏa căng thẳng.<br>
                    ● Huấn luyện cá nhân (PT 1 kèm 1): Được thiết kế theo mục tiêu cá nhân - giảm cân, tăng cơ, hoặc phục hồi sau chấn thương.<br>
                    ● Group Classes: Các lớp nhóm năng động như BodyPump, CrossFit, Bootcamp, Dance Fitness.<br>
                    ● Dịch vụ tập thử & huấn luyện online: Dành cho người bận rộn hoặc ở xa.
                </p>
            </section>

            <section id="products" class="mb-16 scroll-mt-24">
                <h2 class="text-2xl font-extrabold pb-2 mb-4 border-b-2 border-blue-600 font-montserrat text-[#292929]">Sản phẩm</h2>
                <p class="text-base leading-relaxed text-justify font-open-sans text-[#333333]">
                    ● Thực phẩm bổ sung dinh dưỡng: Whey protein, BCAA, multivitamin, pre-workout,...<br>
                    ● Quầy Smoothie Bar: Nước ép detox, sinh tố protein, đồ uống healthy.<br>
                    ● Cửa hàng đồ tập: Quần áo thể thao, găng tay, dây kháng lực, bình nước,...<br>
                    ● Dịch vụ khác: Tủ đồ cá nhân, phòng tắm nước nóng, phòng xông hơi, và khu vực nghỉ ngơi thư giãn,...
                </p>
            </section>

            <section id="values" class="mb-16 scroll-mt-24">
                <h2 class="text-2xl font-extrabold pb-2 mb-4 border-b-2 border-blue-600 font-montserrat text-[#292929]">Giá trị cốt lõi</h2>
                <p class="text-base leading-relaxed text-justify font-open-sans text-[#333333]">
                    ● <strong>Tận tâm</strong>: Luôn đặt trải nghiệm và sự hài lòng của hội viên lên hàng đầu.<br>
                    ● <strong>Chuyên nghiệp</strong>: Đội ngũ PT được đào tạo bài bản, có chứng chỉ quốc tế.<br>
                    ● <strong>Đổi mới</strong>: Ứng dụng công nghệ, mang đến giải pháp tập luyện hiện đại và hiệu quả.<br>
                    ● <strong>Cộng đồng</strong>: Grynd không chỉ là nơi tập, mà còn là nơi kết nối những người cùng chí hướng.<br>
                    ● <strong>Bền vững</strong>: Hướng đến phong cách sống khỏe mạnh lâu dài, thay vì chỉ là kết quả ngắn hạn.
                </p>
            </section>

            <section id="help" class="mb-16 scroll-mt-24">
                <h2 class="text-2xl font-extrabold pb-2 mb-4 border-b-2 border-blue-600 font-montserrat text-[#292929]">Triết lý hoạt động</h2>
                <p class="text-base leading-relaxed text-justify font-open-sans text-[#333333]">
                    “Tập luyện không phải để hoàn hảo - mà để tốt hơn chính mình hôm qua.”
                    <strong>GRYND</strong> tin rằng mỗi bước nhỏ đều là một chiến thắng, 
                    và hành trình đến với sức khỏe bền vững chính là hành trình đáng tự hào nhất.
                </p>
            </section>

            <section id="contact" class="scroll-mt-24">
                <h2 class="text-2xl font-extrabold pb-2 mb-4 border-b-2 border-blue-600 font-montserrat text-[#292929]">Liên hệ</h2>
                <p class="leading-relaxed">
                    📞 Hotline: <strong>012 345 6789</strong><br>
                    ✉️ Email: <a href="mailto:yobae@gmail.com" class="text-blue-600 underline">yobae@gmail.com</a><br>
                    🌐 Website: <a href="#" class="text-blue-600 underline">www.grynd.vn</a><br>
                    🕓 Giờ mở cửa: 6:00 - 21:00 (Tất cả các ngày)
                </p>
            </section>
        </main>

    </div>
    
    <script>
        const sections = document.querySelectorAll("section");
        const links = document.querySelectorAll("aside a");
        window.addEventListener("scroll", () => {
            let current = "";
            sections.forEach(sec => {
                const top = window.scrollY;
                if (top >= sec.offsetTop - 120) current = sec.getAttribute("id");
            });
            links.forEach(link => {
            link.classList.remove("text-blue-600", "font-semibold"); // Sửa nhỏ: bỏ 'font-semibold' khi remove
            if (link.getAttribute("href") === "#" + current) {
                link.classList.add("text-blue-600", "font-semibold");
            } else {
                link.classList.remove("font-semibold"); // Đảm bảo các link khác không bị đậm
            }
            });
        });
    </script>

@endsection