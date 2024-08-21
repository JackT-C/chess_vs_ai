document.addEventListener('DOMContentLoaded', () => {
    const chessboard = document.getElementById('chessboard');
    const chess = new Chess(); // Initialize a new chess game
    let selectedSquare = null;

    // Initialize the chessboard
    initializeBoard();
    updateTurnDisplay();

    chessboard.addEventListener('click', (event) => {
        const square = event.target.closest('.square');
        if (!square) return;

        const piece = square.dataset.piece;

        if (selectedSquare) {
            const from = selectedSquare.dataset.square;
            const to = square.dataset.square;

            if (selectedSquare !== square) {
                const move = { from, to };
                if (chess.move(move)) {
                    updateBoard();
                    if (chess.game_over()) {
                        alert('Game over');
                        return;
                    }
                    if (chess.turn() === 'b') {
                        makeAiMove(); // AI makes a move if it's black's turn
                    } else {
                        updateTurnDisplay();
                    }
                } else {
                    alert('Invalid move');
                }
            }
            selectedSquare.classList.remove('selected');
            selectedSquare = null;
        } else {
            if (piece && piece[0] === chess.turn()) {
                selectedSquare = square;
                selectedSquare.classList.add('selected');
            }
        }
    });

    function initializeBoard() {
        const board = chess.board();
        board.forEach((row, rowIndex) => {
            const rowDiv = document.createElement('div');
            rowDiv.classList.add('row');
            row.forEach((square, colIndex) => {
                const squareDiv = document.createElement('div');
                squareDiv.classList.add('square');
                squareDiv.dataset.square = `${rowIndex},${colIndex}`;
                squareDiv.dataset.piece = square ? square.color + square.type.toUpperCase() : '';
                if (square) {
                    const color = square.color;
                    const type = square.type;
                    squareDiv.innerHTML = `<img src='images/${color}_${type}.svg' alt='${color}${type.toUpperCase()}'>`;
                }
                rowDiv.appendChild(squareDiv);
            });
            chessboard.appendChild(rowDiv);
        });
    }

    function updateBoard() {
        const board = chess.board();
        const squares = document.querySelectorAll('.square');
        squares.forEach(square => {
            const [row, col] = square.dataset.square.split(',');
            const piece = board[row][col];
            square.dataset.piece = piece ? piece.color + piece.type.toUpperCase() : '';
            if (piece) {
                const color = piece.color;
                const type = piece.type;
                square.innerHTML = `<img src='images/${color}_${type}.svg' alt='${color}${type.toUpperCase()}'>`;
            } else {
                square.innerHTML = '';
            }
        });
    }

    function makeAiMove() {
        const moves = chess.ugly_moves();
        const move = moves[Math.floor(Math.random() * moves.length)];
        chess.move(move);
        updateBoard();
        if (chess.game_over()) {
            alert('Game over');
        } else {
            updateTurnDisplay();
        }
    }

    function updateTurnDisplay() {
        document.getElementById('turn').textContent = chess.turn() === 'w' ? 'White' : 'Black';
    }

    document.getElementById('resetButton').addEventListener('click', () => {
        chess.reset();
        updateBoard();
        updateTurnDisplay();
    });
});
