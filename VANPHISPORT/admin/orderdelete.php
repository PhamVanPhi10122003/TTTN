<?php
include "../admin/class/address_class.php";

$Address = new Address;

if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] == 1) {
    $id = $_GET['id'];
    $delete_address = $Address->delete_address($id);
    echo "<script>alert('Xóa đơn hàng thành công!'); window.location.href = 'orderlist.php';</script>";
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
?>
    <script>
        if (confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')) {
            window.location.href = 'orderdelete.php?confirm_delete=1&id=<?php echo $id; ?>';
        } else {
            window.location.href = 'orderlist.php';
        }
    </script>
<?php
}
?>
