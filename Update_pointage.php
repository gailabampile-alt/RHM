<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');
echo 1;
    if (isset($_POST['Modif'])){ echo 2;
        $periode=$_POST['periode'];
        //$dateAv=$_POST['DateAv'];
        $id_pointage=$_POST['id_pointage'];
        $periode = validation_donnees($_POST['periode']);
        $datep=validation_donnees($_POST['datep']);
        $matriAg = validation_donnees($_POST['matriAg']);
        
        $nbrejrs=$_POST['nbrejrs'];
        //$creerPar = $_POST['creerpar'];
        $dateCreation = $_POST['dateAvc'];
        $modifierPar = $_SESSION['id_utilisateur'];  
        $Datemodif = date('Y-m-d');
       // $heure = $_POST['heure'];
echo 2;
        if(isset($periode)&& isset($matriAg)&& isset($datep)&& isset($nbrejrs)){
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

            if($datep ==''){
             $_SESSION['message']="Selectionnez une date ";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Pointage');
             exit();
            }
            
            if($nbrejrs ==''){
                $_SESSION['message']="Saisir le nombre de jour presté";
                $_SESSION['typeMsg']="danger";
                header('location:accueil.php?page=Pointage');
                exit();
               }
            
         }


                 

            $reqAdd_CodePaie = $db->prepare('UPDATE bdd_paie.t_pointage SET periode=:periode, datep=:datep, matric=:matricule, nbrejrs=:nbrejrs, modifierpar=:modifierPar, datemodif=:datemodif WHERE id_pointage=:id_pointage');
            $reqAdd_CodePaie->bindvalue(':id_pointage',$id_pointage); 
            $reqAdd_CodePaie->bindvalue(':periode',$periode);
            $reqAdd_CodePaie->bindvalue(':datep',$datep);
            $reqAdd_CodePaie->bindvalue(':matricule',$matriAg);
            //$reqAdd_CodePaie->bindvalue(':ph',$ph);
            $reqAdd_CodePaie->bindvalue(':nbrejrs',$nbrejrs);
           // $reqAdd_CodePaie->bindvalue(':heure',$heure);
           // $reqAdd_CodePaie->bindvalue(':creerPar',$creerPar);
           // $reqAdd_CodePaie->bindvalue(':dateav',$dateCreation);
            $reqAdd_CodePaie->bindvalue(':modifierPar',$modifierPar);
            $reqAdd_CodePaie->bindvalue(':datemodif',$Datemodif);
           
           
            $reqAdd_CodePaie->execute();  

            $_SESSION['message']  = "Modification Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=voir_pointage');
            exit();
            

        //}

        
    }