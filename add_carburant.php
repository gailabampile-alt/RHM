<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['addCarburant'])){
            $date_carbu = validation_donnees($_POST['date_carbu']);
            $prix_litre = validation_donnees($_POST['prix_litr']);
            $taux = validation_donnees($_POST['id_taux_jr']);
            $dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";
            if(!empty($date_carbu) || !empty($prix_litre) )
            {
                try {
                    $reqAddCarburant = $db->prepare ("INSERT INTO bdd_paie.t_carburant 
                    (id_carb,prix_litre,taux_ID,creerPar,dateCreation,statut_ID) VALUES 
                    (:id_carb,:prix_litre,:taux_ID,:creerPar,:dateCreation,:statut_ID)");
                    $reqAddCarburant->bindValue(':id_carb',$date_carbu);
                    $reqAddCarburant->bindValue(':prix_litre',$prix_litre);
                    $reqAddCarburant->bindValue(':taux_ID',$taux);
                    $reqAddCarburant->bindValue(':creerPar',$creerPar);
                    $reqAddCarburant->bindValue(':dateCreation',$dateCreat);
                    $reqAddCarburant->bindValue(':statut_ID',$statut);
                    $reqAddCarburant->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Carburant');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Carburant');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Carburant');
        exit();
        
    }


