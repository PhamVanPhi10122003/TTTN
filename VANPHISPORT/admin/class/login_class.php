<?php
include "../config/database.php"; // Kết nối database


class Login {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    public function getDb() {
        return $this->db;
    }
    // Kiểm tra đăng nhập
    public function check_login($email, $password) {
        $query = "SELECT * FROM tbl_user WHERE email = '$email' LIMIT 1";
        $result = $this->db->select($query);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc(); // Trả về thông tin người dùng
        } else {
            return false; // Không tìm thấy tài khoản
        }
    }
    public function get_user_by_email($email) {
        $query = "SELECT * FROM tbl_user WHERE email = '$email' LIMIT 1";
        $result = $this->db->select($query);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function store_reset_token($email, $token) {
        $query = "UPDATE tbl_user SET reset_token = '$token', token_expiry = NOW() + INTERVAL 1 HOUR WHERE email = '$email'";
        return $this->db->update($query);
    }
}

?>

