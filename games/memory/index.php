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
                        <option value="6x6">6x6</option>
                        <option value="8x8">8x8</option>
                    </select>
                </div>

                <div class="control">
                    <label for="thème">THEMES</label>
                    <select id="thème">
                        <option value="Hollow_knight">Hollow Knight</option>
                        <option value="Hollow_Knight_silksong">Hollow Knight Silksong</option>
                        <option value="Ori">Ori</option>
                    </select>
                </div>
                <button id="generate-btn">Generate a grid</button>
            </div>

            <div class="grid">
            </div>
        </section>

        <script>
        let flippedCards = [];
        let lockboard = false;

        document.addEventListener('click', function(event) {
            const card = event.target.closest('.card');

            // Si la cible n'est pas la carte
            if(!card) return;

            if(lockboard) return; // Cooldown

            if(card.classList.contains("matched")) return; // empeche de clicker sur une carte deja retourner
            
            // Ajouter la classe flipped : ON FLIPPE LA CASE
            card.classList.toggle('flipped');

            card.classList.add("flipped");

            // Ajouter dans le tableau seulement si moins de 2 élements
            if(flippedCards.length < 2) {
                // Verifier que la carte n'est pas déjà présente
                if(!flippedCards.includes(card)) {
                    flippedCards.push(card);
                }
            }
            
            // si 2 carte retourné -> verification (en dessous)
            if (flippedCards.length === 2)  checkMatch();
            
        });

        function checkMatch() {
            let [card1, card2] = flippedCards;
            let id1 = card1.dataset.id;
            let id2 = card2.dataset.id;

            console.log(id1, id2);

            if (id1 === id2) {
                // si match
                card1.classList.add("matched");
                card2.classList.add("matched");
                flippedCards = [];
            } else {
                // si non match -> retourne
                lockBoard = true; // blocage
                setTimeout(() => {
                    flippedCards = [];
                    lockBoard = false; // deblocage
                    card1.classList.remove("flipped");
                    card2.classList.remove("flipped");
                }, 1000);
            }
        }
        </script>

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
    // partie simple
    const USER_ID = <?= json_encode($_SESSION['user_id'] ?? 0) ?>;
    const chatBody = document.querySelector('.chat-body');
    const chatInput = document.querySelector('.chat-input input');

    const chatToggle = document.getElementById('chat-toggle');
    const chatBox = document.querySelector('.chatbox');


    // partie complex
    // chatbox hide
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

    // Envoie un GIF de chat au chargement de la page

    function sendRandomCatGif() {
        fetch("https://api.thecatapi.com/v1/images/search?mime_types=gif")
        .then(res => res.json())
        .then(data => {
            if (!data[0] || !data[0].url) return;

            const
        })
    }

    // refresh

    setInterval(loadMessages, 10000);
    loadMessages();

    //function addition(a, b) {
    //    return a + b;
    //}

    //function diff(a, b) {
    //    return a - b;
    //}

    //function prod(a, b) {
    //    return a * b;
    //}

    //function quo(a, b) {
    //    return a / b;
    //}


    </script>

    </body>
    
</html>
