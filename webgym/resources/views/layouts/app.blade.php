<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'GRYND')</title>
    @vite(['resources/css/app.css', 'resources/js/chatbot.js', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-open-sans bg-[#F5F7FA] text-[#333333]">

    @includeIf('user.layouts.header')

    <div class="h-16"></div>

    <main>
        @yield('content')
    </main>

    @includeIf('user.layouts.footer')

</body>
</html>
