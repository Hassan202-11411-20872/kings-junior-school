<?php
include '../includes/header.php';
require_once '../includes/db.php';
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv'])) {
    $file = $_FILES['csv']['tmp_name'];
    if (($handle = fopen($file, 'r')) !== false) {
        $row = 0;
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            if ($row == 0) { $row++; continue; } // skip header
            list($admission_number, $full_name, $class_id, $stream, $dob, $gender, $parent_name, $parent_phone, $address) = $data;
            $stmt = $pdo->prepare('INSERT INTO students (admission_number, full_name, class_id, stream, dob, gender, parent_name, parent_phone, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            try {
                $stmt->execute([$admission_number, $full_name, $class_id, $stream, $dob, $gender, $parent_name, $parent_phone, $address]);
            } catch (PDOException $e) {
                $error .= 'Error on row ' . ($row+1) . ': ' . $e->getMessage() . '<br>';
            }
            $row++;
        }
        fclose($handle);
        if (!$error) $success = 'Students uploaded successfully!';
    } else {
        $error = 'Failed to open file.';
    }
}
?>
<div class="no-print my-3">
    <a href="students.php" class="btn btn-secondary">&larr; Back to Students</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Batch Upload Students</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="card p-4 shadow-lg" style="max-width:500px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">CSV File</label>
            <input type="file" name="csv" class="form-control" accept=".csv" required>
            <div class="form-text">CSV columns: admission_number, full_name, class_id, stream, dob, gender, parent_name, parent_phone, address</div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Upload</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 