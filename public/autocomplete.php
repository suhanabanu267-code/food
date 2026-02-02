<?php
require '../config/db.php';

if (isset($_GET['term'])) {
    $term = $_GET['term'] . '%';

    $stmt = $pdo->prepare("SELECT title FROM recipes WHERE title LIKE ? OR cuisine LIKE ? LIMIT 5");
    $stmt->execute([$term, $term]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_COLUMN));
}
?>

