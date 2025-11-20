document.addEventListener("DOMContentLoaded", () => {

    const ROWS = 6;
    const COLS = 7;

    let board = [];
    let currentPlayer = "red";
    let gameOver = false;

    const boardDiv = document.getElementById("board");
    const currentPlayerSpan = document.getElementById("currentPlayer");
    const popup = document.getElementById("endgame-popup");
    const winnerPlayer = document.getElementById("winner-player");
    const restartBtn = document.getElementById("restartbtn");
    const resetBtn = document.getElementById("resetBtn");

    const modeSelect = document.getElementById("mode");
    const difficultySelect = document.getElementById("difficulty");

    const DEPTH = {
        easy: 0,
        medium: 2,
        hard: 4,
        nightmare: 8
    };

    // -------------------------------
    // INITIALISATION DU PLATEAU
    // -------------------------------
    function initBoard() {
        board = Array.from({ length: ROWS }, () => Array(COLS).fill(null));
        boardDiv.innerHTML = "";
        currentPlayer = "red";
        currentPlayerSpan.textContent = "Rouge";
        gameOver = false;

        popup.classList.add("hidden");
        resetBtn.disabled = true;

        for (let c = 0; c < COLS; c++) {
            const colDiv = document.createElement("div");
            colDiv.classList.add("column");
            colDiv.dataset.col = c;

            colDiv.addEventListener("click", () => {
                if (gameOver) return;
                if (modeSelect.value === "ia" && currentPlayer === "yellow") return; // joueur peut jouer seulement rouge en mode IA
                handleMove(c);
            });

            for (let r = 0; r < ROWS; r++) {
                const cell = document.createElement("div");
                cell.className = "cell";
                colDiv.appendChild(cell);
            }

            boardDiv.appendChild(colDiv);
        }
    }

    // -------------------------------
    // GESTION DU COUP
    // -------------------------------
    async function handleMove(c) {
        if (gameOver) return;

        let r = ROWS - 1;
        while (r >= 0 && board[r][c] !== null) r--;
        if (r < 0) return;

        board[r][c] = currentPlayer;

        await animateDrop(c, r, currentPlayer);

        const cell = boardDiv.children[c].children[r];
        const settled = document.createElement("div");
        settled.className = `token ${currentPlayer}`;
        settled.style.width = "100%";
        settled.style.height = "100%";
        settled.style.borderRadius = "50%";
        cell.appendChild(settled);
        cell.classList.add("pop");
        setTimeout(() => cell.classList.remove("pop"), 220);

        const winning = getWinningCells(r, c);
        if (winning.length) {
            winning.forEach(([wr, wc]) => {
                boardDiv.children[wc].children[wr].classList.add("winner");
            });
            endGame(currentPlayer);
            return;
        }

        if (board.every(row => row.every(cell => cell !== null))) {
            endGame("draw");
            return;
        }

        currentPlayer = currentPlayer === "red" ? "yellow" : "red";
        currentPlayerSpan.textContent = currentPlayer === "red" ? "Rouge" : "Jaune";

        if (currentPlayer === "yellow" && modeSelect.value === "ia") {
            setTimeout(() => aiPlay(difficultySelect.value), 300);
        }
    }

    // -------------------------------
    // ANIMATION DE CHUTE
    // -------------------------------
    function animateDrop(c, r, color) {
        return new Promise(resolve => {
            const colDiv = boardDiv.children[c];
            const targetCell = colDiv.children[r];

            const token = document.createElement("div");
            token.className = `token ${color}`;
            token.style.position = "absolute";
            token.style.left = "50%";
            token.style.transform = "translateX(-50%)";
            token.style.top = "-120px";
            token.style.transition = "top 0.35s cubic-bezier(.2,.9,.3,1)";
            colDiv.appendChild(token);

            const colRect = colDiv.getBoundingClientRect();
            const cellRect = targetCell.getBoundingClientRect();
            const targetY = cellRect.top - colRect.top;

            requestAnimationFrame(() => token.style.top = `${targetY}px`);

            token.addEventListener("transitionend", () => {
                if (token.parentElement) token.remove();
                resolve();
            });

            setTimeout(() => {
                if (token.parentElement) token.remove();
                resolve();
            }, 650);
        });
    }

    // -------------------------------
    // IA
    // -------------------------------
    function aiPlay(level) {

        if (gameOver) return;

        if (level === "easy") return randomMove();
        if (level === "medium") return mediumMove();
        if (level === "hard") return minimaxMove(DEPTH.hard);
        if (level === "nightmare") return minimaxMove(DEPTH.nightmare);

        randomMove();
    }

    function randomMove() {
        const valid = getValidColumns();
        handleMove(valid[Math.floor(Math.random() * valid.length)]);
    }

    function mediumMove() {
        const valid = getValidColumns();

        for (let c of valid) {
            if (checkWinBoard(simulateMove(board, c, "yellow"), "yellow"))
                return handleMove(c);
        }
        for (let c of valid) {
            if (checkWinBoard(simulateMove(board, c, "red"), "red"))
                return handleMove(c);
        }

        randomMove();
    }

    function minimaxMove(depth) {
        const valid = getValidColumns();
        let bestScore = -Infinity;
        let bestCol = valid[0];

        for (let col of valid) {
            const temp = simulateMove(board, col, "yellow");
            const score = minimax(temp, depth - 1, false, -Infinity, Infinity);
            if (score > bestScore) {
                bestScore = score;
                bestCol = col;
            }
        }

        handleMove(bestCol);
    }

    // -------------------------------
    // MINIMAX
    // -------------------------------
    function minimax(boardState, depth, maximizing, alpha, beta) {

        if (depth === 0 || isTerminal(boardState))
            return evaluateBoard(boardState);

        const valid = getValidColumns(boardState);
        if (valid.length === 0) return 0;

        valid.sort((a, b) => Math.abs(a - 3) - Math.abs(b - 3));

        if (maximizing) {
            let maxEval = -Infinity;
            for (let col of valid) {
                const child = simulateMove(boardState, col, "yellow");
                const evalScore = minimax(child, depth - 1, false, alpha, beta);
                maxEval = Math.max(maxEval, evalScore);
                alpha = Math.max(alpha, evalScore);
                if (beta <= alpha) break;
            }
            return maxEval;
        } else {
            let minEval = Infinity;
            for (let col of valid) {
                const child = simulateMove(boardState, col, "red");
                const evalScore = minimax(child, depth - 1, true, alpha, beta);
                minEval = Math.min(minEval, evalScore);
                beta = Math.min(beta, evalScore);
                if (beta <= alpha) break;
            }
            return minEval;
        }
    }

    // -------------------------------
    // HEURISTIQUE
    // -------------------------------
    function evaluateBoard(b) {
        let score = 0;

        const center = Math.floor(COLS / 2);
        let centerCount = 0;
        for (let r = 0; r < ROWS; r++)
            if (b[r][center] === "yellow") centerCount++;

        score += centerCount * 5;

        const windows = getAllWindows(b);
        for (let w of windows) {
            const y = w.filter(x => x === "yellow").length;
            const r = w.filter(x => x === "red").length;
            const e = w.filter(x => x === null).length;

            if (y === 4) score += 10000;
            else if (y === 3 && e === 1) score += 80;
            else if (y === 2 && e === 2) score += 10;

            if (r === 4) score -= 12000;
            else if (r === 3 && e === 1) score -= 90;
            else if (r === 2 && e === 2) score -= 8;
        }

        return score;
    }

    function getAllWindows(state) {
        const res = [];

        for (let r = 0; r < ROWS; r++)
            for (let c = 0; c < COLS - 3; c++)
                res.push([state[r][c], state[r][c+1], state[r][c+2], state[r][c+3]]);

        for (let c = 0; c < COLS; c++)
            for (let r = 0; r < ROWS - 3; r++)
                res.push([state[r][c], state[r+1][c], state[r+2][c], state[r+3][c]]);

        for (let r = 0; r < ROWS - 3; r++)
            for (let c = 0; c < COLS - 3; c++)
                res.push([state[r][c], state[r+1][c+1], state[r+2][c+2], state[r+3][c+3]]);

        for (let r = 3; r < ROWS; r++)
            for (let c = 0; c < COLS - 3; c++)
                res.push([state[r][c], state[r-1][c+1], state[r-2][c+2], state[r-3][c+3]]);

        return res;
    }

    // -------------------------------
    // OUTILS IA
    // -------------------------------
    function getValidColumns(state = board) {
        const valid = [];
        for (let c = 0; c < COLS; c++)
            if (state[0][c] === null) valid.push(c);
        return valid;
    }

    function simulateMove(state, col, color) {
        const newBoard = state.map(r => [...r]);
        let r = ROWS - 1;
        while (r >= 0 && newBoard[r][col] !== null) r--;
        if (r >= 0) newBoard[r][col] = color;
        return newBoard;
    }

    function isTerminal(state) {
        return (
            checkWinBoard(state, "yellow") ||
            checkWinBoard(state, "red") ||
            getValidColumns(state).length === 0
        );
    }

    function checkWinBoard(state, color) {
        for (let r = 0; r < ROWS; r++)
            for (let c = 0; c < COLS; c++)
                if (state[r][c] === color && getWinningCellsFromState(state, r, c).length >= 4)
                    return true;
        return false;
    }

    function getWinningCellsFromState(state, row, col) {
        const color = state[row][col];
        if (!color) return [];

        const dirs = [[0,1],[1,0],[1,1],[1,-1]];

        for (let [dr,dc] of dirs) {
            let line = [[row,col]];
            let r = row + dr, c = col + dc;

            while (r>=0 && r<ROWS && c>=0 && c<COLS && state[r][c] === color) {
                line.push([r,c]);
                r += dr; c += dc;
            }

            r = row - dr; c = col - dc;
            while (r>=0 && r<ROWS && c>=0 && c<COLS && state[r][c] === color) {
                line.unshift([r,c]);
                r -= dr; c -= dc;
            }

            if (line.length >= 4) return line;
        }
        return [];
    }

    function getWinningCells(row, col) {
        return getWinningCellsFromState(board, row, col);
    }

    // -------------------------------
    // FIN DE PARTIE
    // -------------------------------
    function endGame(winner) {
        gameOver = true;
        popup.classList.remove("hidden");

        winnerPlayer.textContent =
            winner === "draw"
                ? "Égalité"
                : (winner === "red" ? "Rouge" : "Jaune");

        const audio = document.getElementById("winner-title").getAttribute("data-audio");
        if (audio) new Audio(audio).play().catch(() => {});

        resetBtn.disabled = false;
    }

    function resetHighlights() {
        document.querySelectorAll(".winner").forEach(e => e.classList.remove("winner"));
        document.querySelectorAll(".cell .token").forEach(tok => tok.remove());
    }

    restartBtn.addEventListener("click", () => { resetHighlights(); initBoard(); });
    resetBtn.addEventListener("click", () => { resetHighlights(); initBoard(); });

    initBoard();

    // -------------------------------
    // KONAMI CODE — UNLOCK NIGHTMARE
    // -------------------------------
    const konami = [
        "ArrowUp","ArrowUp",
        "ArrowDown","ArrowDown",
        "ArrowLeft","ArrowRight",
        "ArrowLeft","ArrowRight",
        "b","a"
    ];

    let konamiIndex = 0;

    document.addEventListener("keydown", (e) => {
        if (e.key === konami[konamiIndex]) {
            konamiIndex++;
            if (konamiIndex === konami.length) {
                unlockNightmare();
                konamiIndex = 0;
            }
        } else {
            konamiIndex = 0;
        }
    });

    function unlockNightmare() {
        if (!difficultySelect.querySelector("option[value='nightmare']")) {
            const opt = document.createElement("option");
            opt.value = "nightmare";
            opt.textContent = "Nightmare 👹";
            difficultySelect.appendChild(opt);
        }

        difficultySelect.value = "nightmare";

        alert("🔥 Mode NIGHTMARE débloqué ! Bonne chance… 😈");
    }

});
