<?php
require_once __DIR__ . '/../../config/database.php';
$db = require __DIR__ . '/../../config/database.php';

$stmt = $db->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

require __DIR__ . '/../Views/explore.view.php';