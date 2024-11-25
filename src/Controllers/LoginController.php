<?php

session_start();
require_once __DIR__ . '/../../config/database.php';
$db = require __DIR__ . '/../../config/database.php';

$email = ''; // Uchovanie hodnoty v poli s emailom

// Overenie pokusu o prihlasenie
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vyhladanie uzivatela v db
    $stmt = $db->prepare("SELECT id, password, moderator FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Kontrola hesla, nastavenie SESSION atributov a presmerovanie
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['is_moderator'] = $user['moderator'];
        
        header('Location: index.php?page=dashboard');
        exit();
    } 
    else {
        $error = "Nesprávne prihlasovacie údaje.";
    }
}

require __DIR__ . '/../Views/login.view.php';