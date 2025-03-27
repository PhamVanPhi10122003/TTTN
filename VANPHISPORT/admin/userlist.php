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
$show_users = $user->show_user();
?>

<div class="admin-content-right">
    <div class="admin-content-right-cartegory_list">
        <h1>Danh sách người dùng</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Tên người dùng</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ</th>
                <th>Vai trò</th>
                <th>Tuỳ biến</th>
            </tr>
            <?php 
            if ($show_users) {
                while ($result = $show_users->fetch_assoc()) {
                    $role = $result['role'] == 1 ? 'Khách hàng' : 'Admin';
            ?>
            <tr>
                <td><?php echo $result['id_user']; ?></td>
                <td><?php echo $result['username']; ?></td>
                <td><?php echo $result['email']; ?></td>
                <td><?php echo $result['PhoneNumber']; ?></td>
                <td><?php echo $result['Address']; ?></td>
                <td><?php echo $role; ?></td>
                <td>
                    <a href="useredit.php?id_user=<?php echo $result['id_user']; ?>">Sửa</a> |
                    <a href="userdelete.php?id_user=<?php echo $result['id_user']; ?>">Xóa</a>
                </td>
            </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>
</div>

</section>
</body>
</html>
