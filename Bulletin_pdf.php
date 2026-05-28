
<?php
require_once __DIR__ . '/vendor/autoload.php'; // charge mPDF
include_once('sys_connexion.php');

$matricule  = $_GET['matric'] ?? '';
$periode    = $_GET['periode'] ?? '';
$type_paie  = $_GET['type_paie'] ?? '';

if (!$matricule || !$periode || !$type_paie) {
    die("Paramètres manquants.");
}

// ✅ 1. RÉCUPÉRATION DES INFOS AGENT
$sql = $db->prepare("
    SELECT matricule, nom, postnom, prenom, N_inss, grade, sexe
    FROM bdd_paie.t_paie
    WHERE matricule=:m AND periode=:p AND type_paie=:t 
    LIMIT 1
");
$sql->execute([':m'=>$matricule, ':p'=>$periode, ':t'=>$type_paie]);
$agent = $sql->fetch(PDO::FETCH_ASSOC);

if (!$agent) die("Aucun bulletin trouvé.");

// ✅ 2. RÉCUPÉRATION DES DÉTAILS
$det = $db->prepare("
    SELECT codeEiPaie, libelle_el_paie, montant_payer, montant_a_retenir, montant_imposa
    FROM bdd_paie.t_paie
    WHERE matricule=:m AND periode=:p AND type_paie=:t
");
$det->execute([':m'=>$matricule, ':p'=>$periode, ':t'=>$type_paie]);
$details = $det->fetchAll(PDO::FETCH_ASSOC);

// ✅ 3. TEMPLATE HTML → PDF
ob_start(); // démarre un buffer invisible
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-family: sans-serif; font-size: 12px; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
th, td { border: 1px solid #000; padding: 4px; }
th { background: #eee; }
h2, h3 { text-align: center; margin: 0; }
</style>
</head>
<body>

<h2>CAISSE GENERALE D'EPARGNE DU CONGO</h2>
<h3>BULLETIN DE PAIE – <?= $periode ?></h3>
<br>

<p>
<b>Matricule :</b> <?= $agent['matricule'] ?><br>
<b>Nom complet :</b> <?= $agent['nom']." ".$agent['postnom']." ".$agent['prenom'] ?><br>
<b>N° INSS :</b> <?= $agent['N_inss'] ?><br>
<b>Grade :</b> <?= $agent['grade'] ?><br>
<b>Sexe :</b> <?= $agent['sexe'] ?><br>
</p>

<table>
<tr>
<th>Code</th>
<th style="text-align:left">Libellé</th>
<th>Montant à Payer</th>
<th>Montant à Retenir</th>
<th>Montant Imposable</th>
</tr>

<?php foreach ($details as $d): ?>
<tr>
<td><?= $d['codeEiPaie'] ?></td>
<td style="text-align:left"><?= $d['libelle_el_paie'] ?></td>
<td><?= number_format($d['montant_payer'],2,",",".") ?></td>
<td><?= number_format($d['montant_a_retenir'],2,",",".") ?></td>
<td><?= number_format($d['montant_imposa'],2,",",".") ?></td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>

<?php

$html = ob_get_clean(); // récupère le HTML

// ✅ 4. GÉNÉRATION DU PDF
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
]);

$mpdf->WriteHTML($html);

// ✅ 5. TÉLÉCHARGEMENT DIRECT
$filename = "bulletin_{$agent['matricule']}_{$periode}.pdf";
$mpdf->Output($filename, \Mpdf\Output\Destination::DOWNLOAD);

exit;
