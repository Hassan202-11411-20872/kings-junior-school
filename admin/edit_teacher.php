<?php
include '../includes/header.php';
require_once '../includes/db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM teachers WHERE id = ?');
$stmt->execute([$id]);
$teacher = $stmt->fetch();
if (!$teacher) {
    echo '<div class="alert alert-danger">Teacher assignment not found.</div>';
    include '../includes/footer.php';
    exit;
}
$users = $pdo->query("SELECT * FROM users WHERE role='teacher'")->fetchAll();
$classes = $pdo->query('SELECT * FROM classes')->fetchAll();
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'] ?: null;
    $initials = trim($_POST['initials']);
    $subjects = trim($_POST['subjects']);
    $stmt = $pdo->prepare('UPDATE teachers SET class_id=?, initials=?, subjects=? WHERE id=?');
    try {
        $stmt->execute([$class_id, $initials, $subjects, $id]);
        $success = 'Teacher assignment updated!';
        // Refresh teacher data
        $stmt = $pdo->prepare('SELECT * FROM teachers WHERE id = ?');
        $stmt->execute([$id]);
        $teacher = $stmt->fetch();
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Edit Teacher Assignment</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:600px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Initials</label>
            <input type="text" name="initials" class="form-control" value="<?php echo htmlspecialchars($teacher['initials']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Assign Class</label>
            <select name="class_id" class="form-select">
                <option value="">None</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php if ($teacher['class_id'] == $c['id']) echo 'selected'; ?>><?php echo $c['class_name'] . ' (' . $c['section'] . ')'; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Subjects (comma-separated)</label>
            <input type="text" name="subjects" class="form-control" value="<?php echo htmlspecialchars($teacher['subjects']); ?>">
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Assignment</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 