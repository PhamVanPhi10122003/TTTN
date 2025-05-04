const imgPosition = document.querySelectorAll(".aspect-ratio-169 img")
const imgContainer = document.querySelector('.aspect-ratio-169')

const dotItem = document.querySelectorAll(".dot")

let imgNuber = imgPosition.length
let index = 0

// console.log(imgPosition)

imgPosition.forEach(function(image,index){
    image.style.left = index*100 + "%"
    dotItem[index].addEventListener("click", function(){
        slider(index)
    })
})

function imgSlide (){
    index++;
    console.log(index)
    if (index >= imgNuber) {index=0}
    slider(index)
}

function slider(index){
    imgContainer.style.left = "-" + index * 100 + "%";

    // Chỉ tìm .dot.active để không ảnh hưởng menu hay thành phần khác
    const currentDot = document.querySelector('.dot.active');
    if (currentDot) {
        currentDot.classList.remove("active");
    }

    dotItem[index].classList.add("active");
}


setInterval(imgSlide,3000)

function toggleChatbox() {
    const chatbox = document.querySelector(".chatbox");
    chatbox.style.display = (chatbox.style.display === "none" || chatbox.style.display === "") ? "flex" : "none";
}

// Đóng chatbox khi nhấn phím Esc
document.addEventListener("keydown", function(event) {
    const chatbox = document.querySelector(".chatbox");
    if (event.key === "Escape" && chatbox.style.display === "flex") {
        chatbox.style.display = "none";
    }
});

function sendMessage() {
    const message = document.getElementById("message").value.trim();
    const chatMessages = document.getElementById("chat-messages");

    if (message === "") {
        alert("Vui lòng nhập tin nhắn.");
        return;
    }

    // Gửi tin nhắn lên server để lưu vào CSDL
    fetch("http://localhost:8080/TTTN/VANPHISPORT/admin/chat_handler.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `message=${encodeURIComponent(message)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            // Hiển thị tin nhắn ngay lập tức
            const userMessage = document.createElement("div");
            userMessage.className = "chat-message user";
            userMessage.textContent = `Bạn: ${message}`;
            chatMessages.appendChild(userMessage);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            // Xóa nội dung ô nhập
            document.getElementById("message").value = "";
        } else {
            alert("Lỗi khi gửi tin nhắn: " + data.message);
        }
    })
    .catch(error => console.error("Lỗi gửi tin nhắn:", error));
}

// Gửi tin nhắn khi nhấn Enter
document.getElementById("message").addEventListener("keypress", function(event) {
    if (event.key === "Enter" && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
    }
});
function fetchMessages() {
    fetch("http://localhost:8080/TTTN/VANPHISPORT/admin/chat_handler.php")
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                const chatMessages = document.getElementById("chat-messages");
                chatMessages.innerHTML = ""; // Xóa tin nhắn cũ khi user mới đăng nhập

                data.messages.forEach(msg => {
                    const messageDiv = document.createElement("div");
                    messageDiv.className = msg.username === "Văn Phi Sport" ? "chat-message bot" : "chat-message user";
                    messageDiv.textContent = `${msg.username}: ${msg.message}`;
                    chatMessages.appendChild(messageDiv);
                });

                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        })
        .catch(error => console.error("Lỗi tải tin nhắn:", error));
}



// Gọi hàm này khi trang load hoặc khi đăng nhập thành công
document.addEventListener("DOMContentLoaded", fetchMessages);




function toggleQR() {
    var bankTransfer = document.getElementById('bank_transfer');
    var momo = document.getElementById('momo');
    var qrBank = document.getElementById('qr-bank');
    var qrMomo = document.getElementById('qr-momo');

    if (bankTransfer.checked) {
        qrBank.style.display = 'block';
        qrMomo.style.display = 'none';
    } else if (momo.checked) {
        qrBank.style.display = 'none';
        qrMomo.style.display = 'block';
    } else {
        qrBank.style.display = 'none';
        qrMomo.style.display = 'none';
    }
}


    function toggleRentalTerms() {
        var terms = document.getElementById("rental-terms");
        if (terms.style.display === "none") {
            terms.style.display = "block";
        } else {
            terms.style.display = "none";
        }
    }

    function searchProduct() {
        let query = document.getElementById("searchInput").value;
        if (query.length > 1) {
            fetch("search.php?q=" + query)
                .then(response => response.text())
                .then(data => document.getElementById("searchResults").innerHTML = data);
        } else {
            document.getElementById("searchResults").innerHTML = "";
        }
    }

    let isMenuOpen = false;

    function toggleMenu() {
        const menu = document.querySelector('.menu');
        isMenuOpen = !isMenuOpen;
        menu.classList.toggle('active', isMenuOpen);
    }
    









