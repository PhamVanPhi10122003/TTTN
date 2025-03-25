<?php
require_once "../config/database.php"; // Kết nối database
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message_id"]) && isset($_POST["reply"])) {
    $message_id = $_POST["message_id"];
    $reply = trim($_POST["reply"]);

    if (!empty($reply)) {
        $stmt = $db->prepare("UPDATE messages SET reply = ? WHERE id = ?");
        $stmt->bind_param("si", $reply, $message_id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Không thể gửi phản hồi"]);
        }
        $stmt->close();
    }
}
?>
