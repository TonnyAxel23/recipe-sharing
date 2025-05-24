<?php
session_start();

// Include functions first
require_once __DIR__ . '/functions.php';

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'recipe_sharing');
define('DB_USER', 'root');
define('DB_PASS', '');

// File upload configuration
define('UPLOAD_DIR', 'assets/uploads/');
define('ALLOWED_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('MAX_SIZE', 2 * 1024 * 1024); // 2MB

// Create database connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>