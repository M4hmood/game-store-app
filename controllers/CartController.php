<?php
require_once __DIR__ . '/../models/Game.php';
require_once __DIR__ . '/../models/Order.php';

class CartController {
    public function __construct() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function view() {
        $gameModel = new Game();
        $cartItems = [];
        $totalPrice = 0.0;

        foreach ($_SESSION['cart'] as $id => $quantity) {
            $game = $gameModel->getGameById($id);
            if ($game) {
                $cartItems[] = $game;
                $totalPrice += $game['price'];
            }
        }

        require __DIR__ . '/../views/front-office/cart.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gameId = (int)($_POST['game_id'] ?? 0);
            
            if ($gameId > 0) {
                // Ensure quantity is 1 max
                $_SESSION['cart'][$gameId] = 1;
            }
        }
        header('Location: /cart');
        exit;
    }

    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gameId = (int)($_POST['game_id'] ?? 0);
            
            if (isset($_SESSION['cart'][$gameId])) {
                unset($_SESSION['cart'][$gameId]);
            }
        }
        header('Location: /cart');
        exit;
    }

    public function checkout() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                header('Location: /signin');
                exit;
            }

            if (empty($_SESSION['cart'])) {
                header('Location: /store');
                exit;
            }

            $orderModel = new Order();
            // Process the bulk cart item checkout
            if ($orderModel->createOrderFromCart($_SESSION['user_id'], array_keys($_SESSION['cart']))) {
                $_SESSION['cart'] = []; // Clear Cart
                header('Location: /profile?transaction=completed');
                exit;
            } else {
                die("An error occurred during checkout.");
            }
        }
        
        header('Location: /cart');
        exit;
    }
}
?>
