<?php   
include "header.php";
include "slider.php";
include "../admin/class/rental_class.php";
include "../admin/class/product_class.php";
include "../admin/class/address_class.php";
?>

<?php   
$rental = new Rental;
$show_rental = $rental -> show_rental();



?>

<div class="admin-content-right">
            <div class="admin-content-right-cartegory_list">
                <h1>Danh sách thuê sản phẩm</h1>
                <table>
    <tr>
        <th>Stt</th>
        <th>id_user</th>
        <th>Tên Sản Phẩm</th>
        <th>Size</th>
        <th>Ngày Bắt Đầu</th>
        <th>Số Ngày Thuê</th>
        <th>Ghi Chú</th>
        <th>Giá Thuê</th>
        <th>Tổng Tiền</th>
        <th>Ngày Tạo</th> <!-- Mới thêm -->
        <th>Trạng Thái</th> <!-- Mới thêm -->
        <th>Tuỳ biến</th>
    </tr>
    <?php
    if ($show_rental) {
        $i = 0;
        while ($result = $show_rental->fetch_assoc()) {
            $i++;
    ?>
    <tr>
       <td><?php echo $i ?></td>
       <td><?php echo $result['id_user'] ?></td>
       <td><?php echo $result['product_name'] ?></td>
       <td><?php echo $result['product_size'] ?></td>
       <td><?php echo $result['rental_start'] ?></td>
       <td><?php echo $result['rental_days'] ?></td>
       <td><?php echo $result['notes'] ?></td>
       <td><?php echo number_format($result['rental_price'], 0, ',', '.'); ?> <sup>đ</sup></p></td>
       <td><?php echo number_format($result['total_price'], 0, ',', '.'); ?> <sup>đ</sup></p></td>
       <td><?php echo $result['created_at'] ?></td> <!-- Hiển thị ngày tạo -->
       <td>
            <form method="POST" action="updatastatus.php">
                <input type="hidden" name="rental_id" value="<?php echo $result['rental_id']; ?>">
                <select name="status_rental" onchange="this.form.submit()">
                    <option value="Chờ xác nhận" <?php if ($result['status_rental'] == 'Chờ xác nhận') echo 'selected'; ?>>Đang xử lý</option>
                    <option value="Đang giao" <?php if ($result['status_rental'] == 'Đang giao') echo 'selected'; ?>>Đang giao</option>
                    <option value="Đang thuê" <?php if ($result['status_rental'] == 'Đang thuê') echo 'selected'; ?>>Đang thuê</option>
                    <option value="Đã trả" <?php if ($result['status_rental'] == 'Đã trả') echo 'selected'; ?>>Hoàn thành</option>
                    <option value="Huỷ" <?php if ($result['status_rental'] == 'Huỷ') echo 'selected'; ?>>Đã hủy</option>
                </select>
            </form>
        </td>
       <td><a href="rentaldelete.php?rental_id=<?php echo $result['rental_id'] ?>">Xoá</a></td>
    </tr>
    <?php
        }
    }
    ?>
</table>

            </div>
</div>