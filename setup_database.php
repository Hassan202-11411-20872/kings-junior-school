<?php
// Database Setup Script for Kings Junior School
// This script will help you set up the database and create a default admin user

echo "<h1>Kings Junior School - Database Setup</h1>";

// Check if config exists
if (!file_exists('config.php')) {
    die("ERROR: config.php file not found! Please create it first.");
}

// Include config
require_once 'config.php';
echo "<p>✅ Config loaded successfully</p>";

// Test database connection
try {
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "<p>✅ Database connection successful</p>";
    
    // Check if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "<p>✅ Users table exists</p>";
        
        // Check if admin user exists
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users WHERE role = 'admin'");
        $stmt->execute();
        $result = $stmt->fetch();
        
        if ($result['count'] > 0) {
            echo "<p>✅ Admin user already exists</p>";
        } else {
            echo "<p>⚠️ No admin user found. Creating default admin...</p>";
            
            // Create default admin user
            $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute(['admin', 'admin@kingsjunior.rf.gd', $admin_password, 'admin']);
            
            echo "<p>✅ Default admin user created!</p>";
            echo "<p><strong>Username:</strong> admin</p>";
            echo "<p><strong>Password:</strong> admin123</p>";
            echo "<p><strong>⚠️ IMPORTANT:</strong> Change this password immediately after first login!</p>";
        }
        
        // Show existing users
        $stmt = $pdo->query("SELECT username, email, role FROM users ORDER BY id");
        $users = $stmt->fetchAll();
        
        if (count($users) > 0) {
            echo "<h3>Existing Users:</h3>";
            echo "<ul>";
            foreach ($users as $user) {
                echo "<li><strong>{$user['username']}</strong> ({$user['email']}) - {$user['role']}</li>";
            }
            echo "</ul>";
        }
        
    } else {
        echo "<p>❌ Users table not found. You need to import the database first.</p>";
        echo "<p>Please import the <code>database/kings_junior_school.sql</code> file to your database.</p>";
    }
    
} catch (PDOException $e) {
    echo "<p>❌ Database connection failed: " . $e->getMessage() . "</p>";
    echo "<p>Please check your database credentials in config.php</p>";
}

echo "<hr>";
echo "<p><a href='login.php'>Go to Login Page</a></p>";
echo "<p><a href='test.php'>Run Full Diagnostic</a></p>";
?> 