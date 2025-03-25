<?php
include "header.php";
include "slider.php";
include "class/product_class.php";
?>

<?php   
$product = new product;
$show_product = $product -> show_product();

?>

<div class="admin-content-right">
            <div class="admin-content-right-cartegory_list">
                <h1>Danh sách sản phẩm</h1>
                <table>
                    <tr>
                        <th>Stt</th>
                        <th>ID</th>
                        <th>Danh mục</th>
                        <th>Sản phẩm</th>
                        <th>Giá sản phẩm</th>
                        <th>Giá sản phẩm mới</th>
                        <th>Mô tả sản phẩm</th>
                        <th>Trạng thái</th>
                        <th>Đã bán</th>
                        <th>Tuỳ biến</th>
                    </tr>
                    <?php
                    if($show_product) {
                        $i=0;
                        while($result = $show_product->fetch_assoc()) {$i++;
                    ?>
                        <tr>
                           <td><?php echo $i ?></td>
                            <td><?php echo $result['product_id'] ?></td>
                            <td><?php echo $result['cartegory_name'] ?></td>
                            <td><?php echo $result['product_name'] ?></td>
                            <td><?php echo number_format($result['product_price'], 0, ',', '.'); ?> <sup>đ</sup></p></td>
                            <td><?php echo number_format($result['product_price_new'], 0, ',', '.'); ?> <sup>đ</sup></p></td>
                            <td><?php echo $result['product_desc'] ?></td>
                            <td><?php echo $result['status_product'] ?></td>
                            <td><?php echo $result['product_sold'] ?></td>
                            <td><a href=" productedit.php?product_id=<?php echo $result['product_id'] ?>">Sửa</a>|<a href="productdelete.php?product_id=<?php echo $result['product_id'] ?>">Xoá</a></td>
                        </tr>
                        <?php
                        }
                    }
                    ?>
                </table>
            </div>
</div> 