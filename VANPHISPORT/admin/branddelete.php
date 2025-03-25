<?php
include "class/brand_class.php";

$brand = new Brand;

if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] == 1) {
    $brand_id = $_GET['brand_id'];
    $delete_brand = $brand->delete_brand($brand_id);
    echo "<script>alert('Xóa thương hiệu thành công!'); window.location.href = 'brandlist.php';</script>";
    exit();
}

if (isset($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];
?>
    <script>
        if (confirm('Bạn có chắc chắn muốn xóa thương hiệu này không?')) {
            window.location.href = 'branddelete.php?confirm_delete=1&brand_id=<?php echo $brand_id; ?>';
        } else {
            window.location.href = 'brandlist.php';
        }
    </script>
<?php
}
?>