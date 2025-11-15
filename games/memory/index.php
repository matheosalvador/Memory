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

        <!-- memory.php -->
        <section class="memory-game">
            <h1 class="wwline">The Power Of Memory</h1>
            <p class="wwline">
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

    <script src="<?= getBaseUrl(); ?>/assets/js/burger.js"></script>

    <?php include "../../partials/footer-terminé.php" ?>

    <script>

    const USER_ID = <?= json_encode($_SESSION['user_id'] ?? 0) ?>;
    const chatBody = document.querySelector('.chat-body');
    const chatInput = document.querySelector('.chat-input input');

    const chatToggle = document.getElementById('chat-toggle');
    const chatBox = document.querySelector('.chatbox');


    //chatbox hide
    chatBox.style.display = 'none';

    chatToggle.addEventListener('click', () => {
        const isOpen = chatBox.style.display === 'flex';
        chatBox.style.display = isOpen ? 'none' : 'flex';
        chatToggle.classList.toggle('open', !isOpen);
    });

    function loadMessages() {
        fetch("../../actions/chat.php?action=load")
        .then(res => res.json())
        .then(messages => {
            chatBody.innerHTML = "";
            messages.forEach(msg => {
                const isMe = msg.user_id == USER_ID;
                chatBody.innerHTML += `
                    <div class="message ${isMe ? "right" : "left"}">
                        <span class="sender">${isMe ? "You" : msg.pseudo}</span>
                        <div class="bubble ${isMe ? "red" : ""}">
                            ${msg.message}
                        </div>
                        <span class="time">${msg.created_at}</span>
                    </div>
                `;
            });
            chatBody.scrollTop = chatBody.scrollHeight;
        })
    }

    // sending message
    chatInput.addEventListener("keypress", function(e) {
        if (e.key === "Enter" && chatInput.value.trim() !== "") {
            fetch("../../actions/chat.php?action=send", {
                method: "POST",
                headers: {"Content-Type": "application/x-www-form-urlencoded"},
                body: "message=" + encodeURIComponent(chatInput.value)
            })
            .then(res => res.text())
            .then(text => {
                console.log('send response:', text);  // <-- ça montre si OK ou erreur
                chatInput.value = "";
                loadMessages();
            });
        }
    });

    // refresh

    setInterval(loadMessages, 60000);
    loadMessages();

    </script>

    </body>
    
</html>
