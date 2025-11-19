<!-- Helper add into this page  -->
<?php require('utils/helper.php');
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

    <!-- Head -->
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/login-register-style.css">
        <link rel="icon" type="image/png" href="<?= getBaseUrl(); ?>/assets/images/favicon.ico">
        <title>Register</title>
    </head>
    <!-- Body -->
    <body>
    <div id="login-register">
        <div class="flex">
            <div class="w-50">
                <div class="login-container flex">

                    <!-- title and paraphe -->
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
                        <input class="input" name="email" type="email" placeholder="Example@email.com" required value="<?= htmlspecialchars($old['email']) ?>">
                        <label for="pseudo">Pseudo</label>
                        <input class="input" name="pseudo" type="text" placeholder="4 characters min" required value="<?= htmlspecialchars($old['pseudo']) ?>">
                        <label for="password">Password</label>
                        <input class="input" name="password" id="password" type="password" placeholder="Minimum 8 characters" required minlength="8">

                        <!-- barre de sécu mdp -->
                        <div id="password-strength" class="password-strength">
                            <div class="strength-bar"></div>
                            <span class="strength-text"></span>
                        </div>

                        <label for="confirm_password">Confirm Password</label>
                        <input class="input" name="confirm_password" type="password" placeholder="Confirm password" required minlength="8">
                        <button type="submit" id="check-button"><span id="txt-button">Registration</span></button>

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
                    
                    <!-- Google button -->
                    <button id="google-button">
                        <div class="flex align-items-center justify-content-center gap-1">
                            <img id="google" width="25px" src="assets/images/google.png"/>
                            <span>Sign up with Google</span>
                        </div>
                    </button>

                    <!-- No Account TXT and Link -->
                    <span id="txt-link1">No account?<a href="login.php" id="link2" >Sign up</a></span>
                </div>
            </div>
        </form>
            <div class="w-50">
                <img id="image" src="assets/images/Image.jpg" alt=""/>
            </div>
        </div>
    </div>



    <script>
    const passwordInput = document.getElementById('password');
    const strengthBar = document.querySelector('.strength-bar');
    const strengthText = document.querySelector('.strength-text');

    passwordInput.addEventListener('input', () => {
        const val = passwordInput.value;
        let score = 0;

        const hasMinLength = val.length >= 8;
        const hasUpper = /[A-Z]/.test(val);
        const hasNumber = /\d/.test(val);
        const hasSpecial = /[\W_]/.test(val);

        if(hasMinLength) score++;
        if(hasUpper) score++;
        if(hasNumber) score++;
        if(hasSpecial) score++;

        switch(score) {
            case 0:
            case 1:
                strengthBar.style.width = "25%";
                strengthBar.style.backgroundColor = "red";
                strengthText.textContent = 'Weak';
                break;
            case 2:
            case 3:
                strengthBar.style.width = "60%";
                strengthBar.style.backgroundColor = "orange";
                strengthText.textContent = 'Medium';
                break;
            case 4:
            case 5:
                strengthBar.style.width = "100%";
                strengthBar.style.backgroundColor = "green";
                strengthText.textContent = 'Strong';
                break;
        }
    });
    </script>



    </body>
</html>
