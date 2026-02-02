<?php
require '../config/db.php';
require '../includes/functions.php';
require_login();
include '../includes/header.php';

$keyword = $_GET['keyword'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM recipes WHERE title LIKE ? OR cuisine LIKE ?");
$stmt->execute(["%$keyword%","%$keyword%"]);
$recipes = $stmt->fetchAll();
?>

<h2>Search Recipes</h2>
<form method="GET">
    <input name="keyword" placeholder="Search by title or cuisine" value="<?= e($keyword) ?>">
    <button>Search</button>
</form>

<table>
<?php foreach($recipes as $r): ?>
<tr>
    <td><?= e($r['title']) ?></td>
    <td><?= e($r['cuisine']) ?></td>
    <td><?= e($r['difficulty']) ?></td>
</tr>
<?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>
