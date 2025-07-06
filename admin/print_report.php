<?php
require_once '../includes/db.php';
// Fetch classes and terms for the form
$classes = $pdo->query('SELECT * FROM classes ORDER BY section, class_name')->fetchAll();
$terms = $pdo->query('SELECT * FROM terms ORDER BY year DESC, name DESC')->fetchAll();
$streams = [];
$class_id = $_GET['class_id'] ?? '';
if ($class_id) {
    $streams_stmt = $pdo->prepare('SELECT DISTINCT stream FROM students WHERE class_id = ? AND stream IS NOT NULL AND stream != ""');
    $streams_stmt->execute([$class_id]);
    $streams = $streams_stmt->fetchAll(PDO::FETCH_COLUMN);
}
$students = [];
$stream = $_GET['stream'] ?? '';
$session_filter = $_GET['session'] ?? '';
if ($class_id) {
    $query = 'SELECT * FROM students WHERE class_id = ?';
    $params = [$class_id];
    
    if ($stream) {
        $query .= ' AND stream = ?';
        $params[] = $stream;
    }
    
    if ($session_filter) {
        $query .= ' AND session = ?';
        $params[] = $session_filter;
    }
    
    $students_stmt = $pdo->prepare($query);
    $students_stmt->execute($params);
    $students = $students_stmt->fetchAll();
}

