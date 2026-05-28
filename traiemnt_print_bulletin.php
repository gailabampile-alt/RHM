<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['printBy'])){
            $code_siege = validation_donnees($_POST['code_siege']);
            $matricule = validation_donnees($_POST['matric']);
            $periode = validation_donnees($_POST['periode']);
            if(!empty($code_siege)){
                header('location:print_bulletin_paie_siege.php?codeS='.$code_siege.'& periode='.$periode);
                exit;
            }elseif (!empty($matricule) && !empty($periode) /*&& empty($code_siege)*/) {
                try {
                    header('location:print_bulletin_paie_indiv.php?matric='.$matricule.'& periode='.$periode);
                    exit();
    
                } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir les zones concerner par votre filtre";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Bulletins');
                exit();

            }
         
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Bulletins');
        exit();
        
    }


