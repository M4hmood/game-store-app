<?php
require_once __DIR__ . '/../config/database.php';

class Order {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function createOrder($userId, $gameId, $price) {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (:user_id, :total_price)");
            $stmt->execute(['user_id' => $userId, 'total_price' => $price]);
            $orderId = $this->conn->lastInsertId();

            $stmtItem = $this->conn->prepare("INSERT INTO order_items (order_id, game_id, price_at_purchase) VALUES (:order_id, :game_id, :price)");
            $stmtItem->execute([
                'order_id' => $orderId,
                'game_id' => $gameId,
                'price' => $price
            ]);

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function createOrderFromCart($userId, $gameIds) {
        if (empty($gameIds)) return false;

        require_once __DIR__ . '/Game.php';
        $gameModel = new Game();
        
        try {
            $this->conn->beginTransaction();

            // Calculate total and prepare items accurately
            $totalPrice = 0;
            $items = [];
            foreach ($gameIds as $id) {
                $game = $gameModel->getGameById($id);
                if ($game) {
                    $totalPrice += $game['price'];
                    $items[] = [
                        'game_id' => $game['id'],
                        'price' => $game['price']
                    ];
                }
            }

            if (empty($items)) {
                $this->conn->rollBack();
                return false;
            }

            // Insert matching order parent
            $stmt = $this->conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (:user_id, :total_price)");
            $stmt->execute(['user_id' => $userId, 'total_price' => $totalPrice]);
            $orderId = $this->conn->lastInsertId();

            // Insert child lines
            $stmtItem = $this->conn->prepare("INSERT INTO order_items (order_id, game_id, price_at_purchase) VALUES (:order_id, :game_id, :price)");
            
            foreach ($items as $item) {
                $stmtItem->execute([
                    'order_id' => $orderId,
                    'game_id' => $item['game_id'],
                    'price' => $item['price']
                ]);
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function getOrdersByUser($userId) {
        $stmt = $this->conn->prepare("SELECT o.*, oi.price_at_purchase, oi.game_id, g.title, g.cover_image_path FROM orders o JOIN order_items oi ON o.id = oi.order_id JOIN games g ON oi.game_id = g.id WHERE o.user_id = :user_id ORDER BY o.created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getAllOrders() {
        $stmt = $this->conn->query("SELECT o.*, u.username, u.email FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
        return $stmt->fetchAll();
    }
}
?>
