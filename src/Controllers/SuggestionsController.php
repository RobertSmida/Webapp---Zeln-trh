<?php

require_once __DIR__ . '/../Models/Category.php';
session_start();
require_once __DIR__ . '/../../config/database.php';

// Overenie ci je prihlaseny uzivatel moderator
if (!isset($_SESSION['user_id']) || $_SESSION['is_moderator'] != 1) {
    header('Location: index.php?page=login');
    exit();
}

$db = require __DIR__ . '/../../config/database.php';
$categoryModel = new Category($db);

$errors = [];
$success = "";

// Spracovanie formularov
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['accept_category'])) {
        $categoryModel->acceptCategory((int)$_POST['category_id']);
        $success = "Kategória bola akceptovaná.";
    }

    if (isset($_POST['reject_category'])) {
        $categoryModel->deleteCategory((int)$_POST['category_id']);
        $success = "Kategória bola odmietnutá.";
    }

    if (isset($_POST['update_category'])) {
        $name = trim($_POST['name']);
        if (empty($name)) {
            $errors[] = "Názov kategórie nemôže byť prázdny.";
        } 
        else {
            $categoryModel->updateCategory((int)$_POST['category_id'], $name);
            $success = "Názov kategórie bol úspešne aktualizovaný.";
        }
    }

    if (isset($_POST['delete_category'])) {
        $categoryModel->deleteCategory((int)$_POST['category_id']);
        $success = "Kategória bola úspešne vymazaná.";
    }
}

// Ziskanie zoznamov jednotlivych kategorii
$unacceptedCategories = $categoryModel->getUnacceptedCategories();
$acceptedCategories = $categoryModel->getAcceptedWithParents();

require __DIR__ . '/../Views/suggestions.view.php';
