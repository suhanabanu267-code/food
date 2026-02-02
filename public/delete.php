<?php
require '../config/db.php';
require '../includes/functions.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    verify_csrf();

    $id = $_POST['id'];

   
    $pdo->prepare("DELETE FROM ingredients WHERE recipe_id=?")->execute([$id]);

  
    $pdo->prepare("DELETE FROM recipes WHERE id=?")->execute([$id]);
}

header("Location: index.php");
exit;
