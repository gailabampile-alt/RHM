<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');
       
        
        if(isset($_POST['modifierPret'])){
            $id_pret = validation_donnees($_POST['id_pret']);
            $nRef = validation_donnees($_POST['nRef']);
            $matricule = validation_donnees($_POST['matric']);
            $codePaie = validation_donnees($_POST['codePaie']);
            $montPreter = validation_donnees($_POST['montPreter']);
            $durer = validation_donnees($_POST['durer']);
            $solde = validation_donnees($_POST['solde']);
            $periode = normalizePeriode($_POST['periode']);
            $dateDebut = validation_donnees($_POST['dateDebut']);
            $aPayer = validation_donnees($_POST['aPayer']);
            $interet = validation_donnees($_POST['interet']);
            $monnaie = validation_donnees($_POST['monnaie']);
            $modifierPar = $_SESSION['id_utilisateur'];
            $dateModifier = date('Y-m-d');
            $dateDebut =validation_donnees($_POST['dateDebut']); 
            $statut = "act";
            
            //$id_pret = validation_donnees($_POST['monnaie']);
            if(!empty($nRef) || !empty($matricule) || !empty($codePaie) || !empty($montPreter)
            || !empty($durer) || !empty($solde) || !empty($periode) || $dateDebut == "jj/mm/aaaa"
            || !empty($aPayer) || !empty($interet) || !empty($monnaie))
            {
                try {
                    
                    $reqUpdatePret = $db->prepare ("UPDATE bdd_paie.t_pret SET moisEpuration = :moisEpuration,periodePret = :periodePret,N_refPret = :N_refPret,
                                montantPreter = :montantPreter,solde = :solde,montant_a_retenir = :montant_a_retenir,dateDebut_retenir = :dateDebut_retenir,
                                taux_Interet = :taux_Interet,codePaie_ID = :codePaie_ID,statut_ID = :statut_ID,
                                monnaie_ID = :monnaie_ID,modifierPar = :modifierPar,dateModifier=:dateModifier ,agent_ID = :agent_ID WHERE id_pret = :id_pret");
                    $reqUpdatePret->bindValue(':moisEpuration',$durer);
                    $reqUpdatePret->bindValue(':periodePret',$periode);
                    $reqUpdatePret->bindValue(':N_refPret',$nRef);
                    $reqUpdatePret->bindValue(':montantPreter',$montPreter);
                    $reqUpdatePret->bindValue(':solde',$solde);
                    $reqUpdatePret->bindValue(':montant_a_retenir',$aPayer);
                    $reqUpdatePret->bindValue(':dateDebut_retenir',$dateDebut);
                    $reqUpdatePret->bindValue(':taux_Interet',$interet);
                    $reqUpdatePret->bindValue(':codePaie_ID',$codePaie);
                    $reqUpdatePret->bindValue(':statut_ID',$statut);
                    $reqUpdatePret->bindValue(':monnaie_ID',$monnaie);
                    $reqUpdatePret->bindValue(':modifierPar',$modifierPar);
                    $reqUpdatePret->bindValue(':dateModifier',$dateModifier);
                    $reqUpdatePret->bindValue(':agent_ID',$matricule);
                    $reqUpdatePret->bindValue(':id_pret',$id_pret);

                    $reqUpdatePret->execute();
                    $_SESSION['message']  = "Modification Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_Prets');
                    exit();
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Voir_Prets');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Voir_Prets');
        exit();
        
    }


