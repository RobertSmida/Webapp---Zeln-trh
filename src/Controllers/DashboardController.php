<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
$db = require __DIR__ . '/../../config/database.php';

// Overenie, či je užívateľ prihlásený
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

// Získanie údajov prihláseného užívateľa
$stmt = $db->prepare("SELECT name, role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Chyba: Užívateľ neexistuje.";
    session_destroy();
    exit();
}

require __DIR__ . '/../Views/dashboard.view.php';