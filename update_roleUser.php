<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_GET['code_role_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_role_user SET statut_ID = :statut_ID,modifierPar = :modifierPar,dateModifier_role = :dateModifier_role
                     WHERE id_role = :id_role");
            $reqActiverGrade->bindValue(':id_role',$_GET['code_role_act']);
            $reqActiverGrade->bindValue(':statut_ID','act');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModifier_role',date('Y-m-d'));
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_roleUser');
            exit();
        }else if(isset($_GET['code_role_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_role_user SET  statut_ID = :statut_ID,modifierPar = :modifierPar,dateModifier_role = :dateModifier_role
                     WHERE id_role = :id_role");
            $reqActiverGrade->bindValue(':id_role',$_GET['code_role_desac']);
            $reqActiverGrade->bindValue(':statut_ID','desac');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModifier_role',date('Y-m-d'));
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_roleUser');
            exit();
        }



        if(isset($_POST['update_roleUser'])){
            $code = validation_donnees($_POST['code']);
            $libelle = validation_donnees($_POST['libRole']);
            $modifierPar = $_SESSION['id_utilisateur'];
            // Récupérer le statut : si 'statut' est 'act' sinon 'desac'
            $statut = isset($_POST['statut']) && $_POST['statut'] == 'act' ? 'act' : 'desac';
            $dateModif = date('Y-m-d');
            //$eqCompt = validation_donnees($_POST['eqCompt']);
            
            //$statut = "act";
            if(!empty($code) || !empty($libelle) )
            {
                try {
                    $reqAddRole = $db->prepare ("UPDATE bdd_paie.t_role_user SET  libelle_role = :libelle_role,statut_ID = :statut_ID,modifierPar = :modifierPar,dateModifier_role = :dateModifier_role
                     WHERE id_role = :id_role"  );
                    $reqAddRole->bindValue(':id_role',$code,PDO::PARAM_STR);
                    $reqAddRole->bindValue(':libelle_role',$libelle,PDO::PARAM_STR);
                    $reqAddRole->bindValue(':statut_ID',$statut,PDO::PARAM_STR);
                    $reqAddRole->bindValue(':modifierPar',$modifierPar,PDO::PARAM_STR);
                    $reqAddRole->bindValue(':dateModifier_role',$dateModif,PDO::PARAM_STR);
                    $reqAddRole->execute();

                    $_SESSION['message']  = "Modification Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_roleUser');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Voir_roleUser');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Frm_roleUsers');
        exit();
        
    }


