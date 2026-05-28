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
        $this->Image('img/Logo CADECO1.jpg',8,6,18,20);
        $this->Image('img/Logo CADECO1.jpg',186,6,18,20);

    // Police Arial gras 15
    $this->SetFont('Arial','B',15);
    // Décalage à droite
    $this->Cell(80);
    // Titre
    $this->Cell(30,3,'CAISSE GENERALE D\'EPARGNE DU CONGO',0,0,'C');
    // Saut de ligne
    $this->Ln(5);
    $this->Cell(80);
    $this->SetFont('Arial','BI',10);
    $this->Cell(30,3,iconv('UTF-8', 'iso-8859-1','Société-Anonyme-Unipersonnelle'),0,0,'C');

    // Saut de ligne
    $this->Ln(6);
    $this->Cell(80);
    $this->SetFont('Arial','B',14);
    $this->Cell(30,3,iconv('UTF-8', 'iso-8859-1','CADECO SAU'),0,0,'C');

    // Saut de ligne
    $this->Ln(6);
    $this->Cell(80);
    $this->SetFont('Arial','B',10);
    $this->Cell(30,3,iconv('UTF-8', 'iso-8859-1','38.Av Cadeco Kinshasa/Gombe'),0,0,'C');

    $this->Ln(5);
    // Ligne de séparation
    $this->Cell(190,1,'',1,2,'C');
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

    /*function header_data($siege,$lib_siege){
        $this->SetFont('Times','B',14);

        $this->ln(3);
        //$this->SetTextColor(25,50,190);
        $txt = "L I S T E    D E S    A G E N T S    A C T I F S    A    L A    D A T E    D U  ".date('d/m/Y');
        $this->Cell(260,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C',false);

        $this->ln(6);
        $txt = "S I E G E  :  $siege $lib_siege";
        $this->Cell(190,20,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'L',false);

        $this->ln(15);
        
    }*/
    
    function header_data($siege, $lib_siege)
    {
        // En-tête spécifique au siège
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,"SIEGE : $siege ($lib_siege)", 0, 1, 'L');
        $this->Ln(5);
    }

}



// Instanciation de la classe dérivée
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();

// Requête pour récupérer les informations des agents
$reqInfoAgent = $db->prepare("SELECT * FROM bdd_paie.v_agent_seiegact WHERE activiter_ID = '01' ORDER BY code_sieg;");
$reqInfoAgent->execute();

// En-tête du tableau
$header = array('N°','CODE','MATRICULE', 'NOM COMPLET', 'SEXE', 'DATE NAIS', 'DATE ENGAG');


$data = [];
$compt = 1;
$current_siege = null;

while ($row = $reqInfoAgent->fetch()) {
    if ($current_siege !== $row['code_sieg']) {
        // Si le tableau de données n'est pas vide, terminer le tableau actuel
        if (!empty($data)) {
            $pdf->BasicTable($header, $data);
            $pdf->ln(15);
            $pdf->ln(15);
            $txt = "Fait à Kinshasa, Le ". date('d-m-Y');
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C'); $pdf->ln(8);
            $txt = "Blévin LAMA LUTSHIMA";
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C');
        }

        // Nouvelle page et nouvel en-tête
        $pdf->AddPage();
        $pdf->header_data($row['code_sieg'], $row['libelle_sieg']);
        $data = []; // Réinitialiser le tableau de données
        $compt = 1; // Réinitialiser le compteur de lignes
        $current_siege = $row['code_sieg'];
    }

    // Ajouter une ligne au tableau
    $data[] = array($compt++, $row['code_sieg'], $row['matricule'], $row['nom'], $row['sexe_ag'], $row['dateNaiss_ag'], $row['dateEngagemnt_ag']);
    
}

    // Traiter le dernier tableau
    if (!empty($data)) {
        $pdf->BasicTable($header, $data);
    }
    // Pied de page et sortie du PDF
    $pdf->SetFont('arial','',9);
    $pdf->ln(15);
    $txt = "Fait à Kinshasa, Le ". date('d-m-Y');
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C'); $pdf->ln(8);
    $txt = "Blévin LAMA LUTSHIMA";
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C');        

    $pdf->Output();

?>