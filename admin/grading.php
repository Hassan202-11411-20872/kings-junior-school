<?php
include '../includes/header.php';
require_once '../includes/db.php';
$grading = $pdo->query('SELECT * FROM grading_scale ORDER BY min_mark DESC')->fetchAll();
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Grading Scale</h2>
    <div class="mb-3">
        <a href="add_grading.php" class="btn btn-primary">Add Grading Entry</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Min Mark</th>
                    <th>Max Mark</th>
                    <th>Grade</th>
                    <th>Remark</th>
                    <th>Division</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grading as $g): ?>
                <tr>
                    <td><?php echo htmlspecialchars($g['min_mark']); ?></td>
                    <td><?php echo htmlspecialchars($g['max_mark']); ?></td>
                    <td><?php echo htmlspecialchars($g['grade']); ?></td>
                    <td><?php echo htmlspecialchars($g['remark']); ?></td>
                    <td><?php echo htmlspecialchars($g['division']); ?></td>
                    <td>
                        <a href="edit_grading.php?id=<?php echo $g['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="delete_grading.php?id=<?php echo $g['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this grading entry?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 