<?php
include '../includes/header.php';
require_once '../includes/db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM subjects WHERE id = ?');
$stmt->execute([$id]);
$subject = $stmt->fetch();
if (!$subject) {
    echo '<div class="alert alert-danger">Subject not found.</div>';
    include '../includes/footer.php';
    exit;
}
$classes = $pdo->query('SELECT * FROM classes ORDER BY section, class_name')->fetchAll();
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'];
    $subject_name = trim($_POST['subject_name']);
    $is_core = isset($_POST['is_core']) ? 1 : 0;
    $max_score = $_POST['max_score'] ?: 100;
    $stmt = $pdo->prepare('UPDATE subjects SET class_id=?, subject_name=?, is_core=?, max_score=? WHERE id=?');
    try {
        $stmt->execute([$class_id, $subject_name, $is_core, $max_score, $id]);
        $success = 'Subject updated successfully!';
        // Refresh subject data
        $stmt = $pdo->prepare('SELECT * FROM subjects WHERE id = ?');
        $stmt->execute([$id]);
        $subject = $stmt->fetch();
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Edit Subject</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:500px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Class</label>
            <select name="class_id" class="form-select" required>
                <option value="">Select Class</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php if ($subject['class_id'] == $c['id']) echo 'selected'; ?>><?php echo $c['class_name'] . ' (' . $c['section'] . ')'; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" name="subject_name" class="form-control" value="<?php echo htmlspecialchars($subject['subject_name']); ?>" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_core" class="form-check-input" id="is_core" <?php if ($subject['is_core']) echo 'checked'; ?>>
            <label class="form-check-label" for="is_core">Is Core Subject</label>
        </div>
        <div class="mb-3">
            <label class="form-label">Max Score</label>
            <input type="number" name="max_score" class="form-control" value="<?php echo htmlspecialchars($subject['max_score']); ?>" min="1" max="400">
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Subject</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 