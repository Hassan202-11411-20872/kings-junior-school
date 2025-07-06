<?php
require_once '../includes/db.php';
require_once '../includes/audit.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$stmt->execute([$id]);
$student = $stmt->fetch();
if ($student) {
    // Log the deletion before removing the student
    $details = [
        'student_id' => $student['id'],
        'admission_number' => $student['admission_number'],
        'school_pay_number' => $student['school_pay_number'],
        'full_name' => $student['full_name'],
        'class_id' => $student['class_id'],
        'session' => $student['session']
    ];
    logAuditAction($pdo, 'delete_student', "Deleted student: {$student['full_name']} ({$student['admission_number']})", $details);
    
    if ($student['photo_path'] && file_exists('../../' . $student['photo_path'])) {
        unlink('../../' . $student['photo_path']);
    }
    $pdo->prepare('DELETE FROM students WHERE id = ?')->execute([$id]);
}
header('Location: students.php');
exit; 