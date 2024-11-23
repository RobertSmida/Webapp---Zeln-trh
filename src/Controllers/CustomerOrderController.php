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

// Handle status update for "Confirm Delivery" button
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delivery'])) {
    $order_id = (int)$_POST['order_id'];
    $customerOrderModel->confirmDelivery($order_id, $customer_id);
    header('Location: index.php?page=customer_orders&success=Dodávka bola potvrdená.');
    exit();
}

// Fetch all orders for the logged-in customer
$orders = $customerOrderModel->getCustomerOrders($customer_id);

require __DIR__ . '/../Views/customer_order.view.php';
