<?php

require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

$selectedSiege = (isset($_GET['siege']) && !is_array($_GET['siege'])) ? validation_donnees($_GET['siege']) : '';
$selectedSiegeLabel = 'TOUS LES SIEGES';

if ($selectedSiege !== '') {
    $reqSiege = $db->prepare("SELECT libelle_sieg FROM bdd_paie.t_siege WHERE code_sieg = :siege");
    $reqSiege->bindValue(':siege', $selectedSiege);
    $reqSiege->execute();
    $siegeTrouve = $reqSiege->fetch(PDO::FETCH_ASSOC);

    if ($siegeTrouve && !empty($siegeTrouve['libelle_sieg'])) {
        $selectedSiegeLabel = $selectedSiege . ' | ' . $siegeTrouve['libelle_sieg'];
    } else {
        $selectedSiegeLabel = $selectedSiege;
    }
}

class PDF extends FPDF
{
    public $angle = 0;

    function Rotate($angle, $x=-1, $y=-1)
    {
        if ($x == -1) $x = $this->x;
        if ($y == -1) $y = $this->y;
        if ($this->angle != 0) {
            $this->_out('Q');
        }
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
        $this->SetFont('Arial','B',38);
        $this->SetTextColor(220,220,220);
        $this->Rotate(30, 70, 200);
        $this->Text(30, 200, "CADECO");
        $this->Rotate(0);
    }

// En-tête
function Header()
{
    $this->Watermark();
    if ($this->PageNo() == 1) {
        $this->SetFillColor(30,60,120);
        $this->Rect(0,0,297,25,"F");
        $this->Image('img/Logo CADECO1.jpg',10,4,18);
        $this->SetFont('Arial','B',14);
        $this->SetTextColor(255,255,255);
        $this->SetXY(35,5);
        $this->Cell(227,6,"CAISSE GENERALE D'EPARGNE DU CONGO",0,1,'C');
        $this->Cell(282, 5, "C A D E C O", 0, 1, 'C');
        $this->SetFont('Arial','',10);
        $this->Cell(282,4,iconv('UTF-8','ISO-8859-1//TRANSLIT', "Société Anonyme Unipersonnelle"),0, 1, 'C');
        $this->SetDrawColor(180,180,180);
        $this->Line(10,28,287,28);
        $this->Ln(12);
        $this->SetTextColor(0,0,0);
    }
}

// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Arial','I',8);
    // Numéro de page
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

function FitCellText($text, $width)
{
    $text = (string) $text;
    $maxWidth = $width - 2;

    if ($this->GetStringWidth($text) <= $maxWidth) {
        return $text;
    }

    while (strlen($text) > 0 && $this->GetStringWidth($text.'...') > $maxWidth) {
        $text = substr($text, 0, -1);
    }

    return rtrim($text).'...';
}

function BasicTable($header, $data, $widths = array())
    {
               // Calculer la largeur maximale pour chaque colonne
    if(count($widths) != count($header)){
        $widths = array_map(function($col) {
            return $this->GetStringWidth($col) + 6; // Ajouter une marge
        }, $header);

        foreach($data as $row) {
            foreach($row as $index => $col) {
                $width = $this->GetStringWidth($col) + 9; // Ajouter une marge
                if ($width > $widths[$index]) {
                    $widths[$index] = $width;
                }
            }
        }
    }

    // En-tête
    foreach($header as $index => $col) {
        $this->SetFillColor(200, 220, 255);
        $this->SetFont('Arial','B',8.5);
        $this->Cell($widths[$index], 7, iconv('UTF-8', 'iso-8859-1',$col), 1,0,'C',true);
    }
    $this->Ln();

    // Données
    foreach($data as $row) {
        foreach($row as $index => $col) {
            $this->SetFont('Arial','',8);
            $align = in_array($index, array(0, 2, 4, 6, 7, 8)) ? 'C' : 'L';
            $this->Cell($widths[$index], 7, $this->FitCellText($col, $widths[$index]), 1,0,$align);
        }
        $this->Ln();
    }
    }

function GenreTitle($title)
{
    $this->SetFillColor(30,60,120);
    $this->SetTextColor(255,255,255);
    $this->SetFont('Arial','B',11);
    $this->Cell(272,8,iconv('UTF-8', 'iso-8859-1//TRANSLIT', $title),1,1,'C',true);
    $this->SetTextColor(0,0,0);
}

} 
// Instanciation de la classe dérivée
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',12);

