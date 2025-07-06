<?php
// Desktop compatibility test
echo "<h1>Desktop Compatibility Test</h1>";
echo "<p>Testing: kingsjunior.rf.gd</p>";

// Check basic PHP functionality
echo "<h2>PHP Information</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";

// Check if config file exists
echo "<h2>Configuration Check</h2>";
if (file_exists('config.php')) {
    echo "✅ config.php exists<br>";
    include 'config.php';
    echo "✅ Config loaded successfully<br>";
} else {
    echo "❌ config.php missing<br>";
}

// Check database connection
echo "<h2>Database Connection</h2>";
if (file_exists('includes/db.php')) {
    try {
        include 'includes/db.php';
        echo "✅ Database connection successful<br>";
    } catch (Exception $e) {
        echo "❌ Database error: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ includes/db.php missing<br>";
}

// Check file permissions
echo "<h2>File Permissions</h2>";
$files_to_check = [
    'index.php',
    'login.php',
    'register.php',
    'assets/css/style.css',
    'assets/images/logo.png'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "✅ $file exists<br>";
        if (is_readable($file)) {
            echo "✅ $file is readable<br>";
        } else {
            echo "❌ $file is NOT readable<br>";
        }
    } else {
        echo "❌ $file missing<br>";
    }
}

// Check for common desktop issues
echo "<h2>Common Desktop Issues</h2>";

// Check if .htaccess exists and is readable
if (file_exists('.htaccess')) {
    echo "✅ .htaccess exists<br>";
} else {
    echo "⚠️ .htaccess missing (may cause routing issues)<br>";
}

// Check for index.php redirect issues
echo "<h2>Index File Check</h2>";
if (file_exists('index.php')) {
    echo "✅ index.php exists<br>";
    $index_content = file_get_contents('index.php');
    if (strpos($index_content, '<?php') !== false) {
        echo "✅ index.php contains PHP code<br>";
    } else {
        echo "❌ index.php may be empty or corrupted<br>";
    }
} else {
    echo "❌ index.php missing<br>";
}

// Check for JavaScript errors
echo "<h2>Browser Compatibility</h2>";
echo "<p>If you see this page, PHP is working. Check browser console for JavaScript errors.</p>";

// Test basic HTML rendering
echo "<h2>HTML Rendering Test</h2>";
echo "<div style='background: #0a6efd; color: white; padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "✅ If you can see this blue box, HTML rendering is working";
echo "</div>";

// Test CSS
echo "<h2>CSS Test</h2>";
echo "<div style='background: linear-gradient(120deg, #0a6efd 0%, #ffffff 100%); padding: 20px; border-radius: 10px; margin: 20px 0;'>";
echo "✅ If you can see this gradient box, CSS is working";
echo "</div>";

echo "<hr>";
echo "<h2>Quick Links</h2>";
echo "<p><a href='index.php'>Home Page</a></p>";
echo "<p><a href='login.php'>Login Page</a></p>";
echo "<p><a href='register.php'>Register Page</a></p>";
echo "<p><a href='test.php'>Full Diagnostic</a></p>";
?> 