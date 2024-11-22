<?php

require_once __DIR__ . '/../Models/Product.php';
session_start();
require_once __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] !== 'farmer' && $_SESSION['user_role'] !== 'customer')) {
    header('Location: index.php?page=login');
    exit();
}

$db = require __DIR__ . '/../../config/database.php';
$productModel = new Product($db);
$user_id = $_SESSION['user_id'];
$errors = [];
$success = "";

// Spracovanie formulára pre vytvorenie alebo aktualizáciu produktu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_product'])) {
        $name = trim($_POST['name']);
        $price = (float)$_POST['price'];
        $quantity = (int)$_POST['quantity'];

        if (empty($name) || $price <= 0 || $quantity < 0) {
            $errors[] = "Všetky polia sú povinné a musia byť validné.";
        } else {
            $productModel->create($user_id, $name, $price, $quantity);
            $success = "Produkt bol úspešne vytvorený.";
        }
    }

    if (isset($_POST['update_product'])) {
        $product_id = (int)$_POST['product_id'];
        $name = trim($_POST['name']);
        $price = (float)$_POST['price'];
        $quantity = (int)$_POST['quantity'];

        if (empty($name) || $price <= 0 || $quantity < 0) {
            $errors[] = "Všetky polia sú povinné a musia byť validné.";
        } else {
            $productModel->update($product_id, $user_id, $name, $price, $quantity);
            $success = "Produkt bol úspešne aktualizovaný.";
        }
    }

    if (isset($_POST['delete_product'])) {
        $product_id = (int)$_POST['product_id'];
        $productModel->delete($product_id, $user_id);
        $success = "Produkt bol úspešne vymazaný.";
    }
}

// Načítanie aktuálnych produktov užívateľa
$products = $productModel->getAllByUser($user_id);

require __DIR__ . '/../Views/manage_products.view.php';
