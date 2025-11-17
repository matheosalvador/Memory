document.getElementById("generate-btn").addEventListener("click", generateGrid);

function generateGrid() {
    const size = document.getElementById("grid-size").value;
    const theme = document.getElementById("theme").value;

    // Taille → nombre de paires
    const pairsCount = {
        "4x4": 8,   // 16 cartes → 8 paires
        "6x6": 18,  // 36 cartes → 18 paires
        "8x8": 32   // 64 cartes → 32 paires
    }[size];

    // Fetch liste images du thème
    fetch(`../../assets/images/themes/${theme}/`)
        .then(res => res.text())
        .then(text => {
            // Récupération des fichiers via regex HTML directory listing
            const files = [...text.matchAll(/href="([^"]+\.(png|jpg|jpeg|gif))"/gi)]
                .map(e => e[1]);

            if (files.length < pairsCount) {
                alert("Pas assez d’images dans ce thème !");
                return;
            }

            // Sélectionner N images aléatoires
            const selected = shuffle(files).slice(0, pairsCount);

            // Dupliquer les cartes (paires)
            const finalCards = shuffle([...selected, ...selected]);

            // Générer HTML
            const grid = document.querySelector(".grid");
            grid.style.gridTemplateColumns = `repeat(${size.split("x")[0]}, 1fr)`;

            grid.innerHTML = finalCards.map(img => `
                <div class="card">
                    <img src="../../assets/images/themes/${theme}/${img}" alt="">
                </div>
            `).join("");
        });
}

// Mélange Fisher-Yates
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

