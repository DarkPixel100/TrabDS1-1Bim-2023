<?php
session_start();
$conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");

if (isset($_POST["relatorio"])) {
    if ($_POST["relatorio"] == "mine") {
        $sqlquery = "SELECT userID, gameID, titulo, sistema, ano, empresa, imgpath FROM cartuchos JOIN users WHERE userID = ? AND users.id = userID;";
        $stmt = mysqli_prepare($conexao, $sqlquery);
        $stmt->bind_param("i", $_SESSION["userID"]);
    } else if ($_POST["relatorio"] == "all") {
        $sqlquery = "SELECT gameID, userID, username, titulo, sistema, ano, empresa, imgpath FROM cartuchos JOIN users WHERE users.id = userID;";
        $stmt = mysqli_prepare($conexao, $sqlquery);
    } else {
        $sqlquery = "SELECT * FROM historicoderemocao;";
        $stmt = mysqli_prepare($conexao, $sqlquery);
    }
}
$stmt->execute();
$resultado = $stmt->get_result();
$resultarray = array();
while ($data = $resultado->fetch_assoc()) {
    array_push($resultarray, $data);
}

$html = "<link rel='stylesheet' href='tabela.css'>
        <table>
        <tr>";
if (isset($resultarray[0])) {
    foreach ($resultarray[0] as $header => $value) {
        if ($header == "imgpath") $header = "imagem";
        $html = $html . "<th>$header</th>";
    }
} else $html = $html . "<th>Sem registros</th>";
$html = $html . "</tr>";

foreach ($resultarray as $jogo) {
    $html = $html . "<tr>";
    foreach ($jogo as $key => $dado) {
        if ($key == "imgpath") $html = $html . "<td><img src='$dado'></td>";
        else $html = $html . "<td>$dado</td>";
    }
    $html = $html . "</tr>";
}
$html = $html . "</table>";

$filename = "newpdffile";
// include autoloader
require_once './libs/dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->setChroot('');

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream($filename, array("Attachment" => 0));
// echo $html;
