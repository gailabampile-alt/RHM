<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_GET['code_taux_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_taux SET modifierPar = :modifierPar,statut_ID = :statut_ID 
            WHERE id_taux = :id_taux");
            $reqActiverGrade->bindValue(':statut_ID','act');
            $reqActiverGrade->bindValue(':id_taux',$_GET['code_taux_act']);
            $modifierPar = $_SESSION['id_utilisateur'];
            $reqActiverGrade->bindValue(':modifierPar',$modifierPar);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_taux');
            exit();
        }
        if(isset($_GET['code_taux_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_taux SET modifierPar = :modifierPar,statut_ID = :statut_ID 
            WHERE id_taux = :id_taux");
            $modifierPar = $_SESSION['id_utilisateur'];
            $reqActiverGrade->bindValue(':modifierPar',$modifierPar);
            $reqActiverGrade->bindValue(':statut_ID','desac');
            $reqActiverGrade->bindValue(':id_taux',$_GET['code_taux_desac']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_taux');
            exit();
        }

        if(isset($_POST['updateTaux'])){
            $id_taux = validation_donnees($_POST['id_taux']);
            $taux = validation_donnees($_POST['taux']);
            $monnaie = validation_donnees($_POST['monnaie']);
            $dateTaux = validation_donnees($_POST['dateTaux']);
            $modifierPar = $_SESSION['id_utilisateur'];
            $statut = "act";
            if(!empty($taux) || !empty($monnaie) || !empty($dateTaux))
            {   
                try {
                    $reqUpdateTaux = $db->prepare ("UPDATE bdd_paie.t_taux SET montantTaux = :montantTaux,
                    monnaie_ID = :monnaie_ID,dateTaux = :dateTaux, modifierPar = :modifierPar,statut_ID = :statut_ID
                    WHERE id_taux = :id_taux");
                    $reqUpdateTaux->bindValue(':montantTaux',$taux);
                    $reqUpdateTaux->bindValue(':monnaie_ID',$monnaie);
                    $reqUpdateTaux->bindValue(':dateTaux',$dateTaux);
                    $reqUpdateTaux->bindValue(':modifierPar',$modifierPar);
                    $reqUpdateTaux->bindValue(':statut_ID',$statut);
                    $reqUpdateTaux->bindValue(':id_taux',$id_taux);
                    //$reqUpdateCarburant->bindValue(':dateCreation',$dateCreat);
                    $reqUpdateTaux->execute();

                    $_SESSION['message']  = "Modification Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_taux');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Voir_taux');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Voir_taux');
        exit();
        
    }


