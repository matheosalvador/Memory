const boardElement = document.getElementById("board");
const rollBtn = document.getElementById("rollDiceBtn");
const diceResult = document.getElementById("diceResult");
const turnInfo = document.getElementById("turnInfo");
const caseInfo = document.getElementById("caseInfo");

const TOTAL_CASES = 63;
let players = [];
let currentPlayer = 0;

// ============================================================
// PLATEAU
// ============================================================
function createBoard() {
    boardElement.innerHTML = "";
    for (let i = 1; i <= TOTAL_CASES; i++) {
        const cell = document.createElement("div");
        cell.className = "cell";
        cell.dataset.num = i;
        cell.innerHTML = `<div class="num">${i}</div><div class="tokens"></div>`;
        boardElement.appendChild(cell);
    }
}

function spiralLayout() {
    const cells = Array.from(boardElement.children);
    const rows = 7, cols = 9;
    const spiralOrder = [];
    let top = 0, bottom = rows - 1, left = 0, right = cols - 1;

    while (top <= bottom && left <= right) {
        for (let i = left; i <= right; i++) spiralOrder.push([top, i]);
        top++;
        for (let i = top; i <= bottom; i++) spiralOrder.push([i, right]);
        right--;
        if (top <= bottom) for (let i = right; i >= left; i--) spiralOrder.push([bottom, i]);
        bottom--;
        if (left <= right) for (let i = bottom; i >= top; i--) spiralOrder.push([i, left]);
        left++;
    }

    cells.forEach((cell, index) => {
        const pos = spiralOrder[index];
        if (pos) {
            cell.style.gridRowStart = pos[0] + 1;
            cell.style.gridColumnStart = pos[1] + 1;
        }
    });
}

// ============================================================
// JOUEURS
// ============================================================
function initPlayers() {
    players = [];
    for (let i = 1; i <= window.PLAYER_COUNT; i++) {
        players.push({
            id: i,
            name: window.PLAYER_NAMES[i-1] || `Joueur ${i}`,
            position: 1,
            skip: 0,
            turns: 0, // compteur de tours
            isAI: (window.GAME_MODE === "pvai" && i === window.PLAYER_COUNT),
            aiSmartRerolls: 1
        });
    }
}

// ============================================================
// CAS SPÉCIAUX
// ============================================================
const specialCases = {
    6: { type: "bridge", move: 6 },
    12: { type: "bridge", move: 6 },
    5: { type: "goose" }, 9: { type: "goose" }, 14: { type: "goose" }, 18: { type: "goose" }, 23: { type: "goose" }, 27: { type: "goose" },
    19: { type: "inn", skip: 1 },
    31: { type: "well", skip: 2 },
    42: { type: "labyrinth", goto: 30 },
    58: { type: "death", goto: 1 }
};

function processSpecialCases(player) {
    let currentCase = player.position;
    while (specialCases[currentCase]) {
        const s = specialCases[currentCase];
        switch (s.type) {
            case "bridge": player.position += s.move; break;
            case "goose": player.position += rollDice(); break;
            case "inn": player.skip = s.skip; return;
            case "well": player.skip = s.skip; return;
            case "labyrinth": player.position = s.goto; return;
            case "death": player.position = s.goto; return;
        }
        currentCase = player.position;
    }
}

function getCaseName(pos) {
    const special = specialCases[pos];
    if (!special) return "Case normale";
    switch (special.type) {
        case "bridge": return "Pont (+6)";
        case "goose": return "Oie";
        case "inn": return "Auberge (skip 1)";
        case "well": return "Puits (skip 2)";
        case "labyrinth": return "Labyrinthe (retour 30)";
        case "death": return "Mort (retour 1)";
        default: return "Case spéciale";
    }
}

// ============================================================
// CHEMIN
// ============================================================
function getMovePath(player, diceRoll) {
    let path = [];
    let pos = player.position;
    for (let i = 1; i <= diceRoll; i++) {
        pos++;
        if (pos > TOTAL_CASES) pos = TOTAL_CASES - (pos - TOTAL_CASES);
        path.push(pos);
    }
    return path;
}

function displayMovePath(player, diceRoll) {
    const path = getMovePath(player, diceRoll);
    const pathNames = path.map(pos => getCaseName(pos));
    caseInfo.textContent = `Cases à parcourir : ${path.join(" → ")} (${pathNames.join(" → ")})`;
}

// ============================================================
// PIONS
// ============================================================
function renderTokens() {
    document.querySelectorAll(".tokens").forEach(t => t.innerHTML = "");
    players.forEach(p => {
        const cell = document.querySelector(`.cell[data-num='${p.position}'] .tokens`);
        if (cell) {
            const token = document.createElement("div");
            token.className = `player-token p${p.id}`;
            token.title = p.name;
            cell.appendChild(token);
        }
    });
}

// ============================================================
// ENREGISTREMENT SCORE
// ============================================================
function saveScore(player) {
    const payload = {
        game_id: 3,          // ID pour "Jeu de l'oie"
        difficulty: "1",
        time: 0,
        data: {
            player: player.name,
            position: player.position,
            turns: player.turns
        }
    };

    fetch('../../utils/fct-scores.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "OK") console.log("Score enregistré ! ID:", data.id);
        else console.error("Erreur score :", data.message);
    })
    .catch(err => console.error("Erreur fetch :", err));
}

// ============================================================
// TOUR PAR TOUR
// ============================================================
function nextPlayer() {
    currentPlayer = (currentPlayer + 1) % players.length;
    const p = players[currentPlayer];
    turnInfo.textContent = `Tour du joueur ${p.name}`;
    caseInfo.textContent = `Prochaine case : ${getCaseName(p.position)}`;
    rollBtn.disabled = p.isAI;
    if (p.isAI) setTimeout(playTurn, 900);
}

function rollDice() { return Math.floor(Math.random() * 6) + 1; }

function playTurn() {
    const p = players[currentPlayer];
    p.turns++;

    if (p.skip > 0) {
        alert(`${p.name} passe son tour.`);
        p.skip--;
        return nextPlayer();
    }

    let result = rollDice();

    displayMovePath(p, result);

    if (p.isAI && p.aiSmartRerolls > 0) {
        const predictedPos = p.position + result;
        if (specialCases[predictedPos] && ["inn","well","death"].includes(specialCases[predictedPos].type)) {
            result = rollDice();
            p.aiSmartRerolls--;
        }
    }

    diceResult.textContent = `Résultat : ${result}`;
    p.position += result;
    if (p.position > TOTAL_CASES) p.position = TOTAL_CASES - (p.position - TOTAL_CASES);

    if (p.position === TOTAL_CASES) {
        renderTokens();
        alert(`🎉 ${p.name} gagne !`);
        rollBtn.disabled = true;
        caseInfo.textContent = "";

        saveScore(p); // enregistre score à la fin
        return;
    }

    processSpecialCases(p);
    renderTokens();
    nextPlayer();
}

// ============================================================
// INITIALISATION
// ============================================================
createBoard();
spiralLayout();
initPlayers();
renderTokens();
turnInfo.textContent = `Tour du joueur ${players[currentPlayer].name}`;
caseInfo.textContent = `Prochaine case : ${getCaseName(players[currentPlayer].position)}`;
rollBtn.addEventListener("click", playTurn);
