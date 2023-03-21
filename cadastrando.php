<?php
if (isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");
    $sqlquery = "INSERT INTO UserGames (titulo, sistema, ano, empresa, imgpath) VALUES ('" . $_POST["titulo"] . "','" . $_POST["sistema"] . "','" . $_POST["ano"] . "','" . $_POST["empresa"] . "','" . $_POST["imgpath"] . "');";
    $resultado = mysqli_query($conexao, $sqlquery);
}
?>