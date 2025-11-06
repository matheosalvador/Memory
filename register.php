<?php
require('utils/helper.php');
session_start();

// Récupération des messages et anciennes valeurs
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
$old = $_SESSION['old'] ?? ['email' => '', 'pseudo' => ''];

// Nettoyage des sessions
unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login-register-style.css">
    <title>Register</title>
</head>

<body>
<div id="login-register">
    <div class="flex">
        <div class="w-50">
            <div class="login-container flex">
                <h1 id="welcome">Welcome to our place ! 👋</h1>
                <p id="details">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Suspendisse scelerisque in tortor vitae sollicitudin.</p>

                <!-- Affichage des erreurs / succès -->
                <?php if(!empty($errors)): ?>
                    <div class="errors">
                        <ul>
                            <?php foreach($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php elseif($success): ?>
                    <div class="success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <!-- Formulaire -->
                <form class="form-login" action="actions/register_action.php" method="post">
                    <label for="email">Email</label>
                    <input name="email" type="email" placeholder="Example@email.com" required value="<?= htmlspecialchars($old['email']) ?>">
                    
                    <label for="pseudo">Pseudo</label>
                    <input name="pseudo" type="text" placeholder="4 characters min" required value="<?= htmlspecialchars($old['pseudo']) ?>">
                    
                    <label for="password">Password</label>
                    <input name="password" type="password" placeholder="Minimum 8 characters" required minlength="8">
                    
                    <label for="confirm_password">Confirm Password</label>
                    <input name="confirm_password" type="password" placeholder="Confirm password" required minlength="8">
                    
                    <button type="submit" id="check-button"><span id="txt-button">Registration</span></button>
                </form>

                <!-- Google button -->
                <button id="google-button">
                    <div class="flex align-items-center justify-content-center gap-1">
                        <img id="google" width="25px" src="assets/images/google.png"/>
                        <span>Sign up with Google</span>
                    </div>
                </button>

                <span id="txt-link1">Already have an account?<a href="login.php" id="link2">Sign in</a></span>
            </div>
        </div>
        <div class="w-50">
            <img id="image" src="assets/images/Image.jpg" alt=""/>
        </div>
    </div>
</div>
</body>
</html>
