<?php
require '../config/db.php';
require '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        "INSERT INTO users (username, password, role)
         VALUES (?, ?, 'user')"
    );
    $stmt->execute([$username, $password]);

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="register-container">
    <h2>User Registration</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <button type="submit">Register</button>
    </form>


    <p>Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
