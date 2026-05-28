
<?php
require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

/*----------------------------------------------------
  Évite l'erreur FPDF "Certaines données ont déjà été produites"
------------------------------------------------------*/
ob_start();
ini_set('display_errors', 0);

/*----------------------------------------------------
  Conversion UTF-8 -> ISO-8859-1 sécurisée pour FPDF
------------------------------------------------------*/
function toLatin1($str)
{
    if ($str === null) return '';
    if (!is_string($str)) $str = (string)$str;

    $map = [
        "’"=>"'", "‘"=>"'", "‚"=>",",
        "“"=>'"', "”"=>'"', "„"=>'"',
        "–"=>"-", "—"=>"-", "−"=>"-",
        "…" => "...",
        " "=>" ", " "=>" "
    ];

    $str = strtr($str, $map);
    $str = preg_replace('/\s+/u', ' ', trim($str));

    $converted = @iconv('UTF-8','ISO-8859-1//TRANSLIT',$str);
    if ($converted === false) {
        $converted = utf8_decode($str);
    }
    return $converted;
}

/*----------------------------------------------------
  Vérification du matricule
------------------------------------------------------*/
if (!isset($_GET['code']) || trim($_GET['code']) === "") {
    die("Matricule manquant !");
}
$matricule = trim($_GET['code']);

/*----------------------------------------------------
  Date en Français
------------------------------------------------------*/
function dateFR($d)
{
    if ($d == "" || $d == "0000-00-00") return "-";

    $mois = [
        "01"=>"janvier","02"=>"février","03"=>"mars","04"=>"avril",
        "05"=>"mai","06"=>"juin","07"=>"juillet","08"=>"août",
        "09"=>"septembre","10"=>"octobre","11"=>"novembre","12"=>"décembre"
    ];

    $ts = strtotime($d);
    return date("d", $ts)." ".$mois[date("m",$ts)]." ".date("Y",$ts);
}

/*----------------------------------------------------
  Récupération des infos de l’agent
------------------------------------------------------*/
$stmt = $db->prepare("
    SELECT CONCAT(nom_ag,' ',postnom_ag,' ',prenom_ag) AS nom
    FROM bdd_paie.t_agent
    WHERE matricule = :m
");
$stmt->bindValue(':m',$matricule);
$stmt->execute();
$res = $stmt->fetch(PDO::FETCH_ASSOC);
$nomAgent = $res ? $res['nom'] : "Inconnu";

/*----------------------------------------------------
  Classe PDF optimisée
------------------------------------------------------*/
class PDF extends FPDF
{
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
            $this->Cell(280,5,toLatin1("Société Anonyme Unipersonnelle"),0,1,'C');

            $this->SetDrawColor(180,180,180);
            $this->Line(10,28,287,28);

            $this->Ln(14);
            $this->SetTextColor(0,0,0);
        }
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',9);
        $this->Cell(0,10, "Page ".$this->PageNo()."/{nb}", 0, 0, 'C');
    }

    function InfoAgent($matricule,$nom) {
        $this->SetFont('Arial','BU',14);
        $this->Cell(0,10, toLatin1("CHRONOLOGIE DES PROMOTIONS DE L'AGENT"), 0, 1, 'C');

        $this->SetFont('Arial','B',12);
        $this->Cell(0,8, toLatin1("Matricule : ".$matricule), 0, 1, 'C');
        $this->Cell(0,8, toLatin1("Nom complet : ".$nom), 0, 1, 'C');

        $this->Ln(5);
    }

    function EnteteTableau() {
        $this->SetFont('Arial','B',12);

        $w = 250;
        $x = ($this->GetPageWidth() - $w)/2;

        $this->SetX($x);
        $this->Cell(40,20, toLatin1("Mouvement N°"),1,0,'C');
        $this->Cell(210,10, toLatin1("Chronologie de mouvement"),1,1,'C');

        $this->SetX($x + 40);
        $this->Cell(110,10, toLatin1("Grade"),1,0,'L');
        $this->Cell(50,10, toLatin1("Date Début"),1,0,'C');
        $this->Cell(50,10, toLatin1("Date Fin"),1,1,'C');
    }

    function LigneTableau($num,$grade,$deb,$fin) {
        $this->SetFont('Arial','',11);

        $w = 250;
        $x = ($this->GetPageWidth() - $w)/2;

        $this->SetX($x);
        $this->Cell(40,10,$num,1,0,'C');
        $this->Cell(110,10,toLatin1($grade),1,0,'L');
        $this->Cell(50,10,toLatin1($deb),1,0,'C');
        $this->Cell(50,10,toLatin1($fin),1,1,'C');
    }
}

/*----------------------------------------------------
  Génération du PDF
------------------------------------------------------*/
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->showHeader = true;
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,15);

$pdf->InfoAgent($matricule, $nomAgent);
$pdf->EnteteTableau();

/*----------------------------------------------------
  Récupération des promotions de l’agent
------------------------------------------------------*/
$q = $db->prepare("
    SELECT 
        ag_gr.grade_ID,
        gra.libelle_grade,
        ag_gr.dateDebut,
        ag_gr.dateFin
    FROM bdd_paie.detail_agent_grade AS ag_gr
    INNER JOIN bdd_paie.t_grade AS gra ON gra.code_grade = ag_gr.grade_ID
    WHERE ag_gr.agent_ID = :m
    ORDER BY ag_gr.dateDebut ASC
");
$q->bindValue(':m',$matricule);
$q->execute();

$i = 1;
while($row = $q->fetch(PDO::FETCH_ASSOC)) {

    $grade = $row["grade_ID"]." | ".$row["libelle_grade"];
    $deb   = dateFR($row["dateDebut"]);
    $fin   = dateFR($row["dateFin"]);

    $pdf->LigneTableau($i,$grade,$deb,$fin);
    $i++;
}

/*----------------------------------------------------
  Signature + sortie PDF
------------------------------------------------------*/
$pdf->Ln(12);
$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,toLatin1("Fait à Kinshasa, le ".date("d-m-Y")),0,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,toLatin1("KASONGO NGOY"),0,1,'C');

/*IMPORTANT : nettoyer le buffer*/
ob_end_clean();

$pdf->Output('I','etat_carriere.pdf');
