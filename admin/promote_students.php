<?php
include '../includes/header.php';
require_once '../includes/db.php';
require_once '../includes/audit.php';

// Get all classes ordered by id
$classes = $pdo->query('SELECT id FROM classes ORDER BY id')->fetchAll(PDO::FETCH_COLUMN);
$class_map = array_flip($classes); // class_id => index
$last_class_id = max($classes);

// Get current academic year and term
$year = $pdo->query('SELECT id FROM academic_years WHERE is_current = 1')->fetchColumn();
$term = $pdo->query('SELECT id FROM terms WHERE is_current = 1')->fetchColumn();

$promoted = 0;
$graduated = 0;
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_promotion'])) {
    // Get all students who are not alumni
    $students = $pdo->query("SELECT id, class_id FROM students WHERE session != 'Alumni'")->fetchAll();
    foreach ($students as $student) {
        $current_class = $student['class_id'];
        if ($current_class == $last_class_id) {
            // Graduate
            $stmt = $pdo->prepare("UPDATE students SET session = 'Alumni' WHERE id = ?");
            $stmt->execute([$student['id']]);
            // Record in history (to_class_id is NULL for alumni)
            $pdo->prepare("INSERT INTO student_history (student_id, from_class_id, to_class_id, academic_year_id, term_id) VALUES (?, ?, NULL, ?, ?)")
                ->execute([$student['id'], $current_class, $year, $term]);
            $graduated++;
        } else {
            // Promote
            $next_index = $class_map[$current_class] + 1;
            $next_class = $classes[$next_index] ?? $last_class_id;
            $stmt = $pdo->prepare("UPDATE students SET class_id = ? WHERE id = ?");
            $stmt->execute([$next_class, $student['id']]);
            // Record in history
            $pdo->prepare("INSERT INTO student_history (student_id, from_class_id, to_class_id, academic_year_id, term_id) VALUES (?, ?, ?, ?, ?)")
                ->execute([$student['id'], $current_class, $next_class, $year, $term]);
            $promoted++;
        }
    }
    
    // Log the promotion action
    $details = [
        'promoted_count' => $promoted,
        'graduated_count' => $graduated,
        'total_students' => $promoted + $graduated,
        'academic_year_id' => $year,
        'term_id' => $term
    ];
    logAuditAction($pdo, 'promote_students', "Promoted $promoted students and graduated $graduated to Alumni", $details);
    
    $success = "Promotion complete: $promoted students promoted, $graduated graduated to Alumni.";
}
?>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Promote Students to Next Class</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" onsubmit="return confirm('Are you sure you want to promote all students to the next class? This action cannot be undone.');">
        <button type="submit" name="confirm_promotion" class="btn btn-lg btn-success">Promote All Students</button>
    </form>
    <p class="mt-3 text-muted">This will move all students to the next class. Students in the last class will be marked as Alumni.</p>
</div>
<?php include '../includes/footer.php'; ?> 