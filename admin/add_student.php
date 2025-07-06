<?php
include '../includes/header.php';
require_once '../includes/db.php';
require_once '../includes/audit.php';

// Fetch classes
$classes = $pdo->query('SELECT * FROM classes')->fetchAll();
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $school_pay_number = trim($_POST['school_pay_number']);
    // Validate format: 10-digit numeric code
    if (!preg_match('/^\d{10}$/', $school_pay_number)) {
        $error = 'School Pay Number must be a 10-digit numeric code (e.g., 1009603679).';
    } else {
        $full_name = trim($_POST['full_name']);
        $class_id = $_POST['class_id'];
        $stream = trim($_POST['stream']);
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $session = $_POST['session'];
        // Auto-generate admission_number if blank
        function generateAdmissionNumber($pdo) {
            $stmt = $pdo->query("SELECT admission_number FROM students WHERE admission_number LIKE 'KJS%' ORDER BY id DESC LIMIT 1");
            $last = $stmt->fetchColumn();
            if ($last && preg_match('/KJS(\\d+)/', $last, $matches)) {
                $num = intval($matches[1]) + 1;
            } else {
                $num = 1;
            }
            return 'KJS' . str_pad($num, 5, '0', STR_PAD_LEFT);
        }
        $admission_number = '';
        if (empty($admission_number)) {
            $admission_number = generateAdmissionNumber($pdo);
        }
        $photo_path = '';
        if (!empty($_FILES['photo']['name'])) {
            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $photo_path = 'uploads/students/' . $admission_number . '.' . $ext;
            move_uploaded_file($_FILES['photo']['tmp_name'], '../' . $photo_path);
        }
        $stmt = $pdo->prepare('INSERT INTO students (admission_number, school_pay_number, full_name, class_id, stream, photo_path, dob, gender, session) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        try {
            $stmt->execute([$admission_number, $school_pay_number, $full_name, $class_id, $stream, $photo_path, $dob, $gender, $session]);
            
            // Log the student addition
            $student_id = $pdo->lastInsertId();
            $details = [
                'student_id' => $student_id,
                'admission_number' => $admission_number,
                'school_pay_number' => $school_pay_number,
                'full_name' => $full_name,
                'class_id' => $class_id,
                'stream' => $stream,
                'session' => $session
            ];
            logAuditAction($pdo, 'add_student', "Added student: $full_name ($admission_number)", $details);
            
            $success = 'Student added successfully!';
        } catch (PDOException $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>
<div class="no-print my-3">
    <a href="students.php" class="btn btn-secondary">&larr; Back to Students</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Add Student</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="card p-4 shadow-lg" style="max-width:600px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">School Pay Number</label>
            <input type="text" name="school_pay_number" class="form-control" required pattern="^\d{10}$" placeholder="1009603679">
            <div class="form-text">Enter the official 10-digit numeric School Pay Number (e.g., 1009603679).</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Class</label>
            <select name="class_id" class="form-select" required>
                <option value="">Select Class</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['class_name'] . ' (' . $c['section'] . ')'; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Stream</label>
            <input type="text" name="stream" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Session</label>
            <select name="session" class="form-select" required>
                <option value="Day Scholar">Day Scholar</option>
                <option value="Boarding Scholar">Boarding Scholar</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Student</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 