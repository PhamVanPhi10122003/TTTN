<?php
session_start();
require_once "../admin/class/cartegory_class.php";

// Kiểm tra nếu chưa đăng nhập thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nếu có phương thức thanh toán được chọn, chuyển hướng sang trang thanh toán thành công
    if (isset($_POST['payment_method'])) {
        $_SESSION['payment_method'] = $_POST['payment_method'];
        header("Location: payment_success.php"); // Chuyển hướng sang trang thanh toán thành công
        exit();
    } else {
        $error_message = "Vui lòng chọn phương thức thanh toán.";
    }
}
?>

<?php
$cartegory = new cartegory;
$show_cartegory = $cartegory->show_cartegory();  // Lấy danh mục từ cơ sở dữ liệu

// Kiểm tra nếu không có danh mục nào được trả về
if (!$show_cartegory) {
    // Xử lý khi không có danh mục nào được tìm thấy
    $error_message = "Không tìm thấy danh mục.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VANPHI STORE</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
    <div class="logo">
        <a href="trangchu.php"><img src="../image/1-removebg-preview.png" style="width: 100px;"></a>
    </div>
    <div class="menu">
    <?php
            // Kiểm tra xem $show_cartegory có được trả về và có dữ liệu không
            if (isset($show_cartegory) && $show_cartegory) {
                while ($result = $show_cartegory->fetch_assoc()) {
                    // Lấy id của category
                    $cartegory_id = $result['cartegory_id'];

                    // Truy vấn lấy các sub-category từ bảng brand
                    $query_sub_category = "SELECT * FROM tbl_brand WHERE cartegory_id = '$cartegory_id'";
                    $show_sub_category = $cartegory->getDb()->select($query_sub_category);
            ?>
            <li>
                <a href=""><?php echo $result['cartegory_name']; ?></a>
                <ul class="sub-menu">
                    <?php
                    // Kiểm tra nếu có sub-category
                    if ($show_sub_category) {
                        while ($sub_result = $show_sub_category->fetch_assoc()) {
                    ?>
                        <li><a href="cartegory.php"><?php echo $sub_result['brand_name']; ?></a></li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </li>
            <?php
                }
            } else {
                // Hiển thị thông báo nếu không có danh mục nào
                echo "<li>Không có danh mục nào</li>";
            }
            ?>
        </div>
        <div class="other">
        <li><input id="searchInput" placeholder="Tìm kiếm" type="text"><i class="fas fa-search"></i></li>
        <li><a class="fa fa-user" href="profile.php"></a></li>
        <li><a class="fa fa-shopping-bag" href="history.php"></a></li>
        <li><a class="fa fa-history" href="rental_history.php"></a></li>
        <?php if (isset($_SESSION["id_user"])) { ?>
        <li><a href="logout.php">Đăng xuất</a></li>
        <?php } else { ?>
        <li><a href="login.php">Đăng nhập</a></li>
        <?php } ?>
        </div>
</header>
</section>
<!-------------------cart--------------->
<section class="payment">
    <div class="container">
        <div class="payment-top-wrap">
            <div class="payment-top">
            <div class="cart-top-payment payment-top-item">
                <i class="fas fa-shopping-cart "></i>
            </div>
            <div class="payment-top-adress payment-top-item">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="payment-top-payment payment-top-item ">
                <i class="fas fa-money-check-alt"></i>
            </div>
            </div>
        </div>
    </div>
<section class="paymentt">
    <form action="" method="POST">
        <div class="payment-option">
            <input type="radio" id="cod" name="payment_method" value="COD" required>
            <label for="cod">
              Thanh toán khi nhận hàng (COD)
            </label>
        </div>
        <div class="payment-option">
            <input type="radio" id="bank_transfer" name="payment_method" value="Bank Transfer" required>
            <label for="bank_transfer">
                <img src="../image/bidv.jpg" alt="Bank"> Chuyển khoản ngân hàng
            </label>
        </div>
        <div class="payment-option">
            <input type="radio" id="momo" name="payment_method" value="MoMo" required>
            <label for="momo">
                <img src="../image/momo.jpg" alt="MoMo"> Thanh toán qua MoMo
            </label>
        </div>
        <button type="submit">Xác nhận thanh toán</button>
        <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
    </form>
</section>


</body>
</html>
