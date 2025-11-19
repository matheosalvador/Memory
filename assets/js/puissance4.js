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
        popup.classList.add("hidden");
        resetBtn.disabled = true;

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

        let r = ROWS - 1;
        while (r >= 0 && board[r][c] !== null) r--;
        if (r < 0) return;

        board[r][c] = currentPlayer;

        await dropToken(c, r, currentPlayer);

        const cell = boardDiv.children[c].children[r];
        cell.classList.add(currentPlayer);

        if (checkWin(r, c)) {
            endGame(currentPlayer);
            return;
        }

        if (board.every(row => row.every(cell => cell !== null))) {
            endGame("draw");
            return;
        }

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
            token.style.top = "-100px";
            token.style.transition = "top 0.35s cubic-bezier(.2,.9,.3,1)";

            colDiv.appendChild(token);

            const colRect = colDiv.getBoundingClientRect();
            const cellRect = targetCell.getBoundingClientRect();
            const targetY = cellRect.top - colRect.top;

            requestAnimationFrame(() => {
                token.style.top = targetY + "px";
            });

            token.addEventListener("transitionend", () => {
                token.remove();
                targetCell.classList.add("pop");
                setTimeout(() => targetCell.classList.remove("pop"), 250);
                resolve();
            });
        });
    }

    function checkWin(row, col) {
        const color = board[row][col];
        const dirs = [
            [1, 0], [0, 1], [1, 1], [1, -1]
        ];

        for (const [dr, dc] of dirs) {
            const cells = [[row, col]];
            let r = row + dr, c = col + dc;
            while (r >= 0 && r < ROWS && c >= 0 && c < COLS && board[r][c] === color) {
                cells.push([r, c]);
                r += dr; c += dc;
            }
            r = row - dr; c = col - dc;
            while (r >= 0 && r < ROWS && c >= 0 && c < COLS && board[r][c] === color) {
                cells.unshift([r, c]);
                r -= dr; c -= dc;
            }
            if (cells.length >= 4) {
                cells.forEach(([rr, cc]) => {
                    boardDiv.children[cc].children[rr].classList.add("winner");
                });
                return true;
            }
        }
        return false;
    }

    function endGame(winner) {
        gameOver = true;
        popup.classList.remove("hidden");

        if (winner === "draw") {
            winnerPlayer.textContent = "Aucun (égalité)";
        } else {
            winnerPlayer.textContent = winner === "red" ? "Rouge" : "Jaune";
        }

        resetBtn.disabled = false;
    }

    function resetHighlights() {
        document.querySelectorAll(".winner").forEach(e => e.classList.remove("winner"));
    }

    restartBtn.addEventListener("click", () => {
        resetHighlights();
        initBoard();
    });

    resetBtn.addEventListener("click", () => {
        resetHighlights();
        initBoard();
    });

    initBoard();
});
