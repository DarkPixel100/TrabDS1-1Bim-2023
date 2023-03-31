<?php
// Obtendo variáveis do post
$emailORusername = $_POST["emailORuser"];
$password = $_POST["password"];

// Conectando com o banco
$conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");

// Buscando o usuário no banco
$sqlquery = "SELECT * from Users WHERE email = ? OR username = ?";
$stmt = mysqli_prepare($conexao, $sqlquery);
$stmt->bind_param('ss', $emailORusername, $emailORusername);
$stmt->execute();
$resultado = $stmt->get_result();
$linha = $resultado->fetch_assoc();
var_dump($resultado, $password, $linha["password"]);
// Verificanndo senha
if ($resultado) {
    if ($linha) {

        if (password_verify($password, $linha["password"])) {
            // Iniciando a sessão
            session_start();
            session_set_cookie_params(0);
            $_SESSION["userID"] = $linha["id"];
            header("Location: ./home.php");
        } else {
            header("Location: ./login.php?msg=ERROR");
        }
    } else {
        header("Location: ./login.php?msg=ERROR");
    }
} else {
    echo mysqli_error($conexao);
};
