<?php
// Active la mise en memoire tampon de sortie (buffer) pour eviter l'envoi d'entetes
ob_start();

require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

$matric = $_GET['matric'] ?? '';
$id_conger = $_GET['idc'] ?? '';

if (empty($matric)) {
    die("Erreur : Le matricule est manquant.");
}

$id_demande = $noms = $direction = $fonction = $conge = $grade = $aprendre = $exercice = $nbrJr = $dateDepart = $dateReprise = $datefin = "";

try {
    $req = $db->prepare("SELECT 
        tdc.id_demande, tdc.id_typeconge, ttc.libelle_conge, tdc.date_demande, tdc.date_debut,
        tdc.date_fin, tdc.excercice, tdc.nbrejr_accord, tdc.nbrejr_solic, tdc.matricule, ta.nom_ag, ta.postnom_ag,
        td.libelle_dir, tf.libelleFonct, dagr.grade_ID
        FROM bdd_paie.t_demandeconge tdc
        INNER JOIN bdd_paie.t_agent ta ON ta.matricule = tdc.matricule
        INNER JOIN bdd_paie.detail_agent_direction dad ON dad.agent_ID = tdc.matricule
        INNER JOIN bdd_paie.t_direction td ON td.code_dir = dad.direction_ID
        INNER JOIN bdd_paie.detail_agent_fonction daf ON daf.agent_ID = tdc.matricule
        INNER JOIN bdd_paie.t_fonction tf ON tf.codeFonct = daf.fonction_ID
        INNER JOIN bdd_paie.detail_agent_grade dagr ON dagr.agent_ID = tdc.matricule
        INNER JOIN bdd_paie.t_typconge ttc ON ttc.id_type_conge = tdc.id_typeconge
        WHERE tdc.matricule = :matricule AND tdc.statut = 'naprv' AND tdc.etat = 'act' AND tdc.id_demande = :id_conger
        LIMIT 1");

    $req->bindValue(':matricule', $matric);
    $req->bindValue(':id_conger', $id_conger);
    $req->execute();

    if ($res = $req->fetch(PDO::FETCH_ASSOC)) {
        $id_demande = $res['id_demande'];
        $noms = $res['nom_ag'] . " " . $res['postnom_ag'];
        $direction = strtoupper($res['libelle_dir']);
        $fonction = $res['libelleFonct'];
        $grade = $res['grade_ID'];
        $aprendre = $res['nbrejr_accord'];
        $exercice = $res['excercice'];
        $nbrJr = $res['nbrejr_solic'];
        $conge = strtoupper($res['libelle_conge']);

        $dateDepart = date('d/m/Y', strtotime($res['date_debut']));
        $datefin = date('d/m/Y', strtotime($res['date_fin']));
        $dateReprise = date("d/m/Y", strtotime($res['date_fin'] . " +1 day"));
    } else {
        die("Erreur : Aucune demande de conge 'naprv' trouvee pour le matricule $matric.");
    }
    $req->closeCursor();
} catch (PDOException $e) {
    die("Erreur de base de donnees : " . $e->getMessage());
}

function enc($text) {
    return iconv('UTF-8', 'windows-1252', $text ?? '');
}

function addRow($pdf, $label, $value, $labelWidth, $colonWidth, $valueWidth) {
    $pdf->SetFont('Times', 'B', 13);
    $pdf->Cell($labelWidth, 8, enc($label), 0, 0, 'L');
    $pdf->Cell($colonWidth, 8, ":", 0, 0, 'L');
    $pdf->SetFont('Times', '', 13);
    $pdf->Cell($valueWidth, 8, enc($value), 0, 1, 'L');
}

class PDF extends FPDF {
    public $angle = 0;

    function Rotate($angle, $x = -1, $y = -1)
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
                $cx - $c * $cx + $s * $cy,
                $cy - $s * $cx - $c * $cy
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
        $this->SetFont('Arial', 'B', 40);
        $this->SetTextColor(230, 230, 230);
        $this->Rotate(30, 80, 200);
        $this->Text(35, 210, "CADECO");
        $this->Rotate(0);
    }

    function Header()
    {
        $this->Watermark();

        if ($this->PageNo() == 1) {
            $this->SetFillColor(30, 60, 120);
            $this->Rect(0, 0, 210, 25, "F");

            $this->Image('img/Logo CADECO1.jpg', 10, 4, 18);

            $this->SetFont('Arial', 'B', 14);
            $this->SetTextColor(255, 255, 255);
            $this->SetXY(30, 5);
            $this->Cell(150, 6, "CAISSE GENERALE D'EPARGNE DU CONGO", 0, 1, 'C');
            $this->Cell(190, 5, "C A D E C O", 0, 1, 'C');

            $this->SetFont('Arial', '', 10);
            $this->Cell(
                190,
                4,
                iconv('UTF-8', 'ISO-8859-1//TRANSLIT', "Societe Anonyme Unipersonnelle"),
                0,
                1,
                'C'
            );

            $this->SetDrawColor(180, 180, 180);
            $this->Line(10, 28, 200, 28);
            $this->Ln(12);
            $this->SetTextColor(0, 0, 0);
        }
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'A4', 'UTF-8');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 14);

