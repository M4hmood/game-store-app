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

-- Insert another Admin User (Password is 'Mahmoud03' hashed with bcrypt)
INSERT IGNORE INTO users (username, email, password, role) VALUES
('admin_mahmoud', 'admin@gamestore.local', '$2y$10$K79.iTHSbP1RwgQHgCd57.LNffqeR5xzY81/sjJsZGTct2dLb0oB2', 'admin');

-- Insert Categories
INSERT IGNORE INTO categories (id, name) VALUES 
(1, 'Action/Adventure'),
(2, 'RPG'),
(3, 'FPS'),
(4, 'Strategy'),
(5, 'Adventure'),
(6, 'Fighting'),
(7, 'Open World');

-- Insert Games
INSERT IGNORE INTO games (title, description, price, category_id, cover_image_path) VALUES 
('Red Dead Redemption 2', 'Outlaw Arthur Morgan rides through the fading Wild West.', 49.99, 5, '/assets/images/games/red-dead-redemption-2.jpg'),
('Sekiro: Shadows Die Twice', 'Master katana combat and stealth in Sengoku-era Japan.', 59.99, 1, '/assets/images/games/sekiro.jpg'),
('Mortal Kombat 11', 'Kombatants clash with brutal fatalities and a time-bending story.', 49.99, 6, '/assets/images/games/mortal-kombat-11.jpg'),
('Far Cry 5', 'Liberate Hope County from a dangerous cult in a vast open world.', 49.99, 7, '/assets/images/games/far-cry-5.jpg'),
('Ghost of Tsushima', 'Lead Jin Sakai against the Mongol invasion across a stunning open world.', 59.99, 1, '/assets/images/games/ghost-of-tsushima.jpg'),
('Cyberpunk 2077', 'Forge your legend in Night City with high-tech weaponry and cyberware.', 49.99, 2, '/assets/images/games/cyberpunk-2077.jpg'),
('The Last of Us Part II', 'Ellie''s journey of survival, revenge, and redemption in a ravaged world.', 69.99, 5, '/assets/images/games/the-last-of-us-2.jpg'),
('Uncharted 4: A Thief''s End', 'Join Nathan Drake for one last treasure hunt across the globe.', 29.99, 5, '/assets/images/games/uncharted-4.jpg'),
('Assassin''s Creed Valhalla', 'Lead Eivor''s Viking clan to forge a new saga across England.', 59.99, 1, '/assets/images/games/assassins-creed-valhalla.jpg');