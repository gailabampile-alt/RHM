<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    if (isset($_POST['creerBar'])){
       
        $id_bar= validation_donnees($_POST['IdBar']);
        $lib_Bar = validation_donnees($_POST['libBar']);
        $creerPar = $_SESSION['id_utilisateur'];
        $dateCreation = $_POST['dateBar'];
        $modifierPar = $_SESSION['id_utilisateur'];  
        $statut = $_POST['statutCode'];
        $Datemodif =$_POST['DateModifBar'];

        if(isset($id_bar)&& isset($lib_Bar)){
            if($id_bar ==''){
             $_SESSION['message']="Saisisez le code Barème svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Bareme');
             exit();
            }

            if($lib_Bar ==''){
             $_SESSION['message']="Saisisez le Libelle Barème";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Bareme');
             exit();
            }
         }

        $reqVerificationidbar = $db->prepare('SELECT * FROM bdd_paie.t_bareme WHERE id_bar = :id_bar');
        $reqVerificationidbar -> bindValue(':id_bar',$id_bar);
        $reqVerificationidbar ->execute();

        if($reqVerificationidbar ->rowCount() == 1){
            $_SESSION['message']  = "Le id barème : $id_bar est déjà associer à un barème!";
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=Bareme');
            exit();

        }else{
            $reqAdd_bar = $db->prepare('INSERT INTO bdd_paie.t_bareme (id_bar, LibelleBar, Creat_Par, Date_Creat, modifierPar, Date_Modif)
                VALUES (:id_bar, :LibelleBar, :Creat_Par, :Date_Creat, :modifierPar, :Date_Modif)');


            $reqAdd_bar->bindvalue(':id_bar',$id_bar);
            $reqAdd_bar->bindvalue(':LibelleBar',$lib_Bar);
            $reqAdd_bar->bindvalue(':Creat_Par',$creerPar);
            $reqAdd_bar->bindvalue(':Date_Creat',$dateCreation);
            $reqAdd_bar->bindvalue(':modifierPar',$modifierPar);
            $reqAdd_bar->bindvalue(':Date_Modif',$Datemodif);
           // $reqAdd_bar->bindvalue(':statut_ID', $statut);
          
         
            $reqAdd_bar->execute();  

            $_SESSION['message']  = "Enregistrement Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Bareme');
            exit();

        }

        
    }