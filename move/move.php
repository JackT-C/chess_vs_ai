<?php
session_start();
header('Content-Type: application/json');

function isMoveValid($from, $to, $board, $color) {
    // Implement piece-specific move validation logic here
    return true;
}

if (!isset($_SESSION['board']) || !isset($_SESSION['turn'])) {
    echo json_encode(['success' => false, 'error' => 'Game not initialized']);
    exit;
}

$board = $_SESSION['board'];
$turn = $_SESSION['turn'];

$data = json_decode(file_get_contents('php://input'), true);
$from = $data['from'] ?? null;
$to = $data['to'] ?? null;

if (!$from || !$to) {
    echo json_encode(['success' => false, 'error' => 'Invalid move data']);
    exit;
}

if (!isMoveValid($from, $to, $board, $turn)) {
    echo json_encode(['success' => false, 'error' => 'Invalid move']);
    exit;
}

// Apply the move
list($fromRow, $fromCol) = explode(',', $from);
list($toRow, $toCol) = explode(',', $to);
$board[$toRow][$toCol] = $board[$fromRow][$fromCol];
$board[$fromRow][$fromCol] = '';

$_SESSION['board'] = $board;

echo json_encode(['success' => true]);
?>
