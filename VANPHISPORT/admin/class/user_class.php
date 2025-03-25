<?php 
require_once(__DIR__ . '/../../config/database.php');
?>
<?php

class user {
    private $db;

    public function __construct()
    {
            $this -> db = new Database();
    }
    public function getDb() {
        return $this->db;
    }
    public function get_all_users() {
        // Truy vấn tất cả người dùng
        $query = "SELECT * FROM tbl_user";
        $result = $this->db->select($query);  // Thực thi truy vấn và trả về kết quả
        return $result;  // Trả về kết quả truy vấn
    }
    public function get_user_by_id($user_id) {
        $query = "SELECT * FROM tbl_user WHERE id_user = '$user_id' LIMIT 1";
        $result = $this->db->select($query);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();  // Trả về một mảng chứa thông tin của người dùng
        } else {
            return null;  // Trả về null nếu không tìm thấy người dùng
        }
    }
    
    public function update_avatar($id_user, $avatar) {
        $query = "UPDATE tbl_user SET avatar = '$avatar' WHERE id_user = '$id_user'";
        return $this->db->update($query);
    }
    
    public function insert_user($username, $lastname, $email, $PhoneNumber, $Address, $password, $role) {
        // Truy vấn thêm người dùng vào cơ sở dữ liệu
        $query = "INSERT INTO tbl_user (username, lastname, email, PhoneNumber, Address, password, role) 
                  VALUES ('$username', '$lastname', '$email', '$PhoneNumber', '$Address', '$password', '$role')";
        $result = $this->db->insert($query);  // Thực thi truy vấn
        return $result;  // Trả về kết quả của việc thêm người dùng
    }
    public function get_user($user_id) {
        $query = "SELECT * FROM tbl_user WHERE id_user = '$user_id'";  // Truy vấn lấy thông tin người dùng
        $result = $this->db->select($query);
        return $result;
    }
    public function show_user() {
        $query = "SELECT * FROM tbl_user";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_user($user_id, $username, $lastname, $email, $PhoneNumber, $Address, $password, $role) {
        $query = "UPDATE tbl_user 
                  SET username = '$username', lastname = '$lastname', email = '$email', PhoneNumber = '$PhoneNumber', Address = '$Address', password = '$password', role = '$role'
                  WHERE id_user = '$user_id'";
        $result = $this->db->update($query);  // Thực thi truy vấn
        return $result;
    }
    public function delete_user($id_user) {
        $query = "DELETE FROM tbl_user WHERE id_user = '$id_user'";
        $result = $this -> db -> delete($query);
        header('Location:userlist.php');
        return $result;
    }
}  