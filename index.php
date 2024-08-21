<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/chess.js@1.0.0/dist/chess.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chess vs AI</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Chess vs AI</h1>
        <div class="game-controls">
            <div class="turn-indicator">
                Turn: <span id="turn">White</span>
            </div>
            <button id="resetButton">Reset</button>
        </div>
        <div class="chessboard-container">
            <div class="chessboard" id="chessboard">
                <?php
                session_start();
                if (!isset($_SESSION['board'])) {
                    $_SESSION['board'] = [
                        ['bR', 'bN', 'bB', 'bQ', 'bK', 'bB', 'bN', 'bR'],
                        ['bP', 'bP', 'bP', 'bP', 'bP', 'bP', 'bP', 'bP'],
                        ['', '', '', '', '', '', '', ''],
                        ['', '', '', '', '', '', '', ''],
                        ['', '', '', '', '', '', '', ''],
                        ['', '', '', '', '', '', '', ''],
                        ['wP', 'wP', 'wP', 'wP', 'wP', 'wP', 'wP', 'wP'],
                        ['wR', 'wN', 'wB', 'wQ', 'wK', 'wB', 'wN', 'wR'],
                    ];
                    $_SESSION['turn'] = 'white';
                }
                $board = $_SESSION['board'];
                foreach ($board as $row) {
                    echo "<div class='row'>";
                    foreach ($row as $piece) {
                        $class = $piece ? 'occupied' : 'empty';
                        echo "<div class='square $class' data-piece='$piece'>";
                        if ($piece) {
                            $color = $piece[0] === 'w' ? 'white' : 'black';
                            $type = getPieceType($piece);
                            echo "<img src='images/{$color}_{$type}.svg' alt='$piece'>";
                        }
                        echo "</div>";
                    }
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
    <script src="js/game.js"></script>
</body>
</html>

<?php
function getPieceType($piece) {
    switch ($piece[1]) {
        case 'R': return 'rook';
        case 'N': return 'knight';
        case 'B': return 'bishop';
        case 'Q': return 'queen';
        case 'K': return 'king';
        case 'P': return 'pawn';
        default: return '';
    }
}
?>
