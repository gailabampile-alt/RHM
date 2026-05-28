<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_GET['code_desac_stg'])){
            $reqFinStage = $db->prepare ("UPDATE bdd_paie.t_stagiare SET statut_ID = :statut_ID,
                dateFin_stg = :dateFin_stg,modifierPar = :modifierPar
                WHERE id_stg = :id_stg");
            $reqFinStage->bindValue(':statut_ID','desac');
            $reqFinStage->bindValue(':dateFin_stg',date('Y-m-d'));
            $reqFinStage->bindValue(':modifierPar',$_SESSION['id_utilisateur']);
            $reqFinStage->bindValue(':id_stg',$_GET['code_desac_stg']);
            $reqFinStage->execute();

            $_SESSION['message']  = "Suspension du Stage Effectuer !";
            $_SESSION['typeMsg']  = "info";
            header('location:accueil.php?page=Voir_Stagiaire');
            exit();
        }

        if(isset($_POST['ModifStg'])){ 
            $nom = validation_donnees($_POST['nom_stg']);
            $postnom = validation_donnees($_POST['postnom_stg']);
            $prenom = validation_donnees($_POST['prenom_stg']);
            $sexe = validation_donnees($_POST['sexe_stg']);
            $etatCiv = validation_donnees($_POST['etatCiv_stg']);
            $nivEtud = validation_donnees($_POST['nivEtude_stg']);
            $siege = validation_donnees($_POST['siege_stg']);
            $dir = validation_donnees($_POST['dir_stg']);
            $pOrigi = validation_donnees($_POST['pOrigi_stg']);
            $pNaiss = validation_donnees($_POST['pNaiss_stg']);
            $dateNaiss = validation_donnees($_POST['dateNaiss_stg']);
            $dateDebut = validation_donnees($_POST['dateDebut_stg']);
            $dateFin = validation_donnees($_POST['dateFin_stg']);
            $nomPhoto = '';
            $anciennePhoto = $_POST['ancienne_photo'];
            $photoBinaire = '';
            $cheminPhoto = '';
            $cheminDoc_stg;
            $doc_stg_Data = '';
            $doc_stg_Binaire = ''; 
            $nomDoc_stg = "";
            $phone = validation_donnees($_POST['phone_stg']);
            $adresse = validation_donnees($_POST['adresse_stg']);
            $histo = validation_donnees($_POST['histo_stg']);
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Vérifie si le fichier a été téléchargé sans erreur
                if (isset($_FILES['photo_stg']) && $_FILES['photo_stg']['error'] == 0) {
                    // Vous pouvez ajouter ici le code pour traiter le fichier téléchargé
                    if($_FILES['photo_stg']['size'] < 10000000){
                        $nomPhoto = $_FILES['photo_stg']['name'];
                        $cheminPhoto = 'photoStagiaire/'.$nomPhoto;
                        $imagePath = pathinfo($cheminPhoto,PATHINFO_EXTENSION);
                        $valid  = array("jpg","jpeg","png");$y = "A";
                        if(in_array(strtolower($imagePath),$valid)){$z = "B";
                            move_uploaded_file($_FILES['photo_stg']['tmp_name'],$cheminPhoto);
                            $imageData = file_get_contents($cheminPhoto);
                            $photoBinaire = base64_encode($imageData); 
                            
                        }else{
                            $_SESSION['message'] = "Votre type de Fichier n'est correspond pas aux types prises en charge";
                            $_SESSION['typeMsg'] = "warning";
                            header('location:accueil.php?page=frm_stagiaire');
                            exit;
                        }
                    }
                } else {
                    //echo "Aucun fichier n'a été téléchargé ou une erreur s'est produite.";
                    $imageData = "";
                    $photoBinaire = "";
                } 
            }
            if (isset($_FILES['Fdoc']) && $_FILES['Fdoc']['error'] == 0) {
                if($_FILES['Fdoc']['size'] < 10000000){
                $nomDoc_stg = $_FILES['Fdoc']['name'];
                $cheminDoc_stg = 'DocumentsStagiaire/'.$nomDoc_stg;
                $doc_stg_Path = pathinfo($cheminDoc_stg,PATHINFO_EXTENSION);
                $valid  = array("jpg","jpeg","docx","pdf");
                if(in_array(strtolower($doc_stg_Path),$valid)){
                    move_uploaded_file($_FILES['Fdoc']['tmp_name'],$cheminDoc_stg);
                    $doc_stg_Data = file_get_contents($cheminDoc_stg);
                    $doc_stg_Binaire = base64_encode($doc_stg_Data); 
                    
                }else{
                    $_SESSION['message'] = "Votre type de Fichier n'est correspond pas aux types prises en charge";
                    $_SESSION['typeMsg'] = "warning";
                    header('location:accueil.php?page=frm_stagiaire');
                    exit;
                }
            }
        
            }
            

                
            if(empty($dateEngag) || empty($siege) || empty($dir) || empty($prenom) || empty($phone)
            || empty($sexe) || empty($nom) || empty($pOrigi) || empty($activ) || empty($adresse)
            || empty($dateDebut) || empty($nivEtud) || empty($nCompte)|| empty($dateNaiss) || empty($etatCiv)
            || empty($pNaiss) || empty($postnom) || empty($photo_ag))
            {
                try {
                    $db->beginTransaction();
                    $sql = "UPDATE  bdd_paie.t_stagiare SET nom_stg = :nom, postnom_stg = :postnom, prenom_stg = :prenom, sexe_stg = :sexe, 
                            etatCiv_stg = :etatCiv, siege_stg = :siege,dir_stg = :dir, pOrigi_stg = :pOrigi, pNaiss_stg = :pNaiss, 
                            dateNaiss = :dateNaiss, dateDebut_stage = :dateDebut,dateFin_stg = :dateFin_stg, photo_stg = :photo,
                            photo_byte_stg = :photoByte, statut_ID = :statut, creerPar = :creerPar, phone_stg = :phone, adresse_stg =  :adresse,
                             histo_stg = :histo,nivEtude_stg = :nivEtude_stg,document_byte = :document_byte,document = :document";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        ':nom' => $nom,
                        ':postnom' => $postnom,
                        ':prenom' => $prenom,
                        ':sexe' => $sexe,
                        ':etatCiv' => $etatCiv,
                        ':siege' => $siege,
                        ':dir' => $dir,
                        ':pOrigi' => $pOrigi,
                        ':pNaiss' => $pNaiss,
                        ':dateNaiss' => $dateNaiss,
                        ':dateDebut' => $dateDebut,
                        ':dateFin_stg' => $dateFin,
                        ':photo' => $nomPhoto,
                        ':photoByte' => $photoBinaire,
                        ':statut' => $statut,
                        ':creerPar' => $creerPar,
                        ':phone' => $phone,
                        ':adresse' => $adresse,
                        ':histo' => $histo,
                        ':nivEtude_stg' => $nivEtud,
                        'document_byte' => $doc_stg_Binaire,
                        'document' => $nomDoc_stg 
                    ]);

                        
                    /*    
                    $db->exec("INSERT INTO bdd_paie.detail_agent_province (agent_ID,province_ID,creerPar,statut_ID) 
                        VALUES ('$matric', '$pOrigi', '$creerPar','$statut')");
    
                    $db->exec("INSERT INTO bdd_paie.detail_agent_province_naissance (agent_ID,provinceNaiss_ID,creerPar,statut_ID) 
                        VALUES ('$matric', '$pNaiss', '$creerPar','$statut')");
                     
                    $db->exec("INSERT INTO bdd_paie.detail_agent_siege (agent_ID, siege_ID,dateDebut, creerPar,statut_ID) 
                        VALUES ('$matric', '$siege', '$dateDebut','$creerPar','$statut')");
                     */   

                    $db->commit();
                    $_SESSION['message']  = "Modification Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Voir_Stagiaire');
                    exit();
    
                  } catch (PDOException $e) {
                    $db->rollBack();
                    echo "Erreur: " . $e->getMessage();
                  }



            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=frm_stagiaire');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=frm_stagiaire');
        exit();
        
    }


