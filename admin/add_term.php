<?php
include '../includes/header.php';
require_once '../includes/db.php';

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
        $pdo->prepare('UPDATE terms SET is_current = 0')->execute();
    }
    
    $stmt = $pdo->prepare('INSERT INTO terms (name, year, start_date, end_date, is_current) VALUES (?, ?, ?, ?, ?)');
    try {
        $stmt->execute([$name, $year, $start_date, $end_date, $is_current]);
        $success = 'Term added successfully!';
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}

// Get current year for default value
$current_year = date('Y');
?>
<div class="no-print my-3">
    <a href="terms.php" class="btn btn-secondary">&larr; Back to Terms</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Add Academic Term</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:500px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Term Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g., Term 1, First Term, etc." required>
        </div>
        <div class="mb-3">
            <label class="form-label">Academic Year</label>
            <input type="number" name="year" class="form-control" value="<?php echo $current_year; ?>" min="2020" max="2030" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Start Date (Optional)</label>
            <input type="date" name="start_date" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">End Date (Optional)</label>
            <input type="date" name="end_date" class="form-control">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_current" class="form-check-input" id="is_current">
            <label class="form-check-label" for="is_current">Set as Current Term</label>
            <small class="form-text text-muted d-block">Only one term can be current at a time.</small>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Term</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 