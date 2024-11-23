<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Models/Category.php';
require_once __DIR__ . '/../Models/Product.php';

$db = require __DIR__ . '/../../config/database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION['user_role'] = 'nonreg';

$categoryModel = new Category($db);
$productModel = new Product($db);

$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
$subcategory_id = isset($_GET['subcategory_id']) ? (int)$_GET['subcategory_id'] : null;

if (!$category_id && !$subcategory_id) {
    $categories = $categoryModel->getTopCategories();
    $products = $productModel->getAllProducts();
    $current_level = 'main';
} elseif ($category_id && !$subcategory_id) {
    $subcategories = $categoryModel->getSubcategories($category_id);
    $products = $productModel->getByParentCategoryId($category_id);
    $current_category = $categoryModel->getCategoryById($category_id);
    $current_level = 'category';
} elseif ($subcategory_id) {
    $products = $productModel->getByCategoryId($subcategory_id);
    $current_subcategory = $categoryModel->getCategoryById($subcategory_id);
    if ($current_subcategory) {
        $current_category = $categoryModel->getCategoryById($current_subcategory['parent_id']);
    }
    $current_level = 'subcategory';
}

require __DIR__ . '/../Views/browse_products.view.php';