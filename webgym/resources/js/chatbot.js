// Chatbot AI
document.addEventListener('DOMContentLoaded', function () {
    // Lấy các phần tử từ HTML
    const chatbotToggleBtn = document.getElementById('chatbot-toggle');
    const chatbotWindow = document.getElementById('chatbot-window');
    const closeChatbotBtn = document.getElementById('close-chatbot');

    if (chatbotToggleBtn && chatbotWindow && closeChatbotBtn) {
        
        // Hàm để bật/tắt khung chat
        function toggleChatbot() {
            chatbotWindow.classList.toggle('scale-95');
            chatbotWindow.classList.toggle('opacity-0');
            // Bật/tắt khả năng tương tác
            chatbotWindow.classList.toggle('pointer-events-auto');
        }
        // 1. Khi bấm vào nút linh vật
        chatbotToggleBtn.addEventListener('click', toggleChatbot);
        // 2. Khi bấm vào nút đóng
        closeChatbotBtn.addEventListener('click', toggleChatbot);
    }
    
    // == Nút gợi ý chat ==
    const chatInput = document.getElementById('chatbot-input');
    const suggestionContainer = document.getElementById('chatbot-suggestions');
    const sendButton = document.getElementById('chatbot-send');

    // Kiểm tra xem chúng có tồn tại không
    if (chatInput && suggestionContainer && sendButton) {

        // Lắng nghe sự kiện click trên *khung chứa* các nút
        suggestionContainer.addEventListener('click', function(e) {

            // Chỉ chạy code nếu thứ được bấm vào là nút gợi ý
            if (e.target.classList.contains('chatbot-suggestion')) {
                // Lấy nội dung text của nút
                const suggestionText = e.target.innerText;
                // Gán text đó vào ô input
                chatInput.value = suggestionText;
                // (Tùy chọn) Tự động focus vào ô input
                chatInput.focus();
            }
        });

        // Tạo một hàm riêng để ẩn gợi ý
        function hideSuggestions() {
            suggestionContainer.style.display = 'none';
        }

        // Lắng nghe khi bấm nút Gửi
        sendButton.addEventListener('click', hideSuggestions);

        // Lắng nghe khi bấm Enter trong ô input
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                hideSuggestions();
            }
        });
    }

    // (Phần code AI chatbot)

});