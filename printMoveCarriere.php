
<?php
require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

/*************************************************
 * Vérification du matricule
 *************************************************/
if (!isset($_GET['code']) || empty($_GET['code'])) {
    die("Matricule manquant !");
}
$matricule = trim($_GET['code']);

/*************************************************
 * Fonction Date FR
 *************************************************/
function dateFR($dateSql)
{
    if ($dateSql == "" || $dateSql == "0000-00-00") return "-";

    $mois = [
        "01"=>"janvier","02"=>"février","03"=>"mars","04"=>"avril",
        "05"=>"mai","06"=>"juin","07"=>"juillet","08"=>"août",
        "09"=>"septembre","10"=>"octobre","11"=>"novembre","12"=>"décembre"
    ];

    $ts = strtotime($dateSql);
    return date("d", $ts)." ".$mois[date("m",$ts)]." ".date("Y",$ts);
}

/*************************************************
 * Nom complet de l’agent
 *************************************************/
$sql = $db->prepare("
    SELECT CONCAT(nom_ag,' ',postnom_ag,' ',prenom_ag) AS nom_complet
    FROM bdd_paie.t_agent
    WHERE matricule = :m
");
$sql->bindValue(':m',$matricule);
$sql->execute();
$agent = $sql->fetch(PDO::FETCH_ASSOC);
$nomAgent = $agent ? $agent['nom_complet'] : "Inconnu";

/*************************************************
 * Classe PDF AVEC ENTÊTE COMPLET
 *************************************************/
class PDF extends FPDF
{
    public $angle = 0;
    public $showHeader = false;

    /* -------- ROTATION -------- */
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

    /* -------- FILIGRANE -------- */
    function Watermark()
    {
        $this->SetFont('Arial','B',40);
        $this->SetTextColor(230,230,230);
        $this->Rotate(30, 120, 180);
        $this->Text(80, 200, "CADECO");
        $this->Rotate(0);
    }

    /* -------- HEADER INSTITUTIONNEL -------- */
    function Header()
    {
        // Filigrane
        $this->Watermark();

        if ($this->showHeader === true) {

            // Bandeau bleu
            $this->SetFillColor(30,60,120);
            $this->Rect(0,0,297,25,'F'); // A4 paysage

            // Logo
            $this->Image('img/Logo CADECO1.jpg',10,4,18);

            // Texte
            $this->SetTextColor(255,255,255);
            $this->SetFont('Arial','B',14);
            $this->SetXY(30,5);
            $this->Cell(237,6,"CAISSE GENERALE D'EPARGNE DU CONGO",0,1,'C');
                  $this->Cell(280,6,"CADECO",0,1,'C');
            $this->SetFont('Arial','',10);
            $this->Cell(280,5, iconv('UTF-8','ISO-8859-1//TRANSLIT',"Société Anonyme Unipersonnelle"),0, 1, 'C'
            );

            // Ligne
            $this->SetDrawColor(180,180,180);
            $this->Line(10,28,287,28);

            $this->Ln(14);
            $this->SetTextColor(0,0,0);
        }
    }

    /* -------- FOOTER -------- */
    function Footer()
    {
        $this->SetY(-12);
        $this->SetFont('Arial','I',9);
        $this->SetTextColor(120,120,120);
        $this->Cell(0,10,"Page ".$this->PageNo()."/{nb}",0,0,'R');
    }

    /* -------- ENTÊTE TABLEAU -------- */
    function EnteteTableau()
    {
        $this->SetFont('Arial','B',10);
        $this->SetFillColor(210,210,210);

        $this->Cell(12,8, iconv('UTF-8','ISO-8859-1','N°'),1,0,'C',true);
        $this->Cell(35,8, iconv('UTF-8','ISO-8859-1','Mouvement'),1,0,'C',true);
        $this->Cell(120,8,iconv('UTF-8','ISO-8859-1','Désignation'),1,0,'C',true);
        $this->Cell(40,8,iconv('UTF-8','ISO-8859-1','Date début'),1,0,'C',true);
        $this->Cell(40,8,iconv('UTF-8','ISO-8859-1','Date fin'),1,1,'C',true);
    }
}

/*************************************************
 * Génération PDF
 *************************************************/
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->showHeader = true;   // ✅ AFFICHER L’ENTÊTE
$pdf->AddPage();

/************ Infos Agent ************/
$pdf->SetFont('Arial','BU',14);
$pdf->Cell(0,10,"CHRONOLOGIE DES MOUVEMENTS DE L'AGENT",0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"Matricule : $matricule",0,1,'C');
$pdf->Cell(0,8,iconv('UTF-8','ISO-8859-1',"Nom complet : $nomAgent"),0,1,'C');
$pdf->Ln(5);

/*************************************************
 * Requête mouvements
 *************************************************/
$sql = $db->prepare("
SELECT 'SIEGE' AS type_info, sg.code_sieg AS code, sg.libelle_sieg AS libelle, ags.dateDebut, ags.dateFin
FROM bdd_paie.detail_agent_siege ags
JOIN bdd_paie.t_siege sg ON ags.siege_ID = sg.code_sieg
WHERE ags.agent_ID = :m

UNION ALL
SELECT 'GRADE', gra.code_grade, gra.libelle_grade, ag_gr.dateDebut, ag_gr.dateFin
FROM bdd_paie.detail_agent_grade ag_gr
JOIN bdd_paie.t_grade gra ON gra.code_grade = ag_gr.grade_ID
WHERE ag_gr.agent_ID = :m

UNION ALL
SELECT 'FONCTION', agf.fonction_ID, f.libelleFonct, agf.dateDebut, agf.dateFin
FROM bdd_paie.detail_agent_fonction agf
JOIN bdd_paie.t_fonction f ON agf.fonction_ID = f.codeFonct
WHERE agf.agent_ID = :m

UNION ALL
SELECT 'DIRECTION', dir.code_dir, dir.libelle_dir, agd.dateDebut, agd.dateFin
FROM bdd_paie.detail_agent_direction agd
JOIN bdd_paie.t_direction dir ON agd.direction_ID = dir.code_dir
WHERE agd.agent_ID = :m

ORDER BY type_info ASC
");
$sql->bindValue(':m',$matricule);
$sql->execute();

/************ Tableau ************/
$pdf->EnteteTableau();
$pdf->SetFont('Arial','',9);
$num = 1;

foreach ($sql as $row) {

    switch ($row['type_info']) {
        case 'SIEGE':     $pdf->SetFillColor(217,234,246); break;
        case 'GRADE':     $pdf->SetFillColor(223,240,216); break;
        case 'FONCTION':  $pdf->SetFillColor(255,235,205); break;
        case 'DIRECTION': $pdf->SetFillColor(230,220,250); break;
        default:          $pdf->SetFillColor(255,255,255);
    }

    $designation = $row['code'].' | '.$row['libelle'];

    $pdf->Cell(12,7,$num,1,0,'C',true);
    $pdf->Cell(35,7,$row['type_info'],1,0,'C',true);
    $pdf->Cell(120,7,iconv('UTF-8','ISO-8859-1',$designation),1,0,'L',true);
    $pdf->Cell(40,7,dateFR($row['dateDebut']),1,0,'C',true);
    $pdf->Cell(40,7,$row['dateFin'] ? dateFR($row['dateFin']) : 'En cours',1,1,'C',true);

    $num++;
}

/************ Signature ************/
$pdf->Ln(10);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,"Fait à Kinshasa, le ".date('d/m/Y'),0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"KASONGO NGOY",0,1,'C');

$pdf->Output("I","etat_carriere.pdf");
