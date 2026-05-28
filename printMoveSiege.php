
<?php
require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

/*************************************************
 * Vérification du matricule
 *************************************************/
if (!isset($_GET['code']) || empty($_GET['code'])) {
    die("Matricule manquant !");
}
$matricule = trim($_GET['code']);


/*************************************************
 * Fonction : Date FR
 *************************************************/
function dateFR($dateSql)
{
    if ($dateSql == "" || $dateSql == "0000-00-00") return "-";

    $mois = [
        "01"=>"janvier","02"=>"février","03"=>"mars","04"=>"avril","05"=>"mai","06"=>"juin",
        "07"=>"juillet","08"=>"août","09"=>"septembre","10"=>"octobre","11"=>"novembre","12"=>"décembre"
    ];

    $ts = strtotime($dateSql);
    return date("d", $ts) . " " . $mois[date("m", $ts)] . " " . date("Y", $ts);
}


/*************************************************
 * Récupération nom complet de l'agent
 *************************************************/
$sql = $db->prepare("
    SELECT CONCAT(nom_ag,' ',postnom_ag,' ',prenom_ag) AS nom_complet
    FROM bdd_paie.t_agent
    WHERE matricule = :m
");
$sql->bindValue(':m', $matricule);
$sql->execute();
$agent = $sql->fetch(PDO::FETCH_ASSOC);

$nomAgent = $agent ? $agent['nom_complet'] : "Inconnu";


/*************************************************
 * Classe PDF améliorée
 *************************************************/
class PDF extends FPDF {
    public $angle = 0;
    public $showHeader = false;

    /* -------- ROTATION -------- */
    function Rotate($angle, $x=-1, $y=-1)
    {
        if ($x == -1) $x = $this->x;
        if ($y == -1) $y = $this->y;

        if ($this->angle != 0) {
            $this->_out('Q');
        }

        $this->angle = $angle;

        if ($angle != 0) {
            $angle = deg2rad($angle);
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

    /* -------- FILIGRANE -------- */
    function Watermark()
    {
        $this->SetFont('Arial','B',40);
        $this->SetTextColor(230,230,230);
        $this->Rotate(30, 120, 180);
        $this->Text(80, 200, "CADECO");
        $this->Rotate(0);
    }

    /* -------- HEADER INSTITUTIONNEL -------- */
    function Header()
    {
        $this->Watermark();

        if ($this->showHeader === true) {
            $this->SetFillColor(30,60,120);
            $this->Rect(0,0,297,25,'F');

            $this->Image('img/Logo CADECO1.jpg',10,4,18);

            $this->SetTextColor(255,255,255);
            $this->SetFont('Arial','B',14);
            $this->SetXY(30,5);
            $this->Cell(237,6,"CAISSE GENERALE D'EPARGNE DU CONGO",0,1,'C');
            $this->Cell(280,6,"CADECO",0,1,'C');

            $this->SetFont('Arial','',10);
            $this->Cell(280,5,iconv('UTF-8','ISO-8859-1//TRANSLIT',"Société Anonyme Unipersonnelle"),0,1,'C');

            $this->SetDrawColor(180,180,180);
            $this->Line(10,28,287,28);

            $this->Ln(14);
            $this->SetTextColor(0,0,0);
        }
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',9);
        $this->Cell(0,10,"Page ".$this->PageNo().'/{nb}',0,0,'C');
    }

    /***********************************************
     * En-tête tableau
     ***********************************************/
    function EnteteTableau() {
        $this->Ln(5);
        $this->SetFont('Arial','B',12);

        $tableWidth = 250;
        $x = ($this->GetPageWidth() - $tableWidth) / 2;
        $this->SetX($x);

        // Ligne 1 fusionnée
        $this->Cell(30,20,iconv('UTF-8','ISO-8859-1','N°'),1,0,'C');
        $this->Cell(220,10,iconv('UTF-8','ISO-8859-1','Chronologie des Mouvements'),1,0,'C');
        $this->Ln();

        // Ligne 2
        $this->SetX($x + 30);
        $this->Cell(120,10,iconv('UTF-8','ISO-8859-1','Siège'),1,0,'L');
        $this->Cell(50,10,'Date Début',1,0,'C');
        $this->Cell(50,10,'Date Fin',1,0,'C');
        $this->Ln();
    }

    /***********************************************
     * Ligne tableau
     ***********************************************/
    function LigneTableau($num, $siege, $date_deb, $date_fin) {
        $this->SetFont('Arial','',11);

        $tableWidth = 250;
        $x = ($this->GetPageWidth() - $tableWidth) / 2;
        $this->SetX($x);

        $this->Cell(30,10,$num,1,0,'C');
        $this->Cell(120,10,iconv('UTF-8','ISO-8859-1',$siege),1,0,'L');
        $this->Cell(50,10,$date_deb,1,0,'C');
        $this->Cell(50,10,$date_fin,1,0,'C');
        $this->Ln();
    }
}

/*************************************************
 * Génération du PDF
 *************************************************/
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->showHeader = true;
$pdf->AddPage();

/************ TITRE principal **************/
$pdf->SetFont('Arial','BU',14);
$pdf->Cell(0,10,iconv('UTF-8','ISO-8859-1',"CHRONOLOGIE DES MOUVEMENTS DE L'AGENT"),0,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,"Matricule : $matricule",0,1,'C');
$pdf->Cell(0,8,iconv('UTF-8','ISO-8859-1',"Nom complet : $nomAgent"),0,1,'C');
$pdf->Ln(5);

/*************************************************
 * Charger données mouvements
 *************************************************/
$sql = $db->prepare("
    SELECT 
        ags.dateDebut, ags.dateFin, 
        sg.code_sieg, sg.libelle_sieg
    FROM bdd_paie.detail_agent_siege AS ags
    INNER JOIN bdd_paie.t_siege AS sg ON ags.siege_ID = sg.code_sieg
    WHERE ags.agent_ID = :m
    ORDER BY ags.dateDebut ASC
");

$sql->bindValue(':m',$matricule);
$sql->execute();

/************ Tableau **************/
$pdf->EnteteTableau();

$num = 1;

foreach($sql as $row)
{
    $siege = $row['code_sieg']." | ".$row['libelle_sieg'];
    $date_deb = dateFR($row['dateDebut']);
    $date_fin = dateFR($row['dateFin']);

    $pdf->LigneTableau($num, $siege, $date_deb, $date_fin);
    $num++;
}

/************ Signature **************/
$pdf->Ln(10);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,iconv('UTF-8','ISO-8859-1','Fait à Kinshasa, le '.date('d-m-Y')),0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,iconv('UTF-8','ISO-8859-1','KASONGO NGOY'),0,1,'C');

$pdf->Output("I","etat_carriere.pdf");
?>
