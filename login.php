<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cadastro de Cartuchos</title>

    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./general.css">

    <script src="tiles.js" defer></script>

    <script src="https://kit.fontawesome.com/cb01a77c08.js" crossorigin="anonymous"></script>
</head>

<body class="oceanic">
    <?php
    // Checando se já está logado
    session_start();
    if (isset($_SESSION["userID"])) {
        header("Location: ./home.php");
    }
    session_destroy();
    
    // Requisitando login após registro
    if (!empty($_GET['msg'])) {
        if ($_GET['msg'] == 'OK') {
            echo "<main> <h2> Por favor, faça Login</h2> </main>";
        } else if ($_GET['msg'] == 'ERROR') {
            $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");
            echo "<main> <h2> Login e/ou senha incorreto(s) </h2> </main>";
        }
    }
    ?>
    <header>
        <h1>Login de Usuário</h1>
    </header>

    <main>
        <!-- Form de login -->
        <form class="infoBox" action="./login_session.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <label for="emailORuser">Email ou Nome de Usuário:</label>
            <input type="text" id="emailORuser" name="emailORuser" placeholder="fulano@gmail.com ou fulano_12" required>

            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" placeholder="Senha" required>

            <input type="submit" name="submit" value="Login" required>
            <a href="./register.php"> <button type="button">Criar Conta</Button> </a>
        </form>
    </main>

</body>

</html>