<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    if(isset($_POST['add_type_conge'])){
       
        $lib_conge= validation_donnees($_POST['lib_conge']);
        $creerPar = $_SESSION['id_utilisateur'];
        $dateCreation = date('Y-m-d');
       

        if(isset($lib_doc)){
            if($lib_doc==''){
             $_SESSION['message']="Selectionez un Agent svp !";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Type_conge');
             exit();
            }

            
         }

        $reqVerificationidbar = $db->prepare('SELECT * FROM bdd_paie.t_typconge WHERE libelle_conge=:libelle_conge' );
        $reqVerificationidbar -> bindValue(':libelle_conge',$lib_conge);
        
        $reqVerificationidbar ->execute();

        if($reqVerificationidbar ->rowCount() == 1){
            $_SESSION['message']  = "ce Type Congé que vous enregistrer existe déjà !";
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=Type_conge');
            exit();

        }else{
            $reqAdd_bar = $db->prepare('INSERT INTO bdd_paie.t_typconge( `libelle_conge`, `creerPar`, `datecreer`, `modifierPar`, `dateModif`, `statut`) 
            VALUES (:libelle_conge,:creerPar,:datecreer,:modifierPar,:dateModif,:statut)');


            $reqAdd_bar->bindvalue(':libelle_conge',$lib_conge);
            $reqAdd_bar->bindvalue(':creerPar',$creerPar);
            $reqAdd_bar->bindvalue(':datecreer',$dateCreation);
            $reqAdd_bar->bindvalue(':modifierPar',null);
            $reqAdd_bar->bindvalue(':dateModif',null);
           $reqAdd_bar->bindvalue(':statut',"act");
            
            $reqAdd_bar->execute();  

            $_SESSION['message']  = "Enregistrement Effectuer avec succès !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Type_conge');
            exit();

        }

        
    }