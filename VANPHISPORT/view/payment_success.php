<?php
session_start();

// Kiểm tra nếu chưa đăng nhập thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán Thành Công - VANPHI STORE</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="payment-success">
        <h1>Thanh toán thành công!</h1>
        <p>Cảm ơn bạn đã mua hàng tại VANPHI STORE. Đơn hàng của bạn sẽ được xử lý ngay.</p>
        <!-- Thông báo và tự động chuyển hướng về trang chủ sau 3 giây -->
        <p>Trang sẽ tự động chuyển hướng về trang chủ sau <span id="countdown">3</span> giây.</p>
    </div>

    <script> 
        // Thiết lập đồng hồ đếm ngược
    let countdown = 3;
        const countdownElement = document.getElementById('countdown');

        setInterval(function() {
            countdown--;
            countdownElement.innerHTML = countdown;
            if (countdown <= 0) {
                window.location.href = 'trangchu.php'; // Chuyển hướng về trang chủ
            }
        }, 1000); // Cập nhật mỗi giây 
    </script>

</body>

</html>
