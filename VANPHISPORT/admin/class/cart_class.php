<?php
require_once(__DIR__ . '/../../config/database.php');
?>
<?php
class cart {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Đảm bảo class Database được gọi đúng
    }

    public function insert_cart() {
        $product_id = $_POST["product_id"];
        $product_size = $_POST["product_size"];
        $product_name = $_POST["product_name"];
        $product_price = $_POST["product_price"];
        $product_price_new = $_POST["product_price_new"];
        $product_img = $_POST["product_img"];


        // Kiểm tra size có được chọn hay không
        if (empty($product_size)) {
            return "Vui lòng chọn size sản phẩm!";
        }

        // Truy vấn chèn vào giỏ hàng
        $query = "INSERT INTO tbl_cart ( product_id, product_size, product_name,product_price, product_price_new, product_img) 
                  VALUES ( '$product_id', '$product_size','$product_name','$product_price', '$product_price_new', '$product_img')";
        $result = $this->db->insert($query); // Đảm bảo Database có phương thức insert()
        return $result;
    }

    public function get_cart($cart_id) {
        $query = "SELECT * FROM tbl_cart WHERE cart_id = '$cart_id'";
        $result = $this->db->select($query);
        return $result;
    }
}


?>