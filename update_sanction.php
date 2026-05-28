<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_GET['id_sanct_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_sanct_agent SET statut_sanct = :statut,
                modifierPar = :modifierPar,dateModif = :dateModif
                WHERE id_sanct = :id_sanct");
            $reqActiverGrade->bindValue(':statut','act');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModif',date('Y-m-d'));
            $reqActiverGrade->bindValue(':id_sanct',$_GET['id_sanct_act']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=voir_sanction');
            exit();
        }
        if(isset($_GET['id_sanct_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_sanct_agent SET statut_sanct = :statut,
                modifierPar = :modifierPar,dateModif = :dateModif
                WHERE id_sanct = :id_sanct");
            $reqActiverGrade->bindValue(':statut','desac');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModif',date('Y-m-d'));
            $reqActiverGrade->bindValue(':id_sanct',$_GET['id_sanct_desac']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=voir_sanction');
            exit();
        }

        if(isset($_POST['addsanction'])){

            $id_sanct=validation_donnees($_POST['id_sanct']);
            $matric = validation_donnees($_POST['matric']);
            $sanct = validation_donnees($_POST['sanct']);
            $Numref = validation_donnees($_POST['Numref']);
            $ate_sanct= validation_donnees($_POST['date_sanct']);
          //  $excercice = validation_donnees($_POST['excercice']);
            //$nbrjr = validation_donnees($_POST['nbrjr']);
            $dateDu = date('Y-m-d', strtotime($_POST['dateDu']));
            $dateAu = date('Y-m-d', strtotime($_POST['dateAu']));
            //$dateDu = validation_donnees($_POST['dateDu']);
            //$dateAu = validation_donnees($_POST['dateAu']);
            $observation = validation_donnees($_POST['observation']);
            $creerPar = validation_donnees($_POST['creerPar']);
            $dateCreat = validation_donnees($_POST['datecreat']);
            $modifierPar =  $_SESSION['id_utilisateur'];
            $datemodif = validation_donnees($_POST['dateModif']);
            $fichiersanct_Data = "";
            $fichiersanct_Binaire = "";

            if(empty($_FILES['fich_sanct']['name'])){
                if(!empty($matric) || !empty($sanct) || !empty($Numref) || !empty($dateCreat)   )
             {
                 try {
                    
                    $reqAddVehicule = $db->prepare (" UPDATE  bdd_paie.t_sanct_agent SET `id_typesanct`=:sanct,`matricule`=:matricule,
                    `ref_sanct`=:ref_sanct,`observation`=:observation,`date_debut`=:date_debut,`date_fin`=:date_fin ,`modifierPar`=:modifierPar,`dateModif`=:dateModif WHERE `id_sanct`=:id_sanct");
                    $reqAddVehicule->bindValue(':id_sanct',$id_sanct);
                    $reqAddVehicule->bindValue(':sanct',$sanct);
                    $reqAddVehicule->bindValue(':matricule',$matric);
                    $reqAddVehicule->bindValue(':ref_sanct',$Numref);
                    $reqAddVehicule->bindValue(':observation',$observation);
                    $reqAddVehicule->bindValue(':date_debut',$dateDu);
                    $reqAddVehicule->bindValue(':date_fin',$dateAu);
                 //   $reqAddVehicule->bindValue(':fichier', $nomFichier_sanct );
                  //  $reqAddVehicule->bindValue(':fichier_byte',$fichiersanct_Binaire);
                  //  $reqAddVehicule->bindValue(':creerPar',$creerPar);
                   // $reqAddVehicule->bindValue(':datecreat',$dateCreat);
                    $reqAddVehicule->bindValue(':modifierPar',$modifierPar);
                    $reqAddVehicule->bindValue(':dateModif',$datemodif);
                    $reqAddVehicule->execute();

                     $_SESSION['message']  = "Modification Effectuer avec Succès !";
                     $_SESSION['typeMsg']  = "info";
                     header('location:accueil.php?page=voir_sanction');
                     exit();
     
                   } catch (PDOException $e) {
                     echo "Erreur: " . $e->getMessage();
                   }
             }else{
                 $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                 $_SESSION['typeMsg']  = "danger";
                 header('location:accueil.php?page=voir_sanction');
                 exit();
             }
            }else{
                if($_FILES['fich_sanct']['size'] < 10000000){
                    $nomFichier_sanct = $_FILES['fich_sanct']['name'];
                    $cheminFichiersanct = 'Documents/'.$nomFichier_sanct;
                    $fichiersanct_Path = pathinfo($cheminFichiersanct,PATHINFO_EXTENSION);
                    $valid  = array("jpg","jpeg","docx","pdf");
                    if(in_array(strtolower($fichiersanct_Path),$valid)){
                        move_uploaded_file($_FILES['fich_sanct']['tmp_name'],$cheminFichiersanct);
                        $fichiersanct_Data = file_get_contents($cheminFichiersanct);
                        $fichiersanct_Binaire = base64_encode($fichiersanct_Data); 

                        if(!empty($matric) || !empty($sanct) || !empty($Numref) || !empty($dateCreat)  )
                     {
                      //   try {
                            $reqAddVehicule = $db->prepare (" UPDATE bdd_paie.t_sanct_agent SET `id_typesanct`=:sanct,`matricule`=:matricule,
                            `ref_sanct`=:ref_sanct,`observation`=:observation,`date_debut`=:date_debut,`date_fin`=:date_fin,`sanction`=:fichier,`sanction_byte`=:fichier_byte,
                            modifierPar=:modifierPar,dateModif=:dateModif WHERE id_sanct=:id_sanct");
                            $reqAddVehicule->bindValue(':id_sanct',$id_sanct);
                            $reqAddVehicule->bindValue(':sanct',$sanct);
                            $reqAddVehicule->bindValue(':matricule',$matric);
                            $reqAddVehicule->bindValue(':ref_sanct',$Numref);
                            $reqAddVehicule->bindValue(':observation',$observation);
                            $reqAddVehicule->bindValue(':date_debut',$dateDu);
                            $reqAddVehicule->bindValue(':date_fin',$dateAu);
                            $reqAddVehicule->bindValue(':fichier', $nomFichier_sanct );
                            $reqAddVehicule->bindValue(':fichier_byte',$fichiersanct_Binaire);
                          //  $reqAddVehicule->bindValue(':creerPar',$creerPar);
                           // $reqAddVehicule->bindValue(':datecreat',$dateCreat);
                            $reqAddVehicule->bindValue(':modifierPar',$modifierPar);
                            $reqAddVehicule->bindValue(':dateModif',$datemodif);
                            $reqAddVehicule->execute();

                            $_SESSION['message']  = "Modification Effectuer avec succès!";
                            $_SESSION['typeMsg']  = "info";
                            header('location:accueil.php?page=voir_sanction');
                            exit();
            
             
                         //  } catch (PDOException $e) {
                        //     echo "Erreur: " . $e->getMessage();
                        //   }
                     }else{
                         $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                         $_SESSION['typeMsg']  = "danger";
                         header('location:accueil.php?page=voir_sanction');
                         exit();
                     }
                        
                    }else{
                        $_SESSION['message'] = "Votre type de Fichier n'est correspond pas aux types prises en charge";
                        $_SESSION['typeMsg'] = "warning";
                        header('location:accueil.php?page=voir_sanction');
                        exit;
                    }
                }

            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=voir_sanction');
        exit();
        
    }


