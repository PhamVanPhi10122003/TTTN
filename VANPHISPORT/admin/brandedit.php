<?php
include "header.php";
include "slider.php";
require_once(__DIR__ . '/class/brand_class.php');

$brand = new Brand();

if (isset($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];
    $brand_data = $brand->get_brand($brand_id);
    if ($brand_data) {
        $brand_info = $brand_data->fetch_assoc();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $brand_name = $_POST['brand_name'];
    $update_result = $brand->update_brand($brand_id, $brand_name);
    if ($update_result) {
        echo "<script>alert('Cập nhật thành công!'); window.location='brandlist.php';</script>";
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
    <title>Chỉnh sửa thương hiệu</title>
</head>
<body>
<div class="admin-content-right">
<div class="admin-content-right-product_edit">
    <h1>Chỉnh sửa thương hiệu</h1>
    <form action="" method="POST">
        <label for="brand_name">Tên thương hiệu:</label>
        <input type="text" id="brand_name" name="brand_name" value="<?php echo $brand_info['brand_name']; ?>" required>
        <button type="submit">Cập nhật</button>
    </form>
    </div>
</div>
</body>
</html>
