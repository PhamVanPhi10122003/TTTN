<?php
require_once "../admin/class/cartegory_class.php";
require_once "../admin/class/product_class.php";
require_once "../admin/class/address_class.php";
?>

<?php
session_start();

// Kiểm tra nếu chưa đăng nhập thì chuyển hướng về trang đăng nhập
if (!isset($_SESSION["id_user"])) {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập
    exit();
}
?>
<?php
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

?>
<?php
$Address = new Address;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $insert_address = $Address->insert_address($_POST);

    if ($insert_address === true) {
        header('Location: payment.php');  
        exit();  
    } else {
        echo "Lỗi khi lưu địa chỉ: " . $insert_address;
    }
}
// Hiển thị thông báo nếu có    
if (isset($message)) {
    echo $message;
}

$insert_address = null; 
// Kiểm tra nếu có dữ liệu gửi đến từ cart.php
if (!empty($_GET['product_name']) && !empty($_GET['product_price_new']) && !empty($_GET['product_qty'])&& !empty($_GET['product_size']) && !empty($_GET['total_price'])) {
    $product_name = $_GET['product_name'];  
    $product_price_new = $_GET['product_price_new'];
    $product_qty = $_GET['product_qty'];
    $product_size = $_GET['product_size'];
    $total_price = $_GET['total_price']; 

    $sql_update_price = "UPDATE tbl_address 
                         SET product_price_new = ?, total_price = ? ,product_qty = ? , product_size = ?
                         WHERE id_user = ? AND product_name = ?";
    
} else {
    die("Lỗi: Không nhận được dữ liệu sản phẩm.");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
</section>
<!------------------Delivery--------------------->
<section class="delivery">
    <div class="container">
        <div class="delivery-top-wrap">
            <div class="delivery-top">
            <div class="delivery-top-delivery delivery-top-item">
                <i class="fas fa-shopping-cart "></i>
            </div>
            <div class="delivery-top-adress delivery-top-item">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="delivery-top-payment delivery-top-item">
                <i class="fas fa-money-check-alt"></i>
            </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="delivery-content row">
            <div class="delivery-content-left">
                <p>Vui lòng chọn địa chỉ giao hàng với thông tin bên dưới</p>
    <form action="giaohang.php" action="history.php" method="POST">
    <div class="delivery-content-left-input-top row">
        <div class="delivery-content-left-input-top-item">
            <label>Họ tên <span style="color: red;">*</span></label>
            <input type="text" name="full_name" required>
        </div>
        <div class="delivery-content-left-input-top-item">
            <label>Điện thoại <span style="color: red;">*</span></label>
            <input type="text" name="phone" required>
        </div>
        <div class="delivery-content-left-input-top-item">
            <label>Tỉnh / Thành phố <span style="color: red;">*</span></label>
            <input type="text" name="city" required>
        </div>
        <div class="delivery-content-left-input-top-item">
            <label>Quận / Huyện <span style="color: red;">*</span></label>
            <input type="text" name="district" required>
        </div>
        <div class="delivery-content-left-input-top-item">
            <label>Địa chỉ <span style="color: red;">*</span></label>
            <input type="text" name="address" required>
        </div>
    </div>

    <!-- Truyền dữ liệu sản phẩm vào form -->
    <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($id_user); ?>">
    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">
    <input type="hidden" name="product_price_new" value="<?php echo htmlspecialchars($product_price_new); ?>">
    <input type="hidden" name="product_qty" value="<?php echo htmlspecialchars($product_qty); ?>">
    <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($total_price); ?>">
    <input type="hidden" name="product_size" value="<?php echo htmlspecialchars($product_size); ?>">

    <div class="delivery-content-left-buttom row">
    <button type="submit" style="font-weight: bold;">THANH TOÁN VÀ GIAO HÀNG</button>
    </div>
</form>
            </div>
            <div class="delivery-content-right">
                <table>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>SL</th>
                        <th>Size</th>
                        <th>Thành tiền</th>
                    </tr>
                    <td><?php echo htmlspecialchars($product_name); ?></td>
                    <td><?php echo number_format($product_price_new, 0, ',', '.'); ?> đ</td>
                    <td><?php echo htmlspecialchars($product_qty); ?></td>
                    <td><?php echo htmlspecialchars($product_size); ?></td>
                    <td ><?php echo number_format($total_price, 0, ',', '.'); ?> đ</td>
                </table>
            </div>
        </div>    
        </div>
    </div>
</section>
<section class="app-container">
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
    <li><a href=""><img src="../image/Thongbao.webp" alt=""></a></li>
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
<script src="../js/scripts.js"></script>
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
    </script>
</html>