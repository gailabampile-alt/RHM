<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        
       
        if(isset($_POST['auto_conge'])){
           $id_demande = validation_donnees($_POST['id_demande']);
           /// $matricule = validation_donnees($_POST['matric']);
           // $date_demande = validation_donnees($_POST['date_demande']);
          //  $excercice = validation_donnees($_POST['excercice']);
           $nbrejrsol = validation_donnees($_POST['nbrejrsol']);
            $nbrejrben = validation_donnees($_POST['nbrejrben']);
          //  $ecart = validation_donnees($_POST['ecart']);
          //  $conge = validation_donnees($_POST['conge']);
          $date_debut_en= strtotime($_POST['dateDu']);
          $date_fin_en= strtotime($_POST['dateAu']);
          $dateDu = date('Y-m-d',  $date_debut_en);
          $dateAu = date('Y-m-d',  $date_fin_en);
      // $dateDu = validation_donnees($_POST['dateDu']);
        //   $dateAu = validation_donnees($_POST['dateAu']);
          //  $creer = validation_donnees($_POST['creerPar']);
          //  $datecreat = validation_donnees($_POST['datecreat']);
            $dateacc = date('Y-m-d');
            $accordPar = $_SESSION['id_utilisateur'];
            $statut ="auto";
            if(!empty($nbrejrben))
            {
              if($nbrejrben > $nbrejrsol){
                $_SESSION['message']="le nombre de jour accordé superieur au nombre de jour demandé!";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=voir_demande_conge');
                exit();
               }
                try {
                    $reqAddFonction = $db->prepare ("UPDATE bdd_paie.t_demandeconge SET date_debut=:date_debut,date_fin=:date_fin, nbrejr_accord=:nbrejrAcc,AccordePar =:AccorderPar,date_accord=:dateacc,statut=:statut WHERE id_demande=:id_demande");
                    $reqAddFonction->bindValue(':date_debut',$dateDu);
                    $reqAddFonction->bindValue(':date_fin',$dateAu);
                    $reqAddFonction->bindValue(':id_demande',$id_demande);
                    $reqAddFonction->bindValue(':nbrejrAcc',$nbrejrben);
                    $reqAddFonction->bindValue(':AccorderPar',$accordPar);
                    $reqAddFonction->bindValue(':dateacc',$dateacc);
                    $reqAddFonction->bindValue(':statut',$statut);
                   // $reqAddFonction->bindValue(':etat',"act");
                    $reqAddFonction->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=voir_demande_conge');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez saisir le nombre de jour benéficié";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=voir_demande_conge');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=voir_demande_conge');
        exit();
        
    }


