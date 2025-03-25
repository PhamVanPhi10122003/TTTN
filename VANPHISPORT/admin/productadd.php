<?php
include "header.php";
include "slider.php";
include "../admin/class/product_class.php";

$product = new Product;
$show_cartegory = $product->show_cartegory();
$show_brand = $product->show_brand();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $cartegory_id = $_POST['cartegory_id'];
    $brand_id = $_POST['brand_id'];
    $product_price = $_POST['product_price'];
    $product_price_new = $_POST['product_price_new'];
    $product_sold = $_POST['product_sold'];
    $product_desc = $_POST['product_desc'];

    // Xử lý ảnh tải lên
    $product_img = $_FILES['product_img']['name'];
    $product_img_tmp = $_FILES['product_img']['tmp_name'];

    $upload_dir = __DIR__ . "/uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $target_file = $upload_dir . basename($product_img);
    move_uploaded_file($product_img_tmp, $target_file);

    $insert_product = $product->insert_product($product_name, $cartegory_id, $brand_id, $product_price, $product_price_new, $product_desc, $product_img,$product_sold);
}
?>

<div class="admin-content-right">
    <div class="box">
        <h1>Thêm Sản Phẩm</h1>
        <form action="" method="post" enctype="multipart/form-data" class="form-group">
            <label for="product_name">Tên sản phẩm</label>
            <input required name="product_name" id="product_name" type="text" placeholder="Nhập tên sản phẩm">
            
            <label for="cartegory_id">Danh mục</label>
            <select required name="cartegory_id" id="cartegory_id">
                <option value="">Chọn danh mục</option>
                <?php while ($row = $show_cartegory->fetch_assoc()) { ?>
                    <option value="<?php echo $row['cartegory_id']; ?>"> <?php echo $row['cartegory_name']; ?> </option>
                <?php } ?>
            </select>

            <label for="brand_id">Thương hiệu</label>
            <select required name="brand_id" id="brand_id">
                <option value="">Chọn thương hiệu</option>
                <?php while ($row = $show_brand->fetch_assoc()) { ?>
                    <option value="<?php echo $row['brand_id']; ?>"> <?php echo $row['brand_name']; ?> </option>
                <?php } ?>
            </select>

            <label for="product_price">Giá gốc</label>
            <input required name="product_price" id="product_price" type="number" placeholder="Giá gốc">

            <label for="product_price_new">Giá khuyến mãi</label>
            <input required name="product_price_new" id="product_price_new" type="number" placeholder="Giá khuyến mãi">

            <label for="product_sold">Đã bán</label>
            <input required name="product_sold" id="product_sold" type="number" placeholder="Đã bán">


            <label for="product_desc">Mô tả sản phẩm</label>
            <textarea required name="product_desc" id="product_desc" placeholder="Mô tả sản phẩm"></textarea>

            <label for="product_img">Ảnh sản phẩm</label>
            <input required name="product_img" id="product_img" type="file">

            <button type="submit">Thêm</button>
        </form>
    </div>
</div>
