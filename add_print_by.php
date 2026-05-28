<?php
session_start();
set_time_limit(560);
// Récupération des paramètres en GET
$matricule  = $_GET['matric']    ?? '';
$periode    = $_GET['periode']   ?? '';
$type_paie  = $_GET['type_paie'] ?? '';
$printBy    = $_GET['Print_by']  ?? '';
$codeSiege  = $_GET['code_siege'] ?? '';
$format     = strtolower($_GET['format'] ?? 'html');

// Vérification des champs obligatoires
if (empty($periode) || empty($type_paie) || empty($printBy) || empty($format)) {
    $_SESSION['message'] = "⚠️ Merci de remplir tous les champs obligatoires.";
    header("Location: frm_print_bulletins.php");
    exit;
}

$allowed = ['html','pdf'];
if (!in_array($format, $allowed, true)) {
    $_SESSION['message'] = "⚠️ Format d'impression invalide.";
    header("Location: frm_print_bulletins.php");
    exit;
}

// Construction de l’URL vers bulletin_ap.php
$url = "bulletin_ap.php?periode=" . urlencode($periode) .
       "&type_paie=" . urlencode($type_paie) .
       "&Print_by=" . urlencode($printBy) .
       "&format=" . urlencode($format);

// Ajout des paramètres selon le type de filtre choisi
if ($printBy === "I" && !empty($matricule)) {
    $url .= "&matric=" . urlencode($matricule);
} elseif ($printBy === "S" && !empty($codeSiege)) {
    $url .= "&code_siege=" . urlencode($codeSiege);
} elseif ($printBy === "T") {
    $url .= "&periode=" . urlencode($periode);
}

// Redirection vers bulletin.php
header("Location: $url");
exit;
?>