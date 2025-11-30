document.addEventListener("DOMContentLoaded", () => {

    const ROWS = 6;
    const COLS = 7;
    let board = [];
    let currentPlayer = "red";
    let gameOver = false;
    let warningPlayed = false;
    let totalTurns = 0;

    const boardDiv = document.getElementById("board");
    const currentPlayerSpan = document.getElementById("currentPlayer");

    const winPopup = document.getElementById("win-popup");
    const losePopup = document.getElementById("lose-popup");
    const winnerPlayer = document.getElementById("winner-player");
    const resetBtn = document.getElementById("resetBtn");
    const popupRestartBtns = [...document.querySelectorAll(".restartbtn")];

    const modeSelect = document.getElementById("mode");
    const difficultySelect = document.getElementById("difficulty");
    const bgMusic = document.getElementById("bgMusic");

    const DEPTH = { easy: 0, medium: 2, hard: 4, nightmare: 8 };

    const BASE_URL = detectBaseUrl();

    const FILES_BY_DIFFICULTY = {
        easy:  `${BASE_URL}/assets/audio/footer-contact-puissance4/easy.mp3`,
        medium:`${BASE_URL}/assets/audio/footer-contact-puissance4/Moderate.mp3`,
        hard:  `${BASE_URL}/assets/audio/footer-contact-puissance4/hard.mp3`,
        nightmare:`${BASE_URL}/assets/audio/footer-contact-puissance4/Hardcore.mp3`
    };

    // Mapping string -> integer pour la DB
    const DIFFICULTY_MAP = { easy: 1, medium: 2, hard: 3, nightmare: 4 };

    function detectBaseUrl() {
        const candidates = [
            boardDiv?.dataset?.warning,
            losePopup?.dataset?.nightmare,
            losePopup?.dataset?.warning3,
            winPopup?.querySelector("#winner-title")?.dataset?.audio,
            document.querySelector("[data-audio]")?.dataset?.audio
        ];
        for (const val of candidates) {
            if (!val) continue;
            const idx = val.indexOf("/assets/");
            if (idx !== -1) return val.slice(0, idx);
        }
        return "";
    }

    function updateBackgroundMusic() {
        if (!bgMusic || !difficultySelect) return;
        const difficulty = difficultySelect.value || "easy";
        const src = FILES_BY_DIFFICULTY[difficulty];
        if (bgMusic.src !== src) {
            bgMusic.src = src;
            bgMusic.volume = 0.6;
            bgMusic.loop = true;
            bgMusic.play().catch(()=>{});
        }
    }

    if (difficultySelect) difficultySelect.addEventListener("change", updateBackgroundMusic);

    function initBoard() {
        board = Array.from({ length: ROWS }, () => Array(COLS).fill(null));
        if (boardDiv) boardDiv.innerHTML = "";
        currentPlayer = "red";
        totalTurns = 0;
        if (currentPlayerSpan) currentPlayerSpan.textContent = "Rouge";
        warningPlayed = false;
        gameOver = false;
        winPopup?.classList.add("hidden");
        losePopup?.classList.add("hidden");
        if (resetBtn) resetBtn.disabled = false;

        for (let c = 0; c < COLS; c++) {
            const colDiv = document.createElement("div");
            colDiv.classList.add("column");
            colDiv.dataset.col = c;

            colDiv.addEventListener("click", () => {
                if (gameOver) return;
                if (modeSelect && modeSelect.value === "ia" && currentPlayer === "yellow") return;
                handleMove(c);
            });

            for (let r = 0; r < ROWS; r++) {
                const cell = document.createElement("div");
                cell.className = "cell";
                colDiv.appendChild(cell);
            }
            boardDiv.appendChild(colDiv);
        }

        updateBackgroundMusic();
    }

    async function handleMove(c) {
        if (gameOver) return;

        totalTurns++;
        let r = ROWS - 1;
        while (r >= 0 && board[r][c] !== null) r--;
        if (r < 0) return;

        board[r][c] = currentPlayer;
        await animateDrop(c, r, currentPlayer);

        const cell = boardDiv.children[c].children[r];
        const settled = document.createElement("div");
        settled.className = `token ${currentPlayer}`;
        cell.appendChild(settled);

        const winning = getWinningCells(r, c);
        if (winning.length) {
            winning.forEach(([wr, wc]) => {
                if (boardDiv.children[wc] && boardDiv.children[wc].children[wr]) {
                    boardDiv.children[wc].children[wr].classList.add("winner");
                }
            });
            await saveScore(currentPlayer);
            if (currentPlayer === "yellow" && modeSelect && modeSelect.value === "ia") return endLose();
            return endWin(currentPlayer);
        }

        if (board.every(row => row.every(cell => cell !== null))) {
            await saveScore("draw");
            return endWin("draw");
        }

        const iaJustPlayed = currentPlayer === "yellow";
        currentPlayer = currentPlayer === "red" ? "yellow" : "red";
        if (currentPlayerSpan) currentPlayerSpan.textContent = currentPlayer === "red" ? "Rouge" : "Jaune";

        if (iaJustPlayed && modeSelect && modeSelect.value === "ia") detectThreat();
        if (currentPlayer === "yellow" && modeSelect && modeSelect.value === "ia") {
            setTimeout(() => aiPlay(difficultySelect ? difficultySelect.value : "easy"), 300);
        }
    }

    async function saveScore(winner) {
        const difficultyValue = DIFFICULTY_MAP[difficultySelect?.value || "easy"] || 1;
        const payload = {
            game_id: 2,
            difficulty: difficultyValue,
            time: 0,
            data: { winner, turns: totalTurns }
        };
        try {
            const res = await fetch("../../utils/fct-scores.php", {

                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload)
            });
            const json = await res.json();
            console.log("Score enregistré:", json);
        } catch(err) {
            console.error("Erreur enregistrement score:", err);
        }
    }

    // ---------------- AI Functions ----------------
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
        if (!valid.length) return;
        handleMove(valid[Math.floor(Math.random() * valid.length)]);
    }

    function mediumMove() {
        const valid = getValidColumns();
        for (let c of valid) {
            if (checkWinBoard(simulateMove(board, c, "yellow"), "yellow")) return handleMove(c);
        }
        for (let c of valid) {
            if (checkWinBoard(simulateMove(board, c, "red"), "red")) return handleMove(c);
        }
        randomMove();
    }

    function minimaxMove(depth) {
        const valid = getValidColumns();
        if (!valid.length) return;
        let bestScore = -Infinity, bestCol = valid[0];
        for (let col of valid) {
            const temp = simulateMove(board, col, "yellow");
            const score = minimax(temp, depth - 1, false, -Infinity, Infinity);
            if (score > bestScore) { bestScore = score; bestCol = col; }
        }
        handleMove(bestCol);
    }

    function minimax(state, depth, maximizing, alpha, beta) {
        if (depth === 0 || isTerminal(state)) return evaluateBoard(state);
        const valid = getValidColumns(state);
        if (!valid.length) return 0;
        if (maximizing) {
            let best = -Infinity;
            for (let col of valid) {
                const child = simulateMove(state, col, "yellow");
                const score = minimax(child, depth - 1, false, alpha, beta);
                best = Math.max(best, score);
                alpha = Math.max(alpha, score);
                if (alpha >= beta) break;
            }
            return best;
        } else {
            let best = Infinity;
            for (let col of valid) {
                const child = simulateMove(state, col, "red");
                const score = minimax(child, depth - 1, true, alpha, beta);
                best = Math.min(best, score);
                beta = Math.min(beta, score);
                if (beta <= alpha) break;
            }
            return best;
        }
    }

    function evaluateBoard(b) {
        let score = 0;
        for (let w of getAllWindows(b)) {
            const y = w.filter(x => x === "yellow").length;
            const r = w.filter(x => x === "red").length;
            const e = w.filter(x => x === null).length;
            if (y === 4) score += 10000;
            else if (y === 3 && e === 1) score += 80;
            if (r === 4) score -= 10000;
            else if (r === 3 && e === 1) score -= 80;
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

    function getValidColumns(state = board) {
        return [...Array(COLS).keys()].filter(c => state[0][c] === null);
    }

    function simulateMove(state, col, color) {
        const newBoard = state.map(r => [...r]);
        let r = ROWS - 1;
        while (r >= 0 && newBoard[r][col] !== null) r--;
        if (r >= 0) newBoard[r][col] = color;
        return newBoard;
    }

    function isTerminal(state) {
        return checkWinBoard(state, "yellow") || checkWinBoard(state, "red") || getValidColumns(state).length === 0;
    }

    function getWinningCells(row, col) {
        return getWinningCellsFromState(board, row, col);
    }

    function getWinningCellsFromState(state, row, col) {
        const color = state[row][col];
        if (!color) return [];
        const dirs = [[0,1], [1,0], [1,1], [1,-1]];
        for (let [dr, dc] of dirs) {
            let line = [[row, col]];
            let r = row + dr, c = col + dc;
            while (r >= 0 && r < ROWS && c >= 0 && c < COLS && state[r][c] === color) { line.push([r,c]); r+=dr;c+=dc; }
            r = row - dr; c = col - dc;
            while (r >= 0 && r < ROWS && c >= 0 && c < COLS && state[r][c] === color) { line.unshift([r,c]); r-=dr;c-=dc; }
            if (line.length >= 4) return line;
        }
        return [];
    }

    function checkWinBoard(state, color) {
        for (let r = 0; r < ROWS; r++)
            for (let c = 0; c < COLS; c++)
                if (state[r][c] === color && getWinningCellsFromState(state, r, c).length >= 4)
                    return true;
        return false;
    }

    async function animateDrop(c, r, color) {
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
            requestAnimationFrame(() => (token.style.top = `${targetY}px`));
            function done() { if (token.parentElement) token.remove(); resolve(); }
            token.addEventListener("transitionend", done);
            setTimeout(done, 700);
        });
    }

    function endWin(winner) {
        gameOver = true;
        winPopup?.classList.remove("hidden");
        if (winnerPlayer) winnerPlayer.textContent = (winner === "draw") ? "Égalité" : (winner === "red" ? "Rouge" : "Jaune");
        const audio = winPopup?.querySelector("#winner-title")?.dataset?.audio;
        if (audio) try { new Audio(audio).play(); } catch(e) {}
    }

    function endLose() {
        gameOver = true;
        const loseNormal = document.getElementById("lose-title")?.dataset?.audio || null;
        const loseNightmare = losePopup?.dataset?.nightmare || null;
        const sound = (difficultySelect && difficultySelect.value === "nightmare") ? loseNightmare : loseNormal;
        if (sound) try { new Audio(sound).play(); } catch(e) {}
        losePopup?.classList.remove("hidden");
    }

    function detectThreat() { /* ton code actuel */ }

    function resetHighlights() {
        document.querySelectorAll(".winner").forEach(e => e.classList.remove("winner"));
        document.querySelectorAll(".cell .token").forEach(t => t.remove());
    }

    [...popupRestartBtns, resetBtn].forEach(btn => {
        if (!btn) return;
        btn.addEventListener("click", () => {
            winPopup?.classList.add("hidden");
            losePopup?.classList.add("hidden");
            resetHighlights();
            initBoard();
        });
    });

    const konami = ["ArrowUp","ArrowUp","ArrowDown","ArrowDown","ArrowLeft","ArrowRight","ArrowLeft","ArrowRight","b","a"];
    let konamiIndex = 0;
    document.addEventListener("keydown", (e) => {
        if (e.key === konami[konamiIndex]) {
            konamiIndex++;
            if (konamiIndex === konami.length) {
                unlockNightmare();
                konamiIndex = 0;
            }
        } else konamiIndex = 0;
    });

    function unlockNightmare() {
        if (!difficultySelect) return;
        if (!difficultySelect.querySelector("option[value='nightmare']")) {
            const opt = document.createElement("option");
            opt.value = "nightmare";
            opt.textContent = "Nightmare 👹";
            difficultySelect.appendChild(opt);
        }
        difficultySelect.value = "nightmare";
        alert("🔥 Mode NIGHTMARE débloqué ! Bonne chance vous en aurez besoin.");
        updateBackgroundMusic();
    }

    initBoard();
});
