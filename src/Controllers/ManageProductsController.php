<?php

require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Category.php';
$categoryModel = new Category($db);
$subcategories = $categoryModel->getAllSubcategories();

session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'farmer' && $_SESSION['user_role'] !== 'customer')) {
    header('Location: index.php?page=login');
    exit();
}

$db = require __DIR__ . '/../../config/database.php';
$productModel = new Product($db);
$categoryModel = new Category($db);

$user_id = $_SESSION['user_id'];
$errors = [];
$success = "";

$subcategories = $categoryModel->getAllSubcategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['create_product'])) {
        $name = trim($_POST['name']);
        $price_per_unit = (float)$_POST['price_per_unit'];
        $available_quantity = (float)$_POST['available_quantity'];
        $category_id = (int)$_POST['category_id'];

        if (empty($name) || $price_per_unit <= 0 || $available_quantity < 0 || $category_id <= 0) {
            $errors[] = "Všetky polia sú povinné a musia byť validné.";
        } else {
            $productModel->create($user_id, $name, $price_per_unit, $available_quantity, $category_id);
            $success = "Produkt bol úspešne vytvorený.";
        }
    }

    if (isset($_POST['update_product'])) {
        $product_id = (int)$_POST['product_id'];
        $name = trim($_POST['name']);
        $price_per_unit = (float)$_POST['price_per_unit'];
        $available_quantity = (float)$_POST['available_quantity'];

        if (empty($name) || $price_per_unit <= 0 || $available_quantity < 0) {
            $errors[] = "Všetky polia sú povinné a musia byť validné.";
        } else {
            $productModel->update($product_id, $user_id, $name, $price_per_unit, $available_quantity);
            $success = "Produkt bol úspešne aktualizovaný.";
        }
    }

    if (isset($_POST['delete_product'])) {
        $product_id = (int)$_POST['product_id'];
        try {
            $productModel->delete($product_id, $user_id);
            $success = "Produkt bol úspešne vymazaný.";
        } catch (PDOException $e) {
            $errors[] = "Produkt sa nedá vymazať, pretože má prepojené objednávky.";
        }
    }
}

$products = $productModel->getAllByUser($user_id);

require __DIR__ . '/../Views/manage_products.view.php';
