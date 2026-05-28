<?php

require('fpdf.php');


class PDF extends FPDF
{
// Chargement des données
function LoadData($file)
{
    // Lecture des lignes du fichier
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}


// Tableau coloré
function FancyTable($header, $data)
{
    // Couleurs, épaisseur du trait et police grasse
    $this->SetFillColor(255,0,0);
    //$this->SetTextColor(255);
    //$this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('Arial','','12');
    // En-tête
    //$w = GetStringWidth;
    // Logo
    $this->Image('Logo CADECO.jpg',10,6,30);
    // Police Arial gras 15
    $this->SetFont('Arial','',12);
    // Décalage à droite
    $this->Cell(20);
    // Titre
    $this->Cell(0,0,'CAISSE GENERALE D\'EPARGNE DU CONGO',0,0,'C');
    $this->Ln(5);
    $this->Cell(20);

    $this->Cell(0,0,'SOCIETE ANONYME UNIPERSONNELLE',0,0,'C');
     $this->Ln(5);
    $this->Cell(20);

    $this->Cell(0,0,'CADECO SAU ',0,0,'C');
    $this->Ln(20);
    $this->Cell(80);
	$this->SetFont('Arial','',15);
    $this->Cell(120,10,'LISTE DES Agents ',1,0,'C');

    // Saut de ligne
    $this->Ln(20);
    $this->SetFont('Arial','',11);
    $w = array(20,80,10,55,60);
    for($i=0;$i<count($header);$i++)
      $this->Cell($w[$i],6,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauration des couleurs et de la police
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Données


    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
        $this->Cell($w[3],6,$row[3],'LR',0,'L',$fill);
       // $this->Cell($w[4],6,$row[4],'LR',0,'L',$fill);
        $this->Cell($w[4],6,$row[5],'LR',0,'L',$fill);
       // $this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T');
}
}



$pdf = new PDF();
// Titres des colonnes

$header = array('Matricule', 'Nom','Grade','Siege','Direction');
//Chargement des données
$data = $pdf->LoadData('agent.txt');
$pdf->SetFont('Arial','',10);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();


