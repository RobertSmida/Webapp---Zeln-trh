<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
$db = require __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

$customer_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'] ?? null;
$quantity_to_add = $_POST['quantity'] ?? null;

if (!$product_id || !$quantity_to_add) {
    header('Location: index.php?page=browse_products');
    exit();
}

$product_id = (int)$product_id;
$quantity_to_add = (float)$quantity_to_add; 

if ($quantity_to_add <= 0) {
    header('Location: ' . $_SERVER['HTTP_REFERER'] .'&error=Neplatné množstvo.');
    exit();
}

$stmt = $db->prepare("SELECT available_quantity FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: ' . $_SERVER['HTTP_REFERER'] .'&error=Produkt neexistuje.');
    exit();
}

$stmt = $db->prepare("SELECT SUM(quantity) as total_pending_quantity FROM orders WHERE product_id = ? AND status = 'pending'");
$stmt->execute([$product_id]);
$pending_data = $stmt->fetch(PDO::FETCH_ASSOC);
$total_pending_quantity = $pending_data['total_pending_quantity'] ?? 0;

$available_quantity = $product['available_quantity'] - $total_pending_quantity;

if ($available_quantity < $quantity_to_add) {
    header('Location: ' . $_SERVER['HTTP_REFERER'] . '&error=Nedostatočné množstvo na sklade.');
    exit();
}

$stmt = $db->prepare("SELECT id, quantity FROM orders WHERE customer_id = ? AND product_id = ? AND status = 'pending'");
$stmt->execute([$customer_id, $product_id]);
$existing_order = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing_order) {
    $new_quantity = $existing_order['quantity'] + $quantity_to_add;
    if ($new_quantity > $product['available_quantity']) {
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '&error=Nedostatočné množstvo na sklade.');
        exit();
    }
    $stmt = $db->prepare("UPDATE orders SET quantity = ? WHERE id = ?");
    $stmt->execute([$new_quantity, $existing_order['id']]);
} else {
    $stmt = $db->prepare("INSERT INTO orders (customer_id, product_id, quantity, status) VALUES (?, ?, ?, 'pending')");
    $stmt->execute([$customer_id, $product_id, $quantity_to_add]);
}

header('Location: ' . $_SERVER['HTTP_REFERER'] . '&success=Produkt bol pridaný do košíka.');
exit();
