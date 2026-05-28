<?php
require('sys_fonction.php');
require('sys_connexion.php');
require('fpdf.php');

$devise = validation_donnees($_GET['devise'] ?? '');
$siege = validation_donnees($_GET['siege'] ?? '');
$periode = validation_donnees($_GET['periode'] ?? '');
$siegeLibelle = 'TOUS LES SIEGES';

$totalPret = 0;
$totalRetenir = 0;
$totalSolde = 0;

class PDF extends FPDF
{
    public $angle = 0;

    function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1) {
            $x = $this->x;
        }
        if ($y == -1) {
            $y = $this->y;
        }

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
                $c,
                $s,
                -$s,
                $c,
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
        $this->Text(120, 210, 'CADECO');
        $this->Rotate(0);
    }

    function Header()
    {
        $this->Watermark();

        if ($this->PageNo() == 1) {
            $this->SetFillColor(30, 60, 120);
            $this->Rect(0, 0, 310, 25, 'F');

            $this->Image('img/Logo CADECO1.jpg', 10, 4, 18);

            $this->SetFont('Arial', 'B', 14);
            $this->SetTextColor(255, 255, 255);
            $this->SetXY(30, 5);
            $this->Cell(230, 6, "CAISSE GENERALE D'EPARGNE DU CONGO", 0, 1, 'C');
            $this->Cell(270, 5, 'C A D E C O', 0, 1, 'C');

            $this->SetFont('Arial', '', 10);
            $this->Cell(
                270,
                4,
                iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Societe Anonyme Unipersonnelle'),
                0,
                1,
                'C'
            );

            $this->SetDrawColor(180, 180, 180);
            $this->Line(10, 28, 280, 28);
            $this->Ln(12);
            $this->SetTextColor(0, 0, 0);
        }
    }

    function Footer()
    {
        $this->SetDrawColor(200, 200, 200);
        $this->Line(10, 285, 200, 285);
        $this->SetY(-12);
        $this->SetFont('Arial', 'I', 9);
        $this->SetTextColor(120, 120, 120);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }

    function TablePro($header, $data)
    {
        $widths = [15, 85, 65, 20, 22, 28, 22, 15];
        $totalWidth = array_sum($widths);
        $startX = ($this->GetPageWidth() - $totalWidth) / 2;

        $this->SetFillColor(230, 240, 255);
        $this->SetTextColor(0, 0, 80);
        $this->SetFont('Arial', 'B', 10);
        $this->SetX($startX);

        foreach ($header as $i => $col) {
            $this->Cell(
                $widths[$i],
                8,
                iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $col),
                1,
                0,
                'C',
                true
            );
        }
        $this->Ln();

        $this->SetFont('Arial', '', 10);
        $this->SetTextColor(0, 0, 0);

        $numero = 1;
        foreach ($data as $row) {
            $this->SetX($startX);
            $this->Cell($widths[0], 7, $numero, 1, 0, 'C');
            $this->Cell($widths[1], 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', (string) ($row[0] ?? '')), 1);
            $this->Cell($widths[2], 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', (string) ($row[1] ?? '')), 1);
            $this->Cell($widths[3], 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', (string) ($row[2] ?? '')), 1);
            $this->Cell($widths[4], 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', (string) ($row[3] ?? '')), 1);
            $this->Cell($widths[5], 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', (string) ($row[4] ?? '')), 1);
            $this->Cell($widths[6], 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', (string) ($row[5] ?? '')), 1);
            $this->Cell($widths[7], 7, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', (string) ($row[6] ?? '')), 1);
            $this->Ln();
            $numero++;
        }
    }
}

if ($siege !== '') {
    $reqSiege = $db->prepare("SELECT libelle_sieg FROM bdd_paie.t_siege WHERE code_sieg = :siege");
    $reqSiege->bindValue(':siege', $siege, PDO::PARAM_STR);
    $reqSiege->execute();
    $siegeTrouve = $reqSiege->fetch(PDO::FETCH_ASSOC);

    if ($siegeTrouve && !empty($siegeTrouve['libelle_sieg'])) {
        $siegeLibelle = $siegeTrouve['libelle_sieg'];
    } else {
        $siegeLibelle = $siege;
    }
}

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 11);
$pdf->SetTextColor(0, 0, 80);

$periodeAffichee = $periode !== '' ? $periode : 'TOUTES PERIODES';
$siegeAffiche = $siegeLibelle;
$deviseAffichee = $devise !== '' ? $devise : 'TOUTES';
$titre = 'LISTE DE PRETS EN : ' . $deviseAffichee . ' | SIEGE : ' . $siegeAffiche . ' | PERIODE : ' . $periodeAffichee;
$pdf->MultiCell(0, 10, iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $titre), 0, 'C');
$pdf->Ln(4);
$pdf->SetTextColor(0, 0, 0);

$data = [];
$params = [];
$conditions = [];

$sql = "SELECT
    pr.id_pret,
    pr.moisEpuration,
    pr.periodePret,
    pr.N_refPret,
    pr.montantPreter,
    pr.solde,
    pr.montant_a_retenir,
    pr.codePaie_ID,
    pr.monnaie_ID,
    pr.creerPar,
    pr.modifierPar,
    pr.statut_ID,
    pr.agent_ID,
    CONCAT(ag.nom_ag, ' ', ag.postnom_ag, ' ', ag.prenom_ag) AS noms,
    cp.libelle_codePaie,
    s.code_sieg,
    s.libelle_sieg
FROM bdd_paie.t_pret AS pr
INNER JOIN bdd_paie.t_agent AS ag ON ag.matricule = pr.agent_ID
INNER JOIN bdd_paie.t_codepaie AS cp ON cp.codePaie = pr.codePaie_ID
INNER JOIN bdd_paie.detail_agent_siege AS ags ON ags.agent_ID = ag.matricule
INNER JOIN bdd_paie.t_siege AS s ON s.code_sieg = ags.siege_ID";

if ($devise !== '') {
    if ($devise === 'CDF&USD') {
        $conditions[] = "pr.monnaie_ID IN ('CDF', 'USD')";
    } else {
        $conditions[] = 'pr.monnaie_ID = :monnaie';
        $params[':monnaie'] = $devise;
    }
}

if ($siege !== '') {
    $conditions[] = 's.code_sieg = :siege';
    $params[':siege'] = $siege;
}

if ($periode !== '') {
    $conditions[] = "(
        TRIM(pr.periodePret) = :periode
        OR REPLACE(TRIM(pr.periodePret), '-', '/') = :periode_slash
        OR REPLACE(TRIM(pr.periodePret), '/', '-') = :periode_dash
    )";
    $params[':periode'] = trim($periode);
    $params[':periode_slash'] = str_replace('-', '/', trim($periode));
    $params[':periode_dash'] = str_replace('/', '-', trim($periode));
}

if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

$sql .= ' ORDER BY s.libelle_sieg ASC, ag.nom_ag ASC, ag.postnom_ag ASC, ag.prenom_ag ASC';

$req = $db->prepare($sql);
$req->execute($params);

while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
    $pret = (float) ($row['montantPreter'] ?? 0);
    $retenir = (float) ($row['montant_a_retenir'] ?? 0);
    $solde = (float) ($row['solde'] ?? 0);

    $data[] = [
        $row['agent_ID'] . ' | ' . $row['noms'],
        $row['libelle_sieg'],
        $row['codePaie_ID'],
        number_format($pret, 2, ',', ' '),
        number_format($retenir, 2, ',', ' '),
        number_format($solde, 2, ',', ' '),
        $row['monnaie_ID'],
    ];

    $totalPret += $pret;
    $totalRetenir += $retenir;
    $totalSolde += $solde;
}

$pdf->TablePro(
    array('N°', 'Identite', 'Siege', 'CodePaie', 'Montant', 'A retenir', 'Solde', 'Devise'),
    $data
);

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(0, 0, 80);
$pdf->Cell(0, 8, 'Total prets : ' . count($data), 0, 1, 'R');
$pdf->Cell(
    0,
    8,
    iconv(
        'UTF-8',
        'ISO-8859-1//TRANSLIT',
        'Montant : ' . number_format($totalPret, 2, ',', ' ') .
        ' | A retenir : ' . number_format($totalRetenir, 2, ',', ' ') .
        ' | Solde : ' . number_format($totalSolde, 2, ',', ' ')
    ),
    0,
    1,
    'R'
);

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 11);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(
    280,
    10,
    iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'Fait a Kinshasa, le ' . date('d-m-Y')),
    0,
    1,
    'R'
);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(
    280,
    10,
    iconv('UTF-8', 'ISO-8859-1//TRANSLIT', 'KASONGO NGOY'),
    0,
    1,
    'R'
);

$pdf->Output();
?>
