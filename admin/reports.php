<?php
include '../includes/header.php';
require_once '../includes/db.php';
$classes = $pdo->query('SELECT * FROM classes ORDER BY section, class_name')->fetchAll();
$terms = $pdo->query('SELECT * FROM terms ORDER BY year DESC, name DESC')->fetchAll();
$class_id = $_GET['class_id'] ?? '';
$stream = $_GET['stream'] ?? '';
$term_id = $_GET['term_id'] ?? '';
$exam_type = $_GET['exam_type'] ?? 'Mid Term';
$students = [];
if ($class_id && $term_id) {
    $students = $pdo->prepare('SELECT * FROM students WHERE class_id = ?' . ($stream ? ' AND stream = ?' : ''));
    $students->execute($stream ? [$class_id, $stream] : [$class_id]);
    $students = $students->fetchAll();
}
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Report Card Generation</h2>
    <form class="row g-3 mb-4" method="get">
        <div class="col-md-3">
            <select name="class_id" class="form-select" required onchange="this.form.submit()">
                <option value="">Select Class</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php if ($class_id == $c['id']) echo 'selected'; ?>><?php echo $c['class_name'] . ' (' . $c['section'] . ')'; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="text" name="stream" class="form-control" placeholder="Stream (optional)" value="<?php echo htmlspecialchars($stream); ?>">
        </div>
        <div class="col-md-3">
            <select name="term_id" class="form-select" required onchange="this.form.submit()">
                <option value="">Select Term</option>
                <?php foreach ($terms as $t): ?>
                    <option value="<?php echo $t['id']; ?>" <?php if ($term_id == $t['id']) echo 'selected'; ?>><?php echo $t['name'] . ' ' . $t['year']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="exam_type" class="form-select" onchange="this.form.submit()">
                <option value="Mid Term" <?php if ($exam_type == 'Mid Term') echo 'selected'; ?>>Mid Term</option>
                <option value="End Term" <?php if ($exam_type == 'End Term') echo 'selected'; ?>>End Term</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary w-100">Load</button>
        </div>
    </form>
    <?php if ($class_id && $term_id && $students): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Photo</th>
                    <th>Admission #</th>
                    <th>Full Name</th>
                    <th>Stream</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><img src="../<?php echo $student['photo_path'] ?: 'assets/images/logo-e.png'; ?>" alt="Photo" style="width:40px; height:40px; object-fit:cover; border-radius:50%;"></td>
                    <td><?php echo htmlspecialchars($student['admission_number']); ?></td>
                    <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['stream']); ?></td>
                    <td>
                        <a href="print_report.php?student_id=<?php echo $student['id']; ?>&term_id=<?php echo $term_id; ?>&exam_type=<?php echo urlencode($exam_type); ?>" class="btn btn-sm btn-outline-primary" target="_blank">Print/Export Report</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        <a href="print_report.php?class_id=<?php echo $class_id; ?>&term_id=<?php echo $term_id; ?>&exam_type=<?php echo urlencode($exam_type); ?>&bulk=1" class="btn btn-success btn-lg" target="_blank">Bulk Print/Export All Reports</a>
    </div>
    <?php elseif ($class_id && $term_id): ?>
        <div class="alert alert-warning">No students found for this class/stream.</div>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?> 