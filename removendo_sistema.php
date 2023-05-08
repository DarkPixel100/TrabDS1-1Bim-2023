<?php
session_start();

if (isset($_POST["removeID"])) {
    $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");

    // Pegando dados do jogo do banco
    $sqlquery = "SELECT * FROM sistemas WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("i", $_POST["removeID"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $resultarray = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

    // Removendo o sistema do banco
    $sqlquery = "DELETE FROM sistemas WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("i", $_POST["removeID"]);
    $stmt->execute();

    // Retornando à página anterior
    header("Location: ./sistemas.php");
}
