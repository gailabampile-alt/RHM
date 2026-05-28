<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_GET['id_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_typconge SET statut = :statut,modifierPar =:modifierPar ,dateModif=:dateModif
            WHERE id_type_conge = :id_type_conge");
            $reqActiverGrade->bindValue(':statut','act');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModif',date('Y-m-d'));
            $reqActiverGrade->bindValue(':id_type_conge',$_GET['id_act']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=voir_type_conge');
            exit();
        }
        if(isset($_GET['id_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_typconge SET statut = :statut,modifierPar = :modifierPar ,dateModif=:dateModif
            WHERE id_type_conge= :id_type_conge");
            $reqActiverGrade->bindValue(':statut','desac');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModif',date('Y-m-d'));
            $reqActiverGrade->bindValue(':id_type_conge',$_GET['id_desac']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=voir_type_conge');
            exit();
        }

        if(isset($_POST['update_type_conge'])){
            $id_type_conge = validation_donnees($_POST['id_type_conge']);
            $lib = validation_donnees($_POST['lib_conge']);
            $dateModif = date('Y-m-d');
            $modifierPar = $_SESSION['id_utilisateur'];
            //$statut = (isset($_POST['statutCode']))?"act":"desac";
          
            if(!empty($id_type_conge) || !empty($lib) )
            {
                try {
                   
                   $reqAddFonction = $db->prepare ("UPDATE bdd_paie.t_typconge SET libelle_conge =:libelle_conge,modifierPar = :modifierPar,dateModif=:dateModif
                    WHERE id_type_conge =:id_type_conge");
                    $reqAddFonction->bindValue(':id_type_conge',$id_type_conge);
                    $reqAddFonction->bindValue(':libelle_conge',$lib);
                    $reqAddFonction->bindValue(':modifierPar',$modifierPar);
                    $reqAddFonction->bindValue(':dateModif',$dateModif);
                   // $reqAddFonction->bindValue(':statut',$statut);
                    $reqAddFonction->execute();

                    $_SESSION['message']  = "Modification Effectuer avec succès !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=voir_type_conge');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=voir_type_conge');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=voir_type_doc');
        exit();
        
    }


