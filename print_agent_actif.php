<?php
require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

class PDF extends FPDF
{
    public $angle = 0;
    public $showHeader = true;

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
        if ($this->showHeader) {
            $this->Watermark();
            $this->SetFillColor(30,60,120);
            $this->Rect(0,0,210,25,"F");
            $this->Image('img/Logo CADECO1.jpg',10,4,18);
            $this->SetFont('Arial','B',14);
            $this->SetTextColor(255,255,255);
            $this->SetXY(35,5);
            $this->Cell(140,6,"CAISSE GENERALE D'EPARGNE DU CONGO",0,1,'C');
            $this->Cell(190, 5, "C A D E C O", 0, 1, 'C');
            $this->SetFont('Arial','',10);
            $this->Cell(190,4,iconv('UTF-8','ISO-8859-1//TRANSLIT', "Société Anonyme Unipersonnelle"),0, 1, 'C');
            $this->SetDrawColor(180,180,180);
            $this->Line(10,28,200,28);
            $this->Ln(12);
            $this->SetTextColor(0,0,0);
            $this->showHeader = false; // Désactiver après affichage
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
        $txt = "L I S T E    D E S    A G E N T S    A C T I V E S    A    L A    D A T E    D U  ".date('d/m/Y');
        $this->Cell(0,10,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'C',false);
        $this->Ln();
        $this->Cell(0,10,"SIEGE : $siege [ $lib_siege ]", 0, 1, 'L');
        $this->Ln(5);
    }

}



// Instanciation de la classe dérivée
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->showHeader = true; // Activer l'entête pour la première page

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
            $txt = "David KASONGO NGOY";
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C');
        }

        // Nouvelle page et nouvel en-tête
        $pdf->showHeader = true; // Activer l'entête pour la nouvelle page
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
    $txt = "David KASONGO NGOY ";
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),0,0,'C');        

    $pdf->Output();

?>