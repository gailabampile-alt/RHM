
<?php
/* ================= DEBUG ================= */
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'sys_connexion.php';
require_once 'sys_fonction.php';
set_time_limit(600);

/* ================= PERIODE ================= */
function formatPeriode(string $periode): string {
    [$m, $y] = explode('/', $periode);
    if (strlen($y) === 2) {
        $y = '20' . $y;
    }

    $mois = [
        '01'=>'JANVIER','02'=>'FÉVRIER','03'=>'MARS',
        '04'=>'AVRIL','05'=>'MAI','06'=>'JUIN',
        '07'=>'JUILLET','08'=>'AOÛT','09'=>'SEPTEMBRE',
        '10'=>'OCTOBRE','11'=>'NOVEMBRE','12'=>'DÉCEMBRE'
    ];

    return ($mois[$m] ?? '') . ' ' . $y;
}

/* ================= PARAMETRES ================= */
$matricule = $_GET['matric'] ?? '';
$periode   = $_GET['periode'] ?? '';
$type_paie = $_GET['type_paie'] ?? '';
$printBy   = $_GET['Print_by'] ?? '';
$codeSiege = $_GET['code_siege'] ?? '';
$format    = strtolower($_GET['format'] ?? 'html');

if (!$periode || !$type_paie || !$printBy) {
    die('Paramètres manquants.');
}

if (!in_array($format, ['html', 'pdf'], true)) {
    $format = 'html';
}

