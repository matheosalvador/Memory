<?php require('utils/helper.php'); ?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<!-- Head -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?= getBaseUrl(); ?>\assets\css\login-register-style.css">
	<title>Register</title>
</head>
<body>
<!-- Body -->
 <div id="login-register">
	<div class="flex">
		<div class="w-50">
		<!-- title and paraphe -->
			<div class="login-container flex"> 
					<h1 id="welcome">Welcome to our place ! 👋</h1>
					<p id="details">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					Suspendisse scelerisque in tortor vitae sollicitudin.</p>
					<!-- email, password and sign in button  -->
					<label for="email">Email</label>
					<input id="checkemail" name="email" type="email" placeholder="Example@email.com" required>
					<label for="password">Password</label>
					<input id="checkpassword" name="password" type="password" placeholder="Minimum 8 characters" required minlength="8">
					<label for="password">Confirm Password</label>
					<input id="checkpassword" name="confirm-password" type="password" placeholder="Minimum 8 characters" required minlength="8">
					<button id="checkbutton"><span id="txt-button">Sign in</span></button>
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
			<button id="google-button" ><img id="google" width="25px" hei src="assets\images\google.png"/>Sign in with Google</button>
				<span id="txtlink1">Don't have an account yet ?<a href="register.php" id="link2" >Sign up</a></span>
			</div>
		</div>
		<div class="w-50">
			<img id="image" src="assets\images\Image.jpg" alt=""/>
		</div>
	</div>
</body>
</html>