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

    function initBoard() {
        board = Array.from({ length: ROWS }, () => Array(COLS).fill(null));
        boardDiv.innerHTML = "";
        currentPlayer = "red";
        currentPlayerSpan.textContent = "Rouge";
        gameOver = false;
        if (popup) popup.classList.add("hidden");
        if (resetBtn) resetBtn.disabled = true;

        for (let c = 0; c < COLS; c++) {
            const colDiv = document.createElement("div");
            colDiv.classList.add("column");
            colDiv.dataset.col = c;

            colDiv.addEventListener("click", () => handleMove(c));

            for (let r = 0; r < ROWS; r++) {
                const cell = document.createElement("div");
                cell.className = "cell";
                cell.dataset.row = r;
                cell.dataset.col = c;
                colDiv.appendChild(cell);
            }

            boardDiv.appendChild(colDiv);
        }
    }

    async function handleMove(c) {
        if (gameOver) return;

        // trouve la plus basse case libre
        let r = ROWS - 1;
        while (r >= 0 && board[r][c] !== null) r--;
        if (r < 0) return;

        // pose le jeton dans la logique
        board[r][c] = currentPlayer;

        // anime la chute
        await dropToken(c, r, currentPlayer);

        // marque visuellement la case finale
        const cell = boardDiv.children[c].children[r];
        if (cell) {
            const settled = document.createElement("div");
            settled.className = `token ${currentPlayer}`;
            settled.style.width = "100%";
            settled.style.height = "100%";
            settled.style.borderRadius = "50%";
            cell.appendChild(settled);
            cell.classList.add("pop");
            setTimeout(() => cell.classList.remove("pop"), 220);
        }

        // recherche des cellules gagnantes
        const winning = getWinningCells(r, c);
        if (winning.length) {
            winning.forEach(([wr, wc]) => {
                const slot = boardDiv.children[wc].children[wr];
                if (slot) slot.classList.add("winner");
            });
            endGame(currentPlayer);
            return;
        }

        // égalité ?
        if (board.every(row => row.every(cell => cell !== null))) {
            endGame("draw");
            return;
        }

        // change de joueur
        currentPlayer = currentPlayer === "red" ? "yellow" : "red";
        currentPlayerSpan.textContent = currentPlayer === "red" ? "Rouge" : "Jaune";
    }

    function dropToken(c, r, color) {
        return new Promise(resolve => {
            const colDiv = boardDiv.children[c];
            const targetCell = colDiv.children[r];

            const token = document.createElement("div");
            token.className = `token ${color}`;
            token.style.position = "absolute";
            token.style.left = "50%";
            token.style.transform = "translateX(-50%)";
            token.style.top = "-120px";
            token.style.transition = "top 0.38s cubic-bezier(.2,.9,.3,1)";

            colDiv.appendChild(token);

            const colRect = colDiv.getBoundingClientRect();
            const cellRect = targetCell.getBoundingClientRect();
            const targetY = cellRect.top - colRect.top;

            requestAnimationFrame(() => {
                token.style.top = `${targetY}px`;
            });

            const onEnd = () => {
                token.removeEventListener("transitionend", onEnd);
                if (token.parentElement) token.parentElement.removeChild(token);
                resolve();
            };
            token.addEventListener("transitionend", onEnd);

            setTimeout(() => {
                if (token.parentElement) onEnd();
            }, 700);
        });
    }

    function getWinningCells(row, col) {
        const color = board[row][col];
        if (!color) return [];

        const directions = [
            [0, 1],
            [1, 0],
            [1, 1],
            [1, -1]
        ];

        for (const [dr, dc] of directions) {
            const matched = [[row, col]];

            let r = row + dr, c = col + dc;
            while (r >= 0 && r < ROWS && c >= 0 && c < COLS && board[r][c] === color) {
                matched.push([r, c]);
                r += dr; c += dc;
            }

            r = row - dr; c = col - dc;
            while (r >= 0 && r < ROWS && c >= 0 && c < COLS && board[r][c] === color) {
                matched.unshift([r, c]);
                r -= dr; c -= dc;
            }

            if (matched.length >= 4) {
                return matched;
            }
        }

        return [];
    }

    function endGame(winner) {
        gameOver = true;
        if (popup) popup.classList.remove("hidden");

        if (winner === "draw") {
            if (winnerPlayer) winnerPlayer.textContent = "Aucun (égalité)";
        } else {
            if (winnerPlayer) winnerPlayer.textContent = winner === "red" ? "Rouge" : "Jaune";
        }

        // 🔊 AUDIO DE VICTOIRE
        const title = document.getElementById("winner-title");
        if (title) {
            const audioSrc = title.getAttribute("data-audio");
            if (audioSrc) {
                const audio = new Audio(audioSrc);
                audio.play().catch(err => console.error("Erreur audio :", err));
            }
        }

        if (resetBtn) resetBtn.disabled = false;
    }

    function resetHighlights() {
        document.querySelectorAll(".winner").forEach(e => e.classList.remove("winner"));
        document.querySelectorAll(".cell .token").forEach(tok => tok.remove());
    }

    if (restartBtn) restartBtn.addEventListener("click", () => {
        resetHighlights();
        initBoard();
    });

    if (resetBtn) resetBtn.addEventListener("click", () => {
        resetHighlights();
        initBoard();
    });

    initBoard();
});
