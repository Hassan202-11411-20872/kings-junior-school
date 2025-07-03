<?php
include '../includes/header.php';
require_once '../includes/db.php';

// Fetch classes for filter
$classes = $pdo->query('SELECT * FROM classes')->fetchAll();
$class_id = $_GET['class_id'] ?? '';
$stream = $_GET['stream'] ?? '';

// Build query
$query = 'SELECT s.*, c.class_name, c.section FROM students s JOIN classes c ON s.class_id = c.id WHERE 1';
$params = [];
if ($class_id) {
    $query .= ' AND s.class_id = ?';
    $params[] = $class_id;
}
if ($stream) {
    $query .= ' AND s.stream = ?';
    $params[] = $stream;
}
$query .= ' ORDER BY s.full_name';
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$students = $stmt->fetchAll();
?>
<div class="no-print my-3">
    <a href="dashboard.php" class="btn btn-secondary">&larr; Back to Dashboard</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Students</h2>
    <div class="mb-3">
        <a href="add_student.php" class="btn btn-primary">Add Student</a>
        <a href="upload_students.php" class="btn btn-outline-primary ms-2">Batch Upload</a>
    </div>
    <form class="row g-3 mb-4" method="get">
        <div class="col-md-4">
            <select name="class_id" class="form-select" onchange="this.form.submit()">
                <option value="">All Classes</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php if ($class_id == $c['id']) echo 'selected'; ?>><?php echo $c['class_name'] . ' (' . $c['section'] . ')'; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" name="stream" class="form-control" placeholder="Stream (optional)" value="<?php echo htmlspecialchars($stream); ?>">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Photo</th>
                    <th>Admission #</th>
                    <th>Full Name</th>
                    <th>Class</th>
                    <th>Stream</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><img src="../<?php echo $student['photo_path'] ?: 'assets/images/logo-e.png'; ?>" alt="Photo" style="width:40px; height:40px; object-fit:cover; border-radius:50%;"></td>
                    <td><?php echo htmlspecialchars($student['admission_number']); ?></td>
                    <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['class_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['stream']); ?></td>
                    <td>
                        <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="delete_student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this student?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 