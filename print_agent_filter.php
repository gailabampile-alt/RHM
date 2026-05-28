<?php
ini_set('max_execution_time', 300);
ini_set('memory_limit', '512M');

require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

$activ = validation_donnees($_GET['activ'] ?? '');
$siege = validation_donnees($_GET['siege'] ?? '');
$dateDebut = validation_donnees($_GET['dateDebut'] ?? '');
$dateFin = validation_donnees($_GET['dateFin'] ?? '');

if (empty($activ) && empty($siege) && empty($dateDebut) && empty($dateFin)) {
    die("<h3 style='color:red;'>Sélectionnez au moins un filtre.</h3>");
}

$activLabel = '';
if ($activ) {
    $reqActiv = $db->prepare('SELECT libelle_activ FROM bdd_paie.t_activite WHERE code_activ = :activ');
    $reqActiv->bindValue(':activ', $activ);
    $reqActiv->execute();
    $activLabel = $reqActiv->fetchColumn() ?: '';
}

$siegeLabel = '';
if ($siege) {
    $reqSiege = $db->prepare('SELECT libelle_sieg FROM bdd_paie.t_siege WHERE code_sieg = :siege');
    $reqSiege->bindValue(':siege', $siege);
    $reqSiege->execute();
    $siegeLabel = $reqSiege->fetchColumn() ?: '';
}

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

    function Header()
    {
        $this->Watermark();

        if ($this->PageNo() == 1) {
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
        }
    }

    function Footer()
    {
        $this->SetDrawColor(200,200,200);
        $this->Line(10,285,200,285);
        $this->SetY(-12);
        $this->SetFont('Arial','I',9);
        $this->SetTextColor(120,120,120);
        $this->Cell(0,10,"Page ".$this->PageNo()."/{nb}",0,0,'R');
    }

    function TablePro($header, $data)
    {
        if (count($header) === 4) {
            $widths = [12,40,95,20];
        } else {
            $widths = [12,25,40,22,55,15];
        }
        $totalWidth = array_sum($widths);
        $startX = ($this->GetPageWidth() - $totalWidth) / 2;

        $this->SetFillColor(230,240,255);
        $this->SetTextColor(0,0,80);
        $this->SetFont('Arial','B',10);
        $this->SetX($startX);

        foreach ($header as $i=>$col) {
            $this->Cell($widths[$i],8,iconv('UTF-8','ISO-8859-1//TRANSLIT',$col),1,0,'C',true);
        }
        $this->Ln();

        $this->SetFont('Arial','',9);
        $this->SetTextColor(0,0,0);

        foreach ($data as $row) {
            $this->SetX($startX);
            foreach ($row as $i=>$col) {
                $this->Cell($widths[$i],7,iconv('UTF-8','ISO-8859-1//TRANSLIT',$col),1);
            }
            $this->Ln();
        }
    }
}

$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',13);
$pdf->SetTextColor(0,0,80);

$titre = "LISTE DES AGENTS";
$pdf->MultiCell(0,10,iconv('UTF-8','ISO-8859-1//TRANSLIT',$titre),0,'C');
$pdf->Ln(4);

$sql = "SELECT 
    t_agent.matricule,
    CONCAT(t_agent.nom_ag, ' ', t_agent.postnom_ag, ' ', t_agent.prenom_ag) AS noms,
    t_agent.sexe_ag,
    t_siege.code_sieg,
    t_type_siege.libelle_typSieg,
    t_siege.libelle_sieg,
    t_activite.libelle_activ
FROM bdd_paie.t_agent
INNER JOIN bdd_paie.detail_agent_siege ON detail_agent_siege.agent_ID = t_agent.matricule
INNER JOIN bdd_paie.t_siege ON t_siege.code_sieg = detail_agent_siege.siege_ID
INNER JOIN bdd_paie.t_type_siege ON t_type_siege.code_typSieg = t_siege.typeSiege_ID
INNER JOIN bdd_paie.t_activite ON t_activite.code_activ = t_agent.activiter_ID
WHERE 1=1";

