-- Student Accommodation Management Database
-- ============================================

CREATE DATABASE IF NOT EXISTS student_accommodation;
USE student_accommodation;

-- Users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'landlord', 'admin') NOT NULL,
    phone VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Properties Table
CREATE TABLE properties (
    id INT PRIMARY KEY AUTO_INCREMENT,
    landlord_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    location VARCHAR(200) NOT NULL,
    price INT NOT NULL,
    room_type VARCHAR(50) NOT NULL,
    status ENUM('available', 'occupied', 'unavailable') DEFAULT 'available',
    amenities TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (landlord_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Property Images Table
CREATE TABLE property_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE
);

-- Applications Table
CREATE TABLE applications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    property_id INT NOT NULL,
    message TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE
);

-- Messages/Contact Table
CREATE TABLE messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample admin
INSERT INTO users (full_name, email, password, role, phone) VALUES 
('Admin User', 'admin@accommodation.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36gZvWFm', 'admin', '9876543210');

-- Sample landlord
INSERT INTO users (full_name, email, password, role, phone) VALUES 
('John Landlord', 'landlord@example.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36gZvWFm', 'landlord', '9123456789');

-- Sample student
INSERT INTO users (full_name, email, password, role, phone) VALUES 
('Alex Student', 'student@example.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36gZvWFm', 'student', '9234567890');

-- Sample properties
INSERT INTO properties (landlord_id, title, description, location, price, room_type, status, amenities) VALUES 
(2, '2 BHK Modern Apartment', 'Spacious 2-bedroom apartment with modern amenities', 'Downtown Area', 15000, '2 bedroom', 'available', 'WiFi, AC, Kitchen, Parking'),
(2, 'Cozy Single Room', 'Small comfortable room perfect for single occupancy', 'College Lane', 8000, 'single', 'available', 'WiFi, Fan, Attached Bathroom'),
(2, '3 BHK Family Flat', 'Large flat suitable for families or groups', 'Suburbs', 25000, '3 bedroom', 'available', 'WiFi, AC, Kitchen, Balcony, Parking, Gym Access');
