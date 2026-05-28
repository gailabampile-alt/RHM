<?php
session_start();
include_once('sys_connexion.php');

function formatPeriode($periode) {
    list($mois, $annee) = explode("/", $periode);
    $mois_fr = [
        "01" => "janvier", "02" => "février", "03" => "mars", "04" => "avril",
        "05" => "mai", "06" => "juin", "07" => "juillet", "08" => "août",
        "09" => "septembre", "10" => "octobre", "11" => "novembre", "12" => "décembre"
    ];
    $annee = "20" . $annee; // ex : "25" → "2025"
    return strtoupper($mois_fr[$mois]) . " " . $annee;
}

// Récupération du siège et de la période depuis le formulaire
$code_siege = isset($_GET['code_siege']) ? $_GET['code_siege'] : '';
$periode    = isset($_GET['periode']) ? $_GET['periode'] : '';
$type_paie  = isset($_GET['type_paie']) ? $_GET['type_paie'] : '';

if (empty($code_siege) || empty($periode) || empty($type_paie)) {
    echo "<p style='color:red'>⚠️ Merci de sélectionner un siège et une période.</p>";
    exit();
}

// Récupération des agents pour ce siège et période
$sql = $db->prepare("
    SELECT *
    FROM bdd_paie.t_paie
    WHERE periode = :periode
    AND codeEiPaie = '999' 
    AND type_paie = :type_paie
    GROUP BY matricule, nom
    ORDER BY codesiege, Nom, PostNom, prenom
");

$sql->bindValue(':periode', $periode);
$sql->bindValue(':type_paie', $type_paie);
$sql->execute();

$agents = $sql->fetchAll(PDO::FETCH_ASSOC);

// Calcul du total
$total_general = 0;
foreach ($agents as $ag) {
    $total_general += $ag['montant_payer'];
}

// Récupération du libellé du siège si disponible
$libelle_siege = isset($agents[0]['libelle_siege']) ? $agents[0]['libelle_siege'] : '';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ordre de Paiement - Siège <?= htmlspecialchars($code_siege) ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2, h3,h4 { text-align: center; margin: 0; }  
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th,td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background: #f2f2f2; }
        .total { font-weight: bold; background: #ddd; }
    </style>
</head>
<body>
    
    <h2>CAISSE GENERALE D'EPARGNE DU CONGO</h2>
     <br> 
     <h2>C A D E C O</h2>
    <br>  
    <h4>ORDRE DE PAIEMENT : SALAIRE DU 25 <?= formatPeriode($periode) ?></h4>
  
    <p><b>SIEGE :</b> <?= htmlspecialchars($code_siege) ?>  <?= htmlspecialchars($libelle_siege) ?></p>

    <table>
        <tr>
            <th>Matricule</th>
            <th>Nom complet</th>
            <th>N° Compte</th>
            <th>Net à Payer (FC)</th>
            <th>Signature</th>
        </tr>
        <?php foreach ($agents as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['Matricule']) ?></td>
            <td style="text-align:left"><?= htmlspecialchars($row['Nom'].' '.$row['PostNom'].' '.$row['prenom']) ?></td>
            <td><?= htmlspecialchars($row['numCompt']) ?></td>
            <td style="text-align:right"><?= number_format($row['montant_payer'], 2, ",", ".") ?></td>
            <td></td>
        </tr>
        <?php endforeach; ?>
        <tr class="total">
            <td colspan="3">TOTAL GÉNÉRAL</td>
            <td style="text-align:right"><?= number_format($total_general, 2, ",", ".") ?> FC</td>
            <td></td>
        </tr>
    </table>

    <table style="width:100%; margin-top:50px; border:none;">
        <tr>
            <td style="text-align:left; border:none;">
                Le Directeur des Ressources Humaines <br><br><br>
                <strong>David KASONGO NGOY</strong>
            </td>
            <td style="text-align:right; border:none;">
                Le Directeur Financier <br><br><br>
                <strong>Fabien NGONGO KANDOLO</strong>
            </td>
        </tr>
    </table>

</body>
</html>