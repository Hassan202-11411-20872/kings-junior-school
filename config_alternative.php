<?php
// Alternative Database Configuration for InfinityFree Hosting
// Try these different settings if the main config doesn't work

// Option 1: Standard InfinityFree settings
$host = 'sql.infinityfree.com';
$db   = 'if0_39379715_kings_junior_school';
$user = 'if0_39379715';
$pass = 'QiTeM1DYDPz';
$charset = 'utf8mb4';

// Option 2: Try localhost instead of sql.infinityfree.com
// Uncomment these lines if Option 1 doesn't work:
// $host = 'localhost';
// $db   = 'if0_39379715_kings_junior_school';
// $user = 'if0_39379715';
// $pass = 'QiTeM1DYDPz';

// Option 3: Try without the prefix
// Uncomment these lines if Option 1 and 2 don't work:
// $host = 'sql.infinityfree.com';
// $db   = 'kings_junior_school';
// $user = 'if0_39379715';
// $pass = 'QiTeM1DYDPz';

// Application Configuration
define('APP_NAME', 'Kings Junior School Management System');
define('APP_VERSION', '1.0.0');
define('APP_URL', 'https://www.kingsjunior.rf.gd');

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