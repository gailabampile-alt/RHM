<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    if (isset($_POST['creerBarGr'])){
        
        $id_bar = validation_donnees($_POST['codebar']);
        $codegra = validation_donnees($_POST['codegrade']);
        $MontBar = validation_donnees($_POST['MontBar']);
        $Monnaie = validation_donnees($_POST['codemonnaie']);
        $creerPar = $_SESSION['id_utilisateur'];
        $dateCreation = $_POST['dateBar'];
        $modifierPar = $_SESSION['id_utilisateur'];  
        //$statut = $_POST['statutCode'];
        $Datemodif =$_POST['DateModifBar'];
        $datedebut=$_POST['datedeb'];
        $datefin=$_POST['datefin'];
        $statut = (isset ($_POST['statutCode']))? 'act':'desac' ;

        if(isset($id_bar)&& isset($codegra)&& isset($MontBar)&& isset($Monnaie)){
            if($id_bar ==''){
             $_SESSION['message']="Selectionnez le code Barème svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Bareme_Grade');
             exit();
            }

            if($codegra ==''){
             $_SESSION['message']="Selectionnez le code grade svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Bareme_Grade');
             exit();
            }

            if($MontBar ==''){
                $_SESSION['message']="Saisisez le montant Barème";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=Bareme_Grade');
                exit();
               }

            if($Monnaie ==''){
                $_SESSION['message']="Selectionnez la devise svp";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=Bareme_Grade');
                exit();
               }
         }

        $reqVerificationidbar = $db->prepare('SELECT * FROM bdd_paie.detail_grade_bareme WHERE id_bar= :id_bar and code_grade=:code_grade');
        $reqVerificationidbar -> bindValue(':id_bar',$id_bar);
        $reqVerificationidbar -> bindValue(':code_grade',$codegra);
        $reqVerificationidbar ->execute();

        if($reqVerificationidbar ->rowCount() == 1){
            $_SESSION['message']  = "Le grade :$codegra est déjà associer au barème $id_bar!";
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=Bareme_Grade');
            exit();

        }else{
            $reqAdd_bar = $db->prepare('INSERT INTO bdd_paie.detail_grade_bareme(id_bar, code_grade, Montant_bar, code_devise, Date_debut, Date_fin, creerPar, modifierPar, date_creat, date_modif) VALUES (:id_bar,:code_grade,:Monnaie,:devise,:datedebut,:datefin,:Creat_Par,:modifierPar,:Date_Creat,:Date_Modif)');

           // $reqAdd_bar->bindvalue(':id_grade_bar',$id_grade_bar);
            $reqAdd_bar->bindvalue(':id_bar',$id_bar);
            $reqAdd_bar->bindvalue(':code_grade', $codegra);
            $reqAdd_bar->bindvalue(':Monnaie', $MontBar);
            $reqAdd_bar->bindvalue(':devise', $Monnaie);
            $reqAdd_bar->bindvalue(':datedebut', $datedebut);
            $reqAdd_bar->bindvalue(':datefin', $datedebut);
            $reqAdd_bar->bindvalue(':Creat_Par',$creerPar);
            $reqAdd_bar->bindvalue(':modifierPar',$modifierPar);
            $reqAdd_bar->bindvalue(':Date_Creat',$dateCreation);
            $reqAdd_bar->bindvalue(':Date_Modif',$Datemodif);
            
           // $reqAdd_bar->bindvalue(':statut', $datedebut);
            $reqAdd_bar->execute();  

            $_SESSION['message']  = "Enregistrement Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Bareme_Grade');
            exit();

        }

        
    }