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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['role'])) {
    $new_role = $_POST['role'];

    if (in_array($new_role, ['farmer', 'customer'])) {
        $_SESSION['user_role'] = $new_role; // Store role in session
        $user['role'] = $new_role;
    }
}

if (!isset($_SESSION['user_role'])) {
    $_SESSION['user_role'] = $user['role'];
} else {
    $user['role'] = $_SESSION['user_role'];
}

require __DIR__ . '/../Views/dashboard.view.php';