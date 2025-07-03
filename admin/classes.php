<?php
include '../includes/header.php';
require_once '../includes/db.php';
$classes = $pdo->query('SELECT * FROM classes ORDER BY section, class_name')->fetchAll();
?>
<div class="no-print my-3">
    <a href="dashboard.php" class="btn btn-secondary">&larr; Back to Dashboard</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Classes</h2>
    <div class="mb-3">
        <a href="add_class.php" class="btn btn-primary">Add Class</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Section</th>
                    <th>Class Name</th>
                    <th>Stream</th>
                    <th>Has Streams</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class): ?>
                <tr>
                    <td><?php echo htmlspecialchars($class['section']); ?></td>
                    <td><?php echo htmlspecialchars($class['class_name']); ?></td>
                    <td><?php echo htmlspecialchars($class['stream']); ?></td>
                    <td><?php echo $class['has_streams'] ? 'Yes' : 'No'; ?></td>
                    <td><?php echo htmlspecialchars($class['created_at']); ?></td>
                    <td>
                        <a href="edit_class.php?id=<?php echo $class['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="delete_class.php?id=<?php echo $class['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this class?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 