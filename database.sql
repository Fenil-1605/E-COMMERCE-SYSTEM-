CREATE DATABASE IF NOT EXISTS bookverse CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE bookverse;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mobile VARCHAR(20) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    address VARCHAR(255) DEFAULT NULL,
    city VARCHAR(100) DEFAULT NULL,
    state VARCHAR(100) DEFAULT NULL,
    pincode VARCHAR(10) DEFAULT NULL,
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    description TEXT,
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    price DECIMAL(10,2) NOT NULL,
    discount DECIMAL(10,2) NOT NULL DEFAULT 0,
    description TEXT,
    specifications TEXT,
    stock_quantity INT NOT NULL DEFAULT 0,
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    mobile VARCHAR(20) DEFAULT NULL,
    billing_address VARCHAR(255) NOT NULL,
    shipping_address VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    pincode VARCHAR(10) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL DEFAULT 'Cash on Delivery',
    payment_status VARCHAR(50) NOT NULL DEFAULT 'Pending',
    order_status VARCHAR(50) NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(200) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);

CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(200) DEFAULT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO categories (name, image, description) VALUES
('Fiction', 'assets/images/category-fiction.svg', 'Stories, novels and imaginative worlds.'),
('Technology', 'assets/images/category-technology.svg', 'Programming, computers, AI and technology books.'),
('Science', 'assets/images/category-science.svg', 'Physics, astronomy, biology and general science.'),
('Self Help', 'assets/images/category-selfhelp.svg', 'Personal growth, habits and productivity.'),
('Business', 'assets/images/category-business.svg', 'Business, management, finance and entrepreneurship.'),
('Academic', 'assets/images/category-academic.svg', 'Study material and academic reference books.');

INSERT INTO products
(category_id, name, image, price, discount, description, specifications, stock_quantity) VALUES
(1, 'The Silent Library', 'assets/images/book-1.svg', 499, 50, 'A mystery novel about a forgotten library and the secrets hidden inside it.', 'Author: A. Mehta | Pages: 320 | Language: English', 25),
(1, 'Beyond the Stars', 'assets/images/book-2.svg', 599, 80, 'A science-fiction adventure following a young explorer beyond the solar system.', 'Author: R. Shah | Pages: 368 | Language: English', 18),
(2, 'Python Made Simple', 'assets/images/book-3.svg', 699, 100, 'Beginner-friendly Python programming with practical examples.', 'Author: K. Patel | Pages: 410 | Language: English', 30),
(2, 'Web Development Essentials', 'assets/images/book-4.svg', 799, 120, 'HTML, CSS, JavaScript, PHP and MySQL fundamentals in one book.', 'Author: N. Desai | Pages: 520 | Language: English', 22),
(3, 'A Brief Guide to Astronomy', 'assets/images/book-5.svg', 549, 70, 'An accessible introduction to stars, galaxies, planets and the universe.', 'Author: J. Trivedi | Pages: 290 | Language: English', 16),
(3, 'Physics for Curious Minds', 'assets/images/book-6.svg', 649, 90, 'Core physics concepts explained through everyday examples.', 'Author: M. Joshi | Pages: 350 | Language: English', 20),
(4, 'Atomic Habits', 'assets/images/book-7.svg', 499, 60, 'A practical guide to building good habits and breaking bad ones.', 'Author: J. Clear | Pages: 300 | Language: English', 35),
(4, 'Deep Work', 'assets/images/book-8.svg', 449, 50, 'Strategies for focused work and better productivity.', 'Author: C. Newport | Pages: 280 | Language: English', 28),
(5, 'The Startup Handbook', 'assets/images/book-9.svg', 749, 100, 'A practical introduction to launching and managing a small business.', 'Author: S. Rao | Pages: 430 | Language: English', 14),
(5, 'Money Basics', 'assets/images/book-10.svg', 399, 40, 'Simple financial concepts for students and young professionals.', 'Author: P. Shah | Pages: 250 | Language: English', 40),
(6, 'Database Systems', 'assets/images/book-11.svg', 899, 150, 'Relational databases, SQL, normalization and database design.', 'Author: V. Kumar | Pages: 560 | Language: English', 19),
(6, 'Operating Systems', 'assets/images/book-12.svg', 849, 100, 'Processes, memory, scheduling, file systems and OS concepts.', 'Author: D. Mehta | Pages: 500 | Language: English', 17);

-- Demo admin. Password is: admin123
INSERT INTO admins (name, email, password)
VALUES ('BookVerse Admin', 'admin@bookverse.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC7Yw8V4vQx0fPqJwQyO');

