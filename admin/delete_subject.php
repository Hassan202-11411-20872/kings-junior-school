<?php
require_once '../includes/db.php';
$id = $_GET['id'] ?? 0;
$pdo->prepare('DELETE FROM subjects WHERE id = ?')->execute([$id]);
header('Location: subjects.php');
exit; 