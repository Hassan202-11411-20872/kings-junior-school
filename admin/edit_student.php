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
    $admission_number = trim($_POST['admission_number']);
    $full_name = trim($_POST['full_name']);
    $class_id = $_POST['class_id'];
    $stream = trim($_POST['stream']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $parent_name = trim($_POST['parent_name']);
    $parent_phone = trim($_POST['parent_phone']);
    $address = trim($_POST['address']);
    $photo_path = $student['photo_path'];
    if (!empty($_FILES['photo']['name'])) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photo_path = 'uploads/students/' . $admission_number . '.' . $ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], '../' . $photo_path);
    }
    $stmt = $pdo->prepare('UPDATE students SET admission_number=?, full_name=?, class_id=?, stream=?, photo_path=?, dob=?, gender=?, parent_name=?, parent_phone=?, address=? WHERE id=?');
    try {
        $stmt->execute([$admission_number, $full_name, $class_id, $stream, $photo_path, $dob, $gender, $parent_name, $parent_phone, $address, $id]);
        $success = 'Student updated successfully!';
        // Refresh student data
        $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
        $stmt->execute([$id]);
        $student = $stmt->fetch();
    } catch (PDOException $e) {
        $error = 'Error: ' . $e->getMessage();
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
            <input type="text" name="admission_number" class="form-control" value="<?php echo htmlspecialchars($student['admission_number']); ?>" required>
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
                <img src="/<?php echo $student['photo_path']; ?>" alt="Photo" style="width:60px; height:60px; object-fit:cover; border-radius:50%; margin-bottom:10px;">
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
            <label class="form-label">Parent Name</label>
            <input type="text" name="parent_name" class="form-control" value="<?php echo htmlspecialchars($student['parent_name']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Parent Phone</label>
            <input type="text" name="parent_phone" class="form-control" value="<?php echo htmlspecialchars($student['parent_phone']); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control"><?php echo htmlspecialchars($student['address']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Student</button>
    </form>
</div>
<?php include '../includes/footer.php'; ?> 