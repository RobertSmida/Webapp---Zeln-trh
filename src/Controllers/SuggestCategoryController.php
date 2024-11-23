<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/SuggestCategory.php';

$db = require __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

$suggestCategoryModel = new SuggestCategory($db);

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $parent_id = (int)$_POST['parent_id'];

    if (empty($name)) {
        $errors[] = "Názov podkategórie je povinný.";
    } else {
        $suggestCategoryModel->suggestCategory($name, $parent_id);
        $success = "Podkategória bola navrhnutá. Po schválení bude dostupná.";
    }
}

$topCategories = $suggestCategoryModel->getTopCategories();

require __DIR__ . '/../Views/suggest_category.view.php';
