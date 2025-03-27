<?php
include "header.php";
include "slider.php";
include "../admin/class/brand_class.php";
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != '0') {
    header("Location: ../view/login.php");
    exit();
}
$brand = new Brand;
$show_brand = $brand->get_all_brand();
?>

<div class="admin-content-right">
    <div class="admin-content-right-brand_list">
        <h1>Danh sách thương hiệu</h1>
        <table>
            <tr>
                <th>Stt</th>
                <th>ID Thương Hiệu</th>
                <th>Tên Thương Hiệu</th>
                <th>Tuỳ biến</th>
            </tr>
            <?php
            if ($show_brand) {
                $i = 0;
                while ($result = $show_brand->fetch_assoc()) {
                    $i++;
            ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $result['brand_id']; ?></td>
                        <td><?php echo $result['brand_name']; ?></td>
                        <td>
                            <a href="brandedit.php?brand_id=<?php echo $result['brand_id']; ?>">Sửa</a> |
                            <a href="branddelete.php?brand_id=<?php echo $result['brand_id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xoá</a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>
</div>
