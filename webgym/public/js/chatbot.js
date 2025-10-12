const chatToggle = document.getElementById("chatbot-toggle");
const chatContainer = document.getElementById("chatbot-container");
const closeChat = document.getElementById("close-chat");
const sendBtn = document.getElementById("send-btn");
const chatLog = document.getElementById("chat-log");
const userInput = document.getElementById("user-input");

// Ẩn/hiện khung chat
chatToggle.addEventListener("click", () => {
    chatContainer.style.display = "flex";
    chatToggle.style.display = "none";
});

closeChat.addEventListener("click", () => {
    chatContainer.style.display = "none";
    chatToggle.style.display = "block";
});

// Gửi tin nhắn
sendBtn.addEventListener("click", () => {
    const message = userInput.value.trim();
    if (!message) return;

    chatLog.innerHTML += `<div><b>Bạn:</b> ${message}</div>`;
    userInput.value = "";

    chatLog.innerHTML += `<div><i>Chatbot:</i> Đang xử lý...</div>`;

    // Giả lập phản hồi AI
    setTimeout(() => {
        chatLog.innerHTML += `<div><b>Chatbot:</b> Xin chào! Tôi là trợ lý ảo WebGym</div>`;
        chatLog.scrollTop = chatLog.scrollHeight;
    }, 800);
});
