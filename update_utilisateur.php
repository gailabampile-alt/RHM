<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    // DESACTIVATION / ACTIVATION DE L'UTILISATEUR
    // Sans passé par le bouton du formulaire de modification
    
    if(isset($_GET['id_act'])){
        $reqUpdate_user = $db->prepare('UPDATE bdd_paie.t_utilisateurs SET statut_ID = :statut_ID, dateLast_Modifi = :dateLast_Modifi,modifierPar = :modifierPar 
        WHERE id_user = :id_user');
        $reqUpdate_user->bindvalue(':id_user',$_GET['id_act']);
        $reqUpdate_user->bindvalue(':modifierPar',$_SESSION['id_utilisateur']);
        $reqUpdate_user->bindvalue(':statut_ID',"act");
        $reqUpdate_user->bindvalue(':dateLast_Modifi',date("Y-m-d"));
        
        $reqUpdate_user->execute(); 

        $_SESSION['message']  = "Opération Effectuer : Statut Utilisateur Changer avec succes ";
        $_SESSION['typeMsg']  = "info";
        header('location:accueil.php?page=Voir_Utilisateur');
        exit();
    }
    if(isset($_GET['id_des'])){
        $reqUpdate_user = $db->prepare('UPDATE bdd_paie.t_utilisateurs SET statut_ID = :statut_ID, dateLast_Modifi = :dateLast_Modifi,modifierPar = :modifierPar 
        WHERE id_user = :id_user');
        $reqUpdate_user->bindvalue(':id_user',$_GET['id_des']);
        $reqUpdate_user->bindvalue(':modifierPar',$_SESSION['id_utilisateur']);
        $reqUpdate_user->bindvalue(':statut_ID',"desac");
        $reqUpdate_user->bindvalue(':dateLast_Modifi',date("Y-m-d"));
        
        $reqUpdate_user->execute(); 

        $_SESSION['message']  = "Opération Effectuer : Statut Utilisateur Changer avec succes ";
        $_SESSION['typeMsg']  = "info";
        header('location:accueil.php?page=Voir_Utilisateur');
        exit();
    }
    if(isset($_GET['id_reinit'])){
        $reqUpdate_user = $db->prepare('UPDATE bdd_paie.t_utilisateurs SET token = :token, validation = :validation,
        dateLast_Modifi = :dateLast_Modifi,modifierPar = :modifierPar,password = :password
        WHERE id_user = :id_user');
        $reqUpdate_user->bindvalue(':id_user',$_GET['id_reinit']);
        $reqUpdate_user->bindvalue(':token',"Cadeco123@");
        $reqUpdate_user->bindvalue(':password',"Password : After Reinitialisation");
        $reqUpdate_user->bindvalue(':validation',"Non_Valide");
        $reqUpdate_user->bindvalue(':modifierPar',$_SESSION['id_utilisateur']);
        //$reqUpdate_user->bindvalue(':statut_ID',"desac");
        $reqUpdate_user->bindvalue(':dateLast_Modifi',date("Y-m-d"));
        
        $reqUpdate_user->execute(); 

        $_SESSION['message']  = "Opération Effectuer : Utilisateur Réinitialiser avec succes ";
        $_SESSION['typeMsg']  = "info";
        header('location:accueil.php?page=Voir_Utilisateur');
        exit();
    }

    if(isset($_POST['modifierUser'])){
        $matricule = validation_donnees($_POST['matriAg']);
        $nomUtilisateur = validation_donnees($_POST['nomUtilisateur']);
        $statut = validation_donnees($_POST['statut']);
        $modifierPar = $_SESSION['id_utilisateur'];
        $role = $_POST['roleAg'];
        $dateModif = date("Y-m-d");
        $id_user = $_POST['id_user'];
        $token = "Cadeco123@";
        //$token = mot_de_passe_Aleatoire(8);
        /* Envoie du token par mail */

        try {
            if(isset($_POST['reinit'])){
                
                $reqUpdate_user = $db->prepare('UPDATE bdd_paie.t_utilisateurs SET username = :username,agent_ID = :agent_ID,token = :token,validation = :validation, modifierPar = :modifierPar,
                role_user_ID = :role_user_ID,statut_ID = :statut_ID,dateLast_Modifi = :dateLast_Modifi WHERE id_user = :id_user');
                $reqUpdate_user->bindvalue(':username',$nomUtilisateur);
                $reqUpdate_user->bindvalue(':agent_ID',$matricule);
                $reqUpdate_user->bindvalue(':id_user',$id_user);
                $reqUpdate_user->bindvalue(':token',$token);
                $reqUpdate_user->bindvalue(':validation',"Non_Valide");
                $reqUpdate_user->bindvalue(':modifierPar',$modifierPar);
                $reqUpdate_user->bindvalue(':role_user_ID',$role);
                $reqUpdate_user->bindvalue(':statut_ID',$statut);
                $reqUpdate_user->bindvalue(':dateLast_Modifi',$dateModif);echo $role;
                $reqUpdate_user->execute();  

                $_SESSION['message']  = "Enregistrement Effectuer !";
                $_SESSION['typeMsg']  = "info";
                header('location:accueil.php?page=Voir_Utilisateur');
                exit();
                
            }else{
                $reqUpdate_user = $db->prepare('UPDATE bdd_paie.t_utilisateurs SET username = :username,agent_ID = :agent_ID,modifierPar = :modifierPar,
                role_user_ID = :role_user_ID,statut_ID = :statut_ID,dateLast_Modifi = :dateLast_Modifi WHERE id_user = :id_user');
                $reqUpdate_user->bindvalue(':username',$nomUtilisateur);
                $reqUpdate_user->bindvalue(':agent_ID',$matricule);
                $reqUpdate_user->bindvalue(':id_user',$id_user);
                $reqUpdate_user->bindvalue(':modifierPar',$modifierPar);
                $reqUpdate_user->bindvalue(':role_user_ID',$role);
                $reqUpdate_user->bindvalue(':statut_ID',$statut);
                $reqUpdate_user->bindvalue(':dateLast_Modifi',$dateModif);
                
                $reqUpdate_user->execute();

                $_SESSION['message']  = "Enregistrement Effectuer !";
                $_SESSION['typeMsg']  = "info";
                header('location:accueil.php?page=Voir_Utilisateur');
                exit();

            }     
            
            
        } catch (PDOException $ex) {
            $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=Edit_Utilisateur');
            exit();
            
            
        }
            
        
    }