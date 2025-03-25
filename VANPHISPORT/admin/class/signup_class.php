<?php
require_once(__DIR__ . '/../../config/database.php');

class Signup {
    private $db;
    public $message = ""; // Biến lưu thông báo

    public function __construct() {
        $this->db = new Database();
    }
    public function getDb() {
        return $this->db;
    }

    public function insert_signup($data) {
        $username = $data['username'];
        $lastname = $data['lastname'];
        $email = $data['email'];
        $PhoneNumber = $data['PhoneNumber'];
        $Address = $data['Address'];
        $password = $data['password'];
        $role = 1; 
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Kiểm tra email đã tồn tại chưa
        $check_query = "SELECT * FROM tbl_user WHERE email = '$email'";
        $check_result = $this->db->select($check_query);
        
        if ($check_result && mysqli_num_rows($check_result) > 0) {
            return "Email đã tồn tại! Vui lòng sử dụng email khác.";
        } 

        // Thêm tài khoản mới nếu email chưa tồn tại
        $query = "INSERT INTO tbl_user (username, lastname, email, PhoneNumber, Address, password, role)
                  VALUES ('$username', '$lastname', '$email', '$PhoneNumber', '$Address', '$hashed_password', '$role')";
        $result = $this->db->insert($query);

        if ($result) {
            return "success"; // Trả về thành công
        } else {
            return "Đăng ký thất bại! Vui lòng thử lại.";
        }
    }
}
?>
