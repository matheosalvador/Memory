<?php 
require('utils/helper.php');
session_start();

// Récupération des messages de session
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';

// Nettoyage après affichage
unset($_SESSION['errors'], $_SESSION['success']);
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?= getBaseUrl(); ?>\assets\css\login-register-style.css">
	<link rel="icon" type="image/png" href="<?= getBaseUrl(); ?>/assets/images/favicon.ico">
	<title>Login</title>
</head>

<body>
	<div id="login-register">
		<div class="flex">
			<div class="w-50">
				<div class="login-container flex">
					
					<!-- title and paraphe -->
					<h1 id="welcome">Welcome back 👋</h1>
					<p id="details">
						Enter your account information to access the game.
					</p>

					<!--  Affichage des messages -->
					<?php if (!empty($errors)): ?>
						<div class="errors" style="color: red; margin-bottom: 15px;">
							<ul>
								<?php foreach ($errors as $error): ?>
									<li><?= htmlspecialchars($error) ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php elseif ($success): ?>
						<div class="success" style="color: green; margin-bottom: 15px;">
							<?= htmlspecialchars($success) ?>
						</div>
					<?php endif; ?>

					<!--  Formulaire de connexion -->
					<form class="form-login" action="actions/login_action.php" method="post">
						<label for="email">Email</label>
						<input class="button" name="email" type="email" placeholder="Example@email.com" required>

						<label for="password">Password</label>
						<input class="button" name="password" type="password" placeholder="Minimum 8 characters" required minlength="8">

						<button type="submit" id="check-button">
							<span id="txt-button">Sign in</span>
						</button>
					

					<!-- Ligne de séparation -->
					<div class="flex align-items-center">
						<div class="border-bottom height-1 w-full"></div>
						<div class="flex bg-white p1">
							<span class="mt-3">Or</span>
						</div>
						<div class="border-bottom height-1 w-full"></div>
					</div>

					<!-- Bouton Google -->
					<button id="google-button">
						<div class="flex align-items-center justify-content-center gap-1">
							<img id="google" width="25px" src="assets/images/google.png" />
							<span>Sign in with Google</span>
						</div>
					</button>

					<!-- Lien vers inscription -->
					<span id="txt-link1">No account? <a href="register.php" id="link2">Sign up</a></span>
				</div>
			</div>
		</form>
			<div class="w-50">
				<img id="image" src="assets/images/Image.jpg" alt="login image" />
			</div>
		</div>
	</div>
</body>
</html>
