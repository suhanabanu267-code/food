<?php
require '../config/db.php';
require '../includes/functions.php';

require_login();
include '../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id=?");
$stmt->execute([$id]);
$recipe = $stmt->fetch();

if (!$recipe) {
    header("Location: index.php");
    exit;
}

$stmtIng = $pdo->prepare("SELECT name FROM ingredients WHERE recipe_id=?");
$stmtIng->execute([$id]);
$ingredientsArr = $stmtIng->fetchAll(PDO::FETCH_COLUMN);
$ingredients = implode(', ', $ingredientsArr);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    verify_csrf();

    $title = trim($_POST['title']);
    $cuisine = trim($_POST['cuisine']);
    $difficulty = $_POST['difficulty'];
    $instructions = trim($_POST['instructions']);
    $newIngredients = explode(',', $_POST['ingredients']);

 
    $stmt = $pdo->prepare(
        "UPDATE recipes SET title=?, cuisine=?, difficulty=?, instructions=? WHERE id=?"
    );
    $stmt->execute([$title, $cuisine, $difficulty, $instructions, $id]);

   
    $pdo->prepare("DELETE FROM ingredients WHERE recipe_id=?")->execute([$id]);

    $stmtIng = $pdo->prepare(
        "INSERT INTO ingredients (recipe_id, name) VALUES (?, ?)"
    );

    foreach ($newIngredients as $ing) {
        $ing = trim($ing);
        if ($ing !== '') {
            $stmtIng->execute([$id, $ing]);
        }
    }

    header("Location: index.php");
    exit;
}
?>

<h2>Edit Recipe</h2>

<form method="POST" class="container">

    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

    <input name="title" value="<?= e($recipe['title']) ?>" required>

    <input name="cuisine" value="<?= e($recipe['cuisine']) ?>" required>

    <select name="difficulty" required>
        <option <?= $recipe['difficulty']=='Easy'?'selected':'' ?>>Easy</option>
        <option <?= $recipe['difficulty']=='Medium'?'selected':'' ?>>Medium</option>
        <option <?= $recipe['difficulty']=='Hard'?'selected':'' ?>>Hard</option>
    </select>

    <input
        name="ingredients"
        value="<?= e($ingredients) ?>"
        placeholder="Ingredients (comma separated)"
        required
    >

    <textarea name="instructions" rows="5" required><?= e($recipe['instructions']) ?></textarea>

    <button type="submit">Update Recipe</button>
</form>

<?php include '../includes/footer.php'; ?>

