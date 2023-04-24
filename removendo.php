<?php
session_start();

if (isset($_POST["removeID"])) {
    $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");

    // Pegando dados do jogo do banco
    $sqlquery = "SELECT * FROM cartuchos WHERE gameID = ?";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("i", $_POST["removeID"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $resultarray = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

    // Registrando a remoção no relatório
    $date = date("Y-m-d h:i:s");
    $sqlquery = "INSERT INTO historicoderemocao (deletionUserID, gameUserID, titulo, sistema, ano, empresa, dataremocao) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("iississ", $_SESSION["userID"], $resultarray["userID"], $resultarray["titulo"], $resultarray["sistema"], $resultarray["ano"], $resultarray["empresa"], $date);
    $stmt->execute();

    // Removendo o cartucho do banco
    $sqlquery = "DELETE FROM cartuchos WHERE gameID = ?";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("i", $_POST["removeID"]);
    $stmt->execute();

    // Removendo a imagem dos arquivos
    $path = $resultarray["imgpath"];
    unlink($path);

    // Retornando à página anterior
    header("Location: ./home.php");
}