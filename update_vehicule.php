<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');
        
        if(isset($_GET['code_vehic_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_vehicule SET statut_ID = :statut_ID,
                modifierPar = :modifierPar,dateModif = :dateModif
                WHERE id_veh = :id_veh");
            $reqActiverGrade->bindValue(':statut_ID','act');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModif',date('Y-m-d H:m:s'));
            $reqActiverGrade->bindValue(':id_veh',$_GET['code_vehic_act']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Vehicule');
            exit();
        }
        if(isset($_GET['code_vehic_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_vehicule SET statut_ID = :statut_ID,
                modifierPar = :modifierPar,dateModif = :dateModif
                WHERE id_veh = :id_veh");
            $reqActiverGrade->bindValue(':statut_ID','desac');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModif',date('Y-m-d H:m:s'));
            $reqActiverGrade->bindValue(':id_veh',$_GET['code_vehic_desac']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Vehicule');
            exit();
        }

        if(isset($_POST['updateVehicule'])){
            $matric = validation_donnees($_POST['matric']);
            $modele = validation_donnees($_POST['modele']);
            $nChassis = validation_donnees($_POST['numChassis']);
            $nPermis = validation_donnees($_POST['numPermis']);
            $nCarteRose = validation_donnees($_POST['numCarteRose']);
            $immatric = validation_donnees($_POST['immatric']);
            $observ = validation_donnees($_POST['observ']);
            //$eqCompt = validation_donnees($_POST['eqCompt']);
            $dateCreat = date('Y-m-d');
            $modifierPar = $_SESSION['id_utilisateur'];
            $statut = (isset($_POST['statutCode']))?"act":"desac";
            if(!empty($matric) || !empty($nChassis) || !empty($nCarteRose) || !empty($observ) ||
               !empty($modele) || !empty($nPermis) || !empty($immatric))
            {
                try {
                    $reqAddVehicule = $db->prepare ("UPDATE bdd_paie.t_vehicule SET agent_ID = :agent_ID,modele = :modele,numChassis = :numChassis,numPermis = :numPermis
                    ,numCarteRose = :numCarteRose,immatriculation = :immatriculation,observation = :observation,modifierPar = :modifierPar, dateModif = :dateModif,statut_ID = :statut_ID");
                    $reqAddVehicule->bindValue(':agent_ID',$matric);
                    $reqAddVehicule->bindValue(':modele',$modele);
                    $reqAddVehicule->bindValue(':numChassis',$nChassis);
                    $reqAddVehicule->bindValue(':numPermis',$nPermis);
                    $reqAddVehicule->bindValue(':numCarteRose',$nCarteRose);
                    $reqAddVehicule->bindValue(':immatriculation',$immatric);
                    $reqAddVehicule->bindValue(':observation',$observ);
                    $reqAddVehicule->bindValue(':modifierPar',$modifierPar);
                    $reqAddVehicule->bindValue(':dateModif',date('Y-m-d'));
                    $reqAddVehicule->bindValue(':statut_ID',$statut);
                    $reqAddVehicule->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_Vehicule');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Voir_Vehicule');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Vehicule');
        exit();
        
    }


