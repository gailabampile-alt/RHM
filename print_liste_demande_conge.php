<?php

require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

$reqVerificationCodePaie = $db->prepare('SELECT * FROM bdd_paie.t_demandeconge INNER JOIN bdd_paie.t_typconge ON t_typconge.id_type_conge=t_demandeconge.id_typeconge INNER JOIN bdd_paie.t_agent ON t_agent.matricule=t_demandeconge.matricule where t_demandeconge.statut=:statut');
$reqVerificationCodePaie -> bindValue(':statut',"naprv");
$reqVerificationCodePaie ->execute();

if($reqVerificationCodePaie ->rowCount() == 0){
    $_SESSION['message']  = "Le codePaie : Pas de demande de Congé non traité!";
    $_SESSION['typeMsg']  = "danger";
    header('location:accueil.php?page=voir_demande');
    exit();

}else{

class PDF extends FPDF
{
    public $angle = 0;

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
    $this->Watermark();
    if ($this->PageNo() == 1) {
        $this->SetFillColor(30,60,120);
        $this->Rect(0,0,297,25,"F");
        $this->Image('img/Logo CADECO1.jpg',10,4,18);
        $this->SetFont('Arial','B',14);
        $this->SetTextColor(255,255,255);
        $this->SetXY(35,5);
        $this->Cell(150,6,"CAISSE GENERALE D'EPARGNE DU CONGO",0,1,'C');
        $this->Cell(205, 5, "C A D E C O", 0, 1, 'C');
        $this->SetFont('Arial','',10);
        $this->Cell(205,4,iconv('UTF-8','ISO-8859-1//TRANSLIT', "Société Anonyme Unipersonnelle"),0, 1, 'C');
        $this->SetDrawColor(180,180,180);
        $this->Line(10,28,287,28);
        $this->Ln(12);
        $this->SetTextColor(0,0,0);
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
        return $this->GetStringWidth($col) + 10; // Ajouter une marge
    }, $header);

    foreach($data as $row) {
        foreach($row as $index => $col) {
            $width = $this->GetStringWidth($col) + 28; // Ajouter une marge
            if ($width > $widths[$index]) {
                $widths[$index] = $width;
            }
        }
    }

    // En-tête
    foreach($header as $index => $col) {
        $this->SetFillColor(200, 220, 255);
        $this->SetFont('Arial','B',11);
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
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Times','B',14);

$pdf->ln(5);
$txt = "LISTE DES DEMANDE DE CONGES";
$pdf->Cell(190,10,iconv('UTF-8', 'iso-8859-1',$txt),1,0,'C');

    $header = array('NOMS','TYPE DE CONGE','EXCERCICE','NOMBRE DE JOUR');
    $compt = 1;
    // Data loading
    $reqGrade = $db->prepare('SELECT * FROM bdd_paie.t_demandeconge INNER JOIN bdd_paie.t_typconge ON t_typconge.id_type_conge=t_demandeconge.id_typeconge INNER JOIN bdd_paie.t_agent ON t_agent.matricule=t_demandeconge.matricule where t_demandeconge.statut=:statut');
    $reqGrade-> bindValue(':statut',"naprv");
    $reqGrade ->execute();
    while($resGrade=$reqGrade->fetch()){
        $excercice = $resGrade['excercice'];
        $nbrejr= $resGrade['nbrejr_solic'];
        $conge = $resGrade['libelle_conge'];
        $agent = $resGrade['nom_ag'].' '.$resGrade['postnom_ag'];
        $data[] = array($agent,$conge,$excercice,$nbrejr);      
        ++$compt;       
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
}
?>