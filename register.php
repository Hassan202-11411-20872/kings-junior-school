<?php
require_once 'includes/db.php';

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        $error = 'Username or email already exists.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO users (full_name, username, email, password, role) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$full_name, $username, $email, $password, $role]);
        $success = 'Registration successful! You can now <a href="login.php">login</a>.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Kings Junior School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/images/favicon_io/favicon.ico">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Nunito', Arial, sans-serif;
            background: linear-gradient(120deg, #0a6efd 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }
        
        .register-container {
            width: 100%;
            max-width: 1200px;
            min-height: 600px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(10, 110, 253, 0.15);
            overflow: hidden;
            display: flex;
        }
        
        .register-left {
            flex: 1;
            background: #e3f2fd;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px 20px;
            text-align: center;
        }
        
        .register-right {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px 20px;
        }
        
        .register-illustration {
            width: 250px;
            max-width: 100%;
            margin-bottom: 20px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(10, 110, 253, 0.12);
        }
        
        .register-headline {
            font-size: 1.8rem;
            font-weight: 800;
            color: #0a6efd;
            margin-bottom: 10px;
        }
        
        .register-subtext {
            font-size: 1rem;
            color: #444;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .register-logo {
            width: 120px;
            margin-bottom: 20px;
        }
        
        .register-card {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(10, 110, 253, 0.10);
            padding: 30px 20px;
        }
        
        .form-control, .form-select {
            border-radius: 30px;
            padding: 12px 20px;
            font-size: 1rem;
            border: 2px solid #e9ecef;
            transition: border-color 0.2s;
            width: 100%;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #0a6efd;
            box-shadow: 0 0 0 0.2rem rgba(10, 110, 253, 0.25);
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
            box-shadow: 0 2px 8px rgba(10, 110, 253, 0.10);
            transition: background 0.2s, box-shadow 0.2s;
        }
        
        .btn-primary:hover {
            background: #0056c7;
            box-shadow: 0 4px 16px rgba(10, 110, 253, 0.18);
        }
        
        .alert {
            border-radius: 15px;
            border: none;
            margin-bottom: 20px;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        
        .mb-3 {
            margin-bottom: 20px;
        }
        
        /* Mobile Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
                min-height: 100vh;
                align-items: stretch;
            }
            
            .register-container {
                flex-direction: column;
                min-height: auto;
                max-width: 100%;
                border-radius: 15px;
            }
            
            .register-left, .register-right {
                padding: 20px 15px;
                flex: none;
            }
            
            .register-left {
                order: 2;
                border-radius: 0 0 15px 15px;
            }
            
            .register-right {
                order: 1;
                border-radius: 15px 15px 0 0;
            }
            
            .register-illustration {
                width: 200px;
                margin-bottom: 15px;
            }
            
            .register-headline {
                font-size: 1.5rem;
            }
            
            .register-subtext {
                font-size: 0.9rem;
            }
            
            .register-card {
                padding: 25px 15px;
                max-width: 100%;
            }
            
            .register-logo {
                width: 100px;
                margin-bottom: 15px;
            }
        }
        
        /* Extra Small Phones */
        @media (max-width: 480px) {
            body {
                padding: 5px;
            }
            
            .register-container {
                border-radius: 10px;
            }
            
            .register-left, .register-right {
                padding: 15px 10px;
            }
            
            .register-card {
                padding: 20px 10px;
            }
            
            .register-illustration {
                width: 180px;
            }
            
            .register-headline {
                font-size: 1.3rem;
            }
            
            .form-control, .form-select {
                padding: 10px 15px;
                font-size: 0.95rem;
            }
            
            .btn-primary {
                padding: 10px 0;
                font-size: 1rem;
            }
        }
        
        /* Very Small Phones */
        @media (max-width: 360px) {
            .register-illustration {
                width: 150px;
            }
            
            .register-headline {
                font-size: 1.2rem;
            }
            
            .register-subtext {
                font-size: 0.85rem;
            }
            
            .form-control, .form-select {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-left">
            <img src="assets/images/team.png" alt="Kings Junior School Team" class="register-illustration">
            <div class="register-headline">Join Our Team</div>
            <div class="register-subtext">Become part of our educational community and help shape the future of our students.</div>
        </div>
        
        <div class="register-right">
            <div class="register-card">
                <img src="assets/images/logo.png" alt="Logo" class="register-logo" style="display: block; margin: 0 auto;">
                <h2 class="text-center mb-3" style="font-weight: 800; font-size: 1.8rem; color: #0a6efd;">Create Account</h2>
                <p class="text-center mb-4" style="color: #666;">Register to access the system</p>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="post" autocomplete="off">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="teacher">Class Teacher</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mb-3">Register</button>
                    
                    <div class="text-center">
                        <a href="login.php" style="color: #0a6efd; text-decoration: none; font-weight: 600;">
                            Already have an account? <span style="text-decoration: underline;">Login</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 