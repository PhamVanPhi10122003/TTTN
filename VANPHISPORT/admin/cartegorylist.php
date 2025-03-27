<?php
include "header.php";
include "slider.php";
include "../admin/class/cartegory_class.php";

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != '0') {
    header("Location: ../view/login.php");
    exit();
}

$cartegory = new Cartegory;
$show_cartegory = $cartegory->get_all_cartegory();
?>

<div class="admin-content-right">
    <div class="admin-content-right-cartegory_list">
        <h1>Danh sách danh mục</h1>
        <table>
            <tr>
                <th>Stt</th>
                <th>ID Danh Mục</th>
                <th>Tên Danh Mục</th>
                <th>Tuỳ biến</th>
            </tr>
            <?php
            if ($show_cartegory) {
                $i = 0;
                while ($result = $show_cartegory->fetch_assoc()) {
                    $i++;
            ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $result['cartegory_id']; ?></td>
                        <td><?php echo $result['cartegory_name']; ?></td>
                        <td>
                            <a href="cartegoryedit.php?cartegory_id=<?php echo $result['cartegory_id']; ?>">Sửa</a> |
                            <a href="cartegorydelete.php?cartegory_id=<?php echo $result['cartegory_id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xoá</a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>
</div>
