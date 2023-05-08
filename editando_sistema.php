<?php
session_start();

if (isset($_POST["itemID"])) {
    $conexao = mysqli_connect(
        "localhost",
        "root",
        "mysqluser",
        "DS1-ListaJogos-Diego-Sofia"
    );

    $sqlquery = "SELECT * FROM sistemas WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("i", $_POST["itemID"]);
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
    $sqlquery = "UPDATE sistemas SET nome = ?, fabricante = ?, ano = ? WHERE id = ?";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("ssii", $infos["nome"], $infos["fabricante"], $infos["ano"], $_POST["itemID"]);
    $stmt->execute();

    // Retornando à página anterior
    header("Location: ./sistemas.php");
}
