<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Food Recipe Database</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h1>Food Recipe Database</h1>

<nav>
    <a href="index.php">Home</a>

    <?php if (is_admin()): ?>
  
        <a href="add.php">Add Recipe</a>
    <?php endif; ?>

    <a href="search.php">Search</a>
    <a href="logout.php" style="color:red;">Logout</a>
</nav>

<hr>
<div class="container">
