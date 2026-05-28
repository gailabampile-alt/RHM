<?php
    session_start();
	include_once('sys_connexion.php');
    include_once('sys_fonction.php');
   
    if (isset($_POST['changePass'])){ 
        $ancienPass = $_POST['lastPassword'];
        $Password1 = $_POST['Password1'];
        $Password2 = $_POST['Password2'];

        if($Password1 == $Password2){ 
            $req = $db->prepare('SELECT * FROM bdd_paie.t_utilisateurs WHERE id_user = :id_user');
            $req->bindvalue(':id_user',$_SESSION['id_utilisateur']);
            $result = $req->execute();
            $numbre = $req->rowCount();
            $infoUser = $req->fetch();
            if (password_verify($ancienPass, $infoUser['password'])) {
                // Le mot de passe est correct
                $hashedPassword = password_hash($Password1, PASSWORD_DEFAULT);
                $Password1 =  $hashedPassword;

                $reqReinit = $db->prepare('UPDATE bdd_paie.t_utilisateurs SET password = :passwords WHERE id_user = :id_user');
                $reqReinit->bindvalue(':passwords',$Password1);
                $reqReinit->bindvalue(':id_user',$_SESSION['id_utilisateur']);
                $resultReinit = $reqReinit->execute();

                header('location:sys_logOut.php');
                exit();
            } else {
                // Le mot de passe est incorrect
                $_SESSION['message'] = "Votre ancien mot de passe ne correspond pas à celui en mémoire ▲ Veuiller saisir un mot de passe valide";
                $_SESSION['typeMsg'] = "Warning";
                header('locatin:accueil.php?page=ChangementPIN');
                exit();
            
            }  
            
        }else{
            $_SESSION['message'] = "Vos mot de passe ne sont pas identique !";
            $_SESSION['typeMsg'] = "Warning";
            header('location:accueil.php?page=ChangementPIN');
            exit();
        }
    }

?>


