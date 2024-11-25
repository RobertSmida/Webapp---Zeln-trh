<?php

class Category
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getTopCategories()
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE parent_id IS NULL AND is_accepted = TRUE");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubcategories($parent_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE parent_id = ? AND is_accepted = TRUE");
        $stmt->execute([$parent_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllSubcategories()
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE parent_id IS NOT NULL AND is_accepted = TRUE");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($category_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ? AND is_accepted = TRUE");
        $stmt->execute([$category_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUnacceptedCategories()
    {
        $stmt = $this->db->prepare("
            SELECT c.id, c.name, p.name AS parent_name
            FROM categories c
            LEFT JOIN categories p ON c.parent_id = p.id
            WHERE c.is_accepted = 0
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAcceptedWithParents()
    {
        $stmt = $this->db->prepare("
            SELECT c.id, c.name, p.name AS parent_name
            FROM categories c
            LEFT JOIN categories p ON c.parent_id = p.id
            WHERE c.is_accepted = 1 AND c.parent_id IS NOT NULL
        ");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $result ?: [];
    }

    public function acceptCategory($category_id)
    {
        $stmt = $this->db->prepare("UPDATE categories SET is_accepted = 1 WHERE id = ?");
        $stmt->execute([$category_id]);
    }

    public function updateCategory($category_id, $name)
    {
        $stmt = $this->db->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $stmt->execute([$name, $category_id]);
    }

    public function deleteCategory($category_id)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$category_id]);
    }
}
