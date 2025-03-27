<?php
require_once "../admin/class/cartegory_class.php";
require_once "../admin/class/product_class.php";
require_once "../admin/class/address_class.php"; 
require_once "../admin/class/cart_class.php";

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

$product = new product;
$show_product = $product->show_product();
if (!$show_product) {
    die("Lỗi: Truy vấn không trả về kết quả. Vui lòng kiểm tra phương thức show_product().");
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

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
<!---------------------product------------------>
<section class="product">
    <div class="container">
        <div class="content-content row">
            <div class="product-content-left row">
                <div class="product-content-left-big-img"> 
                <img src="../image/<?php echo $product_data['product_img']; ?>" 
                                alt="<?php echo $product_data['product_name']; ?>" >
                </div>
            </div>
            <div class="product-content-right">
                <div class="product-content-right-product-name">
                    <h1><?php echo $product_data['product_name']; ?></h1>
                </div>  
                <div class="product-content-right-product-price">
                    <p class="sale-price"><?php echo number_format($product_data['product_price_new'], 0, ',', '.'); ?> <sup>đ</sup></p>
                    <p class="original-price"><?php echo number_format($product_data['product_price'], 0, ',', '.'); ?> <sup>đ</sup></p>
                    <p class="rent-price" style="color: green; font-weight: bold; display: none;">
                        Giá thuê: <span id="rentalPrice"></span> <sup>đ</sup>
                    </p>
                </div>
                <div class="product-content-right-product-size">
                <p style="color: red;">Vui lòng chọn size</p>
                    <p style="font-weight: bold;">Size</p>
                    <div class="size" name="product_size">
                        <span data-size="38" onclick="selectSize(this)">38</span>
                        <span data-size="39" onclick="selectSize(this)">39</span>
                        <span data-size="40" onclick="selectSize(this)">40</span>
                        <span data-size="41" onclick="selectSize(this)">41</span>
                        <span data-size="42" onclick="selectSize(this)">42</span>
                    </div> 
                    
                    <div class="product-content-right-product-buttom">
                    <div class="cart-content-right-button">
                    <form action="" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product_data['product_id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $product_data['product_name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $product_data['product_price']; ?>">
                        <input type="hidden" name="product_price_new" value="<?php echo $product_data['product_price_new']; ?>">
                        <input type="hidden" name="product_img" value="<?php echo $product_data['product_img']; ?>">
                        <input type="hidden" name="product_size" id="selectedSize" required>
                        <input type="hidden" id="total_price" name="total_price" value="<?php echo $product_data['product_price_new']; ?>">
                        
                        <!-- Trường này xác định hành động -->
                        <input type="hidden" id="action" name="action" value="">

                        <button onclick="setAction('buy')" 
                            <?php echo ($product_data['status_buy'] == 0) ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : ''; ?>>
                            <i class="fa-solid fa-cart-shopping"></i> Mua hàng
                        </button>
                        <?php if ($product_data['status_buy'] == 0) { ?>
                            <p style="color: red;">Sản phẩm này hiện không có sẵn để mua.</p>
                        <?php } ?>
                        <button type="submit" onclick="setAction('rent')"  class="rent-button"
                            <?php echo ($product_data['status_product'] == 0) ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : ''; ?>>
                            Thuê Ngay <span class="discount-text"> (-90%)</span>
                        </button>
                        <div id="rental-terms-container" style=" font-size: 14px; color: #333;">
                            <p style=" margin-right: 380px; cursor: pointer; font-weight: bold; color: #333;" onclick="toggleRentalTerms()">
                                ► Điều khoản thuê giày
                            </p>
                            <div id="rental-terms" style="display: none; margin-right: 100px; padding-top: 10px; background: #f8f8f8;  ">
                                <ul style=" list-style: circle;">
                                    <li>Giày phải được trả lại trong tình trạng sạch sẽ, không hư hỏng.</li>
                                    <li>Nếu giày bị mất hoặc hư hỏng nặng, bạn sẽ phải bồi thường theo giá trị sản phẩm.</li>
                                    <li>Mọi tranh chấp sẽ được giải quyết theo chính sách của VĂN PHI SPORT.</li>
                                </ul>
                            </div>
                        </div>

                        <?php if ($product_data['status_product'] == 0) { ?>
                            <p style="color: red;">Sản phẩm này hiện không có sẵn để thuê.</p>
                        <?php } ?>
                    </form>
                    <a  href="cartegory.php?cartegory_id=<?php echo $product_data['cartegory_id']; ?>&brand_id=<?php echo $product_data['brand_id']; ?>">
                    <button class="find-store-button">TÌM TẠI CỬA HÀNG</button>
                    </a>
                    </div>
                    <div class="product-content-right-product-icon">
                        <div class="product-content-right-product-icon-item">
                            <i class="fa-solid fa-phone"><p>Hotline</p></i>
                        </div>
                        <div class="product-content-right-product-icon-item">
                            <i class="fa-solid fa-comment"><p>Chat</p></i>
                        </div>
                        <div class="product-content-right-product-icon-item">
                            <i class="fa-solid fa-envelope"> Mail</i>
                        </div>
                    </div>
                    <div class="product-content-right-product-qrcode">
                        <img src="../image/QR.jpg" alt="" style="width: 100px; right: 100px;">
                    </div>
                    <div class="product-content-right-bottom">
                        
                        <div class="product-content-right-bottom-content-big ">
                            <div class="product-content-right-bottom-content-title row">
                                <div class="product-content-right-bottom-content-title-item chitiet">
                                    <p>Chi tiết</p>
                                </div>
                            </div>
                            <div class="product-content-right-bottom-content">
                                <div class="product-content-right-bottom-content-chitiet">
                                <?php echo $product_data['product_desc']; ?>
                                </div>
                            </div>
                        </div>
</section>
<!--------"product related"-->
<section class="product-related">
    <div class="product-related-title">
        <p>SẢN PHẨM LIÊN QUAN</p>
    </div>
    <div class="product-content row">
    <?php
                    if ($show_product && $show_product->num_rows > 0) {
                        while ($product = $show_product->fetch_assoc()) {
                    ?>
                        <div class="cartegory-right-content-item">
                            <a href="chitietproduct.php?product_id=<?php echo $product['product_id']; ?>">
                                <img src="../image/<?php echo $product['product_img']; ?>" alt="<?php echo $product['product_name']; ?>">
                            </a>
                            <h1><?php echo $product['product_name']; ?></h1>
                            
                            <p class="sale-price"><?php echo number_format($product['product_price_new'], 0, ',', '.'); ?> <sup>đ</sup></p>
                            <p class="original-price"><?php echo number_format($product['product_price'], 0, ',', '.'); ?> <sup>đ</sup></p>
                        </div>
                    <?php
                        }
                    } else {
                        echo "<p>Không có sản phẩm nào phù hợp.</p>";
                    }
                    ?>
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
<script src="../js/script.js"> </script>
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

        function selectSize(element) {
            // Xóa class 'selected' ở tất cả các size trước đó
            document.querySelectorAll(".size span").forEach(span => span.classList.remove("selected"));

            // Thêm class 'selected' vào size được chọn
            element.classList.add("selected");

            // Cập nhật giá trị vào input hidden
            document.getElementById("selectedSize").value = element.getAttribute("data-size");

            console.log("Size đã chọn:", document.getElementById("selectedSize").value); // Kiểm tra trên console
        }


    function setAction(action) {
        document.getElementById('action').value = action;
        document.forms[0].action = (action === 'buy') ? 'cart.php' : 'rental_process.php';
    }
</script>
</html>