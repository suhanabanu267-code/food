<?php
// db.php — central database connection file

$host = "localhost";              // or the server host if different
$dbname = "NP03CS4A240117";       // your database name
$username = "NP03CS4A240117";     // your DB username
$password = "zOg1X24ldf";   // replace with your actual password

try {
    // Create a single PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set error mode to exception for debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
