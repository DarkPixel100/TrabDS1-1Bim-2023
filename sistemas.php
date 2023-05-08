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
$admin = mysqli_fetch_assoc($resultado)["admin"]; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<?php if ($admin) : ?>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastro de Sistemas</title>
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

            <h1>Cadastro de Sistemas</h1>

            <div id="top-buttons">
                <a href="home.php">Cartuchos</a>
            </div>
        </header>
        <main>
            <!-- Form de cadastro -->
            <form class="infoBox" action="insere_sistema.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <label for="nome">Nome do sistema:</label>
                <input type="text" id="nome" name="nome" placeholder="Nintendo Switch" required>

                <label for="fabricante">Nome da Fabricante:</label>
                <input type="text" id="fabricante" name="fabricante" placeholder="Nintendo" required>

                <label for="ano">Ano de lançamento:</label>
                <input type="number" id="ano" name="ano" inputmode="numeric" step="1" min="1910" max="<?php echo (int) date("Y") ?>" placeholder="1910-<?php echo (int) date("Y") ?>" required>

                <input type="submit" name="submit" value="Cadastrar" required>
            </form>

            <div class="infoBox" id="itemList">
                <?php
                // Fazendo a query no banco, buscando todos os sistemas
                $sqlquery = "SELECT sistemas.*, count(gameID) AS jogos FROM sistemas LEFT JOIN cartuchos ON id = cartuchos.sistema GROUP BY sistemas.id;";

                $stmt = mysqli_prepare($conexao, $sqlquery);
                $stmt->execute();
                $resultado = $stmt->get_result();

                // Inserindo os resultados da query em um array, para gerar a lista
                $resultarray = array();
                while ($data = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                    array_push($resultarray, $data);
                }

                // Construindo a lista dinamicamente
                if (sizeof($resultarray) == 0) : ?>
                    <p>Nenhum sistema cadastrado.</p>

                <?php else : ?>
                    <?php if (sizeof($resultarray) == 1) : ?>
                        <p id="results">1 sistema.</p>
                    <?php else : ?>
                        <p id="results">
                            <?php echo sizeof($resultarray); ?> sistemas
                        </p>
                    <?php endif; ?>

                    <form action="./removendo_sistema.php" method="POST" autocomplete="off">
                        <?php foreach ($resultarray as $sistemas) : ?>
                            <li class="item sistema" id="<?php echo $sistemas["id"]; ?>">

                                <div class="itemInfo">
                                    <h3 class="systemName">
                                        Sistema:
                                        <?php echo $sistemas["nome"]; ?>
                                    </h3>
                                    <span>
                                        ID:
                                        <?php echo $sistemas["id"]; ?>
                                    </span>
                                    <span>
                                        Fabricante:
                                        <?php echo $sistemas["fabricante"]; ?>
                                    </span>

                                    <span>
                                        Lançado em:
                                        <?php echo $sistemas["ano"]; ?>
                                    </span>
                                    <span>
                                        Jogos cadastrados: <?php echo $sistemas["jogos"]; ?>
                                    </span>
                                    <!-- Botões de edição e remoção -->
                                    <span class="buttons">
                                        <button type="button" class="remove-btn" value="<?php echo $sistemas["id"]; ?>">
                                            <span class="fa fa-trash"></span>
                                        </button>
                                        <button type="button" class="edit-btn" value="<?php echo $sistemas["id"]; ?>">
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
<?php else : echo "Você não têm acesso a essa página";
endif; ?>

</html>