<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title >@yield('title', 'GRYND - Chung')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">

            <!-- Logo và tiêu đề -->
            <div class="flex items-center gap-3 px-6 py-4"> 
                
                <!-- Logo: Dùng kích thước chuẩn h-[60px] -->
                <img src="{{ asset('images/profile/logo.png') }}" 
                    alt="Logo" 
                    class="h-[60px] w-[60px] object-contain">
                
                <!-- Tiêu đề -->
                <a href="{{ route('home') }}" class="hover:opacity-80 transition-opacity">
                    <h1 class="text-3xl font-extrabold bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent font-montserrat">
                        GRYND
                    </h1>
                </a>

            </div>

            <!-- Menu điều hướng -->
            <nav class="flex-1 px-4 py-6 space-y-2 font-open-sans">
                <a href="{{ route('profile') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-[#333333] font-normal hover:bg-[#1976D2]/10 hover:text-[#0D47A1] hover:font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-900 stroke-2 group-hover:text-[#0D47A1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Hồ sơ
                </a>

                <a href="{{ route('my_packages') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-[#333333] font-normal hover:bg-[#1976D2]/10 hover:text-[#0D47A1] hover:font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-900 stroke-2 group-hover:text-[#0D47A1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                    </svg>
                    Gói tập đã mua
                </a>

                <a href="{{ route('my_classes') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-[#333333] font-normal hover:bg-[#1976D2]/10 hover:text-[#0D47A1] hover:font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-900 stroke-2 group-hover:text-[#0D47A1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                    Lớp học đã đăng ký
                </a>

                <a href="{{ route('order_history') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-[#333333] font-normal hover:bg-[#1976D2]/10 hover:text-[#0D47A1] hover:font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-900 stroke-2 group-hover:text-[#0D47A1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                    Lịch sử đơn hàng
                </a>

                <a href="{{ route('rental_history') }}" class="group flex items-center gap-3 px-4 py-3 rounded-lg transition-all text-[#333333] font-normal hover:bg-[#1976D2]/10 hover:text-[#0D47A1] hover:font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-900 stroke-2 group-hover:text-[#0D47A1]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    Lịch sử mượn trả
                </a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 px-6 py-8 overflow-y-auto h-screen">
            
            <div class="max-w-7xl mx-auto space-y-6">
                
                @yield('content')  

            </div>
        </main>
    </div>

</body>

</html>