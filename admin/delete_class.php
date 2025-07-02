<?php
require_once '../includes/db.php';
$id = $_GET['id'] ?? 0;
$pdo->prepare('DELETE FROM classes WHERE id = ?')->execute([$id]);
header('Location: classes.php');
exit; 