<?php
require_once '../includes/db.php';
$id = $_GET['id'] ?? 0;
$pdo->prepare('DELETE FROM teachers WHERE id = ?')->execute([$id]);
header('Location: teachers.php');
exit; 