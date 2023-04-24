<?php
session_start();

if (isset($_POST["gameID"])) {
    $conexao = mysqli_connect("localhost", "root", "mysqluser", 
    "DS1-ListaJogos-Diego-Sofia");

    $sqlquery = "SELECT * FROM cartuchos WHERE gameID = ?";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("i", $_POST["gameID"]);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $resultarray = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

    foreach ($resultarray as $key => $value) {
        if (isset($_POST[$key])) {
            if ($_POST[$key] == '')
            $infos[$key] = $value;
            else
            $infos[$key] = $_POST[$key];
        }
    }

    // Alterando dados do cartucho
    $sqlquery = "UPDATE cartuchos SET titulo = ?, empresa = ?, sistema = ?, ano = ? WHERE gameID = ?";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("sssii", $infos["titulo"], $infos["empresa"], $infos["sistema"], $infos["ano"], $infos["gameID"]);
    $stmt->execute();

    // Retornando à página anterior
    header("Location: ./home.php");
}
