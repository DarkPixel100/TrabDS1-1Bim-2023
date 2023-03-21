<?php session_start();
$_SESSION["userID"] = 1; ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca de jooj</title>
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./style.css">
    <script src="tiles.js"></script>
</head>

<body>
    <div id="bgTiles">
    </div>
    <header>
        <h1>Cadastro de Cartuchos</h1>
    </header>
    <div id="wrapper">
        <form action="./cadastrando.php" method="post" enctype="multipart/form-data">
            <label for="titulo">Título do jogo:</label>
            <input type="text" name="titulo" required>
            <label for="empresa">Noma da Empresa:</label>
            <input type="text" name="empresa" required>
            <label for="sistema">Sistema:</label>
            <input type="text" name="sistema" required>
            <label for="ano">Ano de lançamento:</label>
            <input type="date" name="ano" required>
            <label for="fotocartucho">Foto do cartucho:</label>
            <input type="file" name="fotocartucho" accept="image/png, image/jpg, image/jpeg" required>
            <input type="submit" name="submit" value="Cadastrar">
        </form>
        <ul id="gameList">
            <?php
            $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");
            $sqlquery = "SELECT UserGames.gameID, UserGames.titulo, UserGames.sistema, UserGames.ano, UserGames.empresa, UserGames.imgpath FROM UserGames JOIN Users WHERE UserGames.gameID = '" . $_SESSION["userID"] . "';";
            $resultado = mysqli_query($conexao, $sqlquery);
            $resultarray = array();
            while ($data = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                array_push($resultarray, $data);
            }
            foreach ($resultarray as $jogo) : ?>
                <div class="jogo" id="<?php $jogo["gameID"] ?>">
                    <img src="<?php $jogo["imgpath"] ?>">
                    <h3>
                        <?php $jogo["titulo"] ?>
                    </h3>
                    <span>
                        <?php $jogo["empresa"] ?> -
                        <?php $jogo["ano"] ?>
                    </span>
                    <span>
                        <?php $jogo["sistema"] ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>