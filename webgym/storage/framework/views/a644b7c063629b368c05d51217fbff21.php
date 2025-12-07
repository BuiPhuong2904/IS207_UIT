<?php $__env->startSection('title', 'GRYND - Trang chủ'); ?>

<?php $__env->startSection('content'); ?>
 
    <!-- Banner Carousel -->
    <section id="banner-carousel" class="relative w-full">
        <!-- Wrapper chứa các slide -->
        <div class="relative overflow-hidden h-[60vh] sm:h-[50vh] md:h-[60vh] lg:h-[65vh] xl:h-[60vh] 2xl:h-[55vh]">

            <!-- Slide 1 -->
            <div class="block duration-700 ease-in-out" data-carousel-item>
            <img
                src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762339078/banner_axqau9.jpg"
                alt="Banner 1"
                class="absolute top-0 left-0 w-full h-full object-contain bg-black">
            </div>

            <!-- Slide 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img
                src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762429712/banner_3_wlycmf.png"
                alt="Banner 2"
                class="absolute top-0 left-0 w-full h-full object-contain bg-black">
            </div>

            <!-- Slide 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img
                src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762412842/banner_2_xwpyse.png"
                alt="Banner 3"
                class="absolute top-0 left-0 w-full h-full object-contain bg-black">
            </div>

            <!-- Slide 4 (YouTube video) -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <div class="absolute top-0 left-0 w-full h-full overflow-hidden">
                    <iframe class="w-full h-full object-cover"
                        src="https://www.youtube.com/embed/wOngPiiQaJ4?start=32&end=218&autoplay=1&mute=1&loop=1&playlist=wOngPiiQaJ4&controls=0&modestbranding=1&showinfo=0"
                        title="LUXURIOUS GYM TOUR || MINISTRY OF FITNESS || INTERIOR DESIGN BY AP INTERIOR STUDIO"
                        frameborder="0"
                        allow="autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen>
                    </iframe>

                    <!-- Lớp phủ chống click -->
                    <div class="absolute inset-0 bg-transparent"></div>
                </div>
            </div>
        </div>

        <!-- Dots chọn slide -->
        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3">
            <button type="button" class="w-3 h-3 rounded-full bg-white/50" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full bg-white/50" data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full bg-white/50" data-carousel-slide-to="2"></button>
            <button type="button" class="w-3 h-3 rounded-full bg-white/50" data-carousel-slide-to="3"></button>
        </div>

        <!-- Nút điều hướng -->
        <button type="button"
                class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
            <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
            <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 1 1 5l4 4" />
            </svg>
            </span>
        </button>

        <button type="button"
                class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
            <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
            <svg class="w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4" />
            </svg>
            </span>
        </button>

    </section>


    <!-- Đăng ký chi nhánh -->
    <section class="w-full bg-[#E3F2FD] pt-6 pb-6 px-4">
        <div class="bg-[#1e87db] rounded-xl shadow-lg p-4 w-full max-w-xl
                    mx-auto md:max-w-3xl">

            <h3 class="text-center text-white  text-xl font-bold mb-2">
                Tham gia cộng đồng GRYND ngay hôm nay!
            </h3>
            <p class="text-center text-white mb-4">
                Chọn địa điểm thuận tiện nhất từ 7+ chi nhánh toàn quốc của chúng tôi.
            </p>

            <form action="/dang-ky-chi-nhanh" method="GET" class="w-full">

                <div class="flex items-center bg-white rounded-full shadow-inner p-2 gap-2">

                    <select name="chi_nhanh"
                            class="flex-1 bg-transparent border-none focus:ring-0 focus:border-none px-4 py-2 text-gray-800">
                        <option value="" disabled selected>Chọn chi nhánh gần bạn</option>
                        <option value="ho-chi-minh">TP. Hồ Chí Minh</option>
                        <option value="ha-noi">Hà Nội</option>
                        <option value="da-nang">Đà Nẵng</option>
                    </select>

                    <button type="submit"
                            class="bg-[#00A8E8] text-white font-semibold px-6 py-2 rounded-full
                                hover:bg-[#145ea8] transition-colors whitespace-nowrap">
                        Tham gia
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Trusted by section -->
    <section class="bg-[#F5F7FA] text-center pt-6">
        <p class="text-[#0D47A1] font-bold font-montserrat tracking-wide mb-8 text-lg">
            TRUSTED BY TOP BRANDS
        </p>

        <div class="flex justify-center items-center gap-10 md:gap-16 bg-[#ffffff] py-6 px-4 flex-nowrap overflow-x-auto">

            <div class="flex justify-center items-center h-12">
                <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340172/logo_nike_pz7mez.png" 
                    alt="Nike" class="h-17 object-contain" />
            </div>

            <div class="flex justify-center items-center h-12">
                <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340180/logo_adidas_iwsmdj.png" 
                    alt="Adidas" class="h-17 object-contain" />
            </div>

            <div class="flex justify-center items-center h-12">
                <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340271/logo_on_peghag.png" 
                    alt="Optimum Nutrition" class="h-8 object-contain" />
            </div>

            <div class="flex justify-center items-center h-12">
                <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340190/logo_her_tqsvup.png" 
                    alt="Herbalife Nutrition" class="max-h-full max-w-full object-contain" />
            </div>

            <div class="flex justify-center items-center h-12">
                <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340302/logo_momo_kgi4ul.png" 
                    alt="MoMo" class="max-h-full max-w-full object-contain" />
            </div>

            <div class="flex justify-center items-center h-12">
                <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340307/logo_vnpay_ywpf1u.png" 
                    alt="VNPay" class="h-24 object-contain" />
            </div>

        </div>
    </section>

    <!-- Giới thiệu -->
    <section class="flex flex-wrap justify-center items-center gap-10 bg-[#F5F7FA] px-10 md:px-20 py-12">
        <!-- Carousel hình ảnh -->
        <div id="default-carousel" class="relative w-full md:w-[420px]">
            <div class="relative h-[350px] overflow-hidden rounded-lg shadow-lg">

                <div class="duration-700 ease-in-out" data-carousel-item>
                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340415/home_1_clrdg8.jpg" 
                        class="absolute block w-full h-full object-cover top-0 left-0" alt="Gym photo 1">
                </div>

                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340414/home_nulk3t.jpg" 
                        class="absolute block w-full h-full object-cover top-0 left-0" alt="Gym photo 2">
                </div>

                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340416/home_2_khgoxc.jpg" 
                        class="absolute block w-full h-full object-cover top-0 left-0" alt="Gym photo 3">
                </div>

                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340417/home_3_jtpn8i.jpg" 
                        class="absolute block w-full h-full object-cover top-0 left-0" alt="Gym photo 4">
                </div>

                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <video autoplay loop muted playsinline
                            class="absolute block w-full h-full object-cover top-0 left-0">
                        <source src="https://res.cloudinary.com/dna9qbejm/video/upload/v1762418517/banner_6_phplga.mp4" type="video/mp4">
                        Trình duyệt của bạn không hỗ trợ video.
                    </video>
                </div>

            </div>

            <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>

            <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>

            <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                <button type="button" class="w-3 h-3 rounded-full" data-carousel-slide-to="0"></button>
                <button type="button" class="w-3 h-3 rounded-full" data-carousel-slide-to="1"></button>
                <button type="button" class="w-3 h-3 rounded-full" data-carousel-slide-to="2"></button>
                <button type="button" class="w-3 h-3 rounded-full" data-carousel-slide-to="3"></button>
                <button type="button" class="w-3 h-3 rounded-full" data-carousel-slide-to="4"></button>
            </div>
        </div>
        <!-- Nội dung giới thiệu -->
        <div class="text-center max-w-md">
            <h2 class="text-[#0D47A1] font-montserrat text-xl font-bold mb-2">"CHINH PHỤC MỌI MỤC TIÊU FITNESS"</h2>
            <h4 class="text-[#1976D2] font-roboto mb-4">Giải Pháp Toàn Diện Cho Lối Sống Năng Động</h4>

            <p class="text-[#333333] text-justify leading-relaxed mb-5">
                Chào mừng bạn đến với <span class="font-bold">GRYND</span>.
                Chúng tôi đồng hành cùng bạn trên mọi chặng đường,
                từ các gói tập luyện linh hoạt đến cửa hàng trực tuyến chuyên cung cấp quần áo,
                phụ kiện và thực phẩm chức năng cao cấp. Mọi thứ bạn cần để bứt phá giới hạn đều có tại đây.
            </p>
            <button class="border-2 border-[#1976D2] text-[#1976D2] bg-white px-4 py-2 rounded-md font-bold
                hover:bg-[#1976D2] hover:text-white hover:scale-105 transition">
                Tìm hiểu thêm
            </button>

        </div>
    </section>

    <!-- Gói tập nổi bật -->
    <section class="bg-[#E3F2FD] py-12 px-10 md:px-20 text-center">
        <h2 class="text-xl md:text-2xl font-bold text-[#0D47A1] mb-2 font-montserrat tracking-wide uppercase">
        GÓI TẬP NỔI BẬT
        </h2>
        <div class="w-48 h-[3px] mx-auto mb-10 rounded-full"
            style="background: linear-gradient(90deg, #0D47A1, #42A5F5);"></div>

        <div class="grid grid-cols-4 gap-6 max-w-7xl mx-auto">
            <!-- Card 1 -->
            <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6">
                <div class="flex flex-col items-center gap-3">
                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340544/home_icon_1_vwnrex.png" 
                        alt="Basic Icon" class="w-14 h-14 mb-2">
                    <h4 class="text-lg font-semibold text-[#0D47A1]">Gói Tháng</h4>
                    <p class="text-[#1976D2] font-bold text-xl mb-2">399.000 Đ / gói</p>
                    <ul class="text-[#333333] text-sm space-y-1 mb-4 text-left">
                        <li>✔️ Thời hạn: 30 ngày</li>
                        <li>✔️ Tập không giới hạn</li>
                        <li>✔️ Hỗ trợ PT hướng dẫn</li>
                        <li>✔️ Miễn phí tủ đồ</li>
                    </ul>
                    <button
                    class="bg-[#1976D2] text-white font-semibold px-5 py-2 rounded-full hover:bg-[#0D47A1] transition">
                    Đăng ký ngay
                    </button>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6">
                <div class="flex flex-col items-center gap-3">
                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340552/home_icon_5_ogsfnh.png" 
                        alt="Standard Icon" class="w-14 h-14 mb-2">
                    <h4 class="text-lg font-semibold text-[#0D47A1]">Gói Quý</h4>
                    <p class="text-[#1976D2] font-bold text-xl mb-2">1.199.000 Đ / gói</p>
                    <ul class="text-[#333333] text-sm space-y-1 mb-4 text-left">
                        <li>✔️ Thời hạn: 90 ngày</li>
                        <li>✔️ Tập không giới hạn</li>
                        <li>✔️ Tặng 1 buổi PT cá nhân</li>
                        <li>✔️ Ưu đãi mua sản phẩm</li>
                    </ul>
                    <button
                    class="bg-[#1976D2] text-white font-semibold px-5 py-2 rounded-full hover:bg-[#0D47A1] transition">
                    Đăng ký ngay
                    </button>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6">
                <div class="flex flex-col items-center gap-3">
                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340545/home_icon_3_i7thpr.png" 
                        alt="Premium Icon" class="w-14 h-14 mb-2">
                    <h4 class="text-lg font-semibold text-[#0D47A1]">Gói Năm</h4>
                    <p class="text-[#1976D2] font-bold text-xl mb-2">4.599.000đ / gói</p>
                    <ul class="text-[#333333] text-sm space-y-1 mb-4 text-left">
                        <li>✔️ Thời hạn: 365 ngày</li>
                        <li>✔️ Tặng 5 buổi PT/năm</li>
                        <li>✔️ Giảm 10% các dịch vụ</li>
                        <li>✔️ Ưu tiên đặt lịch</li>
                    </ul>
                    <button
                    class="bg-[#1976D2] text-white font-semibold px-5 py-2 rounded-full hover:bg-[#0D47A1] transition">
                    Đăng ký ngay
                    </button>
                </div>
            </div>

            <!-- Card 4 (HOT) -->
            <div class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border-t-4 border-[#FFD700]">
                <!-- Badge -->
                <span class="absolute top-3 right-3 bg-[#FFD700] text-[#0D47A1] font-semibold text-xs px-3 py-1 rounded-full shadow">
                    🔥 HOT
                </span>

                <div class="flex flex-col items-center gap-3">
                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340551/home_icon_4_bnbmxh.png" 
                        alt="VIP Icon" class="w-14 h-14 mb-2">
                    <h4 class="text-lg font-semibold text-[#0D47A1]">Gói PT Cá Nhân</h4>
                    <p class="text-[#1976D2] font-bold text-xl mb-2">1.599.000đ / gói</p>
                    <ul class="text-[#333333] text-sm space-y-1 mb-4 text-left">
                        <li>✔️ Thời hạn: 30 ngày</li>
                        <li>✔️ Huấn luyện viên cá nhân</li>
                        <li>✔️ Có giáo trình tập riêng</li>
                        <li>✔️ Tư vấn chế độ ăn riêng</li>
                    </ul>
                    <button
                        class="font-semibold px-6 py-2 rounded-full text-[#0D47A1]
                                transition-all duration-300 shadow-md hover:shadow-lg
                                hover:scale-105 active:scale-95"
                        style="background: linear-gradient(90deg, #FFDD00, #F7B731);">
                        Đăng ký ngay
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Lớp học phổ biến -->
    <section class="bg-[#F5F7FA] py-10 px-10 md:px-20 text-center">
        <h2 class="text-xl md:text-2xl font-bold text-[#0D47A1] mb-2 font-montserrat tracking-wide uppercase">
            LỚP HỌC PHỔ BIẾN
        </h2>
        <div class="w-48 h-[3px] mx-auto mb-8 rounded-full"
            style="background: linear-gradient(90deg, #0D47A1, #42A5F5);"></div>

        <h3 class="text-[#1e87db] font-montserrat text-xl font-bold mb-2">
            ĐÁNH THỨC NĂNG LƯỢNG - BÙNG NỔ CÙNG GRYND
        </h3>

        <p class="text-[#000000] text-center leading-relaxed mb-5 max-w-3xl mx-auto">
            Hãy để <span class="font-bold">GRYND</span> biến mỗi buổi tập của bạn thành một giờ giải phóng năng lượng và niềm vui.
            Mọi lớp học đều được thiết kế khoa học để giúp bạn đạt hiệu quả tối đa.
            Hãy khám phá lớp học đa dạng của chúng tôi và tìm ra "chân ái" luyện tập của bạn.
        </p>

        <!-- Slider wrapper -->
        <div class="relative max-w-7xl mx-auto py-4">
            <!-- Container có overflow để ẩn phần bị trượt -->
            <div class="overflow-hidden pb-4">
                <!-- Dải card ngang -->
                <div id="slider"
                    class="flex flex-nowrap gap-6 transition-transform duration-500 ease-in-out
                        will-change-transform">

                    <!-- Lớp học 1 -->
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-4 flex-none basis-1/3 h-[420px]">
                        <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340664/class_yoga_pnqj0e.jpg" alt="Yoga Class"
                            class="w-full h-60 object-cover rounded-md mb-2">
                        <h4 class="text-lg font-semibold text-[#0D47A1] mb-2">Lớp Yoga</h4>
                        <p class="text-[#333333] text-sm mb-4">Nơi tâm trí tĩnh lặng và cơ thể được thả lỏng, phục hồi năng lượng.</p>
                        <button
                        class="border-1 border-[#1976D2] text-[#1976D2] font-semibold px-5 py-2 rounded-full hover:bg-[#1976D2] hover:text-white transition duration-300">
                        Xem thêm
                        </button>
                    </div>

                    <!-- Lớp học 2 -->
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-4 flex-none basis-1/3 h-[420px]">
                        <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340660/class_gym_zqcmwl.jpg" alt="Gym Class"
                            class="w-full h-60 object-cover rounded-md mb-2">
                        <h4 class="text-lg font-semibold text-[#0D47A1] mb-2">Lớp Gym</h4>
                        <p class="text-[#333333] text-sm mb-4">Cảm nhận từng thớ cơ mạnh mẽ hơn, định hình vóc dáng sắc nét.</p>
                        <button
                        class="border-1 border-[#1976D2] text-[#1976D2] font-semibold px-5 py-2 rounded-full hover:bg-[#1976D2] hover:text-white transition duration-300">
                        Xem thêm
                        </button>
                    </div>

                    <!-- Lớp học 3 -->
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-4 flex-none basis-1/3 h-[420px]">
                        <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340669/class_cardio_nhx24a.jpg" alt="Cardio Class"
                            class="w-full h-60 object-cover rounded-md mb-2">
                        <h4 class="text-lg font-semibold text-[#0D47A1] mb-2">Lớp Cardio</h4>
                        <p class="text-[#333333] text-sm mb-4">Chạy, nhảy và đẩy nhịp tim lên cao nhất để chinh phục sức bền của bạn.</p>
                        <button
                        class="border-1 border-[#1976D2] text-[#1976D2] font-semibold px-5 py-2 rounded-full hover:bg-[#1976D2] hover:text-white transition duration-300">
                        Xem thêm
                        </button>
                    </div>

                    <!-- Lớp học 4 -->
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-4 flex-none basis-1/3 h-[420px]">
                        <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340666/class_zumba_mdctb7.jpg" alt="Zumba Class"
                            class="w-full h-60 object-cover rounded-md mb-2">
                        <h4 class="text-lg font-semibold text-[#0D47A1] mb-2">Lớp Zumba</h4>
                        <p class="text-[#333333] text-sm mb-4">Vừa tập vừa vui, đốt mỡ cực nhanh qua điệu nhảy sôi động.</p>
                        <button
                        class="border-1 border-[#1976D2] text-[#1976D2] font-semibold px-5 py-2 rounded-full hover:bg-[#1976D2] hover:text-white transition duration-300">
                        Xem thêm
                        </button>
                    </div>

                    <!-- Lớp học 5 -->
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-4 flex-none basis-1/3 h-[420px]">
                        <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340668/class_boxing_jgare2.jpg" alt="Boxing Class"
                            class="w-full h-60 object-cover rounded-md mb-2">
                        <h4 class="text-lg font-semibold text-[#0D47A1] mb-2">Lớp Boxing</h4>
                        <p class="text-[#333333] text-sm mb-4">Tung cú đấm dứt khoát, né đòn nhanh nhẹn và giải tỏa căng thẳng cực đã.</p>
                        <button
                        class="border-1 border-[#1976D2] text-[#1976D2] font-semibold px-5 py-2 rounded-full hover:bg-[#1976D2] hover:text-white transition duration-300">
                        Xem thêm
                        </button>
                    </div>

                    <!-- Lớp học 6 -->
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-4 flex-none basis-1/3 h-[420px]">
                        <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340662/class_HIIT_hziu98.jpg" alt="HIIT Class"
                            class="w-full h-60 object-cover rounded-md mb-2">
                        <h4 class="text-lg font-semibold text-[#0D47A1] mb-2">Lớp HIIT</h4>
                        <p class="text-[#333333] text-sm mb-4">Đốt mỡ ngay cả khi đã nghỉ tập. Hiệu quả tối đa trong thời gian ngắn nhất.</p>
                        <button
                        class="border-1 border-[#1976D2] text-[#1976D2] font-semibold px-5 py-2 rounded-full hover:bg-[#1976D2] hover:text-white transition duration-300">
                        Xem thêm
                        </button>
                    </div>

                    <!-- Lớp học 7 -->
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-4 flex-none basis-1/3 h-[420px]">
                        <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340663/class_pilates_b1irhb.jpg" alt="Pilates Class"
                            class="w-full h-60 object-cover rounded-md mb-2">
                        <h4 class="text-lg font-semibold text-[#0D47A1] mb-2">Lớp Pilates</h4>
                        <p class="text-[#333333] text-sm mb-4">Siết chặt cơ lõi, kiểm soát từng chuyển động chậm rãi để có một tư thế chuẩn.</p>
                        <button
                        class="border-1 border-[#1976D2] text-[#1976D2] font-semibold px-5 py-2 rounded-full hover:bg-[#1976D2] hover:text-white transition duration-300">
                        Xem thêm
                        </button>
                    </div>
                </div>
            </div>

            <!-- Nút điều hướng -->
            <button id="prevBtn"
                class="absolute top-1/2 -left-15 -translate-y-1/2 bg-gradient-to-r from-[#5280c7] to-[#42A5F5] text-white p-4 rounded-full shadow-md hover:scale-110 transition-all duration-300 hover:shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button id="nextBtn"
                class="absolute top-1/2 -right-15 -translate-y-1/2 bg-gradient-to-r from-[#42A5F5] to-[#5280c7] text-white p-4 rounded-full shadow-md hover:scale-110 transition-all duration-300 hover:shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </section>

    <!-- Cửa hàng -->
    <section class="bg-[#E3F2FD] py-14 px-10 md:px-20 text-center">
        <h2 class="text-xl md:text-2xl font-bold text-[#0D47A1] mb-2 font-montserrat tracking-wide uppercase">
            CỬA HÀNG GRYND
        </h2>
        <div class="w-48 h-[3px] mx-auto mb-10 rounded-full"
            style="background: linear-gradient(90deg, #0D47A1, #42A5F5);"></div>

        <div class="flex flex-col md:flex-row items-center justify-center gap-12 max-w-7xl mx-auto">

            <div class="text-center max-w-md">
                <h3 class="font-montserrat text-3xl font-extrabold mb-4
                           text-transparent bg-clip-text bg-gradient-to-r
                           from-[#0D47A1] to-[#42A5F5]">
                    NÂNG TẦM TRẢI NGHIỆM TẬP LUYỆN
                </h3>

                <p class="text-[#333333] leading-relaxed text-justify mb-8">
                    <span class="font-bold">GRYND</span> mang đến cho bạn bộ sưu tập
                    quần áo thể thao, phụ kiện và thực phẩm chức năng chất lượng cao từ các thương hiệu hàng đầu.
                    Dù bạn là người mới bắt đầu hay vận động viên chuyên nghiệp,
                    chúng tôi có mọi thứ bạn cần để nâng tầm trải nghiệm luyện tập của mình.
                </p>

                <div class="text-center">
                    <button class="inline-flex items-center justify-center gap-2 text-white px-6 py-2 rounded-lg font-semibold shadow-lg
                                   bg-gradient-to-r from-[#3484d4] to-[#42A5F5]
                                   hover:shadow-xl hover:scale-105
                                   transition-all duration-300">

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"></path>
                        </svg>
                        <span>Mua sắm ngay</span>
                    </button>
                </div>
            </div>

            <!-- Carousel hình ảnh cửa hàng -->
            <div id="store-carousel" class="relative w-full md:w-1/2">
                <div class="relative h-[350px] overflow-hidden rounded-lg shadow-lg">

                    <div class="duration-700 ease-in-out" data-carousel-item>
                        <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341684/shop_1_vfdd5j.jpg" 
                            class="absolute block w-full h-full object-cover top-0 left-0" alt="Gym Apparel 1">
                    </div>

                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341191/shop_1_dol83h.jpg" 
                            class="absolute block w-full h-full object-cover top-0 left-0" alt="Gym Apparel 2">
                    </div>

                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341192/shop_3_ldc5kj.jpg" 
                            class="absolute block w-full h-full object-cover top-0 left-0" alt="Supplements 1">
                    </div>

                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762342077/shop_4_sbwoos.jpg" 
                            class="absolute block w-full h-full object-cover top-0 left-0" alt="Accessories 1">
                    </div>

                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341195/shop_5_lbdjrz.jpg" 
                            class="absolute block w-full h-full object-cover top-0 left-0" alt="Accessories 2">
                    </div>
                </div>

                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button>
                </div>

                <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        </div>
    </section>

    <!-- Blog -->
    <section class="bg-[#F5F7FA] py-14 px-10 md:px-20 text-center">
        <h2 class="text-xl md:text-2xl font-bold text-[#0D47A1] mb-2 font-montserrat tracking-wide uppercase">
            BÀI VIẾT MỚI NHẤT
        </h2>
        <div class="w-48 h-[3px] mx-auto mb-10 rounded-full"
            style="background: linear-gradient(90deg, #0D47A1, #42A5F5);"></div>

        <div class="grid grid-cols-3 gap-6 max-w-7xl mx-auto">
            <!-- Bài viết 1 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-4 text-left h-[420px]">
                <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341272/blog_1_shlvij.jpg" 
                    alt="Blog 1" class="w-full h-60 object-cover rounded-md mb-2">
                <h4 class="text-lg font-semibold text-[#0D47A1] mb-2">5 Lợi Ích Của Việc Tập Yoga Hàng Ngày</h4>
                <p class="text-[#333333] text-sm mb-4">Khám phá cách yoga có thể cải thiện sức khỏe thể chất và tinh thần của bạn.</p>
                <a href="<?php echo e(route('blog1')); ?>" class="text-blue-700 font-semibold hover:underline">Đọc thêm →</a>
            </div>

            <!-- Bài viết 2 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-4 text-left h-[420px]">
                <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341274/blog_2_uugz6s.jpg" 
                    alt="Blog 2" class="w-full h-60 object-cover rounded-md mb-2">
                <h4 class="text-lg font-semibold text-[#0D47A1] mb-2">Chế Độ Dinh Dưỡng Cho Người Tập Gym</h4>
                <p class="text-[#333333] text-sm mb-4">Tìm hiểu những thực phẩm tốt nhất để hỗ trợ quá trình tập luyện của bạn.</p>
                <a href="<?php echo e(route('blog2')); ?>" class="text-blue-700 font-semibold hover:underline">Đọc thêm →</a>
            </div>

            <!-- Bài viết 3 -->
            <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-4 text-left h-[420px]">
                <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341270/blog_3_nravn8.jpg" 
                    alt="Blog 3" class="w-full h-60 object-cover rounded-md mb-2">
                <h4 class="text-lg font-semibold text-[#0D47A1] mb-2">10 Bài Tập Cardio Hiệu Quả Tại Nhà</h4>
                <p class="text-[#333333] text-sm mb-4">Các bài tập đơn giản giúp bạn đốt cháy calo và cải thiện sức khỏe tim mạch.</p>
                <a href="<?php echo e(route('blog3')); ?>" class="text-blue-700 font-semibold hover:underline">Đọc thêm →</a>
            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layouts.user_layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\UIT\Phat_trien_ung_dung_web\DoAnWeb\webgym\resources\views/user/home.blade.php ENDPATH**/ ?>