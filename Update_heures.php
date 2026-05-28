<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    if (isset($_POST['Modif'])){ echo 2;
        $periode=$_POST['periode'];
        //$dateAv=$_POST['DateAv'];
        $id_pointage=$_POST['id_pointage'];
        $periode = validation_donnees($_POST['periode']);
        //$datep=validation_donnees($_POST['dateop']);
        $matriAg = validation_donnees($_POST['matriAg']);
        
        $nbreh=$_POST['nbreh'];
        $creerPar = $_SESSION['id_utilisateur'];
        $dateCreation = $_POST['dateop'];
        $modifierPar = $_SESSION['id_utilisateur'];  
        $Datemodif = date('Y-m-d');
        $heure = $_POST['heure'];

        if(isset($periode)&& isset($matriAg)&& isset($nbreh)){
            if($periode ==''){
             $_SESSION['message']="Selectionnez la periode svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Pointage');
             exit();
            }

            if($matriAg ==''){
             $_SESSION['message']="Selectionnez un Agent svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Pointage');
             exit();
            }

            
            if($nbreh ==''){
                $_SESSION['message']="Saisir le nombre de jour presté";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=Pointage');
                exit();
               }
            
         }


                 

            $reqAdd_CodePaie = $db->prepare('UPDATE bdd_paie.t_heures SET periode=:periode, datep=:dateav, matric=:matricule, nbreh=:nbreh, typeHeure=:heure, datecreat=:dateav, modifierpar=:modifierPar, datemodif=:datemodif WHERE id_pointage=:id_pointage');
            $reqAdd_CodePaie->bindvalue(':id_pointage',$id_pointage); 
            $reqAdd_CodePaie->bindvalue(':periode',$periode);
            //$reqAdd_CodePaie->bindvalue(':datep',$datep);
            $reqAdd_CodePaie->bindvalue(':matricule',$matriAg);
            //$reqAdd_CodePaie->bindvalue(':ph',$ph);
            $reqAdd_CodePaie->bindvalue(':nbreh',$nbreh);
           $reqAdd_CodePaie->bindvalue(':heure',$heure);
            $reqAdd_CodePaie->bindvalue(':creerPar',$creerPar);
            $reqAdd_CodePaie->bindvalue(':dateav',$dateCreation);
            $reqAdd_CodePaie->bindvalue(':modifierPar',$modifierPar);
            $reqAdd_CodePaie->bindvalue(':datemodif',$Datemodif);
           
           
            $reqAdd_CodePaie->execute();  

            $_SESSION['message']  = "Modification Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=voir_heures');
            exit();
            

        //}

        
    }