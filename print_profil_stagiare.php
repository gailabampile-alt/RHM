<?php
// Active l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
error_reporting(E_ALL);

// =======================================================
// CONFIGURATION ET DÉFINITIONS
// =======================================================

define('photoStagiaire', __DIR__ . '/photoStagiaire');

// Inclusion des dépendances
// NOTE : Décommentez la ligne FPDF si nécessaire
// require_once __DIR__ . '/fpdf/fpdf.php'; 
include_once('sys_connexion.php'); 

// Vérification de la connexion DB
if (!isset($db) || !($db instanceof PDO)) {
    die("Erreur : connexion DB invalide.");
}

// Vérification que le répertoire de photos existe
if (!is_dir(photoStagiaire)) {
    die("Erreur fatale : Le répertoire de photos 'photoAgent' est introuvable ou inaccessible.");
}

// Récupère et nettoie le matricule de l'URL
$matricule = isset($_GET['id_stg']) ? trim($_GET['id_stg']) : null;
$agent = null;
$photoFilePath = null;
$photoFileName = null; 

// Requête pour récupérer les informations de l'agent si un matricule est fourni
if (!empty($matricule)) {
    $sql = "SELECT *, photo_stg,sieg.libelle_sieg,sieg.libelle_sieg FROM bdd_paie.t_stagiare 
        INNER JOIN bdd_paie.t_direction AS dir ON dir.code_dir = t_stagiare.dir_stg
        INNER JOIN bdd_paie.t_siege AS sieg ON sieg.code_sieg = t_stagiare.siege_stg
        WHERE id_stg = :id_stg LIMIT 1";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id_stg', $matricule, PDO::PARAM_STR);
    $stmt->execute();
    $agent = $stmt->fetch(PDO::FETCH_ASSOC);

    // LOGIQUE DE GESTION DU CHEMIN DE LA PHOTO
    if (!empty($agent) && !empty($agent['photo_stg'])) {
        $photoFileName = $agent['photo_stg']; 
        $photoFilePath = photoStagiaire . '/' . $photoFileName; 
    }
}


// ----------------------------------------------------
// LOGIQUE DE GÉNÉRATION PDF
// ----------------------------------------------------
if (isset($_POST['generate_pdf']) && !empty($agent)) {
    // ⚠️ Assurez-vous d'avoir instancié FPDF ici (Ex: $pdf = new FPDF();)
    // ... (Code PDF) ...
    
    // Envoi du PDF au navigateur
    // $pdf->Output('I', 'profil_agent_' . $agent['matricule'] . '.pdf');
    // exit;
}

// =======================================================
// FORMATAGE DES DATES POUR L'AFFICHAGE HTML (Retour à strftime pour compatibilité)
// =======================================================

// Initialisation avec les valeurs brutes ou par défaut
$date_naissance = !empty($agent['dateNaiss']) ? htmlspecialchars($agent['dateNaiss']) : 'Non spécifié';
$date_engagement = !empty($agent['dateDebut_stage']) ? htmlspecialchars($agent['dateDebut_stage']) : 'Non spécifié';

if (!empty($agent)) {
    // DÉFINITION DE LA LOCALE (Nécessaire pour strftime())
    // Vous verrez l'erreur "Deprecated" si vous utilisez PHP 8.1+
    setlocale(LC_TIME, 'fr_FR.utf8', 'fra', 'fr_FR'); 
    
    // 1. Formatage de la Date de Naissance
    try {
        $dateObjNaiss = new DateTime($agent['dateNaiss']);
        // Utilisation de strftime()
        //$date_naissance = date('%d %B %Y', $dateObjNaiss->getTimestamp()); 
        $date_naissance = $dateObjNaiss->format('d F Y');
    } catch (Exception $e) {
        // En cas d'erreur de format, on garde la valeur brute
    }

    // 2. Formatage de la Date d'Engagement
    try {
        $dateObjEngage = new DateTime($agent['dateDebut_stage']);
        // Utilisation de strftime()
        //$date_engagement = strftime('%d %B %Y', $dateObjEngage->getTimestamp());
         $date_engagement = $dateObjEngage->format('d F Y');
    } catch (Exception $e) {
        // En cas d'erreur de format, on garde la valeur brute
    }
}

