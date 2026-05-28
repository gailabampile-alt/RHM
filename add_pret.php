<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

     

        if(isset($_POST['octroiPret'])){
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
            $monnaie = validation_donnees($_POST['monnaie']);;
            $dateModifier = date('Y-m-d');
            $modifierPar = $_SESSION['id_utilisateur'];
            //$dateDebut = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";
            if(!empty($nRef) || !empty($matricule) || !empty($codePaie) || !empty($montPreter)
            || !empty($durer) || !empty($solde) || !empty($periode) || $dateDebut == "jj/mm/aaaa"
            || !empty($aPayer) || !empty($interet) || !empty($monnaie))
            {
                try {
                    if($periode >= date('mm-YYYY')){
                        $_SESSION['message']  = "Attention : Votre Période doit être superieur au mois et à l'année en cour !";
                        $_SESSION['typeMsg']  = "warning";
                        header('location:accueil.php?page=Pret');
                        exit();
                    }
                    $reqAddPret = $db->prepare ("INSERT INTO bdd_paie.t_pret (moisEpuration,periodePret,N_refPret,
                                montantPreter,solde,montant_a_retenir,dateDebut_retenir,taux_Interet,codePaie_ID,statut_ID,
                                monnaie_ID,creerPar,modifierPar,dateModifier,agent_ID)
                            VALUES (:moisEpuration,:periodePret,:N_refPret,:montantPreter,:solde,:montant_a_retenir,
                                :dateDebut_retenir,:taux_Interet,:codePaie_ID,:statut_ID,:monnaie_ID,:creerPar,:modifierPar,:dateModifier,:agent_ID)");
                    $reqAddPret->bindValue(':moisEpuration',$durer);
                    $reqAddPret->bindValue(':periodePret',$periode);
                    $reqAddPret->bindValue(':N_refPret',$nRef);
                    $reqAddPret->bindValue(':montantPreter',$montPreter);
                    $reqAddPret->bindValue(':solde',$solde);
                    $reqAddPret->bindValue(':montant_a_retenir',$aPayer);
                    $reqAddPret->bindValue(':dateDebut_retenir',$dateDebut);
                    $reqAddPret->bindValue(':taux_Interet',$interet);
                    $reqAddPret->bindValue(':codePaie_ID',$codePaie);
                    $reqAddPret->bindValue(':statut_ID',$statut);
                    $reqAddPret->bindValue(':monnaie_ID',$monnaie);
                    $reqAddPret->bindValue(':creerPar',$creerPar);
                    $reqAddPret->bindValue(':modifierPar',$modifierPar);
                    $reqAddPret->bindValue(':dateModifier',$dateModifier);
                    $reqAddPret->bindValue(':agent_ID',$matricule);

                    $reqAddPret->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Pret');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Pret');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Pret');
        exit();
        
    }


