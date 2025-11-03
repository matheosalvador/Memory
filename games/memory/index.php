<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/indexgames.css">
    <link rel="stylesheet" href="assets\css\main.css">
    <title>Games</title>
</head>
    <body>  

        <!-- header start (start at the top)-->
        <header>
            <img class="logohead" src="assets\images\logo_memory.png" alt="logo">
                <div class="nav-container">
                    <table>
                        <thead>
                            <th><a class="spaceh" href="index.html"> Home</a></th> <!-- redirection to home page-->
                            <th><a class="spaceh" href="scores.html"> Scores</a></th> <!-- redirection to scores page-->
                            <th><button><a href="contact.html">Contact us</a></button></th> <!-- redirection to contact page-->
                        </thead>
                    </table>
                </div>
        </header>
        <!-- header end -->

        <!-- memory.html -->
        <section class="memory-game">
            <h1>The Power Of Memory</h1>
            <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.  
            Suspendisse scelerisque in tortor vitae sollicitudin.
            </p>

            <div class="controls">
                <div class="control">
                    <label for="grid-size">GRID SIZE</label>
                    <select id="grid-size">
                        <option value="4x4">4x4</option>
                    </select>
                </div>

                <div class="control">
                    <label for="theme">THEMES</label>
                    <select id="theme">
                        <option value="game">Hollow Knight</option>
                        <option value="game">Hollow Knight Silksong</option>
                        <option value="game">Ori</option>
                    </select>
                </div>
                <button id="generate-btn">Generate a grid</button>
            </div>

            <div class="grid">
                <!-- 16 cartes blanches -->
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="assets/images/HK.png" alt=""></div>
            </div>
        </section>

    <!-- SECTION IMAGE + CHATBOX FINALE -->
    <section class="game-presentation">
        <div class="presentation-text">
            <h2>Lorem ipsum dolor sit amet,<br>consectetur adipiscing elit.</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Suspendisse scelerisque in tortor vitae sollicitudin.
                Aliquam lacus augue, rhoncus eget porta et, egestas ut augue.
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Suspendisse scelerisque in tortor vitae sollicitudin.
            </p>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Suspendisse scelerisque in tortor vitae sollicitudin.
            </p>
            <button class="play-btn">Jouer</button>
        </div>

        <div class="presentation-image">
            <img src="assets/images/manette.png" alt="Manette de jeu" class="gamepad">
            <div class="chatbox">
                <div class="chat-header">Power Of Memory</div>
                <div class="chat-body">
                    <div class="message left">
                        <span class="sender">TM</span>
                        <div class="bubble">👋 Hey ! Bien joué Clément !</div>
                    </div>
                    <div class="message right">
                        <div class="bubble red">Yes ! Bien joué Clément !</div>
                        <span class="time">Il y a 2 minutes</span>
                    </div>
                    <div class="message left">
                        <span class="sender">CP</span>
                        <div class="bubble">Merci beaucoup !!</div>
                        <span class="time">À l’instant</span>
                    </div>
                </div>
                <div class="chat-input">
                    <input type="text" placeholder="Votre message..." disabled>
                </div>
            </div>
        </div>
    </section>

        <!-- start of footer (start at the bottom) -->
        <footer>
            <div class="fhead">
                <div class="tabl0">
                    <p> <img src="assets\images\logo_memory.png" alt="logo" id="logo"></p>
                    <p>Our games offer an entertaining experience<br /> and make you work on your thinking!</p>
                </div>
                <div class="tabl1">
                    <h4>Menu</h4> <!-- redirections -->
                    <a href="index.html">Home</a>
                    <a href="scores.html">Scores</a>
                    <a href="contact.html">contact</a>
                </div>
                <div class="tabl2"> <!-- sum text :> -->
                    <h4>Contact us</h4><br />
                    <span>We are at your<br />disposal for<br /> any questions.</span>
                    <br />
                    <p>contact@web.com</p>
                    <br />
                </div>
                <div id="links"> <!-- links for facebook, instagram, twitter and linkedin -->
                    <a href="https://www.facebook.com/profile.php?id=61581419054379"><img src="assets\images\facebook_logo.png" alt="Facebook" class="linka"></a>
                    <a href="https://x.com/MemoryContact"><img src="assets\images\twitter_logo.png" alt="Twitter" class="linka"></a>
                    <a href="https://www.instagram.com/contact.memory.games/"><img src="assets\images\instagram_logo.png" alt="Instagram" class="linka"></a>
                    <a href="https://www.linkedin.com/in/memory-games-168488388/"><img src="assets\images\linkedin_logo.png" alt="linkdin" class="linka"></a>
                </div>

            </div>
            <hr> <!-- line -->
            <div id="endf">
                <span>© 2025 all rights reserved</span>
            </div>
        </footer>
        <!-- end of footer -->

    </body>
</html>
