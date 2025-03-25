<?php
require_once(__DIR__ . "/../config/database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rental_id = $_POST["rental_id"];
    $status_rental = $_POST["status_rental"];

    // Kết nối database
    $db = new Database();
    
    // Cập nhật trạng thái đơn thuê
    $query = "UPDATE tbl_rental SET status_rental = '$status_rental' WHERE rental_id = '$rental_id'";
    $db->update($query);

    // Quay lại trang danh sách sau khi cập nhật
    header("Location: rentallist.php");
    exit();
}
?>
