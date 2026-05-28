<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['printBy'])){
            $activ = $_POST['activ'];
            $siege = $_POST['siege'];
            //$periode = validation_donnees($_POST['periode']);
            if (!empty($_POST['activ']) && !empty($_POST['siege']) ) {
                header("location:print_masseSal_by_activiter.php?siege=$siege&activ=$activ");
                exit();
            }
            if(!empty($_POST['activ'])&& empty($_POST['siege'])){
                header("location:print_masseSal_by_activiter.php?activ=$activ");
                exit();

            }else{
                $_SESSION['message']  = "Avertissement :";
                $_SESSION['typeMsg']  = "Warning";
                header('location:accueil.php?page=Graphic_ActiviteAgent');
                exit();

            }    
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Graphic_ActiviteAgent');
        exit();
        
    }


