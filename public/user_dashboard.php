<?php
require '../config/db.php';
require '../includes/functions.php';

require_login(); 
if (is_admin()) {

    header("Location: index.php");
    exit;
}

include '../includes/header.php';


$stmt = $pdo->query("SELECT * FROM recipes ORDER BY id DESC");
$recipes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
  
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>User Dashboard</h2>
<p>Welcome, <?= e($_SESSION['user']) ?> 👋</p>
<p>You can view the recipes here</p>

<table>
    <tr>
        <th>Title</th>
        <th>Cuisine</th>
        <th>Difficulty</th>
        <th>Ingredients</th>
        <th>Image</th>
    </tr>

<?php foreach ($recipes as $r): ?>
<?php

    $stmtIng = $pdo->prepare("SELECT name FROM ingredients WHERE recipe_id = ?");
    $stmtIng->execute([$r['id']]);
    $ingredientsArray = $stmtIng->fetchAll(PDO::FETCH_COLUMN);
    $ings = $ingredientsArray ? implode(', ', $ingredientsArray) : '—';
?>
<tr>
    <td><?= e($r['title']) ?></td>
    <td><?= e($r['cuisine']) ?></td>
    <td><?= e($r['difficulty']) ?></td>
    <td><?= e($ings) ?></td>
    <td>
        <?php if (!empty($r['image'])): ?>
            <img src="../uploads/<?= e($r['image']) ?>" alt="Recipe Image" style="max-width:120px;">
        <?php else: ?>
            —
        <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
