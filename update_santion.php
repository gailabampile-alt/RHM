<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['addsanction'])){
            $id_sanct=validation_donnees($_POST['id_sanct']);
            $matric = validation_donnees($_POST['matric']);
            $sanct = validation_donnees($_POST['sanct']);
            $Numref = validation_donnees($_POST['Numref']);
            $ate_sanct= validation_donnees($_POST['date_sanct']);
          //  $excercice = validation_donnees($_POST['excercice']);
            $nbrjr = validation_donnees($_POST['nbrjr']);
            $dateDu = date('Y-m-d', strtotime($_POST['dateDu']));
            $dateAu = date('Y-m-d', strtotime($_POST['dateAu']));
            //$dateDu = validation_donnees($_POST['dateDu']);
            //$dateAu = validation_donnees($_POST['dateAu']);
            $observation = validation_donnees($_POST['observation']);
            $creerPar = validation_donnees($_POST['creerPar']);
            $dateCreat = validation_donnees($_POST['datecreat']);
            $modifierPar = validation_donnees($_POST['modifierPar']);
            $datemodif = validation_donnees($_POST['dateModif']);
            $fichiersanct_Data = "";
            $fichiersanct_Binaire = "";

            if($_FILES['fich_doc_sanct']['size'] < 10000000){
                $nomFichier_sanct = $_FILES['fich_doc_sanct']['name'];
                $cheminFichiersanct = 'Documents/'.$nomFichier_sanct;
                $fichiersanct_Path = pathinfo($cheminFichiersanct,PATHINFO_EXTENSION);
                $valid  = array("jpg","jpeg","docx","pdf");
                if(in_array(strtolower($fichiersanct_Path),$valid)){
                    move_uploaded_file($_FILES['fich_doc_sanct']['tmp_name'],$cheminFichiersanct);
                    $fichiersanct_Data = file_get_contents($cheminFichiersanct);
                    $fichiersanct_Binaire = base64_encode($fichiersanct_Data); 
                    
                }else{
                    $_SESSION['message'] = "Votre type de Fichier n'est correspond pas aux types prises en charge";
                    $_SESSION['typeMsg'] = "warning";
                    header('location:accueil.php?page=Edit_discipline');
                    exit;
                }
            }
            //$dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $modifierPar ='' ;
          //  $statut = "act";

            if(!empty($matric) || !empty($sanct) || !empty($Numref) || !empty($dateCreat) ||
               !empty($nbrjr)  )
            {
                try {
                    $reqAddVehicule = $db->prepare (" UPDATE `t_sanct_agent` SET `id_typesanct`=:sanct,`matricule`=:matricule,
                    `ref_sanct`=:ref_sanct,`observation`=:observation,`date_debut`=:date_debut,`date_fin`=:date_fin,`sanction`=:fichier,`sanction_byte`=:fichier_byte
                    ,`modifierPar`=:modifierPar,`dateModif`=:dateModif WHERE `id_sanct`=:id_sanct");
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

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Edit_discipline');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Edit_discipline');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Edit_discipline');
        exit();
        
    }


