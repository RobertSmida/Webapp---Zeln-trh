<?php

session_start();
require_once __DIR__ . '/../../config/database.php';
$db = require __DIR__ . '/../../config/database.php';

// Overenie ci je uzivatel prihlaseny
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

// Nacitanie udajov uzivatela z db
$stmt = $db->prepare("SELECT name, role, moderator FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Chyba: Užívateľ neexistuje.";
    session_destroy();
    exit();
}

// Zmena role pri zmene rezimu predaj/nakup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['role'])) {
    $new_role = $_POST['role'];

    $_SESSION['user_role'] = $new_role;
    $user['role'] = $new_role;
}

// Inicializacia role
if (!isset($_SESSION['user_role'])) {
    $_SESSION['user_role'] = $user['role'];
} else {
    $user['role'] = $_SESSION['user_role'];
}

require __DIR__ . '/../Views/dashboard.view.php';