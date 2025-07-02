<?php
include '../includes/header.php';
require_once '../includes/db.php';
// Fetch users with role teacher
$users = $pdo->query("SELECT * FROM users WHERE role='teacher'")->fetchAll();
$classes = $pdo->query('SELECT * FROM classes')->fetchAll();
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $class_id = $_POST['class_id'] ?: null;
    $initials = trim($_POST['initials']);
    $subjects = trim($_POST['subjects']);
    $stmt = $pdo->prepare('INSERT INTO teachers (user_id, class_id, initials, subjects) VALUES (?, ?, ?, ?)');
    try {
        $stmt->execute([$user_id, $class_id, $initials, $subjects]);
        $success = 'Teacher assignment added!';
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Add Teacher Assignment</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:600px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">User (Teacher)</label>
            <select name="user_id" class="form-select" required>
                <option value="">Select Teacher</option>
                <?php foreach ($users as $u): ?>
                    <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['full_name'] . ' (' . $u['username'] . ')'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Initials</label>
            <input type="text" name="initials" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Assign Class</label>
            <select name="class_id" class="form-select">
                <option value="">None</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['class_name'] . ' (' . $c['section'] . ')'; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Subjects (comma-separated)</label>
            <input type="text" name="subjects" class="form-control" placeholder="e.g. Math, English">
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Assignment</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 