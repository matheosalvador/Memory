// game.js - Version FUSIONNÉE propre

// =====================================================
// 1. CONSTANTES ET ELEMENTS
// =====================================================

const boardElement = document.getElementById("board");
const rollBtn = document.getElementById("rollDiceBtn");
const diceResult = document.getElementById("diceResult");
const turnInfo = document.getElementById("turnInfo");

const TOTAL_CASES = 63;

// =====================================================
// 2. CREATION DU PLATEAU (VERSION FINALE)
// =====================================================

function createBoard() {
    boardElement.innerHTML = '';
    for (let i = 1; i <= TOTAL_CASES; i++) {
        const cell = document.createElement("div");
        cell.className = "cell";
        cell.dataset.num = i;
        cell.innerHTML = `
            <div class="num">${i}</div>
            <div class="tokens"></div>
        `;
        boardElement.appendChild(cell);
    }
}

createBoard();

// =====================================================
// 3. INITIALISATION DES JOUEURS (VERSION FUSION)
// =====================================================

let players = [];
let currentPlayer = 0;

function initPlayers() {
    players = [];

    for (let i = 1; i <= PLAYER_COUNT; i++) {
        players.push({
            id: i,
            position: 1,
            skip: 0,
            isAI: (GAME_MODE === "pvai" && i === PLAYER_COUNT),
            aiSmartRerolls: 1
        });
    }
}

initPlayers();

// =====================================================
// 4. AFFICHAGE DES PIONS (VERSION FINALE)
// =====================================================

function renderTokens() {
    document.querySelectorAll('.tokens').forEach(t => t.innerHTML = "");

    players.forEach(player => {
        const cell = document.querySelector(`.cell[data-num='${player.position}'] .tokens`);
        if (cell) {
            const token = document.createElement("div");
            token.className = `player-token p${player.id}`;
            cell.appendChild(token);
        }
    });
}

renderTokens();

// =====================================================
// 5. LANCER DE DÉ (UNIFIÉ)
// =====================================================

function rollDice() {
    return Math.floor(Math.random() * 6) + 1;
}

// =====================================================
// 6. REGLES SPECIALES
// =====================================================

const specialCases = {
    6: { type: 'bridge', move: +6 },
    12: { type: 'bridge', move: +6 },

    5:  { type: 'goose' },
    9:  { type: 'goose' },
    14: { type: 'goose' },
    18: { type: 'goose' },
    23: { type: 'goose' },
    27: { type: 'goose' },

    19: { type: 'inn', skip: 1 },
    31: { type: 'well', skip: 2 },
    42: { type: 'labyrinth', goto: 30 },
    58: { type: 'death', goto: 1 }
};

function processSpecialCases(player) {
    let currentCase = player.position;

    while (specialCases[currentCase]) {
        const sp = specialCases[currentCase];

        if (sp.type === 'bridge') {
            player.position += sp.move;
        }
        else if (sp.type === 'goose') {
            let roll = rollDice();
            player.position += roll;
        }
        else if (sp.type === 'inn') {
            player.skip = sp.skip;
            break;
        }
        else if (sp.type === 'well') {
            player.skip = sp.skip;
            break;
        }
        else if (sp.type === 'labyrinth') {
            player.position = sp.goto;
            break;
        }
        else if (sp.type === 'death') {
            player.position = sp.goto;
            break;
        }

        currentCase = player.position;
    }
}

// =====================================================
// 7. TOUR PAR TOUR (VERSION FUSION)
// =====================================================

function nextPlayer() {
    currentPlayer = (currentPlayer + 1) % players.length;
    turnInfo.textContent = `Tour du joueur ${players[currentPlayer].id}`;

    const player = players[currentPlayer];

    if (player.isAI) {
        rollBtn.disabled = true;
        setTimeout(() => playTurn(), 900);
    } else {
        rollBtn.disabled = false;
    }
}

function playTurn() {
    const player = players[currentPlayer];

    if (player.skip > 0) {
        player.skip--;
        alert(`Joueur ${player.id} passe son tour.`);
        return nextPlayer();
    }

    let result = rollDice();

    if (player.isAI && player.aiSmartRerolls > 0) {
        const predicted = player.position + result;
        if (specialCases[predicted] && ["inn", "well", "death"].includes(specialCases[predicted].type)) {
            result = rollDice();
            player.aiSmartRerolls--;
        }
    }

    diceResult.textContent = `Résultat : ${result}`;

    player.position += result;

    if (player.position > TOTAL_CASES) {
        player.position = TOTAL_CASES - (player.position - TOTAL_CASES);
    }

    if (player.position === TOTAL_CASES) {
        renderTokens();
        alert(`🎉 Joueur ${player.id} a gagné !`);
        rollBtn.disabled = true;
        return;
    }

    processSpecialCases(player);

    renderTokens();
    nextPlayer();
}

rollBtn.addEventListener("click", playTurn);