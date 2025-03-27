<?php
include "header.php";
include "slider.php";
include "class/user_class.php";

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != '0') {
    header("Location: ../view/login.php");
    exit();
}
// Khởi tạo đối tượng user
$user = new user();

if (isset($_GET['id_user'])) {
    $user_id = $_GET['id_user'];
    // Tiến hành lấy thông tin người dùng và hiển thị thông tin
} else {
    echo "<script>alert('Không tìm thấy người dùng.'); window.location = 'userlist.php';</script>";
}

// Xử lý form khi người dùng chỉnh sửa thông tin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Address = $_POST['Address'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Cập nhật người dùng
    $updateUser = $user->update_user($user_id, $username, $lastname, $email, $PhoneNumber, $Address, $password, $role);
    if ($updateUser) {
        echo "<script>alert('Cập nhật người dùng thành công!'); window.location = 'userlist.php';</script>";
    } else {
        echo "<script>alert('Cập nhật người dùng thất bại!');</script>";
    }
}

// Lấy thông tin người dùng hiện tại
$get_user = $user->get_user_by_id($user_id);
if ($get_user) {
    $result = $get_user;
}
?>

<div class="admin-content-right">
    <div class="admin-content-right-user_edit">
        <h1>Chỉnh sửa người dùng</h1>
        <form action="" method="POST">
            <label for="username">Tên người dùng</label>
            <input type="text" name="username" value="<?php echo $result['username']; ?>" required>
            
            <label for="lastname">Họ</label>
            <input type="text" name="lastname" value="<?php echo $result['lastname']; ?>" required>
            
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo $result['email']; ?>" required>
            
            <label for="PhoneNumber">Số điện thoại</label>
            <input type="text" name="PhoneNumber" value="<?php echo $result['PhoneNumber']; ?>">
            
            <label for="Address">Địa chỉ</label>
            <textarea name="Address"><?php echo $result['Address']; ?></textarea>
            
            <label for="password">Mật khẩu</label>
            <input type="password" name="password" value="<?php echo $result['password']; ?>">
            
            <label for="role">Vai trò</label>
            <select name="role">
                <option value="0" <?php if ($result['role'] == '0') echo "selected"; ?>>Quản trị viên</option>
                <option value="1" <?php if ($result['role'] == '1') echo "selected"; ?>>Người dùng</option>
            </select>
            
            <button type="submit">Cập nhật</button>
        </form>
    </div>
</div>
