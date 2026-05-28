
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
set_time_limit(360);
session_start();
include_once('sys_connexion.php');
include_once('sys_fonction.php');


if (isset($_POST['periode']) && !empty($_POST['periode'])) {
    $periode = normalizePeriode($_POST['periode']);
    $type_paie = validation_donnees ($_POST['type_paie']);

    try {

        $reqVerifpaie = $db->prepare ('SELECT * FROM bdd_paie.t_paie WHERE periode =:periode and type_paie =:type_paie');
        $reqVerifpaie -> bindValue(':periode',$periode);
        $reqVerifpaie -> bindValue(':type_paie',$type_paie);
        $reqVerifpaie ->execute();

        $result = $reqVerifpaie ->fetch();

        if(!$result){
            $_SESSION['message'] = "⚠️Il n'existe pas de paie pour la période de :<strong>$periode</strong>";
            $_SESSION['typeMsg'] = "warning";
            header("Location: accueil.php?page=Calcul-Paie");
            exit();
        }
     // Suppression dans t_calcul_paie
        $reqAnnuler_Paie1 = $db->prepare("DELETE FROM bdd_paie.t_calcule_paie WHERE periode = :periode ");
        $reqAnnuler_Paie1->bindValue(':periode', $periode);
       
        $reqAnnuler_Paie1->execute();

        // Suppression dans t_paie
        $reqAnnuler_Paie2 = $db->prepare("DELETE FROM bdd_paie.t_paie WHERE periode = :periode and type_paie =:type_paie");
        $reqAnnuler_Paie2->bindValue(':periode', $periode);
        $reqAnnuler_Paie2->bindValue(':type_paie', $type_paie);
        $reqAnnuler_Paie2->execute();

        //supression dans t_retenue

        $reqAnnuler_Paie3 = $db->prepare("DELETE FROM bdd_paie.t_retenue WHERE periode = :periode");
        $reqAnnuler_Paie3->bindValue(':periode', $periode);
        $reqAnnuler_Paie3->execute();

        //supression dans t_imposa

        $reqAnnuler_Paie3 = $db->prepare("DELETE FROM bdd_paie.t_imposa WHERE periode = :periode");
        $reqAnnuler_Paie3->bindValue(':periode', $periode);
        $reqAnnuler_Paie3->execute();


        // Vérifier si une suppression a été faite
        if ($reqAnnuler_Paie1->rowCount()  > 0 || $reqAnnuler_Paie2->rowCount()  > 0) 
        {
            $_SESSION['message'] = "✅ La paie pour la période <strong>$periode</strong> a été annulée avec succès.";
            $_SESSION['typeMsg'] = "success";
             header('location:accueil.php?page=Calcul-Paie');
             exit();
        } else {
            $_SESSION['message'] = "❌ Erreur lors de l'annulation de la période <strong>$periode</strong>.";
            $_SESSION['typeMsg'] = "danger";
             header('location:accueil.php?page=Calcul-Paie');
              exit();
        }

    } catch (Exception $e) {
        $_SESSION['message'] = "⚠️ Erreur système : " . $e->getMessage();
        $_SESSION['typeMsg'] = "danger";
         header('location:accueil.php?page=Calcul-Paie');
          exit();
    }

} else {
    $_SESSION['message'] = "⚠️ Aucune période reçue.";
    $_SESSION['typeMsg'] = "warning";
    header('location:accueil.php?page=Calcul-Paie');
     exit();
}
