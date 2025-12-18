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
        // 1. CẤU HÌNH DANH SÁCH MENU
        const menuConfig = [
            { id: 'goitap',     btn: 'goitap-btn',    menu: 'goitap-menu',    arrow: 'arrow-goitap' },
            { id: 'lichlop',    btn: 'lichlop-btn',   menu: 'lichlop-menu',   arrow: 'arrow-lichlop' },
            { id: 'muondo',     btn: 'muondo-btn',    menu: 'muondo-menu',    arrow: 'arrow-muondo' },
            { id: 'nguoidung',  btn: 'nguoidung-btn', menu: 'nguoidung-menu', arrow: 'arrow-nguoidung' }
        ];

        // 2. LỌC CÁC MENU TỒN TẠI
        const activeMenus = menuConfig.map(config => {
            const btnEl = document.getElementById(config.btn);
            const menuEl = document.getElementById(config.menu);
            const arrowEl = document.getElementById(config.arrow);

            if (btnEl && menuEl && arrowEl) {
                return { btn: btnEl, menu: menuEl, arrow: arrowEl };
            }
            return null;
        }).filter(item => item !== null); 

        // 3. GÁN SỰ KIỆN CLICK CHO CÁC MENU HỢP LỆ
        activeMenus.forEach(current => {
            current.btn.addEventListener('click', (e) => {
                e.stopPropagation(); 

                // A. Đóng các menu khác 
                activeMenus.forEach(other => {
                    if (other !== current) {
                        other.menu.classList.add('hidden');
                        // Reset mũi tên menu khác về màu xám
                        other.arrow.classList.remove('rotate-90', 'text-blue-700'); 
                        other.arrow.classList.add('text-gray-400');
                    }
                });

                // B. Toggle (Đóng/Mở) menu hiện tại
                const isHidden = current.menu.classList.contains('hidden');
                
                if (isHidden) {
                    current.menu.classList.remove('hidden');
                    // Xoay mũi tên & đổi màu xanh
                    current.arrow.classList.add('rotate-90', 'text-blue-700');
                    current.arrow.classList.remove('text-gray-400');
                } else {
                    current.menu.classList.add('hidden');
                    current.arrow.classList.remove('rotate-90', 'text-blue-700');
                    current.arrow.classList.add('text-gray-400');
                }
            });
        });

        // 4. CLICK RA NGOÀI
        document.addEventListener('click', () => {
            activeMenus.forEach(item => {
                item.menu.classList.add('hidden');
                item.arrow.classList.remove('rotate-90', 'text-blue-700');
                item.arrow.classList.add('text-gray-400');
            });
        });
    });
</script>

@stack('scripts')
</body>
</html>
