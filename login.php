<!-- Helper add into this page  -->
<?php require('utils/helper.php'); ?>

<!DOCTYPE HTML>
<html lang="en">
	<!-- Head -->
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?= getBaseUrl(); ?>\assets/css/login-register-style.css">
	<title>Login</title>
</head>
	<!-- Body -->
<body>
	<div id="login-register">
		<div class="flex">
			<div class="w-50">
				<div class="login-container flex">
						<!-- title and paraphe -->
					<h1 id="welcome">It's nice to see you again  👋</h1>
					<p id="details">zLorem ipsum dolor sit amet, consectetur adipiscing elit.
					Suspendisse scelerisque in tortor vitae sollicitudin.</p>
						<!-- email, password and sign in button  -->
					<form class="form-login" action="login.php" method="post">
						<label for="email">Email</label>
						<input id="check-email" name="email" type="email" placeholder="Example@email.com" required>
						<label for="password">Password</label>
						<input id="check-password" name="password" type="password" placeholder="Minimum 8 characters" required minlength="8">
						<a href="https://www.google.com/" id="link1"> Forgot Password? </a>
						<button id="check-button"><span id="txt-button">Connexion</span></button>
					</form>
						<!-- line -->
					<div class="flex align-items-center">
						<div class="border-bottom height-1 w-full">
						</div>
					<div class="flex bg-white p1">
						<span class="mt-3">Or</span>
					</div>
					<div class="border-bottom height-1 w-full">
					</div>
					</div>
						<!-- google button -->
					<button id="google-button">
					<div class="flex align-items-center justify-content-center gap-1">
						<img id="google" width="25px" src="assets\images\google.png"/>
						<span>Sign in with Google </span>
					</div>
					</button>	
				<!-- sign-up link -->
			<span id="txt-link1">Already have an account?<a href="register.php" id="link2" >Sign in</a></span>
		</div>
	</div>
	<div class="w-50">
		<img id="image" src="assets\images\Image.jpg" alt=""/>
	</div>
</div>
</body>
</html>