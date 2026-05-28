<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

while (ob_get_level() > 0) {
    ob_end_clean();
}
ob_start();

header('Content-Type: application/json; charset=utf-8');

function send_json_response($payload, $statusCode = 200) {
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload);
    exit;
}

set_error_handler(function($severity, $message, $file, $line) {
    send_json_response(array('error' => $message . ' in ' . $file . ':' . $line), 500);
});
set_exception_handler(function($exception) {
    send_json_response(array('error' => $exception->getMessage()), 500);
});

try {
    require_once __DIR__ . '/sys_connexion.php';
} catch (Exception $e) {
    send_json_response(array('error' => $e->getMessage()), 500);
}

$selectedActiv = isset($_GET['activ']) ? $_GET['activ'] : '';
$selectedSiege = isset($_GET['siege']) ? $_GET['siege'] : '';
$selectedDateDebut = isset($_GET['dateDebut']) ? $_GET['dateDebut'] : '';
$selectedDateFin = isset($_GET['dateFin']) ? $_GET['dateFin'] : '';


$sql = "SELECT t_agent.matricule, t_agent.nom_ag, t_agent.postnom_ag, t_agent.prenom_ag, t_agent.sexe_ag,
    t_agent.NumCompt, t_agent.NumCNSS_ag, t_agent.dateEngagemnt_ag,
    t_siege.code_sieg, t_siege.libelle_sieg, t_type_siege.libelle_typSieg,
    t_activite.libelle_activ,
    t_direction.libelle_dir,
    t_fonction.libelleFonct,
    t_grade.libelle_grade
    FROM bdd_paie.t_agent
    INNER JOIN bdd_paie.t_activite ON t_activite.code_activ = t_agent.activiter_ID
    INNER JOIN bdd_paie.detail_agent_siege ON detail_agent_siege.agent_ID = t_agent.matricule
    INNER JOIN bdd_paie.t_siege ON t_siege.code_sieg = detail_agent_siege.siege_ID
    INNER JOIN bdd_paie.t_type_siege ON t_type_siege.code_typSieg = t_siege.typeSiege_ID
    LEFT JOIN bdd_paie.detail_agent_direction ON detail_agent_direction.agent_ID = t_agent.matricule AND detail_agent_direction.statut_ID = 'act'
    LEFT JOIN bdd_paie.t_direction ON t_direction.code_dir = detail_agent_direction.direction_ID
    LEFT JOIN bdd_paie.detail_agent_fonction ON detail_agent_fonction.agent_ID = t_agent.matricule AND detail_agent_fonction.statut_ID = 'act'
    LEFT JOIN bdd_paie.t_fonction ON t_fonction.codeFonct = detail_agent_fonction.fonction_ID
    LEFT JOIN bdd_paie.detail_agent_grade ON detail_agent_grade.agent_ID = t_agent.matricule AND detail_agent_grade.statut_ID = 'act'
    LEFT JOIN bdd_paie.t_grade ON t_grade.code_grade = detail_agent_grade.grade_ID
    WHERE 1=1";

$params = array();



$retraites = ['02','03','04','05','06','07','08','09','10'];

if (!empty($selectedActiv)) {

    $sql .= " AND t_agent.activiter_ID = :activ";
    $params[':activ'] = $selectedActiv;

    if (in_array($selectedActiv, $retraites)) {
        // ✅ retraité → on ne met PAS 'act'
        $sql .= " AND detail_agent_siege.statut_ID = 'desac'";
    } else {
        // ✅ non retraité → uniquement actif
        $sql .= " AND detail_agent_siege.statut_ID = 'act'";
    }

} else {

    // ✅ aucun filtre activité → on gère les deux cas correctement
    $sql .= " AND (
        (t_agent.activiter_ID IN ('02','03','04','05','06','07','08','09','10') 
         AND detail_agent_siege.statut_ID = 'desac')
        OR
        (t_agent.activiter_ID NOT IN ('02','03','04','05','06','07','08','09','10') 
         AND detail_agent_siege.statut_ID = 'act')
    )";
}


if (!empty($selectedSiege)) {
    $sql .= " AND detail_agent_siege.siege_ID = :siege";
    $params[':siege'] = $selectedSiege;
}

if (!empty($selectedDateDebut)) {
    $sql .= " AND t_agent.dateEngagemnt_ag >= :dateDebut";
    $params[':dateDebut'] = $selectedDateDebut;
}

if (!empty($selectedDateFin)) {
    $sql .= " AND t_agent.dateEngagemnt_ag <= :dateFin";
    $params[':dateFin'] = $selectedDateFin;
}
$sql .= " ORDER BY t_agent.nom_ag, t_agent.postnom_ag, t_agent.prenom_ag";

try {
    $req = $db->prepare($sql);
    foreach ($params as $key => $value) {
        $req->bindValue($key, $value);
    }
    $req->execute();
    $rows = array();
    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
        $rows[] = array(
            'code_sieg' => $row['code_sieg'],
            'type_sieg' => $row['libelle_typSieg'],
            'lib_sieg' => $row['libelle_sieg'],
            'matric' => $row['matricule'],
            'noms' => trim($row['nom_ag'] . ' ' . $row['postnom_ag'] . ' ' . $row['prenom_ag']),
            'compte' => $row['NumCompt'],
            'siege' => $row['libelle_sieg'],
            'direction' => $row['libelle_dir'],
            'fonction' => $row['libelleFonct'],
            'grade' => $row['libelle_grade'],
            'cnss' => $row['NumCNSS_ag'],
            'sexe' => $row['sexe_ag'],
            'activiter' => $row['libelle_activ'],
        );
    }
    send_json_response(array('rows' => $rows));
} catch (PDOException $e) {
    send_json_response(array('error' => 'Erreur SQL: ' . $e->getMessage()), 500);
} catch (Exception $e) {
    send_json_response(array('error' => 'Erreur interne du serveur'), 500);
}
