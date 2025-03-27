<?php
include "header.php";
include "slider.php";
include "../admin/class/address_class.php";

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != '0') {
    header("Location: ../view/login.php");
    exit();
}

?>

<?php   
$Address = new Address;
$show_address = $Address -> show_address();

?>

<div class="admin-content-right">
    <div class="admin-content-right-cartegory_list">
        <h1>Danh sách đơn hàng</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>PhoneNumber</th>
                <th>Tỉnh/Thành Phố</th>
                <th>Xã/Huyện</th>
                <th>Address</th>
                <th>Sản phẩm</th>
                <th>Giá sản phẩm</th>
                <th>Số lượng</th>
                <th>Trạng thái</th>
                <th>Tuỳ biến</th>
            </tr>
            <?php 
            if ($show_address) {
                while ($result = $show_address->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $result['id_user']; ?></td>
                <td><?php echo $result['full_name']; ?></td>
                <td><?php echo $result['phone']; ?></td>
                <td><?php echo $result['city']; ?></td>
                <td><?php echo $result['district']; ?></td>
                <td><?php echo $result['address']; ?></td>
                <td><?php echo $result['product_name']; ?></td>
                <td><?php echo $result['total_price']; ?></td>
                <td><?php echo $result['product_qty']; ?></td>
                <td>
        <form action="order_status_update.php" method="POST">
            <input type="hidden" name="id_user" value="<?php echo $result['id_user']; ?>">
            <select name="status" onchange="this.form.submit()">
                <option value="Chờ xác nhận" <?php if($result['status'] == 'Chờ xác nhận') echo 'selected'; ?>>Chờ xác nhận</option>
                <option value="Đang giao" <?php if($result['status'] == 'Đang giao') echo 'selected'; ?>>Đang giao</option>
                <option value="Hoàn thành" <?php if($result['status'] == 'Hoàn thành') echo 'selected'; ?>>Hoàn thành</option>
                <option value="Hủy" <?php if($result['status'] == 'Hủy') echo 'selected'; ?>>Hủy</option>
            </select>
        </form>
    </td>

                <td>
                    <a href="orderdelete.php?id=<?php echo $result['id']; ?>">Xóa</a>
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