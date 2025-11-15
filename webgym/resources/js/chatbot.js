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
    const chatBody = document.querySelector("#chatbot-window .overflow-y-auto");

    // Tạo một hàm riêng để ẩn gợi ý
    function hideSuggestions() {
        if (suggestionContainer) {
            suggestionContainer.style.display = 'none';
        }
    }

    // Tạo một hàm riêng để HIỆN gợi ý
    function showSuggestions() {
        if (suggestionContainer) {
            suggestionContainer.style.display = ''; 
        }
    }

    async function sendMessageToAI(message) {
        // Hiển thị tin nhắn người dùng
        appendMessage("Bạn", message, "text-right");

        // Hiển thị phản hồi tạm thời
        appendMessage("GRYND AI", "Đang soạn phản hồi...", "text-left italic text-gray-500", true);

        try {
            const response = await fetch("/chatbot/message", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();

            // Xóa tin nhắn tạm
            const lastTemp = chatBody.querySelector('[data-temp="true"]');
            if (lastTemp) lastTemp.remove();

            appendMessage("GRYND AI", data.reply, "text-left");

            showSuggestions();
        } 
        catch (error) {
            const lastTemp = chatBody.querySelector('[data-temp="true"]');
            if (lastTemp) lastTemp.remove();

            appendMessage("GRYND AI", "Xin lỗi, hệ thống đang tạm bận. Vui lòng thử lại sau!", "text-left text-red-500");

            showSuggestions();
        }
    }

    // Hàm hiển thị tin nhắn (đã có khả năng xử lý Markdown)
    function appendMessage(sender, text, alignClass = "", temporary = false) {
        const div = document.createElement("div");
        div.className = `my-2 ${alignClass}`;
        
        let formattedText = text;

        if (alignClass.includes('text-left')) {
            
            // Chuyển **bold** thành thẻ <strong> 
            formattedText = formattedText.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

            // 2. Chuyển * (dấu bullet) ở đầu dòng thành dấu • 
            formattedText = formattedText.replace(/^\s*\*\s/gm, '• ');

            // 3. Chuyển dấu xuống dòng (\n) thành thẻ <br> 
            formattedText = formattedText.replace(/\n/g, '<br>');
        }

        div.innerHTML = `<p class="bg-gray-100 rounded-lg p-2 inline-block max-w-[80%]">${formattedText}</p>`;
        
        if (temporary) div.dataset.temp = "true";
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

// Gắn sự kiện gửi tin nhắn
    if (sendButton && chatInput) {
        sendButton.addEventListener("click", () => {
            const message = chatInput.value.trim();
            if (message) {
                sendMessageToAI(message);
                chatInput.value = "";
            }
        });

        chatInput.addEventListener("keypress", e => {
            if (e.key === "Enter") {
                const message = chatInput.value.trim();
                if (message) {
                    sendMessageToAI(message);
                    chatInput.value = "";
                }
            }
        });
    }
});