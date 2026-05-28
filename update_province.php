<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_GET['code_prov_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_province SET statut_ID = :statut_ID,modifierPar = :modifierPar 
            WHERE code_prov = :code_prov");
            $reqActiverGrade->bindValue(':statut_ID','act');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            //$reqActiverGrade->bindValue(':dateModif',date('Y-m-d H:m:s'));
            $reqActiverGrade->bindValue(':code_prov',$_GET['code_prov_act']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Province');
            exit();
        }
        if(isset($_GET['code_prov_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_province SET statut_ID = :statut_ID,modifierPar = :modifierPar 
            WHERE code_prov = :code_prov");
            $reqActiverGrade->bindValue(':statut_ID','desac');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            //$reqActiverGrade->bindValue(':dateModif',date('Y-m-d H:m:s'));
            $reqActiverGrade->bindValue(':code_prov',$_GET['code_prov_desac']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Province');
            exit();
        }

        if(isset($_POST['updateProvince'])){
            $code = validation_donnees($_POST['codeProv']);
            $libe = validation_donnees($_POST['libProv']);
            //$dateModif = date('Y-m-d');
            $modifierPar = $_SESSION['id_utilisateur'];
            //$statut = (isset($_POST['statutCode']))?"act":"desac";
            if(!empty($code) || !empty($libe) )
            {
                try {
                    $reqAddFonction = $db->prepare ("UPDATE bdd_paie.t_province 
                    SET libelle_prov = :libelle_prov,modifierPar = :modifierPar
                    WHERE code_prov = :code_prov");
                    $reqAddFonction->bindValue(':code_prov',$code);
                    $reqAddFonction->bindValue(':libelle_prov',$libe);
                    $reqAddFonction->bindValue(':modifierPar',$modifierPar);
                    //$reqAddFonction->bindValue(':statut_ID',$statut);
                    $reqAddFonction->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_Province');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Voir_Province');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Voir_Province');
        exit();
        
    }


