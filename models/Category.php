<?php
require_once __DIR__ . '/../config/database.php';

class Category {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getAllCategories() {
        $stmt = $this->conn->query("SELECT * FROM categories");
        return $stmt->fetchAll();
    }
}
?>
