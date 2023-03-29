<?php
if (isset($_POST["submit"])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $conexao = mysqli_connect("localhost", "root", "", "DS1-ListaJogos-Diego-Sofia");
    $sqlquery = "INSERT INTO Users (username, email, password) VALUES ('$username', '$email', '$password');";

    if (mysqli_query($conexao, $sqlquery)) {
        header ("Location: login.php?msg=OK"); 
    } 
    else {
        header ("Location: login.php=ERRO");
    }
}
?>