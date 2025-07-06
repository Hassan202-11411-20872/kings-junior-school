<?php
require_once '../includes/db.php';
$total = isset($_GET['total']) ? (int)$_GET['total'] : 0;
$pdo->prepare('DELETE FROM major_subject_comments WHERE total = ?')->execute([$total]);
header('Location: comments.php');
exit; 