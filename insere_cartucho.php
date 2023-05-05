<?php
session_start();

if (isset($_POST["submit"])) {
    $imageFileType = strtolower(pathinfo($_FILES["fotocartucho"]["name"], PATHINFO_EXTENSION)); // Verificando o tipo de arquivo
    $target_dir = "uploads/img/"; // Diretório de envio dos arquivos de imagem
    $target_file = $target_dir . "cartuchoUSER" . $_SESSION["userID"] . "_" . date("d-m-y_h-i-s") . ".jpg"; // Nomeando os arquivos
    move_uploaded_file($_FILES["fotocartucho"]["tmp_name"], $target_file); // Salvando arquivo

    // Inserindo o cartucho cadastrado no banco
    $conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");

    $sqlquery = "INSERT INTO cartuchos (userID, titulo, sistema, ano, empresa, imgpath) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_prepare($conexao, $sqlquery);
    $stmt->bind_param("ississ", 
    $_SESSION["userID"], 
    $_POST["titulo"], 
    $_POST["sistema"], 
    $_POST["ano"], 
    $_POST["empresa"], 
    $target_file);

    $stmt->execute();
    $resultado = $stmt->get_result();

    // Retornando à página anterior
    header("Location: ./home.php");
}
?>