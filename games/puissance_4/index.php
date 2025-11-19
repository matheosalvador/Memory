<?php session_start(); $currentPage = 'puissance4.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Puissance 4</title>
    <link rel="stylesheet" href="puissance4.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main class="game-container">
        <h1>Puissance 4</h1>
        <div id="grid"></div>
        <button id="resetBtn">Rejouer</button>
    </main>

    <?php include 'footer.php'; ?>

    <script src="puissance4.js"></script>
</body>
</html>
