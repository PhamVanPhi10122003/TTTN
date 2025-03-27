<?php
include "header.php";
include "slider.php";
require_once(__DIR__ . '/class/cartegory_class.php');
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != '0') {
    header("Location: ../view/login.php");
    exit();
}
$cartegory = new Cartegory();

if (isset($_GET['cartegory_id'])) {
    $cartegory_id = $_GET['cartegory_id'];
    $cartegory_data = $cartegory->get_cartegory($cartegory_id);
    if ($cartegory_data) {
        $cartegory_info = $cartegory_data->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cartegory_name = $_POST['cartegory_name'];
    $update_result = $cartegory->update_cartegory($cartegory_id, $cartegory_name);
    if ($update_result) {
        echo "<script>alert('Cập nhật thành công!'); window.location='cartegorylist.php';</script>";
    } else {
        echo "<script>alert('Cập nhật thất bại!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa danh mục</title>
</head>
<body>
<div class="admin-content-right">
<div class="admin-content-right-product_edit">
    <h1>Chỉnh sửa danh mục</h1>
    <form action="" method="POST">
        <label for="cartegory_name">Tên danh mục:</label>
        <input type="text" id="cartegory_name" name="cartegory_name" value="<?php echo $cartegory_info['cartegory_name']; ?>" required>
        <button type="submit">Cập nhật</button>
    </form>
    </div>
</div>
</body>
</html>
