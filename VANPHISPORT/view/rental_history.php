<?php
session_start();
require_once "../admin/class/cartegory_class.php";
require_once "../admin/class/rental_class.php";

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION["id_user"])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION["id_user"];
$rental = new Rental();
$history = $rental->get_rental($id_user);

$cartegory = new cartegory;
$show_cartegory = $cartegory->show_cartegory();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VANPHI SPORT - Lịch Sử Thuê</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<header>
    <div class="logo">
        <a href="trangchu.php"><img src="../image/1-removebg-preview.png" style="width: 100px;"></a>
    </div>
    <div class="menu">
        <?php if ($show_cartegory) { while ($result = $show_cartegory->fetch_assoc()) { ?>
            <li>
                <a href="#"><?php echo $result['cartegory_name']; ?></a>
                <ul class="sub-menu">
                    <?php
                    $query_sub_category = "SELECT * FROM tbl_brand WHERE cartegory_id = '{$result['cartegory_id']}'";
                    $show_sub_category = $cartegory->getDb()->select($query_sub_category);
                    if ($show_sub_category) {
                        while ($sub_result = $show_sub_category->fetch_assoc()) { ?>
                            <li>
                                <a href="cartegory.php?cartegory_id=<?php echo $result['cartegory_id']; ?>&brand_id=<?php echo $sub_result['brand_id']; ?>">
                                    <?php echo $sub_result['brand_name']; ?>
                                </a>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </li>
        <?php } } ?>
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

<section class="rental-history">
    <h2>Lịch Sử Thuê Sản Phẩm</h2>
    <table>
        <tr>
            <th>Mã Thuê</th>
            <th>Sản Phẩm</th>
            <th>Size</th>
            <th>Giá Thuê</th>
            <th>Ngày Bắt Đầu</th>
            <th>Số Ngày</th>
            <th>Tổng Tiền</th>
            <th>Trạng Thái</th>
            <th>Hành Động</th>
        </tr>
        <?php if ($history && $history->num_rows > 0) { 
            while ($row = $history->fetch_assoc()) { 
                // Xử lý class trạng thái
                $statusClass = strtolower(str_replace(' ', '-', $row['status_rental']));
        ?>
                <tr>
                    <td><?php echo $row['rental_id']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['product_size']; ?></td>
                    <td><?php echo number_format($row['rental_price'], 0, ',', '.'); ?> đ/ngày</td>
                    <td><?php echo date('d/m/Y', strtotime($row['rental_start'])); ?></td>
                    <td><?php echo $row['rental_days']; ?></td>
                    <td><?php echo number_format($row['total_price'], 0, ',', '.'); ?> đ</td>
                    <td class="status-<?php echo $statusClass; ?>"><?php echo $row['status_rental']; ?></td>
                    <td>
                        <?php if ($row['status_rental'] == "Chờ xác nhận") { ?>
                            <form action="../admin/cancel_rental.php" method="POST">
                                <input type="hidden" name="rental_id" value="<?php echo $row['rental_id']; ?>">
                                <button type="submit" class="cancel-btn" onclick="return confirm('Bạn có chắc muốn hủy đơn này?')">Hủy</button>
                            </form>
                        <?php } else { echo "Không thể hủy"; } ?>
                    </td>
                </tr>
        <?php } } else { ?>
            <tr><td colspan="9">Không có đơn thuê nào.</td></tr>
        <?php } ?>
    </table>
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
</section>
</body>
</html>
