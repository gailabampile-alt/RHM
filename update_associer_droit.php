<?php
session_start();

include_once('sys_connexion.php');
include_once('sys_fonction.php');

// S'assurer que PDO affiche les erreurs
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_POST['enreg'])) {
    $profil_id = $_POST['id_role'];
    $pages = isset($_POST['page']) ? $_POST['page'] : [];
    $creerPar =$_SESSION['id_utilisateur'];
    $dateCreation = $_POST['datecreer'];
    $modifierPar = $_SESSION['id_utilisateur'];  
   // $Datemodif = $_POST['DateModifcodep'];

    if ($profil_id == '') {
        $_SESSION['message'] = "Sélectionnez un rôle";
        $_SESSION['typeMsg'] = "danger";
        header('location:accueil.php?page=associer_droit');
        exit();
    }

    if (empty($pages)) {
        $_SESSION['message'] = "Sélectionnez une ou plusieurs pages";
        $_SESSION['typeMsg'] = "danger";
        header('location:accueil.php?page=associer_droit');
        exit();
    }

    // Supprimer les anciens droits
    $reqDel = $db->prepare("DELETE FROM bdd_paie.droits_acces WHERE id_role = :iprofil_id");
    $reqDel->bindValue(':iprofil_id', $profil_id, PDO::PARAM_INT);
    $reqDel->execute();

    // Debug : voir si la suppression a fonctionné
    // echo $reqDel->rowCount()." droits supprimés<br>";

    // Préparer insertion
  $reqAdd = $db->prepare("INSERT INTO bdd_paie.droits_acces (id_role, page_id,creerPar, modifierPar, date_Creat, date_Modif) VALUES (:id_role, :page_id,:creerPar,:modifierPar,:Date_Creat,:datemodif)");


$Datemodif = date('Y-m-d'); // Format correct
$dateCreation = date('Y-m-d'); // Si nécessaire

    foreach ($pages as $page_id) {
        $reqAdd->bindParam(':id_role', $profil_id, PDO::PARAM_INT);
        $reqAdd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
        $reqAdd->bindvalue(':creerPar',$creerPar);
        $reqAdd->bindvalue(':modifierPar',$modifierPar);
        $reqAdd->bindvalue(':Date_Creat',$dateCreation);
        $reqAdd->bindvalue(':datemodif', $Datemodif);
        if (!$reqAdd->execute()) {
            print_r($reqAdd->errorInfo()); // voir les erreurs SQL si ça échoue
            exit();
        }
    }

    $_SESSION['message'] = "Modification effectué avec succès !";
    $_SESSION['typeMsg'] = "info";
    header('location:accueil.php?page=voir_profil_droit');
    exit();
}
?>