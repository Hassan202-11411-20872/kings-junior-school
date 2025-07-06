<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    exit('Unauthorized');
}

require_once '../includes/db.php';

// Get teacher's assigned class
$teacher = $pdo->prepare('SELECT * FROM teachers WHERE user_id = ?');
$teacher->execute([$_SESSION['user_id']]);
$teacher = $teacher->fetch();
$class_id = $teacher['class_id'] ?? '';

if (!$class_id) {
    exit('No class assigned');
}

// Get filter parameters
$stream_filter = $_GET['stream'] ?? '';
$name_search = $_GET['name_search'] ?? '';
$show_all_streams = $_GET['show_all_streams'] ?? false;

// Build query with filters
$query = 'SELECT * FROM students WHERE class_id = ?';
$params = [$class_id];

if ($stream_filter && !$show_all_streams) {
    $query .= ' AND stream = ?';
    $params[] = $stream_filter;
}

if ($name_search) {
    $query .= ' AND full_name LIKE ?';
    $params[] = '%' . $name_search . '%';
}

$query .= ' ORDER BY stream, full_name';

$students = $pdo->prepare($query);
$students->execute($params);
$students = $students->fetchAll();

// Output HTML for table rows
foreach ($students as $student): ?>
    <tr class="<?php echo $show_all_streams && $student['stream'] ? 'table-light' : ''; ?>">
        <td>
            <img src="../<?php echo $student['photo_path'] ?: 'assets/images/logo-e.png'; ?>" 
                 alt="Student Photo" 
                 style="width:40px; height:40px; object-fit:cover; border-radius:50%;">
        </td>
        <td><strong><?php echo htmlspecialchars($student['admission_number']); ?></strong></td>
        <td><?php echo htmlspecialchars($student['school_pay_number']); ?></td>
        <td>
            <strong><?php echo htmlspecialchars($student['full_name']); ?></strong>
            <?php if ($student['gender']): ?>
                <br><small class="text-muted"><?php echo htmlspecialchars($student['gender']); ?></small>
            <?php endif; ?>
        </td>
        <td>
            <?php if ($student['stream']): ?>
                <span class="badge bg-info"><?php echo htmlspecialchars($student['stream']); ?></span>
            <?php else: ?>
                <span class="text-muted">-</span>
            <?php endif; ?>
        </td>
        <td>
            <span class="badge bg-secondary"><?php echo htmlspecialchars($student['session']); ?></span>
        </td>
        <td>
            <a href="marks.php?student_id=<?php echo $student['id']; ?>" class="btn btn-sm btn-outline-primary">View Marks</a>
        </td>
    </tr>
<?php endforeach; ?> 