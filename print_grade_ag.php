<?php
    require('sys_fonction.php');
    require('sys_connexion.php');
    require('fpdf.php');

// =============================
//       CLASS PDF PRO
// =============================
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
        $widths = [35, 100, 45];
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


// =============================
//      GENERATION PDF
// =============================
$pdf = new PDF('P','mm','A4','UTF-8');
$pdf->AliasNbPages();
$pdf->AddPage();

// ---- Titre ----
$pdf->SetFont('Arial','B',13);
$pdf->SetTextColor(0,0,80);

$titre = "LISTE DE GRADE — EN DATE DU " .date('d-m-Y');
$pdf->MultiCell(0,10, iconv('UTF-8','ISO-8859-1//TRANSLIT',$titre), 0, 'C');
$pdf->Ln(4);

$pdf->SetTextColor(0,0,0);

// =============================
//     REQUETE SQL CNSS (408)
// =============================
// Data loading
$compteur = 1;
    $reqGrade = $db->prepare('SELECT * FROM bdd_paie.t_grade');
    $reqGrade ->execute();
    while($resGrade=$reqGrade->fetch()){
        $code_grade = $resGrade['code_grade'];
        $lib_grade = $resGrade['libelle_grade'];
        $eq_paie = $resGrade['Eq_Paie_ID'];
        $eq_compt = $resGrade['Eq_Compt_ID'];
        $creerPar = $resGrade['creePar'];
        $modifierPar = $resGrade['modifierPar'];
        $statut = $resGrade['statut_ID'];
        
        // Formatage du statut
        $statut_display = ($statut == 'act') ? 'Actif' : 'Inactif';
        
        $data[] = array($code_grade, $lib_grade, $statut_display);      
        ++$compteur;      
    }

$pdf->TablePro(['Code Grade','Libelle', 'Statut'], $data);

// =============================
//       TOTAL GLOBAL
// =============================
$pdf->Ln(6);
$pdf->SetFont('Arial','B',12);
$pdf->SetFillColor(230,240,255);
$pdf->SetTextColor(0,0,80);



// =============================
//       SIGNATURE
// =============================
$pdf->Ln(10);
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(190,10,
    iconv('UTF-8','ISO-8859-1//TRANSLIT',"Fait à Kinshasa, le ".date('d-m-Y')),
    0,1,'R'
);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,
    iconv('UTF-8','ISO-8859-1//TRANSLIT',"KASONGO NGOY"),
    0,1,'R'
);

$pdf->Output();

?>
