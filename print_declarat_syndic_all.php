
<?php

ini_set('max_execution_time', 300);
ini_set('memory_limit', '512M');

require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

// ✅ Paramètres
$periode = $_GET['periode'] ?? '';
if (empty($periode)) {
    die("<h3 style='color:red;'>❌ Période manquante</h3>");
}

// =====================================================================
//          CLASS PDF PRO — PORTRAIT, FILIGRANE, HEADER 1° PAGE
// =====================================================================
class PDF extends FPDF
{
    public $angle = 0;
    public $showHeader = false;

    // Rotation
    function Rotate($angle, $x=-1, $y=-1)
    {
        if ($x == -1) $x = $this->x;
        if ($y == -1) $y = $this->y;

        if ($this->angle != 0) {
            $this->_out('Q');
        }

        $this->angle = $angle;

        if ($angle != 0) {
            $angle = deg2rad($angle);
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
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    // ✅ FILIGRANE
    function Watermark()
    {
        $this->SetFont('Arial','B',40);
        $this->SetTextColor(230,230,230);
        $this->Rotate(30, 80, 200);
        $this->Text(30, 210, "CADECO");
        $this->Rotate(0);
    }

    // ✅ HEADER PRO : première page du siège seulement
    function Header()
    {
        $this->Watermark();

        if ($this->showHeader) {

            // Bandeau bleu
            $this->SetFillColor(30,60,120);
            $this->Rect(0,0,210,25,"F");

            // Logo
            $this->Image('img/Logo CADECO1.jpg',10,4,18);

            // Nom institution
            $this->SetFont('Arial','B',14);
            $this->SetTextColor(255,255,255);
            $this->SetXY(30,5);
            $this->Cell(150,6,"CAISSE GENERALE D'EPARGNE DU CONGO",0,1,'C');

            // Forme juridique
            $this->Cell(190, 5, "C A D E C O", 0, 1, 'C');
            $this->SetFont('Arial','',10);
            $this->Cell( 190,4,iconv('UTF-8','ISO-8859-1//TRANSLIT', "Société Anonyme Unipersonnelle"),0, 1, 'C');

            // Trait décoratif
            $this->SetDrawColor(180,180,180);
            $this->Line(10,28,200,28);

            $this->Ln(12);
            $this->SetTextColor(0,0,0);
        }
    }

    // ✅ FOOTER PRO
    function Footer()
    {
        $this->SetDrawColor(200,200,200);
        $this->Line(10,285,200,285);

        $this->SetY(-12);
        $this->SetFont('Arial','I',9);
        $this->SetTextColor(120,120,120);
        $this->Cell(0,10,"Page ".$this->PageNo()."/{nb}",0,0,'R');
    }

    // ✅ TABLEAU PRO — centré
    function TablePro($header, $data)
    {
        $widths = [12,25,70,22,50];
        $totalWidth = array_sum($widths);
        $startX = ($this->GetPageWidth() - $totalWidth) / 2;

        // En‑tête tableau
        $this->SetFillColor(230,240,255);
        $this->SetTextColor(0,0,80);
        $this->SetFont('Arial','B',10);
        $this->SetX($startX);

        foreach ($header as $i=>$col) {
            $this->Cell($widths[$i],8, iconv('UTF-8','ISO-8859-1//TRANSLIT',$col),1,0,'C',true);
        }
        $this->Ln();

        // Lignes
        $this->SetFont('Arial','',10);
        $this->SetTextColor(0,0,0);

        foreach ($data as $row) {
            $this->SetX($startX);
            foreach ($row as $i=>$col) {
                $this->Cell($widths[$i],7,iconv('UTF-8','ISO-8859-1//TRANSLIT',$col),1);
            }
            $this->Ln();
        }
    }
}


// =====================================================================
//       RECUPERATION DES DONNÉES SYNDICALES POUR TOUS LES SIÈGES
// =====================================================================

    
$sql = "
    SELECT 
        Matricule,
        Nom,
        Postnom,
        Prenom,
        codeElPaie,
        libelle_el_paie,
        periode,
        Montant_retsyndyc,
        codesiege,
        libelle_sieg
    FROM bdd_paie.v_retsydic
    INNER JOIN bdd_paie.t_siege ON t_siege.code_sieg = v_retsydic.codesiege
    WHERE periode = :periode
    ORDER BY codesiege, Matricule


";

$req = $db->prepare($sql);
$req->bindValue(':periode', $periode);
$req->execute();
$rows = $req->fetchAll(PDO::FETCH_ASSOC);

if (!$rows) {
    die("<h3 style='color:red;'>Aucune donnée trouvée</h3>");
}

// Groupement par siège
$group = [];
foreach ($rows as $r) {
    $group[$r['codesiege']]['nom'] = $r['libelle_sieg'];
    $group[$r['codesiege']]['data'][] = $r;
}


// =====================================================================
//                          GENERATION PDF
// =====================================================================
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();

$header = ['N','MATRICULE','NOMS','CODE','RETENU'];

foreach ($group as $code_siege => $content)
{
    $lib_sieg  = $content['nom'];
    $dataRows  = $content['data'];

    // ✅ Nouvelle page pour le siège → entête visible
    $pdf->showHeader = true;
    $pdf->AddPage();
    $pdf->showHeader = false;

    // ✅ TITRE
    $pdf->SetFont('Arial','B',13);
    $titre = "RETENUE SYNDICALE — SIEGE : $code_siege / $lib_sieg — PERIODE : $periode";
    $pdf->MultiCell(0,10, iconv('UTF-8','ISO-8859-1//TRANSLIT',$titre), 0, 'C');

    // Préparation des lignes
    $data = [];
    $n = 1;
    $total_siege = 0;

    foreach ($dataRows as $row) {
        $nomComplet = $row['Nom']." ".$row['Postnom']." ".$row['Prenom'];

        $data[] = [
            $n,
            $row['Matricule'],
            $nomComplet,
            $row['codeElPaie'],
            number_format($row['Montant_retsyndyc'],2,",",".")
        ];

        $total_siege += $row['Montant_retsyndyc'];
        $n++;
    }

    // ✅ Tableau pro
    $pdf->Ln(5);
    $pdf->TablePro($header, $data);

    // ✅ TOTAL
    $pdf->Ln(6);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(230,240,255);
    $pdf->SetTextColor(0,0,80);

    $txt = "TOTAL SYNDICAT RETENU — SIEGE $code_siege : ". number_format($total_siege,2,',',' ') ." FC";
    $pdf->Cell(190,10, iconv('UTF-8','ISO-8859-1//TRANSLIT',$txt),1,1,'R',true);
}

// ✅ Final output
$pdf->Output();

?>
