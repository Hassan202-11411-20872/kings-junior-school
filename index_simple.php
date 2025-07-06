<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kings Junior School - Report System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Nunito', Arial, sans-serif;
            background: linear-gradient(120deg, #e3f2fd 0%, #ffffff 100%);
            color: #222;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
            color: #fff;
            border-radius: 0 0 40px 40px;
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.2);
            padding: 60px 20px;
            text-align: center;
        }
        
        .hero-logo {
            width: 120px;
            margin-bottom: 20px;
            animation: bounceIn 1s;
        }
        
        .hero-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            animation: fadeInUp 1.2s 0.2s both;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 30px;
            animation: fadeInUp 1.2s 0.4s both;
        }
        
        .btn-hero {
            margin: 10px;
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 30px;
            animation: bounceIn 1.2s 0.6s both;
        }
        
        .features-section {
            background: #f5faff;
            border-radius: 24px;
            margin: 40px auto;
            padding: 40px 20px;
            box-shadow: 0 2px 12px rgba(25, 118, 210, 0.06);
            max-width: 1200px;
        }
        
        .feature-card {
            border-radius: 20px;
            box-shadow: 0 4px 24px rgba(25, 118, 210, 0.10);
            transition: transform 0.2s, box-shadow 0.2s;
            background: #fff;
            height: 100%;
            padding: 30px 20px;
            text-align: center;
        }
        
        .feature-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.18);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: #1976d2;
            margin-bottom: 20px;
            animation: pulseIcon 2s infinite alternate;
        }
        
        .about-section {
            background: #fff;
            border-radius: 24px;
            margin: 40px auto;
            padding: 40px 20px;
            box-shadow: 0 2px 12px rgba(25, 118, 210, 0.06);
            max-width: 1200px;
        }
        
        .about-logo {
            max-width: 300px;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(25, 118, 210, 0.15);
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes bounceIn {
            0% { transform: scale(0.5); opacity: 0; }
            60% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(1); }
        }
        
        @keyframes pulseIcon {
            from { text-shadow: 0 0 8px #42a5f5; }
            to { text-shadow: 0 0 24px #1976d2; }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .features-section, .about-section {
                margin: 20px 10px;
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <img src="assets/images/logo.png" alt="Kings Junior School Logo" class="hero-logo">
        <h1 class="hero-title">Kings Junior School</h1>
        <h2 class="hero-subtitle">Students Report Generation System</h2>
        <a href="login.php" class="btn btn-primary btn-hero">Login</a>
        <a href="register.php" class="btn btn-outline-light btn-hero">Register</a>
    </div>

    <!-- Features Section -->
    <div class="features-section">
        <div class="container">
            <h2 class="text-center mb-5" style="color: #1976d2; font-weight: bold;">System Features</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <h5 class="card-title">Easy Student Registration</h5>
                        <p class="card-text">Register students one by one or in bulk, including photo upload and parent details.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <h5 class="card-title">Quick Marks Entry</h5>
                        <p class="card-text">Teachers can easily input marks for all subjects, with per-subject remarks and auto-grading.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                        </div>
                        <h5 class="card-title">Professional Report Cards</h5>
                        <p class="card-text">Generate, print, and export beautiful report cards for single or all students, with school branding.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0 text-center">
                    <img src="assets/images/logo.png" alt="Kings Junior School Logo" class="about-logo">
                </div>
                <div class="col-md-6">
                    <h3 class="fw-bold mb-3" style="color: #1976d2;">About Our System</h3>
                    <p class="lead">Kings Junior School's digital report system is designed for speed, accuracy, and professionalism. With a modern blue-and-white interface, smooth animations, and robust features, it empowers teachers and admins to manage students, marks, and reports with ease.</p>
                    <ul class="list-unstyled mt-3">
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Dynamic classes, streams, and subjects</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Editable grading and comments</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Secure, role-based access</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Responsive and mobile-friendly</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4" style="background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); color: white;">
        <div class="container">
            <h4>KING'S JUNIOR SCHOOL</h4>
            <p>P.O. Box 11413 Wakiso | Tel: 0708441411 | 0703460226</p>
            <p>GAYAZA MANYANGWA KIWALE</p>
            <p><em>"We Hold The Future"</em></p>
            <p class="mt-3">© All rights reserved 2025 | Created by Hassan Mugisha</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 