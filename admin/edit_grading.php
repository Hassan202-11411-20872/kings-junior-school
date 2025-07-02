<?php
include '../includes/header.php';
require_once '../includes/db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM grading_scale WHERE id = ?');
$stmt->execute([$id]);
$grading = $stmt->fetch();
if (!$grading) {
    echo '<div class="alert alert-danger">Grading entry not found.</div>';
    include '../includes/footer.php';
    exit;
}
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $min_mark = $_POST['min_mark'];
    $max_mark = $_POST['max_mark'];
    $grade = trim($_POST['grade']);
    $remark = trim($_POST['remark']);
    $division = $_POST['division'] ?: null;
    $stmt = $pdo->prepare('UPDATE grading_scale SET min_mark=?, max_mark=?, grade=?, remark=?, division=? WHERE id=?');
    try {
        $stmt->execute([$min_mark, $max_mark, $grade, $remark, $division, $id]);
        $success = 'Grading entry updated!';
        // Refresh grading data
        $stmt = $pdo->prepare('SELECT * FROM grading_scale WHERE id = ?');
        $stmt->execute([$id]);
        $grading = $stmt->fetch();
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Edit Grading Entry</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:500px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Min Mark</label>
            <input type="number" name="min_mark" class="form-control" value="<?php echo htmlspecialchars($grading['min_mark']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Max Mark</label>
            <input type="number" name="max_mark" class="form-control" value="<?php echo htmlspecialchars($grading['max_mark']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Grade</label>
            <input type="text" name="grade" class="form-control" value="<?php echo htmlspecialchars($grading['grade']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Remark</label>
            <input type="text" name="remark" class="form-control" value="<?php echo htmlspecialchars($grading['remark']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Division</label>
            <input type="number" name="division" class="form-control" value="<?php echo htmlspecialchars($grading['division']); ?>">
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Grading Entry</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 