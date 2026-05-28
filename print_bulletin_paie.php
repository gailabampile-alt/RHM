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
    '_________________________________________________________________________'),0,0,'C');
    
    $this->Ln(7);
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
        $widths = array_map(function($col) {
            return $this->GetStringWidth($col) + 3; // Ajouter une marge
        }, $header);
    
        foreach($data as $row) {
            foreach($row as $index => $col) {
                $width = $this->GetStringWidth($col) + 12; // Ajouter une marge
                if ($width > $widths[$index]) {
                    $widths[$index] = $width;
                }
            }
        }
    
        // En-tête
        foreach($header as $index => $col) {
            $this->SetFillColor(200, 220, 255);
            $this->SetFont('Arial','B',9);
            $this->Cell($widths[$index], 7, iconv('UTF-8', 'iso-8859-1',$col), 1,0,'',true);
        }
        $this->Ln();
    
        // Données
        foreach($data as $row) {
            foreach($row as $index => $col) {
                $this->SetFont('Arial','',9);
                $this->Cell($widths[$index], 7, $col, 'LR',0);
                //$this->Cell($widths[$index], 7, "", 'LRB',0);
            }
            
            $this->Ln();
        }
    }

    function header_data($siege,$periode,$matric,$nomComplet,$nCnss,$sitFam,$grade,$jrsP,$sexe,$equi){
        $this->SetFont('Times','',10);

        

        $this->ln(5);
        $txt = "SIEGE : $siege    BULLETIN DE PAIE MOIS DE : $periode";
        $this->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'C');

        $this->ln(10);
        $txt = "MATRIC : $matric | NOM & POSTNOM : $nomComplet | N° INSS : $nCnss  | SIT.F : $sitFam";
        $this->Cell(190,20,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'L');

        $this->ln(6);
        $txt = "GRADE : $grade | JrsP : $jrsP  | SEXE : $sexe  | EQUI : $equi";
        $this->Cell(190,20,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'L',false);

        $this->ln(15);
        
    }

} 
// Instanciation de la classe dérivée
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','',11);
/*
$pdf->ln(5);
$txt = "SIEGE : 0000    BULLETIN DE PAIE MOIS DE : DEC 2023";
$pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'C');

$pdf->ln(10);
$txt = "MATRIC.     NOM & POSTNOM       N° INSS     SIT.F       JrsP        SEXE        EQUI            GRADE";
$pdf->Cell(190,20,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'L');

$pdf->ln(6);
$txt = "MATRIC. NOM & POSTNOM";
$pdf->Cell(190,20,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'L',false);

$pdf->ln(15);
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
    $pdf->SetFont('Arial','',9);
    $header = array('CODE', 'LIBELLE', 'MONTANT A PAYER','MONTANT A RETENIR','MONTANT IMPOSA');
    // Data loading
    $result = $db->prepare('SELECT * FROM bdd_paie.t_paie ORDER BY Matricule');
    $result ->execute();
    $last_matric = NULL;
    $data = array();
    $test = 1;
    
    while($row = $result->fetch())
    {
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
        $jrsPrester = 26;
        $eqComp = $row['EquiG'];
        $autre = $inss.' '.$sexe.' '.$grad;
        
        if ($last_matric !== $row['Matricule'] && $last_matric !== NULL) {
            // Saut de page au changement d'ID $pdf->AddPage();
            if ($test == 1) {
                $pdf->header_data($siege,$periode,$matric,$nomComplet,$inss,$sitFam,$grad,$jrsPrester,$sexe,$eqComp);
                $test = 2;
            }
            //$pdf->header_data('Siège',$periode,$matric,$nomComplet,$inss,$sitFam,$grad,$jrsPrester,$sexe,$eqComp);
            $pdf->BasicTable($header,$data); // Imprimez les données avant de passer à la page suivante
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(190,20,iconv('UTF-8', 'iso-8859-1','KIBONGE NGOY'),0,0,'R',false);
            
            $data = array();// Réinitialisez les données pour la nouvelle page
            
            if ($result->fetch()) { // Vérifiez si vous êtes à la dernière itération de la boucle
                $pdf->AddPage();
                if ($test != 1) {
                    $pdf->header_data($siege,$periode,$matric,$nomComplet,$inss,$sitFam,$grad,$jrsPrester,$sexe,$eqComp);
                }
                //$pdf->header_data($siege,$periode,$matric,$nomComplet,$inss,$sitFam,$grad,$jrsPrester,$sexe,$eqComp);
            }
        }
        
        
        $data[] = array($codePaie,$lib_codePaie,$montant_payer,$montant_a_retenir,$montant_imposa);
        $last_matric = $row['Matricule'];        
    }
    
    
    $pdf->ln(15);
    $pdf->BasicTable($header,$data); // Imprimez les données de la dernière page
    
    $pdf->Output();
?>