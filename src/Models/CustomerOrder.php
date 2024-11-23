<?php

class CustomerOrder
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getCustomerOrders($customer_id)
    {
        $stmt = $this->db->prepare("
            SELECT o.*, p.name AS product_name, p.price_per_unit, u.name AS farmer_name
            FROM orders o
            JOIN products p ON o.product_id = p.id
            JOIN users u ON p.farmer_id = u.id
            WHERE o.customer_id = ?
            ORDER BY o.order_date DESC
        ");
        $stmt->execute([$customer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function confirmDelivery($order_id, $customer_id)
    {
        $stmt = $this->db->prepare("
            UPDATE orders
            SET status = 'settled'
            WHERE id = ? AND customer_id = ? AND status = 'processed'
        ");
        $stmt->execute([$order_id, $customer_id]);
    }
}
