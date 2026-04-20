-- ==========================================
-- 1. MIGRATIONS (Structure)
-- ==========================================

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, 
    role ENUM('client', 'admin') DEFAULT 'client',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    cover_image_path VARCHAR(255), 
    category_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    game_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price_at_purchase DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);

-- ==========================================
-- 2. SEEDERS (Dummy Data)
-- ==========================================

-- Insert an Admin User (Password is 'password123' hashed with bcrypt)
INSERT IGNORE INTO users (username, email, password, role) VALUES 
('admin_zouba', 'admin@gamestore.test', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert Categories
INSERT IGNORE INTO categories (id, name) VALUES 
(1, 'Action/Adventure'),
(2, 'RPG'),
(3, 'FPS'),
(4, 'Strategy');

-- Insert Games
INSERT IGNORE INTO games (title, description, price, category_id, cover_image_path) VALUES 
('Cyberpunk 2077', 'An open-world action-adventure story set in Night City.', 59.99, 2, '/assets/images/cyberpunk.jpg'),
('The Witcher 3', 'You are Geralt of Rivia, mercenary monster slayer.', 39.99, 2, '/assets/images/witcher3.jpg'),
('Valorant', 'A 5v5 character-based tactical shooter.', 0.00, 3, '/assets/images/valorant.jpg');