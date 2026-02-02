<?php
// hash.php
$password = "admin123";   // your chosen password
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Hashed password: " . $hash;
?>
