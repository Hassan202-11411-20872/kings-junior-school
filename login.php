<?php
require_once 'includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            padding: 20px;
        }
        
        .kjs-auth-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            min-height: 600px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(10, 110, 253, 0.15);
            overflow: hidden;
        }
        
        .kjs-auth-left {
            flex: 1;
            background: #e3f2fd;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            text-align: center;
        }
        
        .kjs-auth-right {
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }
        
        .kjs-auth-illustration {
            width: 280px;
            max-width: 100%;
            margin-bottom: 30px;
            border-radius: 16px;
        }
        
        .kjs-auth-headline {
            font-size: 2rem;
            font-weight: 800;
            color: #0a6efd;
            margin-bottom: 15px;
        }
        
        .kjs-auth-subtext {
            font-size: 1.1rem;
            color: #444;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .kjs-auth-logo {
            width: 140px;
            margin-bottom: 30px;
        }
        
        .login-card {
            width: 100%;
            max-width: 400px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(10, 110, 253, 0.10);
            padding: 40px;
        }
        
        .form-control {
            border-radius: 30px;
            padding: 12px 20px;
            font-size: 1rem;
            border: 2px solid #e9ecef;
            transition: border-color 0.2s;
        }
        
        .form-control:focus {
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
        }
        
        .slider-container {
            position: relative;
            width: 280px;
            max-width: 100%;
            margin-bottom: 30px;
        }
        
        .slider-slide {
            display: none;
            text-align: center;
        }
        
        .slider-slide.active {
            display: block;
        }
        
        .slider-dots {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        
        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #b3c6e6;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .slider-dot.active {
            background: #0a6efd;
            width: 24px;
            border-radius: 6px;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .kjs-auth-container {
                flex-direction: column;
                min-height: auto;
            }
            
            .kjs-auth-left, .kjs-auth-right {
                padding: 30px 20px;
            }
            
            .kjs-auth-headline {
                font-size: 1.5rem;
            }
            
            .kjs-auth-subtext {
                font-size: 1rem;
            }
            
            .login-card {
                padding: 30px 20px;
            }
            
            .slider-container {
                width: 100%;
                max-width: 250px;
            }
        }
        
        @media (max-width: 480px) {
            .kjs-auth-container {
                border-radius: 15px;
            }
            
            .kjs-auth-left, .kjs-auth-right {
                padding: 20px 15px;
            }
            
            .login-card {
                padding: 25px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="kjs-auth-container">
        <div class="kjs-auth-left">
            <div class="slider-container">
                <div class="slider-slide active" id="slide1">
                    <img src="assets/images/king (1).png" alt="Kings Junior School" class="kjs-auth-illustration">
                    <div class="kjs-auth-headline">Experience Endless Opportunities</div>
                    <div class="kjs-auth-subtext">Provide a variety of features and benefits through live classes to enhance the learning experience at Kings Junior School.</div>
                </div>
                <div class="slider-slide" id="slide2">
                    <img src="assets/images/king.png" alt="Kings Junior School" class="kjs-auth-illustration">
                    <div class="kjs-auth-headline">We Hold The Future</div>
                    <div class="kjs-auth-subtext">Empowering students with knowledge and skills for tomorrow's challenges.</div>
                </div>
                <div class="slider-dots">
                    <span class="slider-dot active" onclick="showSlide(1)"></span>
                    <span class="slider-dot" onclick="showSlide(2)"></span>
                </div>
            </div>
        </div>
        
        <div class="kjs-auth-right">
            <div class="login-card">
                <img src="assets/images/logo.png" alt="Logo" class="kjs-auth-logo" style="display: block; margin: 0 auto;">
                <h2 class="text-center mb-4" style="font-weight: 800; font-size: 1.8rem; color: #0a6efd;">Welcome Back</h2>
                <p class="text-center mb-4" style="color: #666;">Login to your account</p>
                
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
                    <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                    <div class="text-center">
                        <a href="register.php" style="color: #0a6efd; text-decoration: none; font-weight: 600;">
                            Don't have an account? <span style="text-decoration: underline;">Register</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentSlide = 1;
        
        function showSlide(slideNumber) {
            // Hide all slides
            document.querySelectorAll('.slider-slide').forEach(slide => {
                slide.classList.remove('active');
            });
            
            // Remove active class from all dots
            document.querySelectorAll('.slider-dot').forEach(dot => {
                dot.classList.remove('active');
            });
            
            // Show selected slide
            document.getElementById('slide' + slideNumber).classList.add('active');
            
            // Activate selected dot
            document.querySelectorAll('.slider-dot')[slideNumber - 1].classList.add('active');
            
            currentSlide = slideNumber;
        }
        
        // Auto-slide every 4 seconds
        setInterval(() => {
            showSlide(currentSlide === 1 ? 2 : 1);
        }, 4000);
    </script>
</body>
</html> 