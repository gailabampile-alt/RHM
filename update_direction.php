<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_GET['code_dir_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_direction SET statut_ID = :statut_ID,modifierPar = :modifierPar 
            WHERE code_dir = :code_dir");
            $reqActiverGrade->bindValue(':statut_ID','act');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            //$reqActiverGrade->bindValue(':dateModif',date('Y-m-d H:m:s'));
            $reqActiverGrade->bindValue(':code_dir',$_GET['code_dir_act']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Direction');
            exit();
        }
        if(isset($_GET['code_dir_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_direction SET statut_ID = :statut_ID,modifierPar = :modifierPar 
            WHERE code_dir = :code_dir");
            $reqActiverGrade->bindValue(':statut_ID','desac');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            //$reqActiverGrade->bindValue(':dateModif',date('Y-m-d H:m:s'));
            $reqActiverGrade->bindValue(':code_dir',$_GET['code_dir_desac']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Direction');
            exit();
        }

        if(isset($_POST['updateDirection'])){
            $code = validation_donnees($_POST['code_dir']);
            $code_direction = validation_donnees($_POST['code_direction']);
            $libe = validation_donnees($_POST['lib_dir']);
            //$dateCreat = date('Y-m-d');
            $modifierPar = $_SESSION['id_utilisateur'];
            //$statut = (isset($_POST['statutCode']))?"act":"desac";
            if(!empty($code) || !empty($libe) )
            {
                try {
                    $reqAddDirection = $db->prepare ("UPDATE bdd_paie.t_direction SET
                    code_dir = :code_dir,libelle_dir = :libelle_dir,modifierPar = :modifierPar
                    WHERE code_dir = :code_direction");
                    $reqAddDirection->bindValue(':code_dir',$code);
                    $reqAddDirection->bindValue(':code_direction',$code_direction);
                    $reqAddDirection->bindValue(':libelle_dir',$libe);
                    $reqAddDirection->bindValue(':modifierPar',$modifierPar);
                    //$reqAddDirection->bindValue(':statut_ID',$statut);
                    $reqAddDirection->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_Direction');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Voir_Direction');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Direction');
        exit();
        
    }


