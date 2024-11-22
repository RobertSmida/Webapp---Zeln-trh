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
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE parent_id IS NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubcategories($parent_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE parent_id = ?");
        $stmt->execute([$parent_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategoryById($category_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$category_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
