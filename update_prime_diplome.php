<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_GET['code_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.detail_nivetude_montant SET statut_ID = :statut_ID 
            WHERE id_det_nivetud_mont = :id_det_nivetud_mont");
            $reqActiverGrade->bindValue(':statut_ID','act');
            $reqActiverGrade->bindValue(':id_det_nivetud_mont',$_GET['code_act']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_PrimeDiplome');
            exit();
        }
        if(isset($_GET['code_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.detail_nivetude_montant SET statut_ID = :statut_ID 
            WHERE id_det_nivetud_mont = :id_det_nivetud_mont");
            $reqActiverGrade->bindValue(':statut_ID','desac');
            $reqActiverGrade->bindValue(':id_det_nivetud_mont',$_GET['code_desac']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_PrimeDiplome');
            exit();
        }

        if(isset($_POST['updatePrime_dip'])){
            $id_primeDip = validation_donnees($_POST['id_niv']);
            $niv_etu = validation_donnees($_POST['nivEtude']);
            $devise = validation_donnees($_POST['devise']);
            $montant = validation_donnees($_POST['montant']);
            //$codepaie = validation_donnees($_POST['codepaie']);
            $dateModif = date('Y-m-d');
            $modifierPar = $_SESSION['id_utilisateur'];
            $statut = (isset($_POST['statutCode']))?"act":"desac";
            if(!empty($niv_etu) || !empty($montant) || !empty($devise) )
            {
                try {
                    // Récupérer le montant actuel
                    $reqGetMontantActuel = $db->prepare("SELECT montant, statut_ID FROM bdd_paie.detail_nivetude_montant 
                    WHERE id_det_nivetud_mont = :id_det_nivetud_mont");
                    $reqGetMontantActuel->bindValue(':id_det_nivetud_mont',$id_primeDip);
                    $reqGetMontantActuel->execute();
                    $resMontant = $reqGetMontantActuel->fetch();

                    if(!$resMontant || $resMontant['statut_ID'] != "act"){
                        $_SESSION['message']  = "Cette prime est désactivée, pas moyen de modifier.";
                        $_SESSION['typeMsg']  = "warning";
                        header('location:accueil.php?page=Voir_PrimeDiplome');
                        exit();
                    }

                    $montant_actuel = $resMontant['montant'];

                    // Vérifier que le nouveau montant n'est pas inférieur à l'ancien
                    if($montant < $montant_actuel){
                        $_SESSION['message']  = "Erreur : Le montant ne peut pas être diminué. Montant actuel: ". $montant_actuel;
                        $_SESSION['typeMsg']  = "danger";
                        header('location:accueil.php?page=Edit_PrimeDiplome&code='. $id_primeDip);
                        exit();
                    }

                    $reqUpdatePrimeDip = $db->prepare ("UPDATE bdd_paie.detail_nivetude_montant SET niv_etude_ID = :niv_etude_ID,
                    montant = :montant,monnaie_ID = :monnaie_ID,modifierPar = :modifierPar
                    WHERE id_det_nivetud_mont = :id_det_nivetud_mont");
                        $reqUpdatePrimeDip->bindValue(':id_det_nivetud_mont',$id_primeDip);
                        $reqUpdatePrimeDip->bindValue(':niv_etude_ID',$niv_etu);
                        //$reqUpdatePrimeDip->bindValue(':codepaie',$devise);
                        $reqUpdatePrimeDip->bindValue(':monnaie_ID',$devise);
                        $reqUpdatePrimeDip->bindValue(':montant',$montant);
                        $reqUpdatePrimeDip->bindValue(':modifierPar',$modifierPar);
                        $reqUpdatePrimeDip->execute();

                    $_SESSION['message']  = "Modification Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_PrimeDiplome');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Edit_PrimeDiplome&code='. $id_primeDip);
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Voir_Fonction');
        exit();
        
    }


