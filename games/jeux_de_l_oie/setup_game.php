<?php
session_start();

// S'assure que le formulaire vient bien du POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['playerCount'] = intval($_POST['playerCount']);
    $_SESSION['gameMode'] = 'pvp'; // par défaut PVP

    // Redirection vers le plateau du jeu (GET)
    header("Location: game.php");
    exit;
}

// Si accès direct à setup_game.php
header("Location: index.php");
exit;
