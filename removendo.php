<?php
session_start();

if (isset($_POST["removeID"])) {
    $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");

    // Removendo a imagem dos arquivos
    $sqlquery = "SELECT imgpath FROM Cartuchos WHERE gameID = ?";
    $resultado = $conexao->execute_query($sqlquery, [$_POST["removeID"]]);
    $path = mysqli_fetch_array($resultado, MYSQLI_ASSOC)["imgpath"];
    unlink($path);

    // Removendo o cartucho do banco
    $sqlquery = "DELETE FROM Cartuchos WHERE gameID = ?";
    $resultado = $conexao->execute_query($sqlquery, [$_POST["removeID"]]);

    // Retornando à página anterior
    header("Location: ./home.php");
}