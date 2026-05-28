<?php
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');
    
set_time_limit(360);
    if (isset($_POST['calcule'])){
       // $periode=$_POST['periode'];
        //$dateAv=$_POST['DateAv'];
        $date_paie = validation_donnees($_POST['date_paie']);
        $type_paie = validation_donnees($_POST['type_paie']);
        $periode = normalizePeriode($_POST['periode']);
       
       

    if(isset($date_paie)&& isset($type_paie)&& isset($periode)){
            if($date_paie ==''){
             $_SESSION['message']="Saisie une date  svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Calcul-Paie');
             exit();
            }

            if($type_paie==''){
             $_SESSION['message']="Selectionnez une Paie svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Calcul-Paie');
             exit();
            }
            if($periode ==''){
             $_SESSION['message']="Saisie la periode  svp";
             $_SESSION['typeMsg']="danger";
             header('location:accueil.php?page=Calcul-Paie');
             exit();
            }
            
         }


        $reqVerificationPaie = $db->prepare('SELECT * FROM bdd_paie.t_paie WHERE periode= :periode and type_paie=:type_paie');
       
        $reqVerificationPaie -> bindValue(':periode',$periode);
        $reqVerificationPaie -> bindValue(':type_paie',$type_paie);
        $reqVerificationPaie ->execute();

        if($reqVerificationPaie ->rowCount() == 1){
            $_SESSION['message']  = "Le calcule rente dèja effectuer pour la periode : $periode  !";
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=Calcul-Paie');
            exit();

        }else{

            //insert t_calcule_paie

            $reqAdd_Paie1 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_bareme_ret ');
            $reqAdd_Paie1->execute(); 
            
             $reqAdd_Paie1 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_anal_ret ');
            $reqAdd_Paie1->execute(); 

            $reqAdd_Paie9 = $db->prepare('UPDATE bdd_paie.t_calcule_paie SET t_calcule_paie.periode=:periode
            WHERE t_calcule_paie.periode is Null');
            $reqAdd_Paie9->bindvalue(':periode',$periode);
            $reqAdd_Paie9->execute();  
           
            
           
/// insert t_paie
            $reqAdd_Paie = $db->prepare('INSERT INTO bdd_paie.t_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode  from bdd_paie.t_calcule_paie where periode=:periode');
            $reqAdd_Paie->bindvalue(':periode',$periode);
            $reqAdd_Paie->execute();  

            $reqAdd_Paie88 = $db->prepare('INSERT INTO bdd_paie.t_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select Matricule, Nom, Postnom, Prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeElPaie, libelle_el_paie, Montant_net_payer, periode FROM bdd_paie.v_net_a_payer_r where periode=:periode');
            $reqAdd_Paie88->bindvalue(':periode',$periode);
            $reqAdd_Paie88->execute(); 


  // update t_paie    
  
  
            $reqAdd_Paie32 = $db->prepare('UPDATE bdd_paie.t_paie JOIN bdd_paie.t_agent ON t_agent.matricule = t_paie.Matricule JOIN bdd_paie.detail_agent_siege ON detail_agent_siege.agent_ID=t_paie.Matricule JOIN bdd_paie.t_siege ON t_siege.code_sieg=detail_agent_siege.siege_ID 
            SET codesiege=detail_agent_siege.siege_ID, libelle_siege=t_siege.libelle_sieg,t_paie.numCompt=t_agent.NumCompt where periode=:periode');
            $reqAdd_Paie32->bindvalue(':periode',$periode);
            $reqAdd_Paie32->execute();

            $reqAdd_Paie901 = $db->prepare('UPDATE bdd_paie.t_paie SET t_paie.type_paie=:type_paie
            WHERE t_paie.type_paie is Null');
            $reqAdd_Paie901->bindvalue(':type_paie',$type_paie);
            $reqAdd_Paie901->execute(); 

            // Suppression dans t_calcul_paie
       $reqAnnuler_Paie1 = $db->prepare("DELETE FROM bdd_paie.t_calcule_paie ");
       // $reqAnnuler_Paie1->bindValue(':periode', $periode);
       $reqAnnuler_Paie1->execute();

        //supression dans t_retenue

       $reqAnnuler_Paie2 = $db->prepare("DELETE FROM bdd_paie.t_retenue ");
      //  $reqAnnuler_Paie2->bindValue(':periode', $periode);
       $reqAnnuler_Paie2->execute();

        //supression dans t_imposa

       $reqAnnuler_Paie3 = $db->prepare("DELETE FROM bdd_paie.t_imposa ");
     //   $reqAnnuler_Paie3->bindValue(':periode', $periode);
       $reqAnnuler_Paie3->execute();
        
     $_SESSION['message']  = "Calcule Rente Effectuer pour la periode de $periode!";
     $_SESSION['typeMsg']  = "info";
    header('location:accueil.php?page=Calcul-Paie');
    exit();
            

        }

        
    }