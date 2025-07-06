<?php
include '../includes/header.php';
require_once '../includes/db.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
$stmt->execute([$id]);
$student = $stmt->fetch();
if (!$student) {
    echo '<div class="alert alert-danger">Student not found.</div>';
    include '../includes/footer.php';
    exit;
}
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
        // Check if school pay number already exists (excluding current student)
        $check_stmt = $pdo->prepare('SELECT id FROM students WHERE school_pay_number = ? AND id != ?');
        $check_stmt->execute([$school_pay_number, $id]);
        if ($check_stmt->fetch()) {
            $error = 'Error: School Pay Number "' . htmlspecialchars($school_pay_number) . '" already exists. Please use a different code.';
        } else {
            $photo_path = $student['photo_path'];
            if (!empty($_FILES['photo']['name'])) {
                $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $photo_path = 'uploads/students/' . $student['admission_number'] . '.' . $ext;
                move_uploaded_file($_FILES['photo']['tmp_name'], '../' . $photo_path);
            }
            $stmt = $pdo->prepare('UPDATE students SET school_pay_number=?, full_name=?, class_id=?, stream=?, photo_path=?, dob=?, gender=?, session=? WHERE id=?');
            try {
                $stmt->execute([$school_pay_number, $full_name, $class_id, $stream, $photo_path, $dob, $gender, $session, $id]);
                $success = 'Student updated successfully!';
                // Refresh student data
                $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
                $stmt->execute([$id]);
                $student = $stmt->fetch();
            } catch (PDOException $e) {
                $error = 'Error: ' . $e->getMessage();
            }
        }
    }
}
?>
<div class="no-print my-3">
    <a href="students.php" class="btn btn-secondary">&larr; Back to Students</a>
</div>
<div class="container py-5">
    <h2 class="mb-4 text-primary">Edit Student</h2>
    <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="card p-4 shadow-lg" style="max-width:600px;margin:auto;">
        <div class="mb-3">
            <label class="form-label">Admission Number</label>
            <input type="text" name="admission_number" class="form-control" value="<?php echo htmlspecialchars($student['admission_number']); ?>" readonly>
            <div class="form-text">Admission number is auto-generated and cannot be changed.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">School Pay Number</label>
            <input type="text" name="school_pay_number" class="form-control" value="<?php echo htmlspecialchars($student['school_pay_number']); ?>" required pattern="^\d{10}$" placeholder="1009603679">
            <div class="form-text">Enter the official 10-digit numeric School Pay Number (e.g., 1009603679).</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($student['full_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Class</label>
            <select name="class_id" class="form-select" required>
                <option value="">Select Class</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php if ($student['class_id'] == $c['id']) echo 'selected'; ?>><?php echo $c['class_name'] . ' (' . $c['section'] . ')'; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Stream</label>
            <input type="text" name="stream" class="form-control" value="<?php echo htmlspecialchars($student['stream']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Photo</label><br>
            <?php if ($student['photo_path']): ?>
                <img src="../<?php echo $student['photo_path']; ?>" alt="Photo" style="width:60px; height:60px; object-fit:cover; border-radius:50%; margin-bottom:10px;">
            <?php endif; ?>
            <input type="file" name="photo" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control" value="<?php echo htmlspecialchars($student['dob']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select">
                <option value="">Select Gender</option>
                <option value="Male" <?php if ($student['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($student['gender'] == 'Female') echo 'selected'; ?>>Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Session</label>
            <select name="session" class="form-select" required>
                <option value="Day Scholar" <?php if ($student['session'] == 'Day Scholar') echo 'selected'; ?>>Day Scholar</option>
                <option value="Boarding Scholar" <?php if ($student['session'] == 'Boarding Scholar') echo 'selected'; ?>>Boarding Scholar</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Student</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 