function popup(url) {
  let fullDiv = document.createElement("div");
  fullDiv.id = "popup";
  document.body.prepend(fullDiv);
  fullDiv.addEventListener("click", (e) => {
    if (e.target.tagName == 'DIV')
    fullDiv.remove();
  });
  let innerHTML = `<img src="${url}">`;
  fullDiv.innerHTML = innerHTML;
}

document.getElementsByTagName("main")[0].addEventListener("click", (e) => {
  if (e.target.classList.contains('imgBox'))
    popup(e.target.children[0].src);
});
