<?php
include 'includes/header.php';
require_once 'includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1');
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] === 'admin') {
            header('Location: admin/dashboard.php');
        } else {
            header('Location: teacher/dashboard.php');
        }
        exit;
    } else {
        $error = 'Invalid username/email or password.';
    }
}
?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%; animation: fadeInDown 1s;">
        <h3 class="text-center mb-4 text-primary">Login</h3>
        <?php if ($error): ?>
            <div class="alert alert-danger animated fadeInUp"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <div class="mb-3">
                <label for="username" class="form-label">Username or Email</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="register.php">Don't have an account? Register</a>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?> 