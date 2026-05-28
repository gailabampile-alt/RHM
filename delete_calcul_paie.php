<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

            $periode = validation_donnees($_POST['periode']);
            $type_paie = validation_donnees($_POST['type_paie']);
            $date = date('y-m-d');
        if(isset($_POST['deletePret'])){    
            try {
                $dateDebut_pret = strtotime($dateDebut);
                $dateServer = strtotime($date);
                if($dateDebut_pret < $dateServer){
                    $_SESSION['message']  = "Attention : Le prêt est déjà en cours de paiement".$dateDebut_pret.'| '.$dateServer;
                    $_SESSION['typeMsg']  = "warning";
                    header('location:accueil.php?page=Voir_Prets');
                    exit();
                }else{
                    $reqDeletePret = $db->prepare ("DELETE FROM bdd_paie.t_pret WHERE id_pret = :id_pret");
                    $reqDeletePret->bindValue(':id_pret',$id_pret);
                    $reqDeletePret->execute();

                    $reqHistoriOperation =  $db->prepare("INSERT INTO bdd_paie.t_historique_operation 
                    (libelle_op,numRef_op,montant_op,utilisateur_ID) VALUES (:libelle_op,:numRef_op,:montant_op,:utilisateur_ID)");
                    $reqHistoriOperation->bindValue(':libelle_op',"Suppression d'un Prêt");
                    $reqHistoriOperation->bindValue(':numRef_op',$nRef);
                    $reqHistoriOperation->bindValue(':montant_op',$montPreter);
                    $reqHistoriOperation->bindValue(':utilisateur_ID',$_SESSION['id_utilisateur']);
                    $reqHistoriOperation->execute();

                    $_SESSION['message']  = "Suppression Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_Prets');
                    exit();
                }
                
            } catch (PDOException $e) {
                $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Voir_Prets');
                exit();
            }
            
        }
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Voir_Prets');
        exit();
        
    }


