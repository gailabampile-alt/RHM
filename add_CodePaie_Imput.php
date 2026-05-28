<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    if (isset($_POST['enreg'])){
       
        $codepaie = validation_donnees($_POST['codepaie']);
        $codeEq = validation_donnees($_POST['EquipeCompt']);
        $imput = $_POST['imput'];
        $creerPar =$_SESSION['id_utilisateur'];
        $dateCreation = $_POST['datecodep'];
        $modifierPar = $_SESSION['id_utilisateur'];  
        $Datemodif = $_POST['DateModifcodep'];
       

       // $reqVerificationCodePaie = $db->prepare('SELECT * FROM bdd_paie.detail_codepaie_compt_eqcompt WHERE code_paie_ID=:codepaie AND code_compt_ID=:imput');
       // $reqVerificationCodePaie -> bindValue(':codepaie',$codepaie);
       // $reqVerificationCodePaie ->execute();

        //if($reqVerificationCodePaie ->rowCount() == 1){
        //    $_SESSION['message']  = "Le codePaie : $codepaie est déjà associer à une imputation!";
        //    $_SESSION['typeMsg']  = "danger";
        //    header('location:accueil.php?page=Code_Paie_Imputation');
        //    exit();

        //}else{

            if(isset($codepaie)&& isset($codeEq)&& isset( $imput)){
               if($codepaie ==''){
                $_SESSION['message']="Selectionnez le code Paie";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=Code_Paie_Imputation');
                exit();
               }

               if($codeEq ==''){
                $_SESSION['message']="Selectionnez l'Equipe Comptable";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=Code_Paie_Imputation');
                exit();
               }

               if($imput ==''){
                $_SESSION['message']="Selectionnez une Imputation";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=Code_Paie_Imputation');
                exit();
               }
            }

            


            $reqAdd_CodePaie = $db->prepare('INSERT INTO bdd_paie.detail_codepaie_compt_eqcompt(code_paie_ID, code_compt_ID, code_EqCompt, creerPar, modifierPar, date_Creat, date_Modif)
                VALUES (:codepaie,:imput,:EquipeCompt,:creerPar,:modifierPar,:Date_Creat,:datemodif)');


            $reqAdd_CodePaie->bindvalue(':codepaie',$codepaie);
            $reqAdd_CodePaie->bindvalue(':imput',$imput);
            $reqAdd_CodePaie->bindvalue(':EquipeCompt',$codeEq);
            $reqAdd_CodePaie->bindvalue(':creerPar',$creerPar);
            $reqAdd_CodePaie->bindvalue(':modifierPar',$modifierPar);
            $reqAdd_CodePaie->bindvalue(':Date_Creat',$dateCreation);
            $reqAdd_CodePaie->bindvalue(':datemodif', $Datemodif);

         
            $reqAdd_CodePaie->execute();  

            $_SESSION['message']  = "Enregistrement Effectuer avec succès!";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Code_Paie_Imputation');
            exit();

       // }

        
    }