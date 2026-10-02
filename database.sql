CREATE DATABASE IF NOT EXISTS pharmacy_db;

USE pharmacy_db;


-- =========================================
-- ADMIN TABLE
-- =========================================

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL
);


INSERT INTO admins
(username, password, full_name)
VALUES
(
    'admin',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC8Gm7h4y8E7y7ZQ7L4e',
    'System Administrator'
);


-- =========================================
-- MEDICINES TABLE
-- =========================================

CREATE TABLE medicines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medicine_name VARCHAR(100) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    expiration_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO medicines
(medicine_name, category, price, stock, expiration_date)
VALUES
('Paracetamol 500mg', 'Pain Reliever', 5.00, 5, '2027-06-15'),
('Amoxicillin 500mg', 'Antibiotic', 12.00, 8, '2027-08-20'),
('Ibuprofen 200mg', 'Pain Reliever', 8.00, 50, '2028-01-10'),
('Vitamin C 500mg', 'Vitamin', 10.00, 75, '2028-03-25');


-- =========================================
-- CUSTOMERS TABLE
-- =========================================

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    contact VARCHAR(30),
    email VARCHAR(100),
    address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO customers
(customer_name, contact, email, address)
VALUES
(
    'Annabelle Awan',
    '09171234567',
    'juan@example.com',
    'Quezon City'
),
(
    'Miguel Bautista',
    '09185552345',
    'maria@example.com',
    'Manila'
),
(
    'Rowena Remolin',
    '09203337890',
    'pedro@example.com',
    'Pasig'
);


-- =========================================
-- SALES TABLE
-- =========================================

CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(30) DEFAULT 'Completed',
    sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO sales
(customer_name, total_amount, status)
VALUES
('Juan Dela Cruz', 850.00, 'Completed'),
('Maria Santos', 1250.00, 'Completed'),
('Pedro Garcia', 540.00, 'Pending');