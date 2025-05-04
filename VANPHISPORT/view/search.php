<?php
require_once "../admin/class/product_class.php";
$product = new Product();
$query = isset($_GET['q']) ? $_GET['q'] : '';

if (!empty($query)) {
    $result = $product->searchProduct($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            echo "<div><a href='chitietproduct.php?product_id=" . $row['product_id'] . "'>" . $row['product_name'] . "</a></div>";
        }
    } else {
        echo "<div>Không tìm thấy sản phẩm</div>";
    }
}
?>