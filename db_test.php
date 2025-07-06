<?php
// Simple database connection test
echo "<h1>Database Connection Test</h1>";

// Check if config exists
if (!file_exists('config.php')) {
    die("❌ config.php file not found!");
}

// Include config
include 'config.php';
echo "<p>✅ Config loaded</p>";

// Show database settings (without password)
echo "<h2>Database Settings:</h2>";
echo "<p><strong>Host:</strong> $host</p>";
echo "<p><strong>Database:</strong> $db</p>";
echo "<p><strong>User:</strong> $user</p>";
echo "<p><strong>Charset:</strong> $charset</p>";

// Test connection without database first
echo "<h2>Testing Connection:</h2>";
try {
    $dsn = "mysql:host=$host;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "<p>✅ Connected to MySQL server successfully</p>";
    
    // Test if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE '$db'");
    if ($stmt->rowCount() > 0) {
        echo "<p>✅ Database '$db' exists</p>";
        
        // Try to use the database
        $pdo->exec("USE $db");
        echo "<p>✅ Successfully connected to database '$db'</p>";
        
        // Check if users table exists
        $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
        if ($stmt->rowCount() > 0) {
            echo "<p>✅ Users table exists</p>";
        } else {
            echo "<p>❌ Users table not found. You need to import the database.</p>";
        }
        
    } else {
        echo "<p>❌ Database '$db' does not exist!</p>";
        echo "<p>Please create the database in your InfinityFree control panel.</p>";
    }
    
} catch (PDOException $e) {
    echo "<p>❌ Connection failed: " . $e->getMessage() . "</p>";
    
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        echo "<h3>Access Denied - Possible Solutions:</h3>";
        echo "<ol>";
        echo "<li>Check your database username and password in config.php</li>";
        echo "<li>Make sure the database exists in your InfinityFree control panel</li>";
        echo "<li>Verify the database user has proper permissions</li>";
        echo "<li>Try using 'localhost' instead of 'sql.infinityfree.com' for host</li>";
        echo "</ol>";
    }
}

echo "<hr>";
echo "<p><a href='test.php'>Run Full Diagnostic</a></p>";
?> 