<?php
/**
 * Kings Junior School Management System
 * Entry point for web application
 */

// Set error reporting for production
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Start session
session_start();

// Include the main application
require_once '../includes/header.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Redirect based on user role
if ($_SESSION['role'] === 'admin') {
    header('Location: admin/dashboard.php');
} elseif ($_SESSION['role'] === 'teacher') {
    header('Location: teacher/dashboard.php');
} else {
    header('Location: login.php');
}
exit; 