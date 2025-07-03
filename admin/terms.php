<?php
include '../includes/header.php';
require_once '../includes/db.php';

$terms = $pdo->query('SELECT * FROM terms ORDER BY year DESC, name ASC')->fetchAll();
?>
<div class="no-print my-3">
    <a href="dashboard.php" class="btn btn-secondary">&larr; Back to Dashboard</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Academic Terms</h2>
    <div class="mb-3">
        <a href="add_term.php" class="btn btn-primary">Add Term</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Term Name</th>
                    <th>Academic Year</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Current Term</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($terms as $term): ?>
                <tr>
                    <td><?php echo htmlspecialchars($term['name']); ?></td>
                    <td><?php echo htmlspecialchars($term['year']); ?></td>
                    <td><?php echo $term['start_date'] ? htmlspecialchars($term['start_date']) : '-'; ?></td>
                    <td><?php echo $term['end_date'] ? htmlspecialchars($term['end_date']) : '-'; ?></td>
                    <td>
                        <?php if ($term['is_current']): ?>
                            <span class="badge bg-success">Current</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Past</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit_term.php?id=<?php echo $term['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="delete_term.php?id=<?php echo $term['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this term? This will also delete all marks associated with this term.');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if (empty($terms)): ?>
        <div class="alert alert-info">
            <h5>No Terms Found</h5>
            <p>You need to add academic terms before you can enter marks. Click "Add Term" to get started.</p>
        </div>
    <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?> 