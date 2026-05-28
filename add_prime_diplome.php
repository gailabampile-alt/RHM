<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');
        
        if(isset($_POST['addPrime_ag'])){
            
            $nivEtude = validation_donnees($_POST['nivEtude']);
            $devise = validation_donnees($_POST['devise']);
            $montant = validation_donnees($_POST['montant']);
            $dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";
            if(!empty($nivEtude) || !empty($devise) || !empty($montant) )
            {
                $reqGetNbrLigne = $db->prepare("SELECT * FROM bdd_paie.detail_nivetude_montant
                    WHERE niv_etude_ID = :niv_etude_ID AND statut_ID = :statut_ID");
                $reqGetNbrLigne->bindValue(':niv_etude_ID',$nivEtude);
                $reqGetNbrLigne->bindValue(':statut_ID',"act");
                $reqGetNbrLigne->execute();
                $nbrDeLigne = $reqGetNbrLigne->rowCount();
                if($nbrDeLigne < 0){
                    try {
                        $reqAddPrimeDiplome = $db->prepare ("INSERT INTO bdd_paie.detail_nivetude_montant
                        (niv_etude_ID,montant,monnaie_ID,creerPar,statut_ID,dateDebut) VALUES 
                        (:niv_etude_ID,:montant,:monnaie_ID,:creerPar,:statut_ID,:dateDebut)");
                        $reqAddPrimeDiplome->bindValue(':niv_etude_ID',$nivEtude);
                        $reqAddPrimeDiplome->bindValue(':monnaie_ID',$devise);
                        $reqAddPrimeDiplome->bindValue(':montant',$montant);
                        $reqAddPrimeDiplome->bindValue(':dateDebut',$dateCreat);
                        $reqAddPrimeDiplome->bindValue(':creerPar',$creerPar);
                        $reqAddPrimeDiplome->bindValue(':statut_ID',$statut);
                        $reqAddPrimeDiplome->execute();
                        
                        $_SESSION['message']  = "Enregistrement Effectuer !";
                        $_SESSION['typeMsg']  = "info";
                        header('location:accueil.php?page=PrimeDiplome');
                        exit();
        
                        }catch (PDOException $e) {
                        echo "Erreur: " . $e->getMessage();
                    }

                }else{
                    $reqUpdatePrime = $db->prepare('UPDATE bdd_paie.detail_nivetude_montant SET dateFin = :dateFin,
                        modifierPar = :modifierPar, statut_ID = :statut_ID WHERE niv_etude_ID = :niv_etude_ID');
                    $reqUpdatePrime->bindValue(':dateFin',$dateCreat);
                    $reqUpdatePrime->bindValue(':modifierPar',$creerPar);
                    $reqUpdatePrime->bindValue(':statut_ID',"desac");
                    //$reqUpdatePrime->bindValue(':statut_ID',$statut);
                    $reqUpdatePrime->bindValue(':niv_etude_ID',$nivEtude);

                    $reqUpdatePrime->execute();
                    try {
                        $reqAddPrimeDiplome = $db->prepare ("INSERT INTO bdd_paie.detail_nivetude_montant
                        (niv_etude_ID,montant,monnaie_ID,creerPar,statut_ID,dateDebut) VALUES 
                        (:niv_etude_ID,:montant,:monnaie_ID,:creerPar,:statut_ID,:dateDebut)");
                        $reqAddPrimeDiplome->bindValue(':niv_etude_ID',$nivEtude);
                        $reqAddPrimeDiplome->bindValue(':monnaie_ID',$devise);
                        $reqAddPrimeDiplome->bindValue(':montant',$montant);
                        $reqAddPrimeDiplome->bindValue(':dateDebut',$dateCreat);
                        $reqAddPrimeDiplome->bindValue(':creerPar',$creerPar);
                        $reqAddPrimeDiplome->bindValue(':statut_ID',$statut);
                        $reqAddPrimeDiplome->execute();
                        
                        $_SESSION['message']  = "Enregistrement Effectuer !";
                        $_SESSION['typeMsg']  = "info";
                        header('location:accueil.php?page=PrimeDiplome');
                        exit();
        
                        }catch (PDOException $e) {
                        echo "Erreur: " . $e->getMessage();
                    }

                }
                
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=PrimeDiplome');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {/*
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=PrimeDiplome');
        exit();*/
        
    }


