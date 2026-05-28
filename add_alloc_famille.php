<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');


        if(isset($_POST['add_alloc_familial'])){
            $reqUpdateOldId_alloc = $db->prepare('UPDATE bdd_paie.t_alloc_famille SET statut_ID = "desac",modifierPar = :modifierPar, date_modif = :date_modif
                WHERE id_alloc = :id_alloc');
            

            $creerPar = $_SESSION['id_utilisateur'];
            $reqUpdateOldId_alloc->bindValue(':id_alloc',$_POST['id_alloc']);
            $reqUpdateOldId_alloc->bindValue(':modifierPar',$creerPar);
            $reqUpdateOldId_alloc->bindValue(':date_modif',date('Y-m-d'));
            $reqUpdateOldId_alloc->execute();


            $reqInsertAlloc = $db->prepare ("INSERT INTO bdd_paie.t_alloc_famille  (id_alloc,codePaie,libelle_alloc,montant_alloc,creerPar,date_creat)
                VALUES (:id_alloc,:codePaie,:libelle_alloc,:montant_alloc,:creerPar,:date_creat)");


            $parties = explode("|", $_POST['cPaie']);

            $codePaie = $parties[0];
            $libPaie = $parties[1]; 

            
            $reqInsertAlloc->bindValue(':id_alloc',$_POST['id_alloc']);
            $reqInsertAlloc->bindValue(':codePaie',$codePaie);
            $reqInsertAlloc->bindValue(':libelle_alloc',$libPaie);
            $reqInsertAlloc->bindValue(':montant_alloc',$_POST['montant_alloc']);
            $reqInsertAlloc->bindValue(':date_creat',date('Y-m-d'));
            $reqInsertAlloc->bindValue(':creerPar',$creerPar);
            $reqInsertAlloc->execute();



            $_SESSION['message']  = "Enregistrement Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Frm_alloc_famille');
            exit();
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Frm_alloc_famille');
        exit();
        
    }


