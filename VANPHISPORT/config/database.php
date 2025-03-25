<?php
include_once "../config/config.php"; 
?>

<?php

class Database {
    public $host = DB_HOST;
    public $user = DB_USER;
    public $pass = DB_PASS;
    public $dbname = DB_NAME;

    public $link; // Biến để kết nối cơ sở dữ liệu
    public $error; // Biến lưu lỗi

    // Hàm khởi tạo (__construct)
    public function __construct() {
        $this->connectDB(); // Gọi hàm kết nối khi khởi tạo lớp
    }

    // Hàm kết nối cơ sở dữ liệu
    private function connectDB() {
        $this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        
        if ($this->link->connect_error) { // Kiểm tra lỗi kết nối
            $this->error = "Kết nối thất bại: " . $this->link->connect_error;
            return false;
        }
    }

    // Hàm đọc dữ liệu (SELECT)
    public function select($query) {
        $result = $this->link->query($query) or die($this->link->error . __LINE__);
        if ($result->num_rows > 0) {
            return $result; // Trả về dữ liệu nếu có kết quả
        } else {
            return false; // Trả về false nếu không có dữ liệu
        }
    }

    public function execute($query, $params, $types) {
        $stmt = $this->link->prepare($query);
        if ($stmt === false) {
            die("Lỗi truy vấn: " . $this->link->error);
        }

        $stmt->bind_param($types, ...$params);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    // Hàm chèn dữ liệu (INSERT)
    public function insert($query) {
        $insert_row = $this->link->query($query) or die($this->link->error . __LINE__);
        if ($insert_row) {
            return true; // Trả về true nếu chèn thành công
        } else {
            return false; // Trả về false nếu chèn thất bại
        }
    }
    

    public function prepare($sql) {
        return $this->link->prepare($sql);
    }

    // Hàm cập nhật dữ liệu (UPDATE)
    public function update($query) {
        $update_row = $this->link->query($query) or die($this->link->error . __LINE__);
        if ($update_row) {
            return true; // Trả về true nếu cập nhật thành công
        } else {
            return false; // Trả về false nếu cập nhật thất bại
        }
    }

    // Hàm xóa dữ liệu (DELETE)
    public function delete($query) {
        $delete_row = $this->link->query($query) or die($this->link->error . __LINE__);
        if ($delete_row) {
            return true; // Trả về true nếu xóa thành công
        } else {
            return false; // Trả về false nếu xóa thất bại
        }
    }
}
?> 