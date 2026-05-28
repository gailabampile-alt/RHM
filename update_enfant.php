<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');


        if(isset($_GET['code_enfant_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_enfants_agent SET statut_ID = :statut_ID,
                modifierPar = :modifierPar,dateModif = :dateModif
                WHERE id_enf = :id_enf");
            $reqActiverGrade->bindValue(':statut_ID','act');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModif',date('Y-m-d'));
            $reqActiverGrade->bindValue(':id_enf',$_GET['code_enfant_act']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Enfant_for_modif');
            exit();
        }
        if(isset($_GET['code_enfant_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_enfants_agent SET statut_ID = :statut_ID,
                modifierPar = :modifierPar,dateModif = :dateModif
                WHERE id_enf = :id_enf");
            $reqActiverGrade->bindValue(':statut_ID','desac');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModif',date('Y-m-d'));
            $reqActiverGrade->bindValue(':id_enf',$_GET['code_enfant_desac']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Enfant_for_modif');
            exit();
        }


        if(isset($_POST['update_enfant'])){
            $matric = validation_donnees($_POST['matric']);
            $id_enf = validation_donnees($_POST['id_enf']);
            $nom = validation_donnees($_POST['nom_enf']);
            $postnom = validation_donnees($_POST['postnom_enf']);
            $prenom = validation_donnees($_POST['prenom_enf']);
            $sexe = validation_donnees($_POST['sexe']);
            $date_naiss = validation_donnees($_POST['date_naiss_enf']);
            $acte_naiss_Existant = validation_donnees($_POST['fich_act_nais_Exist']);
            $fichierEnf_Data = "";
            $fichierEnf_Binaire = "";
            //$dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = (isset($_POST['statutCode']))?"act":"desac";

            if(empty($_FILES['fich_act_nais']['name'])){
                if(!empty($matric) || !empty($nom) || !empty($postnom) || !empty($prenom) ||
                !empty($sexe) || !empty($date_naiss) )
             {
                 try {
                     $reqUpdateEnf = $db->prepare ("UPDATE  bdd_paie.t_enfants_agent SET agent_ID = :agent_ID,nom_enf = :nom_enf,postnom_enf = :postnom_enf,
                     prenom_enf = :prenom_enf,sexe_enf = :sexe_enf,modifierPar = :modifierPar,dateNaiss_enf = :dateNaiss_enf,
                     statut_ID = :statut_ID,dateModif = :dateModif WHERE id_enf = :id_enf");
                     $reqUpdateEnf->bindValue(':agent_ID',$matric);
                     $reqUpdateEnf->bindValue(':nom_enf',$nom);
                     $reqUpdateEnf->bindValue(':postnom_enf',$postnom);
                     $reqUpdateEnf->bindValue(':prenom_enf',$prenom);
                     $reqUpdateEnf->bindValue(':sexe_enf',$sexe);
                     $reqUpdateEnf->bindValue(':modifierPar',$creerPar);
                     $reqUpdateEnf->bindValue(':dateNaiss_enf',$date_naiss);
                     $reqUpdateEnf->bindValue(':statut_ID',$statut);
                     //$reqUpdateEnf->bindValue(':fichier',$nomFichier_Enf);
                     //$reqUpdateEnf->bindValue(':fichier_byte',$fichierEnf_Binaire);
                     $reqUpdateEnf->bindValue(':dateModif',date('Y-m-d H:m:s'));
                     $reqUpdateEnf->bindValue(':id_enf',$id_enf);
                     $reqUpdateEnf->execute();
 
                     $_SESSION['message']  = "Modification Effectuer !".$nom.$id_enf;
                     $_SESSION['typeMsg']  = "info";
                     header('location:accueil.php?page=Voir_Enfant_for_modif');
                     exit();
     
                   } catch (PDOException $e) {
                     echo "Erreur: " . $e->getMessage();
                   }
             }else{
                 $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                 $_SESSION['typeMsg']  = "danger";
                 header('location:accueil.php?page=Voir_Enfant_for_modif');
                 exit();
             }
            }else{
                if($_FILES['fich_act_nais']['size'] < 10000000){
                    $nomFichier_Enf = $_FILES['fich_act_nais']['name'];
                    $cheminFichierEnf = 'fichierEnf_Agent/'.$nomFichier_Enf;
                    $fichierEnf_Path = pathinfo($cheminFichierEnf,PATHINFO_EXTENSION);
                    $valid  = array("jpg","jpeg","docx","pdf");
                    if(in_array(strtolower($fichierEnf_Path),$valid)){
                        move_uploaded_file($_FILES['fich_act_nais']['tmp_name'],$cheminFichierEnf);
                        $fichierEnf_Data = file_get_contents($cheminFichierEnf);
                        $fichierEnf_Binaire = base64_encode($fichierEnf_Data); 

                        if(!empty($matric) || !empty($nom) || !empty($postnom) || !empty($prenom) ||
                        !empty($sexe) || !empty($date_naiss) )
                     {
                         try {
                             $reqUpdateEnf = $db->prepare ("UPDATE  bdd_paie.t_enfants_agent SET agent_ID = :agent_ID,nom_enf = :nom_enf,postnom_enf = :postnom_enf,
                             prenom_enf = :prenom_enf,sexe_enf = :sexe_enf,modifierPar = :modifierPar,dateNaiss_enf = :dateNaiss_enf,
                             statut_ID = :statut_ID,fichier = :fichier,fichier_byte = :fichier_byte, dateModif = :dateModif WHERE id_enf = :id_enf");
                             $reqUpdateEnf->bindValue(':agent_ID',$matric);
                             $reqUpdateEnf->bindValue(':nom_enf',$nom);
                             $reqUpdateEnf->bindValue(':postnom_enf',$postnom);
                             $reqUpdateEnf->bindValue(':prenom_enf',$prenom);
                             $reqUpdateEnf->bindValue(':sexe_enf',$sexe);
                             $reqUpdateEnf->bindValue(':modifierPar',$creerPar);
                             $reqUpdateEnf->bindValue(':dateNaiss_enf',$date_naiss);
                             $reqUpdateEnf->bindValue(':statut_ID',$statut);
                             $reqUpdateEnf->bindValue(':fichier',$nomFichier_Enf);
                             $reqUpdateEnf->bindValue(':fichier_byte',$fichierEnf_Binaire);
                             $reqUpdateEnf->bindValue(':dateModif',date('Y-m-d H:m:s'));
                             $reqUpdateEnf->bindValue(':id_enf',$id_enf);
                             $reqUpdateEnf->execute();
         
                             $_SESSION['message']  = "Modification Effectuer !".$nom.$id_enf;
                             $_SESSION['typeMsg']  = "info";
                             header('location:accueil.php?page=Voir_Enfant_for_modif');
                             exit();
             
                           } catch (PDOException $e) {
                             echo "Erreur: " . $e->getMessage();
                           }
                     }else{
                         $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                         $_SESSION['typeMsg']  = "danger";
                         header('location:accueil.php?page=Voir_Enfant_for_modif');
                         exit();
                     }
                        
                    }else{
                        $_SESSION['message'] = "Votre type de Fichier n'est correspond pas aux types prises en charge";
                        $_SESSION['typeMsg'] = "warning";
                        header('location:accueil.php?page=Voir_Enfant_for_modif');
                        exit;
                    }
                }

            }
            
            



            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Voir_Enfant_for_modif');
        exit();
        
    }


