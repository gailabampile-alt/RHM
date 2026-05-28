<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_GET['code_carbu_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_carburant SET modifierPar = :modifierPar,statut_ID = :statut_ID 
            WHERE id_carb = :id_carb");
            $reqActiverGrade->bindValue(':statut_ID','act');
            $reqActiverGrade->bindValue(':id_carb',$_GET['code_carbu_act']);
            $modifierPar = $_SESSION['id_utilisateur'];
            $reqActiverGrade->bindValue(':modifierPar',$modifierPar);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Carburant');
            exit();
        }
        if(isset($_GET['code_carbu_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_carburant SET modifierPar = :modifierPar,statut_ID = :statut_ID 
            WHERE id_carb = :id_carb");
            $modifierPar = $_SESSION['id_utilisateur'];
            $reqActiverGrade->bindValue(':modifierPar',$modifierPar);
            $reqActiverGrade->bindValue(':statut_ID','desac');
            $reqActiverGrade->bindValue(':id_carb',$_GET['code_carbu_desac']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Carburant');
            exit();
        }

        if(isset($_POST['updateCarburant'])){
            $date_carbu = validation_donnees($_POST['date_carbu']);
            $date_carbu = validation_donnees($_POST['id_carbu_last']);
            $prix_litre = validation_donnees($_POST['prix_litr']);
            $taux = validation_donnees($_POST['id_taux_jr']);
            $dateModif = date('Y-m-d');
            $modifierPar = $_SESSION['id_utilisateur'];
            $statut = "act";
            if(!empty($date_carbu) || !empty($prix_litre) )
            {
                try {
                    $reqUpdateCarburant = $db->prepare ("UPDATE bdd_paie.t_carburant 
                    SET id_carb = :id_carb,prix_litre = :prix_litre,
                    taux_ID = :taux_ID,modifierPar = :modifierPar,statut_ID = :statut_ID
                    WHERE id_carb = :id_carb_last");
                    $reqUpdateCarburant->bindValue(':id_carb',$date_carbu);
                    $reqUpdateCarburant->bindValue(':id_carb_last',$date_carbu);
                    $reqUpdateCarburant->bindValue(':prix_litre',$prix_litre);
                    $reqUpdateCarburant->bindValue(':taux_ID',$taux);
                    $reqUpdateCarburant->bindValue(':modifierPar',$modifierPar);
                    //$reqUpdateCarburant->bindValue(':dateCreation',$dateCreat);
                    $reqUpdateCarburant->bindValue(':statut_ID',$statut);
                    $reqUpdateCarburant->execute();

                    $_SESSION['message']  = "Modification Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_Carburant');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Voir_Carburant');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Voir_Carburant');
        exit();
        
    }


