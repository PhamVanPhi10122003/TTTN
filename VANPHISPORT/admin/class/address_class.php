<?php
require_once(__DIR__ . '/../../config/database.php');                         

class Address {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    public function getDb() {
        return $this->db;
    }

    public function insert_address() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_SESSION['id_user'])) {
                return "Lỗi: Bạn chưa đăng nhập!";
            }
    
            $id_user = $_SESSION['id_user']; 
            $full_name = $_POST['full_name'] ?? null;
            $phone = $_POST['phone'] ?? null;
            $city = $_POST['city'] ?? null;
            $district = $_POST['district'] ?? null;
            $address = $_POST['address'] ?? null;
            $product_name = $_POST['product_name'] ?? null;
            $product_price_new = $_POST['product_price_new'] ?? null;
            $total_price = $_POST['total_price'] ?? null;
            $product_qty = $_POST['product_qty'] ?? null;
            $product_size = $_POST['product_size'] ?? null; // Lấy size từ form

            if (!$full_name || !$phone || !$city || !$district || !$address || !$product_name || !$product_price_new || !$total_price || !$product_qty || !$product_size) {
                return "Lỗi: Vui lòng nhập đầy đủ thông tin!";
            }
    
            // Query lưu vào database
            $query = "INSERT INTO tbl_address (id_user, full_name, phone, city, district, address, product_name, product_price_new, total_price, product_qty, product_size)
                      VALUES ('$id_user', '$full_name', '$phone', '$city', '$district', '$address', '$product_name', '$product_price_new', '$total_price', '$product_qty', '$product_size')";
    
            $result = $this->db->insert($query);
            return $result ? true : "Lỗi khi lưu địa chỉ!";
        } else {
            return "Phương thức không hợp lệ!";
        }
    }
    public function show_address() {
        $query = "SELECT * FROM tbl_address";
        $result = $this->db->select($query);
        return $result;
    }
    public function delete_address($id) {
        $query = "DELETE FROM tbl_address WHERE id = '$id'";
        $result = $this -> db -> delete($query);
        header('Location:orderlist.php');
        return $result;
    }
}
?>
