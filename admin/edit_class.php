<?php
include '../includes/header.php';
require_once '../includes/db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM classes WHERE id = ?');
$stmt->execute([$id]);
$class = $stmt->fetch();
if (!$class) {
    echo '<div class="alert alert-danger">Class not found.</div>';
    include '../includes/footer.php';
    exit;
}
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section = $_POST['section'];
    $class_name = trim($_POST['class_name']);
    $stream = trim($_POST['stream']);
    $has_streams = isset($_POST['has_streams']) ? 1 : 0;
    $stmt = $pdo->prepare('UPDATE classes SET section=?, class_name=?, stream=?, has_streams=? WHERE id=?');
    try {
        $stmt->execute([$section, $class_name, $stream, $has_streams, $id]);
        $success = 'Class updated successfully!';
        // Refresh class data
        $stmt = $pdo->prepare('SELECT * FROM classes WHERE id = ?');
        $stmt->execute([$id]);
        $class = $stmt->fetch();
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Edit Class</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:500px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Section</label>
            <select name="section" class="form-select" required>
                <option value="">Select Section</option>
                <option value="Nursery" <?php if ($class['section'] == 'Nursery') echo 'selected'; ?>>Nursery</option>
                <option value="Lower Primary" <?php if ($class['section'] == 'Lower Primary') echo 'selected'; ?>>Lower Primary</option>
                <option value="Upper Primary" <?php if ($class['section'] == 'Upper Primary') echo 'selected'; ?>>Upper Primary</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Class Name</label>
            <input type="text" name="class_name" class="form-control" value="<?php echo htmlspecialchars($class['class_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stream</label>
            <input type="text" name="stream" class="form-control" value="<?php echo htmlspecialchars($class['stream']); ?>">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="has_streams" class="form-check-input" id="has_streams" <?php if ($class['has_streams']) echo 'checked'; ?>>
            <label class="form-check-label" for="has_streams">Has Streams</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Class</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 