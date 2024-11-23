<?php

class FarmerOrder
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getFarmerOrders($farmer_id)
    {
        $stmt = $this->db->prepare("
            SELECT o.*, p.name AS product_name, p.price_per_unit, u.name AS customer_name
            FROM orders o
            JOIN products p ON o.product_id = p.id
            JOIN users u ON o.customer_id = u.id
            WHERE p.farmer_id = ?
            ORDER BY o.order_date DESC
        ");
        $stmt->execute([$farmer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderStatus($order_id, $farmer_id, $new_status)
    {
        $stmt = $this->db->prepare("
            UPDATE orders o
            JOIN products p ON o.product_id = p.id
            SET o.status = ?
            WHERE o.id = ? AND p.farmer_id = ?
        ");
        $stmt->execute([$new_status, $order_id, $farmer_id]);
    }
}
