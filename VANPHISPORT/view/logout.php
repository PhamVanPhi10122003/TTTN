<?php
session_start();
require_once "../config/database.php"; // Kết nối database
$db = new Database();

if (isset($_SESSION["id_user"])) {
    $id_user = $_SESSION["id_user"];

    // Xóa tin nhắn của user này khỏi CSDL
    $stmt = $db->prepare("DELETE FROM messages WHERE id_user = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->close();
}

// Hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: login.php");
exit();
?>