/* ================= DONNEES ================= */
function chargerAgent(PDO $db, string $mat, string $periode, string $type_paie): ?array {
    $req = $db->prepare("
        SELECT matricule, nom, postnom, prenom,
               N_inss, sexe, grade, codesiege, sit_famille
        FROM bdd_paie.t_paie
        WHERE matricule = :m
          AND periode = :p
          AND type_paie = :t
        LIMIT 1
    ");
    $req->execute([
        ':m'=>$mat,
        ':p'=>$periode,
        ':t'=>$type_paie
    ]);
    return $req->fetch(PDO::FETCH_ASSOC) ?: null;
}

function chargerDetails(PDO $db, string $mat, string $periode, string $type_paie): array {
    $req = $db->prepare("
        SELECT codeEiPaie, libelle_el_paie,
               COALESCE(montant_payer,0)      AS montant_payer,
               COALESCE(montant_a_retenir,0) AS montant_a_retenir,
               COALESCE(montant_imposa,0)    AS montant_imposa
        FROM bdd_paie.t_paie
        WHERE matricule = :m
          AND periode = :p
          AND type_paie = :t
        ORDER BY codeEiPaie
    ");
    $req->execute([
        ':m'=>$mat,
        ':p'=>$periode,
        ':t'=>$type_paie
    ]);
    return $req->fetchAll(PDO::FETCH_ASSOC);
}

function chargerPointage(PDO $db, string $mat, string $periode): int {
    $req = $db->prepare("SELECT nbrejrs FROM bdd_paie.t_pointage WHERE matric = :m AND periode = :p ORDER BY id_pointage DESC LIMIT 1");
    $req->execute([
        ':m' => $mat,
        ':p' => $periode
    ]);
    $row = $req->fetch(PDO::FETCH_ASSOC);
    return $row ? (int)$row['nbrejrs'] : 26;
}

/* ================= AFFICHAGE ================= */
function afficherBulletin(?array $agent, array $details, string $periode, int $nbrejours = 26, string $format = 'html'): void {

    if (empty($agent)) {
       $_SESSION['message'] = "⚠️Aucun agent trouvé pour la période ou le matricule spécifié";
       $_SESSION['typeMsg'] = "warning";
       header("Location: accueil.php?page=Bulletins");
       exit;
    }

    /* ===== CALCUL NET ===== */
    $totalPayer = 0.0;
    $totalRetenue = 0.0;
    $netFromDb = null;

    foreach ($details as $d) {
        if ((string)$d['codeEiPaie'] === '999' || (int)$d['codeEiPaie'] === 999) {
            $netFromDb = (float)$d['montant_payer'];
            continue;
        }

        $totalPayer += (float)$d['montant_payer'];
        $totalRetenue += (float)$d['montant_a_retenir'];
    }

    $net = $netFromDb !== null ? $netFromDb : ($totalPayer - $totalRetenue);
    ?>

    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width:100%; font-size:13px; }
        td { border:1px solid #000; padding:4px; }
        .center { text-align:center; }
        .right { text-align:right; }
        .bold  { font-weight:bold; }
        .logo-header { width:100%; border:none; margin-bottom:10px; }
        .logo-header td { border:none; vertical-align:middle; padding:0; }
        .logo-header img { width:70px; height:auto; }
        .logo-header .logo-text { padding-left:10px; text-align:left; }
    </style>

    <!-- ================= ENTETE CADECO ================= -->
    <?php if ($format === 'pdf'): ?>
        

        <table style="width:100%; border:none;">
            <tr>
               <td border:none;>
                    <img src="img/Logo CADECO1.jpg" style="width:70px;">
                </td>
                <td style="text-align:center;">
                    <b>CAISSE GENERALE D'EPARGNE DU CONGO</b><br>
                    <span style="letter-spacing:5px;">C A D E C O</span><br>
                    <small>Société Anonyme Unipersonnelle</small>
                </td>
            </tr>
        </table>
    </div>


    <?php else: ?>
        <div class="center bold">
            <div style="font-size:15px;">CAISSE GENERALE D’EPARGNE DU CONGO</div>
            <div style="font-size:14px;letter-spacing:6px;">C A D E C O</div>
        </div>
    <?php endif; ?>
    <hr style="border:1px solid #000; margin-bottom:10px;">

    <table>
        <tr class="bold">
            <td style="width:30%;">SIEGE : <?= h($agent['codesiege'] ?? '') ?></td>
            <td class="center" style="width:40%;">BULLETIN DE PAIE</td>
            <td class="right" style="width:30%;">MOIS : <?= formatPeriode($periode) ?></td>
        </tr>
    </table>

    <br>

    <!-- ================= IDENTITE ================= -->
    <table>
        <tr class="bold center">
            <td>MATRICULE</td>
            <td>NOM & POST‑NOM</td>
            <td>N° INSS</td>
            <td>SIT.F</td>
            <td>JrsP</td>
            <td>SEXE</td>
            <td>GRADE</td>
        </tr>
        <tr class="center">
            <td><?= h($agent['matricule'] ?? '') ?></td>
            <td><?= h(($agent['nom'] ?? '').' '.($agent['postnom'] ?? '').' '.($agent['prenom'] ?? '')) ?></td>
            <td><?= h($agent['N_inss'] ?? '') ?></td>
            <td><?= h($agent['sit_famille'] ?? '') ?></td>
            <td><?= $nbrejours ?></td>
            <td><?= h($agent['sexe'] ?? '') ?></td>
            <td><?= h($agent['grade'] ?? '') ?></td>
        </tr>
    </table>

    <br>

    <!-- ================= DETAILS ================= -->
    <table>
        <tr class="bold center">
            <td>Code</td>
            <td>Libellé</td>
            <td>Montant à payer</td>
            <td>Montant retenu</td>
            <td>Imposable</td>
        </tr>

        <?php foreach ($details as $d): ?>
        <tr>
            <td class="center"><?= h($d['codeEiPaie'] ?? '') ?></td>
            <td><?= h($d['libelle_el_paie'] ?? '') ?></td>
            <td class="right"><?= number_format((float)$d['montant_payer'], 2, ',', ' ') ?></td>
            <td class="right"><?= number_format((float)$d['montant_a_retenir'], 2, ',', ' ') ?></td>
            <td class="right"><?= number_format((float)$d['montant_imposa'], 2, ',', ' ') ?></td>
        </tr>
        <?php endforeach; ?>

        <tr class="bold center">
            <td colspan="2">NET À PAYER</td>
            <td colspan="3" style="text-align:center; font-weight:bold;"><?= number_format($net, 2, ',', ' ') ?>  FC</td>
        </tr>
    </table>

    <?php
}

/* ================= TRAITEMENT ================= */
if ($format === 'pdf') {
    ob_start();
    echo '<!DOCTYPE html><html><head><meta charset="utf-8"><style>';
    echo 'body{font-family:Arial,sans-serif;}table{border-collapse:collapse;width:100%;font-size:13px;}td{border:1px solid #000;padding:4px;} .center{text-align:center;} .right{text-align:right;} .bold{font-weight:bold;}';
    echo '</style></head><body>';
}

if ($printBy === 'I') {

    if (!$matricule) {
        die('Matricule manquant pour impression individuelle.');
    }

    afficherBulletin(
        chargerAgent($db,$matricule,$periode,$type_paie),
        chargerDetails($db,$matricule,$periode,$type_paie),
        $periode,
        chargerPointage($db,$matricule,$periode),
        $format
    );

} elseif ($printBy === 'S') {

    $list = $db->prepare("
        SELECT DISTINCT matricule
        FROM bdd_paie.t_paie
        WHERE periode=:p
          AND type_paie=:t
          AND codesiege=:s
    ");
    $list->execute([':p'=>$periode, ':t'=>$type_paie, ':s'=>$codeSiege]);

    foreach ($list->fetchAll(PDO::FETCH_COLUMN) as $mat) {
        afficherBulletin(
            chargerAgent($db,$mat,$periode,$type_paie),
            chargerDetails($db,$mat,$periode,$type_paie),
            $periode,
            chargerPointage($db,$mat,$periode),
            $format
        );
        echo "<div style='page-break-after:always'></div>";
    }

} elseif ($printBy === 'T') {

    $list = $db->prepare("
        SELECT DISTINCT matricule
        FROM bdd_paie.t_paie
        WHERE periode=:p
          AND type_paie=:t
    ");
    $list->execute([':p'=>$periode, ':t'=>$type_paie]);

    foreach ($list->fetchAll(PDO::FETCH_COLUMN) as $mat) {
        afficherBulletin(
            chargerAgent($db,$mat,$periode,$type_paie),
            chargerDetails($db,$mat,$periode,$type_paie),
            $periode,
            chargerPointage($db,$mat,$periode),
            $format
        );
        echo "<div style='page-break-after:always'></div>";
    }
}

if ($format === 'pdf') {
    echo '</body></html>';
    $html = ob_get_clean();
    require_once __DIR__ . '/vendor/autoload.php';
    $mpdf = new \Mpdf\Mpdf([ 'mode' => 'utf-8', 'format' => 'A4' ]);
    $mpdf->WriteHTML($html);
    $filename = 'bulletins_' . str_replace(['/', ' '], ['_', '_'], $periode) . '.pdf';
    $mpdf->Output($filename, \Mpdf\Output\Destination::INLINE);
    exit;
}
?>
