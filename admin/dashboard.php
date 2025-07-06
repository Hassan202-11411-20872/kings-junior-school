<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
?>
<?php
include '../includes/header.php';
require_once '../includes/db.php';
// Fetch full name of the logged-in user
$user_id = $_SESSION['user_id'];
$user = $pdo->prepare('SELECT full_name FROM users WHERE id = ?');
$user->execute([$user_id]);
$user = $user->fetch();
$full_name = $user ? $user['full_name'] : '';
// Get counts
$students = $pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
$teachers = $pdo->query('SELECT COUNT(*) FROM teachers')->fetchColumn();
$classes = $pdo->query('SELECT COUNT(*) FROM classes')->fetchColumn();
$subjects = $pdo->query('SELECT COUNT(*) FROM subjects')->fetchColumn();
$terms = $pdo->query('SELECT COUNT(*) FROM terms')->fetchColumn();
?>
<div class="container py-5">
    <div class="mb-4">
        <h4 class="text-success">Welcome Back Tr. <?php echo htmlspecialchars($full_name); ?>!</h4>
    </div>
    <h2 class="mb-4 text-primary">Admin Dashboard</h2>
    <div class="no-print text-end my-3">
        <a href="../logout.php" class="btn btn-danger">Logout</a>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Students</h5>
                    <p class="display-6 fw-bold text-primary"><?php echo $students; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Teachers</h5>
                    <p class="display-6 fw-bold text-primary"><?php echo $teachers; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Classes</h5>
                    <p class="display-6 fw-bold text-primary"><?php echo $classes; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Subjects</h5>
                    <p class="display-6 fw-bold text-primary"><?php echo $subjects; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Terms</h5>
                    <p class="display-6 fw-bold text-primary"><?php echo $terms; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-3">
            <a href="students.php" class="btn btn-primary w-100 py-3">Manage Students</a>
        </div>
        <div class="col-md-3">
            <a href="teachers.php" class="btn btn-primary w-100 py-3">Manage Teachers</a>
        </div>
        <div class="col-md-3">
            <a href="classes.php" class="btn btn-primary w-100 py-3">Manage Classes</a>
        </div>
        <div class="col-md-3">
            <a href="subjects.php" class="btn btn-primary w-100 py-3">Manage Subjects</a>
        </div>
        <div class="col-md-3">
            <a href="terms.php" class="btn btn-primary w-100 py-3">Manage Terms</a>
        </div>
        <div class="col-md-3 mt-3">
            <a href="marks.php" class="btn btn-outline-primary w-100 py-3">Enter/View Marks</a>
        </div>
        <div class="col-md-3 mt-3">
            <a href="grading.php" class="btn btn-outline-primary w-100 py-3">Grading Scale</a>
        </div>
        <div class="col-md-3 mt-3">
            <a href="comments.php" class="btn btn-outline-primary w-100 py-3">Comments</a>
        </div>
        <div class="col-md-3 mt-3">
            <a href="reports.php" class="btn btn-success w-100 py-3">Reports</a>
        </div>
        <div class="col-md-3 mt-3">
            <a href="promote_students.php" class="btn btn-warning w-100 py-3">Promote Students</a>
        </div>
        <div class="col-md-3 mt-3">
            <a href="audit_logs.php" class="btn btn-info w-100 py-3">Audit Logs</a>
        </div>
        <div class="col-md-3 mt-3">
            <a href="academic_years.php" class="btn btn-outline-warning w-100 py-3">Academic Years</a>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 