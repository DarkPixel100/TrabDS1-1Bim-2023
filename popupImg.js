// Criando o elemento do popup (e add a imagem no centro)
function popup(url) {
  let fullDiv = document.createElement("div");
  fullDiv.id = "popup";
  document.body.prepend(fullDiv);
  fullDiv.addEventListener("click", (e) => { // Fechar o popup
    if (e.target.tagName == 'DIV')
    fullDiv.remove();
  });
  let innerHTML = `<img src="${url}">`;
  fullDiv.innerHTML = innerHTML;
}

// Evento para gerar o popup
document.getElementsByTagName("main")[0].addEventListener("click", (e) => {
  if (e.target.classList.contains('imgBox'))
    popup(e.target.children[0].src);
});
