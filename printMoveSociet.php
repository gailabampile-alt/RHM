
<?php
require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

/* -------------------------------------------
   Sécuriser la sortie : éviter "output already sent"
--------------------------------------------- */
ob_start();
ini_set('display_errors', 0);

/* -------------------------------------------
   Helper : conversion UTF-8 -> ISO-8859-1 sûre
--------------------------------------------- */
function toLatin1($str)
{
    if ($str === null) return '';
    if (!is_string($str)) $str = (string)$str;

    // Normaliser certains caractères "exotiques"
    $map = [
        "’"=>"'", "‘"=>"'", "‚"=>",",
        "“"=>'"', "”"=>'"', "„"=>'"',
        "–"=>"-","—"=>"-","−"=>"-",
        "…"=>"...", "•"=>"*",
        " "=>" ", " "=>" " // espaces fines/insécables
    ];
    $str = strtr($str, $map);
    $str = preg_replace('/\s+/u', ' ', trim($str));

    // Conversion principale
    $converted = @iconv('UTF-8','ISO-8859-1//TRANSLIT',$str);
    if ($converted === false) {
        // Fallback
        $converted = utf8_decode($str);
    }
    return $converted;
}

/* -------------------------------------------
   Vérifier et récupérer le matricule
--------------------------------------------- */
if (!isset($_GET['code']) || trim($_GET['code']) === '') {
    // Rien n'est envoyé au navigateur -> pas de pollution de sortie PDF
    die('Matricule manquant !');
}
$matricule = trim($_GET['code']);

/* -------------------------------------------
   Date en français
--------------------------------------------- */
function dateFR($d)
{
    if ($d == "" || $d == "0000-00-00") return "-";
    $mois = [
        "01"=>"janvier","02"=>"février","03"=>"mars","04"=>"avril","05"=>"mai","06"=>"juin",
        "07"=>"juillet","08"=>"août","09"=>"septembre","10"=>"octobre","11"=>"novembre","12"=>"décembre"
    ];
    $ts = strtotime($d);
    return date('d', $ts).' '.$mois[date('m', $ts)].' '.date('Y', $ts);
}

/* -------------------------------------------
   Récupérer le nom complet de l’agent
--------------------------------------------- */
$stmt = $db->prepare("
    SELECT CONCAT(nom_ag,' ',postnom_ag,' ',prenom_ag) AS nomComplet
    FROM bdd_paie.t_agent
    WHERE matricule = :m
    LIMIT 1
");
$stmt->bindValue(':m', $matricule);
$stmt->execute();
$agent = $stmt->fetch(PDO::FETCH_ASSOC);
$nomAgent = $agent ? $agent['nomComplet'] : 'Inconnu';

/* -------------------------------------------
   Classe PDF
--------------------------------------------- */
class PDF extends FPDF
{
    function Header()
    {
        // Logos
        $this->Image('img/Logo CADECO1.jpg', 10, 10, 25);
        $this->Image('img/Logo CADECO1.jpg', 250, 10, 25);

        // Entête texte
        $this->SetFont('Arial','B',15);
        $this->Cell(0,10, toLatin1("CAISSE GENERALE D'EPARGNE DU CONGO"), 0, 1, 'C');

        $this->SetFont('Arial','',12);
        $this->Cell(0,7, toLatin1('Société-Anonyme-Unipersonnelle'), 0, 1, 'C');
        $this->Cell(0,7, toLatin1('CADECO SAU'), 0, 1, 'C');
        $this->Cell(0,7, toLatin1('38. Av Cadeco Kinshasa/Gombe'), 0, 1, 'C');

        $this->Ln(2);
        $this->Cell(0,0, str_repeat('_', 140), 0, 1, 'C');
        $this->Ln(8);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',9);
        $this->Cell(0,10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }

    function InfoAgent($matricule, $nom)
    {
        $this->SetFont('Arial','BU',14);
        $this->Cell(0,10, toLatin1("CHRONOLOGIE DES MOUVEMENTS (SOCIÉTÉ)"), 0, 1, 'C');

        $this->SetFont('Arial','B',12);
        $this->Cell(0,8, toLatin1("Matricule : ".$matricule), 0, 1, 'C');
        $this->Cell(0,8, toLatin1("Nom complet : ".$nom), 0, 1, 'C');

        $this->Ln(5);
    }

    function EnteteTableau()
    {
        $this->SetFont('Arial','B',12);

        $tableWidth = 250;
        $x = ($this->GetPageWidth() - $tableWidth) / 2;
        $this->SetX($x);

        // Ligne fusionnée
        $this->Cell(40,20, toLatin1('Mouvement N°'), 1, 0, 'C');
        $this->Cell(210,10, toLatin1('Chronologie de mouvement'), 1, 0, 'C');
        $this->Ln();

        // Sous entête
        $this->SetX($x + 40);
        $this->Cell(110,10, toLatin1('Société'), 1, 0, 'L');
        $this->Cell(50,10, toLatin1('Date Début'), 1, 0, 'C');
        $this->Cell(50,10, toLatin1('Date Fin'), 1, 0, 'C');
        $this->Ln();
    }

    function LigneTableau($num, $societe, $dateDebut, $dateFin)
    {
        $this->SetFont('Arial','',11);

        $tableWidth = 250;
        $x = ($this->GetPageWidth() - $tableWidth) / 2;

        $this->SetX($x);
        $this->Cell(40,10, $num, 1, 0, 'C');
        $this->Cell(110,10, toLatin1($societe), 1, 0, 'L');
        $this->Cell(50,10, toLatin1($dateDebut), 1, 0, 'C');
        $this->Cell(50,10, toLatin1($dateFin), 1, 1, 'C');
    }
}

/* -------------------------------------------
   Génération du PDF
--------------------------------------------- */
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 15);

// En-tête du document (agent)
$pdf->InfoAgent($matricule, $nomAgent);

// En-tête du tableau
$pdf->EnteteTableau();

/* -------------------------------------------
   Charger les mouvements "Société"
--------------------------------------------- */
$q = $db->prepare("
    SELECT 
        agso.societe_ID,
        agso.dateDebut,
        agso.dateFin,
        so.libelle_soc
    FROM bdd_paie.detail_agent_societe AS agso
    INNER JOIN bdd_paie.t_societe AS so ON agso.societe_ID = so.code_soc
    WHERE agso.agent_ID = :agent
    ORDER BY agso.dateDebut ASC
");
$q->bindValue(':agent', $matricule);
$q->execute();

$comp = 1;
while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
    $societe = $row['libelle_soc']; // déjà en UTF-8 depuis MySQL
    $deb = dateFR($row['dateDebut']);
    $fin = dateFR($row['dateFin']);

    $pdf->LigneTableau($comp, $societe, $deb, $fin);
    $comp++;
}

/* -------------------------------------------
   Pied + Sortie
--------------------------------------------- */
$pdf->Ln(12);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8, toLatin1("Fait à Kinshasa, le ".date('d-m-Y')), 0, 1, 'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8, toLatin1("KASONGO NGOY"), 0, 1, 'C');

/* IMPORTANT : nettoyer le buffer AVANT d'envoyer le PDF */
ob_end_clean();
$pdf->Output('I', 'etat_carriere.pdf');
