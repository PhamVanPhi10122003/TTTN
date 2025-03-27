<?php
include "header.php";
include "slider.php";
include "class/brand_class.php";
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != '0') {
    header("Location: ../view/login.php");
    exit();
}
?>

<?php   
$brand = new brand;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartegory_name = $_POST['cartegory_name'];
    $brand_name = $_POST['brand_name'];
    $insert_brand = $brand->insert_brand($cartegory_name, $brand_name);
}
?>

<div class="admin-content-right">
    <div class="admin-content-right-cartegory_add">
        <h1>Thêm loại sản phẩm</h1>
        <br>
        <form action="" method="post">
            <select name="cartegory_name" id="">
                <option value="#">--Chọn Danh Mục</option>
                <?php
                $show_cartegory = $brand->show_cartegory();
                if ($show_cartegory) {
                    while ($result = $show_cartegory->fetch_assoc()) {
                ?>
                        <option value="<?php echo $result['cartegory_id']; ?>">
                            <?php echo $result['cartegory_name']; ?>
                        </option>
                <?php
                    }
                }
                ?>
            </select>
            <br>
            <input required name="brand_name" type="text" placeholder="Nhập tên loại sản phẩm">
            <button type="submit">Thêm</button>
        </form>
    </div>
</div>
