<?php
require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

class PDF extends FPDF
{
    public $angle = 0;

    function Rotate($angle, $x=-1, $y=-1)
    {
        if ($x == -1) $x = $this->x;
        if ($y == -1) $y = $this->y;
        if ($this->angle != 0) $this->_out('Q');
        $this->angle = $angle;

        if ($angle != 0) {
            $angle = $angle * M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf(
                'q %.5F %.5F %.5F %.5F %.5F %.5F cm',
                $c, $s, -$s, $c,
                $cx - $c*$cx + $s*$cy,
                $cy - $s*$cx - $c*$cy
            ));
        }
    }

    function _endpage()
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    function Watermark()
    {
        $this->SetFont('Arial','B',40);
        $this->SetTextColor(230,230,230);
        $this->Rotate(30, 80, 200);
        $this->Text(35, 210, "CADECO");
        $this->Rotate(0);
    }

    function Header()
    {
        $this->Watermark();

        if ($this->PageNo() == 1) {
            $this->SetFillColor(30, 60, 120);
            $this->Rect(0, 0, 210, 25, "F");
            $this->Image('img/Logo CADECO1.jpg', 10, 4, 18);

            $this->SetFont('Arial','B',14);
            $this->SetTextColor(255,255,255);
            $this->SetXY(30, 5);
            $this->Cell(150, 6, "CAISSE GENERALE D'EPARGNE DU CONGO", 0, 1, 'C');
            $this->Cell(190, 5, "C A D E C O", 0, 1, 'C');

            $this->SetFont('Arial','',10);
            $this->Cell(190, 4, iconv('UTF-8','ISO-8859-1','Société Anonyme Unipersonnelle'), 0, 1, 'C');
            $this->Line(10, 28, 200, 28);
            $this->Ln(12);
        }
    }

    function Footer()
    {
        $this->SetY(-12);
        $this->SetFont('Arial','I',9);
        $this->Cell(0, 10, "Page ".$this->PageNo()."/{nb}", 0, 0, 'R');
    }

    // =============================
    //        TABLEAU PRO
    // =============================
    function TablePro($header, $data)
    {
        $widths = [12, 30, 45, 30, 23, 25]; // 6 colonnes
        $startX = (210 - array_sum($widths)) / 2;

        // Header
        $this->SetFont('Arial','B',9);
        $this->SetFillColor(230,240,255);
        $this->SetX($startX);

        foreach ($header as $i => $col) {
            $this->Cell($widths[$i], 8, iconv('UTF-8','ISO-8859-1//TRANSLIT', $col), 1, 0, 'C', true);
        }
        $this->Ln();

        // Données
        $this->SetFont('Arial','',9);
        $numero = 1;

        foreach ($data as $row) {
            $this->SetX($startX);
            $this->Cell($widths[0], 7, $numero, 1, 0, 'C');
            $this->Cell($widths[1], 7, iconv('UTF-8','ISO-8859-1//TRANSLIT', $row[0]), 1,0,'C');//$row[0], 1);
            $this->Cell($widths[2], 7, iconv('UTF-8','ISO-8859-1//TRANSLIT', $row[1]), 1);
            $this->Cell($widths[3], 7, iconv('UTF-8','ISO-8859-1//TRANSLIT', $row[2]), 1,0,'R');
            //$this->Cell($widths[3], 7, $row[2], 1, 0, 'R');
            $this->Cell($widths[4], 7, $row[3], 1, 0, 'C');
            $this->Cell($widths[5], 7, iconv('UTF-8','ISO-8859-1//TRANSLIT', $row[4]), 1,0,'C');
            //$this->Cell($widths[5], 7, $row[4], 1, 0, 'C');
            $this->Ln();
            $numero++;
        }
    }
}

// =============================
//       GENERATION
// =============================
$pdf = new PDF('P','mm','A4','UTF-8');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',13);
$pdf->Cell(0,10,"LISTE DE BAREME/GRADE DU ".iconv('UTF-8','ISO-8859-1//TRANSLIT', date('d-m-Y')),0,1,'C');
$pdf->Ln(4);

// Données SQL
$data = [];

$sql = "SELECT * FROM bdd_paie.t_bareme INNER JOIN bdd_paie.detail_grade_bareme on t_bareme.id_bar=detail_grade_bareme.id_bar INNER JOIN bdd_paie.t_grade ON t_grade.code_grade=detail_grade_bareme.code_grade";

$req = $db->query($sql);

while ($r = $req->fetch()) {
    $data[] = [
        $r['code_grade'],
        $r['LibelleBar'],
        number_format((float) ($r['Montant_bar'] ?? 0), 2, ',', ' '),
        $r['code_devise'],
        ($r['statut_ID']=='act') ? 'Actif' : 'Inactif'
    ];
}

$pdf->TablePro(
    ['N°','Code grade','Libellé','Montant','Devise','Statut'],
    $data
);

$pdf->Ln(6);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,7,"Total : ".count($data)." Bareme/Grade",0,1,'R');

$pdf->Output();
?>