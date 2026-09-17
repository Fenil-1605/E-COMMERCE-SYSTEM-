<?php
require_once __DIR__ . '/db.php';

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function isLoggedIn() {
    return !empty($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['flash'] = ['type' => 'warning', 'message' => 'Please login or register before continuing.'];
        redirect('login.php');
    }
}

function isAdmin() {
    return !empty($_SESSION['admin_id']);
}

function requireAdmin() {
    if (!isAdmin()) {
        redirect('login.php');
    }
}

function flash() {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return '<div class="alert alert-' . e($f['type']) . '">' . e($f['message']) . '</div>';
    }
    return '';
}

function cartCount() {
    return array_sum($_SESSION['cart'] ?? []);
}

function cartItems(PDO $pdo) {
    $cart = $_SESSION['cart'] ?? [];
    if (!$cart) return [];
    $ids = array_keys($cart);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON c.id=p.category_id WHERE p.id IN ($placeholders) AND p.status=1");
    $stmt->execute($ids);
    $items = [];
    while ($row = $stmt->fetch()) {
        $row['quantity'] = min((int)$cart[$row['id']], (int)$row['stock_quantity']);
        $row['final_price'] = max(0, (float)$row['price'] - (float)$row['discount']);
        $row['subtotal'] = $row['final_price'] * $row['quantity'];
        $items[] = $row;
    }
    return $items;
}

function cartTotal(PDO $pdo) {
    $total = 0;
    foreach (cartItems($pdo) as $item) $total += $item['subtotal'];
    return $total;
}

function old($key) {
    return $_POST[$key] ?? '';
}

function productPrice($p) {
    return max(0, (float)$p['price'] - (float)$p['discount']);
}
