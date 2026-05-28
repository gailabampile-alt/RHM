<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['addEnfant_ag'])){
            $matric = validation_donnees($_POST['matric']);
            $nom = validation_donnees($_POST['nom_conj']);
            $postnom = validation_donnees($_POST['postnom_conj']);
            $prenom = validation_donnees($_POST['prenom_conj']);
            $sexe = validation_donnees($_POST['sexe_conj']);
            $lieu_mar = validation_donnees($_POST['lieu_mariage']);
            $date_mar = validation_donnees($_POST['date_mariage']);
            $lieu_naiss = validation_donnees($_POST['lieu_naiss']);
            $date_naiss = validation_donnees($_POST['date_naiss_conj']);
            $fichierconj_Data = "";
            $fichierconj_Binaire = "";
            if($_FILES['fich_act_mar']['size'] < 10000000){
                $nomFichier_conj = $_FILES['fich_act_mar']['name'];
                $cheminFichierconj = 'Documents/'.$nomFichier_conj;
                $fichierconj_Path = pathinfo($cheminFichierconj,PATHINFO_EXTENSION);
                $valid  = array("jpg","jpeg","docx","pdf");
                if(in_array(strtolower($fichierconj_Path),$valid)){
                    move_uploaded_file($_FILES['fich_act_mar']['tmp_name'],$cheminFichierconj);
                    $fichierconj_Data = file_get_contents($cheminFichierconj);
                    $fichierconj_Binaire = base64_encode($fichierconj_Data); 
                    
                }else{
                    $_SESSION['message'] = "Votre type de Fichier n'est correspond pas aux types prises en charge";
                    $_SESSION['typeMsg'] = "warning";
                    header('location:accueil.php?page=Conjoint');
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
                    $reqAddVehicule = $db->prepare ("INSERT INTO bdd_paie.t_conjoint (agent_ID,nom_conj,postnom_conj,prenom_conj,sexe_conj,lieu_mariage, date_mariage, creerPar,lieu_naiss,dateNaiss_conj,statut_ID,fichier,fichier_byte) 
                    VALUES (:agent_ID,:nom_enf,:postnom_enf,:prenom_enf,:sexe_enf,:lieu_mariage, :date_mariage,:creerPar,:lieu_naiss,:dateNaiss_enf,:statut_ID,:fichier,:fichier_byte)");
                    $reqAddVehicule->bindValue(':agent_ID',$matric);
                    $reqAddVehicule->bindValue(':nom_enf',$nom);
                    $reqAddVehicule->bindValue(':postnom_enf',$postnom);
                    $reqAddVehicule->bindValue(':prenom_enf',$prenom);
                    $reqAddVehicule->bindValue(':sexe_enf',$sexe);
                    $reqAddVehicule->bindValue(':lieu_mariage',$lieu_mar);
                    $reqAddVehicule->bindValue(':date_mariage',$date_mar);
                    $reqAddVehicule->bindValue(':creerPar',$creerPar);
                    $reqAddVehicule->bindValue(':lieu_naiss',$lieu_naiss);
                    $reqAddVehicule->bindValue(':dateNaiss_enf',$date_naiss);
                    $reqAddVehicule->bindValue(':statut_ID',$statut);
                    $reqAddVehicule->bindValue(':fichier',$nomFichier_conj);
                    $reqAddVehicule->bindValue(':fichier_byte',$fichierEnf_Binaire);
                    $reqAddVehicule->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Conjoint');
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


