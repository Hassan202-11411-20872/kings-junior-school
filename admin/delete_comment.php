<?php
require_once '../includes/db.php';
$id = $_GET['id'] ?? 0;
$pdo->prepare('DELETE FROM comments WHERE id = ?')->execute([$id]);
header('Location: comments.php');
exit; 