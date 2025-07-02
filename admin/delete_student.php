<?php
require_once '../includes/db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$stmt->execute([$id]);
$student = $stmt->fetch();
if ($student) {
    if ($student['photo_path'] && file_exists('../../' . $student['photo_path'])) {
        unlink('../../' . $student['photo_path']);
    }
    $pdo->prepare('DELETE FROM students WHERE id = ?')->execute([$id]);
}
header('Location: students.php');
exit; 