$params = [];
$retraites = ['02','03','04','05','06','07','08','09','10'];

if ($activ) {
    $sql .= " AND t_agent.activiter_ID = :activ";
    $params[':activ'] = $activ;

    if (in_array($activ, $retraites)) {
        $sql .= " AND detail_agent_siege.statut_ID = 'desac'";
    } else {
        $sql .= " AND detail_agent_siege.statut_ID = 'act'";
    }
} else {
    $sql .= " AND (
        (t_agent.activiter_ID IN ('02','03','04','05','06','07','08','09','10')
         AND detail_agent_siege.statut_ID = 'desac')
        OR
        (t_agent.activiter_ID NOT IN ('02','03','04','05','06','07','08','09','10')
         AND detail_agent_siege.statut_ID = 'act')
    )";
}

if ($siege) {
    $sql .= " AND detail_agent_siege.siege_ID = :siege";
    $params[':siege'] = $siege;
}
if ($dateDebut) {
    $sql .= " AND t_agent.dateEngagemnt_ag >= :dateDebut";
    $params[':dateDebut'] = $dateDebut;
}
if ($dateFin) {
    $sql .= " AND t_agent.dateEngagemnt_ag <= :dateFin";
    $params[':dateFin'] = $dateFin;
}
$sql .= " ORDER BY t_siege.code_sieg, t_agent.nom_ag, t_agent.postnom_ag";

$req = $db->prepare($sql);
foreach ($params as $key => $value) {
    $req->bindValue($key, $value);
}
$req->execute();

$rows = [];
while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
    $rows[] = $row;
}

$header = ['N°','MATRICULE','NOMS','SEXE'];

$grouped = [];
foreach ($rows as $row) {
    $groupKey = $row['code_sieg'].'|'.$row['libelle_sieg'];
    if (!isset($grouped[$groupKey])) {
        $grouped[$groupKey] = [];
    }
    $grouped[$groupKey][] = $row;
}

$groupIndex = 0;
foreach ($grouped as $groupKey => $groupRows) {
    list($codeSiege, $libelleSiege) = explode('|', $groupKey, 2);
    if ($groupIndex > 0) {
        $pdf->AddPage();
    }

    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(0,8,iconv('UTF-8','ISO-8859-1//TRANSLIT','ACTIVITÉ : '.($activLabel ?: 'Toutes')),0,1,'L');
    $pdf->Cell(0,8,iconv('UTF-8','ISO-8859-1//TRANSLIT','SIÈGE : '.$codeSiege.' / '.$libelleSiege),0,1,'L');
    if ($dateDebut || $dateFin) {
        $periode = 'PÉRIODE : ';
        if ($dateDebut && $dateFin) {
            $periode .= date('d-m-Y', strtotime($dateDebut)).' au '.date('d-m-Y', strtotime($dateFin));
        } elseif ($dateDebut) {
            $periode .= 'à partir du '.date('d-m-Y', strtotime($dateDebut));
        } else {
            $periode .= 'jusqu\'au '.date('d-m-Y', strtotime($dateFin));
        }
        $pdf->Cell(0,8,iconv('UTF-8','ISO-8859-1//TRANSLIT',$periode),0,1,'L');
    }
    $pdf->Ln(2);

    $tableData = [];
    $n = 1;
    foreach ($groupRows as $row) {
        $tableData[] = [
            $n++,
            $row['matricule'],
            $row['noms'],
            $row['sexe_ag']
        ];
    }

    $pdf->TablePro($header, $tableData);

    $pdf->Ln(4);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,10,iconv('UTF-8','ISO-8859-1//TRANSLIT','Fait à Kinshasa, Le '.date('d-m-Y')),0,1,'C');
    $pdf->Cell(0,10,iconv('UTF-8','ISO-8859-1//TRANSLIT','Blévin LAMA LUTSHIMA'),0,1,'C');

    $groupIndex++;
}

$pdf->Output();
