<?php
$conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");
$sqlquery = "SELECT * FROM users WHERE id = ?;";
$stmt = mysqli_prepare($conexao, $sqlquery);
$stmt->bind_param("i", $_SESSION["userID"]);
$stmt->execute();
$resultado = $stmt->get_result();
$resultarray = array();
while ($data = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
    array_push($resultarray, $data);
}

$html = "  
        <table border='1' width='100%' style='border-collapse: collapse;'>
        <tr>
            <th>UserID</th>
            <th>Username</th>
            <th>GameID</th>
            <th>Título</th>
            <th>Sistema</th>
            <th>Ano</th>
            <th>Empresa</th>
            <th>Img</th>
        </tr>
        <?php foreach ($resultarray as $jogo): ?>
        <tr>
            <td><?php echo $jogo[userID]; ?></td>
            <td><?php echo $jogo[username]; ?></td>
            <td><?php echo $jogo[gameID]; ?></td>
            <td><?php echo $jogo[titulo]; ?></td>
            <td><?php echo $jogo[sistema]; ?></td>
            <td><?php echo $jogo[ano]; ?></td>
            <td><?php echo $jogo[empresa]; ?></td>
            <td><img src=<?php echo $jogo[imgpath]; ?>></td>
        </tr>
        <?php endforeach; ?>
        </table>";
$filename = "newpdffile";
// include autoloader
require_once './libs/dompdf/autoload.inc.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream($filename, array("Attachment" => 0));
?>