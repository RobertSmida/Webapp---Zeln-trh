<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/CustomerOrder.php';

$db = require __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

$customer_id = $_SESSION['user_id'];
$customerOrderModel = new CustomerOrder($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delivery'])) {
    $order_id = (int)$_POST['order_id'];
    $customerOrderModel->confirmDelivery($order_id, $customer_id);
    header('Location: index.php?page=customer_orders&success=Dodávka bola potvrdená.');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $order_id = (int)$_POST['order_id'];
    $product_id = (int)$_POST['product_id'];
    $rating = (int)$_POST['submit_review'];

    if ($rating < 1 || $rating > 5) {
        header('Location: index.php?page=customer_orders&error=Neplatné hodnotenie.');
        exit();
    }

    $stmt = $db->prepare("SELECT * FROM orders WHERE id = ? AND customer_id = ? AND status = 'settled' AND reviewed IS NULL");
    $stmt->execute([$order_id, $customer_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        header('Location: index.php?page=customer_orders&error=Nedá sa hodnotiť.');
        exit();
    }

    $stmt = $db->prepare("SELECT number_of_reviews, average_rating FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $new_num_reviews = $product['number_of_reviews'] + 1;
        $new_average_rating = (($product['average_rating'] * $product['number_of_reviews']) + $rating) / $new_num_reviews;

        $stmt = $db->prepare("UPDATE products SET number_of_reviews = ?, average_rating = ? WHERE id = ?");
        $stmt->execute([$new_num_reviews, $new_average_rating, $product_id]);
    }

    $stmt = $db->prepare("UPDATE orders SET reviewed = 1 WHERE id = ?");
    $stmt->execute([$order_id]);

    header('Location: index.php?page=customer_orders&success=Hodnotenie bolo odoslané.');
    exit();
}

$orders = $customerOrderModel->getCustomerOrders($customer_id);

require __DIR__ . '/../Views/customer_order.view.php';
