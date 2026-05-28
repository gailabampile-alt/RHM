<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    if (isset($_POST['creercodepaie'])){
       
        $codepaie = validation_donnees($_POST['codepaie']);
        $lib_codepaie = validation_donnees($_POST['lib_codepaie']);
        $creerPar = $_SESSION['id_utilisateur'];
        $dateCreation = $_POST['datecodep'];
        $modifierPar = $_SESSION['id_utilisateur'];  
        $Datemodif = $_POST['DateModifcodep'];
        $sens = $_POST['sens'];
        $imposable = $_POST['imposable'];

        if(isset($codepaie)&& isset($lib_codepaie)&& isset($sens)&& isset($imposable)){
            if($codepaie ==''){
             $_SESSION['message']="Saisie le code Paie svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Code_Paie');
             exit();
            }

            if($lib_codepaie ==''){
             $_SESSION['message']="Saisie le Libelle Element Paie svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Code_Paie');
             exit();
            }

            if($sens =='Choisir le sens de la paie'){
             $_SESSION['message']="Selectionnez un sens ";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Code_Paie');
             exit();
            }
            if($imposable =='Choisir une valeur'){
                $_SESSION['message']="Selectionnez une Imposable ou non";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=Code_Paie');
                exit();
               }
         }


        $reqVerificationCodePaie = $db->prepare('SELECT * FROM bdd_paie.t_codepaie WHERE codePaie= :codepaie');
        $reqVerificationCodePaie -> bindValue(':codepaie',$codepaie);
        $reqVerificationCodePaie ->execute();

        if($reqVerificationCodePaie ->rowCount() == 1){
            $_SESSION['message']  = "Le codePaie : $codepaie est déjà associer à un Element de paie!";
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=Code_Paie');
            exit();

        }else{
            $reqAdd_CodePaie = $db->prepare('INSERT INTO bdd_paie.t_codepaie(codePaie, libelle_codePaie, sens_ID, imposable, creerPar, modifierPar, Date_Modif, Date_Creat)
                VALUES (:codepaie, :Libellepaie, :senspaie, :imposable, :creerPar, :modifierPar, :datemodif,:Date_Creat)');


            $reqAdd_CodePaie->bindvalue(':codepaie',$codepaie);
            $reqAdd_CodePaie->bindvalue(':Libellepaie',$lib_codepaie);
            $reqAdd_CodePaie->bindvalue(':senspaie',$sens);
            $reqAdd_CodePaie->bindvalue(':Date_Creat',$dateCreation);
            $reqAdd_CodePaie->bindvalue(':imposable', $imposable);
            $reqAdd_CodePaie->bindvalue(':creerPar',$creerPar);
            $reqAdd_CodePaie->bindvalue(':modifierPar',$modifierPar);
            $reqAdd_CodePaie->bindvalue(':datemodif', $Datemodif);

         
            $reqAdd_CodePaie->execute();  

            $_SESSION['message']  = "Enregistrement Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Code_Paie');
            exit();

        }

        
    }