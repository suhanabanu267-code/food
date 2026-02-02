<?php
require '../config/db.php';

$term = $_GET['term'] . '%';
$stmt = $pdo->prepare("SELECT name FROM ingredients WHERE name LIKE ?");
$stmt->execute([$term]);

echo json_encode($stmt->fetchAll(PDO::FETCH_COLUMN));
