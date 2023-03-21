function createTile(index) {
  const tile = document.createElement("div");
  tile.classList.add("tile");
  return tile;
}

function createTiles(quantity) {
  Array.from(Array(quantity)).map((tile, index) => {
    tileHolder.appendChild(createTile(index));
  });
}

function createGrid(squareSize) {
  tileHolder.innerHTML = "";

  let columns = Math.floor(document.body.clientWidth / squareSize);
  let rows = Math.floor(document.body.clientHeight / squareSize);

  tileHolder.style.setProprety("--columns", columns);
  tileHolder.style.setProprety("--rows", rows);

  createTiles(columns * rows);
}

let tileHolder = document.getElementById("bgTiles");

// createGrid(50);

window.onresize = () => createGrid(50);
