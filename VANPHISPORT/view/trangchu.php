<?php
session_start();
require_once "../admin/class/cartegory_class.php";
require_once "../admin/class/brand_class.php";
require_once "../admin/class/user_class.php";
?>
<?php
$cartegory = new cartegory;
$show_cartegory = $cartegory->show_cartegory();
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VANPHI SPORT</title>
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
<section id="Slider">
    <div class="aspect-ratio-169">
        <img src="../image/b1.jpg">
        <img src="../image/b2.jpg">
        <img src="../image/b3.jpg">
        <img src="../image/b5.jpg">
        <img src="../image/b4.jpg">
    </div>
    <div class="dot-container">
        <div class="dot active"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>

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
<script src="../js/script.js"></script>
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