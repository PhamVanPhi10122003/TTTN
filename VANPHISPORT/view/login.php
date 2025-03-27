<?php
session_start();  
include "../admin/class/login_class.php";  // Kết nối với lớp xử lý đăng nhập

// Kiểm tra nếu người dùng đã gửi form đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']); 

    $login = new Login();  // Tạo đối tượng Login

    // Gọi phương thức kiểm tra đăng nhập
    $user = $login->check_login($email, $password);

    if ($user && password_verify($password, $user['password'])) { // Nếu đăng nhập thành công
        $_SESSION['id_user'] = $user['id_user'];  // Lưu ID người dùng vào session
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role']; // Lưu vai trò của người dùng (nếu cần)

        // Điều hướng người dùng theo vai trò
        if ($user['role'] == 1) {
            header('Location: trangchu.php');  // Admin
        } elseif ($user['role'] == 0) {
            header('Location: ../admin');  // Khách hàng
        }
        exit();
    } else {
        echo "Email hoặc mật khẩu không chính xác.";
    }
}
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/login.css">
    </head>
    <body>
    <div class="container-login">
        <div class="form-container">
            <h2>Login</h2>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password :</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="submit-btn">Login</button>
                <p><a href="forgot_password.php">Quên mật khẩu?</a></p>
                <p>Tôi chưa có tài khoản? <a href="signup.php">Signup</a></p>
            </form>
        </div>
    </div>
    </body>
    </html> 