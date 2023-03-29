<?php
session_start();

if (isset($_POST["removeID"])) {
    $conexao = mysqli_connect("localhost", "root", "", "DS1-ListaJogos-Diego-Sofia");

    // Removendo a imagem dos arquivos
    $sqlquery = "SELECT imgpath FROM Cartuchos WHERE gameID = ?";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("i", $_POST["removeID"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $path = mysqli_fetch_array($resultado, MYSQLI_ASSOC)["imgpath"];
    unlink($path);

    // Removendo o cartucho do banco
    $sqlquery = "DELETE FROM Cartuchos WHERE gameID = ?";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("i", $_POST["removeID"]);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Retornando à página anterior
    header("Location: ./home.php");
}