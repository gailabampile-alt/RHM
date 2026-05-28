<?php

require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');
/*
$getPeriode = $_GET['periode'];
$getSiege = $_GET['siege'];
$getDevise = $_GET['devise'];
*/
$total= 0;
$total_solde = 0;

class PDF extends FPDF
{
// En-tête
function Header()
{
    // Logo
    $this->Image('img/Logo CADECO1.jpg',10,6,18,20);
    $this->Image('img/Logo CADECO1.jpg',262,6,18,20);
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    // Décalage à droite
    $this->Cell(80);
    // Titre
    $this->Cell(100,3,'CAISSE GENERALE D\'EPARGNE DU CONGO',0,0,'C');
    // Saut de ligne
    $this->Ln(5);
    $this->Cell(80);
    $this->SetFont('Arial','B',12);
    $this->Cell(100,3,iconv('UTF-8', 'iso-8859-1','Société-Anonyme-Unipersonnelle'),0,0,'C');

    // Saut de ligne
    $this->Ln(6);
    $this->Cell(80);
    $this->SetFont('Arial','B',15);
    $this->Cell(100,3,iconv('UTF-8', 'iso-8859-1','CADECO SAU'),0,0,'C');

    // Saut de ligne
    $this->Ln(6);
    $this->Cell(80);
    $this->SetFont('Arial','B',12);
    $this->Cell(100,3,iconv('UTF-8', 'iso-8859-1','38.Av Cadeco Kinshasa/Gombe'),0,0,'C');

    // Saut de ligne
    $this->Ln(5);
    $this->Cell(80);
    $this->SetFont('Arial','B',12);
    $this->Cell(100,3,iconv('UTF-8', 'iso-8859-1',
    '_____________________________________________________________________________________________________'),0,2,'C');
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
        return $this->GetStringWidth($col) + 15; // Ajouter une marge
    }, $header);

    foreach($data as $row) {
        foreach($row as $index => $col) {
            $width = $this->GetStringWidth($col) + 20; // Ajouter une marge
            if ($width > $widths[$index]) {
                $widths[$index] = $width;
            }
        }
    }

    // En-tête
    foreach($header as $index => $col) {
        $this->SetFillColor(200, 220, 255);
        $this->SetFont('Arial','B',12);
        $this->Cell($widths[$index], 7, iconv('UTF-8', 'iso-8859-1',$col), 1,0,'',true);
    }
    $this->Ln();

    // Données
    foreach($data as $row) {
        foreach($row as $index => $col) {
            $this->SetFont('Arial','',11);
            $this->Cell($widths[$index], 7, iconv('UTF-8', 'iso-8859-1',$col), 1);
        }
        $this->Ln();
    }
    }

} 
// Instanciation de la classe dérivée
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','B',14);

$pdf->ln(5);
$txt = "RETENU INPP PAR AGENTS";
$pdf->Cell(270,10,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'C');
$pdf->ln(0);
//$txt = "DEVISE : $getDevise";
//$pdf->Cell(270,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'R');
/*
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
    $header = array('N','MATRICULE','NOMS','CODE','LIBELLE','PERIODE','A RETENIR');
    $compt = 1;
    // Data loading
    $bareme = $db->prepare("SELECT * FROM bdd_paie.v_inpp_allep
    UNION ALL
    SELECT * FROM bdd_paie.v_inpp ORDER BY Matricule");//INNER JOIN bdd_paie.t_statut ON t_bareme.statut_ID=t_statut.code_st
    $bareme ->execute();
    while($resbareme=$bareme->fetch()){
        $matric = $resbareme['Matricule'];
       //$siege  = $resbareme['code_sieg'];
        $codepaie = $resbareme['codeElPaie'];
        $noms = $resbareme['Nom'].' '.$resbareme['Postnom'].' '.$resbareme['Prenom'];
        $montantPayer = $resbareme['montant_payer'];
        $lib_El_paie =$resbareme['libelle_el_paie'];
        $periode = $resbareme['periode'];
        //$statut = ($resbareme['statut_ID'] == 'act') ? 'Activer' : 'Désactiver';
        
        $data[] = array($compt,$matric,$noms,$codepaie,$lib_El_paie,$periode,$montantPayer); 
             
        ++$compt;  
        $total += $montantPayer;
        //$total_solde += $solde;     
    }
   

$pdf->SetFont('Arial','',9);
$pdf->ln(15);
$pdf->BasicTable($header,$data);


$pdf->SetFillColor(200, 220, 255);
$total = number_format($total, 4, ',', ' ');
$txt = "TOTAL RETENU : $total";
$pdf->Cell(271.6,10,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'R',true);


$pdf->ln(15);
$txt = "Fait à Kinshasa, Le ". date('d-m-Y');
$pdf->SetFont('Arial','',11);
$pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C'); $pdf->ln(8);
$txt = "LAMA LUTSHIMA BIENVIEN";
$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C');        

$pdf->Output();
?>