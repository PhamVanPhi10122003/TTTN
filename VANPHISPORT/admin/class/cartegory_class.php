<?php
// Kết nối database
require_once(__DIR__ . '/../../config/database.php');

class Cartegory {
    private $db;

    public function getDb() {
        return $this->db;
    }
    
    public function __construct() {
        $this->db = new Database();
    }

    public function show_cartegory() {
        $query = "SELECT * FROM tbl_cartegory ORDER BY cartegory_id DESC";
        $result =  $this -> db -> select($query);
        return $result;
    }
    // Thêm danh mục
    public function insert_cartegory($cartegory_name) {
        $query = "INSERT INTO tbl_cartegory (cartegory_name) VALUES ('$cartegory_name')";
        $result = $this->db->insert($query);
        return $result;
    }

    // Lấy danh sách danh mục
    public function get_all_cartegory() {
        $query = "SELECT * FROM tbl_cartegory ORDER BY cartegory_id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    // Lấy một danh mục theo ID
    public function get_cartegory($cartegory_id) {
        $query = "SELECT * FROM tbl_cartegory WHERE cartegory_id = '$cartegory_id'";
        $result = $this->db->select($query);
        return $result;
    }

    // Cập nhật danh mục
    public function update_cartegory($cartegory_id, $cartegory_name) {
        $query = "UPDATE tbl_cartegory SET cartegory_name = '$cartegory_name' WHERE cartegory_id = '$cartegory_id'";
        $result = $this->db->update($query);
        return $result;
    }

    // Xóa danh mục
    public function delete_cartegory($cartegory_id) {
        $query = "DELETE FROM tbl_cartegory WHERE cartegory_id = '$cartegory_id'";
        $result = $this->db->delete($query);
        return $result;
    }
}
?>
