<?php
    session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');

    if(isset($_POST['Pointage'])){   

        $periode = validation_donnees($_POST['periode']);
        $datep=validation_donnees($_POST['datep']);
        $matriAg = validation_donnees($_POST['matriAg']);
        $nbrejrs=$_POST['nbrejrs'];
        $creerPar = $_SESSION['id_utilisateur'];
        $dateCreation = $_POST['dateAvc'];
        $modifierPar = $_SESSION['id_utilisateur'];  
        $Datemodif = $_POST['DateModifcodep'];

        $reqVerificationCodePaie = $db->prepare('SELECT * FROM bdd_paie.t_pointage WHERE periode= :periode ');
        $reqVerificationCodePaie -> bindValue(':periode',$periode);
      //  $reqVerificationCodePaie -> bindValue(':matricule',$matriAg);
       // $reqVerificationCodePaie -> bindValue(':datep',$datep);
        $reqVerificationCodePaie ->execute();

        if($reqVerificationCodePaie ->rowCount() == 1){
            $_SESSION['message']  = "Le Matricule : $matriAg a ete déjà pointé  pour la date du : $datep  !";
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=Pointage');
            exit();

        }else{

            $reqAdd_CodePaie1 = $db->prepare('INSERT INTO bdd_paie.t_pointage (matric) SELECT matricule FROM bdd_paie.t_agent');
            $reqAdd_CodePaie1->execute();  

            $agents = $db->query('SELECT * FROM bdd_paie.t_agent inner join  bdd_paie.detail_agent_fonction on t_agent.matricule=detail_agent_fonction.agent_ID INNER JOIN  bdd_paie.t_fonction on  t_fonction.codeFonct=detail_agent_fonction.fonction_ID WHERE fonction_ID="0050"');
            $agents->execute();  
            $nbrejr="30";
            while ($agent = $agents->fetch())
            { 
              
                $reqAdd_CodePaie = $db->prepare('UPDATE bdd_paie.t_pointage SET periode=:periode, datep=:datep, nbrejrs=:nbrejrs,
                creerpar=:creerPar, datecreat=:dateav, modifierpar=:modifierPar, datemodif=:datemodif where matric='.$agent['matricule']);

                $reqAdd_CodePaie->bindvalue(':periode',$periode);
                $reqAdd_CodePaie->bindvalue(':datep',$datep);
                $reqAdd_CodePaie->bindvalue(':nbrejrs',$nbrejr);
                $reqAdd_CodePaie->bindvalue(':creerPar',$creerPar);
                $reqAdd_CodePaie->bindvalue(':dateav',$dateCreation);
                $reqAdd_CodePaie->bindvalue(':modifierPar',$modifierPar);
                $reqAdd_CodePaie->bindvalue(':datemodif',$Datemodif);

                $reqAdd_CodePaie->execute();  

            }

            
           
                $reqAdd_CodePaie = $db->prepare('UPDATE bdd_paie.t_pointage SET periode=:periode, datep=:datep, nbrejrs=:nbrejrs,
                creerpar=:creerPar, datecreat=:dateav, modifierpar=:modifierPar, datemodif=:datemodif where nbrejrs is null');

                $reqAdd_CodePaie->bindvalue(':periode',$periode);
                $reqAdd_CodePaie->bindvalue(':datep',$datep);
                $reqAdd_CodePaie->bindvalue(':nbrejrs',$nbrejrs);
                $reqAdd_CodePaie->bindvalue(':creerPar',$creerPar);
                $reqAdd_CodePaie->bindvalue(':dateav',$dateCreation);
                $reqAdd_CodePaie->bindvalue(':modifierPar',$modifierPar);
                $reqAdd_CodePaie->bindvalue(':datemodif',$Datemodif);

                $reqAdd_CodePaie->execute();  

            
            

            $_SESSION['message']  = "Enregistrement Effectuer !"; 
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Pointage');
            exit();
        }
    }
