<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once("sys_connexion.php");
session_start();
ob_start();

/* =========================
   FONCTIONS
========================= */

function formatPeriode($periode) {
    if (!$periode) return '';
    [$mois, $annee] = explode("/", $periode);

    $mois_fr = [
        "01"=>"JANVIER","02"=>"FÉVRIER","03"=>"MARS","04"=>"AVRIL",
        "05"=>"MAI","06"=>"JUIN","07"=>"JUILLET","08"=>"AOÛT",
        "09"=>"SEPTEMBRE","10"=>"OCTOBRE","11"=>"NOVEMBRE","12"=>"DÉCEMBRE"
    ];

    if (strlen($annee) === 2) {
        $annee = "20".$annee;
    }

    return ($mois_fr[$mois] ?? '') . " " . $annee;
}

function libelleTypePaie($type) {
    return match ($type) {
        'N' => 'SALAIRE NORMAL',
        'V' => 'RENTE VIAGÈRE',
        'R' => 'RENTRÉE SCOLAIRE',
        'G' => 'GRATIFICATION',
        default => 'PAIE'
    };
}

function pdfText(string $value): string {
    return mb_convert_encoding($value, 'ISO-8859-1', 'UTF-8');
}

function pdfCell(FPDF $pdf, string $text, float $w, string $align = 'L', bool $fill = false): void {
    $pdf->Cell($w, 6, pdfText($text), 1, 0, $align, $fill);
}

function pdfPrintHeader(FPDF $pdf, string $numero_op, string $titre, string $siegeLabel): void {
    if (file_exists(__DIR__ . '/img/Logo CADECO1.jpg')) {
        $pdf->Image(__DIR__ . '/img/Logo CADECO1.jpg', 10, 10, 25);
    }
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 9, pdfText('CAISSE GÉNÉRALE D\'EPARGNE DU CONGO'), 0, 1, 'C');
    $pdf->Cell(0, 8, pdfText('CADECO'), 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 8, pdfText('Numéro OP : ' . $numero_op), 0, 1, 'C');
    $pdf->Ln(3);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(0, 51, 102);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(0, 8, pdfText($titre), 0, 1, 'C', true);
    $pdf->Ln(4);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(0, 7, pdfText('Siège : ' . $siegeLabel), 0, 1);
    $pdf->Ln(4);
}

function pdfPrintTableHeader(FPDF $pdf): void {
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(230, 230, 230);
    pdfCell($pdf, 'Matricule', 30, 'C', true);
    pdfCell($pdf, 'Noms et Prénoms', 70, 'L', true);
    pdfCell($pdf, 'N° Compte', 40, 'C', true);
    pdfCell($pdf, 'Net à Payer', 30, 'R', true);
    pdfCell($pdf, 'Signature', 20, 'C', true);
    $pdf->Ln();
    $pdf->SetFont('Arial', '', 10);
}

function pdfPrintSignatures(FPDF $pdf): void {
    $pdf->Ln(10);
    $pdf->Cell(95, 7, pdfText('Le Directeur des Ressources Humaines'), 0, 0, 'L');
    $pdf->Cell(95, 7, pdfText('Le Directeur Financier'), 0, 1, 'R');
    $pdf->Ln(18);
    $pdf->Cell(95, 7, pdfText('David KASONGO NGOY'), 0, 0, 'L');
    $pdf->Cell(95, 7, pdfText('Fabien NGONGO KANDOLO'), 0, 1, 'R');
}

/* =========================
   PARAMÈTRES
========================= */
$periode     = $_GET['periode'] ?? '';
$printBy     = $_GET['Print_by'] ?? '';
$code_siege  = $_GET['code_siege'] ?? '';
$type_paie   = $_GET['type_paie'] ?? '';
$format      = strtolower($_GET['format'] ?? 'html');
if (!in_array($format, ['html', 'pdf', 'excel'], true)) {
    $format = 'html';
}

$libelle_paie = libelleTypePaie($type_paie);

/* =========================
   REQUÊTE
========================= */
$sql = "
SELECT p.matricule, p.nom, p.postnom, p.prenom,
       p.codesiege, p.libelle_siege, p.numCompt,
       p.montant_payer AS salaire_net
