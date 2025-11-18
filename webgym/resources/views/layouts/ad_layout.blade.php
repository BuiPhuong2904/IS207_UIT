<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gym Admin Dashboard')</title>

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }
        
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
</head>

<body class="bg-gray-100 ">

    <!-- Sidebar -->    
    <div class="flex h-screen gap-2 bg-gray-100">        
        @include('partials.sidebar')

        <!-- Topbar -->
        <div class="flex-1 flex flex-col overflow-hidden">           
            @include('partials.topbar')

            <!-- Main content -->
            <main class="flex-1 p-6 overflow-y-auto">
                
                @yield('content')

            </main>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- Định nghĩa tất cả các menu ---
        // 1. Menu Lịch Lớp
        const lichlopBtn = document.getElementById('lichlop-btn');
        const lichlopMenu = document.getElementById('lichlop-menu');
        const lichlopArrow = document.getElementById('arrow-lichlop');

        // 2. Menu Mượn Đồ
        const muondoBtn = document.getElementById('muondo-btn');
        const muondoMenu = document.getElementById('muondo-menu');
        const muondoArrow = document.getElementById('arrow-muondo');

        // 3. Menu Người Dùng
        const nguoidungBtn = document.getElementById('nguoidung-btn');
        const nguoidungMenu = document.getElementById('nguoidung-menu');
        const nguoidungArrow = document.getElementById('arrow-nguoidung');

        // --- Tạo một mảng chứa tất cả các menu ---
        const allMenus = [
            { btn: lichlopBtn, menu: lichlopMenu, arrow: lichlopArrow },
            { btn: muondoBtn, menu: muondoMenu, arrow: muondoArrow },
            { btn: nguoidungBtn, menu: nguoidungMenu, arrow: nguoidungArrow }
        ];

        // --- Thêm sự kiện click cho MỖI menu ---
        allMenus.forEach(currentMenu => {
            currentMenu.btn.addEventListener('click', (e) => {
                // Ngăn sự kiện click lan ra ngoài
                e.stopPropagation();

                // 1. Đóng TẤT CẢ các menu khác
                allMenus.forEach(otherMenu => {
                    // Chỉ đóng nếu đó KHÔNG PHẢI là menu đang được click
                    if (otherMenu !== currentMenu) {
                        otherMenu.menu.classList.add('hidden');
                        otherMenu.arrow.classList.remove('rotate-90');
                    }
                });

                // 2. Toggle (đóng/mở) menu hiện tại
                currentMenu.menu.classList.toggle('hidden');
                currentMenu.arrow.classList.toggle('rotate-90');
            });
        });

    });
</script>

@stack('scripts')
</body>
</html>
