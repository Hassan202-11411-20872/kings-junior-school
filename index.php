<?php
include 'includes/header.php';
?>
<!-- Hero Section -->
<div class="hero-section text-center py-5 position-relative" style="overflow:hidden;">
    <img src="assets/images/logo.png" alt="Kings Junior School Logo" style="width:120px; animation: bounceIn 1s;">
    <h1 class="display-4 mt-3 fw-bold animated-title">Kings Junior School</h1>
    <h2 class="mb-4 animated-subtitle">Students Report Generation System</h2>
    <a href="login.php" class="btn btn-primary btn-lg mx-2 shadow animated-cta">Login</a>
    <a href="register.php" class="btn btn-outline-primary btn-lg mx-2 shadow animated-cta">Register</a>
    <div class="animated-waves">
        <svg viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg" style="width:100%;height:60px;display:block;">
            <path id="wavePath" d="M0,30 Q360,60 720,30 T1440,30 V60 H0 Z" fill="#1976d2">
                <animate attributeName="d" dur="6s" repeatCount="indefinite"
                    values="M0,30 Q360,60 720,30 T1440,30 V60 H0 Z;
                            M0,30 Q360,0 720,30 T1440,30 V60 H0 Z;
                            M0,30 Q360,60 720,30 T1440,30 V60 H0 Z" />
            </path>
        </svg>
    </div>
</div>
<!-- Features Section -->
<section class="features-section py-5 bg-light">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card feature-card text-center shadow h-100 animated-card">
                    <div class="card-body">
                        <div class="feature-icon mb-3"><i class="bi bi-person-plus-fill"></i></div>
                        <h5 class="card-title">Easy Student Registration</h5>
                        <p class="card-text">Register students one by one or in bulk, including photo upload and parent details.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card text-center shadow h-100 animated-card">
                    <div class="card-body">
                        <div class="feature-icon mb-3"><i class="bi bi-pencil-square"></i></div>
                        <h5 class="card-title">Quick Marks Entry</h5>
                        <p class="card-text">Teachers can easily input marks for all subjects, with per-subject remarks and auto-grading.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card text-center shadow h-100 animated-card">
                    <div class="card-body">
                        <div class="feature-icon mb-3"><i class="bi bi-file-earmark-bar-graph"></i></div>
                        <h5 class="card-title">Professional Report Cards</h5>
                        <p class="card-text">Generate, print, and export beautiful report cards for single or all students, with school branding.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section -->
<section class="about-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="assets/images/logo.png" alt="Kings Junior School Logo" class="img-fluid rounded shadow animated-about-img" style="max-width:300px;">
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold mb-3">About Our System</h3>
                <p class="lead">Kings Junior School's digital report system is designed for speed, accuracy, and professionalism. With a modern blue-and-white interface, smooth animations, and robust features, it empowers teachers and admins to manage students, marks, and reports with ease.</p>
                <ul class="list-unstyled mt-3">
                    <li><i class="bi bi-check-circle-fill text-primary"></i> Dynamic classes, streams, and subjects</li>
                    <li><i class="bi bi-check-circle-fill text-primary"></i> Editable grading and comments</li>
                    <li><i class="bi bi-check-circle-fill text-primary"></i> Secure, role-based access</li>
                    <li><i class="bi bi-check-circle-fill text-primary"></i> Responsive and mobile-friendly</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php
include 'includes/footer.php';
?>
<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
.hero-section {
    background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
    color: #fff;
    border-radius: 0 0 40px 40px;
    box-shadow: 0 8px 32px rgba(25, 118, 210, 0.2);
    animation: fadeInDown 1s;
    position: relative;
    z-index: 2;
}
.animated-title {
    animation: fadeInUp 1.2s 0.2s both;
}
.animated-subtitle {
    animation: fadeInUp 1.2s 0.4s both;
}
.animated-cta {
    animation: bounceIn 1.2s 0.6s both;
}
.animated-waves {
    position: absolute;
    left: 0; right: 0; bottom: -1px;
    width: 100%;
    z-index: 1;
}
.features-section {
    background: #f5faff;
    border-radius: 24px;
    margin: 2rem auto;
    box-shadow: 0 2px 12px rgba(25, 118, 210, 0.06);
    max-width: 1200px;
}
.feature-card {
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(25, 118, 210, 0.10);
    transition: transform 0.2s, box-shadow 0.2s;
    background: #fff;
    cursor: pointer;
}
.feature-card:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 8px 32px rgba(25, 118, 210, 0.18);
}
.feature-icon {
    font-size: 2.5rem;
    color: #1976d2;
    animation: pulseIcon 2s infinite alternate;
}
@keyframes pulseIcon {
    from { text-shadow: 0 0 8px #42a5f5; }
    to { text-shadow: 0 0 24px #1976d2; }
}
.animated-card {
    animation: fadeInUp 1.2s both;
}
.animated-about-img {
    animation: bounceIn 1.2s both;
}
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-40px); }
    to { opacity: 1; transform: translateY(0); }
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
</style> 