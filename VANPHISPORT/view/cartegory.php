<?php
session_start();
require_once "../admin/class/cartegory_class.php";
require_once "../admin/class/product_class.php";
?>

<?php
$cartegory = new cartegory;
$show_cartegory = $cartegory->show_cartegory();  // Lấy danh mục từ cơ sở dữ liệu


// Kiểm tra nếu không có danh mục nào được trả về
if (!$show_cartegory) {
    // Xử lý khi không có danh mục nào được tìm thấy
    $error_message = "Không tìm thấy danh mục.";
}

$product = new product();
// Lấy category_id và brand_id từ URL
$cartegory_id = isset($_GET['cartegory_id']) ? intval($_GET['cartegory_id']) : 0;
$brand_id = isset($_GET['brand_id']) ? intval($_GET['brand_id']) : 0;

$order = "ASC"; // Mặc định sắp xếp từ thấp đến cao

if (isset($_GET['sort']) && $_GET['sort'] == "desc") {
    $order = "DESC"; // Nếu chọn "Giá cao đến thấp" thì sắp xếp giảm dần
}

// Lọc sản phẩm theo category_id và brand_id, đồng thời sắp xếp theo giá
if ($cartegory_id > 0 && $brand_id > 0) {
    $query_product = "SELECT * FROM tbl_product WHERE cartegory_id = '$cartegory_id' AND brand_id = '$brand_id' ORDER BY product_price_new $order";
} else {
    $query_product = "SELECT * FROM tbl_product WHERE cartegory_id = '$cartegory_id' ORDER BY product_price_new $order";
}

$show_product = $product->getDb()->select($query_product);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VANPHI STORE</title>
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
<!--------------Cartegory---------------->
<section class="cartegory">
<div class="container">
    <div class="cartegory-top">
        <p>Trang chủ</p> <span>&#10230;</span> 
        <p>
            <?php
            if (isset($_GET['cartegory_id']) && $_GET['cartegory_id'] > 0) {
                $cartegory_id = intval($_GET['cartegory_id']);
                
                // Lấy tên danh mục từ database
                $query_category = "SELECT cartegory_name FROM tbl_cartegory WHERE cartegory_id = '$cartegory_id'";
                $result_category = $product->getDb()->select($query_category);
                
                if ($result_category && $row_category = $result_category->fetch_assoc()) {
                    echo $row_category['cartegory_name']; // Hiển thị tên danh mục
                } else {
                    echo "Danh mục không tồn tại";
                }
            } else {
                echo "Tất cả danh mục";
            }
            ?>
        </p> 
        <span>&#10230;</span> 
        <p>
            <?php
            if (isset($_GET['brand_id']) && $_GET['brand_id'] > 0) {
                $brand_id = intval($_GET['brand_id']);
                
                // Lấy tên thương hiệu từ database
                $query_brand = "SELECT brand_name FROM tbl_brand WHERE brand_id = '$brand_id'";
                $result_brand = $product->getDb()->select($query_brand);
                
                if ($result_brand && $row_brand = $result_brand->fetch_assoc()) {
                    echo $row_brand['brand_name']; // Hiển thị tên thương hiệu
                } else {
                    echo "Thương hiệu không tồn tại";
                }
            } else {
                echo "Tất cả sản phẩm";
            }
            ?>
        </p>
    </div> 
</div>
    <div class="container">
        <div class="row">
            <div class="cartegory-left">
                <ul>
                    <?php
                    // Kiểm tra nếu có danh mục
                    if (isset($show_cartegory) && $show_cartegory) {
                        while ($result = $show_cartegory->fetch_assoc()) {
                            $cartegory_id = $result['cartegory_id'];
                    ?>
                        <li class="cartegory-left-li">
                            <a href="#"><?php echo $result['cartegory_name']; ?></a>
                            <ul>
                                <?php
                                // Hiển thị các sản phẩm con (sub-category) nếu có
                                if ($show_sub_category) {
                                    while ($sub_result = $show_sub_category->fetch_assoc()) {
                                ?>
                                    <li><a href="#"><?php echo $sub_result['brand_name']; ?></a></li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                    <?php
                        }
                    } else {
                        // Thông báo nếu không có danh mục
                        echo "<li>Không có danh mục nào.</li>";
                    }
                    ?>
                </ul>
            </div>
            <div class="cartegory-right row">
                <div class="cartegory-right-top-item">
                <?php
                    if (isset($_GET['brand_id']) && $_GET['brand_id'] > 0) {
                        $brand_id = intval($_GET['brand_id']);
                        
                        // Lấy tên thương hiệu từ database
                        $query_brand = "SELECT brand_name FROM tbl_brand WHERE brand_id = '$brand_id'";
                        $result_brand = $product->getDb()->select($query_brand);
                        
                        if ($result_brand && $row_brand = $result_brand->fetch_assoc()) {
                            echo $row_brand['brand_name']; // Hiển thị tên thương hiệu
                        } else {
                            echo "Thương hiệu không tồn tại";
                        }
                    } else {
                        echo "Tất cả sản phẩm";
                    }
                ?>
                </div>
                <div class="cartegory-right-top-item">
                    <select name="sort" id="sort" onchange="location = this.value;">
                    <option value="?cartegory_id=<?php echo $cartegory_id; ?>&brand_id=<?php echo $brand_id; ?>">Sắp xếp</option>
                    <option value="?cartegory_id=<?php echo $cartegory_id; ?>&brand_id=<?php echo $brand_id; ?>&sort=desc"
                    <?php if(isset($_GET['sort']) && $_GET['sort'] == 'desc') echo 'selected'; ?>>Giá cao đến thấp</option>
                    <option value="?cartegory_id=<?php echo $cartegory_id; ?>&brand_id=<?php echo $brand_id; ?>&sort=asc"
                    <?php if(isset($_GET['sort']) && $_GET['sort'] == 'asc') echo 'selected'; ?>>Giá thấp đến cao</option>
                    </select>
                </div>
                <div class="cartegory-right-content row">
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
                            <p class="product-sold">Đã bán: <?php echo $product['product_sold']; ?> sản phẩm</p>
                        </div>
                    <?php
                        }
                    } else {
                        echo "<p>Không có sản phẩm nào phù hợp.</p>";
                    }
                    ?>
                </div>
            <div class="cartegory-right-bottom row">
                <div class="cartegory-right-bottom-item">
                    <p>Hiển thị 2 <span>|</span> 4 sản phẩm</p>
                </div>
                <div class="cartegory-right-bottom-item">
                    <p><span>&#171;</span>1 2 3 4 5 <span>&#187;</span> Trang cuối</p>
                </div>
            </div>
            </div>
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
    Địa chỉ đăng ký : Tam Thăng , Tam Kì , Quảng Nam  <br>
    Đặt hàng online : <b>0626 232 4341</b>
</p>
</div>
<script src="../js/script.js"> </script>

</body>

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
