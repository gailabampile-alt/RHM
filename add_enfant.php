<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['addEnfant_ag'])){
            $matric = validation_donnees($_POST['matric']);
            $nom = validation_donnees($_POST['nom_enf']);
            $postnom = validation_donnees($_POST['postnom_enf']);
            $prenom = validation_donnees($_POST['prenom_enf']);
            $sexe = validation_donnees($_POST['sexe_enf']);
            $lien = validation_donnees($_POST['lien']);
            $lieu_naiss = validation_donnees($_POST['lieu_naiss']);
            $date_naiss = validation_donnees($_POST['date_naiss_enf']);
            $fichierEnf_Data = "";
            $fichierEnf_Binaire = "";
            if($_FILES['fich_act_nais']['size'] < 10000000){
                $nomFichier_Enf = $_FILES['fich_act_nais']['name'];
                $cheminFichierEnf = 'fichierEnf_Agent/'.$nomFichier_Enf;
                $fichierEnf_Path = pathinfo($cheminFichierEnf,PATHINFO_EXTENSION);
                $valid  = array("jpg","jpeg","docx","pdf");
                if(in_array(strtolower($fichierEnf_Path),$valid)){
                    move_uploaded_file($_FILES['fich_act_nais']['tmp_name'],$cheminFichierEnf);
                    $fichierEnf_Data = file_get_contents($cheminFichierEnf);
                    $fichierEnf_Binaire = base64_encode($fichierEnf_Data); 
                    
                }else{
                    $_SESSION['message'] = "Votre type de Fichier n'est correspond pas aux types prises en charge";
                    $_SESSION['typeMsg'] = "warning";
                    header('location:accueil.php?page=Enfant');
                    exit;
                }
            }
            //$dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";

            if(!empty($matric) || !empty($nom) || !empty($postnom) || !empty($prenom) ||
               !empty($sexe) || !empty($date_naiss) )
            {
                try {
                    $reqAddVehicule = $db->prepare ("INSERT INTO bdd_paie.t_enfants_agent (agent_ID,nom_enf,postnom_enf,prenom_enf,sexe_enf,lien_filiation, creerPar,lieu_naiss,dateNaiss_enf,statut_ID,fichier,fichier_byte) 
                    VALUES (:agent_ID,:nom_enf,:postnom_enf,:prenom_enf,:sexe_enf,:lien,:creerPar,:lieu_naiss,:dateNaiss_enf,:statut_ID,:fichier,:fichier_byte)");
                    $reqAddVehicule->bindValue(':agent_ID',$matric);
                    $reqAddVehicule->bindValue(':nom_enf',$nom);
                    $reqAddVehicule->bindValue(':postnom_enf',$postnom);
                    $reqAddVehicule->bindValue(':prenom_enf',$prenom);
                    $reqAddVehicule->bindValue(':sexe_enf',$sexe);
                    $reqAddVehicule->bindValue(':lien',$lien);
                    $reqAddVehicule->bindValue(':creerPar',$creerPar);
                    $reqAddVehicule->bindValue(':lieu_naiss',$lieu_naiss);
                    $reqAddVehicule->bindValue(':dateNaiss_enf',$date_naiss);
                    $reqAddVehicule->bindValue(':statut_ID',$statut);
                    $reqAddVehicule->bindValue(':fichier',$nomFichier_Enf);
                    $reqAddVehicule->bindValue(':fichier_byte',$fichierEnf_Binaire);
                    $reqAddVehicule->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Enfant');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Enfant');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Enfant');
        exit();
        
    }


