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
    $this->Image('img/Logo CADECO1.jpg',256,6,18,20);
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
        return $this->GetStringWidth($col) + 20; // Ajouter une marge
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
            $this->SetFont('Arial','',10);
            $this->Cell($widths[$index], 7, $col, 1);
        }
        $this->Ln();
    }
    }

} 
// Instanciation de la classe dérivée
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','B',12);

$pdf->ln(5);
$txt = "IDENTIFICATIONS VEHICULES DES AGENTS";
$pdf->Cell(272,10,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'C');
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
    $header = array('MATRICULE', 'NOM AGENT', 'IMMATRICULATION','MODELE','NUM CHASSIS','CARTE ROSE');
    $compt = 1;
    // Data loading
    $reqInfoVehicule = $db->prepare('SELECT * FROM bdd_paie.t_vehicule
                        INNER JOIN bdd_paie.t_agent ON t_vehicule.agent_ID = t_agent.matricule');
                        $reqInfoVehicule ->execute();
                        while($resInfoVehicule=$reqInfoVehicule->fetch()){
                            $code_vehic = $resInfoVehicule['id_veh'];
                            $matricule = $resInfoVehicule['matricule'];
                            $nomComplet = $resInfoVehicule['nom_ag'].' '.$resInfoVehicule['postnom_ag'].' '.$resInfoVehicule['prenom_ag'];
                            $modele = $resInfoVehicule['modele'];
                            $numChassis = $resInfoVehicule['numChassis'];
                            $numPermis = $resInfoVehicule['numPermis'];
                            $numCarteRose = $resInfoVehicule['numCarteRose'];
                            $immatriculation = $resInfoVehicule['immatriculation'];
                            $statut = $resInfoVehicule['statut_ID'];
        
        $data[] = array($matricule,$nomComplet,$immatriculation,$modele,$numPermis,$numCarteRose);

         ++$compt;       
                
    }
   

$pdf->SetFont('Arial','',9);
$pdf->ln(15);
$pdf->BasicTable($header,$data);   

$pdf->ln(15);
$txt = "Fait à Kinshasa, Le ". date('d-m-Y');
$pdf->SetFont('Arial','',11);
$pdf->Cell(270,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C'); $pdf->ln(8);
$txt = "LAMA LUTSHIMA BIENVIEN";
$pdf->SetFont('Arial','B',12);
$pdf->Cell(270,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C');

$pdf->Output();
?>