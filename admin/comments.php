<?php
include '../includes/header.php';
require_once '../includes/db.php';
$comments = $pdo->query('SELECT * FROM comments ORDER BY min_marks ASC')->fetchAll();
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Comments (Auto/Custom)</h2>
    <div class="mb-3">
        <a href="add_comment.php" class="btn btn-primary">Add Comment</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Min Marks</th>
                    <th>Max Marks</th>
                    <th>Teacher Comment</th>
                    <th>Headteacher Comment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $c): ?>
                <tr>
                    <td><?php echo htmlspecialchars($c['min_marks']); ?></td>
                    <td><?php echo htmlspecialchars($c['max_marks']); ?></td>
                    <td><?php echo htmlspecialchars($c['teacher_comment']); ?></td>
                    <td><?php echo htmlspecialchars($c['headteacher_comment']); ?></td>
                    <td>
                        <a href="edit_comment.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="delete_comment.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this comment?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 