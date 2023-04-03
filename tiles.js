// Elemento que contêm os quadrados
const tileHolder = document.createElement("div");
tileHolder.id = "bgTiles";
document.body.prepend(tileHolder);

let columns = 0, rows = 0;

// Criar 1 quadrado
function createTile() {
  const tile = document.createElement("div");
  tile.classList.add("tile");
  return tile;
}

// Gerar todos os quadrados baseado na quantidade calculada
function createTiles(quantity) {
  Array.from(Array(quantity)).map((tile) => {
    tileHolder.appendChild(createTile());
  });
}

// Criando a grade (definindo propriedades do tileHolder)
function createGrid() {
  tileHolder.innerHTML = "";
  tileHolder.style.height =
    (document.body.clientHeight / visualViewport.height) * 100 + "%";
  
  const size = 100;
  
  columns = Math.floor(document.body.clientWidth / size);
  rows = Math.floor(document.body.clientHeight / size);
  
  tileHolder.style.setProperty("--columns", columns);
  tileHolder.style.setProperty("--rows", rows);

  createTiles(columns * rows);
};

createGrid();

window.onresize = () => createGrid();
