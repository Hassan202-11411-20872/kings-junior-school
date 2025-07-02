<?php
include '../includes/header.php';
require_once '../includes/db.php';
// Fetch classes and terms
$classes = $pdo->query('SELECT * FROM classes ORDER BY section, class_name')->fetchAll();
$terms = $pdo->query('SELECT * FROM terms ORDER BY year DESC, name DESC')->fetchAll();
$class_id = $_GET['class_id'] ?? '';
$stream = $_GET['stream'] ?? '';
$term_id = $_GET['term_id'] ?? '';
$exam_type = $_GET['exam_type'] ?? 'Mid Term';
$subjects = [];
$students = [];
if ($class_id && $term_id) {
    $subjects = $pdo->prepare('SELECT * FROM subjects WHERE class_id = ?');
    $subjects->execute([$class_id]);
    $subjects = $subjects->fetchAll();
    $students = $pdo->prepare('SELECT * FROM students WHERE class_id = ?' . ($stream ? ' AND stream = ?' : ''));
    $students->execute($stream ? [$class_id, $stream] : [$class_id]);
    $students = $students->fetchAll();
}
// Handle marks submission
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marks'])) {
    foreach ($_POST['marks'] as $student_id => $subject_marks) {
        foreach ($subject_marks as $subject_id => $data) {
            $marks = $data['score'];
            $remarks = $data['remarks'];
            $stmt = $pdo->prepare('SELECT id FROM marks WHERE student_id=? AND subject_id=? AND term_id=? AND exam_type=?');
            $stmt->execute([$student_id, $subject_id, $term_id, $exam_type]);
            if ($stmt->fetch()) {
                $stmt = $pdo->prepare('UPDATE marks SET marks=?, remarks=? WHERE student_id=? AND subject_id=? AND term_id=? AND exam_type=?');
                $stmt->execute([$marks, $remarks, $student_id, $subject_id, $term_id, $exam_type]);
            } else {
                $stmt = $pdo->prepare('INSERT INTO marks (student_id, subject_id, term_id, exam_type, marks, remarks, recorded_by) VALUES (?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$student_id, $subject_id, $term_id, $exam_type, $marks, $remarks, $_SESSION['user_id']]);
            }
        }
    }
    $success = 'Marks saved successfully!';
}
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Marks Entry</h2>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
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
    <?php if ($class_id && $term_id && $subjects && $students): ?>
    <form method="post">
        <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
        <input type="hidden" name="term_id" value="<?php echo $term_id; ?>">
        <input type="hidden" name="exam_type" value="<?php echo htmlspecialchars($exam_type); ?>">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>Student</th>
                        <?php foreach ($subjects as $subject): ?>
                            <th><?php echo htmlspecialchars($subject['subject_name']); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                        <?php foreach ($subjects as $subject): ?>
                        <td style="min-width:120px">
                            <input type="number" name="marks[<?php echo $student['id']; ?>][<?php echo $subject['id']; ?>][score]" class="form-control mb-1" placeholder="Score" min="0" max="<?php echo $subject['max_score']; ?>">
                            <input type="text" name="marks[<?php echo $student['id']; ?>][<?php echo $subject['id']; ?>][remarks]" class="form-control" placeholder="Remarks">
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary w-100">Save Marks</button>
    </form>
    <?php elseif ($class_id && $term_id): ?>
        <div class="alert alert-warning">No students or subjects found for this class/stream.</div>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?> 