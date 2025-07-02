<?php
require_once '../includes/db.php';
$id = $_GET['id'] ?? 0;
$pdo->prepare('DELETE FROM grading_scale WHERE id = ?')->execute([$id]);
header('Location: grading.php');
exit; 