<?php
include '../includes/header.php';
require_once '../includes/db.php';

$student_id = $_GET['id'] ?? 0;
if (!$student_id) {
    header('Location: students.php');
    exit;
}

// Get student details
$stmt = $pdo->prepare('SELECT s.*, c.class_name FROM students s JOIN classes c ON s.class_id = c.id WHERE s.id = ?');
$stmt->execute([$student_id]);
$student = $stmt->fetch();

if (!$student) {
    header('Location: students.php');
    exit;
}

// Get student history
$stmt = $pdo->prepare('
    SELECT sh.*, 
           c1.class_name as from_class_name,
           c2.class_name as to_class_name,
           ay.year_label as academic_year,
           t.name as term_name
    FROM student_history sh
    LEFT JOIN classes c1 ON sh.from_class_id = c1.id
    LEFT JOIN classes c2 ON sh.to_class_id = c2.id
    LEFT JOIN academic_years ay ON sh.academic_year_id = ay.id
    LEFT JOIN terms t ON sh.term_id = t.id
    WHERE sh.student_id = ?
    ORDER BY sh.promoted_at DESC
');
$stmt->execute([$student_id]);
$history = $stmt->fetchAll();
?>

<div class="no-print my-3">
    <a href="students.php" class="btn btn-secondary">&larr; Back to Students</a>
</div>

<div class="container py-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="../<?php echo $student['photo_path'] ?: 'assets/images/logo-e.png'; ?>" 
                         alt="Student Photo" 
                         class="rounded-circle mb-3" 
                         style="width:120px; height:120px; object-fit:cover;">
                    <h4 class="card-title"><?php echo htmlspecialchars($student['full_name']); ?></h4>
                    <p class="text-muted mb-1">Admission: <?php echo htmlspecialchars($student['admission_number']); ?></p>
                    <p class="text-muted mb-1">School Pay: <?php echo htmlspecialchars($student['school_pay_number']); ?></p>
                    <p class="text-muted mb-1">Current Class: <?php echo htmlspecialchars($student['class_name']); ?></p>
                    <p class="text-muted mb-0">Session: <?php echo htmlspecialchars($student['session']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Academic History</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($history)): ?>
                        <p class="text-muted">No history records found for this student.</p>
                    <?php else: ?>
                        <div class="timeline">
                            <?php foreach ($history as $record): ?>
                                <div class="timeline-item">
                                    <div class="timeline-marker <?php echo $record['to_class_id'] ? 'bg-primary' : 'bg-success'; ?>"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">
                                                    <?php if ($record['to_class_id']): ?>
                                                        Promoted to <?php echo htmlspecialchars($record['to_class_name']); ?>
                                                    <?php else: ?>
                                                        Graduated to Alumni
                                                    <?php endif; ?>
                                                </h6>
                                                <p class="text-muted mb-1">
                                                    From: <?php echo htmlspecialchars($record['from_class_name']); ?>
                                                    <?php if ($record['to_class_id']): ?>
                                                        → To: <?php echo htmlspecialchars($record['to_class_name']); ?>
                                                    <?php endif; ?>
                                                </p>
                                                <small class="text-muted">
                                                    <?php echo htmlspecialchars($record['academic_year']); ?> - 
                                                    <?php echo htmlspecialchars($record['term_name']); ?>
                                                </small>
                                            </div>
                                            <small class="text-muted">
                                                <?php echo date('M j, Y', strtotime($record['promoted_at'])); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e9ecef;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}
</style>

<?php include '../includes/footer.php'; ?> 