const ROWS = 6;
const COLS = 7;
let currentPlayer = 'red';
let board = Array.from({ length: ROWS }, () => Array(COLS).fill(null));

const grid = document.getElementById('grid');

function renderGrid() {
    grid.innerHTML = '';
    for (let r = 0; r < ROWS; r++) {
        for (let c = 0; c < COLS; c++) {
            const cell = document.createElement('div');
            cell.classList.add('cell');
            cell.dataset.row = r;
            cell.dataset.col = c;
            if (board[r][c]) cell.classList.add(board[r][c]);
            cell.addEventListener('click', () => dropToken(c));
            grid.appendChild(cell);
        }
    }
}

function dropToken(col) {
    for (let r = ROWS - 1; r >= 0; r--) {
        if (!board[r][col]) {
            board[r][col] = currentPlayer;
            if (checkWin(r, col)) {
                setTimeout(() => alert(currentPlayer.toUpperCase() + ' gagne !'), 50);
            }
            currentPlayer = currentPlayer === 'red' ? 'yellow' : 'red';
            renderGrid();
            break;
        }
    }
}

function checkWin(row, col) {
    return (
        checkDir(row, col, 1, 0) ||
        checkDir(row, col, 0, 1) ||
        checkDir(row, col, 1, 1) ||
        checkDir(row, col, 1, -1)
    );
}

function checkDir(row, col, dr, dc) {
    let count = 1;
    count += countTokens(row, col, dr, dc);
    count += countTokens(row, col, -dr, -dc);
    return count >= 4;
}

function countTokens(row, col, dr, dc) {
    let r = row + dr;
    let c = col + dc;
    let count = 0;
    while (r >= 0 && r < ROWS && c >= 0 && c < COLS && board[r][c] === currentPlayer) {
        count++;
        r += dr;
        c += dc;
    }
    return count;
}

document.getElementById('resetBtn').addEventListener('click', () => {
    board = Array.from({ length: ROWS }, () => Array(COLS).fill(null));
    currentPlayer = 'red';
    renderGrid();
});

renderGrid();
