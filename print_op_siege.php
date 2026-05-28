<?php

require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

$periodeGet = $_GET['periode'];

class PDF extends FPDF
{
// En-tête
function Header()
{
    // Logo
    $this->Image('img/Logo CADECO1.jpg',10,6,18,20);
    $this->Image('img/Logo CADECO1.jpg',182,6,18,20);
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    // Décalage à droite
    $this->Cell(80);
    // Titre
    $this->Cell(30,3,'CAISSE GENERALE D\'EPARGNE DU CONGO',0,0,'C');
    // Saut de ligne
    $this->Ln(5);
    $this->Cell(80);
    $this->SetFont('Arial','B',12);
    $this->Cell(30,3,iconv('UTF-8', 'iso-8859-1','Société-Anonyme-Unipersonnelle'),0,0,'C');

    // Saut de ligne
    $this->Ln(6);
    $this->Cell(80);
    $this->SetFont('Arial','B',15);
    $this->Cell(30,3,iconv('UTF-8', 'iso-8859-1','CADECO SAU'),0,0,'C');

    // Saut de ligne
    $this->Ln(6);
    $this->Cell(80);
    $this->SetFont('Arial','B',12);
    $this->Cell(30,3,iconv('UTF-8', 'iso-8859-1','38.Av Cadeco Kinshasa/Gombe'),0,0,'C');

    // Saut de ligne
    $this->Ln(5);
    $this->Cell(80);
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
        return $this->GetStringWidth($col) +3; // Ajouter une marge
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
        $this->SetFont('Arial','B',10);
        $this->Cell($widths[$index], 7, iconv('UTF-8', 'iso-8859-1',$col), 1,0,'',true);
    }
    $this->Ln();

    // Données
    foreach($data as $row) {
        foreach($row as $index => $col) {
            $this->SetFont('Arial','',8);
            $this->Cell($widths[$index], 7,$col, 1);
        }
        $this->Ln();
    }
    }

    function header_data($periode,$siege,$lib_siege){
        $this->SetFont('Times','B',14);

        $this->ln(3);
        //$this->SetTextColor(25,50,190);
        $txt = "O R D R E  D E  P A I E M E N T :  S A L A I R E   D U 25/$periode";
        $this->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C');

        $this->ln(6);
        $txt = "S I E G E  :  $siege $lib_siege";
        $this->Cell(190,20,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'L',false);

        $this->ln(15);
        
    }

} 
// Instanciation de la classe dérivée
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
/*
$pdf->SetFont('Times','B',14);

$pdf->ln(5);
$txt = "O R D R E  D E  P A I E M E N T :  S A L A I R E   D U 25";
$pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'C');
*/
    $header = array('EQU','MATRIC','NOMS','COMPTE','A PAYER','SIGN.');
    $compt = 1;
    $current_siege = null;$x=1;
    // Data loading
    $reqGet = $db->prepare("SELECT * FROM bdd_paie.t_paie WHERE codeEiPaie = '999' AND periode='$periodeGet' ORDER BY codesiege, Matricule");
    $reqGet ->execute();
    while($row=$reqGet->fetch()){
        $matric = $row['Matricule'];
        $nomComplet = $row['Nom'].' '.$row['PostNom'];
        $inss = $row['N_inss'];
        $sexe = $row['sexe'];
        $etatCiv = $row['etat_civil'];
        $sitFam = $row['sit_famille'];
        $grad = $row['grade'];
        $codePaie = $row['codeEiPaie'];
        $lib_codePaie = $row['libelle_el_paie'];
        $montant_payer = $row['montant_payer'];
        $montant_a_retenir = $row['montant_a_retenir'];
        $montant_imposa = $row['montant_imposa'];
        $periode = $row['periode'];
        $siege = $row['codesiege'];
        $lib_siege = $row['libelle_siege'];
        $n_compte = $row['numCompt'];
        $jrsPrester = 26;
        $eqComp = $row['EquiG'];
        $autre = $inss.' '.$sexe.' '.$grad;
        
        if ($current_siege !== null && $current_siege !== $row['codesiege']) {
            if($x==1){
                $pdf->header_data($row['periode'], $row['codesiege'], $row['libelle_siege']);
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
            $pdf->header_data($row['periode'], $row['codesiege'], $row['libelle_siege']); // Ajoutez l'en-tête de la nouvelle page
        }
        // Ajoutez les données à la table actuelle
        $data[] = array($row['EquiG'], $row['Matricule'], $row['Nom'].' '.$row['PostNom'], $row['numCompt'], $row['montant_payer'], $row['codesiege']);
        $current_siege = $row['codesiege'];
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