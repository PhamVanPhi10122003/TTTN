<?php
include "header.php";
include "slider.php";
include "../admin/class/user_class.php";

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != '0') {
    header("Location: ../view/login.php");
    exit();
}
$user = new User;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy thông tin từ form
    $username = $_POST['username'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Address = $_POST['Address'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Thêm người dùng vào cơ sở dữ liệu
    $insert_user = $user->insert_user($username, $lastname, $email, $PhoneNumber, $Address, $hashed_password, $role);
    if ($insert_user) {
        echo "<script>alert('Thêm người dùng thành công!'); window.location = 'userlist.php';</script>";
    } else {
        echo "<script>alert('Thêm người dùng thất bại!');</script>";
    }
}
?>

<div class="admin-content-right">
    <div class="box">
        <h1>Thêm Người Dùng</h1>
        <form action="" method="post" class="form-group">
            <label for="username">Tên người dùng</label>
            <input required name="username" id="username" type="text" placeholder="Nhập tên người dùng">

            <label for="lastname">Họ tên</label>
            <input required name="lastname" id="lastname" type="text" placeholder="Nhập họ tên">

            <label for="email">Email</label>
            <input required name="email" id="email" type="email" placeholder="Nhập email">

            <label for="PhoneNumber">Số điện thoại</label>
            <input required name="PhoneNumber" id="PhoneNumber" type="text" placeholder="Nhập số điện thoại">

            <label for="Address">Địa chỉ</label>
            <textarea required name="Address" id="Address" placeholder="Nhập địa chỉ"></textarea>

            <label for="password">Mật khẩu</label>
            <input required name="password" id="password" type="password" placeholder="Nhập mật khẩu">

            <label for="role">Vai trò</label>
            <select required name="role" id="role">
                <option value="1">Người dùng</option>
                <option value="0">Quản trị viên</option>
            </select>

            <button type="submit">Thêm</button>
        </form>
    </div>
</div>
