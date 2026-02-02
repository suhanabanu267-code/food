<?php
require '../config/db.php';
require '../includes/functions.php';
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $username = $_POST['username'];
    $password = $_POST['password'];
    $roleChoice = $_POST['role'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($roleChoice === 'admin') {
            header("Location: index.php");
        } else {
            header("Location: user_dashboard.php");
        }
        exit;
    }

    $error = "Invalid login credentials";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="login-container">
    <h2>Login</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <!-- two buttons with different values -->
        <button type="submit" name="role" value="admin">Login as Admin</button>
        <button type="submit" name="role" value="user">Login as User</button>
    </form>

    <?php if(isset($error)): ?>
        <div class="login-error"><?= e($error) ?></div>
    <?php endif; ?>

    <p>Don’t have an account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
