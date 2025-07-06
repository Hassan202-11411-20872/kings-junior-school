<?php
include '../includes/header.php';
require_once '../includes/db.php';

// Handle set current year
if (isset($_GET['set_current'])) {
    $id = intval($_GET['set_current']);
    $pdo->exec('UPDATE academic_years SET is_current = 0');
    $stmt = $pdo->prepare('UPDATE academic_years SET is_current = 1 WHERE id = ?');
    $stmt->execute([$id]);
}
// Handle add year
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['year_label'])) {
    $year_label = trim($_POST['year_label']);
    if ($year_label) {
        $stmt = $pdo->prepare('INSERT INTO academic_years (year_label) VALUES (?)');
        $stmt->execute([$year_label]);
    }
}
$years = $pdo->query('SELECT * FROM academic_years ORDER BY id DESC')->fetchAll();
?>
<div class="no-print my-3">
    <a href="dashboard.php" class="btn btn-secondary">&larr; Back to Dashboard</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Academic Years</h2>
    <form method="post" class="mb-4 row g-2 align-items-end">
        <div class="col-auto">
            <input type="text" name="year_label" class="form-control" placeholder="e.g. 2024/2025" required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-success">Add Academic Year</button>
        </div>
    </form>
    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Year Label</th>
                <th>Status</th>
                <th>Set Current</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($years as $year): ?>
            <tr>
                <td><?php echo $year['id']; ?></td>
                <td><?php echo htmlspecialchars($year['year_label']); ?></td>
                <td><?php echo $year['is_current'] ? '<span class="badge bg-success">Current</span>' : '<span class="badge bg-secondary">Archived</span>'; ?></td>
                <td>
                    <?php if (!$year['is_current']): ?>
                        <a href="?set_current=<?php echo $year['id']; ?>" class="btn btn-sm btn-outline-primary">Set as Current</a>
                    <?php else: ?>
                        <span class="text-success">Current</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include '../includes/footer.php'; ?> 