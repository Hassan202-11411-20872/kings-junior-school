<?php
// Check if config file exists
$config_path = __DIR__ . '/../config.php';
if (!file_exists($config_path)) {
    die("ERROR: config.php file not found at: " . $config_path . "<br>Please make sure config.php exists in the root directory.");
}

// Include config file
require_once $config_path;

// Check if required variables are defined
if (!isset($host) || !isset($db) || !isset($user) || !isset($pass)) {
    die("ERROR: Database configuration variables are missing in config.php<br>Required: \$host, \$db, \$user, \$pass");
}

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Show detailed error for debugging
    die("Database connection failed: " . $e->getMessage() . "<br>Host: $host<br>Database: $db<br>User: $user");
}
?> 