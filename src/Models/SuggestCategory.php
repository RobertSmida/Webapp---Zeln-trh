<?php

class SuggestCategory
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getTopCategories()
    {
        $stmt = $this->db->prepare("SELECT id, name FROM categories WHERE parent_id IS NULL AND is_accepted = TRUE");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function suggestCategory($name, $parent_id, $required_attributes = null)
    {
        $stmt = $this->db->prepare("INSERT INTO categories (name, parent_id, required_attributes, is_accepted) VALUES (?, ?, ?, FALSE)");
        $stmt->execute([$name, $parent_id, $required_attributes]);
    }
}
