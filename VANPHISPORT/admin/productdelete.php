<?php
include "class/product_class.php";

$product = new Product;

if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] == 1) {
    $product_id = $_GET['product_id'];
    $delete_product = $product->delete_product($product_id);
    echo "<script>alert('Xóa sản phẩm thành công!'); window.location.href = 'productlist.php';</script>";
    exit();
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
?>
    <script>
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) {
            window.location.href = 'productdelete.php?confirm_delete=1&product_id=<?php echo $product_id; ?>';
        } else {
            window.location.href = 'productlist.php';
        }
    </script>
<?php
}
?>
