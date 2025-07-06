<?php
include '../includes/header.php';
require_once '../includes/db.php';

// Fetch classes for filter
$classes = $pdo->query('SELECT * FROM classes')->fetchAll();
$class_id = $_GET['class_id'] ?? '';
$stream = $_GET['stream'] ?? '';
$name_search = $_GET['name_search'] ?? '';

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
if ($name_search) {
    $query .= ' AND s.full_name LIKE ?';
    $params[] = '%' . $name_search . '%';
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
    <form class="row g-3 mb-4" method="get" id="filterForm">
        <div class="col-md-3">
            <select name="class_id" class="form-select" onchange="this.form.submit()">
                <option value="">All Classes</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php if ($class_id == $c['id']) echo 'selected'; ?>><?php echo $c['class_name'] . ' (' . $c['section'] . ')'; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="stream" class="form-control" placeholder="Stream (optional)" value="<?php echo htmlspecialchars($stream); ?>">
        </div>
        <div class="col-md-4">
            <input type="text" name="name_search" id="nameSearchInput" class="form-control" placeholder="Search by name" value="<?php echo htmlspecialchars($name_search); ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary w-100">Filter/Search</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Photo</th>
                    <th>Admission #</th>
                    <th>School Pay #</th>
                    <th>Full Name</th>
                    <th>Class</th>
                    <th>Stream</th>
                    <th>Session</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="studentsTableBody">
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><img src="../<?php echo $student['photo_path'] ?: 'assets/images/logo-e.png'; ?>" alt="Photo" style="width:40px; height:40px; object-fit:cover; border-radius:50%;"></td>
                    <td><?php echo htmlspecialchars($student['admission_number']); ?></td>
                    <td><?php echo htmlspecialchars($student['school_pay_number']); ?></td>
                    <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['class_name']); ?></td>
                    <td><?php echo htmlspecialchars($student['stream']); ?></td>
                    <td><?php echo htmlspecialchars($student['session']); ?></td>
                    <td>
                        <a href="edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="student_history.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-outline-info">History</a>
                        <a href="delete_student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this student?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
// Professional unobtrusive AJAX live search
(function() {
    const nameInput = document.getElementById('nameSearchInput');
    const tableBody = document.getElementById('studentsTableBody');
    const filterForm = document.getElementById('filterForm');
    let lastValue = nameInput.value;
    let timeout = null;
    nameInput.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            if (nameInput.value === lastValue) return;
            lastValue = nameInput.value;
            const params = new URLSearchParams(new FormData(filterForm));
            fetch('search_students.php?' + params.toString())
                .then(response => response.text())
                .then(html => {
                    tableBody.innerHTML = html;
                });
        }, 200); // Debounce for 200ms
    });
})();
</script>
<?php include '../includes/footer.php'; ?> 