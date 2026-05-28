<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        /*
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

        */
        if(isset($_POST['update_document_ag'])){
            $id_doc = validation_donnees($_POST['id_doc']);
            $matric = validation_donnees($_POST['matric']);
            $nRef = validation_donnees($_POST['nRef_doc']);
            $typeDoc = validation_donnees($_POST['typeDoc']);
            $observ = validation_donnees($_POST['observ']);
            $doc_ag_Existant = $_POST['doc_ag_Existant'];
            $fichierEnf_Data = "";
            $fichierEnf_Binaire = "";
            $dateModif = date('Y-m-d');
            $modifierPar = $_SESSION['id_utilisateur'];
            $statut = (isset($_POST['statutCode']))?"act":"desac";

            if(empty($_FILES['Fdoc']['name'])){
                if(!empty($matric) || !empty($nRef) || !empty($typeDoc) )
             {
                 try {
                     $reqUpdateEnf = 
                     $db->prepare("UPDATE bdd_paie.t_doc_agent SET id_typedoc = :id_typedoc,
                     ref_doc = :ref_doc,observation = :observation,modifierPar = :modifierPar,dateModif = :dateModif
                        WHERE id_doc = :id_doc");
                    $reqUpdateEnf->bindValue(':id_doc',$id_doc);
                     $reqUpdateEnf->bindValue(':id_typedoc',$typeDoc);
                     $reqUpdateEnf->bindValue(':ref_doc',$nRef);
                     $reqUpdateEnf->bindValue(':observation',$observ);
                     $reqUpdateEnf->bindValue(':modifierPar',$modifierPar);
                     $reqUpdateEnf->bindValue(':dateModif',$dateModif);
                     $reqUpdateEnf->execute();
 
                     $_SESSION['message']  = "Modification Effectuer sur : ".$matric.' | '.$nRef;
                     $_SESSION['typeMsg']  = "info";
                     header('location:accueil.php?page=Voir_Documents');
                     exit();
     
                   } catch (PDOException $e) {
                     echo "Erreur: " . $e->getMessage();
                   }
             }else{
                 $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                 $_SESSION['typeMsg']  = "danger";
                 header('location:accueil.php?page=Voir_Documents');
                 exit();
             }
            }else{
                if($_FILES['Fdoc']['size'] < 10000000){
                    $nomFichier_Enf = $_FILES['Fdoc']['name'];
                    $cheminFichierEnf = 'Documents/'.$nomFichier_Enf;
                    $fichierEnf_Path = pathinfo($cheminFichierEnf,PATHINFO_EXTENSION);
                    $valid  = array("jpg","jpeg","docx","pdf");
                    if(in_array(strtolower($fichierEnf_Path),$valid)){
                        move_uploaded_file($_FILES['Fdoc']['tmp_name'],$cheminFichierEnf);
                        $fichierEnf_Data = file_get_contents($cheminFichierEnf);
                        $fichierEnf_Binaire = base64_encode($fichierEnf_Data); 

                        if(!empty($matric) || !empty($nom) || !empty($postnom) || !empty($prenom) ||
                        !empty($sexe) || !empty($date_naiss) )
                     {
                        try {
                            
                            $fichier = 'Documents/'.$doc_ag_Existant; // Remplacez avec le chemin et le nom du fichier
                            // Vérifiez si le fichier existe avant de le supprimer
                            if (file_exists($fichier)) {
                                if (unlink($fichier)) {
                                    $reqUpdateEnf = 
                                    $db->prepare("UPDATE bdd_paie.t_doc_agent SET id_typedoc = :id_typedoc,
                                    ref_doc = :ref_doc,observation = :observation,modifierPar = :modifierPar,
                                    dateModif = :dateModif,document = :document,document_byte = :document_byte
                                    WHERE id_doc = :id_doc");
                                    $reqUpdateEnf->bindValue(':id_doc',$id_doc);
                                    $reqUpdateEnf->bindValue(':id_typedoc',$typeDoc);
                                    $reqUpdateEnf->bindValue(':ref_doc',$nRef);
                                    $reqUpdateEnf->bindValue(':observation',$observ);
                                    $reqUpdateEnf->bindValue(':modifierPar',$modifierPar);
                                    $reqUpdateEnf->bindValue(':dateModif',$dateModif);
                                    $reqUpdateEnf->bindValue(':document',$nomFichier_Enf);
                                    $reqUpdateEnf->bindValue(':document_byte',$fichierEnf_Binaire);
                                    //$reqUpdateEnf->bindValue(':id_enf',$id_enf);
                                    $reqUpdateEnf->execute();
                
                                    $_SESSION['message']  = "Modification Effectuer !".$matric.' | '.$nRef;
                                    $_SESSION['typeMsg']  = "info";
                                    header('location:accueil.php?page=Voir_Documents');
                                    exit();
                                    //echo "Le fichier a été supprimé avec succès.";
                                } else {
                                    echo "Une erreur est survenue lors de la suppression du fichier.";
                                    echo "<br>";
                                    echo $fichier;
                                }
                            } else {
                                echo "Le fichier n'existe pas.";
                            }
             
                        } catch (PDOException $e) {
                             echo "Erreur: " . $e->getMessage();
                           }
                     }else{
                         $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                         $_SESSION['typeMsg']  = "danger";
                         header('location:accueil.php?page=Voir_Documents');
                         exit();
                     }
                        
                    }else{
                        $_SESSION['message'] = "Votre type de Fichier n'est correspond pas aux types prises en charge";
                        $_SESSION['typeMsg'] = "warning";
                        header('location:accueil.php?page=Voir_Documents');
                        exit;
                    }
                }

            }
            
            



            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Voir_Documents');
        exit();
        
    }


