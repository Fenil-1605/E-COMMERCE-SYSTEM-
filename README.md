# BookVerse — PHP & MySQL E-Commerce Website

A university-friendly dynamic e-commerce bookstore built with PHP, MySQL, PDO, HTML/CSS and Bootstrap.

## Requirements covered

### Frontend / Customer
- Home page with dynamic categories/products
- Category page
- Product listing
- Product detail
- Session-based shopping cart
- Checkout
- Cash on Delivery payment interface
- Order success page
- My Profile
- Order History
- About Us
- Contact Us with database storage
- Login / Register / Logout
- Password hashing
- Search
- Responsive layout

### Admin
- Separate admin login
- Dashboard: users, categories, products, orders, revenue
- User listing/search/deactivation
- Category CRUD
- Product CRUD
- Stock and status management
- Order listing
- Order status updates: Pending, Confirmed, Processing, Shipped, Delivered, Cancelled
- Contact message listing

## Installation in XAMPP

1. Install XAMPP.
2. Copy the `BookVerse` folder into:
   `C:\xampp\htdocs\`
3. Start Apache and MySQL.
4. Open phpMyAdmin:
   `http://localhost/phpmyadmin`
5. Import `database.sql`.
6. Check `config.php`. Default XAMPP MySQL settings are:
   - host: localhost
   - database: bookverse
   - user: root
   - password: empty
7. Open:
   `http://localhost/BookVerse/`

## Admin login
Email: admin@bookverse.com
Password: admin123

## Notes
- Payment is intentionally simplified to Cash on Delivery because the assignment gives COD as an example and does not require a real payment gateway.
- Product/category images are local SVG placeholders so the project works without downloading image files.
- Bootstrap is loaded from CDN for a clean responsive UI. For a completely offline setup, Bootstrap files can later be downloaded into the project.
