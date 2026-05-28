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
    $this->Image('img/Logo CADECO1.jpg',180,6,18,20);
    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    // Décalage à droite
    $this->Cell(30);
    // Titre
    $this->Cell(125,3,'CAISSE GENERALE D\'EPARGNE DU CONGO',0,0,'C');
    // Saut de ligne
    $this->Ln(5);
    $this->Cell(30);
    $this->SetFont('Arial','B',12);
    $this->Cell(125,3,iconv('UTF-8', 'iso-8859-1','Société-Anonyme-Unipersonnelle'),0,0,'C');

    // Saut de ligne
    $this->Ln(6);
    $this->Cell(30);
    $this->SetFont('Arial','B',15);
    $this->Cell(125,3,iconv('UTF-8', 'iso-8859-1','CADECO SAU'),0,0,'C');

    // Saut de ligne
    $this->Ln(6);
    $this->Cell(30);
    $this->SetFont('Arial','B',12);
    $this->Cell(125,3,iconv('UTF-8', 'iso-8859-1','38.Av Cadeco Kinshasa/Gombe'),0,0,'C');

    // Saut de ligne
    $this->Ln(5);
    $this->Cell(30);
    $this->SetFont('Arial','B',12);
    $this->Cell(135,3,iconv('UTF-8', 'iso-8859-1',
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
        return $this->GetStringWidth($col)+18; // Ajouter une marge
    }, $header);

    foreach($data as $row) {
        foreach($row as $index => $col) {
            $width = $this->GetStringWidth($col)+33; // Ajouter une marge
            if ($width > $widths[$index]) {
                $widths[$index] = $width;
            }
        }
    }

    // En-tête
    foreach($header as $index => $col) {
        $this->SetFillColor(200, 220, 255);
        $this->SetFont('Arial','B',11);
        $this->Cell($widths[$index], 7, iconv('UTF-8', 'iso-8859-1',$col), 1,0,'L',true);
    }
    $this->Ln();

    // Données
    foreach($data as $row) {
        foreach($row as $index => $col) {
            $this->SetFont('Arial','',10);
            $this->Cell($widths[$index], 7,$col, 1,0,'L');
        }
        $this->Ln();
    }
    }

    function header_data($nom,$matric){
        $this->SetFont('Times','B',13);

        $this->ln();
        //$this->SetTextColor(25,50,190);
        $txt = "L I S T E  D E  D O C U M E N T S  D E S  A G E N T S";
        $this->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C',false);

        $this->ln(8);
        $txt = "$nom | $matric";
        $this->Cell(120,20,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'L',false);

        $this->ln(5);
        
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

    $header = array('N°','REFERENCE', 'LIBELLE');
    $compt = 1;
    $current_matric = null;
    $x=1;

    $reqInfoAgent = $db->prepare("SELECT 
    t_doc_agent.id_doc,t_doc_agent.id_typedoc,t_doc_agent.matricule,t_doc_agent.ref_doc,
    t_doc_agent.observation,t_doc_agent.document,t_doc_agent.document_byte,t_doc_agent.creerPar,
    t_doc_agent.datecreat,t_doc_agent.dateModif,t_doc_agent.modifierPar,
    t_agent.nom_ag,t_agent.postnom_ag,t_agent.prenom_ag,t_type_doc.libelle_typedoc
    FROM bdd_paie.t_doc_agent
    INNER JOIN bdd_paie.t_agent ON  t_doc_agent.matricule = t_agent.matricule
    INNER JOIN bdd_paie.t_type_doc ON t_type_doc.id_typedoc = t_doc_agent.id_typedoc ORDER BY matricule");
        $reqInfoAgent ->execute();
        $last_matric = NULL;
    while($row = $reqInfoAgent->fetch())
    {

                $nRef = $row['ref_doc'];
                $matric = $row['matricule'];
                $noms = $row['nom_ag'].' '.$row['prenom_ag'].' '.$row['prenom_ag'];
                $lib_doc = $row['libelle_typedoc'];
                $document = $row['document'];
                //$concat = $row['nom_ag'].' '.$row['postnom_ag'].' '.$row['prenom_ag'];
        if ($current_matric !== null && $current_matric !== $row['matricule']) {
            if($x==1){
                $pdf->header_data($row['matricule'],$noms);
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
            $concat = $row['nom_ag'].' '.$row['postnom_ag'].' '.$row['prenom_ag'];
            $pdf->header_data($row['matricule'],$concat); // Ajoutez l'en-tête de la nouvelle page
        }
        // Ajoutez les données à la table actuelle
        $data[] = array($compt++,$row['ref_doc'], $row['libelle_typedoc']);
        $current_matric = $row['matricule'];
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