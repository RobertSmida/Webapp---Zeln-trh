<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/FarmerOrder.php';

$db = require __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

$farmer_id = $_SESSION['user_id'];
$farmerOrderModel = new FarmerOrder($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = (int)$_POST['order_id'];
    $new_status = $_POST['new_status'];
    if (in_array($new_status, ['cancelled', 'processed'])) {
        $farmerOrderModel->updateOrderStatus($order_id, $farmer_id, $new_status);
        header('Location: index.php?page=farmer_orders&success=Stav objednávky bol aktualizovaný.');
        exit();
    }
}

$orders = $farmerOrderModel->getFarmerOrders($farmer_id);

require __DIR__ . '/../Views/farmer_order.view.php';
