<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/PaymentMethod.php';

class ProfileController {
    private function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /signin');
            exit;
        }
    }

    public function index() {
        $this->requireLogin();
        $userId = $_SESSION['user_id'];

        $userModel = new User();
        $user = $userModel->findById($userId);

        $orderModel = new Order();
        $orders = $orderModel->getOrdersByUser($userId);

        $paymentModel = new PaymentMethod();
        $paymentMethods = $paymentModel->getByUser($userId);

        $activeTab = $_GET['tab'] ?? 'account';
        $editPaymentId = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
        $editPayment = null;
        if ($editPaymentId > 0) {
            $editPayment = $paymentModel->getById($editPaymentId, $userId);
            if ($editPayment) $activeTab = 'payment';
        }

        $flash = $_SESSION['profile_flash'] ?? null;
        unset($_SESSION['profile_flash']);

        require __DIR__ . '/../views/front-office/profile.php';
    }

    public function updateAccount() {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $userModel = new User();
        $user = $userModel->findById($userId);

        if (!$user) {
            $this->flash('error', 'User not found.');
            header('Location: /profile?tab=account');
            exit;
        }

        if ($username === '' || $email === '') {
            $this->flash('error', 'Username and email are required.');
            header('Location: /profile?tab=account');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->flash('error', 'Invalid email address.');
            header('Location: /profile?tab=account');
            exit;
        }

        if ($userModel->isUsernameTakenByOther($username, $userId)) {
            $this->flash('error', 'Username already in use.');
            header('Location: /profile?tab=account');
            exit;
        }

        if ($userModel->isEmailTakenByOther($email, $userId)) {
            $this->flash('error', 'Email already in use.');
            header('Location: /profile?tab=account');
            exit;
        }

        $userModel->updateProfile($userId, $username, $email);
        $_SESSION['username'] = $username;

        if ($newPassword !== '' || $confirmPassword !== '' || $currentPassword !== '') {
            if (!password_verify($currentPassword, $user['password'])) {
                $this->flash('error', 'Current password is incorrect.');
                header('Location: /profile?tab=account');
                exit;
            }
            if (strlen($newPassword) < 6) {
                $this->flash('error', 'New password must be at least 6 characters.');
                header('Location: /profile?tab=account');
                exit;
            }
            if ($newPassword !== $confirmPassword) {
                $this->flash('error', 'Password confirmation does not match.');
                header('Location: /profile?tab=account');
                exit;
            }
            $userModel->updatePassword($userId, $newPassword);
        }

        $this->flash('success', 'Profile updated successfully.');
        header('Location: /profile?tab=account');
        exit;
    }

    public function addPayment() {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile?tab=payment');
            exit;
        }

        $data = $this->validateCard();
        if ($data === null) {
            header('Location: /profile?tab=payment');
            exit;
        }

        $paymentModel = new PaymentMethod();
        $existing = $paymentModel->getByUser($_SESSION['user_id']);
        $isDefault = !empty($_POST['is_default']) || empty($existing);

        $paymentModel->create(
            $_SESSION['user_id'],
            $data['holder'],
            $data['number'],
            $data['month'],
            $data['year'],
            $data['cvv'],
            $data['brand'],
            $isDefault
        );

        $this->flash('success', 'Payment method added.');
        header('Location: /profile?tab=payment');
        exit;
    }

    public function updatePayment() {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile?tab=payment');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            header('Location: /profile?tab=payment');
            exit;
        }

        $paymentModel = new PaymentMethod();
        $existing = $paymentModel->getById($id, $_SESSION['user_id']);
        if (!$existing) {
            $this->flash('error', 'Payment method not found.');
            header('Location: /profile?tab=payment');
            exit;
        }

        $data = $this->validateCard();
        if ($data === null) {
            header('Location: /profile?tab=payment&edit=' . $id);
            exit;
        }

        $isDefault = !empty($_POST['is_default']) || $existing['is_default'];

        $paymentModel->update(
            $id,
            $_SESSION['user_id'],
            $data['holder'],
            $data['number'],
            $data['month'],
            $data['year'],
            $data['cvv'],
            $data['brand'],
            $isDefault
        );

        $this->flash('success', 'Payment method updated.');
        header('Location: /profile?tab=payment');
        exit;
    }

    public function deletePayment() {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile?tab=payment');
            exit;
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $paymentModel = new PaymentMethod();
            $paymentModel->delete($id, $_SESSION['user_id']);
            $this->flash('success', 'Payment method removed.');
        }
        header('Location: /profile?tab=payment');
        exit;
    }

    public function setDefaultPayment() {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile?tab=payment');
            exit;
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $paymentModel = new PaymentMethod();
            $paymentModel->setDefault($id, $_SESSION['user_id']);
            $this->flash('success', 'Default payment method updated.');
        }
        header('Location: /profile?tab=payment');
        exit;
    }

    private function validateCard() {
        $holder = trim($_POST['card_holder'] ?? '');
        $number = preg_replace('/\s+/', '', $_POST['card_number'] ?? '');
        $month = (int)($_POST['expiry_month'] ?? 0);
        $year = (int)($_POST['expiry_year'] ?? 0);
        $cvv = trim($_POST['cvv'] ?? '');

        if ($holder === '') {
            $this->flash('error', 'Card holder name is required.');
            return null;
        }
        if (!preg_match('/^\d{13,19}$/', $number)) {
            $this->flash('error', 'Card number must be 13-19 digits.');
            return null;
        }
        if ($month < 1 || $month > 12) {
            $this->flash('error', 'Invalid expiry month.');
            return null;
        }
        $currentYear = (int)date('Y');
        if ($year < $currentYear || $year > $currentYear + 20) {
            $this->flash('error', 'Invalid expiry year.');
            return null;
        }
        if ($year === $currentYear && $month < (int)date('n')) {
            $this->flash('error', 'Card has expired.');
            return null;
        }
        if (!preg_match('/^\d{3,4}$/', $cvv)) {
            $this->flash('error', 'CVV must be 3 or 4 digits.');
            return null;
        }

        return [
            'holder' => $holder,
            'number' => $number,
            'month' => $month,
            'year' => $year,
            'cvv' => $cvv,
            'brand' => PaymentMethod::detectBrand($number),
        ];
    }

    private function flash($type, $message) {
        $_SESSION['profile_flash'] = ['type' => $type, 'message' => $message];
    }
}
?>
