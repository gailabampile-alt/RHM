<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');


        if(isset($_GET['id_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_conjoint SET statut_ID = :statut_ID,
                modifierPar = :modifierPar,dateModif = :dateModif
                WHERE id_conj = :id_conj");
            $reqActiverGrade->bindValue(':statut_ID','act');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModif',date('Y-m-d'));
            $reqActiverGrade->bindValue(':id_conj',$_GET['id_act']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_conjoint');
            exit();
        }
        if(isset($_GET['id_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_conjoint SET statut_ID = :statut_ID,
                modifierPar = :modifierPar,dateModif = :dateModif
                WHERE id_conj = :id_conj");
            $reqActiverGrade->bindValue(':statut_ID','desac');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModif',date('Y-m-d'));
            $reqActiverGrade->bindValue(':id_conj',$_GET['id_desac']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_conjoint');
            exit();
        }


        if(isset($_POST['update_conjoint'])){
            $id_conj = validation_donnees($_POST['id_conj']);
            $matric = validation_donnees($_POST['matric']);
            $nom = validation_donnees($_POST['nom_conj']);
            $postnom = validation_donnees($_POST['postnom_conj']);
            $prenom = validation_donnees($_POST['prenom_conj']);
            $sexe = validation_donnees($_POST['sexe_conj']);
            $lieu_mar = validation_donnees($_POST['lieu_mariage']);
            $date_mar = validation_donnees($_POST['date_mariage']);

            $lieu_naiss = validation_donnees($_POST['lieu_naiss']);
            $date_naiss = validation_donnees($_POST['date_naiss_conj']);


           // $lien = validation_donnees($_POST['lien']);
           // $lieu_naiss=validation_donnees($_POST['lieu_naiss']);
           // $date_naiss = validation_donnees($_POST['date_naiss_enf']);
            $acte_mar_Existant = validation_donnees($_POST['fich_act_mar_Exist']);
            $fichierconj_Data = "";
            $fichierconj_Binaire = "";
            //$dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
           // $statut = (isset($_POST['statutCode']))?"act":"desac";

            if(empty($_FILES['fich_act_mar']['name'])){
                if(!empty($matric) || !empty($nom) || !empty($postnom) || !empty($prenom) ||
                !empty($sexe) || !empty($date_naiss) )
             {
                 try {
                    $reqAddVehicule = $db->prepare ("UPDATE bdd_paie.t_conjoint SET agent_ID=:agent_ID,nom_conj=:nom_conj,postnom_conj=:postnom_conj,
                     prenom_conj=:prenom_conj,sexe_conj=:sexe_conj,lieu_mariage=:lieu_mariage,date_mariage=:date_mariage,modifierPar=:modifierPar,
                    dateModif=:dateModif,lieu_naiss=:lieu_naiss,dateNaiss_conj=:dateNaiss_conj
                    WHERE id_conj= :id_conj");
                 $reqAddVehicule->bindValue(':id_conj',$id_conj);
                 $reqAddVehicule->bindValue(':agent_ID',$matric);
                 $reqAddVehicule->bindValue(':nom_conj',$nom);
                 $reqAddVehicule->bindValue(':postnom_conj',$postnom);
                 $reqAddVehicule->bindValue(':prenom_conj',$prenom);
                 $reqAddVehicule->bindValue(':sexe_conj',$sexe);
                 $reqAddVehicule->bindValue(':lieu_mariage',$lieu_mar);
                 $reqAddVehicule->bindValue(':date_mariage',$date_mar);
                 $reqAddVehicule->bindValue(':modifierPar',$ModifierPar);
                 $reqAddVehicule->bindValue(':dateModif',$dateModif);
                 $reqAddVehicule->bindValue(':lieu_naiss',$lieu_naiss);
                 $reqAddVehicule->bindValue(':dateNaiss_conj',$date_naiss);
               //  $reqAddVehicule->bindValue(':fichier',$nomFichier_conj);
                // $reqAddVehicule->bindValue(':fichier_byte',$fichierconj_Binaire);

                $reqAddVehicule->execute();
 
                     $_SESSION['message']  = "Modification Effectuer !".$nom.$postnom;
                     $_SESSION['typeMsg']  = "info";
                     header('location:accueil.php?page=Voir_conjoint');
                     exit();
     
                   } catch (PDOException $e) {
                     echo "Erreur: " . $e->getMessage();
                   }
             }else{
                 $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                 $_SESSION['typeMsg']  = "danger";
                 header('location:accueil.php?page=Voir_conjoint');
                 exit();
             }
            }else{
                if($_FILES['fich_act_mar']['size'] < 10000000){
                    $nomFichier_conj = $_FILES['fich_act_mar']['name'];
                    $cheminFichierconj = 'Documents/'.$nomFichier_conj;
                    $fichierconj_Path = pathinfo($cheminFichierconj,PATHINFO_EXTENSION);
                    $valid  = array("jpg","jpeg","docx","pdf");
                    if(in_array(strtolower($fichierconj_Path),$valid)){
                        move_uploaded_file($_FILES['fich_act_mar']['tmp_name'],$cheminFichierconj);
                        $fichierconj_Data = file_get_contents($cheminFichierconj);
                        $fichierconj_Binaire = base64_encode($fichierconj_Data); 

                        if(!empty($matric) || !empty($nom) || !empty($postnom) || !empty($prenom) ||
                        !empty($sexe) || !empty($date_naiss) )
                     {
                         try {
                            $reqAddVehicule= $db->prepare ("UPDATE bdd_paie.t_conjoint SET agent_ID=:agent_ID,nom_conj=:nom_conj,postnom_conj=:postnom_conj,
                             prenom_conj=:prenom_conj,sexe_conj=:sexe_conj,lieu_mariage=:lieu_mariage,date_mariage=:date_mariage,modifierPar=:modifierPar,
                             dateModif=:dateModif,lieu_naiss=:lieu_naiss,dateNaiss_conj=:dateNaiss_conj,fichier=:fichier,fichier_byte=:fichier_byte
                             WHERE id_conj= :id_conj");
                             $reqAddVehicule->bindValue(':id_conj',$id_conj);
                             $reqAddVehicule->bindValue(':agent_ID',$matric);
                             $reqAddVehicule->bindValue(':nom_conj',$nom);
                             $reqAddVehicule->bindValue(':postnom_conj',$postnom);
                             $reqAddVehicule->bindValue(':prenom_conj',$prenom);
                             $reqAddVehicule->bindValue(':sexe_conj',$sexe);
                             $reqAddVehicule->bindValue(':lieu_mariage',$lieu_mar);
                             $reqAddVehicule->bindValue(':date_mariage',$date_mar);
                             $reqAddVehicule->bindValue(':modifierPar',$ModifierPar);
                             $reqAddVehicule->bindValue(':dateModif',$dateModif);
                             $reqAddVehicule->bindValue(':lieu_naiss',$lieu_naiss);
                             $reqAddVehicule->bindValue(':dateNaiss_conj',$date_naiss);
                             $reqAddVehicule->bindValue(':fichier',$nomFichier_conj);
                             $reqAddVehicule->bindValue(':fichier_byte',$fichierconj_Binaire);
         
                             $reqAddVehicule->execute();
         
                             $_SESSION['message']  = "Modification Effectuer !".$nom.$postnom;
                             $_SESSION['typeMsg']  = "info";
                             header('location:accueil.php?page=Voir_conjoint');
                             exit();
             
                           } catch (PDOException $e) {
                             echo "Erreur: " . $e->getMessage();
                           }
                     }else{
                         $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                         $_SESSION['typeMsg']  = "danger";
                         header('location:accueil.php?page=Voir_conjoint');
                         exit();
                     }
                        
                    }else{
                        $_SESSION['message'] = "Votre type de Fichier n'est correspond pas aux types prises en charge";
                        $_SESSION['typeMsg'] = "warning";
                        header('location:accueil.php?page=Voir_conjoint');
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


