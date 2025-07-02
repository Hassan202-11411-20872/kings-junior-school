<?php
// Database Configuration
// Copy this file to config.php and modify the values below
$host = 'localhost';
$db   = 'kings_junior_school';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Application Configuration
define('APP_NAME', 'Kings Junior School Management System');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'http://localhost');

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
?> 