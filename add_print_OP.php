<?php
session_start();
set_time_limit(560);
// Récupération des paramètres en GET

$periode    = $_GET['periode']   ?? '';
$type_paie  = $_GET['type_paie'] ?? '';
$printBy    = $_GET['Print_by']  ?? '';
$codeSiege  = $_GET['code_siege'] ?? '';
$format     = strtolower($_GET['format'] ?? '');

// Vérification des champs obligatoires
if (empty($periode) || empty($type_paie) || empty($printBy) || empty($format)) {
    $_SESSION['message'] = "⚠️ Merci de remplir tous les champs obligatoires.";
    header("Location: Ordre_paiement.php");
    exit;
}

$allowedFormats = ['html', 'pdf', 'excel'];
if (!in_array($format, $allowedFormats, true)) {
    $_SESSION['message'] = "⚠️ Format d'impression invalide.";
    header("Location: Ordre_paiement.php");
    exit;
}

// Construction de l’URL vers Ordre_paiement.php
$url = "Ordre_paiement.php?periode=" . urlencode($periode) .
       "&type_paie=" . urlencode($type_paie) .
       "&Print_by=" . urlencode($printBy) .
       "&format=" . urlencode($format);

// Ajout des paramètres selon le type de filtre choisi
if ($printBy === "S" && !empty($codeSiege)) {
    $url .= "&code_siege=" . urlencode($codeSiege);
}

// Redirection vers Ordre_paiement.php
header("Location: $url");
exit;
?>