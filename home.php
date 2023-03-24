<?php
// Início da sessão
session_start();
$_SESSION["userID"] = 1; ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca de jooj</title>
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./general.css">
    <link rel="stylesheet" href="./home.css">
    <script src="tiles.js" defer></script>
</head>

<body class="oceanic">
    <header>
        <h1>Cadastro de Cartuchos</h1>
    </header>
    <main>
        <!-- Form de cadastro -->
        <form class="infoBox" action="./cadastrando.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <label for="titulo">Título do jogo:</label>
            <input type="text" name="titulo" required>
            <label for="empresa">Noma da Empresa:</label>
            <input type="text" name="empresa" required>
            <label for="sistema">Sistema:</label>
            <input type="text" name="sistema" required>
            <label for="ano">Ano de lançamento:</label>
            <input type="number" name="ano" inputmode="numeric" pattern="[0-9]+" min="1901" max="2155" required>
            <label for=" fotocartucho">Foto do cartucho:</label>
            <input type="file" name="fotocartucho" accept="image/png, image/jpg, image/jpeg" required>
            <input type="submit" name="submit" value="Cadastrar">
        </form>
        <div class="infoBox" id="gameList">
            <?php
            // Fazendo a query no banco, buscando todos os cartuchos do usuário logado
            $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");
            $sqlquery = "SELECT Cartuchos.gameID, Cartuchos.titulo, Cartuchos.sistema, Cartuchos.ano, Cartuchos.empresa, Cartuchos.imgpath FROM Cartuchos JOIN Users WHERE Cartuchos.userID = ?;";
            $resultado = $conexao->execute_query($sqlquery, [1]);

            // Inserindo os resultados da query em um array, para gerar a lista
            $resultarray = array();
            while ($data = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                array_push($resultarray, $data);
            }

            // Construindo a lista dinamicamente
            if (sizeof($resultarray) == 0) : ?>
                <p>Nenhum cartucho cadastrado.</p>
            <?php else : ?>
                <form action="./removendo.php" method="POST">
                    <?php foreach ($resultarray as $jogo) : ?>
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
                                    Sistema: <?php echo $jogo["sistema"] ?>
                                </span>
                                <span>
                                    <button type="submit" name="removeID" value="<?php echo $jogo["gameID"]; ?>">Remover</button>
                                </span>
                            </div>
                        </li>
                <?php endforeach;
                endif;
                exit; ?>
                </form>
        </div>
    </main>
</body>

</html>