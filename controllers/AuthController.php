<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function signin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                if ($user['role'] === 'admin') {
                    header('Location: /admin');
                } else {
                    header('Location: /');
                }
                exit;
            } else {
                $error = "Invalid username or password!";
                require __DIR__ . '/../views/auth/signin.php';
                return;
            }
        }
        
        require __DIR__ . '/../views/auth/signin.php';
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            if ($userModel->findByUsername($username) || $userModel->findByEmail($email)) {
                $error = "Username or email already exists!";
                require __DIR__ . '/../views/auth/signup.php';
                return;
            }

            if ($userModel->create($username, $email, $password)) {
                header('Location: /signin');
                exit;
            } else {
                $error = "Failed to create account.";
                require __DIR__ . '/../views/auth/signup.php';
                return;
            }
        }

        require __DIR__ . '/../views/auth/signup.php';
    }
    
    public function logout() {
        session_destroy();
        header('Location: /');
        exit;
    }
}
?>
