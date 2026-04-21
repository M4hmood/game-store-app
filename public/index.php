<?php
// public/index.php

session_start();
ob_start(); // Buffer output to avoid "headers already sent" on redirects

// 1. Get the requested URL path
$request = $_SERVER['REQUEST_URI'];

// Clean up the URL (Removes query strings like ?id=1)
$path = parse_url($request, PHP_URL_PATH);

require_once __DIR__ . '/../controllers/CartController.php';
require_once __DIR__ . '/../controllers/GameController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/AdminController.php';

// 2. Include the Header (This loads your CSS and navbar for every page)
// We might not want the normal header for the admin page, but we'll leave it simple for now or check paths
$isAdminRoute = strpos($path, '/admin') === 0;
if (!$isAdminRoute) {
    // Make sure cart session var exists for header
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    require_once __DIR__ . '/../views/includes/header.php';
}

// 3. The Routing Logic
switch ($path) {
    case '/':
    case '/index.php':
        (new GameController())->index();
        break;

    case '/store':
        (new GameController())->store();
        break;
        
    case '/cart':
        (new CartController())->view();
        break;
        
    case '/cart/add':
        (new CartController())->add();
        break;
        
    case '/cart/remove':
        (new CartController())->remove();
        break;
        
    case '/cart/checkout':
        (new CartController())->checkout();
        break;
        
    case '/profile':
        (new GameController())->profile();
        break;

    case '/library':
        (new GameController())->library();
        break;

    case '/contact':
        (new GameController())->contact();
        break;

    // Admin Routing
    case '/admin':
        (new AdminController())->index();
        break;
        
    case '/admin/games/add':
        (new AdminController())->addGame();
        break;

    case '/admin/games/edit':
        (new AdminController())->editGame();
        break;
        
    case '/admin/users':
        (new AdminController())->users();
        break;
        
    case '/admin/users/edit':
        (new AdminController())->editUser();
        break;
        
    case '/admin/users/delete':
        (new AdminController())->deleteUser();
        break;

    case '/admin/revenue':
        (new AdminController())->revenue();
        break;
        
    case '/admin/settings':
        (new AdminController())->settings();
        break;

    case '/admin/games/edit':
        (new AdminController())->editGame();
        break;
        
    case '/admin/games/delete':
        (new AdminController())->deleteGame();
        break;

    case '/signin':
        (new AuthController())->signin();
        break;

    case '/signup':
        (new AuthController())->signup();
        break;
        
    case '/logout':
        (new AuthController())->logout();
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/../views/front-office/404.php';
        break;
}

// 4. Include the Footer
if (!$isAdminRoute) {
    require_once __DIR__ . '/../views/includes/footer.php';
}

ob_end_flush();
?>