<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    //Gmma
    if(isset($_GET['CodePaie_act'])){
        $reqActiverCodePaie = $db->prepare ("UPDATE bdd_paie.t_codepaie SET statut_ID = :statut_ID ,
            modifierPar = :modifierPar,Date_Modif = :dateModif
            WHERE codePaie  = :codePaie ");
        $reqActiverCodePaie->bindValue(':statut_ID','act');
        $reqActiverCodePaie->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
        $reqActiverCodePaie->bindValue(':dateModif',date('Y-m-d'));
        $reqActiverCodePaie->bindValue(':codePaie',$_GET['CodePaie_act']);
        $reqActiverCodePaie->execute();

        $_SESSION['message']  = "Activation Effectuer !";
        $_SESSION['typeMsg']  = "info";
        header('location:accueil.php?page=voir_Code_paie');
        exit();
    }
    if(isset($_GET['CodePaie_desac'])){
        $reqActiverCodePaie = $db->prepare ("UPDATE bdd_paie.t_codepaie SET statut_ID = :statut_ID, 
            modifierPar = :modifierPar,Date_Modif = :dateModif
            WHERE codePaie = :codePaie");
        $reqActiverCodePaie->bindValue(':statut_ID','desac');
        $reqActiverCodePaie->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
        $reqActiverCodePaie->bindValue(':dateModif',date('Y-m-d'));
        $reqActiverCodePaie->bindValue(':codePaie',$_GET['CodePaie_desac']);
        $reqActiverCodePaie->execute();

        $_SESSION['message']  = "Désactivation Effectuer !";
        $_SESSION['typeMsg']  = "info";
        header('location:accueil.php?page=voir_Code_paie');
        exit();
    }

    if (isset($_POST['ModifCodep'])){
       
        $codePaie= validation_donnees($_POST['codepaie']);
        $lib_codepaie = validation_donnees($_POST['libcodePaie']);
        $sens_ID=validation_donnees($_POST['sens']);
        $imposable= validation_donnees($_POST['imposable']);
        $creerPar = $_POST['creercode'];
        $dateCreation = $_POST['dateBar'];
        $modifierPar = $_SESSION['id_utilisateur'];
        $statut = (isset ($_POST['statutCode']))? 'act':'desac' ;
        $Datemodif =$_POST['DateModifBar'];

        //$reqVerificationidbar = $db->prepare('SELECT * FROM bdd_paie.t_bareme WHERE id_bar = :id_bar');
       // $reqVerificationidbar -> bindValue(':id_bar',$id_bar);
       // $reqVerificationidbar ->execute();    ²

       // if($reqVerificationidbar ->rowCount() == 1){
       //     $_SESSION['message']  = "Le id barème : $id_bar est déjà associer à un barème!";
        //    $_SESSION['typeMsg']  = "danger";
        //    header('location:accueil.php?page=Bareme');
        //    exit();

       // }else{
            $reqAdd_bar = $db->prepare("UPDATE bdd_paie.t_codepaie SET codePaie=:codePaie,libelle_codePaie=:libelle_codePaie,sens_ID=:sens_ID,imposable=:imposable,modifierPar=:modifierPar,Date_Modif=:Date_Modif,Date_Creat=:Date_Creat,statut_ID=:statut_ID WHERE codePaie=:codePaie");


            $reqAdd_bar->bindvalue(':codePaie',$codePaie);
            $reqAdd_bar->bindvalue(':libelle_codePaie',$lib_codepaie);
            $reqAdd_bar->bindvalue(':sens_ID',$sens_ID);
            $reqAdd_bar->bindvalue(':imposable',$imposable);
            $reqAdd_bar->bindvalue(':Creat_Par',$creerPar);
            $reqAdd_bar->bindvalue(':modifierPar',$modifierPar);
            $reqAdd_bar->bindvalue(':Date_Modif',$Datemodif);
            $reqAdd_bar->bindvalue(':Date_Creat',$dateCreation);
            $reqAdd_bar->bindvalue(':statut_ID', $statut);
          
         
            $reqAdd_bar->execute();  

            $_SESSION['message']  = "Opération Effectuer avec Succès !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=voir_Code_paie');
            exit();

        //}

        
    }