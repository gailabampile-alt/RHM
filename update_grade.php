<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_GET['code_gr_act'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_grade SET statut_ID = :statut_ID,
                modifierPar = :modifierPar,Date_Modif = :dateModif
                WHERE code_grade = :code_grade");
            $reqActiverGrade->bindValue(':statut_ID','act');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModif',date('Y-m-d'));
            $reqActiverGrade->bindValue(':code_grade',$_GET['code_gr_act']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Activation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Grade');
            exit();
        }
        if(isset($_GET['code_gr_desac'])){
            $reqActiverGrade = $db->prepare ("UPDATE bdd_paie.t_grade SET statut_ID = :statut_ID,
                modifierPar = :modifierPar,Date_Modif = :dateModif
                WHERE code_grade = :code_grade");
            $reqActiverGrade->bindValue(':statut_ID','desac');
            $reqActiverGrade->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqActiverGrade->bindValue(':dateModif',date('Y-m-d'));
            $reqActiverGrade->bindValue(':code_grade',$_GET['code_gr_desac']);
            $reqActiverGrade->execute();

            $_SESSION['message']  = "Désactivation Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Grade');
            exit();
        }

        if(isset($_POST['updateGrade'])){
            $codeGrade = validation_donnees($_POST['code_Orig']);
            $code = validation_donnees($_POST['cod_gr']);
            $libe = validation_donnees($_POST['lib_gr']);
            $eq_paie = validation_donnees($_POST['eqPaie']);
            $eq_compt = validation_donnees($_POST['eqCompt']);
            $dateModif = date('Y-m-d');
            $modifierPar = $_SESSION['id_utilisateur'];
            // Normalize inputs
            $codeGrade = trim($codeGrade);
            $code = trim($code);
            $libe = trim($libe);

            // Ensure original code is present
            if(empty($codeGrade)){
                $_SESSION['message']  = "Opération Echouer  : Code original manquant";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Voir_Grade');
                exit();
            }

            // If changing the code, ensure new code does not already exist
            if($code !== $codeGrade){
                $chk = $db->prepare('SELECT COUNT(*) AS c FROM bdd_paie.t_grade WHERE code_grade = :code');
                $chk->bindValue(':code',$code);
                $chk->execute();
                $resChk = $chk->fetch();
                if($resChk && $resChk['c'] > 0){
                    $_SESSION['message']  = "Opération Echouer  : Le code $code existe déjà.";
                    $_SESSION['typeMsg']  = "danger";
                    header('location:accueil.php?page=Edit_Grade&code_gr='.urlencode($codeGrade));
                    exit();
                }
            }
            //$statut = (isset($_POST['statutCode']))?"act":"desac";
            // Require both code and libelle to be non-empty
            if(!empty($code) && !empty($libe) )
            {
                try {
                    $reqAddFonction = $db->prepare ("UPDATE bdd_paie.t_grade SET code_grade = :code_grade,
                    libelle_grade = :libelle_grade,Eq_Paie_ID = :Eq_Paie_ID,
                    Eq_Compt_ID = :Eq_Compt_ID,modifierPar = :modifierPar,Date_Modif = :Date_Modif
                    WHERE code_grade = :code_gradeLast");
                    $reqAddFonction->bindValue(':code_gradeLast',$codeGrade);
                    $reqAddFonction->bindValue(':code_grade',$code);
                    $reqAddFonction->bindValue(':libelle_grade',$libe);
                    $reqAddFonction->bindValue(':Eq_Paie_ID',$eq_paie );
                    $reqAddFonction->bindValue(':Eq_Compt_ID',$eq_compt);
                    $reqAddFonction->bindValue(':modifierPar',$modifierPar);
                    $reqAddFonction->bindValue(':Date_Modif',$dateModif);
                    //$reqAddFonction->bindValue(':statut_ID',$statut);
                    $reqAddFonction->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_Grade');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Edit_Grade&code_gr='.urlencode($codeGrade));
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Voir_Grade');
        exit();
        
    }


