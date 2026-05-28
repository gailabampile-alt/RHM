<?php
include_once('sys_connexion.php');

function calendrier_eng_h($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function calendrier_eng_date_valide($date) {
    if ($date === null || $date === '' || $date === '0000-00-00') {
        return false;
    }
    return strtotime($date) !== false;
}

function calendrier_eng_fin_depuis_debut($dateDebut, $nbreJour) {
    $date = new DateTime($dateDebut);
    $date->modify('+' . max(0, ((int) $nbreJour) - 1) . ' days');
    return $date->format('Y-m-d');
}

function calendrier_eng_classe_statut($statut) {
    switch ($statut) {
        case 'valide':
            return 'approved';
        case 'reporte':
            return 'pending';
        case 'annule':
            return 'refused';
        default:
            return 'active';
    }
}

$tableReady = true;
$tableError = '';
try {
    $db->exec("CREATE TABLE IF NOT EXISTS bdd_paie.t_calendrier_conge_engagement (
        id_planning INT NOT NULL AUTO_INCREMENT,
        matricule VARCHAR(50) NOT NULL,
        exercice INT NOT NULL,
        date_debut DATE NOT NULL,
        date_fin DATE NOT NULL,
        nbre_jour INT NOT NULL DEFAULT 0,
        statut VARCHAR(20) NOT NULL DEFAULT 'planifie',
        observation TEXT NULL,
        creerPar VARCHAR(50) NULL,
        datecreat DATE NULL,
        modifierPar VARCHAR(50) NULL,
        datemodif DATE NULL,
        PRIMARY KEY (id_planning),
        UNIQUE KEY uq_calendrier_conge_engagement (matricule, exercice)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
} catch (Exception $ex) {
    $tableReady = false;
    $tableError = $ex->getMessage();
}

$annee = (int) date('Y');
$dureeDefaut = isset($_GET['duree']) ? (int) $_GET['duree'] : 30;
$agentFiltre = isset($_GET['agent']) ? trim($_GET['agent']) : '';
$siegeFiltre = isset($_GET['siege']) ? trim($_GET['siege']) : '';

if ($dureeDefaut <= 0 || $dureeDefaut > 90) {
    $dureeDefaut = 30;
}

$params = array(':annee' => $annee);
$conditions = array(
    "t_agent.matricule <> ''",
    "t_agent.activiter_ID = '01'",
    "t_agent.dateEngagemnt_ag IS NOT NULL",
    "t_agent.dateEngagemnt_ag <> ''"
);

if ($agentFiltre !== '') {
    $conditions[] = "(t_agent.matricule LIKE :agent OR t_agent.nom_ag LIKE :agent OR t_agent.postnom_ag LIKE :agent OR t_agent.prenom_ag LIKE :agent)";
    $params[':agent'] = '%' . $agentFiltre . '%';
}
if ($siegeFiltre !== '') {
    $conditions[] = "detail_agent_siege.siege_ID = :siege";
    $params[':siege'] = $siegeFiltre;
}

$joinPlanning = $tableReady ? "LEFT JOIN bdd_paie.t_calendrier_conge_engagement planning ON planning.matricule = t_agent.matricule AND planning.exercice = :annee" : "";
$planningFields = $tableReady ? ", planning.date_debut AS plan_debut, planning.date_fin AS plan_fin, planning.nbre_jour AS plan_jour, planning.statut AS plan_statut, planning.observation AS plan_observation" : ", NULL AS plan_debut, NULL AS plan_fin, NULL AS plan_jour, NULL AS plan_statut, NULL AS plan_observation";

$sql = "SELECT t_agent.matricule, t_agent.nom_ag, t_agent.postnom_ag, t_agent.prenom_ag, t_agent.dateEngagemnt_ag,
            detail_agent_siege.siege_ID, t_siege.libelle_sieg" . $planningFields . "
        FROM bdd_paie.t_agent
        INNER JOIN bdd_paie.detail_agent_siege ON detail_agent_siege.agent_ID = t_agent.matricule AND detail_agent_siege.statut_ID = 'act'
        INNER JOIN bdd_paie.t_siege ON t_siege.code_sieg = detail_agent_siege.siege_ID
        " . $joinPlanning . "
        WHERE " . implode(' AND ', $conditions) . "
        ORDER BY t_siege.libelle_sieg, MONTH(t_agent.dateEngagemnt_ag), DAY(t_agent.dateEngagemnt_ag), t_agent.nom_ag";

$reqAgents = $db->prepare($sql);
foreach ($params as $key => $value) {
    $reqAgents->bindValue($key, $value);
}
$reqAgents->execute();
$agents = $reqAgents->fetchAll(PDO::FETCH_ASSOC);

$planning = array();
$stats = array('total' => 0, 'planifie' => 0, 'valide' => 0, 'reporte' => 0, 'annule' => 0, 'jours' => 0);

foreach ($agents as $agent) {
    if (!calendrier_eng_date_valide($agent['dateEngagemnt_ag'])) {
        continue;
    }

    $engagement = new DateTime($agent['dateEngagemnt_ag']);
    $debutPropose = sprintf('%04d-%02d-%02d', $annee, (int) $engagement->format('m'), (int) $engagement->format('d'));

    if (!calendrier_eng_date_valide($debutPropose)) {
        $debutPropose = sprintf('%04d-%02d-28', $annee, (int) $engagement->format('m'));
    }

    $dateDebut = $agent['plan_debut'] ?: $debutPropose;
    $nbreJour = $agent['plan_jour'] ?: $dureeDefaut;
    $dateFin = $agent['plan_fin'] ?: calendrier_eng_fin_depuis_debut($dateDebut, $nbreJour);
    $statut = $agent['plan_statut'] ?: 'planifie';

    $agent['date_debut_calculee'] = $dateDebut;
    $agent['date_fin_calculee'] = $dateFin;
    $agent['nbre_jour_calcule'] = $nbreJour;
    $agent['statut_calcule'] = $statut;
    $planning[] = $agent;

    $stats['total']++;
    $stats['jours'] += (int) $nbreJour;
    if (isset($stats[$statut])) {
        $stats[$statut]++;
    }
}

$planningParMois = array();
for ($i = 1; $i <= 12; $i++) {
    $planningParMois[$i] = array();
}
foreach ($planning as $ligne) {
    $mois = (int) date('n', strtotime($ligne['date_debut_calculee']));
    $planningParMois[$mois][] = $ligne;
}

$nomsMois = array('', 'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');

$reqSieges = $db->prepare("SELECT code_sieg, libelle_sieg FROM bdd_paie.t_siege ORDER BY libelle_sieg ASC");
$reqSieges->execute();
$sieges = $reqSieges->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    .eng-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin: 15px; flex-wrap: wrap; }
    .eng-toolbar h3 { margin: 0; }
    .eng-panel { margin: 15px; padding: 16px; background: #fff; border: 1px solid #ddd; border-radius: 4px; }
    .eng-stats { display: grid; grid-template-columns: repeat(5, minmax(130px, 1fr)); gap: 12px; margin: 15px; }
    .eng-stat { background: #fff; border: 1px solid #ddd; border-left: 4px solid #1384C8; border-radius: 4px; padding: 12px 14px; min-height: 74px; }
    .eng-stat strong { display: block; color: #2f323a; font-size: 24px; line-height: 28px; }
    .eng-stat span { color: #777; font-size: 12px; text-transform: uppercase; }
    .eng-stat.pending { border-left-color: #f0ad4e; }
    .eng-stat.approved { border-left-color: #5cb85c; }
    .eng-stat.refused { border-left-color: #d9534f; }
    .eng-month-grid { display: grid; grid-template-columns: repeat(4, minmax(180px, 1fr)); gap: 12px; }
    .eng-month { border: 1px solid #ddd; border-radius: 4px; min-height: 130px; background: #fafafa; }
    .eng-month-title { padding: 9px 10px; border-bottom: 1px solid #ddd; background: #f4f4f4; color: #2f323a; font-weight: 700; }
    .eng-event { display: block; margin: 8px; padding: 7px 8px; border-radius: 3px; color: #fff; font-size: 12px; line-height: 15px; }
    .eng-event.active { background: #1384C8; }
    .eng-event.approved { background: #5cb85c; }
    .eng-event.pending { background: #f0ad4e; }
    .eng-event.refused { background: #d9534f; }
    .eng-event small { display: block; opacity: .92; }
    .eng-empty { padding: 10px; color: #999; }
    .eng-badge { display: inline-block; padding: 4px 8px; border-radius: 12px; color: #fff; font-size: 11px; }
    .eng-badge.active { background: #1384C8; }
    .eng-badge.approved { background: #5cb85c; }
    .eng-badge.pending { background: #f0ad4e; }
    .eng-badge.refused { background: #d9534f; }
    .eng-table input, .eng-table select { min-width: 110px; }
    .eng-table textarea { min-width: 160px; min-height: 34px; resize: vertical; }
    @media (max-width: 991px) {
        .eng-stats { grid-template-columns: repeat(2, minmax(130px, 1fr)); }
        .eng-month-grid { grid-template-columns: repeat(2, minmax(160px, 1fr)); }
    }
    @media (max-width: 620px) {
        .eng-month-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="eng-toolbar">
    <h3><i class="fa fa-calendar-plus-o"></i> Planning des conges par date d'engagement</h3>
    <div>
        <a class="btn btn-round btn-default" href="accueil.php?page=Calendrier_Conges"><i class="fa fa-calendar"></i> Calendrier demandes</a>
        <a class="btn btn-round btn-primary" href="accueil.php?page=Demande_Conger"><i class="fa fa-plus-circle"></i> Nouvelle demande</a>
    </div>
</div>

<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-<?php echo calendrier_eng_h($_SESSION['typeMsg']); ?>" style="margin:15px;">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <span><?php echo calendrier_eng_h($_SESSION['message']); unset($_SESSION['message']); unset($_SESSION['typeMsg']); ?></span>
    </div>
<?php } ?>

<?php if (!$tableReady) { ?>
    <div class="alert alert-danger" style="margin:15px;">La table du planning n'a pas pu etre preparee : <?php echo calendrier_eng_h($tableError); ?></div>
<?php } ?>

<div class="eng-panel">
    <form method="GET" action="accueil.php">
        <input type="hidden" name="page" value="Calendrier_Engagement">
        <div class="row">
            <div class="col-md-2">
                <label>Exercice</label>
                <input class="form-control" type="number" value="<?php echo calendrier_eng_h($annee); ?>" readonly>
            </div>
            <div class="col-md-2">
                <label>Durée</label>
                <input class="form-control" type="number" name="duree" min="1" max="90" value="<?php echo calendrier_eng_h($dureeDefaut); ?>">
            </div>
            <div class="col-md-3">
                <label>Siege</label>
                <select class="form-control chzn-select" name="siege">
                    <option value="">Tous les sieges</option>
                    <?php foreach ($sieges as $siege) { ?>
                        <option value="<?php echo calendrier_eng_h($siege['code_sieg']); ?>" <?php echo (string) $siegeFiltre === (string) $siege['code_sieg'] ? 'selected' : ''; ?>>
                            <?php echo calendrier_eng_h($siege['code_sieg'] . ' | ' . $siege['libelle_sieg']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label>Agent</label>
                <input class="form-control" type="text" name="agent" value="<?php echo calendrier_eng_h($agentFiltre); ?>" placeholder="Matricule ou nom">
            </div>
            <div class="col-md-2">
                <label>&nbsp;</label>
                <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-search"></i> Filtrer</button>
            </div>
        </div>
    </form>
</div>

<div class="eng-stats">
    <div class="eng-stat"><strong><?php echo calendrier_eng_h($stats['total']); ?></strong><span>Agents planifies</span></div>
    <div class="eng-stat"><strong><?php echo calendrier_eng_h($stats['jours']); ?></strong><span>Jours proposes</span></div>
    <div class="eng-stat approved"><strong><?php echo calendrier_eng_h($stats['valide']); ?></strong><span>Valides</span></div>
    <div class="eng-stat pending"><strong><?php echo calendrier_eng_h($stats['reporte']); ?></strong><span>Reportes</span></div>
    <div class="eng-stat refused"><strong><?php echo calendrier_eng_h($stats['annule']); ?></strong><span>Annules</span></div>
</div>

<div class="eng-panel">
    <h4><i class="fa fa-calendar"></i> Vue annuelle proposee - <?php echo calendrier_eng_h($annee); ?></h4>
    <div class="eng-month-grid">
        <?php for ($mois = 1; $mois <= 12; $mois++) { ?>
            <div class="eng-month">
                <div class="eng-month-title"><?php echo calendrier_eng_h($nomsMois[$mois]); ?></div>
                <?php if (count($planningParMois[$mois]) === 0) { ?>
                    <div class="eng-empty">Aucun depart</div>
                <?php } ?>
                <?php foreach (array_slice($planningParMois[$mois], 0, 5) as $event) {
                    $nom = trim($event['nom_ag'] . ' ' . $event['postnom_ag']);
                    $classe = calendrier_eng_classe_statut($event['statut_calcule']);
                ?>
                    <span class="eng-event <?php echo calendrier_eng_h($classe); ?>">
                        <?php echo calendrier_eng_h($nom); ?>
                        <small><?php echo calendrier_eng_h($event['date_debut_calculee'] . ' au ' . $event['date_fin_calculee']); ?></small>
                    </span>
                <?php } ?>
                <?php if (count($planningParMois[$mois]) > 5) { ?>
                    <div class="eng-empty">+<?php echo count($planningParMois[$mois]) - 5; ?> autre(s)</div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

<div class="eng-panel">
    <form method="POST" action="save_calendrier_engagement.php">
        <input type="hidden" name="exercice" value="<?php echo calendrier_eng_h($annee); ?>">
        <div class="table-responsive">
            <table id="planning-engagement-table" class="display table table-bordered table-striped eng-table">
                <thead>
                    <tr>
                        <th>Matricule</th>
                        <th>Agent</th>
                        <th>Siege</th>
                        <th>Date engagement</th>
                        <th>Debut propose/modifie</th>
                        <th>Fin</th>
                        <th>Jours</th>
                        <th>Statut</th>
                        <th>Observation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($planning) === 0) { ?>
                        <tr><td colspan="9" class="text-center">Aucun agent actif avec date d'engagement trouve pour ce siege.</td></tr>
                    <?php } ?>
                    <?php foreach ($planning as $index => $ligne) { ?>
                        <tr>
                            <td>
                                <?php echo calendrier_eng_h($ligne['matricule']); ?>
                                <input type="hidden" name="matricule[]" value="<?php echo calendrier_eng_h($ligne['matricule']); ?>">
                            </td>
                            <td><?php echo calendrier_eng_h(trim($ligne['nom_ag'] . ' ' . $ligne['postnom_ag'] . ' ' . $ligne['prenom_ag'])); ?></td>
                            <td><?php echo calendrier_eng_h($ligne['siege_ID'] . ' | ' . $ligne['libelle_sieg']); ?></td>
                            <td><?php echo calendrier_eng_h($ligne['dateEngagemnt_ag']); ?></td>
                            <td><input class="form-control js-eng-start" type="date" name="date_debut[]" value="<?php echo calendrier_eng_h($ligne['date_debut_calculee']); ?>"></td>
                            <td><input class="form-control js-eng-end" type="date" name="date_fin[]" value="<?php echo calendrier_eng_h($ligne['date_fin_calculee']); ?>"></td>
                            <td><input class="form-control js-eng-days" type="number" name="nbre_jour[]" min="1" max="90" value="<?php echo calendrier_eng_h($ligne['nbre_jour_calcule']); ?>"></td>
                            <td>
                                <select class="form-control" name="statut[]">
                                    <option value="planifie" <?php echo $ligne['statut_calcule'] === 'planifie' ? 'selected' : ''; ?>>Planifie</option>
                                    <option value="valide" <?php echo $ligne['statut_calcule'] === 'valide' ? 'selected' : ''; ?>>Valide</option>
                                    <option value="reporte" <?php echo $ligne['statut_calcule'] === 'reporte' ? 'selected' : ''; ?>>Reporte</option>
                                    <option value="annule" <?php echo $ligne['statut_calcule'] === 'annule' ? 'selected' : ''; ?>>Annule</option>
                                </select>
                            </td>
                            <td><textarea class="form-control" name="observation[]"><?php echo calendrier_eng_h($ligne['plan_observation']); ?></textarea></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <button class="btn btn-round btn-primary" type="submit" name="save_planning_engagement" <?php echo !$tableReady ? 'disabled' : ''; ?>>
            <i class="fa fa-save"></i> Enregistrer les modifications
        </button>
    </form>
</div>

<script>
document.querySelectorAll('.eng-table tbody tr').forEach(function(row) {
    var start = row.querySelector('.js-eng-start');
    var end = row.querySelector('.js-eng-end');
    var days = row.querySelector('.js-eng-days');
    if (!start || !end || !days) {
        return;
    }
    function refreshEnd() {
        if (!start.value || !days.value) {
            return;
        }
        var date = new Date(start.value + 'T00:00:00');
        date.setDate(date.getDate() + parseInt(days.value, 10) - 1);
        end.value = date.toISOString().slice(0, 10);
    }
    start.addEventListener('change', refreshEnd);
    days.addEventListener('change', refreshEnd);
});

$(document).ready(function() {
    if ($.fn.dataTable && $('#planning-engagement-table').length) {
        $('#planning-engagement-table').dataTable({
            "aaSorting": [[2, "asc"]],
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]]
        });
    }
});
</script>
