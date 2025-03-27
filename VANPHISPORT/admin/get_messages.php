<?php
require_once "../config/database.php"; // Kết nối database
$db = new Database();

// Lấy tất cả tin nhắn của khách hàng kèm phản hồi từ Admin
$result = $db->select("SELECT username, message, reply FROM messages ORDER BY created_at ASC");

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

header("Content-Type: application/json");
echo json_encode($messages);
?>
