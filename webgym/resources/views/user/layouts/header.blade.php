<!-- Header Section -->
<header class="fixed top-0 left-0 w-full bg-[#F5F7FA] shadow-sm z-50">
    <div class="flex items-center justify-between px-6 md:px-20 py-3">
        <a href="{{ url('/') }}" class="flex items-center text-2xl font-bold text-[#0D47A1] gap-2 font-montserrat">
            <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762340096/logo_jhd6zr.png" 
                 alt="Logo" class="w-10 h-10">
            GRYND
        </a>
        <!-- Navigation Links -->
        <nav class="hidden md:flex items-center gap-6 text-sm">
            <a href="{{ route('about') }}" class="hover:text-blue-700">Về GRYND</a>
            <a href="{{ route('package') }}" class="hover:text-blue-700">Gói Tập</a>
            <a href="{{ route('class') }}" class="hover:text-blue-700">Lớp Học</a>
            <a href="{{ route('product') }}" class="hover:text-blue-700">Cửa Hàng</a>
            <a href="{{ route('blog') }}" class="hover:text-blue-700">Blog</a>
            <a href="{{ route('contact') }}" class="hover:text-blue-700">Liên Hệ</a>
        </nav>
        <!-- Tìm kiếm và nút đăng nhập, đăng ký -->
        <div class="hidden md:flex items-center gap-4">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>

                <input type="text" placeholder="Tìm kiếm..."
                    class="border border-gray-300 rounded-lg px-3 py-1 pl-10 focus:outline-none
                            focus:ring-2 focus:ring-blue-500 w-30 lg:w-42 transition-all duration-300 placeholder:text-sm">
            </div>
            <!-- Trường hợp chưa đăng nhập -->
            @guest
                <a href="{{ route('login') }}" class="border border-gray-300 text-gray-700 px-3 py-1.5 rounded text-sm
                        hover:border-blue-500 hover:text-blue-500 active:bg-blue-50 transition-colors">Đăng nhập</a>

                <a href="{{ route('register') }}" class="bg-[#1976D2] text-white px-3 py-1.5 rounded text-sm hover:bg-blue-700
                        active:bg-blue-800 hover:scale-105 transition-all duration-200 ease-in-out">Đăng ký</a>
            @endguest
            <!-- Trường hợp đã đăng nhập -->
            @auth
                <button class="relative w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full shadow-sm hover:bg-gray-200 focus:outline-none transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-1 right-1 block w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                </button>

                <!-- Giỏ hàng -->
                <a href="#" class="relative w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full shadow-sm hover:bg-gray-200 focus:outline-none transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-blue-600 rounded-full border-2 border-white">
                        3
                    </span>
                </a>
                <!-- User Dropdown Menu -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex text-sm bg-gray-100 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <img class="h-10 w-10 rounded-full object-cover" 
                                src="{{ Auth::user()->image_url ?? 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762341321/ava_ntqezy.jpg' }}" 
                                alt="User Avatar">
                    </button>

                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 origin-top-right"
                         style="display: none;"> <div class="px-4 py-2 border-b">
                            <span class="block text-sm font-medium text-gray-900">{{ Auth::user()->full_name }}</span>
                            <span class="block text-sm text-gray-500 truncate">{{ Auth::user()->email }}</span>
                        </div>
                        
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Hồ sơ</a>
                        <a href="{{ route('my_packages') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Gói tập đã mua</a>
                        <a href="{{ route('my_classes') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lớp học đã đăng ký</a>
                        <a href="{{ route('order_history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lịch sử đơn hàng</a>
                        <a href="{{ route('rental_history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Lịch sử mượn/trả</a>

                        <!-- Đăng xuất -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-gray-100">
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>

        <!-- Mobile menu button -->
        <button id="menu-btn" class="md:hidden text-3xl focus:outline-none">☰</button>
    </div>
    <!-- Mobile Menu -->
    <nav id="mobile-menu" class="hidden absolute top-full left-0 w-full flex-col items-start
            bg-white px-6 py-4 space-y-3 shadow-md md:hidden transform origin-top transition-all duration-700 ease-in-out">
        <a href="{{ route('about') }}" class="hover:text-blue-700">Về GRYND</a>
        <a href="#" class="hover:text-blue-700">Gói Tập</a>
        <a href="#" class="hover:text-blue-700">Lớp Học</a>
        <a href="#" class="hover:text-blue-700">Cửa Hàng</a>
        <a href="#" class="hover:text-blue-700">Blog</a>
        <a href="{{ route('contact') }}" class="hover:text-blue-700">Liên Hệ</a>

        <div class="w-full border-t border-gray-200 pt-3">
            <input type="text" placeholder="Tìm kiếm..."
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="w-full border-t border-gray-200 pt-3 space-y-2">
            @guest
                <a href="#" class="w-full border border-gray-300 px-3 py-1.5 rounded text-sm">Đăng nhập</a>
                <a href="#" class="w-full bg-blue-700 text-white px-3 py-1.5 rounded text-sm">Đăng ký</a>
            @endguest

            @auth
                <div class="flex items-center gap-3 mb-3">
                    <img class="h-10 w-10 rounded-full object-cover" 
                            src="{{ Auth::user()->image_url ?? 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762341321/ava_ntqezy.jpg' }}" 
                            alt="User Avatar">
                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->full_name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <a href="#" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Hồ sơ</a>
                <a href="#" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Gói tập đã mua</a>
                <a href="#" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Lớp học đã đăng ký</a>
                <a href="#" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Lịch sử đơn hàng</a>
                <a href="#" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Lịch sử mượn/trả</a>   
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">
                        Đăng xuất
                    </button>
                </form>
            @endauth
        </div>
    </nav>
</header>