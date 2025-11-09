<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRYND - LIÊN HỆ</title>
    @vite(['resources/css/app.css', 'resources/js/chatbot.js', 'resources/js/app.js'])
    <style>
      html {
        scroll-behavior: smooth;
      }
    </style>
</head>

<body class="bg-gray-50 font-sans">

    <header class="fixed top-0 left-0 w-full bg-[#F5F7FA] shadow-sm z-50">
        <div class="flex items-center justify-between px-6 md:px-20 py-3">
            <!-- Logo + tên -->
            <a href="{{ url('/') }}" class="flex items-center text-2xl font-bold text-[#0D47A1] gap-2 font-montserrat">
                <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340096/logo_jhd6zr.png" 
                    alt="Logo" class="w-10 h-10">
                GRYND
            </a>

            <!-- Menu desktop -->
            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a href="{{ route('about') }}" class="hover:text-blue-700">Về GRYND</a>
                <a href="#" class="hover:text-blue-700">Gói Tập</a>
                <a href="#" class="hover:text-blue-700">Lớp Tập</a>
                <a href="#" class="hover:text-blue-700">Cửa Hàng</a>
                <a href="#" class="hover:text-blue-700">Blog</a>
                <a href="{{ route('contact') }}" class="hover:text-blue-700">Liên Hệ</a>

                <!-- Ô tìm kiếm -->
                <div class="relative">
                    <input type="text" placeholder="Tìm kiếm..."
                        class="border border-gray-300 rounded-full px-3 py-1 pl-8 focus:outline-none
                            focus:ring-2 focus:ring-blue-500 w-21 lg:w-35 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="absolute left-2 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.65 6.65a7.5 7.5 0 016.5 10.5z" />
                    </svg>
                </div>
            </nav>

            <!-- Buttons -->
            <div class="hidden md:flex items-center gap-3">
                <button class="border border-gray-300 text-gray-700 px-3 py-1.5 rounded text-sm
                 hover:border-blue-500 hover:text-blue-500 active:bg-blue-50 transition-colors">Đăng nhập</button>

                <button class="bg-[#1976D2] text-white px-3 py-1.5 rounded text-sm hover:bg-blue-700
                 active:bg-blue-800 hover:scale-105 transition-all duration-200 ease-in-out">Đăng ký</button>
            </div>

            <!-- Icon menu cho mobile -->
            <button id="menu-btn" class="md:hidden text-3xl focus:outline-none">☰</button>
        </div>

        <!-- Menu mobile -->
        <nav id="mobile-menu" class="hidden absolute top-full left-0 w-full flex-col items-start
             bg-white px-6 py-4 space-y-3 shadow-md md:hidden transform origin-top transition-all duration-700 ease-in-out">
            <a href="#" class="hover:text-blue-700">Về GRYND</a>
            <a href="#" class="hover:text-blue-700">Gói Tập</a>
            <a href="#" class="hover:text-blue-700">Lớp Tập</a>
            <a href="#" class="hover:text-blue-700">Cửa Hàng</a>
            <a href="#" class="hover:text-blue-700">Blog</a>
            <a href="#" class="hover:text-blue-700">Liên Hệ</a>

            <!-- Search trong mobile -->
            <div class="w-full border-t border-gray-200 pt-2">
                <input type="text" placeholder="Search..."
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="w-full border-t border-gray-200"></div>
            <button class="w-full border border-gray-300 px-3 py-1.5 rounded text-sm mb-2">Đăng nhập</button>
            <button class="w-full bg-blue-700 text-white px-3 py-1.5 rounded text-sm">Đăng ký</button>
        </nav>
    </header>

    <section class="pt-20">
        <img src="{{ asset('images/about/about.jpg') }}"
            alt="Grynd Gym"
            class="w-full h-64 object-cover object-[center_65%]">
    </section>

    <div class="flex flex-col md:flex-row justify-center gap-10 px-6 py-16 max-w-7xl mx-auto">

        <div class="flex-1 space-y-5">

            <h1 class="text-4xl font-semibold mb-3 text-[#0D47A1] font-[Montserrat]">Liên hệ với GRYND</h1>
            <p class="text-[#333333] font-[Open_Sans]">
                Chúng tôi luôn sẵn sàng hỗ trợ bạn.<br>
                Hãy gửi tin nhắn hoặc liên hệ qua các chi nhánh dưới đây.
            </p>
    
            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Grynd Gò Vấp</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 25 Nguyễn Văn Lượng, Phường 6, Quận Gò Vấp, TP. Hồ Chí Minh</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 (028) 3894 5566</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Grynd Quận 1</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 120 Lê Lợi, Phường Bến Thành, Quận 1, TP. Hồ Chí Minh</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 (028) 3823 7788</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Grynd Thủ Đức</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 45 Võ Văn Ngân, Phường Linh Chiểu, TP. Thủ Đức, TP. Hồ Chí Minh</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 (028) 3722 9911</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Grynd Bình Thạnh</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 215 Phan Đăng Lưu, Phường 1, Quận Bình Thạnh, TP. Hồ Chí Minh</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 (028) 3555 2244</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Grynd Tân Bình</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 88 Cộng Hòa, Phường 4, Quận Tân Bình, TP. Hồ Chí Minh</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 (028) 3811 7733</p>
            </div>

            <div class="bg-white shadow-md rounded-2xl p-5 hover:shadow-lg transition">
                <h2 class="font-semibold text-lg text-[#292929] font-[Montserrat]">Grynd Hà Nội</h2>
                <p class="mt-2 text-[#333333] font-[Open_Sans]">📍 18 Trần Duy Hưng, Quận Cầu Giấy, Hà Nội</p>
                <p class="text-[#333333] font-[Open_Sans]">📞 (024) 3776 8899</p>
            </div>
        </div>

        <div class="w-full md:w-1/3 bg-white p-6 rounded-lg shadow-md self-start sticky top-24">
            <h2 class="text-xl font-semibold mb-6 text-[#1e87db] font-[Montserrat]">Gửi tin nhắn cho chúng tôi</h2>
            <form action="#" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block mb-1 text-[#333333] font-[Open_Sans]">Họ và tên</label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block mb-1 text-[#333333] font-[Open_Sans]">Email</label>
                    <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block mb-1 text-[#333333] font-[Open_Sans]">Chủ đề</label>
                    <input type="text" name="subject" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div>
                    <label class="block mb-1 text-[#333333] font-[Open_Sans]">Nội dung</label>
                    <textarea name="message" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                </div>
                <button type="submit" class="w-full bg-[#1b7ac5] text-white py-2 rounded-lg hover:bg-[#166ba8] transition duration-300 font-[Open_Sans]">
                    Gửi tin nhắn
                </button>
            </form>
        </div>

    </div>

    <!-- Footer -->
    <footer class="bg-[#191919] text-gray-300 pt-6 pb-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-2">
                    <h3 class="text-white font-bold text-lg mb-4 uppercase">Về GRYND</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Trang chủ</a></li> 
                        <li><a href="#" class="hover:text-white transition-colors">Gói tập</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Lớp tập</a></li> 
                        <li><a href="#" class="hover:text-white transition-colors">Cửa hàng</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                    </ul>
                </div>

                <div class="lg:col-span-4">
                    <h3 class="text-white font-bold text-lg mb-4 uppercase">Hệ thống phòng gym</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 text-gray-400 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h2.64M2.36 21m0 0V9.742c0-.501.206-.976.57-1.341l5.43-5.43a1.875 1.875 0 0 1 2.652 0l5.43 5.43c.363.365.57.84.57 1.341V21m-7.14-10.5h.01" />
                            </svg>
                            <p>155 Nguyễn Thái Bình, Tân Bình</p>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 text-gray-400 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h2.64M2.36 21m0 0V9.742c0-.501.206-.976.57-1.341l5.43-5.43a1.875 1.875 0 0 1 2.652 0l5.43 5.43c.363.365.57.84.57 1.341V21m-7.14-10.5h.01" />
                            </svg>
                            <p>199 Lê Đại Hành, Quận 11</p>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 text-gray-400 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h2.64M2.36 21m0 0V9.742c0-.501.206-.976.57-1.341l5.43-5.43a1.875 1.875 0 0 1 2.652 0l5.43 5.43c.363.365.57.84.57 1.341V21m-7.14-10.5h.01" />
                            </svg>
                            <p>1/2 Chương Dương, Thủ Đức</p>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 text-gray-400 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h2.64M2.36 21m0 0V9.742c0-.501.206-.976.57-1.341l5.43-5.43a1.875 1.875 0 0 1 2.652 0l5.43 5.43c.363.365.57.84.57 1.341V21m-7.14-10.5h.01" />
                            </svg>
                            <p>107 Xô Viết Nghệ Tĩnh, Bình Thạnh</p>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 text-gray-400 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h2.64M2.36 21m0 0V9.742c0-.501.206-.976.57-1.341l5.43-5.43a1.875 1.875 0 0 1 2.652 0l5.43 5.43c.363.365.57.84.57 1.341V21m-7.14-10.5h.01" />
                            </svg>
                            <p>144B Phạm Viết Chánh, Q.1</p>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 text-gray-400 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h2.64M2.36 21m0 0V9.742c0-.501.206-.976.57-1.341l5.43-5.43a1.875 1.875 0 0 1 2.652 0l5.43 5.43c.363.365.57.84.57 1.341V21m-7.14-10.5h.01" />
                            </svg>
                            <p>438 Quang Trung, Gò Vấp</p>
                        </div>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 text-gray-400 mr-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h2.64M2.36 21m0 0V9.742c0-.501.206-.976.57-1.341l5.43-5.43a1.875 1.875 0 0 1 2.652 0l5.43 5.43c.363.365.57.84.57 1.341V21m-7.14-10.5h.01" />
                            </svg>
                            <p>328 Nguyễn Thị Thập, Quận 7</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <h3 class="text-white font-bold text-lg mb-4 uppercase">Liên hệ trụ sở chính</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            <p>Đường Hàn Thuyên, Khu phố 34, Phường Linh Xuân, Thành phố Hồ Chí Minh</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 6.75Z" />
                            </svg>
                            <p>Điện thoại: 0123 456 789</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <p>Email: Yobae@gmail.com</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 w-5 h-5 text-gray-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c.24 0 .477-.02.71-.057M12 21c-.24 0-.477-.02-.71-.057m1.42 0a8.997 8.997 0 0 1-2.84 0M12 15c-1.104 0-2-.896-2-2s.896-2 2-2 2 .896 2 2-.896 2-2 2Zm0 0c-1.104 0-2-.896-2-2s.896-2 2-2 2 .896 2 2-.896 2-2 2ZM12 3c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2Zm0 0c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2Zm7.737 4.737a.75.75 0 0 0 0-1.061L18.676 5.61a.75.75 0 0 0-1.06 0l-.707.707a.75.75 0 0 0 0 1.061l.707.707a.75.75 0 0 0 1.06 0l1.06-1.06ZM4.263 6.793a.75.75 0 0 0 0 1.061l.707.707a.75.75 0 0 0 1.06 0l1.06-1.06a.75.75 0 0 0 0-1.061l-.707-.707a.75.75 0 0 0-1.06 0L4.263 6.793Zm15.474 10.424a.75.75 0 0 0-1.06 0l-.707.707a.75.75 0 0 0 0 1.061l.707.707a.75.75 0 0 0 1.06 0l1.06-1.06a.75.75 0 0 0 0-1.061l-1.06-1.06ZM4.97 18.277a.75.75 0 0 0-1.06 0l-.707.707a.75.75 0 0 0 0 1.061l.707.707a.75.75 0 0 0 1.06 0l1.06-1.06a.75.75 0 0 0 0-1.061l-1.06-1.06Z" />
                            </svg>
                            <p>Website: www.grynd.vn</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <h3 class="text-white font-bold text-lg mb-4 uppercase">Điều khoản</h3> <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Chính sách bảo mật</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Quyền riêng tư</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Điều khoản sử dụng</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Hướng dẫn mua hàng</a></li> 
                        <li><a href="#" class="hover:text-white transition-colors">Hướng dẫn thanh toán</a></li>
                    </ul>
                </div>
            </div>

            <hr class="mt-6 mb-6 border-gray-700"> 
            
            <div class="text-center text-sm text-[#fef8f8]">
                © 2025 GRYND. All rights reserved.
            </div>

        </div>
    </footer>

    <!-- Chatbot trợ lý AI -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end pointer-events-none">
        <div id="chatbot-window"
            class="w-96 h-[450px] bg-white rounded-lg shadow-xl mb-4
                    flex flex-col transition-all duration-300 ease-in-out
                    transform origin-bottom-right scale-95 opacity-0">

            <div class="bg-white border-b border-gray-100 p-3 rounded-t-lg flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341328/mas_head_qqc02f.png" 
                        alt="Mascot" class="w-8 h-8">
                    <h5 class="font-bold text-sm text-[#0D47A1]">GRYND AI Assistant</h5>
                </div>
                <button id="close-chatbot" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="flex-1 p-4 overflow-y-auto bg-white">
                <div class="flex items-start gap-2.5 mb-3">
                    <img class="w-10 h-10 rounded-full ring-1 ring-green-500 ring-offset-2"
                        src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341328/mas_head_qqc02f.png" alt="AI Avatar">

                    <div>
                        <p class="bg-gray-100 text-gray-800 text-sm rounded-lg py-2 px-3 inline-block max-w-xs">
                            <span class="block text-sm font-semibold text-[#1976D2] mb-1">Trợ lý AI</span>
                            Xin chào! Mình là trợ lý AI của bạn tại GRYND. Hôm nay bạn cần mình hỗ trợ gì?
                        </p>

                        <div id="chatbot-suggestions" class="flex flex-wrap gap-2 mt-3">
                            <button class="chatbot-suggestion text-sm text-[#1976D2] bg-blue-50 border border-blue-200 rounded-full px-3 py-1 hover:bg-blue-100 transition-colors">
                                Xem các gói tập
                            </button>
                            <button class="chatbot-suggestion text-sm text-[#1976D2] bg-blue-50 border border-blue-200 rounded-full px-3 py-1 hover:bg-blue-100 transition-colors">
                                Giờ hoạt động?
                            </button>
                            <button class="chatbot-suggestion text-sm text-[#1976D2] bg-blue-50 border border-blue-200 rounded-full px-3 py-1 hover:bg-blue-100 transition-colors">
                                Sản phẩm hot
                            </button>
                            <button class="chatbot-suggestion text-sm text-[#1976D2] bg-blue-50 border border-blue-200 rounded-full px-3 py-1 hover:bg-blue-100 transition-colors">
                                Liên hệ hỗ trợ
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-3 bg-white rounded-b-lg border-t border-gray-100">
                <div class="flex items-center bg-gray-100 rounded-full p-1">

                    <input id="chatbot-input" type="text" placeholder="Nhập tin nhắn..."
                        class="flex-1 bg-transparent border-none focus:ring-0 px-3 py-1 text-sm
                                text-gray-700 placeholder-gray-500">

                    <button id="chatbot-send" class="w-8 h-8 rounded-full bg-[#1976D2] text-white flex items-center justify-center
                                shrink-0 hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 transform rotate-90" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009.175 16V4.697a1 1 0 011.719-.707l4 9a1 1 0 001.788 0l-7-14z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <button id="chatbot-toggle"
            class="relative w-20 h-20 transition-all duration-200
                hover:scale-110 pointer-events-auto">
            <span class="absolute top-0 left-0 z-0 inline-flex w-full h-full
                        rounded-full bg-[#1e87db] opacity-75 animate-ping">
            </span>

            <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341318/mascot_drm5o0.png" 
                alt="Linh vật GRYND" class="relative z-10 w-20 h-20 drop-shadow-lg">
        </button>
    </div>

</body>

</html>