<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['printBy'])){
            $periode = validation_donnees($_POST['periode']);
            $matricule = validation_donnees($_POST['matric']);
            //$periode = validation_donnees($_POST['periode']);

            if(!empty($periode))
            {
                try {
                    header('location:print_op_siege.php?periode='.$periode);
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=FP-OP-PC-MS-BC');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=FP-OP-PC-MS-BC');
        exit();
        
    }


