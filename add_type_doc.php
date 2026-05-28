<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    if(isset($_POST['add_type_doc'])){
        echo "Bonjour";
        $lib_doc= validation_donnees($_POST['lib_doc']);
        $creerPar = $_SESSION['id_utilisateur'];
        $dateCreation = date('Y-m-d');
       

        if(isset($lib_doc)){
            if($lib_doc==''){
             $_SESSION['message']="Selectionez un Agent svp !";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Type_document');
             exit();
            }

            
         }

        $reqVerificationidbar = $db->prepare('SELECT * FROM bdd_paie.t_type_doc WHERE libelle_typedoc=:libelle_typedoc' );
        $reqVerificationidbar -> bindValue(':libelle_typedoc',$lib_doc);
        
        $reqVerificationidbar ->execute();

        if($reqVerificationidbar ->rowCount() == 1){
            $_SESSION['message']  = "le Type document que vous enregistrer existe déjà !";
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=Type_document');
            exit();

        }else{
            $reqAdd_bar = $db->prepare('INSERT INTO bdd_paie.t_type_doc(`libelle_typedoc`, `creerPar`, `datecreer`, `modifierPar`, `dateModif`, `statut`) 
            VALUES (:libelle_typedoc,:creerPar,:datecreer,:modifierPar,:dateModif,:statut)');


            $reqAdd_bar->bindvalue(':libelle_typedoc',$lib_doc);
            $reqAdd_bar->bindvalue(':creerPar',$creerPar);
            $reqAdd_bar->bindvalue(':datecreer',$dateCreation);
            $reqAdd_bar->bindvalue(':modifierPar',null);
            $reqAdd_bar->bindvalue(':dateModif',null);
            $reqAdd_bar->bindvalue(':statut',"act");
            
          
         
            $reqAdd_bar->execute();  

            $_SESSION['message']  = "Enregistrement Effectuer avec succès !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Type_document');
            exit();

        }

        
    }