<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    if (isset($_POST['add_dem_conge'])){
       
        $matric= validation_donnees($_POST['matric']);
        $conge= validation_donnees($_POST['conge']);
        $date_demande = validation_donnees($_POST['date_demande']);
        $excercice = validation_donnees($_POST['excercice']); 
        $nbrejrsol = validation_donnees($_POST['nbrejrsol']);
        $nbrejracc = '';
        $date_acc = '';
        $ecart = '';
        $creerPar = $_SESSION['id_utilisateur'];
        $dateCreation = $_POST['date_creat'];
        //$date_debut =$_POST['dateDu'];
        //$date_fin = $_POST['dateAu'];
       $date_debut_en= strtotime($_POST['dateDu']);
     $date_debut = date('Y-m-d',  $date_debut_en);
     $date_fin_en =strtotime($_POST['dateAu']);
     $date_fin = date('Y-m-d', $date_fin_en);
        $observation = isset($_POST['observation']) ? validation_donnees($_POST['observation']) : '';
        $ecart = isset($_POST['ecart']) ? validation_donnees($_POST['ecart']) : '';
        //$modifierPar = $_SESSION['id_utilisateur'];  
       // $statut = $_POST['statutCode'];
       // $Datemodif =$_POST['DateModifBar'];

        if(isset($matric)&& isset($date_demande)&& isset($excercice)&& isset($nbrejrsol)){
            if($matric==''){
             $_SESSION['message']="Selectionez un Agent svp !";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Demande_Conger');
             exit();
            }

            if($date_demande==''){
             $_SESSION['message']="Saisisez la date de damande svp !";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Demande_Conger');
             exit();
            }

            if($excercice==''){
                $_SESSION['message']="Saisisez l'Excercice du Congé";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=Demande_Conger');
                exit();
               }

            if($nbrejrsol==''){
                $_SESSION['message']="Saisisez le nombre de jour sollité";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=Demande_Conger');
                exit();
               }

               if($conge==''){
                $_SESSION['message']="Selectionnez le congé";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=Demande_Conger');
                exit();
               }
         }

        $reqVerificationidbar = $db->prepare('SELECT * FROM bdd_paie.t_demandeconge WHERE excercice=:excercice AND matricule=:matric AND id_typeconge=:typeconge' );
        $reqVerificationidbar -> bindValue(':excercice',$excercice);
        $reqVerificationidbar -> bindValue(':matric',$matric);
        $reqVerificationidbar -> bindValue(':typeconge',$conge);
        $reqVerificationidbar ->execute();

        if($reqVerificationidbar ->rowCount() == 1){
            $_SESSION['message']  = "ce agent a deja une demande pour cet excercice!";
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=Demande_Conger');
            exit();

        }else{
            $reqAdd_bar = $db->prepare('INSERT INTO bdd_paie.t_demandeconge(`id_typeconge`, `date_demande`, `date_debut`, `date_fin`, `excercice`,
             `nbrejr_solic`, `date_accord`, `nbrejr_accord`, `matricule`, `AccordePar`,creerpar) 
            VALUES (:id_typeconge,:dateDemande, :dateDu, :dateAu, :excercice, :nbrejr_solic,null,null,:matricule,null,:creerpar)');


            $reqAdd_bar->bindvalue(':id_typeconge',$conge);
            $reqAdd_bar->bindvalue(':dateDemande',$date_demande);
            $reqAdd_bar->bindvalue(':dateDu',$date_debut);
            $reqAdd_bar->bindvalue(':dateAu',$date_fin);
            $reqAdd_bar->bindvalue(':excercice',$excercice);
            $reqAdd_bar->bindvalue(':nbrejr_solic',$nbrejrsol);
            $reqAdd_bar->bindvalue(':creerpar', $creerPar);
          //  $reqAdd_bar->bindvalue(':nbrejr_accord',is null);
            $reqAdd_bar->bindvalue(':matricule',$matric);
          //  $reqAdd_bar->bindvalue(':AccordePar',is null);
           // $reqAdd_bar->bindvalue(':statut_ID', $statut);
          
         
            $reqAdd_bar->execute();  

            $_SESSION['message']  = "Enregistrement Effectuer avec succès !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Demande_Conger');
            exit();

        }

        
    }
