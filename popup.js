// Criando o elemento do popup (e add a imagem no centro)
function popup(data) {
  let fullDiv = document.createElement("div");
  fullDiv.id = "popup";
  document.body.prepend(fullDiv);
  let innerHTML;
  // remove
  if (data["type"] == "remove") {
    innerHTML = `
    <form class="infoBox" action=" removendo_${data["item"]}.php" method="POST">
      <h3>Tem certeza que deseja remover esse ${data["item"]}?</h3>
      <button type="submit" name="removeID" value="${data["id"]}">Sim</button>
      <button type="button" id="cancel">Não</button>
    </form>
    `;
  } else if (data["type"] == "edit") {
    // edita
    innerHTML = `
    <form class="infoBox" action="editando_${data["item"]}.php" method="POST" enctype="multipart/form-data" autocomplete="off">
      <h3>Editar dados do ${data["item"]}:</h3>
      `;
    if (data["item"] == "cartucho") {
      innerHTML += `
      <label for="titulo">Novo título:</label>
      <input type="text" id="titulo" name="titulo">

      <label for="empresa">Alterar Empresa:</label>
      <input type="text" id="empresa" name="empresa">

      <label for="sistema">Alterar Sistema:</label>
      ${select.outerHTML}
      `;

    } else {
      innerHTML += `
      <label for="nome">Novo nome:</label>
      <input type="text" id="nome" name="nome">

      <label for="fabricante">Alterar Fabricante:</label>
      <input type="text" id="fabricante" name="fabricante">`;
    }
    innerHTML += `
      <label for="ano">Alterar ano de lançamento:</label>
      <input type="number" id="ano" name="ano" inputmode="numeric" step="1" min="1910" max="${new Date().getFullYear()}" placeholder="1910-${new Date().getFullYear()}">
      <span class="buttons">
        <button type="submit" name="itemID" value="${data["id"]}">Confirmar</button>
        <button type="button" id="cancel">Cancelar</button>
      </span>
    </form>
    `;
  } else {
    // Relatórios
    fullDiv.addEventListener("click", (e) => {
      // Fechar o popup
      if (e.target.tagName == "DIV") fullDiv.remove();
    });
    if (data["type"] == "img") {
      innerHTML = `<img src="${data["url"]}">`;
    } else if (data["type"] == "tables") {
      innerHTML = `
      <form id="relatorios" class="infoBox" action="relatorio.php" method="POST">
        <button type="submit" name="relatorio" value="mine">Meus cartuchos</button>
        <button type="submit" name="relatorio" value="all">Todos os cartuchos</button>
        <button type="submit" name="relatorio" value="removed">Cartuchos removidos</button>
        <button type="submit" name="relatorio" value="summary">Relatório resumo</button>
      </form>
    `;
    }
    fullDiv.innerHTML = innerHTML;
    return;
  }
  fullDiv.innerHTML = innerHTML;
  document.getElementById("cancel").addEventListener("click", () => {
    fullDiv.remove();
  });
}

// Eventos para gerar popups
let select = document.getElementById("sistema");
document.addEventListener("click", (e) => {
  let clicked = e.target;
  if (clicked.classList.contains("imgBox"))
    popup({ type: "img", url: clicked.children[0].src });
  else if (
    clicked.classList.contains("remove-btn") ||
    clicked.parentElement.classList.contains("remove-btn")
  )
    popup({
      type: "remove",
      item: clicked.value
        ? clicked.parentElement.parentElement.parentElement.classList[1]
        : clicked.parentElement.parentElement.parentElement.parentElement
            .classList[1],
      id: clicked.value ? clicked.value : clicked.parentElement.value,
    });
  else if (
    clicked.classList.contains("edit-btn") ||
    clicked.parentElement.classList.contains("edit-btn")
  )
    popup({
      type: "edit",
      item: clicked.value
        ? clicked.parentElement.parentElement.parentElement.classList[1]
        : clicked.parentElement.parentElement.parentElement.parentElement
            .classList[1],
      id: clicked.value ? clicked.value : clicked.parentElement.value,
    });
  else if (clicked.classList.contains("tables")) popup({ type: "tables" });
});