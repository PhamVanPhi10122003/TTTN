<?php
session_start();
require_once "../config/database.php"; // Kết nối CSDL
$db = new Database();

header("Content-Type: application/json");

// Kiểm tra nếu người dùng chưa đăng nhập 
if (!isset($_SESSION["id_user"]) || !isset($_SESSION["username"])) {
    echo json_encode(["status" => "error", "message" => "Bạn chưa đăng nhập!"]);
    exit();
}

$id_user = $_SESSION["id_user"];
$username = $_SESSION["username"];

// Kiểm tra nếu request là POST và có dữ liệu tin nhắn
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message"])) {
    $message = trim($_POST["message"]);

    if (!empty($message)) {
        // Lưu tin nhắn của người dùng vào CSDL
        $stmt = $db->prepare("INSERT INTO messages (id_user, username, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id_user, $username, $message);
        $stmt->execute();
        $stmt->close();

        // Danh sách câu trả lời tự động
        $auto_replies = [
            "chào" => "Xin chào! Văn Phi Sport có thể giúp gì cho bạn?",
            "giày" => "Chúng tôi có nhiều loại giày thể thao, bạn cần loại nào ạ?",
            "áo" => "Chúng tôi có các mẫu áo thể thao đẹp, bạn cần tư vấn không?",
            "giảm giá" => "Hiện tại shop đang có chương trình khuyến mãi, bạn có thể xem chi tiết trên trang chủ!",
            "cảm ơn" => "Không có gì đâu ạ! Văn Phi Sport luôn sẵn sàng hỗ trợ bạn!",
        ];

        // Kiểm tra xem tin nhắn có cần phản hồi tự động không
        foreach ($auto_replies as $key => $response) {
            if (stripos($message, $key) !== false) {
                // Kiểm tra xem tin nhắn phản hồi đã tồn tại chưa để tránh trùng lặp
                $check_stmt = $db->prepare("SELECT COUNT(*) FROM messages WHERE id_user = ? AND message = ?");
                $check_stmt->bind_param("is", $id_user, $response);
                $check_stmt->execute();
                $check_stmt->bind_result($count);
                $check_stmt->fetch();
                $check_stmt->close();

                if ($count == 0) { // Chỉ thêm nếu chưa có phản hồi này trước đó
                    $stmt = $db->prepare("INSERT INTO messages (id_user, username, message) VALUES (?, 'Admin', ?)");
                    $stmt->bind_param("is", $id_user, $response);
                    $stmt->execute();
                    $stmt->close();
                }
                break;
            }
        }

        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Vui lòng nhập nội dung tin nhắn!"]);
    }
}
?>
