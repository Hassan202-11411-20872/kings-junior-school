<?php
// Installation script for Kings Junior School Management System
session_start();

$step = $_GET['step'] ?? 1;
$errors = [];
$success = [];

// Step 1: System Requirements Check
if ($step == 1) {
    // Check PHP version
    if (version_compare(PHP_VERSION, '7.4.0', '<')) {
        $errors[] = "PHP version 7.4 or higher is required. Current version: " . PHP_VERSION;
    } else {
        $success[] = "PHP version: " . PHP_VERSION . " ✓";
    }
    
    // Check required extensions
    $required_extensions = ['pdo', 'pdo_mysql', 'gd', 'mbstring'];
    foreach ($required_extensions as $ext) {
        if (!extension_loaded($ext)) {
            $errors[] = "PHP extension '$ext' is required but not installed.";
        } else {
            $success[] = "PHP extension '$ext' ✓";
        }
    }
    
    // Check if config.php exists
    if (file_exists('config.php')) {
        $errors[] = "config.php already exists. Please remove it to run the installer.";
    }
    
    // Check directory permissions
    $directories = ['uploads', 'uploads/students'];
    foreach ($directories as $dir) {
        if (!file_exists($dir)) {
            if (!mkdir($dir, 0755, true)) {
                $errors[] = "Cannot create directory: $dir";
            } else {
                $success[] = "Created directory: $dir ✓";
            }
        } else {
            if (!is_writable($dir)) {
                $errors[] = "Directory not writable: $dir";
            } else {
                $success[] = "Directory writable: $dir ✓";
            }
        }
    }
}

// Step 2: Database Configuration
if ($step == 2 && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'] ?? 'localhost';
    $dbname = $_POST['dbname'] ?? 'kings_junior_school';
    $username = $_POST['username'] ?? 'root';
    $password = $_POST['password'] ?? '';
    
    try {
        $pdo = new PDO("mysql:host=$host", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Test if database exists, create if not
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        $success[] = "Database connection successful ✓";
        
        // Import database schema
        $sql = file_get_contents('database/kings_junior_school.sql');
        $pdo->exec("USE `$dbname`");
        $pdo->exec($sql);
        $success[] = "Database schema imported successfully ✓";
        
        // Create config file
        $config_content = "<?php
// Database Configuration
\$host = '$host';
\$db   = '$dbname';
\$user = '$username';
\$pass = '$password';
\$charset = 'utf8mb4';

// Application Configuration
define('APP_NAME', 'Kings Junior School Management System');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://' . \$_SERVER['HTTP_HOST']);

// File Upload Configuration
define('UPLOAD_PATH', 'uploads/');
define('STUDENT_PHOTOS_PATH', 'uploads/students/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Security Configuration
define('SESSION_TIMEOUT', 3600); // 1 hour
define('PASSWORD_MIN_LENGTH', 6);

// Create upload directories if they don't exist
if (!file_exists(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0755, true);
}
if (!file_exists(STUDENT_PHOTOS_PATH)) {
    mkdir(STUDENT_PHOTOS_PATH, 0755, true);
}
?>";
        
        if (file_put_contents('config.php', $config_content)) {
            $success[] = "Configuration file created successfully ✓";
            $step = 3; // Move to final step
        } else {
            $errors[] = "Cannot create config.php file. Please check permissions.";
        }
        
    } catch (PDOException $e) {
        $errors[] = "Database connection failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kings Junior School - Installation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Kings Junior School Management System - Installation</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($step == 1): ?>
                            <h4>Step 1: System Requirements Check</h4>
                            
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <h5>Issues Found:</h5>
                                    <ul class="mb-0">
                                        <?php foreach ($errors as $error): ?>
                                            <li><?php echo htmlspecialchars($error); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <p>Please fix the issues above before proceeding.</p>
                            <?php else: ?>
                                <div class="alert alert-success">
                                    <h5>All Requirements Met!</h5>
                                    <ul class="mb-0">
                                        <?php foreach ($success as $msg): ?>
                                            <li><?php echo htmlspecialchars($msg); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <a href="?step=2" class="btn btn-primary">Continue to Database Setup</a>
                            <?php endif; ?>
                            
                        <?php elseif ($step == 2): ?>
                            <h4>Step 2: Database Configuration</h4>
                            
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <?php foreach ($errors as $error): ?>
                                        <p class="mb-1"><?php echo htmlspecialchars($error); ?></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <form method="post">
                                <div class="mb-3">
                                    <label for="host" class="form-label">Database Host</label>
                                    <input type="text" class="form-control" id="host" name="host" value="localhost" required>
                                </div>
                                <div class="mb-3">
                                    <label for="dbname" class="form-label">Database Name</label>
                                    <input type="text" class="form-control" id="dbname" name="dbname" value="kings_junior_school" required>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Database Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="root" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Database Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <button type="submit" class="btn btn-primary">Install Database</button>
                            </form>
                            
                        <?php elseif ($step == 3): ?>
                            <h4>Step 3: Installation Complete!</h4>
                            
                            <div class="alert alert-success">
                                <h5>Installation Successful!</h5>
                                <p>The Kings Junior School Management System has been installed successfully.</p>
                            </div>
                            
                            <div class="alert alert-info">
                                <h6>Default Login Credentials:</h6>
                                <p><strong>Admin Account:</strong><br>
                                Username: <code>irene</code><br>
                                Password: <code>admin123</code></p>
                                
                                <p><strong>Teacher Account:</strong><br>
                                Username: <code>silvia</code><br>
                                Password: <code>teacher123</code></p>
                                
                                <p class="text-warning"><strong>Important:</strong> Please change these passwords immediately after your first login!</p>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="login.php" class="btn btn-success">Go to Login</a>
                                <a href="index.php" class="btn btn-outline-primary">View Homepage</a>
                            </div>
                            
                            <div class="mt-4">
                                <h6>Next Steps:</h6>
                                <ul>
                                    <li>Change default passwords</li>
                                    <li>Configure your school settings</li>
                                    <li>Add your classes and subjects</li>
                                    <li>Import student data</li>
                                    <li>Delete this install.php file for security</li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 