<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Models/Product.php';

$db = require __DIR__ . '/../../config/database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$categoryModel = new Category($db);
$productModel = new Product($db);

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
$subcategory_id = isset($_GET['subcategory_id']) ? (int)$_GET['subcategory_id'] : null;

$sort_by = $_GET['sort_by'] ?? null;
$params = []; 

$sort_query = "ORDER BY p.name ASC"; 
if ($sort_by === 'price_asc') {
    $sort_query = "ORDER BY p.price_per_unit ASC";
} elseif ($sort_by === 'product_reviews') {
    $sort_query = "ORDER BY p.average_rating DESC, p.number_of_reviews DESC";
} elseif ($sort_by === 'farmer_reviews') {
    $sort_query = "ORDER BY u.farmer_aggregate_reviews DESC";
}

$query = "
    SELECT p.*, u.farmer_aggregate_reviews
    FROM products p
    JOIN users u ON p.farmer_id = u.id
    WHERE p.is_self_harvest = 0
";

if ($user_id) {
    $query .= " AND p.farmer_id != ? ";
    $params[] = $user_id;
}

if ($subcategory_id) {
    $query .= " AND p.category_id = ? ";
    $params[] = $subcategory_id;
} elseif ($category_id) {
    $query .= " AND p.category_id IN (SELECT id FROM categories WHERE parent_id = ?) ";
    $params[] = $category_id;
}

$query .= " " . $sort_query;

$stmt = $db->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$current_level = 'main';
if ($category_id && !$subcategory_id) {
    $subcategories = $categoryModel->getSubcategories($category_id);
    $current_category = $categoryModel->getCategoryById($category_id);
    $current_level = 'category';
} elseif ($subcategory_id) {
    $current_subcategory = $categoryModel->getCategoryById($subcategory_id);
    if ($current_subcategory) {
        $current_category = $categoryModel->getCategoryById($current_subcategory['parent_id']);
    }
    $current_level = 'subcategory';
}

$categories = !$category_id && !$subcategory_id ? $categoryModel->getTopCategories() : [];

require __DIR__ . '/../Views/browse_products.view.php';
