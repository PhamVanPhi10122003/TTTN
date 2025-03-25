<?php
session_start();
include "../admin/class/login_class.php";  // Kết nối với lớp xử lý đăng nhập
include "../admin/class/email_class.php"; // Lớp xử lý gửi email

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $login = new Login();
    $user = $login->get_user_by_email($email); // Kiểm tra email có tồn tại không

    if ($user) {
        $token = bin2hex(random_bytes(50)); // Tạo token ngẫu nhiên
        $login->store_reset_token($email, $token); // Lưu token vào CSDL

        $reset_link = "http://localhost:8080/TTTN/VANPHISPORT/view/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click vào link sau để đặt lại mật khẩu: $reset_link";
        
        $email_sender = new Email();
        if ($email_sender->send_email($email, $subject, $message)) {
            // Hiển thị thông báo bằng JavaScript
            echo "<script>alert('Vui lòng kiểm tra email của bạn để đặt lại mật khẩu.');</script>";
        } else {
            // Hiển thị thông báo lỗi bằng JavaScript
            echo "<script>alert('Lỗi khi gửi email, vui lòng thử lại sau.');</script>";
        }
    } else {
        // Thông báo email không tồn tại
        echo "<script>alert('Email không tồn tại trong hệ thống.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container-login">
    <div class="form-container">
        <h2>Quên mật khẩu</h2>
        <form action="forgot_password.php" method="post">
            <div class="form-group">
                <label for="email">Nhập email của bạn:</label>
                <input type="email" id="email" name="email" placeholder="Nhập email" required>
            </div>
            <button type="submit" class="submit-btn">Gửi yêu cầu</button>
            <p>Quay lại <a href="login.php">Đăng nhập</a></p>
        </form>
    </div>
</div>
</body>
</html>
