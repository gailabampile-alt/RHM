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
    $this->Ln(5);
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
        return $this->GetStringWidth($col) + 8; // Ajouter une marge
    }, $header);

    foreach($data as $row) {
        foreach($row as $index => $col) {
            $width = $this->GetStringWidth($col) + 13; // Ajouter une marge
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
            $this->SetFont('Arial','',9);
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

$pdf->SetFont('Times','',12);

$pdf->ln(5);
$txt = "L I S T E  D E S  C O N G E S  ";
$pdf->Cell(272,10,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'C');
$pdf->SetFont('Times','',12);


    $header = array('NOMS','TYPE DE CONGE','EXCERCICE',
        'NBRE JOUR','DATE DEBUT','DATE FIN');
    // Data loading

    $reqInfoAgent = $db->prepare("SELECT * FROM t_conge INNER JOIN bdd_paie.t_demandeconge  ON t_demandeconge.id_demande =t_conge.id_dem_conge 
    INNER JOIN bdd_paie.t_typconge ON t_typconge.id_type_conge=t_demandeconge.id_typeconge 
    INNER JOIN bdd_paie.t_agent ON t_agent.matricule=t_demandeconge.matricule WHERE statut= :statut");
        $reqInfoAgent ->bindValue(':statut','act');
        $reqInfoAgent ->execute();
        $last_matric = NULL;
    while($resInfoAgent = $reqInfoAgent->fetch())
    {
        $matric = $resInfoAgent['agent_ID'];
        $cod_sieg = $resInfoAgent['code_sieg'];
        //$type_sieg = $resInfoAgent['libelle_typSieg'];
        $lib_sieg = $resInfoAgent['libelle_sieg'];
        $matric = $resInfoAgent['matricule'];
        $noms = $resInfoAgent['nom_ag'].' '.$resInfoAgent['postnom_ag'].' '.$resInfoAgent['prenom_ag'];
        $sexe = $resInfoAgent['sexe_ag'];
        $activiter = $resInfoAgent['libelle_activ'];
        $date_nais = $resInfoAgent['dateNaiss_ag'];
        $date_eng = $resInfoAgent['dateEngagemnt_ag'];
        
        $data[] = array($cod_sieg,$lib_sieg,$matric,$noms,
                        $sexe,$date_nais,$date_eng);

                
                
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