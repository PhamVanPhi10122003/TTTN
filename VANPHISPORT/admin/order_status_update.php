<?php
require_once(__DIR__ . "/../config/database.php");                        

class OrderStatusUpdate {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function update_status($id_user, $status) {
        $query = "UPDATE tbl_address SET status = '$status' WHERE id_user = '$id_user'";
        $result = $this->db->update($query);
        return $result ? true : false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = $_POST['id_user'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($id_user && $status) {
        $orderStatusUpdate = new OrderStatusUpdate();
        $updateResult = $orderStatusUpdate->update_status($id_user, $status);

        if ($updateResult) {
            header("Location: orderlist.php?success=1");
            exit();
        } else {
            header("Location: orderlist.php?error=1");
            exit();
        }
    }
}
