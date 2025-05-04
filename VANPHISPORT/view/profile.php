<?php
session_start();
require_once "../admin/class/user_class.php";
require_once "../admin/class/cartegory_class.php";

// Kiểm tra đăng nhập
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$user = new user();
$current_user = $user->get_user_by_id($_SESSION['id_user']);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $new_username = trim($_POST['username']);
    $new_lastname = trim($_POST['lastname']);

    // Kiểm tra nếu có sự thay đổi
    if ($new_username !== $current_user['username'] || $new_lastname !== $current_user['lastname']) {
        $update_info = $user->update_user_info($_SESSION['id_user'], $new_username, $new_lastname);
        if ($update_info) {
            echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href = 'profile.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi cập nhật thông tin.');</script>";
        }
    }
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $file = $_FILES['avatar'];
        
        // Kiểm tra định dạng file
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($imageFileType, $allowed_types)) {
            echo "<script>alert('Chỉ chấp nhận file JPG, PNG, JPEG, GIF.');</script>";
        } else {
            // Đổi tên file để tránh trùng lặp
            $file_name = time() . "_" . basename($file['name']);
            $target_dir = "../image/";
            $target_file = $target_dir . $file_name;

            // Kiểm tra dung lượng file (tối đa 2MB)
            if ($file["size"] > 2 * 1024 * 1024) {
                echo "<script>alert('Ảnh quá lớn, vui lòng chọn ảnh dưới 2MB.');</script>";
            } else {
                // Di chuyển file vào thư mục lưu trữ
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    // Cập nhật avatar vào database
                    $update = $user->update_avatar($_SESSION['id_user'], $file_name);
                    if ($update) {
                        echo "<script>alert('Cập nhật ảnh đại diện thành công!'); window.location.href = 'profile.php';</script>";
                    } else {
                        echo "<script>alert('Lỗi khi cập nhật ảnh vào database.');</script>";
                    }
                } else {
                    echo "<script>alert('Lỗi khi di chuyển file.');</script>";
                }
            }
        }
    } else {
        echo "<script>alert('Vui lòng chọn ảnh hợp lệ.');</script>";
    }
}

$cartegory = new cartegory;
$show_cartegory = $cartegory->show_cartegory();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Của Tôi</title>
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
        <li><input id="searchInput" placeholder="Tìm kiếm sản phẩm..." type="text" onkeyup="searchProduct()"><i class="fas fa-search"></i></li> 
        <div id="searchResults"></div>
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
<!-- Profile Container -->
<div class="profile-container">
    <div class="sidebar">
    <div class="profile-pic">
    <?php 
    $avatar = !empty($current_user['avatar']) ? $current_user['avatar'] : 'default.jpg';
    ?>
    <img id="avatar" src="../image/<?php echo htmlspecialchars($avatar) . "?t=" . time(); ?>" alt="Ảnh đại diện">
    </div>

        <ul>
            <li class="active">Hồ Sơ</li>
        </ul>
    </div>

    <!-- Profile Info -->
    <div class="profile-info">
        <h2>Hồ Sơ Của Tôi</h2>
        <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
        <form action="profile.php" method="POST" enctype="multipart/form-data">
            <label>Tên đăng nhập</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($current_user['username']); ?>">

            <label>Họ & Tên</label>
            <input type="text" name="lastname" value="<?php echo htmlspecialchars($current_user['lastname']); ?>">

            <label>Email</label>
            <input type="email" value="<?php echo htmlspecialchars($current_user['email']); ?>" disabled>

            <label>Số điện thoại</label>
            <input type="text" value="<?php echo htmlspecialchars($current_user['PhoneNumber']); ?>" disabled>
  
            <label>Chọn ảnh đại diện mới</label>
            <input type="file" name="avatar" accept="image/*" required>
            <button type="submit" name="submit">Cập nhật</button>   
        </form>
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
        <textarea id="message" placeholder="Nhập tin nhắn..." onkeypress="handleKeyPress(event)"></textarea>
        <button onclick="sendMessage()">Gửi</button>
    </div>
</div>
<script src="../js/admin.js"> </script>
<script src="../js/script.js"> </script>
</body>
</html>