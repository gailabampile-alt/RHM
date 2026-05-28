<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');


        if(isset($_POST['update_alloc_familial'])){
            $id_alloc = validation_donnees($_POST['id_alloc']);
            $montant_alloc = validation_donnees($_POST['montant_alloc']);
            $montant_alloc_compare = str_replace(array(' ', ','), array('', '.'), $montant_alloc);

            $reqGetAlloc = $db->prepare("SELECT montant_alloc FROM bdd_paie.t_alloc_famille WHERE id_alloc = :id_alloc");
            $reqGetAlloc->bindValue(':id_alloc',$id_alloc);
            $reqGetAlloc->execute();
            $resAlloc = $reqGetAlloc->fetch();

            if(!$resAlloc){
                $_SESSION['message']  = "Allocation Familial introuvable.";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Voir_alloc_famille');
                exit();
            }

            $montant_actuel_compare = str_replace(array(' ', ','), array('', '.'), $resAlloc['montant_alloc']);

            if(is_numeric($montant_alloc_compare) && is_numeric($montant_actuel_compare) && (float)$montant_alloc_compare < (float)$montant_actuel_compare){
                $_SESSION['message']  = "Erreur : Allocation Familial ne peut pas etre modifiee a la baisse. Montant actuel: ".$resAlloc['montant_alloc'];
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Edit_alloc_famille&code='. $id_alloc);
                exit();
            }

            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_alloc_famille SET modifierPar = :modifierPar,montant_alloc = :montant_alloc,
                date_modif =  :date_modif WHERE id_alloc = :id_alloc");
            $modifierPar = $_SESSION['id_utilisateur'];
            $reqActiverGrade->bindValue(':modifierPar',$modifierPar);
            $reqActiverGrade->bindValue(':montant_alloc',$montant_alloc);
            $reqActiverGrade->bindValue(':date_modif',date('Y-m-d'));
            $reqActiverGrade->bindValue(':id_alloc',$id_alloc);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Modification Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_alloc_famille');
            exit();
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Voir_alloc_famille');
        exit();
        
    }


