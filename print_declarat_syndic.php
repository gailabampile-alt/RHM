
<?php

ini_set('max_execution_time', 300);
ini_set('memory_limit', '512M');

require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

// ✅ Récupération des paramètres
$periode = $_POST['periode'] ?? '';
$siege   = $_POST['siege'] ?? '';

if (empty($periode) || empty($siege)) {
    die("<h3 style='color:red;'>❌ Paramètres invalides</h3>");
}

// ✅ Libellé siège
$reqLib = $db->prepare("
    SELECT libelle_sieg 
    FROM bdd_paie.t_siege 
    WHERE code_sieg = :siege
");
$reqLib->bindValue(':siege', $siege);
$reqLib->execute();
$libelle_siege = $reqLib->fetch(PDO::FETCH_ASSOC)['libelle_sieg'] ?? '';

/* ========================================================================
        PDF PRO — PORTRAIT + FILIGRANE + HEADER PREMIÈRE PAGE
   ======================================================================== */
class PDF extends FPDF
{
    public $angle = 0;

    /* Rotation (nécessaire pour filigrane) */
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

    /* ✅ Filigrane CADECO */
    function Watermark()
    {
        $this->SetFont('Arial','B',38);
        $this->SetTextColor(220,220,220);
        $this->Rotate(30, 70, 200);
        $this->Text(30, 200, "CADECO");
        $this->Rotate(0);
    }

    /* ✅ HEADER PRO — uniquement première page */
    function Header()
    {
        $this->Watermark();

        if ($this->PageNo() == 1) {

            // Bandeau Corporate
            $this->SetFillColor(30,60,120);
            $this->Rect(0,0,210,25,"F");

            // Logo
            $this->Image('img/Logo CADECO1.jpg',10,4,18);

            // Texte
            $this->SetFont('Arial','B',14);
            $this->SetTextColor(255,255,255);
            $this->SetXY(35,5);
            $this->Cell(140,6,"CAISSE GENERALE D'EPARGNE DU CONGO",0,1,'C');

            $this->Cell(190, 5, "C A D E C O", 0, 1, 'C');
            $this->SetFont('Arial','',10);
            $this->Cell( 190,4,iconv('UTF-8','ISO-8859-1//TRANSLIT', "Société Anonyme Unipersonnelle"),0, 1, 'C');

            // Ligne décorative
            $this->SetDrawColor(180,180,180);
            $this->Line(10,28,200,28);
            $this->Ln(12);

            $this->SetTextColor(0,0,0);
        }
    }

    /* ✅ FOOTER PRO */
    function Footer()
    {
        $this->SetDrawColor(200,200,200);
        $this->Line(10,285,200,285);

        $this->SetY(-12);
        $this->SetFont('Arial','I',9);
        $this->SetTextColor(120,120,120);
        $this->Cell(0,10,"Page ".$this->PageNo()."/{nb}",0,0,'R');
    }

    /* ✅ Tableau pro centré */
    function TablePro($header,$data)
    {
        $widths = [12,25,70,22,40];
        $totalWidth = array_sum($widths);
        $startX = ($this->GetPageWidth() - $totalWidth) / 2;

        // Header
        $this->SetFillColor(230,240,255);
        $this->SetTextColor(0,0,80);
        $this->SetFont('Arial','B',11);
        $this->SetX($startX);

        foreach ($header as $i=>$col)
            $this->Cell($widths[$i],8,iconv('UTF-8','ISO-8859-1//TRANSLIT',$col),1,0,'C',true);

        $this->Ln();

        // Rows
        $this->SetFont('Arial','',10);
        $this->SetTextColor(0,0,0);

        foreach ($data as $row) {
            $this->SetX($startX);
            foreach ($row as $i=>$col)
                $this->Cell($widths[$i],7,iconv('UTF-8','ISO-8859-1//TRANSLIT',$col),1);
            $this->Ln();
        }
    }
}

/* ========================================================================
                        GÉNÉRATION PDF
   ======================================================================== */

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',13);
$pdf->SetTextColor(0,0,80);

$titre = "RETENUE SYNDICALE — SIEGE : $siege | $libelle_siege — PERIODE : $periode";
$pdf->MultiCell(0,10,iconv('UTF-8','ISO-8859-1//TRANSLIT',$titre),0,'C');
$pdf->Ln(4);


/* ========================================================================
                        REQUÊTE SQL
   ======================================================================== */
$req = $db->prepare("
    SELECT 
        t.Matricule,
        t.codeElPaie,
        t.libelle_el_paie,
        t.Montant_retsyndyc,
        a.nom_ag AS Nom,
        a.postnom_ag AS Postnom,
        a.prenom_ag AS Prenom
    FROM bdd_paie.v_retsydic t
    INNER JOIN bdd_paie.t_agent a ON a.matricule = t.Matricule
    WHERE t.codesiege = :siege
      AND t.periode   = :periode
");
$req->bindValue(':siege', $siege);
$req->bindValue(':periode', $periode);
$req->execute();


/* ========================================================================
                        TABLEAU PDF
   ======================================================================== */
$header = ['N','MATRICULE','NOMS','CODE','RETENU'];
$data = [];
$total = 0;
$n = 1;

while ($row = $req->fetch(PDO::FETCH_ASSOC)) {

    $nomComplet = $row['Nom'].' '.$row['Postnom'].' '.$row['Prenom'];

    $data[] = [
        $n,
        $row['Matricule'],
        $nomComplet,
        $row['codeElPaie'],
        number_format($row['Montant_retsyndyc'],2,",",".")
    ];

    $total += $row['Montant_retsyndyc'];
    $n++;
}

$pdf->TablePro($header,$data);


/* ========================================================================
                        TOTAL
   ======================================================================== */
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(230,240,255);
$pdf->SetTextColor(0,0,80);

$pdf->Cell(
    190,
    10,
    iconv('UTF-8','ISO-8859-1//TRANSLIT',"TOTAL RETENU SYNDICAL : ".number_format($total,2,',',' ')." FC"),
    1,1,'R',true
);


/* ========================================================================
                        SIGNATURE
   ======================================================================== */
$pdf->Ln(12);
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190,10,
    iconv('UTF-8','ISO-8859-1//TRANSLIT',"Fait à Kinshasa, le ".date('d-m-Y')),
    0,1,'R'
);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,
    iconv('UTF-8','ISO-8859-1//TRANSLIT',"LAMA LUTSHIMA BIENVIEN"),
    0,1,'R'
);

$pdf->Output();
?>
