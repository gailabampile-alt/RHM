<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    //Gmma
    if(isset($_GET['bareme_act'])){
        $reqActiverBareme = $db->prepare ("UPDATE bdd_paie.t_bareme SET statut_ID = :statut_ID, 
             modifierPar = :modifierPar,Date_Modif = :dateModif
             WHERE id_bar  = :id_bar");
        $reqActiverBareme->bindValue(':statut_ID','act');
        $reqActiverBareme->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
        $reqActiverBareme->bindValue(':dateModif',date('Y-m-d'));
        $reqActiverBareme->bindValue(':id_bar',$_GET['bareme_act']);
        $reqActiverBareme->execute();

        $_SESSION['message']  = "Activation Effectuer !";
        $_SESSION['typeMsg']  = "info";
        header('location:accueil.php?page=voir_Bareme');
        exit();
    }
    if(isset($_GET['bareme_desac'])){
        $reqActiverBareme = $db->prepare ("UPDATE bdd_paie.t_bareme SET statut_ID = :statut_ID,
             modifierPar = :modifierPar,Date_Modif = :dateModif  
            WHERE id_bar = :id_bar");
        $reqActiverBareme->bindValue(':statut_ID','desac');
        $reqActiverBareme->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
        $reqActiverBareme->bindValue(':dateModif',date('Y-m-d'));
        $reqActiverBareme->bindValue(':id_bar',$_GET['bareme_desac']);
        $reqActiverBareme->execute();

        $_SESSION['message']  = "Désactivation Effectuer !";
        $_SESSION['typeMsg']  = "info";
        header('location:accueil.php?page=voir_Bareme');
        exit();
    }

    if (isset($_POST['creerBar'])){
       
        $id_bar= validation_donnees($_POST['IdBar']);
        $lib_Bar = validation_donnees($_POST['libBar']);

        //$creerPar = $_SESSION['id_utilisateur'];
        $dateCreation = $_POST['dateBar'];
       // $modifierPar = validation_donnees($_POST['ModifBar']);
        $modifierPar = $_SESSION['id_utilisateur'];
      
        $statut = (isset ($_POST['statutCode']))? 'act':'desac' ;
        $Datemodif =$_POST['DateModifBar'];

        //$reqVerificationidbar = $db->prepare('SELECT * FROM bdd_paie.t_bareme WHERE id_bar = :id_bar');
       // $reqVerificationidbar -> bindValue(':id_bar',$id_bar);
       // $reqVerificationidbar ->execute();

       // if($reqVerificationidbar ->rowCount() == 1){
       //     $_SESSION['message']  = "Le id barème : $id_bar est  déjà associer à un barème!";
        //    $_SESSION['typeMsg']  = "danger";
        //    header('location:accueil.php?page=Bareme');
        //    exit();

       // }else{
            $reqAdd_bar = $db->prepare("UPDATE bdd_paie.t_bareme SET id_bar=:id_bar,LibelleBar=:LibelleBar,modifierPar=:modifierPar,Date_Modif=:Date_Modif,statut_ID=:statut_ID WHERE t_bareme.id_bar =:id_bar");


            $reqAdd_bar->bindvalue(':id_bar',$id_bar);
            $reqAdd_bar->bindvalue(':LibelleBar',$lib_Bar);
           // $reqAdd_bar->bindvalue(':Creat_Par',$creerPar);
            $reqAdd_bar->bindvalue(':Date_Creat',$dateCreation);
            $reqAdd_bar->bindvalue(':modifierPar',$modifierPar);
            $reqAdd_bar->bindvalue(':Date_Modif',$Datemodif);
            $reqAdd_bar->bindvalue(':statut_ID', $statut);
          
         
            $reqAdd_bar->execute();  

            $_SESSION['message']  = "Opération Effectuer avec Succès !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=voir_Bareme');
            exit();

        //}

        
    }