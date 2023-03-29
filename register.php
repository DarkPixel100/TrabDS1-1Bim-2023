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
    <header>
        <h1>Cadastro de Usuário</h1>
    </header>

    <main>
        <!-- Form de registro -->
        <form class="infoBox" action="./cadastra_user.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <label for="username">Nome de usuário:</label>
            <input type="text" id="username" name="username" placeholder="Fulano da Silva" minlength="5" required>

            <label for="email">E-mail:</label>
            <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" id="email" name="email" placeholder="fulano@gmail.com" required>

            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" placeholder="Senha%123" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" oninvalid="this.setCustomValidity('A senha deve ter:\n-8 ou mais caracteres;\n-1 ou mais número;')" required>

            <input type="submit" name="submit" value="Registrar" required>
        </form>
    </main>

</body>

</html>