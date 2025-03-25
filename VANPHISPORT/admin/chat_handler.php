<?php
require_once "../config/database.php"; // Kết nối CSDL
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $message = $_POST["message"];

    if (!empty($username) && !empty($message)) {
        $stmt = $db->prepare("INSERT INTO messages (username, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $message);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Lỗi khi gửi tin nhắn!"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Vui lòng nhập đủ thông tin!"]);
    }
}
?>
