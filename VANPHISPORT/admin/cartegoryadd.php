<?php
include "header.php";
include "slider.php";
include "../admin/class/cartegory_class.php";
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != '0') {
    header("Location: ../view/login.php");
    exit();
}
$cartegory = new Cartegory();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartegory_name = $_POST['cartegory_name'];
    $insert_cartegory = $cartegory->insert_cartegory($cartegory_name);
}

?>

<div class="admin-content-right">
    <div class="admin-content-right-cartegory_add">
        <h1>Thêm Danh Mục</h1>
        <br>
        <form action="" method="post">
            <input required name="cartegory_name" type="text" placeholder="Nhập tên danh mục">
            <button type="submit">Thêm</button>
        </form>
    </div>
</div>
