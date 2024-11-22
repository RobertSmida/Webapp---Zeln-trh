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

    public function getAllProducts()
    {
        $stmt = $this->db->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByParentCategoryId($parent_category_id)
    {
        $stmt = $this->db->prepare("
            SELECT p.*
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE c.parent_id = ?
        ");
        $stmt->execute([$parent_category_id]);
        $products_in_subcategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("
            SELECT p.*
            FROM products p
            WHERE p.category_id = ?
        ");
        $stmt->execute([$parent_category_id]);
        $products_in_category = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_merge($products_in_subcategories, $products_in_category);
    }
    public function getByCategoryId($category_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductsInCategoryWithoutSubcategories($category_id)
    {
        $stmt = $this->db->prepare("
            SELECT p.*
            FROM products p
            WHERE p.category_id = ?
        ");
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
