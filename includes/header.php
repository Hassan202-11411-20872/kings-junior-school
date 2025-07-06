<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kings Junior School Report System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="assets/images/favicon_io/favicon.ico">
</head>
<body>
<!-- Modern Centered Header Start -->
<header class="main-header">
    <div class="header-content">
        <img src="/kjs/assets/images/logo.png" alt="Kings Junior School Logo" class="school-logo">
        <h1 class="school-title">KING'S JUNIOR SCHOOL</h1>
        <p class="school-tagline">"We Hold The Future"</p>
    </div>
    <nav class="main-nav">
        <ul class="nav-list">
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>
</header>
<style>
.main-header {
    width: 100%;
    background: linear-gradient(135deg, #0a58ca 0%, #0d6efd 100%);
    padding: 32px 0 0 0;
    box-shadow: 0 2px 8px rgba(10, 88, 202, 0.08);
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 10;
}
.header-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}
.school-logo {
    width: 120px;
    height: 120px;
    object-fit: cover;
    margin-bottom: 10px;
    clip-path: polygon(25% 6%, 75% 6%, 100% 50%, 75% 94%, 25% 94%, 0% 50%);
    background: none;
    /* Wavy and glowing animation */
    animation: hex-wave-glow 2.5s ease-in-out infinite;
    box-shadow: 0 0 0px 0px #0d6efd;
}
@keyframes hex-wave-glow {
    0% {
        transform: scale(1) skewY(0deg);
        box-shadow: 0 0 0px 0px #0d6efd;
    }
    20% {
        transform: scale(1.04, 0.96) skewY(-2deg);
        box-shadow: 0 0 12px 4px #0d6efd66;
    }
    40% {
        transform: scale(0.98, 1.02) skewY(2deg);
        box-shadow: 0 0 18px 8px #0d6efd99;
    }
    60% {
        transform: scale(1.04, 0.96) skewY(-2deg);
        box-shadow: 0 0 12px 4px #0d6efd66;
    }
    80% {
        transform: scale(1.01, 0.99) skewY(1deg);
        box-shadow: 0 0 8px 2px #0d6efd44;
    }
    100% {
        transform: scale(1) skewY(0deg);
        box-shadow: 0 0 0px 0px #0d6efd;
    }
}
.school-title {
    color: #fff;
    font-size: 2rem;
    font-weight: bold;
    margin: 0 0 6px 0;
    text-shadow: 0 2px 8px rgba(0,0,0,0.12);
    letter-spacing: 1px;
}
.school-tagline {
    color: #e3eaff;
    font-size: 1.1rem;
    font-style: italic;
    margin: 0 0 18px 0;
    text-shadow: 0 1px 4px rgba(10, 88, 202, 0.10);
}
.main-nav {
    width: 100%;
    display: flex;
    justify-content: center;
    margin-bottom: 10px;
}
.nav-list {
    list-style: none;
    display: flex;
    gap: 32px;
    padding: 0;
    margin: 0;
}
.nav-list li {
    display: inline-block;
}
.nav-list a {
    color: #fff;
    font-weight: 500;
    text-decoration: none;
    font-size: 1.08rem;
    padding: 8px 18px;
    border-radius: 22px;
    transition: background 0.2s, color 0.2s;
}
.nav-list a:hover, .nav-list a:focus {
    background: rgba(255,255,255,0.18);
    color: #ffe066;
}
@media (max-width: 600px) {
    .main-header { padding: 18px 0 0 0; }
    .school-logo { width: 80px; height: 80px; }
    .school-title { font-size: 1.2rem; }
    .school-tagline { font-size: 0.95rem; }
    .nav-list { gap: 12px; }
    .nav-list a { font-size: 0.98rem; padding: 6px 10px; }
}
</style>
<!-- Modern Centered Header End -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 