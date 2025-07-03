<?php
include '../includes/header.php';
require_once '../includes/db.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM terms WHERE id = ?');
$stmt->execute([$id]);
$term = $stmt->fetch();

if (!$term) {
    echo '<div class="alert alert-danger">Term not found.</div>';
    include '../includes/footer.php';
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $year = $_POST['year'];
    $start_date = $_POST['start_date'] ?: null;
    $end_date = $_POST['end_date'] ?: null;
    $is_current = isset($_POST['is_current']) ? 1 : 0;
    
    // If this is set as current term, unset all other current terms
    if ($is_current) {
        $pdo->prepare('UPDATE terms SET is_current = 0 WHERE id != ?')->execute([$id]);
    }
    
    $stmt = $pdo->prepare('UPDATE terms SET name=?, year=?, start_date=?, end_date=?, is_current=? WHERE id=?');
    try {
        $stmt->execute([$name, $year, $start_date, $end_date, $is_current, $id]);
        $success = 'Term updated successfully!';
        // Refresh term data
        $stmt = $pdo->prepare('SELECT * FROM terms WHERE id = ?');
        $stmt->execute([$id]);
        $term = $stmt->fetch();
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<div class="no-print my-3">
    <a href="terms.php" class="btn btn-secondary">&larr; Back to Terms</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Edit Academic Term</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:500px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Term Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($term['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Academic Year</label>
            <input type="number" name="year" class="form-control" value="<?php echo htmlspecialchars($term['year']); ?>" min="2020" max="2030" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Start Date (Optional)</label>
            <input type="date" name="start_date" class="form-control" value="<?php echo htmlspecialchars($term['start_date']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">End Date (Optional)</label>
            <input type="date" name="end_date" class="form-control" value="<?php echo htmlspecialchars($term['end_date']); ?>">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_current" class="form-check-input" id="is_current" <?php if ($term['is_current']) echo 'checked'; ?>>
            <label class="form-check-label" for="is_current">Set as Current Term</label>
            <small class="form-text text-muted d-block">Only one term can be current at a time.</small>
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Term</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 