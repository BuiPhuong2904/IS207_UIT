<aside class="w-64 bg-white border-r border-gray-300">
    <div class="flex items-center px-4 py-2">

        <div class="-ml-2">
            <img src="https://res.cloudinary.com/dna9qbejm/image/upload/v1762341326/logo_x0erjc.png" 
                alt="Logo" 
                class="h-20 w-20">
        </div>
        
        <div>
            <h1 class="text-3xl font-extrabold bg-gradient-to-r from-[#0D47A1] to-[#42A5F5] bg-clip-text text-transparent">
                User
            </h1>

            <p class="text-sm text-gray-500">Quản lý tài khoản</p>
        </div>

    </div>

    <nav class="mt-2 space-y-1 px-2"> 

        <a href="{{ route('user.profile') }}" 
        class="flex items-center justify-between px-3 py-2 rounded-lg text-white bg-blue-600 font-medium">
            <div class="flex items-center gap-3">
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0A8.966 8.966 0 0 1 12 20.25a8.966 8.966 0 0 1-5.982-2.975M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span>Hồ sơ</span>
            </div>
        </a>

        <a href="{{ route('user.packages.index') }}" 
        class="flex items-center justify-between px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 font-medium">
            <div class="flex items-center gap-3">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.124.75.75 0 0 0 1.5.043 1.5 1.5 0 0 1 2.98 0 .75.75 0 1 0 1.5-.043Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.751 10.198a.562.562 0 0 0-1.002-.271L9.176 10.6l-2.003-2.002a.562.562 0 0 0-1.002-.271l-1.5 4.502a.562.562 0 0 0 .806.65l2.002-2.003 2.003 2.002a.562.562 0 0 0 .806.271l1.5-4.502a.562.562 0 0 0-.806-.65Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Gói tập đã mua</span>
            </div>
        </a>

        <a href="{{ route('user.classes.index') }}" 
            class="flex items-center justify-between px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 font-medium">
            <div class="flex items-center gap-3">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15ZM9.75 15h.008v.008H9.75V15ZM7.5 15h.008v.008H7.5V15Zm6.75-4.5h.008v.008h-.008v-.008Z" />
                </svg>
                <span>Lớp học đã đăng ký</span>
            </div>
        </a>

        <a href="{{ route('user.orders.index') }}" 
        class="flex items-center justify-between px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 font-medium">
            <div class="flex items-center gap-3">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z" />
                </svg>
                <span>Lịch sử đơn hàng</span>
            </div>
        </a>

        <a href="{{ route('user.borrow_return.index') }}"
            class="flex items-center justify-between px-3 py-2 rounded-lg text-gray-700 hover:bg-gray-100 hover:text-gray-900 font-medium">
            <div class="flex items-center gap-3">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                </svg>
                <span>Lịch sử mượn trả</span>
            </div>
        </a>

        </nav>
</aside>