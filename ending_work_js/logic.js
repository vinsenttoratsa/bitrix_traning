let players = ['x', 'o'];
let activePlayer = 0;
let board = [];
let size = 3; 

function startGame() {
  board = Array(size).fill().map(() => Array(size).fill(''));
  activePlayer = 0; 
  renderBoard(board);
}

function click(row, col) {
  if (board[row][col] !== '' || checkWinner() !== null) {
    return;
  }

  board[row][col] = players[activePlayer];
  renderBoard(board);

  const winner = checkWinner();
  if (winner !== null) {
    showWinner(winner);
    return;
  }

  if (isBoardFull()) {
    showWinner(-1); 
    return;
  }

  activePlayer = (activePlayer + 1) % players.length;
}

function checkWinner() {
  for (let row = 0; row < size; row++) {
    if (board[row][0] !== '' && board[row].every(cell => cell === board[row][0])) {
      return players.indexOf(board[row][0]);
    }
  }

  for (let col = 0; col < size; col++) {
    const column = board.map(row => row[col]);
    if (column[0] !== '' && column.every(cell => cell === column[0])) {
      return players.indexOf(column[0]);
    }
  }

  const diag1 = board.map((row, i) => row[i]);
  if (diag1[0] !== '' && diag1.every(cell => cell === diag1[0])) {
    return players.indexOf(diag1[0]);
  }

  const diag2 = board.map((row, i) => row[size - 1 - i]);
  if (diag2[0] !== '' && diag2.every(cell => cell === diag2[0])) {
    return players.indexOf(diag2[0]);
  }

  return null;
}

function isBoardFull() {
  return board.every(row => row.every(cell => cell !== ''));
}

document.querySelectorAll('.reset').forEach(button => {
  button.addEventListener('click', startGame);
});