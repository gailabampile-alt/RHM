<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['addProvince'])){
            $code = validation_donnees($_POST['codeProv']);
            $libe = validation_donnees($_POST['libProv']);
            $dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";
            if(!empty($code) || !empty($libe) )
            {
                try {
                    $reqAddFonction = $db->prepare ("INSERT INTO bdd_paie.t_province 
                    (code_prov,libelle_prov,creerPar,statut_ID) VALUES 
                    (:code_prov,:libelle_prov,:creerPar,:statut_ID)");
                    $reqAddFonction->bindValue(':code_prov',$code);
                    $reqAddFonction->bindValue(':libelle_prov',$libe);
                    $reqAddFonction->bindValue(':creerPar',$creerPar);
                    $reqAddFonction->bindValue(':statut_ID',$statut);
                    $reqAddFonction->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Province');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Province');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Province');
        exit();
        
    }


