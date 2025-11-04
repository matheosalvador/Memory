<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="assets/css/index.css">
    <link rel="stylesheet" href="assets\css\main.css">
	<title>HOME</title>
</head>

    <?php include 'partials\header-terminé.php' ?>

    <body>	
        <section class="main">
            <div class="content">
                <img src="assets/images/Image-dilustration.png" alt="Image d'illustration">
                <div class="text">
                    <h6>OUR ...</h6>
                    <h4>Début de lorem sur fibra</h4>
                    <p>Description</p>
                    <a href="games.html" class="button">Start !</a>
                </div>
            </div>
        </section>

        <section class="games">
            <h3>Our games</h3>
            <div class="games-container">
                <figure>
                    <img src="assets/images/memory.jpg" alt="Power of memory game">
                    <figcaption>Memory Game</figcaption>
                </figure>
                <figure>
                    <img src="assets/images/game2.jpg" alt="game2">
                    <figcaption>Game 2</figcaption>
                </figure>
                <figure>
                    <img src="assets/images/game3.jpg" alt="game3">
                    <figcaption>Game 3</figcaption>
                </figure>
            </div>
        </section>
        <section class="info">
            <div class="infop">
                <span>Lorem ipsum sit amet, consectetur adipiscing elit</span>
            </div>
            <div class="inform">
                <div class="info-text">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <img id="imagescomplementaire" src="assets/images/image_complementaire.jpg" alt="Image complémentaire">
            </div>
        </section>
        <!-- Section Stats modifiée selon l'image -->
        <section class="stats">
            <img src="assets/images/statsi.jpg" alt="Background" class="stats-background">
            <div class="stats-header">
                <h2>Lorem ipsum is simply dummy text of the printing<br>and typesetting industry.</h2>
                <p>Lorem ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
            </div>
            
        <div class="stats-cards">
            <div class="stat-container">
                <p class="stat-number">310</p>
                <p class="stat-label">Games played</p>
            </div>
            <div class="stat-container">
                <p class="stat-number">1020</p>
                <p class="stat-label">Players online</p>
            </div>
            <div class="stat-container">
                <p class="stat-number">10s</p>
                <p class="stat-label">Record time</p>
            </div>
            <div class="stat-container">
                <p class="stat-number">9300</p>
                <p class="stat-label">Registered players</p>
            </div>
            <div class="stat-container">
                <p class="stat-number">2</p>
                <p class="stat-label">Reccords broken</p>
            </div>
        </div>
        </section>
        <section class="team">
            <h3>Our Team</h3>
            <div class="members">
                <figure>
                    <img src="assets/images/member1.png" alt="Photo de Member #1">
                    <figcaption>Member #1</figcaption>
                </figure>
                <figure>
                    <img src="assets/images/member2.png" alt="Photo de Member #2">
                    <figcaption>Member #2</figcaption>
                </figure>
                <figure>
                    <img src="assets/images/member3.png" alt="Photo de Member #3">
                    <figcaption>Member #3</figcaption>
                </figure>
            </div>
        </section>
        <section class="newsletter">
        <div class="container">
                <div class="text">
                    <h3>Stay informed</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse scelerisque in tortor vitae sollicitudin.</p>
                </div>
                <div class="form">
                    <input name="email" type="email" placeholder="Adresse email">
                    <button type="submit">Validate</button>
                </div>
            </div>
        </section>

        <?php include 'partials\footer-terminé.php' ?>

    </body>
</html>
