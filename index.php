<?php
// Načítanie základných nastavení
require_once __DIR__ . '/config/database.php'; // Pripojenie k databáze

// Spracovanie routingu
$page = $_GET['page'] ?? 'home'; // Získa názov stránky z URL alebo nastaví 'home'

switch ($page) {
    case 'profile':
        require_once __DIR__ . '/src/Controllers/ProfileController.php';
        break;

    case 'login':
        require_once __DIR__ . '/src/Controllers/LoginController.php';
        break;

    case 'register':
        require_once __DIR__ . '/src/Controllers/RegisterController.php';
        break;

    case 'dashboard':
        require_once __DIR__ . '/src/Controllers/DashboardController.php';
        break;

    case 'explore':
        require_once __DIR__ . '/src/Controllers/ExploreController.php';
        break;

    case 'logout':
        require_once __DIR__ . '/src/Controllers/LogoutController.php';
        break;

    case 'manage_users':
        require_once __DIR__ . '/src/Controllers/ManageUsersController.php';
        break;

    case 'manage_products':
        require_once __DIR__ . '/src/Controllers/ManageProductsController.php';
        break;

    case 'browse_products':
        require_once __DIR__ . '/src/Controllers/BrowseProductsController.php';
        break;

    case 'add_to_cart':
        require_once __DIR__ . '/src/Controllers/AddToCartController.php';
        break;

    case 'customer_orders':
        require_once __DIR__ . '/src/Controllers/CustomerOrderController.php';
        break;

    case 'farmer_orders':
        require_once __DIR__ . '/src/Controllers/FarmerOrderController.php';
        break;

    case 'suggest_category':
        require_once __DIR__ . '/src/Controllers/SuggestCategoryController.php';
        break;

    case 'suggestions':
        require_once __DIR__ . '/src/Controllers/SuggestionsController.php';
        break;

    case 'harvest_events':
        require_once __DIR__ . '/src/Controllers/HarvestEventsController.php';
        break;   
         
    case 'home':
    default:
        require_once __DIR__ . '/src/Controllers/HomeController.php';
        break;
}

// Tento súbor neobsahuje ďalší HTML alebo logiku - iba spravuje tok aplikácie.
?>
