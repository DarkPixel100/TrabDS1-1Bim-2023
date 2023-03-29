<?php

$email = $_POST['email'];
$password = $_POST['password'];

$conexao = mysqli_connect("localhost", "root", "", "DS1-ListaJogos-Diego-Sofia");

$sqlquery = "SELECT * from Users WHERE email=?"; 
$stmt = mysqli_prepare($conexao, $sqlquery);
$stmt->bind_param('s', $email);
$stmt->execute();

if ($resultado = $stmt->get_result()) {
    if ($linha = $resultado->fetch_assoc()) {
        if (password_verify($password, $linha['password'])) {
            session_start();
            $_SESSION['userID'] = $linha['userID'];
            header("Location: ./home.php");
        }
    } 
};

?>
