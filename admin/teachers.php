<?php
include '../includes/header.php';
require_once '../includes/db.php';

// Fetch teachers with user and class info
$query = 'SELECT t.*, u.username, u.full_name, c.class_name, c.section FROM teachers t JOIN users u ON t.user_id = u.id LEFT JOIN classes c ON t.class_id = c.id';
$teachers = $pdo->query($query)->fetchAll();
?>
<div class="no-print my-3">
    <a href="dashboard.php" class="btn btn-secondary">&larr; Back to Dashboard</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Teachers</h2>
    <div class="mb-3">
        <a href="add_teacher.php" class="btn btn-primary">Add Teacher</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Initials</th>
                    <th>Assigned Class</th>
                    <th>Subjects</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teachers as $teacher): ?>
                <tr>
                    <td><?php echo htmlspecialchars($teacher['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($teacher['username']); ?></td>
                    <td><?php echo htmlspecialchars($teacher['initials']); ?></td>
                    <td><?php echo $teacher['class_name'] ? htmlspecialchars($teacher['class_name'] . ' (' . $teacher['section'] . ')') : '-'; ?></td>
                    <td><?php echo htmlspecialchars($teacher['subjects']); ?></td>
                    <td>
                        <a href="edit_teacher.php?id=<?php echo $teacher['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="delete_teacher.php?id=<?php echo $teacher['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this teacher assignment?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../includes/footer.php'; ?> 