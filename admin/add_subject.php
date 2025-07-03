<?php
include '../includes/header.php';
require_once '../includes/db.php';
$classes = $pdo->query('SELECT * FROM classes ORDER BY section, class_name')->fetchAll();
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'];
    $subject_name = trim($_POST['subject_name']);
    $is_core = isset($_POST['is_core']) ? 1 : 0;
    $max_score = $_POST['max_score'] ?: 100;
    $stmt = $pdo->prepare('INSERT INTO subjects (class_id, subject_name, is_core, max_score) VALUES (?, ?, ?, ?)');
    try {
        $stmt->execute([$class_id, $subject_name, $is_core, $max_score]);
        $success = 'Subject added successfully!';
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<div class="no-print my-3">
    <a href="subjects.php" class="btn btn-secondary">&larr; Back to Subjects</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Add Subject</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:500px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Class</label>
            <select name="class_id" class="form-select" required>
                <option value="">Select Class</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['class_name'] . ' (' . $c['section'] . ')'; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" name="subject_name" class="form-control" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_core" class="form-check-input" id="is_core">
            <label class="form-check-label" for="is_core">Is Core Subject</label>
        </div>
        <div class="mb-3">
            <label class="form-label">Max Score</label>
            <input type="number" name="max_score" class="form-control" value="100" min="1" max="400">
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Subject</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 