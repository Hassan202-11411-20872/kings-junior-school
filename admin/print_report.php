<?php
require_once '../includes/db.php';
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
$grading = $pdo->query('SELECT * FROM grading_scale ORDER BY min_mark DESC')->fetchAll();
$comments = $pdo->query('SELECT * FROM comments ORDER BY min_marks ASC')->fetchAll();
$term_id = $_GET['term_id'] ?? '';
$exam_type = $_GET['exam_type'] ?? 'Mid Term';
$bulk = isset($_GET['bulk']);
$students = [];
if ($bulk) {
    $class_id = $_GET['class_id'] ?? '';
    $students = $pdo->prepare('SELECT * FROM students WHERE class_id = ?');
    $students->execute([$class_id]);
    $students = $students->fetchAll();
} else {
    $student_id = $_GET['student_id'] ?? 0;
    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
    $stmt->execute([$student_id]);
    $students = $stmt->fetchAll();
}
$term = $pdo->prepare('SELECT * FROM terms WHERE id = ?');
$term->execute([$term_id]);
$term = $term->fetch();
$class = null;
if ($students && isset($students[0]['class_id'])) {
    $class_stmt = $pdo->prepare('SELECT * FROM classes WHERE id = ?');
    $class_stmt->execute([$students[0]['class_id']]);
    $class = $class_stmt->fetch();
}
$subjects = [];
if ($class) {
    $subjects = $pdo->prepare('SELECT * FROM subjects WHERE class_id = ?');
    $subjects->execute([$class['id']]);
    $subjects = $subjects->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
</head>
<body style="background:#e3f2fd;">
<div class="container-fluid">
    <div class="no-print text-end my-3">
        <button onclick="window.print()" class="btn btn-primary">Print</button>
    </div>
    <?php foreach ($students as $student): ?>
    <div class="report-card">
        <div class="d-flex align-items-center mb-3">
                            <img src="../<?php echo $student['photo_path'] ?: 'assets/images/logo-e.png'; ?>" class="school-logo me-3" alt="Student Photo">
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
        <?php list($teacher_comment, $head_comment) = get_comment($comments, $main_total); ?>
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