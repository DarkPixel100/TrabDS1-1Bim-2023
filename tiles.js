const tileHolder = document.createElement("div");
tileHolder.id = "bgTiles";
document.body.prepend(tileHolder);

let columns = 0, rows = 0;

function createTile() {
  const tile = document.createElement("div");
  tile.classList.add("tile");
  return tile;
}

function createTiles(quantity) {
  Array.from(Array(quantity)).map((tile) => {
    tileHolder.appendChild(createTile());
  });
}

function createGrid() {
  tileHolder.innerHTML = "";

  const size = document.body.clientWidth > 800 ? 100 : 50;

  columns = Math.floor(document.body.clientWidth / size);
  rows = Math.floor(document.body.clientHeight / size);

  tileHolder.style.setProperty("--columns", columns);
  tileHolder.style.setProperty("--rows", rows);

  createTiles(columns * rows);
};

createGrid();

window.onresize = () => createGrid();
