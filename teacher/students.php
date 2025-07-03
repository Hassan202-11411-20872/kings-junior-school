<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../login.php');
    exit;
}
include '../includes/header.php';
require_once '../includes/db.php';

// Get teacher's assigned class
$teacher = $pdo->prepare('SELECT * FROM teachers WHERE user_id = ?');
$teacher->execute([$_SESSION['user_id']]);
$teacher = $teacher->fetch();
$class_id = $teacher['class_id'] ?? '';
$students = [];
$class = null;
if ($class_id) {
    $students = $pdo->prepare('SELECT * FROM students WHERE class_id = ?');
    $students->execute([$class_id]);
    $students = $students->fetchAll();
    $class = $pdo->prepare('SELECT * FROM classes WHERE id = ?');
    $class->execute([$class_id]);
    $class = $class->fetch();
}
?>
<div class="no-print my-3">
    <a href="dashboard.php" class="btn btn-secondary">&larr; Back to Dashboard</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">My Students</h2>
    <?php if ($class): ?>
        <h5>Class: <?php echo htmlspecialchars($class['class_name'] . ' (' . $class['section'] . ')'); ?></h5>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Admission #</th>
                    <th>Full Name</th>
                    <th>Stream</th>
                    <th>Gender</th>
                    <th>Parent Name</th>
                    <th>Parent Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['admission_number']); ?></td>
                    <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['stream']); ?></td>
                    <td><?php echo htmlspecialchars($student['gender']); ?></td>
                    <td><?php echo htmlspecialchars($student['parent_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['parent_phone']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if (!$class_id): ?>
        <div class="alert alert-info">You are not assigned to any class. Please contact the admin.</div>
    <?php elseif (empty($students)): ?>
        <div class="alert alert-warning">No students found for your class.</div>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?> 