<?php
include "header.php";
include "slider.php";
include "class/product_class.php";

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != '0') {
    header("Location: ../view/login.php");
    exit();
}
$product = new product;

if (!isset($_GET['product_id']) || $_GET['product_id'] == NULL) {
    echo "<script>window.location = 'productlist.php';</script>";
} else {
    $product_id = $_GET['product_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_price_new = $_POST['product_price_new'];
    $product_desc = $_POST['product_desc'];
    $status_product = $_POST['status_product'];
    $product_sold = $_POST['product_sold'];
    $status_buy = $_POST['status_buy'];
    
    $updateProduct = $product->update_product($product_id, $product_name, $product_price, $product_price_new, $product_desc, $status_product, $product_sold,$status_buy);
}

$get_product = $product->get_product_by_id($product_id);
if ($get_product) {
    $result = $get_product->fetch_assoc();
}
?>

<div class="admin-content-right">
    <div class="admin-content-right-product_edit">
        <h1>Chỉnh sửa sản phẩm</h1>
        <form action="" method="POST">
            <label for="product_name">Tên sản phẩm</label> <br>
            <input type="text" name="product_name" value="<?php echo $result['product_name']; ?>" required> 
            <br>
            <label for="product_price">Giá sản phẩm </label>   <br>
            <input type="text" name="product_price" value="<?php echo number_format($result['product_price'], 0, ',', '.'); ?> " required> 
            <br>
            <label for="product_price_new">Giá sản phẩm mới</label> 
            <input type="text" name="product_price_new" value="<?php echo number_format($result['product_price_new'], 0, ',', '.'); ?>">
            <br>
            <label for="product_desc">Mô tả sản phẩm</label>
            <textarea name="product_desc" required><?php echo $result['product_desc']; ?></textarea>
            
            <label for="status_product">Trạng thái thuê</label>
            <select name="status_product">
                <option value="1" <?php if ($result['status_product'] == 1) echo "selected"; ?>>Còn hàng thuê</option>
                <option value="0" <?php if ($result['status_product'] == 0) echo "selected"; ?>>Hết hàng thuê</option>
            </select>
            <label for="status_product">Trạng thái bán</label>
            <select name="status_buy">
                <option value="1" <?php if ($result['status_buy'] == 1) echo "selected"; ?>>Còn hàng bán</option>
                <option value="0" <?php if ($result['status_buy'] == 0) echo "selected"; ?>>Hết hàng bán</option>
            </select>
            
            <label for="product_sold">Số lượng đã bán</label>
            <input type="text" name="product_sold" value="<?php echo $result['product_sold']; ?>">
            
            <button type="submit">Cập nhật</button>
        </form>
    </div>
</div>