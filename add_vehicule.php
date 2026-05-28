<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['addVehicule'])){
            $matric = validation_donnees($_POST['matric']);
            $modele = validation_donnees($_POST['modele']);
            $nChassis = validation_donnees($_POST['numChassis']);
            $nPermis = validation_donnees($_POST['numPermis']);
            $nCarteRose = validation_donnees($_POST['numCarteRose']);
            $immatric = validation_donnees($_POST['immatric']);
            $observ = validation_donnees($_POST['observ']);
            //$eqCompt = validation_donnees($_POST['eqCompt']);
            $dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            //$statut = "act";
            if(!empty($matric) || !empty($nChassis) || !empty($nCarteRose) || !empty($observ) ||
               !empty($modele) || !empty($nPermis) || !empty($immatric))
            {
                try {
                    $reqAddVehicule = $db->prepare ("INSERT INTO bdd_paie.t_vehicule (agent_ID,modele,numChassis,numPermis,numCarteRose,immatriculation,observation,creerPar) 
                    VALUES (:agent_ID,:modele,:numChassis,:numPermis,:numCarteRose,:immatriculation,:observation,:creerPar)");
                    $reqAddVehicule->bindValue(':agent_ID',$matric);
                    $reqAddVehicule->bindValue(':modele',$modele);
                    $reqAddVehicule->bindValue(':numChassis',$nChassis);
                    $reqAddVehicule->bindValue(':numPermis',$nPermis);
                    $reqAddVehicule->bindValue(':numCarteRose',$nCarteRose);
                    $reqAddVehicule->bindValue(':immatriculation',$immatric);
                    $reqAddVehicule->bindValue(':observation',$observ);
                    $reqAddVehicule->bindValue(':creerPar',$creerPar);
                    //$reqAddVehicule->bindValue(':Date_Creat',$dateCreat);
                    $reqAddVehicule->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Vehicule');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Vehicule');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Vehicule');
        exit();
        
    }