FROM bdd_paie.t_paie p
WHERE p.periode = :periode
AND p.type_paie = :type_paie
AND p.codeEiPaie = '999'
";

$params = [
    ':periode' => $periode,
    ':type_paie' => $type_paie
];

if ($printBy === "S") {
    $sql .= " AND p.codesiege = :codesiege ";
    $params[':codesiege'] = $code_siege;
}

$sql .= " ORDER BY p.codesiege, p.nom, p.postnom, p.prenom";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$agents) {
    echo "<h3 style='text-align:center;color:red'>Aucun agent trouvé</h3>";
    exit;
}

if ($format === 'pdf') {
    if (ob_get_length()) {
        ob_end_clean();
    }
    require_once __DIR__ . '/fpdf.php';
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->AddPage();

    $current_siege = '';
    $total_siege = 0;
    $total_general = 0;
    $first = true;

    foreach ($agents as $row) {
        if ($current_siege !== $row['codesiege']) {
            if (!$first) {
                $pdf->Cell(100, 7, pdfText('TOTAL SIÈGE'), 1, 0, 'L', true);
                $pdf->Cell(30, 7, pdfText(number_format($total_siege, 2, ',', ' ') . ' FC'), 1, 0, 'R', true);
                $pdf->Cell(20, 7, '', 1, 1, 'C', true);
                pdfPrintSignatures($pdf);
                $pdf->AddPage();
            }

            $current_siege = $row['codesiege'];
            $total_siege = 0;
            $first = false;

            $numero_op = 'OP-' . str_replace('/', '', $periode) . '-' . $row['codesiege'];
            pdfPrintHeader(
                $pdf,
                $numero_op,
                'ORDRE DE PAIEMENT - ' . $libelle_paie . ' | ' . formatPeriode($periode),
                $row['codesiege'] . ' - ' . ($row['libelle_siege'] ?? '')
            );
            pdfPrintTableHeader($pdf);
        }

        pdfCell($pdf, $row['matricule'] ?? '', 30, 'C');
        pdfCell($pdf, trim(($row['nom'] ?? '') . ' ' . ($row['postnom'] ?? '') . ' ' . ($row['prenom'] ?? '')), 70, 'L');
        pdfCell($pdf, $row['numCompt'] ?? '', 40, 'C');
        pdfCell($pdf, number_format((float)($row['salaire_net'] ?? 0), 2, ',', ' '), 30, 'R');
        pdfCell($pdf, '', 20, 'C');
        $pdf->Ln();

        $total_siege += (float)($row['salaire_net'] ?? 0);
        $total_general += (float)($row['salaire_net'] ?? 0);
    }

    $pdf->Cell(100, 7, pdfText('TOTAL SIÈGE'), 1, 0, 'L', true);
    $pdf->Cell(30, 7, pdfText(number_format($total_siege, 2, ',', ' ') . ' FC'), 1, 0, 'R', true);
    $pdf->Cell(20, 7, '', 1, 1, 'C', true);
    pdfPrintSignatures($pdf);

    $filename = 'Ordre_paiement_' . str_replace(['/', ' '], ['_', '_'], $periode) . '_' . $type_paie . '.pdf';
    $pdf->Output('I', $filename);
    exit;
}

if ($format === 'excel') {
    header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
    header('Content-Disposition: attachment; filename="Ordre_paiement_' . str_replace(['/', ' '], ['_', '_'], $periode) . '_' . $type_paie . '.xls"');
    header('Cache-Control: max-age=0');
    header('Pragma: no-cache');
    echo "\xEF\xBB\xBF"; // BOM for Excel UTF-8 compatibility
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Ordre de Paiement</title>

<style>
body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 13px;
}


/* ===== EN-TÊTE CORPORATE ===== */
.header-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 8px;
}

.header-table td {
    vertical-align: middle;
    border: none !important; /* ✅ aucun trait visible */
}

.logo-cell {
    width: 20%;
    padding-left: 25px;
    text-align: left;
}

.logo-cell img {
    height: 90px;   /* 🔼 logo légèrement plus grand */
}

