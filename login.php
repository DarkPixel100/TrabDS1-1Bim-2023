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
    if (!empty($_GET['msg'])) {
        if ($_GET['msg'] == 'OK') {
            echo "<main> <h2> Por favor, faça Login</h2> </main>";
        } else if ($_GET['msg'] == 'ERROR') {
            echo mysqli_error();
        }
    }
    ?>
    <header>
        <h1>Login de Usuário</h1>
    </header>

    <main>
        <!-- form ou div com form dentro pro login -->
        <form class="infoBox" action="./login_session.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <label for="email">E-mail:</label>
            <input type="text" id="email" name="email" placeholder="fulano@gmail.com" required>

            <label for="password">Senha:</label>
            <input type="password" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" id="password" name="password" placeholder="....." required>

            <input type="submit" name="submit" value="Login" required>
            <a href="./register.php"> <button type="button"> Registrar </Button> </a>
        </form>
    </main>

</body>

</html>