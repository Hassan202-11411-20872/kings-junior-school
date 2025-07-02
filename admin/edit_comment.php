<?php
include '../includes/header.php';
require_once '../includes/db.php';
$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM comments WHERE id = ?');
$stmt->execute([$id]);
$comment = $stmt->fetch();
if (!$comment) {
    echo '<div class="alert alert-danger">Comment not found.</div>';
    include '../includes/footer.php';
    exit;
}
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $min_marks = $_POST['min_marks'];
    $max_marks = $_POST['max_marks'];
    $teacher_comment = trim($_POST['teacher_comment']);
    $headteacher_comment = trim($_POST['headteacher_comment']);
    $stmt = $pdo->prepare('UPDATE comments SET min_marks=?, max_marks=?, teacher_comment=?, headteacher_comment=? WHERE id=?');
    try {
        $stmt->execute([$min_marks, $max_marks, $teacher_comment, $headteacher_comment, $id]);
        $success = 'Comment updated!';
        // Refresh comment data
        $stmt = $pdo->prepare('SELECT * FROM comments WHERE id = ?');
        $stmt->execute([$id]);
        $comment = $stmt->fetch();
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Edit Comment</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:500px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Min Marks</label>
            <input type="number" name="min_marks" class="form-control" value="<?php echo htmlspecialchars($comment['min_marks']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Max Marks</label>
            <input type="number" name="max_marks" class="form-control" value="<?php echo htmlspecialchars($comment['max_marks']); ?>" required>
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
    </form>
</div>
<?php include '../includes/footer.php'; ?> 