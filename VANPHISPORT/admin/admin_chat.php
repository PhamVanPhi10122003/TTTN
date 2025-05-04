<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != '0') {
    header("Location: ../view/login.php");
    exit();
}
require_once "../config/database.php"; // Kết nối database
$db = new Database();
$messages = $db->select("SELECT * FROM messages ORDER BY created_at DESC");

// Xử lý phản hồi từ Admin
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message_id"]) && isset($_POST["reply"])) {
    $message_id = $_POST["message_id"];
    $reply = trim($_POST["reply"]);

    if (!empty($reply)) {

        $stmt = $db->prepare("UPDATE messages SET reply = ? WHERE id = ?");
        $stmt->bind_param("si", $reply, $message_id);
        if ($stmt->execute()) {
            echo "<script>
            alert('Phản hồi đã được gửi!');
            window.location.href = window.location.pathname; // Chỉ load lại trang, không bị lặp
        </script>";        
        } else {
            echo "<script>alert('Lỗi khi gửi phản hồi!');</script>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Tin Nhắn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Danh sách tin nhắn</h1>
    <table border="1">
        <tr>
            <th>Username</th>
            <th>Tin nhắn</th>
            <th>Thời gian</th>
            <th>Phản hồi</th>
            <th>Hành động</th>
        </tr>
        <?php if ($messages) {
            while ($row = $messages->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["username"]); ?></td>
                    <td><?php echo htmlspecialchars($row["message"]); ?></td>
                    <td><?php echo $row["created_at"]; ?></td>
                    <td><?php echo !empty($row["reply"]) ? htmlspecialchars($row["reply"]) : "<i>Chưa có phản hồi</i>"; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="message_id" value="<?php echo $row["id"]; ?>">
                            <input type="text" name="reply" placeholder="Nhập phản hồi..." required>
                            <button type="submit">Gửi</button>
                        </form>
                    </td>
                </tr>
            <?php }
        } ?>
    </table>
</body>
</html>
