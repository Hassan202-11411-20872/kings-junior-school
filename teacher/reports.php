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
$terms = $pdo->query('SELECT * FROM terms ORDER BY year DESC, name DESC')->fetchAll();
$term_id = $_GET['term_id'] ?? '';
$exam_type = $_GET['exam_type'] ?? 'Mid Term';
$subjects = [];
$marks = [];
if ($class_id && $term_id) {
    $students = $pdo->prepare('SELECT * FROM students WHERE class_id = ?');
    $students->execute([$class_id]);
    $students = $students->fetchAll();
    $class = $pdo->prepare('SELECT * FROM classes WHERE id = ?');
    $class->execute([$class_id]);
    $class = $class->fetch();
    $subjects = $pdo->prepare('SELECT * FROM subjects WHERE class_id = ?');
    $subjects->execute([$class_id]);
    $subjects = $subjects->fetchAll();
    // Fetch marks for all students in this class, term, and exam type
    $marks_stmt = $pdo->prepare('SELECT * FROM marks WHERE student_id = ? AND term_id = ? AND exam_type = ? AND subject_id = ?');
}
?>
<div class="no-print my-3">
    <a href="dashboard.php" class="btn btn-secondary">&larr; Back to Dashboard</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Class Reports</h2>
    <form class="row g-3 mb-4" method="get">
        <div class="col-md-4">
            <select name="term_id" class="form-select" required onchange="this.form.submit()">
                <option value="">Select Term</option>
                <?php foreach ($terms as $t): ?>
                    <option value="<?php echo $t['id']; ?>" <?php if ($term_id == $t['id']) echo 'selected'; ?>><?php echo $t['name'] . ' ' . $t['year']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <select name="exam_type" class="form-select" onchange="this.form.submit()">
                <option value="Mid Term" <?php if ($exam_type == 'Mid Term') echo 'selected'; ?>>Mid Term</option>
                <option value="End Term" <?php if ($exam_type == 'End Term') echo 'selected'; ?>>End Term</option>
            </select>
        </div>
    </form>
    <?php if ($class && $term_id && $subjects && $students): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Student</th>
                    <?php foreach ($subjects as $subject): ?>
                        <th><?php echo htmlspecialchars($subject['subject_name']); ?></th>
                    <?php endforeach; ?>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                    <?php
                    $total = 0;
                    foreach ($subjects as $subject):
                        $marks_stmt->execute([$student['id'], $term_id, $exam_type, $subject['id']]);
                        $mark = $marks_stmt->fetch();
                        $score = $mark ? $mark['marks'] : '-';
                        if ($mark) $total += $mark['marks'];
                    ?>
                        <td><?php echo htmlspecialchars($score); ?></td>
                    <?php endforeach; ?>
                    <td><strong><?php echo $total; ?></strong></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php elseif (!$class_id): ?>
        <div class="alert alert-info">You are not assigned to any class. Please contact the admin.</div>
    <?php elseif ($class && $term_id): ?>
        <div class="alert alert-warning">No students or subjects found for your class.</div>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?> 