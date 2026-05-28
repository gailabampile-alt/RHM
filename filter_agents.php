
<?php
header("Content-Type: application/json; charset=UTF-8");

// Connexion
 include('sys_connexion.php');
 
$activite = !empty($_POST['activite']) ? $_POST['activite'] : null;
$siege    = !empty($_POST['siege'])    ? $_POST['siege']    : null;

$sql = "
    SELECT 
        t_siege.code_sieg AS code_sieg,
        t_type_siege.libelle_typSieg AS type_sieg,
        t_siege.libelle_sieg AS lib_sieg,
        t_agent.matricule AS matricule,
        CONCAT(t_agent.nom_ag, ' ', t_agent.postnom_ag, ' ', t_agent.prenom_ag) AS noms,
        t_agent.sexe_ag AS sexe,
        t_activite.libelle_activ AS activite
    FROM t_agent
    INNER JOIN t_activite ON t_activite.code_activ = t_agent.activiter_ID
    INNER JOIN detail_agent_siege ON detail_agent_siege.agent_ID = t_agent.matricule
    INNER JOIN t_siege ON t_siege.code_sieg = detail_agent_siege.siege_ID
    INNER JOIN t_type_siege ON t_type_siege.code_typSieg = t_siege.typeSiege_ID
    WHERE 1 = 1
";

$params = [];

if ($activite !== null) {
    $sql .= " AND t_agent.activiter_ID = :activite";
    $params[':activite'] = $activite;
}

if ($siege !== null) {
    $sql .= " AND t_siege.code_sieg = :siege";
    $params[':siege'] = $siege;
}

$sql .= " ORDER BY noms ASC";

$stmt = $bdd->prepare($sql);
$stmt->execute($params);

$rows = [];
while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $rows[] = [
        "code_sieg" => $r['code_sieg'],
        "type_sieg" => $r['type_sieg'],
        "lib_sieg"  => $r['lib_sieg'],
        "matricule" => $r['matricule'],
        "noms"      => $r['noms'],
        "sexe"      => $r['sexe'],
        "activite"  => $r['activite']
    ];
}

echo json_encode([
    "count" => count($rows),
    "rows"  => $rows
], JSON_UNESCAPED_UNICODE);
