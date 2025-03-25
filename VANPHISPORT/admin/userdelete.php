<?php
include "class/user_class.php";

$user = new User;

if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    echo "<script>
        var confirmDelete = confirm('Bạn có chắc chắn muốn xóa người dùng này không?');
        if (confirmDelete) {
            window.location.href = 'userdelete.php?confirm_delete=1&id_user=$id_user';
        } else {
            window.location.href = 'userlist.php'; // Hoặc trang danh sách người dùng
        }
    </script>";
}

if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] == 1) {
    $id_user = $_GET['id_user'];
    $delete_user = $user->delete_user($id_user);
    echo "<script>alert('Xóa người dùng thành công!'); window.location.href = 'user_list.php';</script>";
}
?>
