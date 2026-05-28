
<?php
// ------------------------------------------------------------
// Configuration & sécurité
// ------------------------------------------------------------
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once('sys_connexion.php');

define('PHOTO_DIR', __DIR__ . '/photoAgent');

// Vérification DB
if (!isset($db) || !($db instanceof PDO)) {
    die("<h2 style='color:red;'>❌ Erreur : Connexion DB invalide.</h2>");
}

// Vérifier dossier photo
if (!is_dir(PHOTO_DIR)) {
    die("<h2 style='color:red;'>❌ Dossier photoAgent introuvable !</h2>");
}

// ------------------------------------------------------------
// Récupération des données agent
// ------------------------------------------------------------
$matricule = isset($_GET['matric']) ? trim($_GET['matric']) : null;
$agent = null;

if ($matricule) {
    $req = $db->prepare("
        SELECT *
        FROM bdd_paie.v_info_agent
        WHERE matricule = :matric
        LIMIT 1
    ");
    $req->bindValue(':matric', $matricule);
    $req->execute();
    $agent = $req->fetch(PDO::FETCH_ASSOC);
}

if (!$agent) {
    die("
        <h2 style='color:red;'>⚠ Aucun agent trouvé.</h2>
        <p>Exemple d'appel :</p>
        <code>print_profil_agent.php?matric=AG12345</code>
    ");
}

// ------------------------------------------------------------
// Gestion photo
// ------------------------------------------------------------
$photo = !empty($agent['photo']) ? PHOTO_DIR . '/' . $agent['photo'] : null;
$photoWebPath = (!empty($agent['photo']) && file_exists($photo))
    ? "photoAgent/" . $agent['photo']
    : null;

// ------------------------------------------------------------
// FORMATAGE DES DATES (Version PRO compatible PHP 8)
// ------------------------------------------------------------
function formatDateSafe($date) {
    if (empty($date) || $date === '0000-00-00') {
        return '—';
    }
    try {
        return (new DateTime($date))->format('d/m/Y');
    } catch (Exception $e) {
        return '—';
    }
}

$dateNaissance   = formatDateSafe($agent['dateNaiss_ag']);
$dateEngagement  = formatDateSafe($agent['dateEngagemnt_ag']);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Profil Agent</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background:#f5f6fa;
        padding:30px;
    }
    .card {
        background:#fff;
        border-radius:8px;
        padding:20px 30px;
        max-width:900px;
        margin:auto;
        box-shadow:0 4px 12px rgba(0,0,0,0.15);
    }
    .card h2 {
        margin:0;
        color:#003366;
        font-size:26px;
        font-weight:bold;
        text-transform:uppercase;
    }
    .header {
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        padding-bottom:15px;
        border-bottom:2px solid #eee;
        margin-bottom:20px;
    }
    .photo {
        width:140px; height:180px;
        border:2px solid #003366;
        object-fit:cover;
        border-radius:4px;
    }
    .placeholder {
        width:140px;height:180px;
        border:2px dashed #666;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#888;
    }
    .section h3 {
        background:#003366;
        color:#fff;
        padding:8px 10px;
        margin-top:30px;
        border-radius:4px;
        font-size:18px;
    }
    .section p {
        font-size:15px;
        margin:5px 0;
    }
    .label {
        font-weight:bold;
        color:#003366;
    }
    .btn-print {
        margin-top:30px;
        background:#28a745;
        padding:12px 20px;
        color:#fff;
        border:none;
        border-radius:4px;
        cursor:pointer;
        font-size:16px;
    }
    @media print {
        .btn-print { display:none; }
    }
</style>

</head>
<body>

<div class="card">

    <!-- ========================== -->
    <!-- HEADER PROFIL              -->
    <!-- ========================== -->
    <div class="header">
        <div>
            <h2><?= htmlspecialchars($agent['nom_ag'].' '.$agent['postnom_ag'].' '.$agent['prenom_ag']) ?></h2>
            <p><strong class="label">Matricule :</strong> <?= htmlspecialchars($agent['matricule']) ?></p>
        </div>

        <div>
            <?php if ($photoWebPath): ?>
                <img src="<?= $photoWebPath ?>" class="photo" alt="Photo agent">
            <?php else: ?>
                <div class="placeholder">Aucune photo</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ========================== -->
    <!-- SECTION INFO PERSONNELLES  -->
    <!-- ========================== -->
    <div class="section">
        <h3>Informations personnelles</h3>

        <p><span class="label">Genre :</span>
            <?= $agent['sexe_ag'] === 'M' ? 'Homme' : 'Femme' ?></p>

        <p><span class="label">Date de naissance :</span>
            <?= $dateNaissance ?></p>

        <p><span class="label">État civil :</span>
            <?= $agent['etatCiv_ag'] === 'M' ? 'Marié(e)' : 'Célibataire' ?></p>

        <p><span class="label">Nombre d'enfants :</span>
            <?= htmlspecialchars($agent['nbreEnfant_ag']) ?></p>
    </div>

    <!-- ========================== -->
    <!-- SECTION INFO PRO           -->
    <!-- ========================== -->
    <div class="section">
        <h3>Informations professionnelles</h3>

        <p><span class="label">Siège :</span> 
            <?= htmlspecialchars($agent['libelle_sieg']) ?></p>

        <p><span class="label">Fonction :</span> 
            <?= htmlspecialchars($agent['libelleFonct']) ?></p>

        <p><span class="label">Direction :</span> 
            <?= htmlspecialchars($agent['libelle_dir']) ?></p>

        <p><span class="label">Grade :</span> 
            <?= htmlspecialchars($agent['libelle_grade']) ?></p>

        <p><span class="label">Date d'engagement :</span>
            <?= $dateEngagement ?></p>
    </div>

    <button class="btn-print" onclick="window.print()">Imprimer</button>

</div>

</body>
</html>
