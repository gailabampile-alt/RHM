<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        $activ = $_REQUEST['activ'] ?? '';
        $siege = $_REQUEST['siege'] ?? '';
        $dateDebut = $_REQUEST['dateDebut'] ?? '';
        $dateFin = $_REQUEST['dateFin'] ?? '';

        $params = array();
        if (!empty($activ)) {
            $params['activ'] = $activ;
        }
        if (!empty($siege)) {
            $params['siege'] = $siege;
        }
        if (!empty($dateDebut)) {
            $params['dateDebut'] = $dateDebut;
        }
        if (!empty($dateFin)) {
            $params['dateFin'] = $dateFin;
        }

        if (!empty($params)) {
            header("location:print_agent_filter.php?" . http_build_query($params));
            exit();
        }

        $_SESSION['message']  = "Avertissement : sélectionnez au moins un filtre.";
        $_SESSION['typeMsg']  = "warning";
        header('location:accueil.php?page=Graphic_ActiviteAgent');
        exit();
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Graphic_ActiviteAgent');
        exit();
        
    }


