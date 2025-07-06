<?php
// Simple diagnostic script to check server configuration
echo "<h1>Kings Junior School - Server Diagnostic</h1>";

// Check PHP version
echo "<h2>PHP Information</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";

// Check if required files exist
echo "<h2>File System Check</h2>";
$files_to_check = [
    'config.php',
    'includes/db.php',
    'includes/header.php',
    'includes/footer.php',
    'assets/css/style.css',
    'assets/images/logo.png'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "✅ $file - EXISTS<br>";
    } else {
        echo "❌ $file - MISSING<br>";
    }
}

// Check database connection
echo "<h2>Database Connection Test</h2>";
if (file_exists('config.php')) {
    include 'config.php';
    
    try {
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        $pdo = new PDO($dsn, $user, $pass, $options);
        echo "✅ Database connection successful<br>";
        
        // Test a simple query
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM information_schema.tables");
        $result = $stmt->fetch();
        echo "✅ Database query test successful<br>";
        
    } catch (PDOException $e) {
        echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ config.php not found<br>";
}

// Check PHP error reporting
echo "<h2>Error Reporting</h2>";
echo "display_errors: " . (ini_get('display_errors') ? 'ON' : 'OFF') . "<br>";
echo "error_reporting: " . ini_get('error_reporting') . "<br>";

// Check if we can write to uploads directory
echo "<h2>Directory Permissions</h2>";
$upload_dirs = ['uploads', 'uploads/students'];
foreach ($upload_dirs as $dir) {
    if (is_dir($dir)) {
        echo "✅ $dir directory exists<br>";
        if (is_writable($dir)) {
            echo "✅ $dir is writable<br>";
        } else {
            echo "❌ $dir is NOT writable<br>";
        }
    } else {
        echo "❌ $dir directory missing<br>";
    }
}

echo "<h2>Current Directory</h2>";
echo "Current working directory: " . getcwd() . "<br>";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

echo "<h2>PHP Extensions</h2>";
$required_extensions = ['pdo', 'pdo_mysql', 'mbstring'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext extension loaded<br>";
    } else {
        echo "❌ $ext extension NOT loaded<br>";
    }
}
?> 