<?php
include '../includes/header.php';
require_once '../includes/db.php';
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $section = $_POST['section'];
    $class_name = trim($_POST['class_name']);
    $stream = trim($_POST['stream']);
    $has_streams = isset($_POST['has_streams']) ? 1 : 0;
    $stmt = $pdo->prepare('INSERT INTO classes (section, class_name, stream, has_streams) VALUES (?, ?, ?, ?)');
    try {
        $stmt->execute([$section, $class_name, $stream, $has_streams]);
        $success = 'Class added successfully!';
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Add Class</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:500px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Section</label>
            <select name="section" class="form-select" required>
                <option value="">Select Section</option>
                <option value="Nursery">Nursery</option>
                <option value="Lower Primary">Lower Primary</option>
                <option value="Upper Primary">Upper Primary</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Class Name</label>
            <input type="text" name="class_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Stream</label>
            <input type="text" name="stream" class="form-control">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="has_streams" class="form-check-input" id="has_streams">
            <label class="form-check-label" for="has_streams">Has Streams</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Class</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 