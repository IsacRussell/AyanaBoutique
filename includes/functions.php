<?php
// Core URL generator
function base_url($path = '') {
    return BASE_URL . ltrim($path, '/');
}

// Security: Escape HTML to prevent XSS attacks
function e($string) {
    return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
}

// Security: Generate a hidden CSRF token input
function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . e($_SESSION['csrf_token']) . '">';
}

// Security: Output the raw CSRF token
function csrf_token() {
    return $_SESSION['csrf_token'] ?? '';
}

// Security: Verify POST requests
function verify_csrf() {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !==$_SESSION['csrf_token']) {
        die('Security token mismatch. Please go back and try again.');
    }
}

// Redirection helper
function redirect($url) {
    header("Location: $url");
    exit;
}

// Formatting: Prices
function format_price($amount) {
    $symbol = CURRENCY_CODE === 'USD' ? '$' : (CURRENCY_CODE === 'INR' ? '₹' : CURRENCY_CODE . ' ');
    return $symbol . number_format((float)$amount, 2);
}

// Formatting: Order numbers
function generate_order_number() {
    return 'AYN-' . strtoupper(substr(uniqid(), -6) . rand(10, 99));
}

// Formatting: Image paths
function product_image_url($path) {
    if (empty($path)) return base_url('assets/images/placeholder.svg');
    return base_url(UPLOAD_URL_PATH . ltrim($path, '/'));
}

// Database: Get all active categories
function get_all_categories($pdo) {
    $stmt =$pdo->query("SELECT * FROM categories ORDER BY id ASC");
    return $stmt->fetchAll();
}

// Database: Get a single category by its URL slug
function get_category_by_slug($pdo,$slug) {
    $stmt =$pdo->prepare("SELECT * FROM categories WHERE slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}
?>