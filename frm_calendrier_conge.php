<?php
include_once('sys_connexion.php');

function calendrier_conge_h($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function calendrier_conge_libelle_statut($statut) {
    switch ($statut) {
        case 'naprv':
            return 'En attente';
        case 'auto':
            return 'Autorise';
        case 'encours':
            return 'En cours';
        case 'nauto':
            return 'Refuse';
        default:
            return $statut ?: 'Non defini';
    }
}

function calendrier_conge_classe_statut($statut) {
    switch ($statut) {
        case 'naprv':
            return 'pending';
        case 'auto':
            return 'approved';
        case 'encours':
            return 'active';
        case 'nauto':
            return 'refused';
        default:
            return 'neutral';
    }
}

$mois = isset($_GET['mois']) ? (int) $_GET['mois'] : (int) date('m');
$annee = isset($_GET['annee']) ? (int) $_GET['annee'] : (int) date('Y');
$statutFiltre = isset($_GET['statut']) ? trim($_GET['statut']) : '';
$typeFiltre = isset($_GET['type_conge']) ? trim($_GET['type_conge']) : '';
$agentFiltre = isset($_GET['agent']) ? trim($_GET['agent']) : '';

if ($mois < 1 || $mois > 12) {
    $mois = (int) date('m');
}
if ($annee < 2000 || $annee > 2100) {
    $annee = (int) date('Y');
}

$debutMois = new DateTime(sprintf('%04d-%02d-01', $annee, $mois));
$finMois = clone $debutMois;
$finMois->modify('last day of this month');
$debutCalendrier = clone $debutMois;
$debutCalendrier->modify('-' . ((int) $debutCalendrier->format('N') - 1) . ' days');
$finCalendrier = clone $finMois;
$finCalendrier->modify('+' . (7 - (int) $finCalendrier->format('N')) . ' days');

$moisPrecedent = clone $debutMois;
$moisPrecedent->modify('-1 month');
$moisSuivant = clone $debutMois;
$moisSuivant->modify('+1 month');

$conditions = array(
    't_demandeconge.date_debut <= :fin_mois',
    't_demandeconge.date_fin >= :debut_mois',
    "t_demandeconge.etat IN ('act', 'desac')"
);
$params = array(
    ':debut_mois' => $debutMois->format('Y-m-d'),
    ':fin_mois' => $finMois->format('Y-m-d')
);

if ($statutFiltre !== '') {
    $conditions[] = 't_demandeconge.statut = :statut';
    $params[':statut'] = $statutFiltre;
}
if ($typeFiltre !== '') {
    $conditions[] = 't_demandeconge.id_typeconge = :type_conge';
    $params[':type_conge'] = $typeFiltre;
}
if ($agentFiltre !== '') {
    $conditions[] = '(t_demandeconge.matricule LIKE :agent OR t_agent.nom_ag LIKE :agent OR t_agent.postnom_ag LIKE :agent OR t_agent.prenom_ag LIKE :agent)';
    $params[':agent'] = '%' . $agentFiltre . '%';
}

$sql = 'SELECT t_demandeconge.*, t_typconge.libelle_conge, t_agent.nom_ag, t_agent.postnom_ag, t_agent.prenom_ag
        FROM bdd_paie.t_demandeconge
        INNER JOIN bdd_paie.t_typconge ON t_typconge.id_type_conge = t_demandeconge.id_typeconge
        INNER JOIN bdd_paie.t_agent ON t_agent.matricule = t_demandeconge.matricule
        WHERE ' . implode(' AND ', $conditions) . '
        ORDER BY t_demandeconge.date_debut ASC, t_agent.nom_ag ASC';

$reqConges = $db->prepare($sql);
foreach ($params as $key => $value) {
    $reqConges->bindValue($key, $value);
}
$reqConges->execute();
$conges = $reqConges->fetchAll(PDO::FETCH_ASSOC);

$eventsParJour = array();
$stats = array('total' => count($conges), 'naprv' => 0, 'auto' => 0, 'encours' => 0, 'nauto' => 0, 'jours' => 0);

foreach ($conges as $conge) {
    $statut = $conge['statut'];
    if (isset($stats[$statut])) {
        $stats[$statut]++;
    }

    $eventStart = new DateTime($conge['date_debut']);
    $eventEnd = new DateTime($conge['date_fin']);
    $visibleStart = $eventStart > $debutMois ? clone $eventStart : clone $debutMois;
    $visibleEnd = $eventEnd < $finMois ? clone $eventEnd : clone $finMois;
    if ($visibleStart <= $visibleEnd) {
        $stats['jours'] += $visibleStart->diff($visibleEnd)->days + 1;
    }

    $jour = $eventStart > $debutCalendrier ? clone $eventStart : clone $debutCalendrier;
    $limite = $eventEnd < $finCalendrier ? clone $eventEnd : clone $finCalendrier;
    while ($jour <= $limite) {
        $cle = $jour->format('Y-m-d');
        if (!isset($eventsParJour[$cle])) {
            $eventsParJour[$cle] = array();
        }
        $eventsParJour[$cle][] = $conge;
        $jour->modify('+1 day');
    }
}

$reqTypes = $db->prepare('SELECT id_type_conge, libelle_conge FROM bdd_paie.t_typconge ORDER BY libelle_conge ASC');
$reqTypes->execute();
$typesConge = $reqTypes->fetchAll(PDO::FETCH_ASSOC);
$nomsMois = array('', 'Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
$joursSemaine = array('Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim');
?>

<style>
    .leave-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin: 15px; flex-wrap: wrap; }
    .leave-toolbar h3 { margin: 0; }
    .leave-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .leave-filter-panel, .leave-calendar-panel, .leave-list-panel { margin: 15px; padding: 16px; background: #fff; border: 1px solid #ddd; border-radius: 4px; }
    .leave-stats { display: grid; grid-template-columns: repeat(5, minmax(130px, 1fr)); gap: 12px; margin: 15px; }
    .leave-stat { background: #fff; border: 1px solid #ddd; border-left: 4px solid #1384C8; border-radius: 4px; padding: 12px 14px; min-height: 74px; }
    .leave-stat strong { display: block; color: #2f323a; font-size: 24px; line-height: 28px; }
    .leave-stat span { color: #777; font-size: 12px; text-transform: uppercase; }
    .leave-stat.pending { border-left-color: #f0ad4e; }
    .leave-stat.approved { border-left-color: #5cb85c; }
    .leave-stat.active { border-left-color: #1384C8; }
    .leave-stat.refused { border-left-color: #d9534f; }
    .leave-calendar-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; gap: 12px; flex-wrap: wrap; }
    .leave-calendar-title { font-size: 20px; font-weight: 700; color: #2f323a; }
    .leave-calendar-grid { display: grid; grid-template-columns: repeat(7, minmax(110px, 1fr)); border: 1px solid #ddd; border-right: 0; border-bottom: 0; overflow-x: auto; }
    .leave-calendar-day-name, .leave-calendar-cell { border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; min-width: 110px; }
    .leave-calendar-day-name { padding: 9px; background: #f7f7f7; color: #555; font-weight: 700; text-align: center; }
    .leave-calendar-cell { min-height: 128px; padding: 8px; background: #fff; }
    .leave-calendar-cell.out-month { background: #fafafa; color: #aaa; }
    .leave-calendar-cell.today { box-shadow: inset 0 0 0 2px #1384C8; }
    .leave-day-number { display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; font-weight: 700; color: #2f323a; }
    .leave-count { color: #777; font-size: 11px; font-weight: 400; }
    .leave-event { display: block; margin-bottom: 5px; padding: 5px 6px; border-radius: 3px; color: #fff; font-size: 11px; line-height: 14px; overflow: hidden; }
    .leave-event.pending { background: #f0ad4e; }
    .leave-event.approved { background: #5cb85c; }
    .leave-event.active { background: #1384C8; }
    .leave-event.refused { background: #d9534f; }
    .leave-event.neutral { background: #777; }
    .leave-event small { display: block; opacity: .9; }
    .leave-more { color: #777; font-size: 11px; }
    .leave-badge { display: inline-block; padding: 4px 8px; border-radius: 12px; color: #fff; font-size: 11px; }
    .leave-badge.pending { background: #f0ad4e; }
    .leave-badge.approved { background: #5cb85c; }
    .leave-badge.active { background: #1384C8; }
    .leave-badge.refused { background: #d9534f; }
    .leave-badge.neutral { background: #777; }
    @media (max-width: 991px) {
        .leave-stats { grid-template-columns: repeat(2, minmax(130px, 1fr)); }
        .leave-calendar-grid { grid-template-columns: repeat(7, minmax(92px, 1fr)); }
        .leave-calendar-day-name, .leave-calendar-cell { min-width: 92px; }
    }
</style>

<div class="leave-toolbar">
    <h3><i class="fa fa-calendar"></i> Calendrier des conges</h3>
    <div class="leave-actions">
        <a class="btn btn-round btn-default" href="accueil.php?page=Calendrier_Conges&amp;mois=<?php echo $moisPrecedent->format('m'); ?>&amp;annee=<?php echo $moisPrecedent->format('Y'); ?>&amp;statut=<?php echo calendrier_conge_h($statutFiltre); ?>&amp;type_conge=<?php echo calendrier_conge_h($typeFiltre); ?>&amp;agent=<?php echo calendrier_conge_h($agentFiltre); ?>"><i class="fa fa-chevron-left"></i> Mois precedent</a>
        <a class="btn btn-round btn-default" href="accueil.php?page=Calendrier_Conges&amp;mois=<?php echo date('m'); ?>&amp;annee=<?php echo date('Y'); ?>"><i class="fa fa-dot-circle-o"></i> Aujourd'hui</a>
        <a class="btn btn-round btn-default" href="accueil.php?page=Calendrier_Conges&amp;mois=<?php echo $moisSuivant->format('m'); ?>&amp;annee=<?php echo $moisSuivant->format('Y'); ?>&amp;statut=<?php echo calendrier_conge_h($statutFiltre); ?>&amp;type_conge=<?php echo calendrier_conge_h($typeFiltre); ?>&amp;agent=<?php echo calendrier_conge_h($agentFiltre); ?>">Mois suivant <i class="fa fa-chevron-right"></i></a>
        <a class="btn btn-round btn-primary" href="accueil.php?page=Demande_Conger"><i class="fa fa-plus-circle"></i> Nouvelle demande</a>
    </div>
</div>

<div class="leave-filter-panel">
    <form method="GET" action="accueil.php">
        <input type="hidden" name="page" value="Calendrier_Conges">
        <div class="row">
            <div class="col-md-2">
                <label>Mois</label>
                <select class="form-control" name="mois">
                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                        <option value="<?php echo $i; ?>" <?php echo $i === $mois ? 'selected' : ''; ?>><?php echo calendrier_conge_h($nomsMois[$i]); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2">
                <label>Annee</label>
                <input class="form-control" type="number" name="annee" min="2000" max="2100" value="<?php echo calendrier_conge_h($annee); ?>">
            </div>
            <div class="col-md-2">
                <label>Statut</label>
                <select class="form-control" name="statut">
                    <option value="">Tous</option>
                    <option value="naprv" <?php echo $statutFiltre === 'naprv' ? 'selected' : ''; ?>>En attente</option>
                    <option value="auto" <?php echo $statutFiltre === 'auto' ? 'selected' : ''; ?>>Autorise</option>
                    <option value="encours" <?php echo $statutFiltre === 'encours' ? 'selected' : ''; ?>>En cours</option>
                    <option value="nauto" <?php echo $statutFiltre === 'nauto' ? 'selected' : ''; ?>>Refuse</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Type de conge</label>
                <select class="form-control" name="type_conge">
                    <option value="">Tous</option>
                    <?php foreach ($typesConge as $type) { ?>
                        <option value="<?php echo calendrier_conge_h($type['id_type_conge']); ?>" <?php echo (string) $typeFiltre === (string) $type['id_type_conge'] ? 'selected' : ''; ?>><?php echo calendrier_conge_h($type['libelle_conge']); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label>Agent</label>
                <div class="input-group">
                    <input class="form-control" type="text" name="agent" value="<?php echo calendrier_conge_h($agentFiltre); ?>" placeholder="Matricule ou nom">
                    <span class="input-group-btn"><button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button></span>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="leave-stats">
    <div class="leave-stat"><strong><?php echo calendrier_conge_h($stats['total']); ?></strong><span>Demandes visibles</span></div>
    <div class="leave-stat active"><strong><?php echo calendrier_conge_h($stats['jours']); ?></strong><span>Jours planifies</span></div>
    <div class="leave-stat pending"><strong><?php echo calendrier_conge_h($stats['naprv']); ?></strong><span>En attente</span></div>
    <div class="leave-stat approved"><strong><?php echo calendrier_conge_h($stats['auto'] + $stats['encours']); ?></strong><span>Autorises / en cours</span></div>
    <div class="leave-stat refused"><strong><?php echo calendrier_conge_h($stats['nauto']); ?></strong><span>Refuses</span></div>
</div>

<div class="leave-calendar-panel">
    <div class="leave-calendar-header">
        <div class="leave-calendar-title"><?php echo calendrier_conge_h($nomsMois[$mois] . ' ' . $annee); ?></div>
        <div>
            <span class="leave-badge pending">En attente</span>
            <span class="leave-badge approved">Autorise</span>
            <span class="leave-badge active">En cours</span>
            <span class="leave-badge refused">Refuse</span>
        </div>
    </div>
    <div class="leave-calendar-grid">
        <?php foreach ($joursSemaine as $jourNom) { ?>
            <div class="leave-calendar-day-name"><?php echo calendrier_conge_h($jourNom); ?></div>
        <?php } ?>
        <?php
        $jourCourant = clone $debutCalendrier;
        while ($jourCourant <= $finCalendrier) {
            $cleJour = $jourCourant->format('Y-m-d');
            $events = isset($eventsParJour[$cleJour]) ? $eventsParJour[$cleJour] : array();
            $classesJour = array('leave-calendar-cell');
            if ($jourCourant->format('m') !== $debutMois->format('m')) { $classesJour[] = 'out-month'; }
            if ($cleJour === date('Y-m-d')) { $classesJour[] = 'today'; }
        ?>
            <div class="<?php echo implode(' ', $classesJour); ?>">
                <div class="leave-day-number">
                    <span><?php echo calendrier_conge_h($jourCourant->format('d')); ?></span>
                    <?php if (count($events) > 0) { ?><span class="leave-count"><?php echo count($events); ?> conge(s)</span><?php } ?>
                </div>
                <?php foreach (array_slice($events, 0, 3) as $event) {
                    $nomAgent = trim($event['nom_ag'] . ' ' . $event['postnom_ag']);
                    $classeEvent = calendrier_conge_classe_statut($event['statut']);
                    $titre = $nomAgent . ' - ' . $event['libelle_conge'] . ' (' . $event['date_debut'] . ' au ' . $event['date_fin'] . ')';
                ?>
                    <a class="leave-event <?php echo calendrier_conge_h($classeEvent); ?>" title="<?php echo calendrier_conge_h($titre); ?>" href="accueil.php?page=Autorisation_Conger&amp;id=<?php echo calendrier_conge_h($event['id_demande']); ?>">
                        <?php echo calendrier_conge_h($nomAgent); ?>
                        <small><?php echo calendrier_conge_h($event['libelle_conge']); ?></small>
                    </a>
                <?php } ?>
                <?php if (count($events) > 3) { ?><div class="leave-more">+<?php echo count($events) - 3; ?> autre(s)</div><?php } ?>
            </div>
        <?php $jourCourant->modify('+1 day'); } ?>
    </div>
</div>

<div class="leave-list-panel">
    <h4><i class="fa fa-list"></i> Conges du mois</h4>
    <div class="table-responsive">
        <table id="calendrier-conges-table" class="display table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Agent</th>
                    <th>Type</th>
                    <th>Periode</th>
                    <th>Jours</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($conges) === 0) { ?>
                    <tr><td colspan="7" class="text-center">Aucun conge trouve pour cette periode.</td></tr>
                <?php } ?>
                <?php foreach ($conges as $conge) { ?>
                    <tr>
                        <td><?php echo calendrier_conge_h($conge['matricule']); ?></td>
                        <td><?php echo calendrier_conge_h(trim($conge['nom_ag'] . ' ' . $conge['postnom_ag'] . ' ' . $conge['prenom_ag'])); ?></td>
                        <td><?php echo calendrier_conge_h($conge['libelle_conge']); ?></td>
                        <td><?php echo calendrier_conge_h($conge['date_debut']); ?> au <?php echo calendrier_conge_h($conge['date_fin']); ?></td>
                        <td><?php echo calendrier_conge_h($conge['nbrejr_accord'] ?: $conge['nbrejr_solic']); ?></td>
                        <td><span class="leave-badge <?php echo calendrier_conge_h(calendrier_conge_classe_statut($conge['statut'])); ?>"><?php echo calendrier_conge_h(calendrier_conge_libelle_statut($conge['statut'])); ?></span></td>
                        <td><a href="accueil.php?page=Autorisation_Conger&amp;id=<?php echo calendrier_conge_h($conge['id_demande']); ?>" style="color:darkblue"><i class="fa fa-edit"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    if ($.fn.dataTable && $('#calendrier-conges-table').length) {
        $('#calendrier-conges-table').dataTable({
            "aaSorting": [[3, "asc"]],
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]]
        });
    }
});
</script>
