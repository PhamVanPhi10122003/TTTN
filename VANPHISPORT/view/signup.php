<?php
include "../admin/class/signup_class.php"; 

$signup = new Signup;
$message = ""; // Đặt mặc định rỗng

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $signup->insert_signup($_POST);

    if ($result === "success") {
        header('Location: login.php'); // Chuyển hướng đến trang đăng nhập nếu thành công
        exit();
    } else {
        $message = $result; // Nhận thông báo lỗi nếu có
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
<div class="container-login">
    <div class="form-container">
        <h2>Sign Up</h2>
        <?php if (!empty($message)) echo "<p style='color: red;'>$message</p>"; ?> <!-- Hiển thị thông báo -->
        <form action="signup.php" method="post">
            <div class="form-group">
                <label for="username">First Name:</label>
                <input type="text" id="username" name="username" placeholder="Enter your Frist Name" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" placeholder="Enter your Last Name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="PhoneNumber" name="PhoneNumber" placeholder="Enter your PhoneNumber" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="Address" name="Address" placeholder="Enter your Address"  required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="submit-btn">Sign Up</button>
            <p>Tôi đã có tài khoản? <a href="login.php">Login</a></p>
        </form>
    </div>
</div>
</body>
</html>
