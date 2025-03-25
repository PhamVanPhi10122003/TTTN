<?php
include "class/rental_class.php";

$rental = new Rental;

if (isset($_GET['rental_id'])) {
    $id_rental = $_GET['rental_id'];

    echo "<script>
        var confirmDelete = confirm('Bạn có chắc chắn muốn xóa mục này không?');
        if (confirmDelete) {
            window.location.href = 'rentaldelete.php?confirm_delete=1&rental_id=$rental_id';
        } else {
            window.location.href = 'rentallist.php'; // Hoặc trang danh sách
        }
    </script>";
}

if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] == 1) {
    $rental_id = $_GET['rental_id'];
    $delete_rental = $rental->delete_rental($rental_id);
    echo "<script>alert('Xóa thành công!'); window.location.href = 'rentallist.php';</script>";
}
?>
