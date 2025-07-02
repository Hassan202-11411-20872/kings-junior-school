<?php
include '../includes/header.php';
require_once '../includes/db.php';
$classes = $pdo->query('SELECT * FROM classes ORDER BY section, class_name')->fetchAll();
$class_id = $_GET['class_id'] ?? '';
$query = 'SELECT s.*, c.class_name, c.section FROM subjects s JOIN classes c ON s.class_id = c.id';
$params = [];
if ($class_id) {
    $query .= ' WHERE s.class_id = ?';
    $params[] = $class_id;
}
$query .= ' ORDER BY c.section, c.class_name, s.subject_name';
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$subjects = $stmt->fetchAll();
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Subjects</h2>
    <div class="mb-3">
        <a href="add_subject.php" class="btn btn-primary">Add Subject</a>
    </div>
    <form class="row g-3 mb-4" method="get">
        <div class="col-md-6">
            <select name="class_id" class="form-select" onchange="this.form.submit()">
                <option value="">All Classes</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php if ($class_id == $c['id']) echo 'selected'; ?>><?php echo $c['class_name'] . ' (' . $c['section'] . ')'; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Subject Name</th>
                    <th>Class</th>
                    <th>Is Core</th>
                    <th>Max Score</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $subject): ?>
                <tr>
                    <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                    <td><?php echo htmlspecialchars($subject['class_name'] . ' (' . $subject['section'] . ')'); ?></td>
                    <td><?php echo $subject['is_core'] ? 'Yes' : 'No'; ?></td>
                    <td><?php echo htmlspecialchars($subject['max_score']); ?></td>
                    <td>
                        <a href="edit_subject.php?id=<?php echo $subject['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="delete_subject.php?id=<?php echo $subject['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this subject?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 