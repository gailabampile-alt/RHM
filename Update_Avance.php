<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    
    if(isset($_GET['code'])){
        $reqFinStage = $db->prepare ("UPDATE bdd_paie.t_stagiare SET statut_ID = :statut_ID,
                dateFin_stg = :dateFin_stg,modifierPar = :modifierPar
                WHERE id_stg = :id_stg");
        $reqFinStage->bindValue(':statut_ID','desac');
        $reqFinStage->bindValue(':dateFin_stg',date('Y-m-d'));
        $reqFinStage->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
        $reqFinStage->bindValue(':id_stg',$_GET['code']);
        $reqFinStage->execute();

        $_SESSION['message']  = "Suspension du Stage Effectuer !";
        $_SESSION['typeMsg']  = "info";
        header('location:accueil.php?page=Voir_Stagiaire');
        exit();
    }


    if (isset($_POST['creerAvance'])){
        $periode= normalizePeriode($_POST['periode']);
        //$dateAv=$_POST['DateAv'];
        $codepaie = validation_donnees($_POST['codepaie']);
        $matriAg = validation_donnees($_POST['matriAg']);
        $codemonnaie=$_POST['codemonnaie'];
        $MontAv=$_POST['MontAv'];
        $creerPar = $_SESSION['id_utilisateur'];
        $dateCreation = $_POST['dateAvc'];
        $modifierPar = $_SESSION['id_utilisateur'];  
        $Datemodif = $_POST['DateModifcodep'];
        $valeur = $_POST['valeur'];
        $id_avc=$_POST['id_avc'];
        if(isset($codepaie)&& isset($matriAg)&& isset($codemonnaie)&& isset($MontAv)&& isset($valeur)){
            if($codepaie ==''){
             $_SESSION['message']="Selectionnez le code Paie svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=avance_Interet');
             exit();
            }

            if($matriAg ==''){
             $_SESSION['message']="Selectionnez un Agent svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=avance_Interet');
             exit();
            }

            if($codemonnaie ==''){
             $_SESSION['message']="Selectionnez une devise ";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=avance_Interet');
             exit();
            }
            if($MontAv ==''){
                $_SESSION['message']="Saisir un montant";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=avance_Interet');
                exit();
               }
            if($valeur ==''){
                $_SESSION['message']="Selectionnez une I ou A";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=avance_Interet');
                exit();
               }
         }


       // $reqVerificationCodePaie = $db->prepare('SELECT * FROM bdd_paie.t_avance WHERE code_paie_ID= :codepaie and Agent_ID=:matricule and periodeAv=:periode');
       // $reqVerificationCodePaie -> bindValue(':codepaie',$codepaie);
       // $reqVerificationCodePaie -> bindValue(':matricule',$matriAg);
       // $reqVerificationCodePaie -> bindValue(':periode',$periode);
       // $reqVerificationCodePaie ->execute();

       // if($reqVerificationCodePaie ->rowCount() == 1){
        //    $_SESSION['message']  = "Le Matricule : $matriAg a déjà un avance: $codepaie pour le mois $periode  !";
        //    $_SESSION['typeMsg']  = "danger";
        //    header('location:accueil.php?page=avance_Interet');
        //    exit();

       // }else{

                 

            $reqAdd_CodePaie = $db->prepare('UPDATE bdd_paie.t_avance SET Agent_ID=:matriAg,montant=:montant,code_monnaie=:Monnaie,code_paie_ID=:codepaie,periodeAv=:periode,modifierPar=:modifierPar,dateModif=:datemodif,valeur=:valeur WHERE id_avc =:id_avc');


            $reqAdd_CodePaie->bindvalue(':id_avc',$id_avc);
            $reqAdd_CodePaie->bindvalue(':matriAg',$matriAg);
            $reqAdd_CodePaie->bindvalue(':montant',$MontAv);
            $reqAdd_CodePaie->bindvalue(':Monnaie',$codemonnaie);
            $reqAdd_CodePaie->bindvalue(':codepaie',$codepaie);
            $reqAdd_CodePaie->bindvalue(':periode',$periode);
           // $reqAdd_CodePaie->bindvalue(':creerPar',$creerPar);
            $reqAdd_CodePaie->bindvalue(':modifierPar',$modifierPar);
            $reqAdd_CodePaie->bindvalue(':datemodif',$Datemodif);
            //$reqAdd_CodePaie->bindvalue(':dateav',$dateCreation);
            $reqAdd_CodePaie->bindvalue(':valeur',$valeur);
            $reqAdd_CodePaie->execute();  

            $_SESSION['message']  = "Enregistrement Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=voir_Avance');
            exit();
            

        //}

        
    }