// ----------------------------------------------------
// DÉBUT DE L'AFFICHAGE HTML
// ----------------------------------------------------
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Profil Agent</title>
<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .profil { border: 1px solid #ccc; padding: 20px; width: 800px; margin: auto; }
    /* Utilisation de Flexbox pour aligner titre et photo */
    .header { 
        display: flex; 
        justify-content: space-between; 
        align-items: flex-start; 
        margin-bottom: 20px;
    }
    /* Hauteur/largeur explicite pour les images */
    .photo { width: 135px; height: 180px; border: 1px solid #000; object-fit: cover; } 
    h2 { margin: 0; color: #007BFF; }
    .section { margin-top: 20px; }
    .section h3 { border-bottom: 1px solid #ccc; padding-bottom: 5px; }
    .btn { margin-top: 20px; padding: 10px 20px; background: #007BFF; color: #fff; border: none; cursor: pointer; }
    .btn-pdf { background: #28a745; }
    @media print { .btn { display: none; } }
    .placeholder { width:150px;height:150px;border:1px solid #000;display:flex;align-items:center;justify-content:center;color:#666; }
</style>
</head>
<body>
<?php if (!empty($agent)): ?>
<div class="profil">
    <div class="header">
        <div>
            <h2><?php echo htmlspecialchars($agent['nom_stg'].' '.$agent['postnom_stg'].' '.$agent['prenom_stg']); ?></h2>
        </div>
        <div>
            <?php if (!empty($photoFileName)): ?>
                <img src="<?php echo htmlspecialchars('photoStagiaire/' . $photoFileName); ?>" class="photo" alt="Photo du stagiaire">
            <?php else: ?>
                <div class="placeholder">Pas de photo</div>
            <?php endif; ?>
        </div>
    </div>
 
    <div class="section">
        <h3>Informations personnelles</h3>
        <p><strong>Matricule :</strong> <?php echo htmlspecialchars($agent['id_stg']); ?></p>
        <p><strong>Genre : </strong><?php if ($agent['sexe_stg']== 'M') {
           echo "Homme"; } else { echo "Femme";}?> </p>
        <p><strong>Date de naissance :</strong> <?php echo htmlspecialchars($date_naissance); ?></p>
        <p><strong>État civil : </strong><?php if ($agent['etatCiv_stg']== 'M') {
           echo "Marié(e)"; } else { echo "Célibataire";}?> </p>
        <p><strong>Phone :</strong> <?php echo htmlspecialchars($agent['phone_stg']); ?></p>
        <p><strong>Adresse :</strong> <?php echo htmlspecialchars($agent['adresse_stg']); ?></p>
    </div>

    <div class="section">
        <h3>Informations professionnelles</h3>
        <p><strong>Siege :</strong> <?php echo htmlspecialchars($agent['libelle_sieg']); ?></p>
        <p><strong>Direction :</strong> <?php echo htmlspecialchars($agent['libelle_dir']); ?></p>
        
        
        <p><strong>Date d'engagement :</strong> <?php echo htmlspecialchars($date_engagement); ?></p>
    </div>

    <button class="btn" onclick="window.print()">Imprimer</button>
    <form method="post" style="display:inline;">
        <input type="hidden" name="matric" value="<?php echo htmlspecialchars($agent['id_stg']); ?>">
       
    </form>
</div>
<?php else: ?>
<p style="color:#c00;"><strong>Aucun agent trouvé.</strong></p>
<p>Appelle la page avec un matricule valide, par ex. :</p>
<code>http://localhost/HRM%201.0/print_profil_agent.php?matric=AG12345</code>
<?php endif; ?>
    <br><br><br><br>
</body>
</html>