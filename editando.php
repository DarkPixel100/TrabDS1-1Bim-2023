<?php
session_start();

if (isset($_POST["editID"])) {
    $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");

    // Alterando dados do cartucho
    $sqlquery = "UPDATE FROM cartuchos WHERE gameID = ?";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("i", $_POST["editID"]);
    $stmt->execute();

    // Retornando à página anterior
    header("Location: ./home.php");
}