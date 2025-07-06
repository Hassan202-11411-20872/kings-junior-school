<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../login.php');
    exit;
}
?>
<?php
include '../includes/header.php';
require_once '../includes/db.php';
$user_id = $_SESSION['user_id'] ?? 0;
// Get teacher info
$teacher = $pdo->prepare('SELECT * FROM teachers WHERE user_id = ?');
$teacher->execute([$user_id]);
$teacher = $teacher->fetch();
$assigned_class = '';
if ($teacher && $teacher['class_id']) {
    $class = $pdo->prepare('SELECT * FROM classes WHERE id = ?');
    $class->execute([$teacher['class_id']]);
    $class = $class->fetch();
    $assigned_class = $class['class_name'] . ' (' . $class['section'] . ')';
}
// Fetch full name of the logged-in user
$user = $pdo->prepare('SELECT full_name FROM users WHERE id = ?');
$user->execute([$user_id]);
$user = $user->fetch();
$full_name = $user ? $user['full_name'] : '';
?>
<div class="container py-5">
    <div class="mb-4">
        <h4 class="text-success">Welcome Back Tr. <?php echo htmlspecialchars($full_name); ?>!</h4>
    </div>
    <h2 class="mb-4 text-primary">Teacher Dashboard</h2>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Assigned Class</h5>
                    <p class="display-6 fw-bold text-primary"><?php echo $assigned_class ?: 'Not Assigned'; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <a href="marks.php" class="btn btn-primary w-100 py-3">Enter Marks</a>
        </div>
        <div class="col-md-4">
            <a href="students.php" class="btn btn-outline-primary w-100 py-3">View Students</a>
        </div>
        <div class="col-md-4 mt-3">
            <a href="reports.php" class="btn btn-outline-primary w-100 py-3">Generate Reports</a>
        </div>
        <div class="col-md-4">
            <a href="print_report.php" class="btn btn-success">Print Report Card</a>
        </div>
    </div>
    <div class="no-print text-end my-3">
        <a href="../logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 