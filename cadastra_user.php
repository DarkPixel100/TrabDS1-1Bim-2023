<?php
if (isset($_POST["submit"])) {
    // Obtendo variáveis do post
    $username = $_POST["username"];
    $email = $_POST["email"];

    // Hashing da senha
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    // Conectando com o banco
    $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");

    // Inserindo o Usuário no banco
    $sqlquery = "INSERT INTO Users (username, email, password) VALUES(?, ?, ?);";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param(
        "sss",
        $username,
        $email,
        $password
    );

    // Checando erros
    if ($stmt->execute()) {
        header ("Location: login.php?msg=OK"); 
    } 
    else {
        header ("Location: login.php=ERRO");
    }
}
?>