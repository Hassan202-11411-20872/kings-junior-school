<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<!-- Starting login page -->";

// Check if config file exists
if (!file_exists('config.php')) {
    die("ERROR: config.php file not found!");
}

// Include config
require_once 'config.php';
echo "<!-- Config loaded -->";

// Check if db file exists
if (!file_exists('includes/db.php')) {
    die("ERROR: includes/db.php file not found!");
}

// Include database connection
require_once 'includes/db.php';
echo "<!-- Database connection loaded -->";

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<!-- Processing login form -->";
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1');
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] === 'admin') {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: teacher/dashboard.php');
        }
        exit;
    } else {
        $error = 'Invalid username/email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kings Junior School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(120deg, #0a6efd 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(10, 110, 253, 0.15);
            max-width: 400px;
            width: 100%;
        }
        .form-control {
            border-radius: 30px;
            padding: 12px 20px;
            font-size: 1rem;
            border: 2px solid #e9ecef;
        }
        .btn-primary {
            background: #0a6efd;
            border: none;
            color: #fff;
            border-radius: 30px;
            font-weight: 700;
            padding: 12px 0;
            font-size: 1.1rem;
            width: 100%;
        }
        .alert {
            border-radius: 15px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center mb-4" style="color: #0a6efd; font-weight: 800;">Login</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger mb-4"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="post" autocomplete="off">
            <div class="mb-3">
                <label for="username" class="form-label fw-bold">Username or Email</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label fw-bold">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <div class="text-center mt-4">
            <a href="register.php" style="color: #0a6efd; text-decoration: none; font-weight: 600;">
                Don't have an account? <span style="text-decoration: underline;">Register</span>
            </a>
        </div>
    </div>
</body>
</html> 