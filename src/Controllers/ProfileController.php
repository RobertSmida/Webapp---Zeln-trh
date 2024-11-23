<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
$db = require __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

$user_id = $_SESSION['user_id'];
$errors = [];
$success = "";

// Načítanie údajov užívateľa
$stmt = $db->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Užívateľ neexistuje.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($name)) {
            $errors[] = "Meno nemôže byť prázdne.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Neplatný email.";
        }

        if ($email !== $user['email']) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Email už existuje.";
            }
        }

        if (!empty($current_password) || !empty($new_password)) {
            $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            $current_user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!password_verify($current_password, $current_user['password'])) {
                $errors[] = "Nesprávne aktuálne heslo.";
            } elseif ($new_password !== $confirm_password) {
                $errors[] = "Nové heslá sa nezhodujú.";
            } elseif (strlen($new_password) < 6) {
                $errors[] = "Nové heslo musí mať aspoň 6 znakov.";
            } else {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            }
        }

        if (empty($errors)) {
            $stmt = $db->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
            $stmt->execute([$name, $email, $hashed_password ?? $current_user['password'], $user_id]);
            $success = "Profil bol úspešne aktualizovaný.";
            $user['name'] = $name;
            $user['email'] = $email;

            header('Location: index.php?page=dashboard');
            exit();
        }
    }

    if (isset($_POST['delete_profile'])) {
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        session_destroy();
        header('Location: index.php?page=home');
        exit();
    }
}

require __DIR__ . '/../Views/profile.view.php';
