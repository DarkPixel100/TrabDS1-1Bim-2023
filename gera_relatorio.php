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
        $w = array(18, 35, 20, 30, 30, 15, 25, 10);

        // Table Header
        for ($i = 0; $i < count($header); $i++)
            $this->Cell($w[$i], 7, iconv('UTF-8', 'iso-8859-1', $header[$i]), 1, 0, 'C');
        $this->Ln();

        // Table Data
        $start_x = $this->GetX();
        $current_y = $this->GetY();
        $current_x = $this->GetX();
        foreach ($data as $row) {
            for ($i = 0; $i < sizeof($row) - 1; $i++) {
                $this->MultiCell($w[$i], 10, $row[$i], 1, 'C');
                $current_x += $w[$i];
                $this->SetXY($current_x, $current_y);
            }
            $this->Image($row[7], null, null, 0, 10);
            $this->Cell(0, 10,'', 0, 1);
            $this->Ln();
            $current_x = $start_x;
            $current_y = $this->GetY();
        }
    }
}

// Column headings
$header = array('UserID', 'Username', 'GameID', 'Título', 'Sistema', 'Ano', 'Empresa', 'Img');

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
$pdf->SetFont('Arial', '', 8);
$pdf->AddPage();
$pdf->ImprovedTable($header, $resultarray);
$pdf->Output();
