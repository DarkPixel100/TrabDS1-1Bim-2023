<?php
@include './gera_relatorio.php';
@include './gera_resumo.php';

session_start();

if (!isset($_SESSION["userID"])) {
    header("Location: login.php?msg=OK");
}

$conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");
$reltype = 'geral';
$sqlquery = "SELECT * FROM users WHERE id = ?;";
$stmt = mysqli_prepare($conexao, $sqlquery);
$stmt->bind_param("i", $_SESSION["userID"]);
$stmt->execute();
$resultado = $stmt->get_result();
$admin = mysqli_fetch_assoc($resultado)["admin"];

// Inicializando o módulo
require_once('libs/tcpdf/examples/tcpdf_include.php');

$pdf = new TCPDF('L');

$verify = false;

if (isset($_POST["relatorio"])) {
    if ($_POST["relatorio"] == 'mine') {
        $sqlquery = "SELECT userID, gameID, titulo, sistemas.nome, cartuchos.ano, empresa, imgpath FROM cartuchos JOIN users ON userID = users.id AND userID = ? LEFT JOIN sistemas ON cartuchos.sistema = sistemas.id;";
        $stmt = mysqli_prepare($conexao, $sqlquery);
        $stmt->bind_param("i", $_SESSION["userID"]);
        $verify = true;
    } else if ($admin) {
        switch ($_POST["relatorio"]) {

            case 'all':
                $sqlquery = "SELECT gameID, userID, username, titulo, sistemas.nome, cartuchos.ano, empresa, imgpath FROM cartuchos JOIN users ON users.id = userID LEFT JOIN sistemas ON cartuchos.sistema = sistemas.id;";
                $stmt = mysqli_prepare($conexao, $sqlquery);
                $verify = true;
                break;

            case 'removed':
                $sqlquery = "SELECT * FROM historicoderemocao ORDER BY dataremocao DESC;";
                $stmt = mysqli_prepare($conexao, $sqlquery);
                $verify = true;
                break;

            case 'summary':
                $sqlquery = "SELECT username, titulo, imgpath FROM cartuchos JOIN users WHERE users.id = userID";
                $stmt = mysqli_prepare($conexao, $sqlquery);
                $reltype = 'resumo';
                $pdf = new TCPDF('P');
                $verify = true;
                break;
        }
    }
}
if ($verify) {
    $stmt->execute();
    $resultado = $stmt->get_result();
    $resultarray = array();
    while ($data = $resultado->fetch_assoc()) {
        array_push($resultarray, $data);
    }

    $pageHeight = $pdf->getPageHeight();
    $pageWidth = $pdf->getPageWidth();

    $html = gera($reltype, $resultarray, (($pageHeight - 90) / 5), ($pageWidth / 3));

    // Criando o pdf
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->AddPage();

    $pdf->writeHTML($html);

    $pdf->Output('relatorio.pdf');
} else {
    echo "Você não têm acesso a esse request";
}