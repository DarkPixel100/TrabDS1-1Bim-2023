<?php
session_start();

if (isset($_POST["submit"])) {

    // Inserindo o sistema cadastrado no banco
    $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");

    $sqlquery = "INSERT INTO sistemas (id, nome, fabricante, ano) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("issi", 
    $_SESSION["id"], 
    $_POST["nome"], 
    $_POST["fabricante"], 
    $_POST["ano"],);

    $stmt->execute();
    $resultado = $stmt->get_result();

    // Retornando à página anterior
    header("Location: ./sistemas.php");
}
?>