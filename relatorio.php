<?php
require_once('libs/tcpdf/examples/tcpdf_include.php');

$pdf = new TCPDF('L');

$pdf->AddPage();

$pdf->writeHTML($html);

session_start();
$conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");

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
        
        case 'summary':
            $sqlquery = "SELECT titulo, username, imgpath FROM cartuchos JOIN users WHERE users.id = userID;";
            $stmt = mysqli_prepare($conexao, $sqlquery);
            break;
        
        case 'removed':
            $sqlquery = "SELECT * FROM historicoderemocao ORDER BY dataremocao;";
            $stmt = mysqli_prepare($conexao, $sqlquery);
            break;
    }
}
$stmt->execute();
$resultado = $stmt->get_result();
$resultarray = array();
while ($data = $resultado->fetch_assoc()) {
    array_push($resultarray, $data);
}

$html = <<<HTML
<style>
    table {
        width: 100%;
    }
    th, td {
        text-align: center;
        border: 1 solid black;
    }
    img {
        width: 80vw;
    }
</style>

<table cellpadding="2">
    <tr>
HTML;

if (isset($resultarray[0])) {
    foreach ($resultarray[0] as $header => $path) {
        if ($header == "imgpath")
            $header = "imagem";

        $html = <<<HTML
        $html<th><b>$header</b></th>
        HTML;
    }
} else {
    $html = <<<HTML
    $html<th>Sem registros</th>
    HTML;
}

$html = <<<HTML
    $html</tr>
    HTML;

foreach ($resultarray as $jogo) {
    $html = <<<HTML
    $html<tr>
    HTML;

    foreach ($jogo as $key => $dado) {
        if ($key == "imgpath") {
            $html = <<<HTML
            $html<td><img src="$dado"></td>
            HTML;
        } else {
            $html = <<<HTML
            $html<td>$dado</td>
            HTML;
        }
    }
    $html = <<<HTML
    $html</tr>
    HTML;
}
$html = <<<HTML
$html</table>
HTML;

$pdf->writeHTML($html);

$pdf->Output('relatorio.pdf');