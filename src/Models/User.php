<?php

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT id, name, email, role, status, moderator FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($user_id, $name, $email, $moderator)
    {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ?, moderator = ? WHERE id = ?");
        $stmt->execute([$name, $email, $moderator, $user_id]);
    }

    public function delete($user_id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
    }
}
