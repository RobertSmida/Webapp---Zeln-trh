<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php'); // Ak je uzivatel prihlaseny, presmeruj ho na dashboard
    exit();
}

require __DIR__ . '/../Views/home.view.php';