<?php
include '../includes/header.php';
require_once '../includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $min_marks = $_POST['min_marks'];
    $max_marks = $_POST['max_marks'];
    $teacher_comment = trim($_POST['teacher_comment']);
    $headteacher_comment = trim($_POST['headteacher_comment']);
    
    $stmt = $pdo->prepare('INSERT INTO comments (min_marks, max_marks, teacher_comment, headteacher_comment) VALUES (?, ?, ?, ?)');
    try {
        $stmt->execute([$min_marks, $max_marks, $teacher_comment, $headteacher_comment]);
        $success = 'Comment added successfully!';
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
    }
}
?>
<div class="no-print my-3">
    <a href="comments.php" class="btn btn-secondary">&larr; Back to Comments</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Add Comment</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" class="card p-4 shadow-lg" style="max-width:600px;margin:auto;">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Minimum Marks</label>
                    <input type="number" name="min_marks" class="form-control" min="0" max="100" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Maximum Marks</label>
                    <input type="number" name="max_marks" class="form-control" min="0" max="100" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Teacher Comment</label>
            <textarea name="teacher_comment" class="form-control" rows="3" placeholder="Enter teacher's comment for this mark range..." required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Headteacher Comment</label>
            <textarea name="headteacher_comment" class="form-control" rows="3" placeholder="Enter headteacher's comment for this mark range..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Comment</button>
    </form>
    
    <div class="mt-4">
        <h5>Comment Guidelines:</h5>
        <div class="row">
            <div class="col-md-6">
                <h6>Teacher Comments Examples:</h6>
                <ul>
                    <li><strong>80-100:</strong> "Excellent work! Keep up the good performance."</li>
                    <li><strong>60-79:</strong> "Good work. Continue to improve."</li>
                    <li><strong>40-59:</strong> "Fair performance. More effort needed."</li>
                    <li><strong>0-39:</strong> "Poor performance. Requires immediate attention."</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6>Headteacher Comments Examples:</h6>
                <ul>
                    <li><strong>80-100:</strong> "Outstanding performance. Congratulations!"</li>
                    <li><strong>60-79:</strong> "Good progress. Keep working hard."</li>
                    <li><strong>40-59:</strong> "Needs improvement. Parent consultation required."</li>
                    <li><strong>0-39:</strong> "Serious concern. Immediate parent meeting needed."</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 