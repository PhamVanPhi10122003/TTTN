<?php
require_once(__DIR__ . '/../../config/database.php');
?>
<?php

class product {
    private $db;

    public function getDb() {
        return $this->db;
    }
    public function __construct()
    {
            $this -> db = new Database();
    }
   
    
    public function show_cartegory() {
        $query = "SELECT * FROM tbl_cartegory ORDER BY cartegory_id DESC";
        $result =  $this -> db -> select($query);
        return $result;
    }
    public function show_brand() {
      //  $query = "SELECT * FROM tbl_brand ORDER BY brand_id DESC";
        $query = "SELECT tbl_brand.*, tbl_cartegory.cartegory_name
        FROM tbl_brand INNER JOIN tbl_cartegory ON  tbl_brand.cartegory_id = tbl_cartegory.cartegory_id
        ORDER BY tbl_brand.brand_id DESC";
        $result =  $this -> db -> select($query);
        return $result;
    }   
    public function get_product_by_id($product_id) {
        $query = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
        return $this->db->select($query);
    }
    public function insert_product() {

        $product_name = $_POST['product_name'];
        $cartegory_id = $_POST['cartegory_id'];
        $brand_id = $_POST['brand_id'];
        $product_price = $_POST['product_price'];
        $product_price_new = $_POST['product_price_new'];
        $product_desc = $_POST['product_desc'];
        $product_img = $_FILES['product_img']['name'];
        $product_sold = $_POST['product_sold'];
        $query = "INSERT INTO tbl_product (
   
        product_name,
        cartegory_id,
        brand_id,
        product_price,
        product_price_new,
        product_desc,
        product_img,
        product_sold
        )
        VALUES (
        '$product_name',
        '$cartegory_id',
        '$brand_id',
        '$product_price',
        '$product_price_new',
        '$product_desc',
        '$product_img',
        '$product_sold')";
        $result =  $this -> db -> insert($query);
        return $result;
    }

public function show_product() {
    $query = "SELECT tbl_product.*, tbl_cartegory.cartegory_name, tbl_brand.brand_name
              FROM tbl_product 
              INNER JOIN tbl_cartegory ON tbl_product.cartegory_id = tbl_cartegory.cartegory_id
              INNER JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
              ORDER BY tbl_product.product_id DESC";

    $result = $this->db->select($query);
    return $result;
    }
    public function delete_product($product_id) {
        $query = "DELETE FROM tbl_product WHERE product_id = '$product_id'";
        $result = $this -> db -> delete($query);
        header('Location:productlist.php');
        return $result;
    }

    public function update_product($product_id, $product_name, $product_price, $product_price_new, $product_desc, $status_product, $product_sold,$status_buy) {
        $query = "UPDATE tbl_product SET 
                  product_name = '$product_name', 
                  product_price = '$product_price', 
                  product_price_new = '$product_price_new', 
                  product_desc = '$product_desc', 
                  status_product = '$status_product', 
                  product_sold = '$product_sold' , 
                  status_buy = '$status_buy'
                  WHERE product_id = '$product_id'";
        
        $result = $this->db->update($query);
        if ($result) {
            echo "<script>alert('Cập nhật thành công!'); window.location='productlist.php';</script>";
        } else {
            echo "<script>alert('Cập nhật thất bại!');</script>";
        }
 
    }
    public function searchProduct($query) {
        $sql = "SELECT * FROM tbl_product WHERE product_name LIKE '%$query%'";
        return $this->db->select($sql);
    }
    
    public function get_related_product_by_brand($brand_id, $product_id) {
        $query = "SELECT * FROM tbl_product 
                  WHERE brand_id = '$brand_id' 
                  AND product_id != '$product_id' 
                  ORDER BY product_id DESC 
                  LIMIT 10";
        return $this->db->select($query);
    }
    
    
}
?> 

