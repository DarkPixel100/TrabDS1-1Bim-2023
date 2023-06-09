<?php
// Início da sessão
session_start();

// Verificando o logout
if (isset($_POST["submit"]) && $_POST["submit"] == "Logout") {
    session_unset();
    session_destroy();
}

// Verificando se está logado
if (!isset($_SESSION["userID"])) {
    header("Location: login.php?msg=OK");
}

// Fazendo a query no banco, buscando todos os cartuchos do usuário logado
$conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");
$sqlquery = "SELECT * FROM users WHERE id = ?;";
$stmt = mysqli_prepare($conexao, $sqlquery);
$stmt->bind_param("i", $_SESSION["userID"]);
$stmt->execute();
$resultado = $stmt->get_result();
$admin = mysqli_fetch_assoc($resultado)["admin"];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de cartuchos</title>
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./general.css">
    <link rel="stylesheet" href="./home-systems.css">

    <script src="tiles.js" defer></script>
    <script src="popup.js" defer></script>

    <script src="https://kit.fontawesome.com/cb01a77c08.js" crossorigin="anonymous"></script>
</head>



<body class="oceanic">
    <header>
        <form id="logout" action="" method="post" autocomplete="off">
            <button title="Logout" name="submit" value="Logout">
                <span class="fa fa-right-from-bracket"></span>
            </button>
        </form>

        <h1>Cadastro de cartuchos</h1>

        <?php
        // Barra de pesquisa (só disponível para admins)
        if ($admin) : ?>
            <form id="top-buttons" action="" method="POST" autocomplete="off">
                <span id="search">
                    <input id="searchBar" type="search" name="pesquisa" placeholder="Pesquisar cartuchos...">
                    <button id="search-btn" type="submit" name="submit" value="search">
                        <span class="fa fa-search"></span>
                    </button>
                </span>
                <button type="submit" name="submit" value="showMine">Mostrar meus cartuchos</button>
                <button type="submit" name="submit" value="showAll">Mostrar todos os cartuchos</button>
                <button class="tables" type="button">Tabelas</button>
                <a href="sistemas.php">
                    <p>Sistemas</p>
                </a>
            </form>
        <?php else : ?>
            <form id="top-buttons" action="relatorio.php" method="POST">
                <button type="submit" name="relatorio" value="mine">Mostrar meus cartuchos</button>
            </form>
        <?php endif; ?>
    </header>
    <main>
        <!-- Form de cadastro -->
        <form class="infoBox" action="./insere_cartucho.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <label for="titulo">Título do jogo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="The Legend of Zelda: Ocarina of Time" required>

            <label for="empresa">Nome da Empresa:</label>
            <input type="text" id="empresa" name="empresa" placeholder="Nintendo" required>

            <label for="sistema">Sistema:</label>
            <select id="sistema" name="sistema" <?php if (!$admin) : ?> required <?php endif; ?>>
                <?php
                $sqlquery = "SELECT id, nome FROM sistemas ORDER BY nome ASC;";
                $stmt = mysqli_prepare($conexao, $sqlquery);
                $stmt->execute();
                $resultado = $stmt->get_result();
                $resultarray = array();
                while ($data = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                    array_push($resultarray, $data);
                }
                foreach ($resultarray as $sistema) : ?>
                    <option value="<?php echo $sistema["id"]; ?>"><?php echo $sistema["nome"]; ?></option>
                <?php endforeach; ?>
            </select>


            <label for="ano">Ano de lançamento:</label>
            <input type="number" id="ano" name="ano" inputmode="numeric" step="1" min="1910" max="<?php echo (int) date("Y") ?>" placeholder="1910-<?php echo (int) date("Y") ?>" required>

            <label for="fotocartucho">Foto do cartucho:</label>
            <input type="file" id="fotocartucho" name="fotocartucho" accept="image/png, image/jpg, image/jpeg" required>

            <input type="submit" name="submit" value="Cadastrar" required>
        </form>

        <div class="infoBox" id="itemList">
            <?php
            // Fazendo a query no banco, buscando todos os cartuchos do usuário logados
            $sqlquery = "SELECT users.id, username, gameID, titulo, sistemas.nome, cartuchos.ano, empresa, imgpath FROM cartuchos JOIN users ON userID = users.id LEFT JOIN sistemas ON cartuchos.sistema = sistemas.id";

            // Completando a query dependendo do input da barra de pesquisa
            if ($admin && isset($_POST["submit"]) && !empty($_POST["submit"]) && $_POST["submit"] != "showMine") {
                /* Mostrar os cartuchos de acordo com a pesquisa, podendo incluir a id ou username do
                usuário que cadastrou o cartucho, titulo, sistema, ano de publicação ou empresa */
                if ($_POST["submit"] == "search") {
                    $sqlquery = $sqlquery .
                        " AND (LOWER(username) LIKE CONCAT ('%', LOWER(?), '%')
                    OR users.id = ? 
                    OR gameID = ? 
                    OR LOWER(titulo) LIKE CONCAT ('%', LOWER(?), '%') 
                    OR LOWER(sistemas.nome) LIKE CONCAT ('%', LOWER(?), '%') 
                    OR cartuchos.ano = ? 
                    OR LOWER(empresa) LIKE CONCAT ('%', LOWER(?), '%')) 
                    GROUP BY gameID 
                    ORDER BY cartuchos.ano;";
                    $stmt = mysqli_prepare($conexao, $sqlquery);
                    $stmt->bind_param("siissis", $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"]);
                } else if ($_POST["submit"] == "showAll") {
                    // Mostrar todos os cartuchos cadastrados
                    $sqlquery .= " GROUP BY gameID ORDER BY cartuchos.ano;";
                    $stmt = mysqli_prepare($conexao, $sqlquery);
                }
            } else {
                // Mostrar os próprios cartuchos cadastrados
                $sqlquery .= " WHERE userID = ? GROUP BY gameID ORDER BY cartuchos.ano;";
                $stmt = mysqli_prepare($conexao, $sqlquery);
                $stmt->bind_param("i", $_SESSION["userID"]);
            }
            $stmt->execute();
            $resultado = $stmt->get_result();
            // Inserindo os resultados da query em um array, para gerar a lista
            $resultarray = array();
            while ($data = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                array_push($resultarray, $data);
            }


            // Construindo a lista dinamicamente
            if (sizeof($resultarray) == 0) : ?>
                <p>Nenhum cartucho cadastrado.</p>

            <?php else : ?>
                <?php if (sizeof($resultarray) == 1) : ?>
                    <p id="results">1 cartucho.</p>
                <?php else : ?>
                    <p id="results">
                        <?php echo sizeof($resultarray); ?> cartuchos. Ordenados por data
                    </p>
                <?php endif; ?>

                <form action="./removendo.php" method="POST" autocomplete="off">

                    <!-- Add os jogos resultantes da query -->
                    <?php foreach ($resultarray as $jogo) : ?>
                        <li class="item cartucho" id="<?php echo $jogo["gameID"]; ?>">
                            <span class="gameID">ID:
                                <?php echo $jogo["gameID"]; ?>
                            </span>

                            <div class="imgBox">
                                <img src="<?php echo $jogo["imgpath"]; ?>">
                            </div>

                            <div class="itemInfo">
                                <h3 class="gameTitle">
                                    <?php echo $jogo["titulo"]; ?>
                                </h3>

                                <span>
                                    Por:
                                    <?php echo $jogo["empresa"]; ?>
                                </span>

                                <span>
                                    Publicado em:
                                    <?php echo $jogo["ano"]; ?>
                                </span>

                                <span>
                                    Sistema:
                                    <?php
                                    if ($jogo["nome"])
                                        echo $jogo["nome"];
                                    else
                                        echo "SEM SISTEMA";
                                    ?>
                                </span>

                                <?php if ($admin) : ?>
                                    <span>Usuário: <b>
                                            <?php echo $jogo["username"] . ' - UserID: ' . $jogo["id"]; ?>
                                        </b>
                                    </span>
                                <?php endif; ?>
                                <!-- Botões de edição e remoção -->
                                <span class="buttons">
                                    <button type="button" class="remove-btn" value="<?php echo $jogo["gameID"]; ?>">
                                        <span class="fa fa-trash"></span>
                                    </button>
                                    <button type="button" class="edit-btn" value="<?php echo $jogo["gameID"]; ?>">
                                        <span class="fa fa-pencil"></span>
                                    </button>
                                </span>
                            </div>
                        </li>
                <?php endforeach;
                endif; ?>
                </form>
        </div>
    </main>
</body>

</html>