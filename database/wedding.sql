-- Database for Wedding E-Invitation System
CREATE DATABASE IF NOT EXISTS wedding_db;
USE wedding_db;

-- 1. Table for Admin Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    ic_number VARCHAR(20),
    email VARCHAR(100),
    phone VARCHAR(20),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Table for RSVP & Wishes
CREATE TABLE IF NOT EXISTS rsvp (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20) NOT NULL,
    relationship VARCHAR(50),
    attendance ENUM('Yes', 'No') NOT NULL,
    pax INT DEFAULT 0,
    dietary TEXT,
    message TEXT,
    status ENUM('pending', 'approved', 'hidden') DEFAULT 'pending',
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Table for Gallery
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    display_order INT DEFAULT 0,
    status ENUM('visible', 'hidden') DEFAULT 'visible',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Table for Site Settings
CREATE TABLE IF NOT EXISTS site_settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- --- Default Data ---

-- Default Admin (Password: admin123)
INSERT INTO users (username, password, full_name, status) VALUES 
('admin', '$2y$10$.UAK.UIYCkC5DjWXxnPsheUOS/vgjCBSG0riiNYTPasliD1fGd3I5O', 'System Administrator', 'active');

-- Default Settings
INSERT INTO site_settings (setting_key, setting_value) VALUES 
('couple_names', 'Romeo & Juliet'),
('wedding_date', '2025-12-25 10:00:00'),
('venue_name', "St. George's Cathedral"),
('venue_address', 'Verona, Italy'),
('map_link', 'https://maps.google.com'),
('favicon_path', 'assets/images/favicon.png');
