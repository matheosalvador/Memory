<?php
session_start();
require('../../utils/helper.php');
require_once '../../utils/update_last_activity.php';
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>\assets\css\indexgames.css">
    <link rel="stylesheet" href="<?= getBaseUrl(); ?>\assets\css\main.css">
    <link rel="icon" type="image/png" href="<?= getBaseUrl(); ?>/assets/images/favicon.ico">
    <title>Games</title>
</head>

    <body>  

        <?php 
        include "../../partials/header-terminé.php";
        ?>
        <div class="audio-settings">
            <button id="soundToggle" class="gear-btn">⚙️</button> 
            <div id="sound-panel" class="sound-panel hidden">
                <label>Background music: <input id="bgVolume" type="range" min="0" max="1" step="0.01" value="0.5"></label>
                <label>SFX volume: <input id="sfxVolume" type="range" min="0" max="1" step="0.01" value="0.5"></label>
            </div>
        </div>

        <!-- memory.php -->
        <section class="memory-game">
            <h1 class="wwline">The Power Of Memory</h1>
            <p class="wwline">
            Match all the cards to win the game!<br>
            (Quick info : we've added sound! You can adjust the volume at the top of the page.)
            </p>

            <div class="controls">
                <div class="control">
                    <label for="gridsizes">GRID SIZE</label>
                    <select id="gridsizes">
                        <option value="4x4">4x4</option>
                        <option value="6x6">6x6</option>
                        <option value="8x8">8x8</option>
                    </select>
                </div>

                <div class="control">
                    <label for="themes">THEMES</label>
                    <select id="themes">
                        <option id="theme1" value="Hollow_knight">Hollow Knight</option>
                        <option id="theme2" value="Minecraft">Minecraft</option>
                        <option id="theme3" value="The_Legend_Of_Zelda">The Legend Of Zelda</option>
                    </select>
                </div>
                <button id="generatebtn">Generate a grid</button>
                <button id="playbtn">Start</button>
                <div id="timer" class="timer">00:00</div>
            </div>

            <div class="grid">
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
            <button class="play-btn">Play</button>
        </div>

        <div class="presentation-image">
            <img src="../../assets/images/manette.png" alt="Manette de jeu" class="gamepad">

            <div class="chatbox">
                <div class="chat-header">Power Of Memory</div>
                <div class="chat-body"></div>
                <div class="chat-input">
                    <input type="text" placeholder="Your message...">
                </div>
            </div>

        </div>

    </section>

    <button id="chat-toggle" title="Chat" aria-label="Open chat">
        &#9650; <!-- arrow up -->
    </button>

    <script src="<?= getBaseUrl(); ?>/assets/js/indexg.js"></script>
    <script src="<?= getBaseUrl(); ?>/assets/js/burger.js"></script>
    <?php include "../../partials/footer-terminé.php" ?>


    <script>
    // partie ez
    const USER_ID = <?= json_encode($_SESSION['user_id'] ?? 0) ?>;
    const chatBody = document.querySelector('.chat-body');
    const chatInput = document.querySelector('.chat-input input');

    const chatToggle = document.getElementById('chat-toggle');
    const chatBox = document.querySelector('.chatbox');


    // partie chiante
    // chatbox hide
    chatBox.style.display = 'none';

    chatToggle.addEventListener('click', () => {
        const isOpen = chatBox.style.display === 'flex';
        chatBox.style.display = isOpen ? 'none' : 'flex';
        chatToggle.classList.toggle('open', !isOpen);
    });

    function loadMessages(callback = null) {
        fetch("../../actions/chat.php?action=load")
        .then(res => res.json())
        .then(messages => {
            chatBody.innerHTML = "";
            messages.forEach(msg => { // boucle
                const isMe = msg.user_id == USER_ID;
                const isImage = /\.(gif|png|jpg|jpeg)$/i.test(msg.message);
                const content = isImage
                    ? `<img src="${msg.message}" class="chat-gif">`
                    : msg.message;

                chatBody.innerHTML += `
                    <div class="message ${isMe ? "right" : "left"}">
                        <span class="sender">${isMe ? "You" : msg.pseudo}</span>
                        <div class="bubble ${isMe ? "red" : ""}">
                            ${content}
                        </div>
                        <span class="time">${msg.created_at}</span>
                    </div>
                `;
            });
            chatBody.scrollTop = chatBody.scrollHeight;
            
            // gif chat aléa
            const userGifs = Array.from(chatBody.querySelectorAll('.right .chat-gif'));
            if(userGifs.length) {
                const lastGif = userGifs[userGifs.length - 1];
                fetch('https://api.thecatapi.com/v1/images/search?mime_types=gif')
                    .then(res => res.json())
                    .then(data => {
                        if (data[0] && data[0].url) {
                            lastGif.src = data[0].url;
                        }
                    });
            }
        });
    }
    //send
    chatInput.addEventListener("keypress", function(e) {
        if (e.key === "Enter") {
            const msg = chatInput.value.trim();

            // Vérification côté navigateur
            if (msg.length < 3) {
                alert("Votre message doit contenir au moins 3 caractères.");
                return;
            }

            fetch("../../actions/chat.php?action=send", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "message=" + encodeURIComponent(msg)
            })
            .then(res => res.json())
            .then(data => {
                console.log("SEND RESPONSE:", data);

                if (data.status === "OK") {
                    chatInput.value = "";
                    loadMessages();
                } else {
                    console.error("Erreur send:", data);
                }
            });
        }
    });

    //message_privée

    // refresh
    setInterval(loadMessages, 10000);
    loadMessages();

    </script>

    </body>
    
</html>