$pdf->Cell(0, 10, enc("D E C I S I O N  D E  C O N G E N°" . $id_demande . "/DG/DRH/DP/" . date('Y')), 1, 1, 'C');
$pdf->Ln(8);

$labelWidth = 65;
$colonWidth = 10;
$valueWidth = 100;

addRow($pdf, "NOM & POSTNOM", $noms, $labelWidth, $colonWidth, $valueWidth);
addRow($pdf, "DIRECTION", $direction, $labelWidth, $colonWidth, $valueWidth);
addRow($pdf, "FONCTION", $fonction, $labelWidth, $colonWidth, $valueWidth);
addRow($pdf, "GRADE", $grade, $labelWidth, $colonWidth, $valueWidth);
addRow($pdf, "TYPE DE CONGE AUTORISE", $conge, $labelWidth, $colonWidth, $valueWidth);
addRow($pdf, "EXERCICE(S)", $exercice, $labelWidth, $colonWidth, $valueWidth);
addRow($pdf, "NOMBRE DE JOURS", $nbrJr, $labelWidth, $colonWidth, $valueWidth);

$pdf->SetFont('Times', 'B', 13);
$pdf->Cell($labelWidth, 8, "DATE DE DEPART", 0, 0, 'L');
$pdf->Cell($colonWidth, 8, ":", 0, 0, 'L');
$pdf->SetFont('Times', '', 13);
$pdf->Cell(40, 8, $dateDepart ?? '', 0, 0, 'L');
$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(40, 8, "DATE DE REPRISE", 0, 0, 'L');
$pdf->Cell(10, 8, ":", 0, 0, 'L');
$pdf->SetFont('Times', '', 13);
$pdf->Cell(40, 8, $dateReprise ?? '', 0, 1, 'L');

addRow($pdf, "SOIT DU", $dateDepart . "   AU   " . $datefin, $labelWidth, $colonWidth, $valueWidth);

$pdf->Ln(15);

$pdf->SetFont('Times', 'B', 13);
$pdf->Cell(60, 8, "ACCORD DU CHEF", 0, 0, 'L');
$pdf->Cell(70);
$pdf->Cell(60, 8, "VISA DIRECTION", 0, 1, 'R');
$pdf->Ln(20);
$pdf->Cell(0, 8, "VISA DIRECTION DES RESSOURCES HUMAINES", 0, 1, 'C');

$pdf->Ln(15);

$pdf->SetFont('Times', 'B', 13);
$txtNote = "NOTE AU DOSSIER PAR LE CHEF DU DEPARTEMENT DE LA GESTION PERSONNEL ";
$pdf->Cell(0, 10, enc($txtNote), 0, 1, 'L');

$pdf->SetFont('Times', '', 13);
$pdf->Ln(5);
$pdf->Cell(0, 8, enc("OBSERVATIONS :"), 0, 1, 'L');

$margin = 10;
$pdf->SetX($margin);
$pdf->Cell(0, 8, enc("- 1 ORIGINAL DESTINE A L'AGENT"), 0, 1, 'L');
$pdf->SetX($margin);
$pdf->Cell(0, 8, enc("- 1 COPIE POUR LE DOSSIER DE L'AGENT"), 0, 1, 'L');
$pdf->SetX($margin);
$pdf->Cell(0, 8, enc("- 1 COPIE POUR LE SERVICE PAIE"), 0, 1, 'L');
$pdf->SetX($margin);
$pdf->Cell(0, 8, enc("- 1 COPIE POUR LA DIRECTION/SERVICE DE L'AGENT"), 0, 1, 'L');

$pdf->Output();
ob_end_flush();
?>
