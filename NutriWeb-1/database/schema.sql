CREATE DATABASE IF NOT EXISTS nutriweb_mvp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nutriweb_mvp;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'creator', 'admin') NOT NULL DEFAULT 'user',
    city VARCHAR(100) NOT NULL DEFAULT 'Joinville, SC',
    latitude DECIMAL(10, 8) NOT NULL DEFAULT -26.30440000,
    longitude DECIMAL(11, 8) NOT NULL DEFAULT -48.84870000,
    is_subscriber TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE creator_profiles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    business_name VARCHAR(150) NOT NULL,
    specialty VARCHAR(100) NOT NULL,
    cnpj VARCHAR(20) NULL,
    alvara_number VARCHAR(60) NULL,
    diploma_code VARCHAR(60) NULL,
    sanitary_terms_accepted TINYINT(1) NOT NULL DEFAULT 0,
    delivery_radius_km INT NOT NULL DEFAULT 15,
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    reviewed_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    creator_id INT NOT NULL,
    title VARCHAR(160) NOT NULL,
    category ENUM('Brasileira', 'Italiana', 'Asiática', 'Vegetariana') NOT NULL,
    dietary_restriction ENUM('Todas as dietas', 'Vegetariana', 'Sem glúten', 'Sem lactose') DEFAULT 'Todas as dietas',
    difficulty ENUM('Fácil', 'Intermediário', 'Avançado') NOT NULL,
    prep_time_minutes INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    included_in_club TINYINT(1) NOT NULL DEFAULT 1,
    description TEXT NOT NULL,
    ingredients TEXT NOT NULL,
    steps TEXT NOT NULL,
    zero_waste_tip TEXT NULL,
    video_stream_token VARCHAR(120) NOT NULL,
    rating DECIMAL(2, 1) DEFAULT 5.0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (creator_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE kits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    creator_id INT NOT NULL,
    title VARCHAR(150) NOT NULL,
    servings INT NOT NULL DEFAULT 2,
    price DECIMAL(10, 2) NOT NULL,
    sanitary_certified TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    FOREIGN KEY (creator_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE recipe_purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    recipe_id INT NOT NULL,
    purchased_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_access (user_id, recipe_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE kit_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kit_id INT NOT NULL,
    user_id INT NOT NULL,
    distance_km DECIMAL(6, 1) NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('confirmed', 'preparing', 'delivered') DEFAULT 'confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kit_id) REFERENCES kits(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE community_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    user_id INT NOT NULL,
    type ENUM('result', 'question') NOT NULL,
    content TEXT NOT NULL,
    chef_reply TEXT NULL,
    rating INT DEFAULT 5,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;