<?php

class Product
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllByUser($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE farmer_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($user_id, $name, $price, $quantity)
    {
        $stmt = $this->db->prepare("INSERT INTO products (farmer_id, name, price, quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $name, $price, $quantity]);
    }

    public function update($product_id, $user_id, $name, $price, $quantity)
    {
        $stmt = $this->db->prepare("UPDATE products SET name = ?, price = ?, quantity = ? WHERE id = ? AND farmer_id = ?");
        $stmt->execute([$name, $price, $quantity, $product_id, $user_id]);
    }

    public function delete($product_id, $user_id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ? AND farmer_id = ?");
        $stmt->execute([$product_id, $user_id]);
    }
}
