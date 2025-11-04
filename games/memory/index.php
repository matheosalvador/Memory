<?php require('../../utils/helper.php'); ?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>\assets\css\indexgames.css">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>\assets\css\main.css">
    <title>Games</title>
</head>
    <body>  

        <?php include "../../partials\header-terminé.php" ?>

        <!-- memory.php -->
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
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/memory_Card.jpg" alt=""></div>
                <div class="card"><img src="../../assets/images/HK.png" alt=""></div>
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

    <?php include "../../partials/footer-terminé.php" ?>

    </body>
</html>
