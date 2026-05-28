<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    $id_utilisateur = '';
    $nom_utilisateur = '';
    $token = '';

    if(isset($_POST['changePasse'])){
        /**Récuperation de donnée de l'utilisateur */
        $req = $db->prepare('SELECT * FROM bdd_paie.t_utilisateurs WHERE token=:token AND username =:username');
        $req->bindvalue(':username',validation_donnees($_POST['user']));
        $req->bindvalue(':token',validation_donnees($_POST['token']));    
        $req->execute();

        while($result = $req->fetch()){
            //id_utilisateur = $result['id_user'];
            $nom_utilisateur = $result['username'];
            $token = $result['token'];
        }
        if($nom_utilisateur == validation_donnees($_POST['user']) 
            && $token == validation_donnees($_POST['token'])){
                // Mises à jours du mot de passe
                $reqMAJ = $db->prepare('UPDATE bdd_paie.t_utilisateurs SET token = :token, password = :passwords, validation = :validations
                    WHERE username = :username ');
                $reqMAJ->bindvalue(':username',validation_donnees($_POST['user']));
                $reqMAJ->bindvalue(':token',validation_donnees('Token:'.$_POST['token']));
                if(validation_donnees($_POST['passwords1']) == validation_donnees($_POST['passwords2'])){
                    $hashedPassword = password_hash($_POST['passwords1'], PASSWORD_DEFAULT);
                    $Password1 =  $hashedPassword;

                    $reqMAJ->bindvalue(':passwords',$Password1);
                    $reqMAJ->bindvalue(':validations',"Valide");
                    $reqMAJ->execute();
                    header('location:index.php');
                    exit();
                }else{
                    $_SESSION['message']  = "Vous avez mal saisie votre Nouveau mot de passe !";
                    $_SESSION['typeMsg']  = "warning";
                    header('location:frm_validationCompte.php');
                    exit();

                }
                
        }else{
            $_SESSION['message']  = "Les informations fournies ne sont pas correctes";
            $_SESSION['typeMsg']  = "warning";

        }
            $_SESSION['message']  = "Les informations fournies ne sont pas correctes";
            $_SESSION['typeMsg']  = "warning";
            header('location:frm_validationCompte.php');
            exit();

    }