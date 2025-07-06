<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../login.php');
    exit;
}
include '../includes/header.php';
require_once '../includes/db.php';

// Get teacher's assigned class
$teacher = $pdo->prepare('SELECT * FROM teachers WHERE user_id = ?');
$teacher->execute([$_SESSION['user_id']]);
$teacher = $teacher->fetch();
$class_id = $teacher['class_id'] ?? '';
$students = [];
$class = null;

// Get filter parameters
$stream_filter = $_GET['stream'] ?? '';
$name_search = $_GET['name_search'] ?? '';
$show_all_streams = $_GET['show_all_streams'] ?? false;

if ($class_id) {
    $class = $pdo->prepare('SELECT * FROM classes WHERE id = ?');
    $class->execute([$class_id]);
    $class = $class->fetch();
    
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
    
    // Get available streams for the teacher's class
    $streams_query = $pdo->prepare('SELECT DISTINCT stream FROM students WHERE class_id = ? AND stream IS NOT NULL AND stream != "" ORDER BY stream');
    $streams_query->execute([$class_id]);
    $available_streams = $streams_query->fetchAll(PDO::FETCH_COLUMN);
}
?>
<div class="no-print my-3">
    <a href="dashboard.php" class="btn btn-secondary">&larr; Back to Dashboard</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">My Students</h2>
    
    <?php if ($class): ?>
        <div class="alert alert-info">
            <strong>Class:</strong> <?php echo htmlspecialchars($class['class_name'] . ' (' . $class['section'] . ')'); ?> | 
            <strong>Students:</strong> <?php echo count($students); ?> | 
            <strong>Streams:</strong> <?php echo $show_all_streams ? 'All (' . count($available_streams) . ')' : ($stream_filter ? $stream_filter : 'All'); ?>
        </div>
        
        <!-- Filters -->
        <form class="row g-3 mb-4" method="get" id="filterForm">
            <div class="col-md-3">
                <select name="stream" class="form-select" onchange="this.form.submit()">
                    <option value="">All Streams</option>
                    <?php foreach ($available_streams as $s): ?>
                        <option value="<?php echo htmlspecialchars($s); ?>" <?php if ($stream_filter == $s) echo 'selected'; ?>><?php echo htmlspecialchars($s); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <div class="form-check">
                    <input type="checkbox" name="show_all_streams" value="1" class="form-check-input" id="showAllStreams" <?php if ($show_all_streams) echo 'checked'; ?> onchange="this.form.submit()">
                    <label class="form-check-label" for="showAllStreams">Show All Streams</label>
                </div>
            </div>
            <div class="col-md-4">
                <input type="text" name="name_search" id="nameSearchInput" class="form-control" placeholder="Search by name" value="<?php echo htmlspecialchars($name_search); ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">Filter</button>
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
                        <th>Stream</th>
                        <th>Session</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="studentsTableBody">
                    <?php foreach ($students as $student): ?>
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
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <?php if (!$class_id): ?>
        <div class="alert alert-info">You are not assigned to any class. Please contact the admin.</div>
    <?php elseif (empty($students)): ?>
        <div class="alert alert-warning">No students found for your class.</div>
    <?php endif; ?>
</div>

<script>
// Professional unobtrusive AJAX live search
(function() {
    const nameInput = document.getElementById('nameSearchInput');
    const tableBody = document.getElementById('studentsTableBody');
    const filterForm = document.getElementById('filterForm');
    let lastValue = nameInput.value;
    let timeout = null;
    
    if (nameInput && tableBody && filterForm) {
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
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                    });
            }, 200); // Debounce for 200ms
        });
    }
})();
</script>

<?php include '../includes/footer.php'; ?> 