<?php
require_once(__DIR__ . '/../../config/database.php');

class Rental {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    public function getDb() {
        return $this->db;
    }

    // Hàm thêm đơn thuê sản phẩm
    public function insert_rental() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_SESSION['id_user'])) {
                echo "<script>
                alert('Lỗi: Bạn chưa đăng nhập!');
                window.location.href = 'login.php'; 
             </script>";
             exit();
            }

            $id_user = $_SESSION['id_user']; // Lấy id_user từ session
            $product_id = $_POST['product_id'] ?? null;
            $product_name = $_POST['product_name'] ?? null;
            $product_size = $_POST['product_size'] ?? null;
            $product_price_new = $_POST['product_price_new'] ?? null;
            $rental_days = $_POST['rental_days'] ?? null;
            $rental_start = $_POST['rental_start'] ?? null;
            $notes = $_POST['notes'] ?? null;
            // Tính tổng tiền thuê
          

            if ( !$id_user || !$product_id || !$product_name || !$product_size || !$product_price_new || !$rental_days || !$rental_start || !$notes) {
                return "Lỗi: Vui lòng nhập đầy đủ thông tin!";
            }

            $rental_price = $product_price_new / 10; // Giá thuê mỗi ngày (giả sử là 10% giá gốc)
            $total_price = $rental_price * $rental_days; // Tổng tiền thuê

            // Thêm vào CSDL
            $query = "INSERT INTO tbl_rental (id_user, product_id, product_name,product_size,rental_days, rental_start, notes,total_price, rental_price) 
                      VALUES ('$id_user', '$product_id', '$product_name', '$product_size', '$rental_days','$rental_start', '$notes','$total_price','$rental_price')";
            $result = $this->db->insert($query);
            
            return $result ? true : "Lỗi khi lưu đơn thuê!";
        } else {
            return "Phương thức không hợp lệ!";
        }
    }

    // Hàm lấy danh sách đơn thuê của người dùng
    public function get_rental($id_user) {
        $query = "SELECT * FROM tbl_rental WHERE id_user = '$id_user' ORDER BY rental_start DESC";
        return $this->db->select($query);
    }

    public function show_rental() {
        $query = "SELECT tbl_rental.*, 
                         tbl_address.id_user, 
                         tbl_product.product_id
                  FROM tbl_rental 
                  LEFT JOIN tbl_address ON tbl_rental.id_user = tbl_address.id_user
                  LEFT JOIN tbl_product ON tbl_rental.product_id = tbl_product.product_id
                  ORDER BY tbl_rental.product_id DESC";
        $result = $this->db->select($query);
        return $result;
    }
    

    public function delete_rental($rental_id) {
        $query = "DELETE FROM tbl_rental WHERE rental_id = '$rental_id'";
        $result = $this -> db -> delete($query);
        header('Location:rentallist.php');
        return $result;
    }
    public function update_status($rental_id, $status) {
        $allowed_statuses = ['Chờ xác nhận', 'Đang giao', 'Đang thuê', 'Đã trả', 'Huỷ'];
        if (!in_array($status, $allowed_statuses)) {
            return false; // Trạng thái không hợp lệ
        }
    
        $query = "UPDATE tbl_rental SET status_rental = '$status' WHERE rental_id = '$rental_id'";
        return $this->db->update($query);
    }
    
}
?>