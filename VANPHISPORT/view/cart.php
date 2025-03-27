<?php
require_once "../admin/class/cartegory_class.php";
require_once "../admin/class/product_class.php";
require_once "../admin/class/cart_class.php";
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
$cartegory = new cartegory;
$show_cartegory = $cartegory->show_cartegory();  // Lấy danh mục từ cơ sở dữ liệu

// Kiểm tra nếu không có danh mục nào được trả về
if (!$show_cartegory) {
    // Xử lý khi không có danh mục nào được tìm thấy
    $error_message = "Không tìm thấy danh mục.";
}

$product = new product;
$show_product = $product->show_product();
if (!$show_product) {
    die("Lỗi: Truy vấn không trả về kết quả. Vui lòng kiểm tra phương thức show_product().");
}

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Truy vấn thông tin sản phẩm dựa trên ID
    $query = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
    $result = $product->getDb()->select($query);

    // Kiểm tra nếu không tìm thấy sản phẩm
    if (!$result || $result->num_rows == 0) {
        die("Không tìm thấy sản phẩm.");
    }

    // Lấy dữ liệu sản phẩm
    $product_data = $result->fetch_assoc();
} else {
    die("Không có sản phẩm nào được chọn.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_data = [
        'product_id' => $_POST['product_id'],
        'product_name' => $_POST['product_name'],
        'product_price' => $_POST['product_price'],
        'product_price_new' => $_POST['product_price_new'],
        'product_img' => $_POST['product_img'],
        'product_size' => $_POST['product_size'], 
    ];
    $_SESSION['cart'][] = $product_data; // Lưu vào session để hiển thị
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart = new cart();
    // Kiểm tra xem có size được chọn không
    if (empty($_POST["product_size"])) {
        die("Vui lòng chọn size sản phẩm!");
    }

    $result = $cart->insert_cart();

    
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
<section class="cart">
    <div class="container">
        <div class="cart-top-wrap">
            <div class="cart-top">
            <div class="cart-top-cart cart-top-item">
                <i class="fas fa-shopping-cart "></i>
            </div>
            <div class="cart-top-adress cart-top-item">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="cart-top-payment cart-top-item">
                <i class="fas fa-money-check-alt"></i>
            </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="cart-content row">
            <div class="cart-content-left">
                <table>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá ban đầu</th>
                        <th>Size</th>
                        <th>Giá đã sale</th>
                    </tr>
                    <tr>
                        <td>
                            <img src="../image/<?php echo $product_data['product_img']; ?>" 
                            alt="<?php echo $product_data['product_name']; ?>" 
                            style="width: 100px;">
                        </td>
                        <td><?php echo $product_data['product_name']; ?></td>
                        <td class="product_price" data-price="<?php echo $product_data['product_price']; ?>">
                            <?php echo number_format($product_data['product_price'], 0, ',', '.'); ?> <sup>đ</sup>
                        </td>
                        <td><?php echo !empty($product_data['product_size']) ? $product_data['product_size'] : 'Chưa chọn'; ?></td> 
                        <td class="product_price_new" data-price="<?php echo $product_data['product_price_new']; ?>">
                            <?php echo number_format($product_data['product_price_new'], 0, ',', '.'); ?> <sup>đ</sup>
                        </td>
                    </tr>
            </div>
        </div>
    </div>
</section>
                </table>
            </div>
            <div class="cart-content-right">
            <table>
                    <tr>
                        <th colspan="2">TỔNG TIỀN TRONG GIỎ HÀNG</th>
                    </tr>
                    <tr>
                        <td>TỔNG SẢN PHẢM</td>
                        <td><input type="number" value="1" min="1" onchange="calculateTotal(this); updateTotalPrice();"></td>
                    </tr>
                    <tr>
                        <td>TỔNG TIỀN HÀNG</td>
                        <td><span id="total_price"><?php echo number_format($product_data['product_price_new'], 0, ',', '.'); ?> <sup>đ</sup></span></td>
                    </tr>
                </table> 
                <div class="cart-content-right-text">
                    <p>Bạn sẽ được miễn phí ship khi đơn hàng của bạn có tổng giá trị trên 2.000.000 đ</p>
                    <p style="color: red; font-weight: bold;">Mua thêm <span style="font-size: 18px;">100.000đ</span> để được miễn phí SHIP</p>
                </div>
                <div class="cart-content-right-button">
                <form action="giaohang.php" method="GET" >
                <input type="hidden" name="product_id" value="<?php echo $product_data['product_id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $product_data['product_name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $product_data['product_price']; ?>">
                <input type="hidden" name="product_price_new" value="<?php echo $product_data['product_price_new']; ?>">
                <input type="hidden" name="product_img" value="<?php echo $product_data['product_img']; ?>">
                <input type="hidden" id="product_qty" name="product_qty" value="1">
                <input type="hidden" id="total_price" name="total_price" value="<?php echo $product_data['product_price_new']; ?>">
                <input type="hidden" id="selectedSize" name="product_size" value="<?php echo $product_data['product_size'];?>" >
                 <button type="submit">THANH TOÁN</button>
                </form>
      
                </div>
                <div class="cart-content-right-dangnhap">
                    <p>TÀI KHOẢN</p>
                    <p>Hãy <a href="">Đăng nhập</a>tài khoản của bạn để tích điểm thành viên</p>
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

        

        /*------------*/
        function calculateTotal(input) {
        let quantity = input.value;
        let price = <?php echo $product_data['product_price_new']; ?>;
        let totalPrice = quantity * price;
        
        // Cập nhật tổng tiền trên giao diện
        document.getElementById('total_price').textContent = totalPrice.toLocaleString('vi-VN') + " đ";

        // Gán giá trị vào input hidden để gửi qua form
        document.getElementById('product_qty').value = quantity;
        document.querySelector("input[name='total_price']").value = totalPrice;
    } 

    
</script>
</html>
