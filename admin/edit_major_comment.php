<?php
include '../includes/header.php';
require_once '../includes/db.php';
$total = isset($_GET['total']) ? (int)$_GET['total'] : 0;
$stmt = $pdo->prepare('SELECT * FROM major_subject_comments WHERE total = ?');
$stmt->execute([$total]);
$comment = $stmt->fetch();
if (!$comment) {
    echo '<div class="alert alert-danger">Comment not found for total: ' . htmlspecialchars($total) . '.</div>';
    include '../includes/footer.php';
    exit;
}
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_comment = trim($_POST['teacher_comment']);
    $headteacher_comment = trim($_POST['headteacher_comment']);
    $stmt = $pdo->prepare('UPDATE major_subject_comments SET teacher_comment=?, headteacher_comment=? WHERE total=?');
    try {
        $stmt->execute([$teacher_comment, $headteacher_comment, $total]);
        $success = 'Comment updated!';
        // Refresh comment data
        $stmt = $pdo->prepare('SELECT * FROM major_subject_comments WHERE total = ?');
        $stmt->execute([$total]);
        $comment = $stmt->fetch();
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Edit Major Subject Comment</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:500px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="number" name="total" class="form-control" value="<?php echo htmlspecialchars($comment['total']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Teacher Comment</label>
            <input type="text" name="teacher_comment" class="form-control" value="<?php echo htmlspecialchars($comment['teacher_comment']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Headteacher Comment</label>
            <input type="text" name="headteacher_comment" class="form-control" value="<?php echo htmlspecialchars($comment['headteacher_comment']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Comment</button>
        <a href="comments.php" class="btn btn-secondary w-100 mt-2">Back to Comments</a>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 