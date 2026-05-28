<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['creerAgent'])){
            $societe = validation_donnees($_POST['societe']);
            $grade = validation_donnees($_POST['grade']);
            $siege = validation_donnees($_POST['siege']);
            $matric = validation_donnees($_POST['matric']);
            $prenom = validation_donnees($_POST['prenom']);
            $dateEngag = validation_donnees($_POST['dateEngag']);
            $logemnt = validation_donnees($_POST['logemnt']);
            $indCarbu = validation_donnees($_POST['indCarbu']);

            $phone = validation_donnees($_POST['phone']);
            $adresse = validation_donnees($_POST['adress']);

            $nomPhoto = '';
            $photoBinaire = '';
            $cheminPhoto = '';

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
            $alloc_famlily = "";
            if($nbrEnf == 0){
                $alloc_famlily = "N";
            }else{
                $alloc_famlily = "E";
            }
            $etatCiv = validation_donnees($_POST['etatCiv']);
            $dateDebut = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";


            $reqMatricExiste = $db->prepare("SELECT matricule,NumCompt,NumCNSS_ag FROM bdd_paie.t_agent WHERE matricule = :matricule");
            $reqMatricExiste->bindValue(':matricule',$matric);
            $reqMatricExiste->execute();
            while ($reqMatricExiste = $reqMatricExiste->fetch()) {
                $matr = $reqMatricExiste['matricule'];
                $compte = $reqMatricExiste['NumCompt'];
                $cnss = $reqMatricExiste['NumCNSS_ag'];
                if($matr == $matric ){
                    $_SESSION['message']  = "Le Matricule : ".$matric." Existe Déjà !!!";
                    $_SESSION['typeMsg']  = "warning";
                    header('location:accueil.php?page=Signalitique');
                    exit();
                }elseif($compte == $nCompte){
                    $_SESSION['message']  = "Le numéro de compte : ".$nCompte." Existe Déjà !!!";
                    $_SESSION['typeMsg']  = "warning";
                    header('location:accueil.php?page=Signalitique');
                    exit();
                }elseif ($cnss == $nCNSS) {
                    $_SESSION['message']  = "Le numéro CNSS : ".$nCNSS." Existe Déjà !!!";
                    $_SESSION['typeMsg']  = "warning";
                    header('location:accueil.php?page=Signalitique');
                    exit();   
                }
            }
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Vérifie si le fichier a été téléchargé sans erreur
                if (isset($_FILES['photo_ag']) && $_FILES['photo_ag']['error'] == 0) {
                    // Vous pouvez ajouter ici le code pour traiter le fichier téléchargé
                    if($_FILES['photo_ag']['size'] < 10000000){
                        $nomPhoto = $_FILES['photo_ag']['name'];
                        $cheminPhoto = 'photoAgent/'.$nomPhoto;
                        $imagePath = pathinfo($cheminPhoto,PATHINFO_EXTENSION);
                        $valid  = array("jpg","jpeg","png");
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
                } else {
                    //echo "Aucun fichier n'a été téléchargé ou une erreur s'est produite.";
                    $imageData = "";
                    $photoBinaire = "";
                }
            }
            

                
            if(empty($dateEngag) || empty($fonct) || empty($fonct) || empty($fonct)
            || empty($matric) || empty($siege) || empty($grade) || empty($societe)
            || empty($dir) || empty($indCarbu) || empty($logemnt) || empty($prenom) || empty($phone)
            || empty($sexe) || empty($nom) || empty($pOrigi) || empty($activ) || empty($adresse)
            || empty($dateDebut) || empty($nivEtud) || empty($indVoiture) || empty($nCompte)
            || empty($dateNaiss)  || empty($nbrEnf) || empty($etatCiv)
            || empty($fonct) || empty($syndi) || empty($pNaiss) || empty($postnom) || empty($photo_ag))
            {
                try {
                    $db->beginTransaction();
                    $db->exec("INSERT INTO bdd_paie.t_agent (matricule, nom_ag, postnom_ag,prenom_ag,
                            sexe_ag,etatCiv_ag,NumCNSS_ag,ind_logement_ag,nbreEnfant_ag,dateEngagemnt_ag,dateNaiss_ag,
                            indiceCarburant,NivEtude_ag,creerPar,indiceVoiture,NumCompt,provNaiss,provOrig,activiter_ID,alloc_fam_ID,photo,photo_byte,phone,adresse) 
                        VALUES ('$matric', '$nom', '$postnom','$prenom','$sexe','$etatCiv','$nCNSS',
                                '$logemnt','$nbrEnf','$dateEngag','$dateNaiss','$indCarbu','$nivEtud','$creerPar',
                                '$indVoiture','$nCompte','$pNaiss','$pOrigi','$activ','$alloc_famlily','$nomPhoto','$photoBinaire','$phone','$adresse')");
                        
                    $db->exec("INSERT INTO bdd_paie.detail_agent_activ (code_activ_ID, agent_ID, dateDebut,creerPar,statut_ID) 
                        VALUES ('$activ', '$matric','$dateDebut','$creerPar','$statut')");
                        
                    $db->exec("INSERT INTO bdd_paie.detail_agent_direction (agent_ID, direction_ID, dateDebut,affecterPar,statut_ID) 
                        VALUES ('$matric', '$dir', '$dateDebut','$creerPar','$statut')");
                        
                    $db->exec("INSERT INTO bdd_paie.detail_agent_grade (agent_ID, grade_ID, creerPar,dateDebut,statut_ID) 
                        VALUES ('$matric', '$grade', '$creerPar','$dateDebut','$statut')");
                    /*    
                    $db->exec("INSERT INTO bdd_paie.detail_agent_province (agent_ID,province_ID,creerPar,statut_ID) 
                        VALUES ('$matric', '$pOrigi', '$creerPar','$statut')");
    
                    $db->exec("INSERT INTO bdd_paie.detail_agent_province_naissance (agent_ID,provinceNaiss_ID,creerPar,statut_ID) 
                        VALUES ('$matric', '$pNaiss', '$creerPar','$statut')");
                    */    
                    $db->exec("INSERT INTO bdd_paie.detail_agent_siege (agent_ID, siege_ID,dateDebut, creerPar,statut_ID) 
                        VALUES ('$matric', '$siege', '$dateDebut','$creerPar','$statut')");
    
                    $db->exec("INSERT INTO bdd_paie.detail_agent_syndicat (agent_ID, syndicat_ID,dateDebut, creerPar,statut_ID) 
                        VALUES ('$matric', '$syndi', '$dateDebut','$creerPar','$statut')");
                    
                    $db->exec("INSERT INTO bdd_paie.detail_agent_societe (agent_ID, societe_ID,dateDebut, creerPar,statut_ID) 
                        VALUES ('$matric', '$societe', '$dateDebut','$creerPar','$statut')"); 
    
                    $db->exec("INSERT INTO bdd_paie.detail_agent_fonction (agent_ID, fonction_ID,dateDebut, creerPar,statut_ID) 
                    VALUES ('$matric', '$fonct', '$dateDebut','$creerPar','$statut')"); 
    
                    $db->commit();
                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Signalitique');
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


