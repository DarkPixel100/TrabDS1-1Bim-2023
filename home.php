<?php
// Início da sessão
session_start();
if (!isset($_SESSION["userID"])) {
    header("Location: ./login.php");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cartuchos</title>
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" href="./general.css">
    <link rel="stylesheet" href="./home.css">

    <script src="tiles.js" defer></script>

    <script src="https://kit.fontawesome.com/cb01a77c08.js" crossorigin="anonymous"></script>
</head>



<body class="oceanic">
    <header>

        <?php
        if (isset($_POST["logout"])) {
            session_unset();
            session_destroy();
        }
        ?>

        <form action="" method="post" autocomplete="off">
            <input type="submit" name="logout" value="logout">
        </form>

        <h1>Cadastro de Cartuchos</h1>

        <?php
        // Fazendo a query no banco, buscando todos os cartuchos do usuário logado
        $conexao = mysqli_connect("localhost", "root", "", "DS1-ListaJogos-Diego-Sofia");
        $sqlquery = "SELECT * FROM Users WHERE id = ?;";
        $stmt = mysqli_prepare($conexao, $sqlquery);
        $stmt->bind_param("i", $_SESSION["userID"]);
        $stmt->execute();
        $resultado = $stmt->get_result();
        var_dump($resultado);
        $admin = mysqli_fetch_array($resultado, MYSQLI_ASSOC)["admin"];


        // Barra de pesquisa (só disponível para admins)
        if ($admin): ?>
            <form id="search-viewer" action="" method="post" autocomplete="off">
                <span id="search">
                    <input id="searchBar" type="search" name="pesquisa" placeholder="Pesquisar cartuchos...">
                    <!--
             --><button id="search-btn" type="submit" name="submit" value="search">
                        <span class="fa fa-search"></span>
                    </button>
                </span>
                <button type="submit" name="submit" value="showMine">Mostrar meus cartuchos</button>
                <button type="submit" name="submit" value="showAll">Mostrar todos os cartuchos</button>
            </form>
        <?php endif; ?>
    </header>
    <main>
        <!-- Form de cadastro -->
        <form class="infoBox" action="./inserecartucho.php" method="POST" enctype="multipart/form-data"
            autocomplete="off">
            <label for="titulo">Título do jogo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="The Legend of Zelda: Ocarina of Time" required>

            <label for="empresa">Nome da Empresa:</label>
            <input type="text" id="empresa" name="empresa" placeholder="Nintendo" required>

            <label for="sistema">Sistema:</label>
            <input type="text" id="sistema" name="sistema" placeholder="Nintendo 64" required>

            <label for="ano">Ano de lançamento:</label>
            <input type="number" id="ano" name="ano" inputmode="numeric" min="1910" max="<?php echo (int) date("Y") ?>"
                placeholder="1910-<?php echo (int) date("Y") ?>" required>

            <label for="fotocartucho">Foto do cartucho:</label>
            <input type="file" id="fotocartucho" name="fotocartucho" accept="image/png, image/jpg, image/jpeg" required>

            <input type="submit" name="submit" value="Cadastrar" required>
        </form>

        <div class="infoBox" id="gameList">
            <?php
            // Fazendo a query no banco, buscando todos os cartuchos do usuário logado
            $conexao = mysqli_connect("localhost", "root", "", "DS1-ListaJogos-Diego-Sofia");

            $sqlquery = "SELECT gameID, titulo, sistema, ano, empresa, imgpath FROM Cartuchos";

            // Completando a query dependendo do input da barra de pesquisa
            if ($admin && isset($_POST["submit"]) && !empty($_POST["submit"]) && $_POST["submit"] != "showMine") {
                if ($_POST["submit"] == "search") {
                    $sqlquery = $sqlquery .
                        " WHERE gameID = ? 
                    OR userID = ? 
                    OR titulo LIKE CONCAT ('%', ?) 
                    OR titulo LIKE CONCAT (?, '%') 
                    OR titulo LIKE CONCAT ('%', ?, '%') 
                    OR sistema LIKE CONCAT ('%', ?) 
                    OR sistema LIKE CONCAT (?, '%') 
                    OR sistema LIKE CONCAT ('%', ?, '%') 
                    OR ano = ? 
                    OR empresa LIKE CONCAT ('%', ?) 
                    OR empresa LIKE CONCAT (?, '%') 
                    OR empresa LIKE CONCAT ('%', ?, '%') 
                    ORDER BY titulo;";
                    $stmt = mysqli_prepare($conexao, $sqlquery);
                    $stmt->bind_param("iissssssisss", $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"], $_POST["pesquisa"]);
                } else if ($_POST["submit"] == "showAll") {
                    $sqlquery = $sqlquery . " ORDER BY userID;";
                    $stmt = mysqli_prepare($conexao, $sqlquery);
                }
            } else {
                $sqlquery = $sqlquery . " WHERE userID = ? ORDER BY titulo;";
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
            if (sizeof($resultarray) == 0): ?>
                <p>Nenhum cartucho cadastrado.</p>

            <?php else: ?>
                <form action="./removendo.php" method="POST" autocomplete="off">
                    <?php foreach ($resultarray as $jogo): ?>
                        <li class="jogo" id="<?php echo $jogo["gameID"]; ?>">
                            <div class="imgBox">
                                <img src="<?php echo $jogo["imgpath"]; ?>">
                            </div>
                            <div class="gameInfo">
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
                                    <?php echo $jogo["sistema"]; ?>
                                </span>
                                <button type="submit" class="remove-btn" name="removeID" value="<?php echo $jogo["gameID"]; ?>">
                                    <span class="fa fa-trash"></span>
                                </button>
                            </div>
                        </li>
                    <?php endforeach;

            endif;
            ?>
            </form>
        </div>
    </main>
</body>

</html>