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

function slider (index){
    imgContainer.style.left = "-" +index*100 + "%"
    const dotActive = document.querySelector('.active')
    dotActive.classList.remove("active")
    dotItem[index].classList.add("active")
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
    const username = document.getElementById("username").value.trim();
    const message = document.getElementById("message").value.trim();
    const chatMessages = document.getElementById("chat-messages");

    if (message === "" || username === "") {
        alert("Vui lòng nhập tên và tin nhắn.");
        return;
    }

    // Gửi tin nhắn lên server để lưu vào CSDL
    fetch("http://localhost:8080/TTTN/VANPHISPORT/admin/chat_handler.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `username=${encodeURIComponent(username)}&message=${encodeURIComponent(message)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            // Hiển thị tin nhắn ngay lập tức
            const userMessage = document.createElement("div");
            userMessage.className = "chat-message user";
            userMessage.textContent = `${username}: ${message}`;
            chatMessages.appendChild(userMessage);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            // Xóa nội dung ô nhập
            document.getElementById("message").value = "";
        } else {
            alert("Lỗi khi gửi tin nhắn: " + data.message);
        }
    })
    .catch(error => console.error(" Lỗi gửi tin nhắn:", error));
}


function toggleQR() {
    var bankTransfer = document.getElementById('bank_transfer');
    var momo = document.getElementById('momo');
    var qrContainer = document.getElementById('qr-container');
    var qrImage = document.getElementById('qr-image');

    if (bankTransfer.checked) {
        qrContainer.style.display = 'block';
        qrImage.src = "../image/qrcode-bidv.jpg";  // Mã QR ngân hàng
    } else if (momo.checked) {
        qrContainer.style.display = 'block';
        qrImage.src = "../image/qrcode-momo.jpg";  // Mã QR MoMo
    } else {
        qrContainer.style.display = 'none';
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