$pdf->ln(5);
$txt = "P L A N N I N G  D E S  R E T R A I T E S  P O U R  5 a n s";
$pdf->Cell(272,10,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'C');
$pdf->ln(10);
$txt = "SIEGE : " . $selectedSiegeLabel;
$pdf->Cell(272,8,iconv('UTF-8', 'iso-8859-1//TRANSLIT',$txt),1,0,'C');
$pdf->SetFont('Times','',12);

/*
$pdf->ln(10);
$txt = "MATRIC.     NOM & POSTNOM       N° INSS     SIT.F       JrsP        SEXE        EQUI            GRADE";
$pdf->Cell(190,20,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'L');

$pdf->ln(6);
$txt = "MATRIC. NOM & POSTNOM";
$pdf->Cell(190,20,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'L',false);
/*
    $bareme = $db->prepare('SELECT * FROM bdd_paie.t_calcule_paie ORDER BY Matricule');
    $bareme ->execute();
    while($resbareme=$bareme->fetch()){
        $matric = $resbareme['Matricule'];
        $nom  = $resbareme['Nom'];
        $postnom = $resbareme['PostNom'];
        $matric = $resbareme['prenom'];
        $nom  = $resbareme['EquiG'];
        $postnom = $resbareme['N_inss'];

        $pdf->ln(6);
        $txt = $matric.' '.$nom;
        $pdf->Cell(190,20,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'L',false); 
       
                       
    }
*/
    $header = array('N°','SIEGE','MATRICULE','NOMS','SEXE','AGE',
        'D NAISS','D ENGAG','D SORTIE');
    $tableWidths = array(10, 40, 23, 63, 12, 36, 25, 25, 38);
    $genres = array(
        'F' => array('label' => 'FEMMES', 'data' => array(), 'compt' => 0),
        'M' => array('label' => 'HOMMES', 'data' => array(), 'compt' => 0),
        'A' => array('label' => 'AUTRES / NON RENSEIGNES', 'data' => array(), 'compt' => 0)
    );
    // Data loading

    $sqlPlanningRetraite = "SELECT 
    t_agent.matricule,
    t_agent.nom_ag,
    t_agent.postnom_ag,
    t_agent.prenom_ag,
    t_agent.sexe_ag,
    t_agent.dateNaiss_ag,
    t_agent.dateEngagemnt_ag,
    t_siege.code_sieg,
    t_siege.libelle_sieg,
    YEAR(CURDATE()) - YEAR(dateNaiss_ag) AS DiffDate,

    (65 - TIMESTAMPDIFF(YEAR, t_agent.dateNaiss_ag, CURDATE())) AS ResultatCalcul,
    CONCAT(
        FLOOR(TIMESTAMPDIFF(MONTH, t_agent.dateNaiss_ag, CURDATE()) / 12), 'ans ',
    MOD(TIMESTAMPDIFF(MONTH, t_agent.dateNaiss_ag, CURDATE()), 12), 'mois ')AS AgeActuel,
    CONCAT(DAY(t_agent.dateNaiss_ag), '/', MONTH(t_agent.dateNaiss_ag)) AS DateSortie_retraite
FROM 
    bdd_paie.t_agent 
INNER JOIN 
    bdd_paie.detail_agent_siege ON detail_agent_siege.agent_ID = t_agent.matricule
INNER JOIN 
    bdd_paie.t_siege ON t_siege.code_sieg = detail_agent_siege.siege_ID
