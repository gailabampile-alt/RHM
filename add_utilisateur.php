<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    if($_POST['creerUser']){
        $matricule = validation_donnees($_POST['matriAg']);
        $nomutilisateur = validation_donnees($_POST['nomUtilisateur']);
        $dateCreation = $_POST['dateCreationUser'];
        $statut = validation_donnees($_POST['statut']);
        $creerPar = $_SESSION['id_utilisateur'];
        $modifierPar = $_SESSION['id_utilisateur'];
        $role = $_POST['roleAg'];
        //$date = date("Y-m-d H:i:s");
        $dateLast_Modifi = $_POST['dateLastModifUser'];
        $token = "Cadeco123@";
        //$token = mot_de_passe_Aleatoire(8);
        /* Envoie du token par mail */

        $reqVerificationMatric = $db->prepare('SELECT * FROM bdd_paie.t_utilisateurs WHERE agent_ID = :agent_ID');
        $reqVerificationMatric -> bindValue(':agent_ID',$matricule);
        $reqVerificationMatric ->execute();

        if($reqVerificationMatric ->rowCount() == 1){
            $_SESSION['message']  = "Le Matricule : $matricule est déjà associer à un compte utilisateur!";
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=Utilisateurs');
            exit();

        }else{
            $reqAdd_user = $db->prepare('INSERT INTO bdd_paie.t_utilisateurs (username,agent_ID,token,creerPar,modifierPar,dateCreation,role_user_ID,statut_ID,dateLast_Modifi)
                VALUES (:username,:agent_ID,:token,:creerPar,:modifierPar,:dateCreation,:role_user_ID,:statut_ID,:dateLast_Modifi)');
            $reqAdd_user->bindvalue(':username',$nomutilisateur);
            $reqAdd_user->bindvalue(':agent_ID',$matricule);
            $reqAdd_user->bindvalue(':token',$token);
            $reqAdd_user->bindvalue(':creerPar',$creerPar);
            $reqAdd_user->bindvalue(':modifierPar',$creerPar);
            $reqAdd_user->bindvalue(':role_user_ID',$role);
            $reqAdd_user->bindvalue(':statut_ID',$statut);
            $reqAdd_user->bindvalue(':dateCreation',$dateCreation);
            $reqAdd_user->bindvalue(':dateLast_Modifi',$dateLast_Modifi);
            $reqAdd_user->execute();  

            $_SESSION['message']  = "Enregistrement Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Utilisateurs');
            exit();

        }

        
    }