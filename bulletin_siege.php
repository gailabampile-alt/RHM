<?php
//session_start();
include_once('sys_connexion.php');
include_once('sys_fonction.php');


// Récupération des paramètres
$code_siege = isset($_GET['code_siege']) ? $_GET['code_siege'] : '';
$periode    = isset($_GET['periode']) ? $_GET['periode'] : '';
$type_paie  = isset($_GET['type_paie']) ? $_GET['type_paie'] : '';

// Vérification
if (empty($code_siege) || empty($periode) || empty($type_paie)) {
    $_SESSION['message'] = "⚠️ Paramètres manquants.";
    $_SESSION['typeMsg'] = "danger";
    header('location:accueil.php?page=Bulletins');
    exit();
}

// Récupération de tous les agents du siège actifs
$sql_agents = $db->prepare("
    SELECT * FROM bdd_paie.t_agent 
    INNER JOIN bdd_paie.detail_agent_siege ON t_agent.matricule=detail_agent_siege.agent_ID 
    INNER JOIN bdd_paie.t_siege ON t_siege.code_sieg=detail_agent_siege.siege_ID 
    WHERE t_siege.code_sieg =:code_siege AND detail_agent_siege.statut_ID='act' 
    ORDER BY t_agent.nom_ag,t_agent.postnom_ag;
");
$sql_agents->bindValue(':code_siege', $code_siege);
$sql_agents->execute();
$agents = $sql_agents->fetchAll(PDO::FETCH_ASSOC);

if (!$agents) {
    die("<h3 style='color:red;'>❌ Aucun agent trouvé pour ce siège</h3>");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>BULLETIN DE PAIE MOIS DE- Siège <?= h($code_siege ?? '') ?></title>
    <style>
        body { font-family: Arial, sans-serif;}
        h2, h3 { text-align: center; }
        .bulletin { page-break-after: always; border:1px solid #000; padding:15px; margin-bottom:30px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: right; }
        th { background: #f2f2f2; }
        .info { margin-bottom: 10px; }
    </style>
</head>
<body>
    
    <?php foreach ($agents as $agent): ?>
        <?php
        // Récupération des détails de paie pour cet agent
        $sql_det = $db->prepare("
            SELECT codeEiPaie, libelle_el_paie,sexe,N_inss, montant_payer, montant_a_retenir, montant_imposa
            FROM bdd_paie.t_paie
            WHERE matricule = :matricule
              AND periode = :periode
              AND type_paie = :type_paie
              ORDER BY codeEiPaie
        ");
        $sql_det->bindValue(':matricule', $agent['matricule']);
        $sql_det->bindValue(':periode', $periode);
        $sql_det->bindValue(':type_paie', $type_paie);
        $sql_det->execute();
        $details = $sql_det->fetchAll(PDO::FETCH_ASSOC);

        if (!$details) continue;

        $total_payer   = 0;
        $total_retenir = 0;
        $total_impos   = 0;
        ?>
        
        <div class="bulletin">
            <h3>CAISSE GENERALE D'EPARGNE DU CONGO</h3>
            <h2 style="text-align:center;">C A D E C O</h2>
              <br> 
            <h4 style="text-align:center;">
    BULLETIN DE PAIE MOIS DE  <?= formatPeriode($periode) ?>
</h4>

            <div class="info">
                <b>Matricule :</b> <?= $agent['matricule'] ?> <br>
                <b>Nom :</b> <?= $agent['nom_ag']." ".$agent['postnom_ag']." ".$agent['prenom_ag'] ?> 
                &nbsp;&nbsp; <b>Sexe :</b> <?= $agent['sexe_ag'] ?><br>
                <b>N° INSS :</b> <?= $agent['NumCNSS_ag'] ?><br>
                <b>Type Paie :</b> <?= h($type_paie ?? '') ?><br>
                <b>Code Siège :</b> <?= h($code_siege ?? '') ?>
            </div>

            <table>
                <tr>
                    <th>Code</th>
                    <th style="text-align:left">Libellé</th>
                    <th>Montant à Payer</th>
                    <th>Montant à Retenir</th>
                    <th>Imposable</th>
                </tr>
                <?php foreach ($details as $row): ?>
                    <tr>
                        <td><?= $row['codeEiPaie'] ?></td>
                        <td style="text-align:left"><?= $row['libelle_el_paie'] ?></td>
                        <td><?= number_format((float)($row['montant_payer'] ?? 0), 2, ",", ".") ?></td>
                        <td><?= number_format((float)($row['montant_a_retenir'] ?? 0), 2, ",", ".") ?></td>
                        <td><?= number_format((float)($row['montant_imposa'] ?? 0), 2, ",", ".") ?></td>
                    </tr>
                    <?php
                        $total_payer   += $row['montant_payer'];
                        $total_retenir += $row['montant_a_retenir'];
                        $total_impos   += $row['montant_imposa'];
                    ?>
                <?php endforeach; ?>
                
                <tr>
                    <th colspan="3" style="text-align:left">999      NET A PAYER</th>
                    <th colspan="2"><?= number_format($row['montant_payer'],2,",",".") ?> FC</th>
                </tr>
            </table>
        </div>
    <?php endforeach; ?>
</body>
</html>