<?php
require_once __DIR__ . '/../models/Game.php';
require_once __DIR__ . '/../models/Order.php';

class GameController {
    public function index() {
        require __DIR__ . '/../views/front-office/landing_page.php';
    }

    public function store() {
        $gameModel = new Game();
        $games = $gameModel->getAllGames();
        
        $ownedGameIds = [];
        if (isset($_SESSION['user_id'])) {
            require_once __DIR__ . '/../models/Order.php';
            $orderModel = new Order();
            $orders = $orderModel->getOrdersByUser($_SESSION['user_id']);
            foreach ($orders as $order) {
                $ownedGameIds[] = $order['game_id'];
            }
        }

        require __DIR__ . '/../views/front-office/store.php';
    }



    public function preview() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $gameModel = new Game();
        $game = $gameModel->getGameById($id);

        if (!$game) {
            header('Location: /store');
            exit;
        }

        // Check if user owns this game
        $isOwned = false;
        if (isset($_SESSION['user_id'])) {
            require_once __DIR__ . '/../models/Order.php';
            $orderModel = new Order();
            $orders = $orderModel->getOrdersByUser($_SESSION['user_id']);
            foreach ($orders as $order) {
                if ($order['game_id'] == $game['id']) {
                    $isOwned = true;
                    break;
                }
            }
        }

        require __DIR__ . '/../views/front-office/game-preview.php';
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /signin');
            exit;
        }

        $orderModel = new Order();
        $orders = $orderModel->getOrdersByUser($_SESSION['user_id']);
        
        require __DIR__ . '/../views/front-office/profile.php';
    }

    public function library() {
        require __DIR__ . '/../views/front-office/library.php';
    }
    
    public function contact() {
        require __DIR__ . '/../views/front-office/contact.php';
    }
}
?>
