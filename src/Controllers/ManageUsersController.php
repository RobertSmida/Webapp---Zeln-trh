<?php

require_once __DIR__ . '/../Models/User.php';
session_start();
require_once __DIR__ . '/../../config/database.php';

// Overenie, či je užívateľ prihlásený ako administrátor
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

$db = require __DIR__ . '/../../config/database.php';
$userModel = new User($db);
$errors = [];
$success = "";

// Spracovanie formulára
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_user'])) {
        $user_id = (int)$_POST['user_id'];
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $moderator = isset($_POST['moderator']) ? 1 : 0;

        if (empty($name) || empty($email)) {
            $errors[] = "Všetky polia sú povinné.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Neplatný email.";
        } else {
            $userModel->update($user_id, $name, $email, $moderator);
            $success = "Účet bol úspešne aktualizovaný.";
        }
    }

    if (isset($_POST['delete_user'])) {
        $user_id = (int)$_POST['user_id'];
        $userModel->delete($user_id);
        $success = "Účet bol úspešne vymazaný.";
    }
}

// Načítanie všetkých užívateľov
$users = $userModel->getAll();

require __DIR__ . '/../Views/manage_users.view.php';
