<?php
session_start(); 
include "../admin/class/login_class.php";  // Kết nối với lớp xử lý đăng nhập

// Kiểm tra token
if (isset($_GET["token"])) {
    $token = $_GET["token"];

    // Tạo đối tượng Login để tương tác với cơ sở dữ liệu
    $login = new Login();
    
    // Kiểm tra token có hợp lệ không (token phải tồn tại trong cơ sở dữ liệu và chưa hết hạn)
    $query = "SELECT * FROM tbl_user WHERE reset_token = '$token' AND token_expiry > NOW() LIMIT 1";
    $result = $login->getDb()->select($query);
    
    if ($result && $result->num_rows > 0) {
        // Token hợp lệ, xử lý thay đổi mật khẩu
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy mật khẩu mới
            $new_password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            
            // Cập nhật mật khẩu mới và xóa token
            $update_query = "UPDATE tbl_user SET password = '$new_password', reset_token = NULL, token_expiry = NULL WHERE reset_token = '$token'";
            $login->getDb()->update($update_query);
            
            // Hiển thị thông báo thành công bằng JavaScript
            echo "<script>alert('Mật khẩu của bạn đã được thay đổi thành công.'); window.location.href='login.php';</script>";
        }
    } else {
        // Token không hợp lệ hoặc đã hết hạn
        echo "<script>alert('Liên kết không hợp lệ hoặc đã hết hạn.'); window.location.href='login.php';</script>";
    }
} else {
    echo "<script>alert('Token không tồn tại.'); window.location.href='login.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container-login">
    <div class="form-container">
        <h2>Đặt lại mật khẩu</h2>
        <form action="reset_password.php?token=<?php echo $_GET['token']; ?>" method="post">
            <div class="form-group">
                <label for="password">Mật khẩu mới:</label>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu mới" required>
            </div>
            <button type="submit" class="submit-btn">Cập nhật mật khẩu</button>
            <p><a href="login.php">Quay lại đăng nhập</a></p>
        </form>
    </div>
</div>
<div class="chat-container">
        <div class="chat-circle" onclick="toggleChatbox()">
            <i class="fas fa-comments"></i>
        </div>
        <div class="chatbox">
            <div class="chat-header">
                <span>Chat với Văn Phi Sport</span>
            </div>
            <div class="chat-messages" id="chat-messages"></div>
            <input type="text" id="username" placeholder="Tên của bạn">
            <textarea id="message" placeholder="Nhập tin nhắn..."></textarea>
            <button onclick="sendMessage()">Gửi</button>
        </div>
    </div>
<script src="../js/admin.js"> </script>
</body>
</html>
