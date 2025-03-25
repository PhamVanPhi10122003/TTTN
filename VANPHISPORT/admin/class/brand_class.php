<?php
require_once(__DIR__ . '/../../config/database.php');   

class Brand {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    public function getDb() {
        return $this->db;
    }

    public function show_brand() {
        //  $query = "SELECT * FROM tbl_brand ORDER BY brand_id DESC";
          $query = "SELECT tbl_brand.*, tbl_cartegory.cartegory_name
          FROM tbl_brand INNER JOIN tbl_cartegory ON  tbl_brand.cartegory_id = tbl_cartegory.cartegory_id
          ORDER BY tbl_brand.brand_id DESC";
          $result =  $this -> db -> select($query);
          return $result;
      }
      public function show_cartegory() {
        $query = "SELECT * FROM tbl_cartegory ORDER BY cartegory_id DESC";
        $result =  $this -> db -> select($query);
        return $result;
    }
    // Thêm thương hiệu mới
    public function insert_brand($cartegory_id, $brand_name) {
        $query = "INSERT INTO tbl_brand (cartegory_id, brand_name) VALUES ('$cartegory_id', '$brand_name')";
        $result = $this->db->insert($query);
        return $result;
    }
    

    // Lấy danh sách tất cả thương hiệu
    public function get_all_brand() {
        $query = "SELECT * FROM tbl_brand ORDER BY brand_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    // Lấy thông tin một thương hiệu theo ID
    public function get_brand($brand_id) {
        $query = "SELECT * FROM tbl_brand WHERE brand_id = '$brand_id'";
        $result = $this->db->select($query);
        return $result;
    }

    // Cập nhật thương hiệu
    public function update_brand($brand_id, $brand_name) {
        $query = "UPDATE tbl_brand SET brand_name = '$brand_name' WHERE brand_id = '$brand_id'";
        $result = $this->db->update($query);
        return $result;
    }

    // Xóa thương hiệu
    public function delete_brand($brand_id) {
        $query = "DELETE FROM tbl_brand WHERE brand_id = '$brand_id'";
        $result = $this->db->delete($query);
        return $result;
    }
}
?>
