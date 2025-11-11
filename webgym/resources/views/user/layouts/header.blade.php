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
