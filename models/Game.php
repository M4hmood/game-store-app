<?php
require_once __DIR__ . '/../config/database.php';

class Game {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAllGames() {
        $stmt = $this->conn->query("SELECT g.*, c.name as category_name FROM games g LEFT JOIN categories c ON g.category_id = c.id");
        return $stmt->fetchAll();
    }
    
    public function getGameById($id) {
        $stmt = $this->conn->prepare("SELECT g.*, c.name as category_name FROM games g LEFT JOIN categories c ON g.category_id = c.id WHERE g.id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function createGame($title, $description, $price, $categoryId, $coverImagePath) {
        $stmt = $this->conn->prepare("INSERT INTO games (title, description, price, category_id, cover_image_path) VALUES (:title, :description, :price, :category_id, :cover_image_path)");
        return $stmt->execute([
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'category_id' => $categoryId,
            'cover_image_path' => $coverImagePath
        ]);
    }

    public function deleteGame($id) {
        $stmt = $this->conn->prepare("DELETE FROM games WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    public function updateGame($id, $title, $description, $price, $categoryId, $coverImagePath) {
        $query = "UPDATE games SET title = :title, description = :description, price = :price, category_id = :category_id";
        $params = [
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'category_id' => $categoryId
        ];

        if ($coverImagePath !== null) {
            $query .= ", cover_image_path = :cover_image_path";
            $params['cover_image_path'] = $coverImagePath;
        }

        $query .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params);
    }
}
?>
