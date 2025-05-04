<?php
require_once(__DIR__ . "/../config/database.php");                        

class OrderStatusUpdate {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function update_status($id, $status) {
        $query = "UPDATE tbl_address SET status = '$status' WHERE id = '$id'";
        $result = $this->db->update($query);
        return $result ? true : false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($id && $status) {
        $orderStatusUpdate = new OrderStatusUpdate();
        $updateResult = $orderStatusUpdate->update_status($id, $status);

        if ($updateResult) {
            header("Location: orderlist.php?success=1");
            exit();
        } else {
            header("Location: orderlist.php?error=1");
            exit();
        }
    }
}
