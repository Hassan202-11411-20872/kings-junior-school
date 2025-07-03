<?php
include '../includes/header.php';
require_once '../includes/db.php';
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $min_mark = $_POST['min_mark'];
    $max_mark = $_POST['max_mark'];
    $grade = trim($_POST['grade']);
    $remark = trim($_POST['remark']);
    $division = $_POST['division'] ?: null;
    $stmt = $pdo->prepare('INSERT INTO grading_scale (min_mark, max_mark, grade, remark, division) VALUES (?, ?, ?, ?, ?)');
    try {
        $stmt->execute([$min_mark, $max_mark, $grade, $remark, $division]);
        $success = 'Grading entry added!';
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<div class="no-print my-3">
    <a href="grading.php" class="btn btn-secondary">&larr; Back to Grading</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Add Grading Entry</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:500px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Min Mark</label>
            <input type="number" name="min_mark" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Max Mark</label>
            <input type="number" name="max_mark" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Grade</label>
            <input type="text" name="grade" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Remark</label>
            <input type="text" name="remark" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Division</label>
            <input type="number" name="division" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Grading Entry</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 