<?php

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");

$sqlquery = "SELECT * from Users WHERE email=?"; 
$stmt = mysqli_prepare($conexao, $sqlquery);
$stmt->bind_param('s', $email);
$stmt->execute();

if ($resultado = $stmt->get_result()) {
    if ($linha = $resultado->fetch_assoc()) {
        if (password_verify($password, $linha['password'])) {
            session_start();
            $_SESSION['email'] = $linha['email'];
            header("Location: ./home.php");
        }
    } 
};


?>
