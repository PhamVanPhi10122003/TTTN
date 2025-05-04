<?php
include "../config/database.php";

class Order {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }
    public function getDb() {
        return $this->db;
    }

    // Lấy danh sách đơn hàng
    public function show_order() {
        $query = "SELECT tbl_address.*, users.full_name, users.phone, users.city, users.district, users.address,
                         products.product_name, order_details.total_price, order_details.product_qty
                  FROM orders
                  INNER JOIN tbl_user ON tbl_address.id_user = tbl_user.id_user
                  INNER JOIN order_details ON tbl_address.order_id = order_details.order_id
                  INNER JOIN tbl_product ON order_details.product_id = tbl_product.product_id
                  ORDER BY orders.order_id DESC";

        $result = $this->db->select($query);
        return $result;
    }
    public function get_address($id_user) {
        $query = "SELECT * FROM tbl_address WHERE id_user = '$id_user'";
        $result = $this->db->select($query);
        return $result;
    }

    // Cập nhật trạng thái đơn hàng
    public function update_order_status($id, $status) {
        $query = "UPDATE tbl_address SET status = '$status' WHERE id = '$id'";
        $result = $this->db->update($query);
        return $result;
    }

    // Xóa đơn hàng
    public function delete_order($id) {
        $query = "DELETE FROM tbl_address WHERE id = '$id'";
        $result = $this->db->delete($query);
        return $result;
    }
    public function getOrdersByUserId($user_id) {
        $query = "SELECT * FROM tbl_orders WHERE user_id = '$user_id' ORDER BY order_date DESC";
        return $this->db->select($query);
    }

    public function getOrderDetails($order_id) {
        $query = "SELECT * FROM tbl_order_details WHERE order_id = '$order_id'";
        return $this->db->select($query);
    }
}
?>
