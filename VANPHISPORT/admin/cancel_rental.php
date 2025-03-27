<?php
session_start();
require_once "../admin/class/rental_class.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["rental_id"])) {
    $rental_id = $_POST["rental_id"];

    $rental = new Rental();
    $result = $rental->cancel_rental($rental_id);

    if ($result) {
        // Quay lại trang lịch sử sau khi hủy thành công
        header("Location: ../view/rental_history.php?success=Hủy thành công");
    } else {
        header("Location: ../view/rental_history.php?error=Không thể hủy đơn");
    }
} else {
    header("Location: ../view/rental_history.php");
}
exit();
?>
