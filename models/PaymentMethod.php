<?php
require_once __DIR__ . '/../config/database.php';

class PaymentMethod {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getByUser($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM payment_methods WHERE user_id = :uid ORDER BY is_default DESC, created_at DESC");
        $stmt->execute(['uid' => $userId]);
        return $stmt->fetchAll();
    }

    public function getById($id, $userId) {
        $stmt = $this->conn->prepare("SELECT * FROM payment_methods WHERE id = :id AND user_id = :uid LIMIT 1");
        $stmt->execute(['id' => $id, 'uid' => $userId]);
        return $stmt->fetch();
    }

    public function create($userId, $holder, $number, $month, $year, $cvv, $brand, $isDefault) {
        if ($isDefault) {
            $this->clearDefault($userId);
        }
        $stmt = $this->conn->prepare("INSERT INTO payment_methods (user_id, card_holder, card_number, expiry_month, expiry_year, cvv, brand, is_default) VALUES (:uid, :h, :n, :m, :y, :c, :b, :d)");
        return $stmt->execute([
            'uid' => $userId,
            'h' => $holder,
            'n' => $number,
            'm' => $month,
            'y' => $year,
            'c' => $cvv,
            'b' => $brand,
            'd' => $isDefault ? 1 : 0
        ]);
    }

    public function update($id, $userId, $holder, $number, $month, $year, $cvv, $brand, $isDefault) {
        if ($isDefault) {
            $this->clearDefault($userId);
        }
        $stmt = $this->conn->prepare("UPDATE payment_methods SET card_holder = :h, card_number = :n, expiry_month = :m, expiry_year = :y, cvv = :c, brand = :b, is_default = :d WHERE id = :id AND user_id = :uid");
        return $stmt->execute([
            'id' => $id,
            'uid' => $userId,
            'h' => $holder,
            'n' => $number,
            'm' => $month,
            'y' => $year,
            'c' => $cvv,
            'b' => $brand,
            'd' => $isDefault ? 1 : 0
        ]);
    }

    public function delete($id, $userId) {
        $stmt = $this->conn->prepare("DELETE FROM payment_methods WHERE id = :id AND user_id = :uid");
        return $stmt->execute(['id' => $id, 'uid' => $userId]);
    }

    public function setDefault($id, $userId) {
        $this->clearDefault($userId);
        $stmt = $this->conn->prepare("UPDATE payment_methods SET is_default = 1 WHERE id = :id AND user_id = :uid");
        return $stmt->execute(['id' => $id, 'uid' => $userId]);
    }

    private function clearDefault($userId) {
        $stmt = $this->conn->prepare("UPDATE payment_methods SET is_default = 0 WHERE user_id = :uid");
        $stmt->execute(['uid' => $userId]);
    }

    public static function detectBrand($number) {
        $n = preg_replace('/\D/', '', $number);
        if (preg_match('/^4/', $n)) return 'Visa';
        if (preg_match('/^(5[1-5]|2[2-7])/', $n)) return 'Mastercard';
        if (preg_match('/^3[47]/', $n)) return 'Amex';
        if (preg_match('/^6(?:011|5)/', $n)) return 'Discover';
        return 'Card';
    }

    public static function maskNumber($number) {
        $n = preg_replace('/\D/', '', $number);
        $last4 = substr($n, -4);
        return '•••• •••• •••• ' . $last4;
    }
}
?>
