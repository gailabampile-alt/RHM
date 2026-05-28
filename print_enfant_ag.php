
<?php
require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

$matric = isset($_GET['matric']) ? trim($_GET['matric']) : '';

if ($matric === '') {
    die('Matricule manquant.');
}

/**
 * Récupérer le nom complet de l’agent
 */
$sqlAgent = $db->prepare("
    SELECT CONCAT(nom_ag, ' ', postnom_ag, ' ', prenom_ag) AS nom_complet
    FROM bdd_paie.t_agent
    WHERE matricule = :matric
");
$sqlAgent->bindValue(':matric', $matric);
$sqlAgent->execute();
$resAgent = $sqlAgent->fetch(PDO::FETCH_ASSOC);

$nomAgent = $resAgent ? $resAgent['nom_complet'] : 'Agent inconnu';

/**
 * Fonction : Date en français
 */
function date_fr($dateSql)
{
    $mois = [
        "01"=>"janvier","02"=>"février","03"=>"mars","04"=>"avril","05"=>"mai","06"=>"juin",
        "07"=>"juillet","08"=>"août","09"=>"septembre","10"=>"octobre","11"=>"novembre","12"=>"décembre"
    ];

    $ts = strtotime($dateSql);
    $j = date("d", $ts);
    $m = date("m", $ts);
    $y = date("Y", $ts);

    return $j . " " . $mois[$m] . " " . $y;
}

/**
 * Fonction : Calcul âge
 */
function age($dateNaiss)
{
    $dn = new DateTime($dateNaiss);
    $today = new DateTime();
    return $today->diff($dn)->y . " ans";
}

/**
 * PDF
 */
class PDF extends FPDF
{
    // En-tête
    function Header()
    {
        $this->Image('img/Logo CADECO1.jpg',10,6,18,20);
        $this->Image('img/Logo CADECO1.jpg',265,6,18,20);

        $this->SetFont('Arial','B',15);
        $this->Cell(125);
        $this->Cell(30,3,"CAISSE GENERALE D'EPARGNE DU CONGO",0,0,'C');

        $this->Ln(5);
        $this->Cell(125);
        $this->SetFont('Arial','B',12);
        $this->Cell(30,3,iconv('UTF-8','ISO-8859-1','Société-Anonyme-Unipersonnelle'),0,0,'C');

        $this->Ln(6);
        $this->Cell(125);
        $this->SetFont('Arial','B',15);
        $this->Cell(30,3,'CADECO SAU',0,0,'C');

        $this->Ln(6);
        $this->Cell(125);
        $this->SetFont('Arial','B',12);
        $this->Cell(30,3,iconv('UTF-8','ISO-8859-1','38.Av Cadeco Kinshasa/Gombe'),0,0,'C');

        $this->Ln(5);
        $this->Cell(125);
        $this->SetFont('Arial','B',12);
        $this->Cell(30,3,
            iconv('UTF-8','ISO-8859-1','_________________________________________________________________________'),
            0,2,'C'
        );
    }

    // Pied de page
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    /**
     * Tableau centré
     */
    function BasicTable($header, $data)
    {
        // Largeur colonnes
        $widths = array_map(fn($col) => $this->GetStringWidth($col)+20, $header);

        foreach ($data as $row) {
            foreach ($row as $i => $col) {
                $w = $this->GetStringWidth($col)+20;
                if ($w > $widths[$i]) $widths[$i] = $w;
            }
        }

        // Largeur totale
        $totalWidth = array_sum($widths);

        // Centrage
        $pageWidth = $this->GetPageWidth() - $this->lMargin - $this->rMargin;
        $startX = ($pageWidth - $totalWidth) / 2 + $this->lMargin;

        // En-tête
        $this->SetXY($startX,$this->GetY());
        foreach ($header as $i => $col) {
            $this->SetFillColor(200,220,255);
            $this->SetFont('Arial','B',11);
            $this->Cell($widths[$i],8,iconv('UTF-8','ISO-8859-1',$col),1,0,'C',true);
        }
        $this->Ln();

        // Données
        foreach ($data as $row) {
            $this->SetX($startX);
            foreach ($row as $i => $col) {
                $txt = iconv('UTF-8','ISO-8859-1//TRANSLIT',$col);
                $this->SetFont('Arial','',10);
                $this->Cell($widths[$i],8,$txt,1,0,'C');
            }
            $this->Ln();
        }
    }
}

// Instanciation PDF
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',14);
$pdf->Ln(10);

// Titre avec NOM AGENT
$titre = "LISTE DES ENFANTS PRISES EN CHARGE PAR AGENT : " . strtoupper($nomAgent);
$pdf->Cell(272,12,iconv('UTF-8','ISO-8859-1',$titre),1,0,'C');

// ---- TABLEAU ----
// NOUVEAU HEADER SANS MATRICULE
$header = array('NOM ENFANT','SEXE','DATE NAISSANCE','AGE');

// Chargement des données
$data = [];

$result = $db->prepare("
    SELECT nom_enf, postnom_enf, prenom_enf, sexe_enf, dateNaiss_enf
    FROM bdd_paie.t_enfants_agent
    WHERE agent_ID = :matric
    ORDER BY nom_enf
");
$result->bindValue(':matric', $matric);
$result->execute();

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

    $nomEnfant = trim($row['nom_enf'].' '.$row['postnom_enf'].' '.$row['prenom_enf']);
    $dateFr = date_fr($row['dateNaiss_enf']);
    $age = age($row['dateNaiss_enf']);

    $data[] = array(
        $nomEnfant,
        $row['sexe_enf'],
        $dateFr,
        $age
    );
}

$pdf->Ln(15);
$pdf->BasicTable($header,$data);

// Signature
$pdf->Ln(15);
$pdf->SetFont('Arial','',11);
$pdf->Cell(270,10,iconv('UTF-8','ISO-8859-1',"Fait à Kinshasa, le ".date('d-m-Y')),0,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(270,10,iconv('UTF-8','ISO-8859-1','KASONGO NGOY'),0,0,'C');

$pdf->Output();
?>