// Get available sessions for the selected class
$available_sessions = [];
if ($class_id) {
    $sessions_query = $pdo->prepare('SELECT DISTINCT session FROM students WHERE class_id = ? AND session IS NOT NULL AND session != "" ORDER BY session');
    $sessions_query->execute([$class_id]);
    $available_sessions = $sessions_query->fetchAll(PDO::FETCH_COLUMN);
}
$term_id = $_GET['term_id'] ?? '';
$exam_type = $_GET['exam_type'] ?? 'Mid Term';
$print_mode = $_GET['print_mode'] ?? 'single'; // single, bulk, stream
$student_id = $_GET['student_id'] ?? '';
$grading = $pdo->query('SELECT * FROM grading_scale ORDER BY min_mark DESC')->fetchAll();
$comments = $pdo->query('SELECT * FROM comments ORDER BY min_marks ASC')->fetchAll();
function get_grading($grading, $score) {
    foreach ($grading as $g) {
        if ($score >= $g['min_mark'] && $score <= $g['max_mark']) {
            return [$g['grade'], $g['remark'], $g['division']];
        }
    }
    return ['-', '-', '-'];
}
function get_comment($comments, $total) {
    foreach ($comments as $c) {
        if ($total >= $c['min_marks'] && $total <= $c['max_marks']) {
            return [$c['teacher_comment'], $c['headteacher_comment']];
        }
    }
    return ['-', '-'];
}
// Determine which students to print
$students_to_print = [];
if ($print_mode === 'single' && $student_id) {
    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
    $stmt->execute([$student_id]);
    $students_to_print = $stmt->fetchAll();
} elseif ($print_mode === 'bulk' && $class_id) {
    $query = 'SELECT * FROM students WHERE class_id = ?';
    $params = [$class_id];
    
    if ($session_filter) {
        $query .= ' AND session = ?';
        $params[] = $session_filter;
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $students_to_print = $stmt->fetchAll();
} elseif ($print_mode === 'stream' && $class_id && $stream) {
    $query = 'SELECT * FROM students WHERE class_id = ? AND stream = ?';
    $params = [$class_id, $stream];
    
    if ($session_filter) {
        $query .= ' AND session = ?';
        $params[] = $session_filter;
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $students_to_print = $stmt->fetchAll();
}
$term = null;
if ($term_id) {
    $term_stmt = $pdo->prepare('SELECT * FROM terms WHERE id = ?');
    $term_stmt->execute([$term_id]);
    $term = $term_stmt->fetch();
}
$class = null;
if ($class_id) {
    $class_stmt = $pdo->prepare('SELECT * FROM classes WHERE id = ?');
    $class_stmt->execute([$class_id]);
    $class = $class_stmt->fetch();
}
$subjects = [];
if ($class) {
    $subjects_stmt = $pdo->prepare('SELECT * FROM subjects WHERE class_id = ?');
    $subjects_stmt->execute([$class['id']]);
    $subjects = $subjects_stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../assets/images/favicon_io/favicon.ico">
    <style>
        @media print {
            .no-print { display: none !important; }
            .report-card { page-break-after: always; }
        }
        .report-card { max-width: 900px; margin: 2rem auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(25,118,210,0.08); padding: 2rem; }
        .school-logo { width: 80px; height: 80px; object-fit: contain; border-radius: 12px; }
        .footer-motto { font-size: 1.2rem; color: #1976d2; font-weight: bold; margin-top: 2rem; text-align: center; }
        .grading-table, .grading-table th, .grading-table td { font-size: 0.95rem; }
    </style>
    <script>
    function updateForm() {
        document.getElementById('reportForm').submit();
    }
    </script>
</head>
<body style="background:#e3f2fd;">
<div class="container-fluid">
    <form id="reportForm" class="row g-3 align-items-end no-print mb-4" method="get" action="">
        <div class="col-md-2">
            <label class="form-label">Class</label>
            <select name="class_id" class="form-select" onchange="updateForm()" required>
                <option value="">Select Class</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php if ($class_id == $c['id']) echo 'selected'; ?>><?php echo $c['class_name'] . ' (' . $c['section'] . ')'; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Stream</label>
            <select name="stream" class="form-select" onchange="updateForm()">
                <option value="">All Streams</option>
                <?php foreach ($streams as $s): ?>
                    <option value="<?php echo htmlspecialchars($s); ?>" <?php if ($stream == $s) echo 'selected'; ?>><?php echo htmlspecialchars($s); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Session</label>
            <select name="session" class="form-select" onchange="updateForm()">
                <option value="">All Sessions</option>
                <?php foreach ($available_sessions as $s): ?>
                    <option value="<?php echo htmlspecialchars($s); ?>" <?php if ($session_filter == $s) echo 'selected'; ?>><?php echo htmlspecialchars($s); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Student</label>
            <select name="student_id" class="form-select">
                <option value="">All Students</option>
                <?php foreach ($students as $stu): ?>
                    <option value="<?php echo $stu['id']; ?>" <?php if ($student_id == $stu['id']) echo 'selected'; ?>><?php echo htmlspecialchars($stu['full_name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Term</label>
            <select name="term_id" class="form-select" required>
                <option value="">Select Term</option>
                <?php foreach ($terms as $t): ?>
                    <option value="<?php echo $t['id']; ?>" <?php if ($term_id == $t['id']) echo 'selected'; ?>><?php echo $t['name'] . ' ' . $t['year']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Exam Type</label>
            <select name="exam_type" class="form-select" required>
                <option value="Mid Term" <?php if ($exam_type == 'Mid Term') echo 'selected'; ?>>Mid Term</option>
                <option value="End Term" <?php if ($exam_type == 'End Term') echo 'selected'; ?>>End Term</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Print Mode</label>
            <select name="print_mode" class="form-select" onchange="updateForm()">
                <option value="single" <?php if ($print_mode == 'single') echo 'selected'; ?>>Single Student</option>
                <option value="bulk" <?php if ($print_mode == 'bulk') echo 'selected'; ?>>Entire Class</option>
                <option value="stream" <?php if ($print_mode == 'stream') echo 'selected'; ?>>By Stream</option>
            </select>
        </div>
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary">Generate Report(s)</button>
        </div>
    </form>
    <div class="no-print text-end my-3">
        <button onclick="window.print()" class="btn btn-primary">Print</button>
    </div>
    <?php foreach ($students_to_print as $student): ?>
    <div class="report-card">
        <div class="d-flex align-items-center mb-3">
            <img src="../<?php echo $student['photo_path'] ?: 'assets/images/logo.png'; ?>" class="school-logo me-3" alt="Kings Junior School Logo">
            <div>
                <h4 class="mb-0">KINGS JUNIOR SCHOOL</h4>
                <div class="text-muted">STUDENTS REPORT CARD GENERATION SYSTEM</div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6"><strong>Name:</strong> <?php echo htmlspecialchars($student['full_name']); ?></div>
            <div class="col-md-3"><strong>Stream:</strong> <?php echo htmlspecialchars($student['stream']); ?></div>
            <div class="col-md-3"><strong>Admission #:</strong> <?php echo htmlspecialchars($student['admission_number']); ?></div>
        </div>
        <div class="mb-2"><strong><?php echo strtoupper($exam_type); ?> ASSESSMENT REPORT <?php echo $term ? $term['year'] : ''; ?></strong></div>
        <table class="table table-bordered table-striped align-middle mb-4">
            <thead class="table-primary">
                <tr>
                    <th>Subject</th>
                    <th>Max</th>
                    <th>Marks</th>
                    <th>Grade</th>
                    <th>Remarks</th>
                    <th>Initials</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0; $agg = 0; $main_subjects = 0; $main_total = 0; $main_agg = 0;
                foreach ($subjects as $subject):
                    $mark = $pdo->prepare('SELECT * FROM marks WHERE student_id=? AND subject_id=? AND term_id=? AND exam_type=?');
                    $mark->execute([$student['id'], $subject['id'], $term_id, $exam_type]);
                    $mark = $mark->fetch();
                    $score = $mark ? $mark['marks'] : 0;
                    list($grade, $remark, $division) = get_grading($grading, $score);
                    $total += $score;
                    if ($subject['is_core']) {
                        $main_subjects++;
                        $main_total += $score;
                        $main_agg += $division;
                    }
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($subject['subject_name']); ?></td>
                    <td><?php echo htmlspecialchars($subject['max_score']); ?></td>
                    <td><?php echo $score; ?></td>
                    <td><?php echo $grade; ?></td>
                    <td><?php echo $mark ? htmlspecialchars($mark['remarks']) : ''; ?></td>
                    <td><!-- Initials can be added here if needed --></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row mb-2">
            <div class="col-md-4"><strong>Total:</strong> <?php echo $total; ?></div>
            <div class="col-md-4"><strong>Aggregates (Main 4):</strong> <?php echo $main_agg; ?></div>
            <div class="col-md-4"><strong>Division:</strong> <?php echo $main_agg ? $main_agg : '-'; ?></div>
        </div>
        <?php
        // Fetch the major subject comment for this main_total
        $major_comment_stmt = $pdo->prepare('SELECT * FROM major_subject_comments WHERE total = ?');
        $major_comment_stmt->execute([$main_total]);
        $major_comment = $major_comment_stmt->fetch();
        if ($major_comment) {
            $teacher_comment = $major_comment['teacher_comment'];
            $head_comment = $major_comment['headteacher_comment'];
        } else {
            list($teacher_comment, $head_comment) = get_comment($comments, $main_total);
        }
        ?>
        <div class="mb-2"><strong>Class Teacher's Comment:</strong> <?php echo $teacher_comment; ?></div>
        <div class="mb-2"><strong>Headteacher's Comment:</strong> <?php echo $head_comment; ?></div>
        <div class="mb-4">
            <table class="table table-bordered grading-table">
                <thead class="table-light">
                    <tr><th colspan="5" class="text-center">Grading Scale</th></tr>
                    <tr><th>Min</th><th>Max</th><th>Grade</th><th>Remark</th><th>Division</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($grading as $g): ?>
                    <tr>
                        <td><?php echo $g['min_mark']; ?></td>
                        <td><?php echo $g['max_mark']; ?></td>
                        <td><?php echo $g['grade']; ?></td>
                        <td><?php echo $g['remark']; ?></td>
                        <td><?php echo $g['division']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="footer-motto">We Hold The Future</div>
    </div>
    <?php endforeach; ?>
</div>
</body>
</html> 