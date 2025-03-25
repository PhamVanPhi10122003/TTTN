<?php
require_once "../admin/class/order_class.php";
require_once "../admin/class/cartegory_class.php";
session_start();

// Kiểm tra nếu chưa đăng nhập thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
    exit();
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$cartegory = new cartegory;
$show_cartegory = $cartegory->show_cartegory();


// Kiểm tra nếu không có danh mục nào được trả về
if (!$show_cartegory) {
    // Xử lý khi không có danh mục nào được tìm thấy
    $error_message = "Không tìm thấy danh mục.";
}

$order = new order;
$id_user = $_SESSION['id_user'];
$show_order = $order->get_address($id_user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đơn hàng</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header>
        <div class="logo">
        <a href="trangchu.php"><img src="../image/1-removebg-preview.png" style="width: 100px;"></a>
        </div>
            <div class="menu">
                <?php
                if ($show_cartegory) {
                    while ($result = $show_cartegory->fetch_assoc()) {
                        $cartegory_id = $result['cartegory_id'];
                ?>
        <li>
            <!-- Link dẫn đến trang category.php với tham số cartegory_id -->
            <a href="#">
                <?php echo $result['cartegory_name']; ?>
            </a>
            <ul class="sub-menu">
                <?php
                // Lấy danh sách sub-category từ bảng tbl_brand
                $query_sub_category = "SELECT * FROM tbl_brand WHERE cartegory_id = '$cartegory_id'";
                $show_sub_category = $cartegory->getDb()->select($query_sub_category);
                if ($show_sub_category) {
                    while ($sub_result = $show_sub_category->fetch_assoc()) {
                        $brand_id = $sub_result['brand_id'];
                        $category_id = $sub_result['cartegory_id'];
                ?>
                <li>
                    <!-- Link dẫn đến trang brand.php với tham số brand_id -->
                    <a href="cartegory.php?cartegory_id=<?php echo $category_id; ?>&brand_id=<?php echo $brand_id; ?>">
                        <?php echo $sub_result['brand_name']; ?>
                    </a>
                </li>
                <?php
                    }
                }
                ?>
            </ul>
        </li>
        <?php
            }
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
    
<section class="order-history">
<h2>Lịch Sử Mua Sản Phẩm</h2>
    <table>
        <tr>
            <th>Sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Size</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>

        </tr>
        <?php if ($show_order) { ?>
            <?php while ($order = $show_order->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $order['product_name']; ?></td>
                <td><?php echo number_format($order['product_price_new'], 0, ',', '.'); ?> đ</td>
                <td><?php echo $order['product_qty']; ?></td>
                <td><?php echo $order['product_size']; ?></td>
                <td><?php echo number_format($order['total_price'], 0, ',', '.'); ?> đ</td>
                <td><?php echo $order['status']; ?></td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="8">Không có đơn hàng nào.</td></tr>
        <?php } ?>
    </table>
</section>
</body>
</html> <section class="app-container">
        <p>Tải ứng dụng VĂN PHI SPORT</p>
        <div class="app-google">
        <img src="../image/appstore.jpg">
        <img src="../image/Ch-Play-Apk-Cho-Android.png">
    </div>
        <p>Nhận bản tin VĂN PHI SPORT </p>
        <input type="text" placeholder="Nhập email của bạn ..."> 
    </section>
    <!------------Footer----------->
    <div class="footer-top">
        <li><a href=""><img src="image/Thongbao.webp" alt=""></a></li>
        <li><a href=""></a>Liên hệ</li>
        <li><a href=""></a>Tuyển dụng</li>
        <li><a href=""></a>Giới thiệu</li>
        <li>
            <a href="" class="fab fa-facebook-f"></a>
            <a href="" class="fab fa-twitter"></a>
            <a href="" class="fab fa-youtube"></a>
        </li>
    </div>
    <div class="footer-center">
    <p>
        Công ty cổ phần VĂN PHI STORE đăng ký kinh doanh : 0375756332 <br>
        Địa chỉ đăng ký : Tam Thăng , Tam Kì , Quảng Nam -0231223123 <br>
        Đặt hàng online : <b>0626 232 4341</b>
    </p>
    </div>
    </body>
    <script src="js/scripts.js"> </script>
    <script>
        const header =document.querySelector("header")
            window.addEventListener("scroll",function(){
                x = window.pageYOffset
                if(x>0){
                    header.classList.add("sticky")
                }else {
                    header.classList.remove("sticky")
                }
            })

            document.querySelectorAll('.size span').forEach(item => {
            item.addEventListener('click', function() {
                // Xóa class 'selected' khỏi tất cả các span
                document.querySelectorAll('.size span').forEach(span => span.classList.remove('selected'));

                // Thêm class 'selected' vào phần tử được chọn
                this.classList.add('selected');

                // Lưu giá trị size vào input ẩn để gửi lên server
                document.getElementById('selectedSize').value = this.getAttribute('data-size');
                
            });
        });
    </script>
    </html>