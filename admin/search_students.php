<?php
require_once '../includes/db.php';
$class_id = $_GET['class_id'] ?? '';
$stream = $_GET['stream'] ?? '';
$name_search = $_GET['name_search'] ?? '';
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
foreach ($students as $student): ?>
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
        <a href="delete_student.php?id=<?php echo $student['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this student?');">Delete</a>
    </td>
</tr>
<?php endforeach; ?> 