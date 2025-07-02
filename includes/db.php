<?php
require_once __DIR__ . '/../config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Log error for production
    error_log("Database connection failed: " . $e->getMessage());
    
    // Show user-friendly error
    if (defined('APP_ENV') && APP_ENV === 'production') {
        die("Database connection error. Please contact administrator.");
    } else {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
} 