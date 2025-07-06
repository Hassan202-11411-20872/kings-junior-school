<?php
include '../includes/header.php';
require_once '../includes/db.php';

// Check if terms table has academic_year_id column
$has_academic_year = false;
try {
    $pdo->query("SELECT academic_year_id FROM terms LIMIT 1");
    $has_academic_year = true;
} catch (PDOException $e) {
    $has_academic_year = false;
}

if ($has_academic_year) {
    // New structure with academic_year_id
    $years = $pdo->query('SELECT * FROM academic_years ORDER BY id DESC')->fetchAll();
    $year_id = $_GET['year_id'] ?? '';
    if (!$year_id && $years) {
        foreach ($years as $y) { if ($y['is_current']) { $year_id = $y['id']; break; } }
        if (!$year_id) $year_id = $years[0]['id'] ?? '';
    }

    // Handle set current term
    if (isset($_GET['set_current']) && $year_id) {
        $id = intval($_GET['set_current']);
        $pdo->prepare('UPDATE terms SET is_current = 0 WHERE academic_year_id = ?')->execute([$year_id]);
        $stmt = $pdo->prepare('UPDATE terms SET is_current = 1 WHERE id = ?');
        $stmt->execute([$id]);
    }
    // Handle add term
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['term_label']) && $year_id) {
        $term_label = trim($_POST['term_label']);
        if ($term_label) {
            $stmt = $pdo->prepare('INSERT INTO terms (term_label, academic_year_id) VALUES (?, ?)');
            $stmt->execute([$term_label, $year_id]);
        }
    }
    $terms = $year_id ? $pdo->prepare('SELECT * FROM terms WHERE academic_year_id = ? ORDER BY id DESC') : null;
    if ($terms) { $terms->execute([$year_id]); $terms = $terms->fetchAll(); }
} else {
    // Old structure without academic_year_id
    $years = [];
    $year_id = '';
    
    // Handle set current term
    if (isset($_GET['set_current'])) {
        $id = intval($_GET['set_current']);
        $pdo->prepare('UPDATE terms SET is_current = 0')->execute();
        $stmt = $pdo->prepare('UPDATE terms SET is_current = 1 WHERE id = ?');
        $stmt->execute([$id]);
    }
    // Handle add term
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['term_label'])) {
        $term_label = trim($_POST['term_label']);
        if ($term_label) {
            $stmt = $pdo->prepare('INSERT INTO terms (name, year) VALUES (?, ?)');
            $current_year = date('Y');
            $stmt->execute([$term_label, $current_year]);
        }
    }
    $terms = $pdo->query('SELECT * FROM terms ORDER BY id DESC')->fetchAll();
}
?>
<div class="no-print my-3">
    <a href="dashboard.php" class="btn btn-secondary">&larr; Back to Dashboard</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Terms</h2>
    
    <?php if ($has_academic_year): ?>
        <!-- New structure with academic years -->
        <form method="get" class="mb-3 row g-2 align-items-end">
            <div class="col-auto">
                <select name="year_id" class="form-select" onchange="this.form.submit()">
                    <?php foreach ($years as $y): ?>
                        <option value="<?php echo $y['id']; ?>" <?php if ($year_id == $y['id']) echo 'selected'; ?>><?php echo htmlspecialchars($y['year_label']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
        <?php if ($year_id): ?>
        <form method="post" class="mb-4 row g-2 align-items-end">
            <div class="col-auto">
                <input type="text" name="term_label" class="form-control" placeholder="e.g. Term 1" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success">Add Term</button>
            </div>
        </form>
        <?php endif; ?>
    <?php else: ?>
        <!-- Old structure without academic years -->
        <form method="post" class="mb-4 row g-2 align-items-end">
            <div class="col-auto">
                <input type="text" name="term_label" class="form-control" placeholder="e.g. Term 1" required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success">Add Term</button>
            </div>
        </form>
    <?php endif; ?>
    
    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Term Name</th>
                <?php if (!$has_academic_year): ?>
                    <th>Year</th>
                <?php endif; ?>
                <th>Status</th>
                <th>Set Current</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($terms) foreach ($terms as $term): ?>
            <tr>
                <td><?php echo $term['id']; ?></td>
                <td><?php echo htmlspecialchars($has_academic_year ? $term['term_label'] : $term['name']); ?></td>
                <?php if (!$has_academic_year): ?>
                    <td><?php echo htmlspecialchars($term['year']); ?></td>
                <?php endif; ?>
                <td><?php echo $term['is_current'] ? '<span class="badge bg-success">Current</span>' : '<span class="badge bg-secondary">Archived</span>'; ?></td>
                <td>
                    <?php if (!$term['is_current']): ?>
                        <?php if ($has_academic_year): ?>
                            <a href="?year_id=<?php echo $year_id; ?>&set_current=<?php echo $term['id']; ?>" class="btn btn-sm btn-outline-primary">Set as Current</a>
                        <?php else: ?>
                            <a href="?set_current=<?php echo $term['id']; ?>" class="btn btn-sm btn-outline-primary">Set as Current</a>
                        <?php endif; ?>
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