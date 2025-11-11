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

<body class="bg-gray-100">

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
        <!-- Script cho menu con Lịch lớp -->
        document.addEventListener('DOMContentLoaded', () => {
            const lichlopBtn = document.getElementById('lichlop-btn');
            const lichlopMenu = document.getElementById('lichlop-menu');
            const lichlopArrow = document.getElementById('arrow-lichlop');

            lichlopBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                lichlopMenu.classList.toggle('hidden');
                lichlopArrow.classList.toggle('rotate-90');
            });

            window.addEventListener('click', () => {
                lichlopMenu.classList.add('hidden');
                lichlopArrow.classList.remove('rotate-90');
            });
        });

        <!-- Script cho menu con Quản lý người dùng -->
        document.addEventListener('DOMContentLoaded', () => {
            const nguoidungBtn = document.getElementById('nguoidung-btn');
            const nguoidungMenu = document.getElementById('nguoidung-menu');
            const nguoidungArrow = document.getElementById('arrow-nguoidung');

            nguoidungBtn.addEventListener('click', () => {
                nguoidungMenu.classList.toggle('hidden');
                nguoidungArrow.classList.toggle('rotate-90');
           });

            window.addEventListener('click', (e) => {
                if (!nguoidungBtn.contains(e.target)) {
                        nguoidungMenu.classList.add('hidden');
                        nguoidungArrow.classList.remove('rotate-90');
                }
            });
        });

    </script>


</body>
</html>