function loadMessages() {
    fetch("http://localhost:8080/TTTN/VANPHISPORT/admin/get_messages.php")
        .then(response => response.json())
        .then(data => {
            const chatMessages = document.getElementById("chat-messages");
            chatMessages.innerHTML = ""; // Xóa nội dung cũ

            data.forEach(msg => {
                let userMessage = `<p class="user-message"><strong>${msg.username}:</strong> ${msg.message}</p>`;
                chatMessages.innerHTML += userMessage;

                if (msg.reply && msg.reply.trim() !== "") {
                    let adminReply = `<p class="admin-message"><strong>Admin:</strong> ${msg.reply}</p>`;
                    chatMessages.innerHTML += adminReply;
                }
            });

            chatMessages.scrollTop = chatMessages.scrollHeight; // Cuộn xuống cuối
        })
        .catch(error => console.error("❌ Lỗi loadMessages():", error));
}

// Load tin nhắn mỗi 3 giây để cập nhật phản hồi mới
document.addEventListener("DOMContentLoaded", function () {
    loadMessages();
    setInterval(loadMessages, 3000);
});




function showReplyBox(messageId) {
    let replySection = document.getElementById("reply-section");
    replySection.style.display = "block";

    let replyInput = document.getElementById("reply-input");
    replyInput.dataset.messageId = messageId;

    // Hiển thị tin nhắn của user mà admin đang phản hồi
    let messageDiv = document.querySelector(`.message[data-message-id="${messageId}"] p`);
    let userMessage = messageDiv ? messageDiv.innerHTML : "Không tìm thấy tin nhắn!";
    document.getElementById("reply-message-preview").innerHTML = `<strong>Phản hồi:</strong> ${userMessage}`;
}


function sendReply() {
    let replyInput = document.getElementById("reply-input");
    let messageId = replyInput.dataset.messageId;
    let replyText = replyInput.value.trim();

    if (!messageId || replyText === "") {
        alert("Vui lòng nhập nội dung phản hồi.");
        return;
    }

    fetch("http://localhost:8080/TTTN/VANPHISPORT/view/admin_reply.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `message_id=${messageId}&reply=${encodeURIComponent(replyText)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Đã trả lời!");

            // **Cập nhật ngay lập tức trong giao diện User**
            updateUserChatbox(messageId, replyText);

            // **Cập nhật ngay trên giao diện Admin**
            let messageDiv = document.querySelector(`.message[data-message-id="${messageId}"]`);
            if (messageDiv) {
                let adminReply = document.createElement("p");
                adminReply.classList.add("admin-reply");
                adminReply.innerHTML = `<strong>Admin:</strong> ${replyText}`;
                messageDiv.appendChild(adminReply);
            }

            // Ẩn hộp thoại phản hồi và reset input
            replyInput.value = "";
            document.getElementById("reply-section").style.display = "none";
        } else {
            alert("Lỗi khi gửi phản hồi: " + data.message);
        }
    })
    .catch(error => console.error("❌ Lỗi gửi phản hồi:", error));
}

