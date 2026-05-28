<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_GET['code_fonct_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_fonction SET statut_ID = :statut_ID 
            WHERE codeFonct = :codeFonct");
            $reqActiverGrade->bindValue(':statut_ID','act');
            $reqActiverGrade->bindValue(':codeFonct',$_GET['code_fonct_act']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Fonction');
            exit();
        }
        if(isset($_GET['code_fonct_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_fonction SET statut_ID = :statut_ID 
            WHERE codeFonct = :codeFonct");
            $reqActiverGrade->bindValue(':statut_ID','desac');
            $reqActiverGrade->bindValue(':codeFonct',$_GET['code_fonct_desac']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Fonction');
            exit();
        }

        if(isset($_POST['updateAgent'])){
            $codeFonction = validation_donnees($_POST['codeFonction']);
            $code = validation_donnees($_POST['cod_fonct']);
            $libe = validation_donnees($_POST['lib_fonct']);
            $dateModif = date('Y-m-d');
            $modifierPar = $_SESSION['id_utilisateur'];
            $statut = (isset($_POST['statutCode']))?"act":"desac";
            if(!empty($code) || !empty($libe) )
            {
                try {
                    $reqAddFonction = $db->prepare ("UPDATE bdd_paie.t_fonction SET codeFonct = :codeFonct,
                    libelleFonct = :libelleFonct,modifierPar = :modifierPar,dateModif = :dateModif,
                    statut_ID = :statut_ID WHERE codeFonct = :codeFonction ");
                    $reqAddFonction->bindValue(':codeFonction',$codeFonction);
                    $reqAddFonction->bindValue(':codeFonct',$code);
                    $reqAddFonction->bindValue(':libelleFonct',$libe);
                    $reqAddFonction->bindValue(':modifierPar',$modifierPar);
                    $reqAddFonction->bindValue(':dateModif',$dateModif);
                    $reqAddFonction->bindValue(':statut_ID',$statut);
                    $reqAddFonction->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_Fonction');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Edit_Fonction');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Voir_Fonction');
        exit();
        
    }


