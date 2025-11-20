document.addEventListener("DOMContentLoaded", () => {

    let timerInterval = null;
    let milliseconds = 0;
    let lockBoard = false; // bloque le bouton "generate"
    let lockCards = false; // bloque les clics lors de comparaison
    let flippedCards = []; // follow les carte retourné
    

    const endgamePopup = document.getElementById('endgame-popup');
    const scoreValue = document.getElementById('score-value');
    const restartBtn = document.getElementById('restartbtn');
    const startBtn = document.getElementById('playbtn');
    const generateBtn = document.getElementById('generatebtn');
    const gridSizeS = document.getElementById('gridsizes');
    const themeS = document.getElementById('themes');
    const grid = document.querySelector(".grid");

    startBtn.disabled = true;
    startBtn.style.opacity = 0.3;

        // AUDIO (optionel mais on a voulu lol)
    let bgVolume = 0.5;
    let sfxVolume = 0.5;
    let currentBG = null;

    // bg music
    const bgMusics = {
        "Hollow_knight": new Audio("../../assets/audio/themes/HK/Fond.mp3"),
        "Minecraft": new Audio("../../assets/audio/themes/Minecraft/Fond.mp3"),
        "The_Legend_Of_Zelda": new Audio("../../assets/audio/themes/TLOZ/Fond.mp3")
    };

    // sfx carte match
    const matchSFX = {
        "Hollow_knight": new Audio("../../assets/audio/themes/HK/Matched.mp3"),
        "Minecraft": new Audio("../../assets/audio/themes/Minecraft/Matched.mp3"),
        "The_Legend_Of_Zelda": new Audio("../../assets/audio/themes/TLOZ/Matched.mp3")
    };

    // sfx win
    const winSFX = {
        "Hollow_knight": new Audio("../../assets/audio/themes/HK/Fin.mp3"),
        "Minecraft": new Audio("../../assets/audio/themes/Minecraft/Fin.mp3"),
        "The_Legend_Of_Zelda": new Audio("../../assets/audio/themes/TLOZ/Fin.mp3")
    };

    // boucle bg music
    Object.values(bgMusics).forEach(a => { a.loop = true; a.volume = bgVolume;});

    document.getElementById("bgVolume").addEventListener("input", e => {
        bgVolume = parseFloat(e.target.value);
        if (currentBG) currentBG.volume = bgVolume;
    });

    document.getElementById("sfxVolume").addEventListener("input", e => {
        sfxVolume = parseFloat(e.target.value);
        Object.values(matchSFX).forEach(audio => audio.volume = sfxVolume);
        Object.values(winSFX).forEach(audio => audio.volume = sfxVolume);
    });

    // fct de melange des cartes
    function shuffle(array) {
        let i = array.length, j, temp;
        while (i--) {
            j = Math.floor(Math.random() * (i + 1));
            temp = array[i];
            array[i] = array[j];
            array[j] = temp;
        }
        return array;
    }

    const soundToggle = document.getElementById("soundToggle");
    const soundpanel = document.getElementById("sound-panel");

    soundToggle.addEventListener("click", () => {
        soundpanel.classList.toggle("hidden");
    });

    // generation grid
    async function generateGrid() {


        lockBoard = false;
        flippedCards = []; // reset des cartes retournées
        lockCards = false;

        const size = gridSizeS.value;
        const theme = themeS.value;

        const pairsCount = {
            "4x4": 8,
            "6x6": 18,
            "8x8": 32
        }[size];

        // fetch dossier avec directory listing
        const response = await fetch(`../../assets/images/thèmes/${theme}/`);
        const text = await response.text();

        const files = [...text.matchAll(/href="([^"]+\.(png|jpg|jpeg|gif))"/gi)]
            .map(e => e[1]);

        // alerte si pas de carte trouvé
        if (files.length < pairsCount) {
            alert("Pas assez d’images dans ce thème !");
            lockBoard = false;
            return;
        }
        
        const selected = shuffle(files).slice(0, pairsCount);
        const finalCards = shuffle([...selected, ...selected]);

        // repetition deu placement des cartes
        grid.style.gridTemplateColumns = `repeat(${size.split("x")[0]}, 1fr)`;

        // generation cartes
        grid.innerHTML = finalCards.map(img => `
            <div class="card" data-id="${img}">
                <div class="card-inner">
                    <div class="card-front">
                        <img src="../../assets/images/back_card/${theme}/back_card.jpg" alt="dos de carte">
                    </div>
                    <div class="card-back">
                        <img src="../../assets/images/thèmes/${theme}/${img}" alt="carte">
                    </div>
                </div>
            </div>
        `).join("");

        // blocage
        generateBtn.disabled = false;
        gridSizeS.disabled = false;
        themeS.disabled = false;
        generateBtn.style.opacity = 1; // mrc blockbench
        gridSizeS.style.opacity = 1;
        themeS.style.opacity = 1;

        lockCards = true; // ajout
        startBtn.disabled = false; // ajout
        startBtn.style.opacity = 1; // ajout
    }

    // clics cartes
    grid.addEventListener("click", (event) => { 

        if (lockCards) return;

        const card = event.target.closest(".card");
        if(!card || card.classList.contains("flipped") || card.classList.contains("matched")) return;

        card.classList.add("flipped");
        flippedCards.push(card);

        if(flippedCards.length === 2) {
            checkMatch();
        }
    });

    // verification des pairs
    function checkMatch() {
        lockCards = true;

        const [card1, card2] = flippedCards;

        const id1 = card1.dataset.id;
        const id2 = card2.dataset.id;

        if(id1 === id2) {
            card1.classList.add("matched"); // match
            card2.classList.add("matched"); // match

            resetTurn();
            checkWin();

            // sons
            let matchAudio = matchSFX[themeS.value];
            console.log("matchAudio", matchAudio);
            matchAudio.currentTime = 0;
            matchAudio.play().catch(err => console.error(err));

        } else {
            setTimeout(() => {
                card1.classList.remove("flipped"); // pas match
                card2.classList.remove("flipped"); // pas match

                resetTurn();
            }, 1000);
        }
    }

    themeS.addEventListener("change", () => {
        startBtn.disabled = true;
        startBtn.style.opacity = 0.3;
    });

    gridSizeS.addEventListener("change", () => {
        startBtn.disabled = true;
        startBtn.style.opacity = 0.3;
    });

    // cooldown (jsp)
    function resetTurn() {
        flippedCards = [];
        lockCards = false; // libere de click
    }

    // animation de fin
    function playWinAnimation(callback) {
        const cards = Array.from(grid.querySelectorAll(".card"));
        if (cards.length === 0) return;

        //reset cards
        cards.forEach(card => {
            card.style.position = "";
            card.style.left = "";
            card.style.top = "";
            card.style.transition = "";
            card.style.transform = "";
            card.style.opacity = "";
            card.style.zIndex = "";
        });

        // video
        const video = document.createElement("video");
        video.src = '../../assets/video/bettergalaxy.mp4';
        video.autoplay = true;
        video.muted = true;
        video.playsInline = true;
        video.style.position = 'fixed';
        video.style.top = '0';
        video.style.left = '0';
        video.style.width = '100%';
        video.style.height = '100%';
        video.style.objectFit = 'cover';
        video.style.zIndex = '0';
        video.style.opacity = '0';
        video.style.transition = 'opacity 1s';
        document.body.appendChild(video);

        // fondu video debut
        setTimeout(() => video.style.opacity = '1', 50);

        // carte serpentin (mon idée lol)
        const cols = parseInt(gridSizeS.value.split("x")[0]);
        let serpentineOrder = [];

        const rows = cards.length / cols;

        for (let r = 0; r < rows; r++) {
            let rowCards = cards.slice(r * cols, r * cols + cols);
            if (r % 2 === 1) rowCards.reverse();
            serpentineOrder.push(...rowCards);
        }

        setTimeout(() => {

            const centerX = window.innerWidth / 2;
            const centerY = window.innerHeight / 2;

            serpentineOrder.forEach((card, i) => {
                const delay = i * (2500 / serpentineOrder.length); // 3s

                setTimeout(() => {
                    const rect = card.getBoundingClientRect();
                    // css relou
                    card.style.transition = "all 0.5s ease-in";
                    card.style.position = "fixed";
                    card.style.zIndex = "3000";
                    card.style.left = rect.left + "px";
                    card.style.top = rect.top + "px";

                    card.offsetWidth;

                    card.style.left = (centerX - rect.width / 2) + "px";
                    card.style.top = (centerY - rect.height / 2) + "px";
                    card.style.transform = "scale(0.2)";
                    card.style.opacity = "0";
                }, delay);
            });
        }, 500);

        // 4sec
        setTimeout(() => {
            video.style.opacity = "0";
            setTimeout(() => video.remove(), 1000);
        }, 4000);

        // 5sec (callback)
        setTimeout(() => {
            if (callback) callback();
        }, 5000);
    }

    // fct de win (si ta win gg)
    function checkWin() {
        const allMatched = [...grid.querySelectorAll(".card")].every(c => c.classList.contains("matched"));
        if(!allMatched) return;

        stopTimer(); // stop timer

        const presentationText = document.querySelector('.presentation-text');
        //text caché
        presentationText.style.opacity = '0';
        presentationText.style.transition = 'opacity 0.5s';

        if(currentBG) currentBG.pause(); // stop bg music
        let winAudio = winSFX[themeS.value];
        winAudio.currentTime = 0;
        winAudio.play();
    
        playWinAnimation(() => {

            //end animation
            const score = milliseconds / 1000;
            scoreValue.textContent = score;

            //réafficheage text
            presentationText.style.opacity = '1';
        
            endgamePopup.style.display = 'flex'; // ou 'block' selon votre CSS
            lockBoard = false;
            generateBtn.disabled = false;
            gridSizeS.disabled = false;
            themeS.disabled = false;
            startBtn.disabled = true;

            generateBtn.style.opacity = 1;
            gridSizeS.style.opacity = 1;
            themeS.style.opacity = 1;
            lockCards = true;
        });
        
    }

    restartBtn.addEventListener('click', () => {
        endgamePopup.style.display = 'none';
        generateGrid();
    });

    function startTimer() {
        clearInterval(timerInterval);
        milliseconds = 0;

        const timerDisplay = document.getElementById("timer");

        timerInterval = setInterval(() => {
            milliseconds+=10;

            let min = String(Math.floor(milliseconds / 60000)).padStart(2, "0");
            let sec = String(Math.floor((milliseconds % 60000) / 1000)).padStart(2, "0");
            let ms = String(Math.floor((milliseconds % 1000) / 10)).padStart(2, "0");
            timerDisplay.textContent = `${min}:${sec}:${ms}`;
        }, 10);
    }

    // countdown (pendant l'animation)
    function startcountdown(callback) {
        const overlay = document.createElement('div');
        overlay.style.position = 'fixed';
        overlay.style.top = '0';
        overlay.style.left = '0';
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.background = 'rgba(0,0,0,0.7)';
        overlay.style.display = 'flex';
        overlay.style.alignItems = 'center';
        overlay.style.justifyContent = 'center';
        overlay.style.fontSize = '5rem';
        overlay.style.color = "#ffffff";
        overlay.style.zIndex = '2000';
        overlay.style.transition = 'opacity 0.3s';
        document.body.appendChild(overlay);

        const messages = ["Ready?", "3", "2", "1", "GO!"];
        let i = 0;

        // affichage de ready / 3 / 2 / 1 / go
        function showtext() {
            if (i >= messages.length) {
                overlay.style.opacity = '0';
                setTimeout(() => overlay.remove(), 500);
                if (callback) callback();
                return;
            }

            overlay.textContent = messages[i];
            overlay.style.opacity = '1'; // fondu debut

            setTimeout(() => {
                overlay.style.opacity = '0'; // fondu fin
                setTimeout(() => {
                    i++;
                    showtext();
                }, 500);
            }, 300);
        }
        showtext();
    }

    function stopTimer() {
        clearInterval(timerInterval);
    }

    // event bouton generation
    generateBtn.addEventListener("click", generateGrid);
    // btn animation de zinzin
    startBtn.addEventListener("click", () => {

        const presentationText = document.querySelector('.presentation-text');
        //text caché
        presentationText.style.opacity = '0';
        presentationText.style.transition = 'opacity 0.5s';
        
        lockCards = true;
        startBtn.disabled = true;
        generateBtn.disabled = true;
        gridSizeS.disabled = true;
        themeS.disabled = true;

        startBtn.style.opacity = 0.3;
        generateBtn.style.opacity = 0.3;
        gridSizeS.style.opacity = 0.3;
        themeS.style.opacity = 0.3;

        startcountdown();

        const cards = Array.from(grid.querySelectorAll('.card'));
        const gridRect = grid.getBoundingClientRect();
        const centerX = gridRect.left + gridRect.width / 2;
        const centerY = gridRect.top + gridRect.height / 2;

        //disparition carte tout début
        cards.forEach(card => {
            card.style.transition = 'opacity 0.5s';
            card.style.opacity = '0';
        });

        //video
        const video = document.createElement('video');
        video.src = '../../assets/video/bettergalaxy.mp4';
        video.autoplay = true;
        video.muted = true;
        video.playsInline = true;
        video.style.position = 'fixed';
        video.style.top = '0';
        video.style.left = '0';
        video.style.width = '100%';
        video.style.height = '100%';
        video.style.objectFit = 'cover';
        video.style.zIndex = '0';
        video.style.opacity = '0';
        video.style.transition = 'opacity 0.5s';
        document.body.appendChild(video);

        //fondu video debut
        setTimeout(() => video.style.opacity = '1', 50);

        //carte centre apparition
        setTimeout(() => {
            const radius = 300;
            const centerX = window.innerWidth / 2;
            const centerY = window.innerHeight / 2;

            cards.forEach((card, index) => {
                
                const angle = (index / cards.length) * Math.PI * 2;

                const x = centerX + Math.cos(angle) * radius;
                const y = centerY + Math.sin(angle) * radius;

                const rect = card.getBoundingClientRect();

                card.style.position = 'absolute';
                card.offsetWidth;
                card.style.left = `${x - rect.width / 2}px`;
                card.style.top = `${y - rect.height / 2}px`;
                card.style.opacity = '1';
                card.style.zIndex = '1000';
                card.style.transition = 'all 3s ease';
                card.style.transform = 'scale(1.4)';
                setTimeout(() => card.style.transform = 'scale(1)', 800);
            });
        }, 1000);

        //deplacement carte vers grille initiale
        setTimeout(() => {
            const parentRect = grid.getBoundingClientRect();
            const cols = parseInt(gridSizeS.value.split('x')[0]) || 4;

            //gap css
            const gridStyles = window.getComputedStyle(grid);
            const gap = parseInt(gridStyles.gap) || 0;

            cards.forEach((card, index) => {
                const row = Math.floor(index / cols);
                const col = index % cols;
                const cardWidth = card.offsetWidth;
                const cardHeight = card.offsetHeight;
                const finalLeft = parentRect.left + col * (cardWidth + gap);
                const finalTop = parentRect.top + row * (cardHeight + gap);

                card.style.left = `${finalLeft}px`;
                card.style.top = `${finalTop}px`;
            });
        }, 1300);

        //fin animation 4s après
        setTimeout(() => {
            cards.forEach(card => {
                card.style.position = '';
                card.style.left = '';
                card.style.top = '';
                card.style.transition = '';
                card.style.zIndex = '';
            });

            //fondu video fin
            video.style.opacity = '0';
            setTimeout(() => video.remove(), 500);

            //réafficheage text
            presentationText.style.opacity = '1';

            lockCards = false;

            // music + lancement timer
            if(currentBG) currentBG.pause();
            currentBG = bgMusics[themeS.value];
            currentBG.currentTime = 0;
            currentBG.volume = bgVolume;
            currentBG.play();

            startTimer();
        }, 4400);
    });

});