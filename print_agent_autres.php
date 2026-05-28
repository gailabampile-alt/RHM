<?php

require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

class PDF extends FPDF
{
// En-tête
function Header()
{
    // Logo
    $this->Image('img/Logo CADECO1.jpg',10,6,18,20);
    $this->Image('img/Logo CADECO1.jpg',265,6,18,20);
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    // Décalage à droite
    $this->Cell(125);
    // Titre
    $this->Cell(30,3,'CAISSE GENERALE D\'EPARGNE DU CONGO',0,0,'C');
    // Saut de ligne
    $this->Ln(5);
    $this->Cell(125);
    $this->SetFont('Arial','B',12);
    $this->Cell(30,3,iconv('UTF-8', 'iso-8859-1','Société-Anonyme-Unipersonnelle'),0,0,'C');

    // Saut de ligne
    $this->Ln(6);
    $this->Cell(125);
    $this->SetFont('Arial','B',15);
    $this->Cell(30,3,iconv('UTF-8', 'iso-8859-1','CADECO SAU'),0,0,'C');

    // Saut de ligne
    $this->Ln(6);
    $this->Cell(125);
    $this->SetFont('Arial','B',12);
    $this->Cell(30,3,iconv('UTF-8', 'iso-8859-1','38.Av Cadeco Kinshasa/Gombe'),0,0,'C');

    // Saut de ligne
    $this->Ln(5);
    $this->Cell(125);
    $this->SetFont('Arial','B',12);
    $this->Cell(30,3,iconv('UTF-8', 'iso-8859-1',
    '_________________________________________________________________________'),0,2,'C');
    $this->Ln(8);
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

function BasicTable($header, $data)
    {
               // Calculer la largeur maximale pour chaque colonne
    $widths = array_map(function($col) {
        return $this->GetStringWidth($col); // Ajouter une marge
    }, $header);

    foreach($data as $row) {
        foreach($row as $index => $col) {
            $width = $this->GetStringWidth($col); // Ajouter une marge
            if ($width > $widths[$index]) {
                $widths[$index] = $width;
            }
        }
    }

    // En-tête
    foreach($header as $index => $col) {
        $this->SetFillColor(200, 220, 255);
        $this->SetFont('Arial','B',9);
        $this->Cell($widths[$index], 7, iconv('UTF-8', 'iso-8859-1',$col), 1,0,'C',true);
    }
    $this->Ln();

    // Données
    foreach($data as $row) {
        foreach($row as $index => $col) {
            $this->SetFont('Arial','',8);
            $this->Cell($widths[$index], 7,$col, 1,0,'L');
        }
        $this->Ln();
    }
    }

    function header_data($siege,$lib_siege){
        $this->SetFont('Times','B',13);

        $this->ln(3);
        //$this->SetTextColor(25,50,190);
        $txt = "L I S T E    D E S    A G E N T S    A    L A    D A T E    D U  ".date('d/m/Y');
        $this->Cell(260,10,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'C',false);

        $this->ln(6);
        $txt = "S I E G E  :  $siege $lib_siege";
        $this->Cell(190,20,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'L',false);

        $this->ln(15);
        
    }

} 
// Instanciation de la classe dérivée
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
/*
$pdf->SetFont('Times','B',14);

$pdf->ln(5);
$txt = "O R D R E  D E  P A I E M E N T :  S A L A I R E   D U 25";
$pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'C');
*/

    $header = array('N°','CODE','SIEGE','MATRICULE',
        'NOM COMPLET','SEXE','DATE NAIS','DATE ENGAG');
    $compt = 1;
    $current_siege = null;$x=1;

    $reqInfoAgent = $db->prepare("SELECT * FROM bdd_paie.v_agent_seiegact
    WHERE activiter_ID <> '01' AND activiter_ID <> '02' ORDER BY code_sieg;");
        $reqInfoAgent ->execute();
        $last_matric = NULL;
    while($row = $reqInfoAgent->fetch())
    {
                //$matric = $resInfoAgent['agent_ID'];
                $cod_sieg = $row['code_sieg'];
                //$type_sieg = $row['libelle_typSieg'];
                $lib_sieg = $row['libelle_sieg'];
                $matric = $row['matricule'];
                $noms = $row['nom'];
                $sexe = $row['sexe_ag'];
                $activiter = $row['activiter_ID'];
                $date_nais = $row['dateNaiss_ag'];
                $date_eng = $row['dateEngagemnt_ag'];
        
        if ($current_siege !== null && $current_siege !== $row['code_sieg']) {
            if($x==1){
                $pdf->header_data($row['code_sieg'], $row['libelle_sieg']);
                $x = 2;
            }
            $pdf->BasicTable($header, $data); // Terminez la table actuelle
            $pdf->ln(15);
            $txt = "Fait à Kinshasa, Le ". date('d-m-Y');
            $pdf->SetFont('Arial','',11);
            $pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C'); $pdf->ln(8);
            $txt = "LAMA LUTSHIMA BIENVIEN";
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C');


            $data = array(); // Réinitialisez le tableau de données
            $pdf->AddPage(); // Commencez une nouvelle page
            $pdf->header_data($row['code_sieg'], $row['libelle_sieg']); // Ajoutez l'en-tête de la nouvelle page
        }
        // Ajoutez les données à la table actuelle
        $data[] = array($compt++,$row['code_sieg'], $row['libelle_sieg'],$row['matricule'], $row['nom'], $row['sexe_ag'],$row['dateNaiss_ag'], $row['dateEngagemnt_ag']);
        $current_siege = $row['code_sieg'];
        //$data[] = array($eqComp,$matric,$nomComplet,$n_compte,$montant_payer,$siege);      
        //++$compt;        
    }
   

$pdf->SetFont('Arial','',9);
$pdf->ln(15);
$pdf->BasicTable($header,$data);  
$pdf->ln(15);
$txt = "Fait à Kinshasa, Le ". date('d-m-Y');
$pdf->SetFont('Arial','',11);
$pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C'); $pdf->ln(8);
$txt = "LAMA LUTSHIMA BIENVIEN";
$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C');        

$pdf->Output();
?>