<?php
require '../config/db.php';
require '../includes/functions.php';

require_login();
include '../includes/header.php';

$stmt = $pdo->query("
    SELECT *
    FROM recipes
    ORDER BY id DESC
");
$recipes = $stmt->fetchAll();
?>

<h2>All Recipes</h2>

<table>
    <tr>
        <th>Title</th>
        <th>Cuisine</th>
        <th>Difficulty</th>
        <th>Ingredients</th>
        <th>Instructions</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>

<?php foreach ($recipes as $r): ?>

<?php
   
    $stmtIng = $pdo->prepare(
        "SELECT name FROM ingredients WHERE recipe_id = ?"
    );
    $stmtIng->execute([$r['id']]);

    $ingredientsArray = $stmtIng->fetchAll(PDO::FETCH_COLUMN);
    $ings = $ingredientsArray
        ? implode(', ', $ingredientsArray)
        : '—';
?>

<tr>
    <td><?= e($r['title']) ?></td>
    <td><?= e($r['cuisine']) ?></td>
    <td><?= e($r['difficulty']) ?></td>
    <td><?= e($ings) ?></td>
    <td><?= nl2br(e($r['instructions'])) ?></td>

    <td>
        <?php if (!empty($r['image'])): ?>
            <img src="../uploads/<?= e($r['image']) ?>" alt="Recipe Image">
        <?php else: ?>
            —
        <?php endif; ?>
    </td>

    <td>
        <a href="edit.php?id=<?= $r['id'] ?>">Edit</a>

        <form
            method="POST"
            action="delete.php"
            style="display:inline;"
        >
            <input type="hidden" name="id" value="<?= $r['id'] ?>">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <button onclick="return confirm('Delete this recipe?')">
                Delete
            </button>
        </form>
    </td>
</tr>

<?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>
