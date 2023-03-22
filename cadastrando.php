<?php
session_start();
if (isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . "cartuchoUSER" . $_SESSION["userID"] . "_" . date("d-m-y_h-i-s") . "." . pathinfo($_FILES["fotocartucho"]["name"], PATHINFO_EXTENSION);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["fotocartucho"]["tmp_name"], $target_file);

    $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");

    $sqlquery = "INSERT INTO UserGames (userID, titulo, sistema, ano, empresa, imgpath) VALUES ('".$_SESSION["userID"]."', '" . $_POST["titulo"] . "','" . $_POST["sistema"] . "','" .  $_POST["ano"] . "','" . $_POST["empresa"] . "','" . $target_file . "');";
    $resultado = mysqli_query($conexao, $sqlquery);
    header("Location: ./home.php");
}
?>