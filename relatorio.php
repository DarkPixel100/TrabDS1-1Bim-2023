<?php
@include './gera_relatorio.php';
@include './gera_resumo.php';

session_start();
$conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");
$reltype = 'geral';

// Inicializando o módulo
require_once('libs/tcpdf/examples/tcpdf_include.php');

$pdf = new TCPDF('L');

if (isset($_POST["relatorio"])) {
    switch ($_POST["relatorio"]) {
        case 'mine':
            $sqlquery = "SELECT userID, gameID, titulo, sistema, ano, empresa, imgpath FROM cartuchos JOIN users WHERE userID = ? AND users.id = userID;";
            $stmt = mysqli_prepare($conexao, $sqlquery);
            $stmt->bind_param("i", $_SESSION["userID"]);
            break;

        case 'all':
            $sqlquery = "SELECT gameID, userID, username, titulo, sistema, ano, empresa, imgpath FROM cartuchos JOIN users WHERE users.id = userID;";
            $stmt = mysqli_prepare($conexao, $sqlquery);
            break;

        case 'removed':
            $sqlquery = "SELECT * FROM historicoderemocao ORDER BY dataremocao;";
            $stmt = mysqli_prepare($conexao, $sqlquery);
            break;

        case 'summary':
            $sqlquery = "SELECT username, titulo, imgpath FROM cartuchos JOIN users WHERE users.id = userID;";
            $stmt = mysqli_prepare($conexao, $sqlquery);
            $reltype = 'resumo';
            $pdf = new TCPDF('P');
            break;
    }
}
$stmt->execute();
$resultado = $stmt->get_result();
$resultarray = array();
while ($data = $resultado->fetch_assoc()) {
    array_push($resultarray, $data);
}

$html = gera($reltype, $resultarray);

// Criando o pdf
$pdf->AddPage();

$pdf->writeHTML($html);

$pdf->Output('relatorio.pdf');