WHERE 
    TIMESTAMPDIFF(YEAR, t_agent.dateNaiss_ag, CURDATE()) > 59 
    AND t_agent.activiter_ID = '01'";
    if ($selectedSiege !== '') {
        $sqlPlanningRetraite .= "
    AND detail_agent_siege.siege_ID = :siege
    AND detail_agent_siege.statut_ID = 'act'";
    }
    $sqlPlanningRetraite .= " ORDER BY t_agent.sexe_ag, t_siege.code_sieg, t_agent.nom_ag";
        $reqPlanningRetraite = $db->prepare($sqlPlanningRetraite);
        if ($selectedSiege !== '') {
            $reqPlanningRetraite->bindValue(':siege', $selectedSiege);
        }
        $reqPlanningRetraite ->execute();
        while($resPlanningRetraite=$reqPlanningRetraite->fetch()){
            $siege = $resPlanningRetraite['libelle_sieg'];
            $matric = $resPlanningRetraite['matricule'];
            $noms = $resPlanningRetraite['nom_ag'].' '.$resPlanningRetraite['postnom_ag'].' '.$resPlanningRetraite['prenom_ag'];
            $sexe = $resPlanningRetraite['sexe_ag'];
            $genreKey = strtoupper(trim($sexe));
            if($genreKey != 'F' && $genreKey != 'M'){
                $genreKey = 'A';
            }
            $dateNaiss = $resPlanningRetraite['dateNaiss_ag'];
            $dateEng = $resPlanningRetraite['dateEngagemnt_ag'];
            if($resPlanningRetraite['DiffDate'] == 65){
                $dateSortie = $resPlanningRetraite['DateSortie_retraite'].'/'.date('Y');
            }elseif($resPlanningRetraite['DiffDate'] == 64){
                $dateSortie = $resPlanningRetraite['DateSortie_retraite'].'/'.(date('Y')+1);
            }elseif($resPlanningRetraite['DiffDate'] == 63){
                $dateSortie = $resPlanningRetraite['DateSortie_retraite'].'/'.(date('Y')+2);
            }elseif($resPlanningRetraite['DiffDate'] == 62){
                $dateSortie = $resPlanningRetraite['DateSortie_retraite'].'/'.(date('Y')+3);
            }elseif($resPlanningRetraite['DiffDate'] == 61){
                $dateSortie = $resPlanningRetraite['DateSortie_retraite'].'/'.(date('Y')+4);
            }elseif($resPlanningRetraite['DiffDate'] == 60){
                $dateSortie = $resPlanningRetraite['DateSortie_retraite'].'/'.(date('Y')+5);
            }elseif($resPlanningRetraite['DiffDate'] >=66){
                $dateSortie = $resPlanningRetraite['ResultatCalcul']."ans";
            }
            
            $age = $resPlanningRetraite['AgeActuel'];
            $genres[$genreKey]['compt']++;
        
        $genres[$genreKey]['data'][] = array($genres[$genreKey]['compt'],$siege,$matric,$noms,$sexe,$age,$dateNaiss,$dateEng,$dateSortie);
          
    }
   

$pdf->SetFont('Arial','',9);
$pdf->ln(15);
$genreImprime = 0;
foreach($genres as $genre){
    if(count($genre['data']) == 0){
        continue;
    }

    if($genreImprime > 0){
        $pdf->ln(8);
    }

    $pdf->GenreTitle($genre['label'].' : '.count($genre['data']).' agent(s)');
    $pdf->BasicTable($header,$genre['data'],$tableWidths);
    $genreImprime++;
}

if($genreImprime == 0){
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(272,8,iconv('UTF-8', 'iso-8859-1//TRANSLIT', 'Aucun agent a imprimer.'),1,1,'C');
}

$pdf->ln(15);
$txt = "Fait à Kinshasa, Le ". date('d-m-Y');
$pdf->SetFont('Arial','',11);
$pdf->Cell(270,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C'); $pdf->ln(8);
$txt = "KASONGO NGOY David";
$pdf->SetFont('Arial','B',12);
$pdf->Cell(270,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C');

$pdf->Output();
?>
