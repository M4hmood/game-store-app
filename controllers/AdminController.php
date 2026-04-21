<?php
require_once __DIR__ . '/../models/Game.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Category.php';

class AdminController {
    public function __construct() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("HTTP/1.1 403 Forbidden");
            die("Access Denied: Admins only.");
        }
    }

    public function index() {
        $userModel = new User();
        $gameModel = new Game();
        $orderModel = new Order();

        $users = $userModel->getAllUsers();
        $games = $gameModel->getAllGames();
        $orders = $orderModel->getAllOrders();

        $totalRevenue = 0;
        foreach ($orders as $o) {
            $totalRevenue += $o['total_price'] ?? 0;
        }

        require __DIR__ . '/../views/back-office/index.php';
    }

    public function addGame() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $desc = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $catId = $_POST['category_id'] ?? null;
            
            $imagePath = '';
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                // Determine upload path properly
                $uploadDir = __DIR__ . '/../public/assets/images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $filename = time() . '_' . basename($_FILES['cover_image']['name']);
                $targetFile = $uploadDir . $filename;
                
                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $targetFile)) {
                    $imagePath = '/assets/images/' . $filename;
                }
            }

            $gameModel = new Game();
            $gameModel->createGame($title, $desc, $price, $catId, $imagePath);
            
            header('Location: /admin');
            exit;
        }
        
        $catModel = new Category();
        $categories = $catModel->getAllCategories();
        
        $gameModel = new Game();
        $games = $gameModel->getAllGames();

        require __DIR__ . '/../views/back-office/games.php';
    }

    public function editGame() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['game_id'] ?? null;
            $title = $_POST['title'] ?? '';
            $desc = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $catId = $_POST['category_id'] ?? null;
            
            if ($id) {
                $imagePath = null;
                if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = __DIR__ . '/../public/assets/images/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                    
                    $filename = time() . '_' . basename($_FILES['cover_image']['name']);
                    $targetFile = $uploadDir . $filename;
                    
                    if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $targetFile)) {
                        $imagePath = '/assets/images/' . $filename;
                    }
                }
                
                $gameModel = new Game();
                $gameModel->updateGame($id, $title, $desc, $price, $catId, $imagePath);
            }
        }
        header('Location: /admin/games/add');
        exit;
    }

    public function deleteGame() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['game_id'] ?? null;
            if ($id) {
                $gameModel = new Game();
                $gameModel->deleteGame($id);
            }
        }
        header('Location: /admin');
        exit;
    }

    public function users() {
        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();
        $users = $userModel->getAllUsers();
        require __DIR__ . '/../views/back-office/users.php';
    }
    
    public function editUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/User.php';
            $id = $_POST['user_id'] ?? null;
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $role = $_POST['role'] ?? 'client';
            
            if ($id) {
                $userModel = new User();
                $userModel->updateUser($id, $username, $email, $role);
            }
        }
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/admin/users';
        header('Location: ' . $redirect);
        exit;
    }
    
    public function deleteUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../models/User.php';
            $id = $_POST['user_id'] ?? null;
            if ($id && $id != $_SESSION['user_id']) { 
                $userModel = new User();
                $userModel->deleteUser($id);
            }
        }
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/admin/users';
        header('Location: ' . $redirect);
        exit;
    }
    
    public function revenue() {
        require_once __DIR__ . '/../models/Order.php';
        $orderModel = new Order();
        $orders = $orderModel->getAllOrders();
        
        $totalRevenue = 0;
        foreach ($orders as $o) {
            $totalRevenue += $o['total_price'] ?? 0;
        }
        $totalOrdersCount = count($orders);
        $avgTransaction = $totalOrdersCount > 0 ? $totalRevenue / $totalOrdersCount : 0;
        
        require __DIR__ . '/../views/back-office/revenue.php';
    }
    
    public function settings() {
        require __DIR__ . '/../views/back-office/settings.php';
    }
}
?>
