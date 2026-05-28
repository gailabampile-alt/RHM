<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['login'])) {
        header('location:index.php');
        exit();
    }

    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    $username = validation_donnees($_POST['username'] ?? '');
    $password = $_POST['passwords'] ?? '';

    if ($username === '' || $password === '') {
        $_SESSION['message'] = "Veuillez saisir votre nom d'utilisateur et votre mot de passe.";
        $_SESSION['typeMsg'] = 'danger';
        header('location:index.php');
        exit();
    }

    try {
        $stmt = $db->prepare("SELECT password, token, username, agent_ID, validation, statut_ID, role_user_ID, id_user
            FROM bdd_paie.t_utilisateurs
            WHERE username = :username
            LIMIT 1");
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            $_SESSION['message'] = "Cet utilisateur n'existe pas !!!";
            $_SESSION['typeMsg'] = 'danger';
            header('location:index.php');
            exit();
        }

        $id_utilisateur = $result['id_user'];
        $username = $result['username'];
        $agent_ID = $result['agent_ID'];
        $hashedPassword = (string) $result['password'];
        $token = (string) $result['token'];
        $validation = $result['validation'];
        $statut = $result['statut_ID'];
        $droit_acces_utilisateur = $result['role_user_ID'];

        if (password_verify($password, $hashedPassword)) {
            if ($validation == 'Valide' && $statut == 'act') {
                $reqGetNomUtilisateur = $db->prepare('SELECT nom_ag, postnom_ag, prenom_ag FROM bdd_paie.t_agent WHERE matricule = :matricule');
                $reqGetNomUtilisateur->bindValue(':matricule', $agent_ID);
                $reqGetNomUtilisateur->execute();
                $resGetNomUtilisateur = $reqGetNomUtilisateur->fetch(PDO::FETCH_ASSOC);

                $nomComplet = trim(
                    ($resGetNomUtilisateur['nom_ag'] ?? '') . ' ' .
                    ($resGetNomUtilisateur['postnom_ag'] ?? '') . ' ' .
                    ($resGetNomUtilisateur['prenom_ag'] ?? '')
                );

                $_SESSION['nomComplet'] = $nomComplet !== '' ? $nomComplet : $username;
                $_SESSION['id_utilisateur'] = $id_utilisateur;
                $_SESSION['droitDacces'] = $droit_acces_utilisateur;

                $reqHistorique = $db->prepare('INSERT INTO bdd_paie.t_historique_conn (utilisateur_ID, date_con, heure_con)
                    VALUES (:utilisateur_ID, :date_con, :heure_con)');
                $reqHistorique->bindValue(':utilisateur_ID', $_SESSION['id_utilisateur']);
                $reqHistorique->bindValue(':date_con', date('Y-m-d'));
                $reqHistorique->bindValue(':heure_con', date('H:i:s'));
                $reqHistorique->execute();

                $_SESSION['id_histori_con'] = $db->lastInsertId();
                unset($_SESSION['tentatives']);

                header('location:accueil.php');
                exit();
            }

            if ($validation == 'Valide' && $statut == 'desac') {
                $_SESSION['message'] = "Cet utilisateur est desactive !!!\n veuillez contacter votre administrateur";
                $_SESSION['typeMsg'] = 'warning';
                header('location:index.php');
                exit();
            }

            $_SESSION['message'] = 'Mauvaise manipulation du systeme';
            $_SESSION['typeMsg'] = 'warning';
            header('location:index.php');
            exit();
        }

        if ($password === $token) {
            if ($validation == 'Non_Valide' && $statut == 'act') {
                header('location:frm_validationCompte.php');
                exit();
            }

            if ($validation == 'Non_Valide' && $statut == 'desac') {
                $_SESSION['message'] = "Cet utilisateur est desactive et son compte n'est pas valide !!!";
                $_SESSION['typeMsg'] = 'warning';
                header('location:index.php');
                exit();
            }

            $_SESSION['message'] = 'Mauvaise manipulation du systeme';
            $_SESSION['typeMsg'] = 'warning';
            header('location:index.php');
            exit();
        }

        if (!isset($_SESSION['tentatives'])) {
            $_SESSION['tentatives'] = 0;
        }
        $_SESSION['tentatives']++;

        if ($_SESSION['tentatives'] >= 3) {
            $_SESSION['message'] = 'Votre compte est maintenant verrouille apres 3 tentatives incorrectes.';
            $_SESSION['typeMsg'] = 'danger';
            $_SESSION['tentatives'] = 0;

            $updateStmt = $db->prepare("UPDATE bdd_paie.t_utilisateurs SET statut_ID = 'desac' WHERE username = :username");
            $updateStmt->bindParam(':username', $username);
            $updateStmt->execute();

            header('location:index.php');
            exit();
        }

        $_SESSION['message'] = 'Echec de la connexion. Nombre de tentatives : ' . $_SESSION['tentatives'];
        $_SESSION['typeMsg'] = 'danger';
        header('location:index.php');
        exit();
    } catch (PDOException $e) {
        error_log('[HRM] Erreur login: ' . $e->getMessage());
        $_SESSION['message'] = 'Erreur serveur pendant la connexion. Verifiez la base de donnees et les logs PHP.';
        $_SESSION['typeMsg'] = 'danger';
        header('location:index.php');
        exit();
    }
?>
