<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['updateAgent'])){
            $societe = validation_donnees($_POST['societe']);
            $grade = validation_donnees($_POST['grade']);
            $siege = validation_donnees($_POST['siege']);
            $matric = validation_donnees($_POST['matric']);
            $prenom = validation_donnees($_POST['prenom']);
            $dateEngag = validation_donnees($_POST['dateEngag']);
            $logemnt = validation_donnees($_POST['logemnt']);
            $indCarbu = validation_donnees($_POST['indCarbu']);
            $nomPhoto = '';
            $photoBinaire = '';
            $cheminPhoto = '';

            if($_FILES['photo_ag']['size'] < 10000000){
                $nomPhoto = $_FILES['photo_ag']['name'];
                $cheminPhoto = 'photoAgent/'.$nomPhoto;
                $imagePath = pathinfo($cheminPhoto,PATHINFO_EXTENSION);
                $valid  = array("jpg","jpeg","png");
                $chemin_complet = '/chemin/vers/mon/fichier.txt';
                if (file_exists($cheminPhoto)) {
                    
                } else {
                    if(in_array(strtolower($imagePath),$valid)){
                        move_uploaded_file($_FILES['photo_ag']['tmp_name'],$cheminPhoto);
                        $imageData = file_get_contents($cheminPhoto);
                        $photoBinaire = base64_encode($imageData); 
                        
                    }else{
                        $_SESSION['message'] = "Votre type de Fichier n'est correspond pas aux types prises en charge";
                        $_SESSION['typeMsg'] = "warning";
                        header('location:accueil.php?page=Signalitique');
                        exit;
                    }
                    
                }  
            }

            $dir = validation_donnees($_POST['dir']);
            $activ = validation_donnees($_POST['activ']);
            $pOrigi = validation_donnees($_POST['pOrigi']);;
            $nom = validation_donnees($_POST['nom']);
            $sexe = validation_donnees($_POST['sexe']);
            $nCompte = validation_donnees($_POST['nCompte']);
            $indVoiture = validation_donnees($_POST['indVoiture']);
            $nivEtud = validation_donnees($_POST['nivEtud']);

            $fonct = validation_donnees($_POST['fonct']);
            $syndi = validation_donnees($_POST['syndi']);
            $pNaiss = validation_donnees($_POST['pNaiss']);
            $postnom = validation_donnees($_POST['postnom']);
            $dateNaiss = validation_donnees($_POST['dateNaiss']);
            $nCNSS = validation_donnees($_POST['nCNSS']);
            $nbrEnf = validation_donnees($_POST['nbrEnf']);
            $etatCiv = validation_donnees($_POST['etatCiv']);
            $dateDebut = date('Y-m-d');
            $modifierPar = $_SESSION['id_utilisateur'];
            $statut = "act";
            if(empty($dateEngag) || empty($fonct) || empty($fonct) || empty($fonct)
            || empty($matric) || empty($siege) || empty($grade) || empty($societe)
            || empty($dir) || empty($indCarbu) || empty($logemnt) || empty($prenom)
            || empty($sexe) || empty($nom) || empty($pOrigi) || empty($activ)
            || empty($dateDebut) || empty($nivEtud) || empty($indVoiture) || empty($nCompte)
            || empty($dateNaiss)  || empty($nbrEnf) || empty($etatCiv)
            || empty($fonct) || empty($syndi) || empty($pNaiss) || empty($postnom) || empty($photo_ag))
            {
                try {
                    $db->beginTransaction();
                    $db->exec("UPDATE bdd_paie.t_agent SET matricule = '$matric', nom_ag = '$nom', postnom_ag = '$postnom',prenom_ag = '$prenom',
                            sexe_ag = '$sexe',etatCiv_ag = '$etatCiv',NumCNSS_ag = '$nCNSS',ind_logement_ag = '$logemnt',nbreEnfant_ag = '$nbrEnf',
                            dateEngagemnt_ag = '$dateEngag',dateNaiss_ag = '$dateNaiss',ProvOrig = '$pOrigi',
                            indiceCarburant = '$indCarbu',NivEtude_ag = '$nivEtud',modifierPar = '$modifierPar',indiceVoiture = '$indVoiture',NumCompt = '$nCompte',provNaiss = '$pOrigi',
                            provOrig = '$pNaiss',activiter_ID = '$activ', photo = '$nomPhoto', photo_byte = '$photoBinaire' WHERE matricule = '$lastMatric' ");
                        
                    $db->exec("UPDATE bdd_paie.detail_agent_activ SET code_activ_ID = '$activ', agent_ID = '$matric',modifierPar = '$modifierPar'
                            WHERE agent_ID = '$lastMatric' AND statut_ID = '$statut' ");
                        
                    $db->exec("UPDATE bdd_paie.detail_agent_direction SET agent_ID = '$matric', direction_ID = '$dir',modifierPar = '$modifierPar'
                            WHERE agent_ID = '$lastMatric' AND statut_ID = '$statut' ");
                        
                    $db->exec("UPDATE bdd_paie.detail_agent_grade SET agent_ID = '$matric', grade_ID = '$grade', modifierPar = '$modifierPar'
                            WHERE agent_ID = '$lastMatric' AND statut_ID = '$statut' ");
                    /*    
                    $db->exec("INSERT INTO bdd_paie.detail_agent_province (agent_ID,province_ID,creerPar,statut_ID) 
                        VALUES ('$matric', '$pOrigi', '$creerPar','$statut')");
    
                    $db->exec("INSERT INTO bdd_paie.detail_agent_province_naissance (agent_ID,provinceNaiss_ID,creerPar,statut_ID) 
                        VALUES ('$matric', '$pNaiss', '$creerPar','$statut')");
                    */ 
                     
                    $db->exec("UPDATE bdd_paie.detail_agent_siege SET agent_ID = '$matric', siege_ID = '$siege',modifierPar = '$modifierPar' 
                            WHERE agent_ID = '$lastMatric' AND statut_ID = '$statut' ");
    
                    $db->exec("UPDATE bdd_paie.detail_agent_syndicat SET agent_ID = '$matric', syndicat_ID = '$syndi', modifierPar = '$modifierPar' 
                            WHERE agent_ID = '$lastMatric' AND statut_ID = '$statut' ");
                    
                    $db->exec("UPDATE bdd_paie.detail_agent_societe SET agent_ID = '$matric', societe_ID = '$societe', modifierPar = '$modifierPar'
                            WHERE agent_ID = '$lastMatric' AND statut_ID = '$statut' "); 
                        
                    $db->exec("UPDATE bdd_paie.detail_agent_fonction SET agent_ID = '$matric', fonction_ID = '$fonct', modifierPar = '$modifierPar'
                            WHERE agent_ID = '$lastMatric' AND statut_ID = '$statut' "); 
                        
                    $db->commit();
                    $_SESSION['message']  = "Modification Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_Agent');
                    exit();
    
                  } catch (PDOException $e) {
                    $db->rollBack();
                    echo "Erreur: " . $e->getMessage();
                  }



            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Signalitique');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Signalitique');
        exit();
        
    }


