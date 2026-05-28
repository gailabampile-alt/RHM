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


        $reqVerificationPaie = $db->prepare('SELECT * FROM bdd_paie.t_paie WHERE periode= :periode AND type_paie=:type_paie');
       
        $reqVerificationPaie -> bindValue(':periode',$periode);
        $reqVerificationPaie -> bindValue(':type_paie',$type_paie);
        $reqVerificationPaie ->execute();

        if($reqVerificationPaie ->rowCount() > 1){
            $_SESSION['message']  = "Le calcule dèja effectuer pour la periode : $periode  !";
            $_SESSION['typeMsg']  = "danger";
            header('location:accueil.php?page=Calcul-Paie');
            exit();

        }else{

            //insert t_calcule_paie

            $reqAdd_Paie1 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_bareme ');
            $reqAdd_Paie1->execute(); 

            $reqAdd_Paie11 = $db->prepare("DELETE bdd_paie.t_calcule_paie FROM bdd_paie.t_calcule_paie 
            INNER JOIN bdd_paie.t_agent  ON t_calcule_paie.Matricule = t_agent.matricule 
            WHERE t_agent.activiter_ID = '01' AND t_agent.ind_logement_ag = '0' AND t_calcule_paie.codeEiPaie = '230' " );
            $reqAdd_Paie11->execute();  
            
            $reqAdd_Paie111 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_reb_fdom ');
            $reqAdd_Paie111->execute();  

            $reqAdd_Paie112 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_remb_dom');
            $reqAdd_Paie112->execute();  

            $reqAdd_Paie2 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_anal ');
            $reqAdd_Paie2->execute();  

            $reqAdd_Paie311 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_diplome');
            $reqAdd_Paie311->execute();  

            $reqAdd_Paie4 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_alloc_famille ');
            $reqAdd_Paie4->execute();  

            $reqAdd_Paie5 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_alloc_epouse');
            $reqAdd_Paie5->execute();  

            $reqAdd_Paie55 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_prime_special');
            $reqAdd_Paie55->execute();  

            $reqAdd_Paie6 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_heursupl where periode =:periode');
            $reqAdd_Paie6->bindvalue(':periode',$periode);
            $reqAdd_Paie6->execute();  

            $reqAdd_Paie7 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_avance_franc where periodeAv=:periode ');
            $reqAdd_Paie7->bindvalue(':periode',$periode);
            $reqAdd_Paie7->execute();  
            
            $reqAdd_Paie77 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer,periode) 
            SELECT Matricule, Nom, Postnom, Prenom_, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeElPaie, libelle_el_paie, montant_payer, NULL AS periodeAv  FROM bdd_paie.v_interim_franc  ');
            $reqAdd_Paie77->execute();  
            
            $reqAdd_Paie8 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_avance_us where periodeAv=:periode');
            $reqAdd_Paie8->bindvalue(':periode',$periode);
            $reqAdd_Paie8->execute();  

            $reqAdd_Paie88 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer,periode) 
           SELECT Matricule, Nom, Postnom, Prenom_, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeElPaie, libelle_el_paie, montant_payer, NULL AS periodeAv FROM bdd_paie.v_interim_us ');
            $reqAdd_Paie88->execute(); 

            $reqAdd_Paie81 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_fonction ');
            //$reqAdd_Paie81->bindvalue(':periode',$periode);
            $reqAdd_Paie81->execute();  

            $reqAdd_Paie82 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_fonction_usd ');
            //$reqAdd_Paie82->bindvalue(':periode',$periode);
            $reqAdd_Paie82->execute(); 

            $reqAdd_Paie9 = $db->prepare('UPDATE bdd_paie.t_calcule_paie SET t_calcule_paie.periode=:periode
            WHERE t_calcule_paie.periode is Null');
            $reqAdd_Paie9->bindvalue(':periode',$periode);
            $reqAdd_Paie9->execute();  

            $reqAdd_Paie99 = $db->prepare('UPDATE bdd_paie.t_calcule_paie SET t_calcule_paie.type_paie=:type_paie
            WHERE t_calcule_paie.type_paie is Null');
            $reqAdd_Paie99->bindvalue(':type_paie',$type_paie);
            $reqAdd_Paie99->execute(); 
/// update anale 0050
    //        $reqAdd_Paie = $db->prepare('UPDATE bdd_paie.t_anale JOIN v_ajout_anal ON t_anale.agent_ID = v_ajout_anal.Matricule SET t_anale.montant = t_anale.montant + v_ajout_anal.montant_payer
    //        WHERE t_anale.agent_ID=v_ajout_anal_fevrie.Matricule;');
       //      $reqAdd_Paie->bindvalue(':periode',$periode);
        //    $reqAdd_Paie->execute();  

       //     $reqAdd_Paie = $db->prepare('UPDATE bdd_paie.t_calcule_paie JOIN t_anale ON t_calcule_paie.Matricule =t_anale.agent_ID SET t_calcule_paie.montant_payer = t_anale.montant 
         //   WHERE t_calcule_paie.periode=:periode');
         //    $reqAdd_Paie->bindvalue(':periode',$periode);
           // $reqAdd_Paie->execute();  

// update sal 30
            $reqAdd_Paie10 = $db->prepare("UPDATE bdd_paie.t_calcule_paie JOIN bdd_paie.v_ajout_sal_brut01 ON v_ajout_sal_brut01.Matricule= t_calcule_paie.Matricule SET t_calcule_paie.montant_payer=v_ajout_sal_brut01.montant_payer  WHERE t_calcule_paie.codeEiPaie = '001' and t_calcule_paie.periode=:periode AND v_ajout_sal_brut01.periode=:periode");
            $reqAdd_Paie10->bindvalue(':periode',$periode);
            $reqAdd_Paie10->execute();  

            $reqAdd_Paie101 = $db->prepare("UPDATE bdd_paie.t_calcule_paie JOIN bdd_paie.v_ajout_transp ON v_ajout_transp.Matricule= t_calcule_paie.Matricule SET t_calcule_paie.montant_payer=v_ajout_transp.Montant  WHERE t_calcule_paie.codeEiPaie='231' and t_calcule_paie.periode=:periode AND v_ajout_transp.periode=:periode");
            $reqAdd_Paie101->bindvalue(':periode',$periode);
            $reqAdd_Paie101->execute();  

            $reqAdd_Paie1012 = $db->prepare("UPDATE bdd_paie.t_calcule_paie JOIN bdd_paie.detail_agent_fonction ON detail_agent_fonction.agent_ID= t_calcule_paie.Matricule JOIN bdd_paie.t_fonction ON t_fonction.codeFonct=detail_agent_fonction.fonction_ID JOIN bdd_paie.v_synd_transt SET t_calcule_paie.codeEiPaie='232', t_calcule_paie.libelle_el_paie='IND.DE DEPLACEMENT', 
            t_calcule_paie.montant_payer =v_synd_transt.montant_payer WHERE detail_agent_fonction.fonction_ID='2190P' AND t_calcule_paie.codeEiPaie='231' and t_calcule_paie.periode=:periode");
            $reqAdd_Paie1012->bindvalue(':periode',$periode);
            $reqAdd_Paie1012->execute();  

            

//  insert prime fidelité
            $reqAdd_Paie12 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_prime_fidel10j where periode=:periode');
             $reqAdd_Paie12->bindvalue(':periode',$periode);
            $reqAdd_Paie12->execute(); 

            $reqAdd_Paie13 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_prime_fidel15j where periode=:periode');
             $reqAdd_Paie13->bindvalue(':periode',$periode);
            $reqAdd_Paie13->execute(); 

            $reqAdd_Paie14 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_prime_fidel20j where periode=:periode');
             $reqAdd_Paie14->bindvalue(':periode',$periode);
            $reqAdd_Paie14->execute(); 

            $reqAdd_Paie15 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_prime_fidel25j where periode=:periode');
             $reqAdd_Paie15->bindvalue(':periode',$periode);
            $reqAdd_Paie15->execute(); 

            $reqAdd_Paie105 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_prime_fidel30j where periode=:periode');
             $reqAdd_Paie105->bindvalue(':periode',$periode);
            $reqAdd_Paie105->execute(); 

            $reqAdd_Paie16 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_prime_fidel35j where periode=:periode');
             $reqAdd_Paie16->bindvalue(':periode',$periode);
            $reqAdd_Paie16->execute(); 

            $reqAdd_Paie17 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_prime_fidel40j where periode=:periode');
             $reqAdd_Paie17->bindvalue(':periode',$periode);
            $reqAdd_Paie17->execute(); 
// update pour pointage
            $reqAdd_Paie10122 = $db->prepare("UPDATE bdd_paie.t_calcule_paie c INNER JOIN bdd_paie.t_pointage p ON p.matric = c.Matricule SET  c.montant_payer = (c.montant_payer / 26) * p.nbrejrs WHERE p.periode = :periode AND c.codeEiPaie IN (001, 232, 231, 279, 250, 276, 252)");
            $reqAdd_Paie10122->bindvalue(':periode',$periode);
            $reqAdd_Paie10122->execute();  

            /// insert total brut

            $reqAdd_Paie18 = $db->prepare('INSERT INTO bdd_paie.t_calcule_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_total_brut where periode=:periode');
             $reqAdd_Paie18->bindvalue(':periode',$periode);
             $reqAdd_Paie18->execute(); 

       

            // insert retenue
// insert cnss
            $reqAdd_Paie19 = $db->prepare('INSERT INTO bdd_paie.t_retenue (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_ret_pens where periode=:periode');
             $reqAdd_Paie19->bindvalue(':periode',$periode);
            $reqAdd_Paie19->execute(); 

            
// insert ipr
            $reqAdd_Paie20 = $db->prepare('INSERT INTO bdd_paie.t_retenue (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select  DISTINCT * from bdd_paie.v_ipr_all where periode=:periode');
             $reqAdd_Paie20->bindvalue(':periode',$periode);
            $reqAdd_Paie20->execute(); 

            
  //  insert   retenue syndic       
            $reqAdd_Paie21 = $db->prepare('INSERT INTO bdd_paie.t_retenue (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_retsydic_all where periode=:periode');
             $reqAdd_Paie21->bindvalue(':periode',$periode);
            $reqAdd_Paie21->execute(); 

// insert retenue Financement
             $reqAdd_Paie211 = $db->prepare('INSERT INTO bdd_paie.t_retenue (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
             select * from bdd_paie.v_ret_financement where periode=:periode');
             $reqAdd_Paie211->bindvalue(':periode',$periode);
            $reqAdd_Paie211->execute(); 

            $reqAdd_Paie211 = $db->prepare('INSERT INTO bdd_paie.t_retenue (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
             select * from bdd_paie.v_ret_int_financement where periode=:periode');
             $reqAdd_Paie211->bindvalue(':periode',$periode);
            $reqAdd_Paie211->execute(); 

// insert totat retenue
            $reqAdd_Paie22 = $db->prepare('INSERT INTO bdd_paie.t_retenue (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_total_retenue where periode=:periode');
             $reqAdd_Paie22->bindvalue(':periode',$periode);
            $reqAdd_Paie22->execute(); 
/// insert t_imposa
// insert onem
            $reqAdd_Paie23 = $db->prepare('INSERT INTO bdd_paie.t_imposa (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_onem where periode=:periode');
             $reqAdd_Paie23->bindvalue(':periode',$periode);
            $reqAdd_Paie23->execute(); 
//inpp
            $reqAdd_Paie24 = $db->prepare('INSERT INTO bdd_paie.t_imposa (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_inpp_all where periode=:periode');
             $reqAdd_Paie24->bindvalue(':periode',$periode);
            $reqAdd_Paie24->execute(); 
/// quot patronal
            $reqAdd_Paie25 = $db->prepare('INSERT INTO bdd_paie.t_imposa (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_quote_part where periode=:periode');
             $reqAdd_Paie25->bindvalue(':periode',$periode);
            $reqAdd_Paie25->execute(); 
//total brut impos
            $reqAdd_Paie251 = $db->prepare('INSERT INTO bdd_paie.t_imposa (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_total_brut_imp where periode=:periode');
             $reqAdd_Paie251->bindvalue(':periode',$periode);
            $reqAdd_Paie251->execute(); 
// total net impos
            $reqAdd_Paie26 = $db->prepare('INSERT INTO bdd_paie.t_imposa (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_brut_net_impos2 where periode=:periode');
             $reqAdd_Paie26->bindvalue(':periode',$periode);
            $reqAdd_Paie26->execute(); 

            $reqAdd_Paie27 = $db->prepare('INSERT INTO bdd_paie.t_imposa (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select * from bdd_paie.v_brut_net_impos where periode=:periode');
             $reqAdd_Paie27->bindvalue(':periode',$periode);
            $reqAdd_Paie27->execute(); 
/// insert t_paie
            $reqAdd_Paie28 = $db->prepare('INSERT INTO bdd_paie.t_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode  from bdd_paie.t_calcule_paie where periode=:periode');
            $reqAdd_Paie28->bindvalue(':periode',$periode);
            $reqAdd_Paie28->execute(); 

            $reqAdd_Paie29 = $db->prepare('INSERT INTO bdd_paie.t_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie,montant_a_retenir , periode) 
            select Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie,montant_payer , periode  from bdd_paie.t_retenue where periode=:periode ');
            $reqAdd_Paie29->bindvalue(':periode',$periode);
            $reqAdd_Paie29->execute(); 

            $reqAdd_Paie30 = $db->prepare('INSERT INTO bdd_paie.t_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie,montant_imposa, periode) 
            select Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode  from bdd_paie.t_imposa where periode=:periode ');
            $reqAdd_Paie30->bindvalue(':periode',$periode);
            $reqAdd_Paie30->execute(); 

            $reqAdd_Paie31 = $db->prepare('INSERT INTO bdd_paie.t_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select Matricule, Nom, Postnom, Prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeElPaie, libelle_el_paie, Montant_net_payer, periode FROM bdd_paie.v_net_a_payer where periode=:periode');
            $reqAdd_Paie31->bindvalue(':periode',$periode);
            $reqAdd_Paie31->execute(); 

            /*$reqAdd_Paie31 = $db->prepare('INSERT INTO bdd_paie.t_paie (Matricule, Nom, PostNom, prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeEiPaie, libelle_el_paie, montant_payer, periode) 
            select Matricule, Nom, Postnom, Prenom, N_inss, sexe, etat_civil, sit_famille, grade, EquiG, codeElPaie, libelle_el_paie, Montant_net_payer, periode FROM bdd_paie.v_net_a_payer where periode=:periode');
            $reqAdd_Paie31->bindvalue(':periode',$periode);
            $reqAdd_Paie31->execute(); */


  // update t_paie    
  
  
            $reqAdd_Paie32 = $db->prepare('UPDATE bdd_paie.t_paie JOIN bdd_paie.t_agent ON t_agent.matricule = t_paie.Matricule JOIN bdd_paie.detail_agent_siege ON detail_agent_siege.agent_ID=t_paie.Matricule JOIN bdd_paie.t_siege ON t_siege.code_sieg=detail_agent_siege.siege_ID 
            SET codesiege=detail_agent_siege.siege_ID, libelle_siege=t_siege.libelle_sieg,t_paie.numCompt=t_agent.NumCompt where periode=:periode');
            $reqAdd_Paie32->bindvalue(':periode',$periode);
            $reqAdd_Paie32->execute();


            $reqAdd_Paie34 = $db->prepare("UPDATE bdd_paie.t_paie SET codeEiPaie ='232', libelle_el_paie ='IND. DE DEPLACEMENT' WHERE grade >=16 AND codeEiPaie ='231'");
           // $reqAdd_Paie->bindvalue(':periode',$periode);
            $reqAdd_Paie34->execute();

            $reqAdd_Paie901 = $db->prepare('UPDATE bdd_paie.t_paie SET t_paie.type_paie=:type_paie
            WHERE t_paie.type_paie is Null');
            $reqAdd_Paie901->bindvalue(':type_paie',$type_paie);
            $reqAdd_Paie901->execute(); 

            // Suppression dans t_calcul_paie
        $reqAnnuler_Paie1 = $db->prepare("DELETE FROM bdd_paie.t_calcule_paie ");
        //$reqAnnuler_Paie1->bindValue(':periode', $periode);
        $reqAnnuler_Paie1->execute();

        //supression dans t_retenue

       $reqAnnuler_Paie2 = $db->prepare("DELETE FROM bdd_paie.t_retenue ");
       //$reqAnnuler_Paie2->bindValue(':periode', $periode);
       $reqAnnuler_Paie2->execute();

        //supression dans t_imposa

       $reqAnnuler_Paie3 = $db->prepare("DELETE FROM bdd_paie.t_imposa ");
       //$reqAnnuler_Paie3->bindValue(':periode', $periode);
       $reqAnnuler_Paie3->execute();
        
        

            $_SESSION['message']  = "Calcule Effectuer pour la periode de $periode!";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Calcul-Paie');
            exit();
            

        }

        
    }