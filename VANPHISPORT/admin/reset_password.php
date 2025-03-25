<?php
session_start();
$conn = new mysqli("localhost", "root", "", "your_database");

if (isset($_GET["token"])) {
    $token = $_GET["token"];
    $result = $conn->query("SELECT * FROM users WHERE reset_token='$token'");

    if ($result->num_rows > 0) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            $conn->query("UPDATE users SET password='$new_password', reset_token=NULL WHERE reset_token='$token'");

            echo "Mật khẩu đã được đặt lại!";
        }
    } else {
        echo "Liên kết không hợp lệ!";
    }
} else {
    echo "Token không tồn tại!";
}
?>
<form method="post">
    <input type="password" name="password" placeholder="Nhập mật khẩu mới" required>
    <button type="submit">Đặt lại mật khẩu</button>
</form>
