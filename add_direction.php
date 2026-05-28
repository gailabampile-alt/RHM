<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['addDirection'])){
            $code = validation_donnees($_POST['code_dir']);
            $libe = validation_donnees($_POST['lib_dir']);
            $dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";
            if(!empty($code) || !empty($libe) )
            {
                try {
                    $reqAddFonction = $db->prepare ("INSERT INTO bdd_paie.t_direction 
                    (code_dir,libelle_dir,creePar,statut_ID) VALUES 
                    (:code_dir,:libelle_dir,:creerPar,:statut_ID)");
                    $reqAddFonction->bindValue(':code_dir',$code);
                    $reqAddFonction->bindValue(':libelle_dir',$libe);
                    $reqAddFonction->bindValue(':creerPar',$creerPar);
                    $reqAddFonction->bindValue(':statut_ID',$statut);
                    $reqAddFonction->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Direction');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Direction');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Direction');
        exit();
        
    }


