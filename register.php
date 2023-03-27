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
        <form class="infoBox" action="./insert_data.php" method="post" enctype="multipart/form-data" autocomplete="off">
            <label for="username">Nome de usuário:</label>
            <input type="text" id="username" name="username" placeholder="Fulano da Silva" required>
            
            <label for="email">E-mail:</label>
            <input type="text" id="email" name="email" placeholder="fulano@gmail.com" required>

            <label for="password">Senha:</label>
            <input type="text" id="password" name="password" placeholder="xxxxxx" required>

            <input type="submit" name="submit" value="Registrar" required>
        </form>
    </main>

</body>

</html>