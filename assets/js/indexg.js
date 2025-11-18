document.addEventListener("DOMContentLoaded", () => {

    let lockBoard = false; // bloque le bouton "generate"
    let lockCards = false; // bloque les clics lors de comparaison
    let flippedCards = []; // follow les carte retourné

    const startBtn = document.getElementById('playbtn');
    const generateBtn = document.getElementById('generatebtn');
    const gridSizeS = document.getElementById('gridsizes');
    const themeS = document.getElementById('themes');
    const grid = document.querySelector(".grid");

    startBtn.disabled = true;
    startBtn.style.opacity = 0.3;

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
                        <img src="../../assets/images/manette.png" alt="dos de carte">
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
            card2.classList.add("matched");

            resetTurn();
            checkWin();
        } else {
            setTimeout(() => {
                card1.classList.remove("flipped"); // pas match
                card2.classList.remove("flipped");

                resetTurn();
            }, 1000);
        }
    }

    // cooldown (jsp)
    function resetTurn() {
        flippedCards = [];
        lockCards = false; // libere de click
    }

    startBtn.addEventListener("click", () => {
        
        lockCards = false;

        startBtn.disabled = true;
        generateBtn.disabled = true;
        gridSizeS.disabled = true;
        themeS.disabled = true;

        startBtn.style.opacity = 0.3;
        generateBtn.style.opacity = 0.3;
        gridSizeS.style.opacity = 0.3;
        themeS.style.opacity = 0.3;

    });
    
    // deblocage
    function checkWin() {
        const allMatched = [...grid.querySelectorAll(".card")].every(c => c.classList.contains("matched"));
        if(allMatched) {
            
            lockBoard = false;
            generateBtn.disabled = false;
            gridSizeS.disabled = false;
            themeS.disabled = false;
            startBtn.disabled = true;
            generateBtn.style.opacity = 1;
            gridSizeS.style.opacity = 1;
            themeS.style.opacity = 1;

            lockCards = true;
        }
    }

    // event bouton generation
    generateBtn.addEventListener("click", generateGrid);

});