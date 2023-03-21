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
    <script src="tiles.js" defer></script>
</head>

<body>
    <header>
        <h1>Cadastro de Cartuchos</h1>
    </header>
    <main>
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
        <div id="gameList">
            <ul>
                <?php
                $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");
                $sqlquery = "SELECT UserGames.gameID, UserGames.titulo, UserGames.sistema, UserGames.ano, UserGames.empresa, UserGames.imgpath FROM UserGames JOIN Users WHERE UserGames.userID = '" . $_SESSION["userID"] . "';";
                $resultado = mysqli_query($conexao, $sqlquery);
                $resultarray = array();
                while ($data = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                    array_push($resultarray, $data);
                }
                foreach ($resultarray as $jogo) : ?>
                    <li class="jogo" id="<?php echo $jogo["gameID"] ?>">
                        <div class="imgBox">
                            <img src="<?php echo $jogo["imgpath"] ?>">
                        </div>
                        <div class="gameInfo">
                            <h3 class="gameTitle">
                                <?php echo $jogo["titulo"] ?>
                            </h3>
                            <span>
                                <?php echo $jogo["empresa"] ?>
                                - Publicado em:
                                <?php echo $jogo["ano"] ?>
                            </span>
                            <span>
                                <?php echo $jogo["sistema"] ?>
                            </span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>
</body>

</html>