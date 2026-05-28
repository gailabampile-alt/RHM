
<?php
include('sys_connexion.php');
require('fpdf.php');

$periode = $_GET['periode'] ?? '';
if ($periode == '') die('Période non définie');

/* ================= CLASS PDF ================= */
class PDF extends FPDF
{
    public $angle = 0;

    // ---- ROTATION ----
    function Rotate($angle, $x=-1, $y=-1)
    {
        if($x==-1) $x = $this->x;
        if($y==-1) $y = $this->y;
        if($this->angle != 0)
            $this->_out('Q');

        $this->angle = $angle;

        if($angle != 0)
        {
            $angle = $angle * M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);

            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;

            $this->_out(
                sprintf(
                    'q %.5F %.5F %.5F %.5F %.5F %.5F cm',
                    $c, $s, -$s, $c,
                    $cx - $c*$cx + $s*$cy,
                    $cy - $s*$cx - $c*$cy
                )
            );
        }
    }

    function _endpage()
    {
        if($this->angle != 0)
        {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    // ---- FILIGRANE CADECO ----
    function Watermark()
    {
        $this->SetFont('Arial','B',40);
        $this->SetTextColor(230,230,230);
        $this->Rotate(30, 80, 200);
        $this->Text(35, 210, "CADECO");
        $this->Rotate(0);
    }

    // ---- HEADER (page 1 uniquement) ----
    function Header()
    {
        // Filigrane sur toutes les pages
        $this->Watermark();

        if ($this->PageNo() == 1) {

            // Bandeau corporate
            $this->SetFillColor(30, 60, 120);
            $this->Rect(0, 0, 210, 25, "F");

            // Logo
            $this->Image('img/Logo CADECO1.jpg', 10, 4, 18);

            // Texte
            $this->SetFont('Arial','B',14);
            $this->SetTextColor(255,255,255);
            $this->SetXY(30, 5);
            $this->Cell(150, 6, "CAISSE GENERALE D'EPARGNE DU CONGO", 0, 1, 'C');
            $this->Cell(190, 5, "C A D E C O", 0, 1, 'C');
            $this->SetFont('Arial','',10);
            $this->Cell( 190,4,iconv('UTF-8','ISO-8859-1//TRANSLIT', "Société Anonyme Unipersonnelle"),0, 1, 'C');

            // Ligne décorative
            $this->SetDrawColor(180,180,180);
            $this->Line(10, 28, 200, 28);
            $this->Ln(12);
            $this->SetTextColor(0,0,0);
        }
    }

    // ---- FOOTER ----
    function Footer()
    {
        $this->SetDrawColor(200,200,200);
        $this->Line(10, 285, 200, 285);

        $this->SetY(-12);
        $this->SetFont('Arial','I',9);
        $this->SetTextColor(120,120,120);
        $this->Cell(0, 10, "Page ".$this->PageNo()."/{nb}", 0, 0, 'R');
    }

    // ---- TABLEAU PRO ----
    function TablePro($header, $data)
    {
        $widths = [12, 25, 70, 22, 40];
        $totalWidth = array_sum($widths);
        $startX = ($this->GetPageWidth() - $totalWidth) / 2;

        // Header
        $this->SetFillColor(230,240,255);
        $this->SetTextColor(0,0,80);
        $this->SetFont('Arial','B',10);
        $this->SetX($startX);

        foreach ($header as $i=>$col) {
            $this->Cell($widths[$i], 8,
                iconv('UTF-8','ISO-8859-1//TRANSLIT',$col),
                1, 0, 'C', true
            );
        }
        $this->Ln();

        // Rows
        $this->SetFont('Arial','',10);
        $this->SetTextColor(0,0,0);

        foreach ($data as $row) {
            $this->SetX($startX);
            foreach ($row as $i=>$col) {
                $this->Cell($widths[$i], 7,
                    iconv('UTF-8','ISO-8859-1//TRANSLIT',$col),
                    1
                );
            }
            $this->Ln();
        }
    }
}

/* ================= REQUETE ================= */
$sql = "
SELECT 
    periode,
    type_paie,
    CASE
        WHEN codeEiPaie = 999 THEN 'NET A PAYER'
        WHEN codeEiPaie = 412 THEN 'RETENUE SYNDICALE'
        WHEN codeEiPaie = 408 THEN 'RETENUE CNSS'
        WHEN codeEiPaie = 409 THEN 'RETENUE IPR'
    END AS nature_montant,
    SUM(
        CASE 
            WHEN codeEiPaie = 999 THEN montant_payer
            ELSE Montant_a_retenir
        END
    ) AS total_montant
FROM bdd_paie.t_paie
WHERE codeEiPaie IN (999,412,408,409)
  AND periode = :periode
GROUP BY periode, type_paie, nature_montant
ORDER BY type_paie, nature_montant
";

$stmt = $db->prepare($sql);
$stmt->execute([':periode'=>$periode]);

/* ================= PDF ================= */
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

/* ===== TITRE RAPPORT ===== */
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'MASSE SALARIALE',0,1,'C');

$pdf->SetFont('Arial','',11);


 $pdf->Cell(0,8, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "Période : $periode"),0, 1, 'C');

$pdf->Ln(5);

/* ===== TABLE ===== */
$pdf->SetFont('Arial','B',10);

$pdf->Cell(30,8,'Type Paie',1);
$pdf->Cell(70,8,'Nature du Montant',1);
$pdf->Cell(40,8,'Montant (CDF)',1);
$pdf->Ln();

$pdf->SetFont('Arial','',10);
$totalGeneral = 0;

while ($r = $stmt->fetch()) {
    
$libelleType = match ($r['type_paie']) {
    'G' => 'Gratification',
    'N' => 'Normal',
    'V' => 'Rente Viagere',
    default => 'Inconnu',
};

$pdf->Cell(
    30,
    8,
    iconv('UTF-8', 'ISO-8859-1', $libelleType),
    1
);

 
  
    $pdf->Cell(70,8,$r['nature_montant'],1);
    $pdf->Cell(40, 8, number_format($r['total_montant'],0,',',' '), 1, 0, 'R');
    $pdf->Ln();
    $totalGeneral += $r['total_montant'];
}

/* ===== TOTAL GENERAL ===== */
$pdf->SetFont('Arial','B',10);
$pdf->Cell(100,8,'TOTAL GENERAL',1);
$pdf->Cell(40,8,number_format($totalGeneral,0,',',' '),1,0,'R');

/* ================= SORTIE ================= */
$pdf->Output('I',"masse_salariale_$periode.pdf");
