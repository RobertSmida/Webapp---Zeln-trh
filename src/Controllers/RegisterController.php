<?php
require_once __DIR__ . '/../../config/database.php';
$db = require __DIR__ . '/../../config/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validácia vstupov
    if (empty($name)) {
        $errors[] = "Meno je povinné.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Neplatný formát emailu.";
    }
    if (empty($password)) {
        $errors[] = "Heslo je povinné.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Heslá sa nezhodujú.";
    }

    // Kontrola, či email už neexistuje
    if (empty($errors)) {
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = "Email už existuje.";
        }
    }

    // Uloženie nového užívateľa
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users (name, email, password, role, status) VALUES (?, ?, ?, 'customer', 'active')");
        $stmt->execute([$name, $email, $hashed_password]);

        header('Location: index.php?page=login');
        exit();
    }
}

require __DIR__ . '/../Views/register.view.php';