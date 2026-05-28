<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['addTaux'])){
            $dateTaux = validation_donnees($_POST['dateTaux']);
            $taux = validation_donnees($_POST['taux']);
            $monnaie = validation_donnees($_POST['monnaie']);
            //$dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";
            if(!empty($dateTaux) || !empty($taux) || !empty($monnaie))
            {
                $reqVerification = $db->prepare("SELECT monnaie_ID FROM bdd_paie.t_taux");
                $reqVerification->execute();
                $valRequest = $reqVerification->rowCount();
                if($valRequest>0){
                    try {
                        $reqUpdate = $db->prepare("UPDATE bdd_paie.t_taux SET statut_ID =:statut_ID
                        WHERE monnaie_ID =:monnaie_ID");
                        $reqUpdate->bindValue(':statut_ID','desac');
                        $reqUpdate->bindValue(':monnaie_ID',$monnaie);
                        $reqUpdate->execute();
                        
                        $reqAddCarburant = $db->prepare("INSERT INTO bdd_paie.t_taux 
                        (montantTaux,monnaie_ID,creerPar,dateTaux,statut_ID) VALUES 
                        (:montantTaux,:monnaie_ID,:creerPar,:dateTaux,:statut_ID)");
                        $reqAddCarburant->bindValue(':montantTaux',$taux);
                        $reqAddCarburant->bindValue(':monnaie_ID',$monnaie);
                        $reqAddCarburant->bindValue(':dateTaux',$dateTaux);
                        $reqAddCarburant->bindValue(':creerPar',$creerPar);
                        $reqAddCarburant->bindValue(':statut_ID',$statut);
                        $reqAddCarburant->execute();
    
                        $_SESSION['message']  = "Enregistrement Effectuer !";
                        $_SESSION['typeMsg']  = "info";
                        header('location:accueil.php?page=Taux');
                        exit();
        
                      } catch (PDOException $e) {
                        echo "Erreur: " . $e->getMessage();
                      }
                }else{
                    try {
                        $reqAddCarburant = $db->prepare ("INSERT INTO bdd_paie.t_taux 
                        (montantTaux,monnaie_ID,creerPar,dateTaux,statut_ID) VALUES 
                        (:montantTaux,:monnaie_ID,:creerPar,:dateTaux,:statut_ID)");
                        $reqAddCarburant->bindValue(':montantTaux',$taux);
                        $reqAddCarburant->bindValue(':monnaie_ID',$monnaie);
                        $reqAddCarburant->bindValue(':dateTaux',$dateTaux);
                        $reqAddCarburant->bindValue(':creerPar',$creerPar);
                        $reqAddCarburant->bindValue(':statut_ID',$statut);
                        $reqAddCarburant->execute();
    
                        $_SESSION['message']  = "Enregistrement Effectuer !";
                        $_SESSION['typeMsg']  = "info";
                        header('location:accueil.php?page=Taux');
                        exit();
        
                      } catch (PDOException $e) {
                        echo "Erreur: " . $e->getMessage();
                      }
                }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Taux');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Taux');
        exit();
        
    }


