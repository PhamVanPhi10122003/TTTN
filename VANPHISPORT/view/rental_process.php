<?php
session_start();
require_once "../admin/class/cartegory_class.php";
require_once "../admin/class/product_class.php";
require_once "../admin/class/cart_class.php";
require_once "../admin/class/rental_class.php";
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


// Xử lý yêu cầu thuê sản phẩm chỉ khi có dữ liệu POST
$rental = new Rental();
$result = null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {
    $result = $rental->insert_rental();
}

// Kiểm tra kết quả và hiển thị thông báo bằng JavaScript
if ($result === true) {
    echo "<script>alert('Thuê sản phẩm thành công!'); window.location.href = 'rental_history.php';</script>";
} elseif (!is_null($result)) {
    echo "<script>alert('$result');</script>";
}

if ($result === true) {
    header("Location: payment.php");
    exit();
}




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
    <!-- Modal điều khoản -->
<div id="rentalTermsModal" class="modal">
    <div class="modal-content">
        <h2>Điều khoản thuê sản phẩm</h2>
        <p>Khi thuê sản phẩm, quý khách cam kết:</p>
        <ul>
            <li>Trả sản phẩm đúng thời hạn.</li>
            <li>Giữ gìn sản phẩm trong tình trạng tốt.</li>
            <li>Chịu trách nhiệm nếu có hư hỏng hoặc mất mát.</li>
        </ul>
        <p>Bấm "Đồng ý" để tiếp tục thuê.</p>
        <button onclick="agreeToRent()">Đồng ý</button>
        <button onclick="closeModal()">Hủy</button>
    </div>
</div>
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
        <?php if (isset($_SESSION["id_user"])) { ?>
        <li><a href="logout.php">Đăng xuất</a></li>
        <?php } else { ?>
        <li><a href="login.php">Đăng nhập</a></li>
        <?php } ?>
        </div>

    </header>
</section>
<section class="rental-form">
    <h1>Thuê Sản Phẩm</h1>
    <form id="rentalForm" action="rental_process.php" method="POST">
    <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
    <input type="hidden" name="product_id" value="<?php echo $product_data['product_id']; ?>">
    <input type="hidden" name="product_price_new" value="<?php echo $product_data['product_price_new']; ?>">
    <input type="hidden" name="product_img" value="<?php echo $product_data['product_img']; ?>">
    <input type="hidden" name="product_price" value="<?php echo $product_data['product_price']; ?>">

    <label>Tên sản phẩm:</label>
    <input type="text" name="product_name" value="<?php echo $product_data['product_name']; ?>" readonly>

    <label>Size giày:</label>
    <input type="text" name="product_size" value="<?php echo !empty($product_data['product_size']) ? $product_data['product_size'] : 'Chưa chọn'; ?>" readonly>
    
    <label>Giá thuê/ngày:</label>
    <input type="text" name="rental_price" value="<?php echo number_format($product_data['product_price_new'] / 10, 0, ',', '.'); ?> đ" readonly>
    
    <label>Thời gian thuê (ngày):</label>
    <input type="number" name="rental_days" min="1" required>
    
    <label>Tổng tiền thuê:</label>
    <input type="text" id="total_price" readonly>
    
    <label>Ngày bắt đầu thuê:</label>
    <input type="date" name="rental_start" required>
    
    <label>Ghi chú:</label>
    <textarea name="notes" placeholder="Ghi chú thêm (nếu có)"></textarea>
    
    <!-- Khi bấm vào nút này, modal mới hiển thị -->
    <button type="button" onclick="openModal()" class="rent-button">Thuê Ngay</button>
</form>
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
</body>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let pricePerDay = <?php echo $product_data['product_price_new'] / 10; ?>;
    let rentalDaysInput = document.querySelector('input[name="rental_days"]');
    let totalPriceInput = document.getElementById("total_price");

    rentalDaysInput.addEventListener("input", function () {
        let days = parseInt(rentalDaysInput.value) || 0;
        totalPriceInput.value = (pricePerDay * days).toLocaleString("vi-VN") + " đ";
    });

    // Ẩn modal ngay từ đầu
    document.getElementById("rentalTermsModal").style.display = "none";
});

function openModal() {
    document.getElementById("rentalTermsModal").style.display = "block";
}

function closeModal() {
    document.getElementById("rentalTermsModal").style.display = "none";
}

function agreeToRent() {
    document.getElementById("rentalTermsModal").style.display = "none"; // Đóng modal
    document.getElementById("rentalForm").submit(); // Gửi form
}
</script>

</html> 