<?php
require('./libs/fpdf185/fpdf.php');



class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 10, iconv('UTF-8', 'iso-8859-1', 'Lista de Cartuchos'), 0, 0, 'C');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function ImprovedTable($header, $data)
    {
        // Table Column widths
        $w = array(18, 35, 20, 30, 30, 15, 25, 20);

        // Table Header
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, iconv('UTF-8', 'iso-8859-1', $header[$i]), 1, 0, 'C');
        $this->Ln();

        // Table Data
        foreach ($data as $row) {
            $this->Cell($w[0], $w[7], $row[0], 'LR', 0, 'C');
            $this->Cell($w[1], $w[7], $row[1], 'LR', 0, 'C');
            $this->Cell($w[2], $w[7], $row[2], 'LR', 0, 'C');
            $this->Cell($w[3], $w[7], $row[3], 'LR', 0, 'C');
            $this->Cell($w[4], $w[7], $row[4], 'LR', 0, 'C');
            $this->Cell($w[5], $w[7], $row[5], 'LR', 0, 'C');
            $this->Cell($w[6], $w[7], $row[6], 'LR', 0, 'C');
            $this->Image($row[7], null, null, $w[7], $w[7]);
            $this->Ln(0);
            $this->Cell(array_sum($w), 0, '', 1);
            $this->Ln();
        }
        // Closing line
    }
}

// Column headings
$header = array('UserID', 'Username', 'GameID', 'Título', 'Sistema', 'Ano', 'Empresa', 'Imagem');

// Data loading
$conexao = mysqli_connect("localhost", "root", "mysqluser", "DS1-ListaJogos-Diego-Sofia");
$sqlquery = "SELECT id, username, gameID, titulo, sistema, ano, empresa, imgpath FROM cartuchos JOIN users";
$stmt = mysqli_prepare($conexao, $sqlquery);
$stmt->execute();
$resultado = $stmt->get_result();
$resultarray = array();
while ($dados = mysqli_fetch_array($resultado, MYSQLI_NUM)) {
    array_push($resultarray, $dados);
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 12);
$pdf->AddPage();
$pdf->ImprovedTable($header, $resultarray);
$pdf->Output();