.center-cell {
    width: 60%;
    text-align: center;
    font-size: 16px;        /* ✅ TAILLE PRINCIPALE */
    line-height: 1.3;
}

.center-cell strong {
    font-size: 16px;        /* ✅ CADECO & titre */
}

.center-cell span {
    font-size: 14.5px;      /* ✅ Numéro OP (léger retrait visuel) */
}

.right-cell {
    width: 20%;
}

/* ===== BANDEAU CORPORATE ===== */
.band {
    width: 100%;
    background: #003366;
    color: #fff;
    text-align: center;
    font-weight: bold;
    font-size: 15.5px;      /* ✅ BANDEAU PLUS LISIBLE */
    padding: 8px 0;
    margin: 8px 0 14px 0;
    letter-spacing: 0.4px;
}



/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #000;
    padding: 5px;
}

th {
    background: #eee;
}

/* ===== SUPPRIMER TOUT TRAIT SUR L’EN-TÊTE ===== */
.header-table,
.header-table td {
    border: none !important;
}

/* ===== PDF / IMPRESSION ===== */
.page-break {
    page-break-before: always;
}

/* ===== SIGNATURES ===== */
.signature {
    margin-top: 40px;
}
.sig-left {
    float: left;
    width: 45%;
    text-align: center;
}
.sig-right {
    float: right;
    width: 45%;
    text-align: center;
}
.clear {
    clear: both;
}
</style>
</head>

<body>

<?php
$current_siege = '';
$total_siege = 0;
$first = true;

foreach ($agents as $row) {

    if ($current_siege !== $row['codesiege']) {

        /* ==== CLÔTURE SIÈGE PRÉCÉDENT ==== */
        if (!$first) {
            echo "
                <tr>
                    <td colspan='3'><strong>TOTAL SIÈGE</strong></td>
                    <td align='right'><strong>".number_format($total_siege,2,',',' ')."</strong></td>
                    <td></td>
                </tr>
                </tbody>
                </table>

                <div class='signature'>
                    <div class='sig-left'>Directeur RH<br><br>______________</div>
                    <div class='sig-right'>Directeur Financier<br><br>______________</div>
                </div>
                <div class='clear'></div>

                <div class='page-break'></div>
            ";
        }

        /* ==== EN-TÊTE PARFAITEMENT CENTRÉ ==== */
        $numero_op = "OP-" . str_replace('/', '', $periode) . "-" . $row['codesiege'];

        echo "
        <table class='header-table'>
            <tr>
                <td class='logo-cell'>
                    <img src='img/Logo CADECO1.jpg' alt='Logo CADECO'>
                </td>
                <td class='center-cell'>
                    <strong> CAISSE GÉNÉRALE D'ÉPARGNE DU CONGO</strong><br>
                    <strong>CADECO</strong><br>
                    Numéro OP : <strong>$numero_op</strong>
                </td>
                <td class='right-cell'></td>
            </tr>
        </table>

        <div class='band'>
            ORDRE DE PAIEMENT – $libelle_paie | ".formatPeriode($periode)."
        </div>

        <h4>Siège : {$row['codesiege']} - {$row['libelle_siege']}</h4>

        <table>
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Noms et Prénoms</th>
                    <th>N° Compte</th>
                    <th>Net à Payer</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody>
        ";

        $current_siege = $row['codesiege'];
        $total_siege = 0;
        $first = false;
    }

    echo "
        <tr>
            <td>{$row['matricule']}</td>
            <td>{$row['nom']} {$row['postnom']} {$row['prenom']}</td>
            <td>{$row['numCompt']}</td>
            <td align='right'>".number_format($row['salaire_net'],2,',',' ')."</td>
            <td></td>
        </tr>
    ";

    $total_siege += $row['salaire_net'];
}

/* ==== DERNIER TOTAL ==== */
echo "
    <tr>
        <td colspan='3'><strong>TOTAL SIÈGE</strong></td>
        <td align='right'><strong>".number_format($total_siege,2,',',' ')."</strong></td>
        <td></td>
    </tr>
    </tbody>
    </table>
";
?>

</body>
</html>
