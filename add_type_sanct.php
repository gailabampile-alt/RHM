<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    if(isset($_POST['add_type_sanct'])){
      
        $lib_sanct= validation_donnees($_POST['lib_doc']);
        $creerPar = $_SESSION['id_utilisateur'];
        $dateCreation = date('Y-m-d');
        $datemodif= date('Y-m-d');
        $modifierPar = $_SESSION['id_utilisateur'];
        if(isset($lib_doc)){
            if($lib_doc==''){
             $_SESSION['message']="Selectionez un Agent svp !";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Type_document');
             exit();
            }

            
         }

        $reqVerificationidbar = $db->prepare('SELECT * FROM bdd_paie.t_type_sanct WHERE libelle_typesanct=:libelle_typesanct' );
        $reqVerificationidbar -> bindValue(':libelle_typesanct',$lib_sanct);
        
        $reqVerificationidbar ->execute();

        if($reqVerificationidbar ->rowCount() == 1){
            $_SESSION['message']  = "le Type sanction que vous enregistrer existe déjà !";
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=Type_sanction');
            exit();

        }else{
            $reqAdd_bar = $db->prepare('INSERT INTO bdd_paie.t_type_sanct(`libelle_typesanct`, `creerPar`, `datecreer`, `modifierPar`, `dateModif`, `statut`) 
            VALUES (:libelle_typesanct,:creerPar,:datecreer,:modifierPar,:dateModif,:statut)');


            $reqAdd_bar->bindvalue(':libelle_typesanct',$lib_sanct);
            $reqAdd_bar->bindvalue(':creerPar',$creerPar);
            $reqAdd_bar->bindvalue(':datecreer',$dateCreation);
            $reqAdd_bar->bindvalue(':modifierPar',$modifierPar);
            $reqAdd_bar->bindvalue(':dateModif',$datemodif);
            $reqAdd_bar->bindvalue(':statut',"act");
            
          
         
            $reqAdd_bar->execute();  

            $_SESSION['message']  = "Enregistrement Effectuer avec succès !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Type_sanction');
            exit();

        }

        
    }