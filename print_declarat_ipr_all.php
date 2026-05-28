
<?php

ini_set('max_execution_time', 300);
ini_set('memory_limit', '512M');

require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

$periode = $_GET['periode'] ?? '';

if (empty($periode)) {
    die("<h3 style='color:red;'>❌ Période manquante</h3>");
}

// ======================================================================
//   CLASS PDF – PRO, PORTRAIT, FILIGRANE + ENTÊTE 1ère PAGE PAR SIÈGE
// ======================================================================
class PDF extends FPDF
{
    public $showHeader = false;
    public $angle = 0;  // ✅ OBLIGATOIRE POUR PHP 8

    // ================= ROTATION POUR FILIGRANE =================
    function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1) $x = $this->x;
        if ($y == -1) $y = $this->y;

        if ($this->angle != 0)
            $this->_out('Q');

        $this->angle = $angle;

        if ($angle != 0)
        {
            $angle = $angle * M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);

            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;

            $this->_out(sprintf(
                'q %.5F %.5F %.5F %.5F %.5F %.5F cm',
                $c, $s, -$s, $c,
                $cx - $c * $cx + $s * $cy,
                $cy - $s * $cx - $c * $cy
            ));
        }
    }

    function _endpage()
    {
        if ($this->angle != 0)
        {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    // ================= FILIGRANE =================
    function Watermark()
    {
        $this->SetFont('Arial','B',40);
        $this->SetTextColor(220,220,220);
        $this->Rotate(30, 80, 200);
        $this->Text(30, 200, "CADECO");
        $this->Rotate(0);
    }

    // ================= HEADER =================
    function Header()
    {
        $this->Watermark();

        if ($this->showHeader)
        {
            $this->SetFillColor(30,60,120);
            $this->Rect(0,0,210,25,"F");

            $this->Image('img/Logo CADECO1.jpg',10,4,18);

            $this->SetFont('Arial','B',14);
            $this->SetTextColor(255,255,255);
            $this->SetXY(30,5);
            $this->Cell(150,6,"CAISSE GENERALE D'EPARGNE DU CONGO",0,1,'C');
            $this->Cell(190, 5, "C A D E C O", 0, 1, 'C');
            $this->SetFont('Arial','',10);
            $this->Cell( 190,4,iconv('UTF-8','ISO-8859-1//TRANSLIT', "Société Anonyme Unipersonnelle"),0, 1, 'C');

            $this->SetDrawColor(180,180,180);
            $this->Line(10,28,200,28);
            $this->Ln(12);
            $this->SetTextColor(0,0,0);
        }
    }

    // ================= FOOTER =================
    function Footer()
    {
        $this->SetDrawColor(200,200,200);
        $this->Line(10,285,200,285);

        $this->SetY(-12);
        $this->SetFont('Arial','I',9);
        $this->SetTextColor(120,120,120);
        $this->Cell(0,10,"Page ".$this->PageNo()."/{nb}",0,0,'R');
    }

    // ================= TABLEAU =================
    function TablePro($header, $data)
    {
        $widths = [12,25,70,22,40];
        $totalWidth = array_sum($widths);
        $startX = ($this->GetPageWidth() - $totalWidth) / 2;

        // Header
        $this->SetFillColor(230,240,255);
        $this->SetTextColor(0,0,80);
        $this->SetFont('Arial','B',10);
        $this->SetX($startX);

        foreach ($header as $i=>$col)
            $this->Cell($widths[$i],8,iconv('UTF-8','ISO-8859-1//TRANSLIT',$col),1,0,'C',true);
        
        $this->Ln();

        // Rows
        $this->SetFont('Arial','',10);
        $this->SetTextColor(0,0,0);

        foreach ($data as $row)
        {
            $this->SetX($startX);
            foreach ($row as $i=>$col)
                $this->Cell($widths[$i],7,iconv('UTF-8','ISO-8859-1//TRANSLIT',$col),1);
            $this->Ln();
        }
    }
}

// ======================================================================
//   RÉCUPÉRATION DES DONNÉES CNSS (409) POUR TOUS LES SIÈGES
// ======================================================================
$sql = "
    SELECT 
        p.Matricule,
        p.codeEiPaie,
        p.montant_a_retenir,
        p.codesiege,
        s.libelle_sieg,
        a.nom_ag AS Nom,
        a.postnom_ag AS Postnom,
        a.prenom_ag AS Prenom
    FROM bdd_paie.t_paie p
    INNER JOIN bdd_paie.t_agent a ON a.matricule = p.Matricule
    INNER JOIN bdd_paie.t_siege s ON s.code_sieg = p.codesiege
    WHERE p.periode = :periode
      AND p.codeEiPaie = 409
    ORDER BY p.codesiege, p.Matricule
";

$req = $db->prepare($sql);
$req->bindValue(':periode', $periode);
$req->execute();
$rows = $req->fetchAll(PDO::FETCH_ASSOC);

if (empty($rows)) {
    die("<h3 style='color:red;'>Aucune donnée trouvée</h3>");
}

// Groupement par siège
$group = [];
foreach ($rows as $r) {
    $group[$r['codesiege']]['nom'] = $r['libelle_sieg'];
    $group[$r['codesiege']]['data'][] = $r;
}

// ======================================================================
//   CRÉATION PDF
// ======================================================================
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();

$header = ['N','MATRICULE','NOMS','CODE','RETENU'];

foreach ($group as $code_siege => $content)
{
    $lib_sieg = $content['nom'];
    $data_siege = $content['data'];

    // Nouvelle page = entête active
    $pdf->showHeader = true;
    $pdf->AddPage();
    $pdf->showHeader = false;

    // Titre
    $pdf->SetFont('Arial','B',13);
    $titre = "RETENU IPR — SIEGE : $code_siege / $lib_sieg — PERIODE : $periode";
    $pdf->MultiCell(0,10,iconv('UTF-8','ISO-8859-1//TRANSLIT',$titre),0,'C');

    // Préparation tableau
    $data = [];
    $total_siege = 0;
    $n = 1;

    foreach ($data_siege as $r)
    {
        $nomComplet = $r['Nom']." ".$r['Postnom']." ".$r['Prenom'];

        $data[] = [
            $n,
            $r['Matricule'],
            $nomComplet,
            $r['codeEiPaie'],
            number_format($r['montant_a_retenir'],2,",",".")
        ];

        $total_siege += $r['montant_a_retenir'];
        $n++;
    }

    // Affichage tableau
    $pdf->Ln(4);
    $pdf->TablePro($header, $data);

    // Total siège
    $pdf->Ln(6);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetFillColor(230,240,255);
    $pdf->SetTextColor(0,0,80);

    $txtTotal = "TOTAL IPR RETENU — SIEGE $code_siege : ".
                number_format($total_siege,2,',',' ')." FC";

    $pdf->Cell(190,10,iconv('UTF-8','ISO-8859-1//TRANSLIT',$txtTotal),1,1,'R',true);
}

$pdf->Output();

?>
