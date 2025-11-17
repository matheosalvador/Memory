document.addEventListener("DOMContentLoaded", () => {

    document.getElementById("generate-btn").addEventListener("click", generateGrid);

    async function generateGrid() {
        const size = document.getElementById("grid-size").value;
        const theme = document.getElementById("thème").value;

        const pairsCount = {
            "4x4": 8,
            "6x6": 18,
            "8x8": 32
        }[size];

        // --- FETCH du dossier avec directory listing ---
        const response = await fetch(`../../assets/images/thèmes/${theme}/`);
        const text = await response.text();

        // --- Extraction des fichiers image depuis le listing HTML ---
        const files = [...text.matchAll(/href="([^"]+\.(png|jpg|jpeg|gif))"/gi)]
            .map(e => e[1]);

        if (files.length < pairsCount) {
            alert("Pas assez d’images dans ce thème !");
            return;
        }

        const selected = shuffle(files).slice(0, pairsCount);
        const finalCards = shuffle([...selected, ...selected]);

        const grid = document.querySelector(".grid");
        grid.style.gridTemplateColumns = `repeat(${size.split("x")[0]}, 1fr)`;

        // --- Construction de la grille ---
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
    }

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

});
