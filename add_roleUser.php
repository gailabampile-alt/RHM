<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['add_roleUser'])){
            $code = validation_donnees($_POST['code']);
            $libelle = validation_donnees($_POST['libRole']);
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";
            //$eqCompt = validation_donnees($_POST['eqCompt']);
            
            //$statut = "act";
            if(!empty($code) || !empty($libelle) )
            {
                try {
                    $reqAddRole = $db->prepare ("INSERT INTO bdd_paie.t_role_user (id_role,libelle_role,statut_ID,creePar,date_creat) VALUES (:id_role,:libelle_role,:statut_ID,:creePar,:date_creat)");
                    $reqAddRole->bindValue(':id_role',$code,PDO::PARAM_STR);
                    $reqAddRole->bindValue(':libelle_role',$libelle,PDO::PARAM_STR);
                    $reqAddRole->bindValue(':statut_ID',$statut,PDO::PARAM_STR);
                    $reqAddRole->bindValue(':creePar',$creerPar,PDO::PARAM_STR);
                    $reqAddRole->bindValue(':date_creat',date('Y-m-d'),PDO::PARAM_STR);

                    $reqAddRole->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Frm_roleUser');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Frm_roleUser');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Frm_roleUsers');
        exit();
        
    }


