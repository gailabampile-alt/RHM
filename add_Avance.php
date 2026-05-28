<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');


    if (isset($_POST['creerAvance'])){
        $periode= normalizePeriode($_POST['periode']);
        //$dateAv=$_POST['DateAv'];
        $codepaie = validation_donnees($_POST['codepaie']);
        $matriAg = validation_donnees($_POST['matriAg']);
        $codemonnaie=$_POST['codemonnaie'];
        $MontAv=$_POST['MontAv'];
        $V_Avance=$_POST['valeur'];
        $creerPar = $_SESSION['id_utilisateur'];
        $dateCreation = $_POST['dateAvc'];
        $modifierPar = $_SESSION['id_utilisateur'];  
        $Datemodif = $_POST['DateModifcodep'];
       

        if(isset($codepaie)&& isset($matriAg)&& isset($codemonnaie)&& isset($MontAv)&& isset($V_Avance)){
            if($codepaie ==''){
             $_SESSION['message']="Selectionnez le code Paie svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=avance_interet');
             exit();
            }

            if($matriAg==''){
             $_SESSION['message']="Selectionnez un Agent svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=avance_interet');
             exit();
            }

            if($codemonnaie==''){
             $_SESSION['message']="Selectionnez une devise ";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=avance_interet');
             exit();
            }
            if($MontAv ==''){
                $_SESSION['message']="Saisir un montant";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=avance_interet');
                exit();
               }
            if($V_Avance ==''){
                $_SESSION['message']="Selectionnez une I ou A";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=avance_interet');
                exit();
               }
         }


        $reqVerificationCodePaie = $db->prepare('SELECT * FROM bdd_paie.t_avance WHERE code_paie_ID= :codepaie and Agent_ID=:matricule and periodeAv=:periode');
        $reqVerificationCodePaie -> bindValue(':codepaie',$codepaie);
        $reqVerificationCodePaie -> bindValue(':matricule',$matriAg);
        $reqVerificationCodePaie -> bindValue(':periode',$periode);
        $reqVerificationCodePaie ->execute();

        if($reqVerificationCodePaie ->rowCount() == 1){
            $_SESSION['message']  = "Le Matricule : $matriAg a déjà un avance pour le mois $periode  !";
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=avance_interet');
            exit();

        }else{

                 

            $reqAdd_CodePaie = $db->prepare('INSERT INTO bdd_paie.t_avance(Agent_ID, montant, code_monnaie,code_paie_ID, periodeAv, creePar, modifierPar, dateModif, date_avc,valeur) 
            VALUES (:matriAg,:montant,:codemonnaie,:codepaie,:periode,:creerPar,:modifierPar,:datemodif,:dateav,:valeur)');


            $reqAdd_CodePaie->bindvalue(':matriAg', $matriAg);
            $reqAdd_CodePaie->bindvalue(':montant',$MontAv);
            $reqAdd_CodePaie->bindvalue(':codepaie',$codepaie);
            $reqAdd_CodePaie->bindvalue(':periode', $periode);
            $reqAdd_CodePaie->bindvalue(':creerPar',  $creerPar);
            $reqAdd_CodePaie->bindvalue(':codemonnaie', $codemonnaie);
           // $reqAdd_CodePaie->bindvalue(':creerPar',$creerPar);
            $reqAdd_CodePaie->bindvalue(':modifierPar',$modifierPar);
            $reqAdd_CodePaie->bindvalue(':datemodif',$Datemodif);
            $reqAdd_CodePaie->bindvalue(':dateav',$dateCreation);
            $reqAdd_CodePaie->bindvalue(':valeur',$V_Avance);
            $reqAdd_CodePaie->execute();  

            $_SESSION['message']  = "Enregistrement Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=avance_Interet');
            exit();
            

        }

        
    }