<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>WebGym - Trang chủ</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <h1>🏋️ WebGym</h1>
        <nav>
            <a href="#">Trang chủ</a>
            <a href="#">Sản phẩm</a>
            <a href="#">Liên hệ</a>
        </nav>
    </header>

    <main>
        <section class="intro">
            <h2>Chào mừng bạn đến với WebGym!</h2>
            <p>Website quản lý và hỗ trợ mua sắm thiết bị thể hình hàng đầu.</p>
            <button>Bắt đầu ngay</button>
        </section>

        <!-- Nút chatbot nổi -->
        <div id="chatbot-toggle">
            💬
        </div>

        <!-- Khung chat ẩn/hiện -->
        <div id="chatbot-container">
            <div id="chat-header">
                <span>🤖 WebGym Assistant</span>
                <button id="close-chat">×</button>
            </div>
            <div id="chat-log"></div>
            <div id="chat-input-area">
                <input type="text" id="user-input" placeholder="Nhập tin nhắn..." />
                <button id="send-btn">Gửi</button>
            </div>
        </div>

    </main>

    <footer>
        <p>© 2025 WebGym. All rights reserved.</p>
    </footer>

    <script src="{{ asset('js/chatbot.js') }}"></script>
</body>
</html>