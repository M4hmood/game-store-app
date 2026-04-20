<?php
// public/index.php

// 1. Get the requested URL path (e.g., '/games', '/library', or '/' for home)
$request = $_SERVER['REQUEST_URI'];

// Clean up the URL (Removes query strings like ?id=1)
$path = parse_url($request, PHP_URL_PATH);

// 2. Include the Header (This loads your CSS and navbar for every page)
require_once __DIR__ . '/../views/includes/header.php';

// 3. The Routing Logic
switch ($path) {
    // If the URL is just "localhost:8000/" or "localhost:8000/store"
    case '/':
    case '/index.php':
        require __DIR__ . '/../views/front-office/landing_page.php';
        break;

    // Other pages
    case '/store':
        require __DIR__ . '/../views/front-office/store.php';
        break;

    case '/library':
        require __DIR__ . '/../views/front-office/library.php';
        break;

    case '/contact':
        require __DIR__ . '/../views/front-office/contact.php';
        break;


    // The Admin Panel
    case '/admin':
        require __DIR__ . '/../views/back-office/index.php';
        break;


    //auth 

    case '/signin':
        require __DIR__ . '/../views/auth/signin.php';
        break;

    case '/signup':
        require __DIR__ . '/../views/auth/signup.php';
        break;
    // If the user types a URL that doesn't exist, show the 404 page
    default:
        http_response_code(404);
        require __DIR__ . '/../views/front-office/404.php';
        break;
}

// 4. Include the Footer
require_once __DIR__ . '/../views/includes/footer.php';
?>