<?php
require '../config/db.php';
require '../includes/functions.php';

require_login(); 
include '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    verify_csrf();


    $title = trim($_POST['title']);
    $cuisine = trim($_POST['cuisine']);
    $difficulty = $_POST['difficulty'];
    $instructions = trim($_POST['instructions']);
    $ingredients = explode(',', $_POST['ingredients']);

    $imageName = null;
    if (!empty($_FILES['image']['name'])) {

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            die("Only JPG, PNG, or WEBP images allowed.");
        }

        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            die("Image size must be less than 2MB.");
        }

        if (!is_dir("../uploads")) {
            mkdir("../uploads", 0777, true);
        }

        $imageName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/$imageName");
    }

    $stmt = $pdo->prepare(
        "INSERT INTO recipes (title, cuisine, difficulty, instructions, image)
         VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([$title, $cuisine, $difficulty, $instructions, $imageName]);

    $recipeId = $pdo->lastInsertId();


    $stmtIng = $pdo->prepare(
        "INSERT INTO ingredients (recipe_id, name) VALUES (?, ?)"
    );

    foreach ($ingredients as $ingredient) {
        $ingredient = trim($ingredient);
        if ($ingredient !== '') {
            $stmtIng->execute([$recipeId, $ingredient]);
        }
    }

    header("Location: index.php");
    exit;
}
?>

<h2>Add Recipe</h2>

<form method="POST" enctype="multipart/form-data" class="container">


    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

    <input type="text" name="title" placeholder="Recipe Title" required>

    <input type="text" name="cuisine" placeholder="Cuisine" required>

    <select name="difficulty" required>
        <option value="">Select Difficulty</option>
        <option value="Easy">Easy</option>
        <option value="Medium">Medium</option>
        <option value="Hard">Hard</option>
    </select>

    <input
        type="text"
        name="ingredients"
        id="ingredient"
        placeholder="Ingredients (comma separated)"
        required
    >

    <textarea
        name="instructions"
        placeholder="Cooking Instructions"
        rows="5"
        required
    ></textarea>

    <label>Recipe Image</label>
    <input type="file" name="image" id="imageInput" accept="image/*">

    <div id="imagePreview" style="margin-top:10px;"></div>

    <button type="submit">Add Recipe</button>
</form>

<script src="../assets/js/autocomplete.js"></script>

<!-- Image Preview -->
<script>
const imageInput = document.getElementById('imageInput');
const previewDiv = document.getElementById('imagePreview');

imageInput.addEventListener('change', function () {
    previewDiv.innerHTML = '';
    const file = this.files[0];
    if (file) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.maxWidth = '150px';
        img.style.borderRadius = '12px';
        img.style.boxShadow = '0 5px 15px rgba(0,0,0,0.08)';
        previewDiv.appendChild(img);
    }
});
</script>

<?php include '../includes/footer.php'; ?>
