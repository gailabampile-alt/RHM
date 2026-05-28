<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['ajouterGrade'])){
            $code = validation_donnees($_POST['cod_gr']);
            $libe = validation_donnees($_POST['lib_gr']);
            $eqPaie = validation_donnees($_POST['eqPaie']);
            $eqCompt = validation_donnees($_POST['eqCompt']);
            $dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            //$statut = "act";
            if(!empty($code) || !empty($libe) || !$eqPaie == "0" || !$eqCompt == "0")
            {
                try {
                    $reqAddPret = $db->prepare ("INSERT INTO bdd_paie.t_grade (code_grade,libelle_grade,Eq_Paie_ID,Eq_Compt_ID,
                    creePar,Date_Creat) VALUES (:code_grade,:libelle_grade,:Eq_Paie_ID,:Eq_Compt_ID,:creePar,:Date_Creat)");
                    $reqAddPret->bindValue(':code_grade',$code);
                    $reqAddPret->bindValue(':libelle_grade',$libe);
                    $reqAddPret->bindValue(':Eq_Paie_ID',$eqPaie);
                    $reqAddPret->bindValue(':Eq_Compt_ID',$eqCompt);
                    $reqAddPret->bindValue(':creePar',$creerPar);
                    $reqAddPret->bindValue(':Date_Creat',$dateCreat);
                    $reqAddPret->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Grade');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Grade');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Pret');
        exit();
        
    }


