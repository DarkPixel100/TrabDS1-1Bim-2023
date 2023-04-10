// Criando o elemento do popup (e add a imagem no centro)
function popup(data) {
  let fullDiv = document.createElement("div");
  fullDiv.id = "popup";
  document.body.prepend(fullDiv);
  let innerHTML;
  if (data["type"] == "img") {

    fullDiv.addEventListener("click", (e) => { // Fechar o popup
      if (e.target.tagName == 'DIV')
        fullDiv.remove();
    });
    innerHTML = `<img src="${data["url"]}">`;
    fullDiv.innerHTML = innerHTML;
    return;
  } else if (data["type"] == "remove") {
    innerHTML = `
    <form class="infoBox" action="removendo.php" method="POST">
    <h3>Tem certeza que deseja remover esse cartucho?</h3>
    <button type="submit" name="removeID" value="${data["id"]}">Sim</button>
    <button type="button" id="cancel">Não</button>
    </form>
    `;
  } else if (data["type"] == "edit") {
    innerHTML = `
    <form class="infoBox" action="editando.php" method="POST" enctype="multipart/form-data>
      <h3>Editar dados do cartucho:</h3>
      <label for="titulo">Novo título:</label>
            <input type="text" id="titulo" name="titulo">

            <label for="empresa">Alterar Empresa:</label>
            <input type="text" id="empresa" name="empresa">

            <label for="sistema">Alterar Sistema:</label>
            <input type="text" id="sistema" name="sistema">

            <label for="ano">Alterar ano de lançamento:</label>
            <input type="number" id="ano" name="ano" inputmode="numeric" step="1" min="1910" max="${new Date().getFullYear()}" placeholder="1910-${new Date().getFullYear()}">
      <span class="buttons">
        <button type="submit" name="editID" value="${data["id"]}">Confirmar</button>
        <button type="button" id="cancel">Cancelar</button>
      </span>
    </form>
    `;
  }
  fullDiv.innerHTML = innerHTML;
  document.getElementById('cancel').addEventListener('click', () => {
    fullDiv.remove();
  });
}

// Eventos para gerar popups
document.getElementById('gameList').addEventListener("click", (e) => {
  let clicked = e.target;
  if (clicked.classList.contains('imgBox'))
    popup({ type: "img", url: clicked.children[0].src });
  else if (clicked.classList.contains('remove-btn') || clicked.parentElement.classList.contains('remove-btn'))
    popup({ type: "remove", id: clicked.value ? clicked.value : clicked.parentElement.value});
  else if (clicked.classList.contains('edit-btn') || clicked.parentElement.classList.contains('edit-btn'))
    popup({ type: "edit", id: clicked.value ? clicked.value : clicked.parentElement.value });
});
