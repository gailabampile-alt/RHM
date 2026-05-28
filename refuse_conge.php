<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        
       
        if(isset($_POST['refuse'])){
           $id_demande = validation_donnees($_POST['id_demande']);
           $nbrejrsol = validation_donnees($_POST['nbrejrsol']);
           $nbrejrben = "0";
           $dateacc = date('Y-m-d');
           $accordPar = $_SESSION['id_utilisateur'];
           $statut ="nauto";
            
                try {
                    $reqAddFonction = $db->prepare ("UPDATE bdd_paie.t_demandeconge SET nbrejr_accord=:nbrejrAcc,AccordePar =:AccorderPar,date_accord=:dateacc,statut=:statut,etat=:etat WHERE id_demande=:id_demande");
                   $reqAddFonction->bindValue(':id_demande',$id_demande);
                    $reqAddFonction->bindValue(':nbrejrAcc',$nbrejrben);
                    $reqAddFonction->bindValue(':AccorderPar',$accordPar);
                    $reqAddFonction->bindValue(':dateacc',$dateacc);
                    $reqAddFonction->bindValue(':statut',$statut);
                    $reqAddFonction->bindValue(':etat',"desac");
                    $reqAddFonction->execute();

                    $_SESSION['message']  = "Resus Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=voir_demande_conge');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            
            
        }
        
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=voir_demande_conge');
        exit();
        
    }


