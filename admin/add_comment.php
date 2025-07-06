<?php
include '../includes/header.php';
require_once '../includes/db.php';

$error = '';
$success = '';

// Handle CSV upload for major subject comments
if (isset($_POST['upload_major_comments'])) {
    if (isset($_FILES['major_comments_file']) && $_FILES['major_comments_file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['major_comments_file']['tmp_name'];
        $fileName = $_FILES['major_comments_file']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $imported = 0;
        $errors = [];
        if ($fileExtension === 'csv') {
            if (($handle = fopen($fileTmpPath, 'r')) !== false) {
                $header = fgetcsv($handle);
                // Expecting: total, teacher_comment, headteacher_comment
                while (($row = fgetcsv($handle)) !== false) {
                    $total = isset($row[0]) ? intval($row[0]) : null;
                    $teacher_comment = isset($row[1]) ? trim($row[1]) : '';
                    $headteacher_comment = isset($row[2]) ? trim($row[2]) : '';
                    if ($total !== null && $teacher_comment && $headteacher_comment) {
                        $stmt = $pdo->prepare('REPLACE INTO major_subject_comments (total, teacher_comment, headteacher_comment) VALUES (?, ?, ?)');
                        $stmt->execute([$total, $teacher_comment, $headteacher_comment]);
                        $imported++;
                    } else {
                        $errors[] = "Invalid row for total $total.";
                    }
                }
                fclose($handle);
            } else {
                $error = 'Could not open the CSV file.';
            }
        } else {
            $error = 'Unsupported file type. Please upload a .csv file.';
        }
        if ($imported > 0) {
            $success = "Successfully imported $imported comments.";
        }
        if (!empty($errors)) {
            $error = implode('<br>', $errors);
        }
    } else {
        $error = 'No file uploaded or upload error.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['upload_major_comments'])) {
    $total = isset($_POST['total']) ? $_POST['total'] : '';
    $teacher_comment = isset($_POST['teacher_comment']) ? trim($_POST['teacher_comment']) : '';
    $headteacher_comment = isset($_POST['headteacher_comment']) ? trim($_POST['headteacher_comment']) : '';
    if ($total === '' || $teacher_comment === '' || $headteacher_comment === '') {
        $error = 'All fields are required.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO major_subject_comments (total, teacher_comment, headteacher_comment) VALUES (?, ?, ?)');
        try {
            $stmt->execute([$total, $teacher_comment, $headteacher_comment]);
            $success = 'Major subject total-based comment added successfully!';
        } catch (PDOException $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Add Major Subject Total-Based Comment</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="mb-3" style="max-width:500px;margin:auto;">
        <div class="mb-2">
            <label class="form-label">Upload CSV for Major Subject Comments</label>
            <input type="file" name="major_comments_file" class="form-control" accept=".csv" required>
        </div>
        <button type="submit" name="upload_major_comments" class="btn btn-success w-100">Upload Comments File</button>
        <div class="form-text">File must have columns: <b>total</b>, <b>teacher_comment</b>, <b>headteacher_comment</b> (in that order, with header row).</div>
    </form>
    <form method="post" class="card p-4 shadow-lg" style="max-width:500px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="number" name="total" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Teacher Comment</label>
            <input type="text" name="teacher_comment" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Headteacher Comment</label>
            <input type="text" name="headteacher_comment" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Major Subject Comment</button>
        <a href="comments.php" class="btn btn-secondary w-100 mt-2">Back to Comments</a>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 