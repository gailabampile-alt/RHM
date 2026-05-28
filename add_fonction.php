<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['addAgent'])){
            $code = validation_donnees($_POST['cod_fonct']);
            $libe = validation_donnees($_POST['lib_fonct']);
            $dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";
            if(!empty($code) || !empty($libe) )
            {
                try {
                    $reqAddFonction = $db->prepare ("INSERT INTO bdd_paie.t_fonction 
                    (codeFonct,libelleFonct,creerPar,dateCreation,statut_ID) VALUES 
                    (:codeFonct,:libelleFonct,:creerPar,:dateCreation,:statut_ID)");
                    $reqAddFonction->bindValue(':codeFonct',$code);
                    $reqAddFonction->bindValue(':libelleFonct',$libe);
                    $reqAddFonction->bindValue(':creerPar',$creerPar);
                    $reqAddFonction->bindValue(':dateCreation',$dateCreat);
                    $reqAddFonction->bindValue(':statut_ID',$statut);
                    $reqAddFonction->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Fonction');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Fonction');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Fonction');
        exit();
        
    }


