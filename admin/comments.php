<?php
include '../includes/header.php';
require_once '../includes/db.php';
$major_comments = $pdo->query('SELECT * FROM major_subject_comments ORDER BY total ASC')->fetchAll();
?>
<div class="no-print my-3">
    <a href="dashboard.php" class="btn btn-secondary">&larr; Back to Dashboard</a>
    <a href="add_comment.php" class="btn btn-primary">Add Major Subject Comment</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Major Subject Total-Based Comments</h2>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-success">
                <tr>
                    <th>Total</th>
                    <th>Teacher Comment</th>
                    <th>Headteacher Comment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($major_comments) && is_array($major_comments)): ?>
                    <?php foreach ($major_comments as $mc): ?>
                        <tr>
                            <td><?php echo isset($mc['total']) ? htmlspecialchars($mc['total']) : ''; ?></td>
                            <td><?php echo isset($mc['teacher_comment']) ? htmlspecialchars($mc['teacher_comment']) : ''; ?></td>
                            <td><?php echo isset($mc['headteacher_comment']) ? htmlspecialchars($mc['headteacher_comment']) : ''; ?></td>
                            <td>
                                <a href="edit_major_comment.php?total=<?php echo isset($mc['total']) ? (int)$mc['total'] : ''; ?>" class="btn btn-outline-primary btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                                <a href="delete_major_comment.php?total=<?php echo isset($mc['total']) ? (int)$mc['total'] : ''; ?>" class="btn btn-outline-danger btn-sm" title="Delete" onclick="return confirm('Delete this comment?');"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No major subject comments found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<?php include '../includes/footer.php'; ?> 