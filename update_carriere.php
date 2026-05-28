<?php
    session_start();
    require_once('sys_connexion.php');
    require_once('sys_fonction.php');

    $matricule = "";
    //$dateDebut = date('y-m-d');
    $nouv_siege = "";
    $nouv_fonction = "";
    $nouv_direction = "";
    $nouv_activite = "";
    $nouv_syndicat = "";
    $nouv_grade = "";
    $nouv_societe = "";
    $modifier_creerPar = $_SESSION['id_utilisateur'];
    $doc_ag_Data = "";
    $doc_ag_Binaire = "";
    if($_FILES['Fdoc']['size'] < 10000000){
        $nomDoc_ag = $_FILES['Fdoc']['name'];
        $cheminDoc_ag = 'Documents/'.$nomDoc_ag;
        $doc_ag_Path = pathinfo($cheminDoc_ag,PATHINFO_EXTENSION);
        $valid  = array("jpg","jpeg","docx","pdf");
        if(in_array(strtolower($doc_ag_Path),$valid)){
            move_uploaded_file($_FILES['Fdoc']['tmp_name'],$cheminDoc_ag);
            $doc_ag_Data = file_get_contents($cheminDoc_ag);
            $doc_ag_Binaire = base64_encode($doc_ag_Data); 
            
        }else{
            $_SESSION['message'] = "Votre type de Fichier n'est correspond pas aux types prises en charge";
            $_SESSION['typeMsg'] = "warning";
            header('location:accueil.php?page=Carriere');
            exit;
        }
    }
    
    if(isset($_POST['addNewSiege'])){
        $matricule = validation_donnees($_POST['matric']);
        $dateDebut = validation_donnees($_POST['dateDebut']);
        $nouv_siege = validation_donnees($_POST['nouv_siege']);
        $id = "";
        
        $reqGetSiegeID = $db->prepare("SELECT * FROM bdd_paie.detail_agent_siege 
        WHERE agent_ID = :agent_ID AND statut_ID = :statut_ID");

        $reqGetSiegeID->bindValue(':agent_ID',$matricule);
        $reqGetSiegeID->bindValue(':statut_ID','act');
        $reqGetSiegeID->execute();
        while ($resGetSiegeID = $reqGetSiegeID->fetch()) {
            $id = $resGetSiegeID['id_det_ag_siege'];
        }
        
        $reqUpdateSiege = $db->prepare("UPDATE bdd_paie.detail_agent_siege 
            SET dateFin = :dateFin, modifierPar = :modifierPar,statut_ID = :statut_ID
            WHERE id_det_ag_siege = :id_det_ag_siege");
        $reqUpdateSiege->bindValue(':id_det_ag_siege',$id);
        $reqUpdateSiege->bindValue(':dateFin',$dateDebut);
        $reqUpdateSiege->bindValue(':modifierPar',$modifier_creerPar);
        $reqUpdateSiege->bindValue(':statut_ID','desac');
        $reqUpdateSiege->execute();

        $reqAddSiege = $db->prepare("INSERT INTO  bdd_paie.detail_agent_siege
        (agent_ID,siege_ID,dateDebut,creerPar,statut_ID,document,document_byte) 
        VALUES (:agent_ID,:siege_ID,:dateDebut,:creerPar,:statut_ID,:document,:document_byte)");
        $reqAddSiege->bindValue(':agent_ID',$matricule);
        $reqAddSiege->bindValue(':siege_ID',$nouv_siege);
        $reqAddSiege->bindValue(':dateDebut',$dateDebut);
        $reqAddSiege->bindValue(':creerPar',$modifier_creerPar);
        $reqAddSiege->bindValue(':statut_ID','act');
        $reqAddSiege->bindValue(':document',$nomDoc_ag);
        $reqAddSiege->bindValue(':document_byte',$doc_ag_Binaire);
        $reqAddSiege->execute();

        $_SESSION['message'] = "Opération Effectuer !";
        $_SESSION['typeMsg'] = "info";
        header('location:accueil.php?page=Carriere');
        exit();

    }

    if(isset($_POST['addNewDirection'])){
        $matricule = validation_donnees($_POST['matric']);
        $dateDebut = validation_donnees($_POST['dateDebut']);
        $nouv_direction = validation_donnees($_POST['nouv_direction']);
        $id = "";
        
        $reqGetDirectionID = $db->prepare("SELECT * FROM bdd_paie.detail_agent_direction 
        WHERE agent_ID = :agent_ID AND statut_ID = :statut_ID");

        $reqGetDirectionID->bindValue(':agent_ID',$matricule);
        $reqGetDirectionID->bindValue(':statut_ID','act');
        $reqGetDirectionID->execute();
        while ($resGetDirectionID = $reqGetDirectionID->fetch()) {
            $id = $resGetDirectionID['id_det_ag_dir'];
        }
        
        $reqUpdateDirection = $db->prepare("UPDATE bdd_paie.detail_agent_direction 
            SET dateFin = :dateFin, modifierPar = :modifierPar, statut_ID = :statut_ID
            WHERE id_det_ag_dir  = :id_det_ag_dir");
        $reqUpdateDirection->bindValue(':id_det_ag_dir',$id);
        $reqUpdateDirection->bindValue(':dateFin',$dateDebut);
        $reqUpdateDirection->bindValue(':modifierPar',$modifier_creerPar);
        $reqUpdateDirection->bindValue(':statut_ID','desac');
        $reqUpdateDirection->execute();

        $reqAddDirection = $db->prepare("INSERT INTO  bdd_paie.detail_agent_direction
        (agent_ID,direction_ID,dateDebut,affecterPar,statut_ID,document,document_byte) VALUES (:agent_ID,:direction_ID,:dateDebut,:creerPar,:statut_ID,:document,:document_byte)");
        $reqAddDirection->bindValue(':agent_ID',$matricule);
        $reqAddDirection->bindValue(':direction_ID',$nouv_direction);
        $reqAddDirection->bindValue(':dateDebut',$dateDebut);
        $reqAddDirection->bindValue(':creerPar',$modifier_creerPar);
        $reqAddDirection->bindValue(':statut_ID','act');
        $reqAddDirection->bindValue(':document',$nomDoc_ag);
        $reqAddDirection->bindValue(':document_byte',$doc_ag_Binaire);
        $reqAddDirection->execute();

        $_SESSION['message'] = "Opération Effectuer !";
        $_SESSION['typeMsg'] = "info";
        header('location:accueil.php?page=Carriere');
        exit();




    }

    if(isset($_POST['addNewSociete'])){
        $matricule = validation_donnees($_POST['matric']);
        $dateDebut = validation_donnees($_POST['dateDebut']);
        $nouv_societe = validation_donnees($_POST['nouv_societe']);
        $id = "";
        
        $reqGetSocieteID = $db->prepare("SELECT * FROM bdd_paie.detail_agent_societe 
        WHERE agent_ID = :agent_ID AND statut_ID = :statut_ID");

        $reqGetSocieteID->bindValue(':agent_ID',$matricule);
        $reqGetSocieteID->bindValue(':statut_ID','act');
        $reqGetSocieteID->execute();
        while ($resGetSocieteID = $reqGetSocieteID->fetch()) {
            $id = $resGetSocieteID['id_det_ag_soc'];
        }
        
        $reqUpdateSociete = $db->prepare("UPDATE bdd_paie.detail_agent_societe 
            SET dateFin = :dateFin, modifierPar = :modifierPar, statut_ID = :statut_ID
            WHERE id_det_ag_soc = :id_det_ag_soc");
        $reqUpdateSociete->bindValue(':id_det_ag_soc',$id);
        $reqUpdateSociete->bindValue(':dateFin',$dateDebut);
        $reqUpdateSociete->bindValue(':modifierPar',$modifier_creerPar);
        $reqUpdateSociete->bindValue(':statut_ID','desac');
        $reqUpdateSociete->execute();

        $reqAddSociete = $db->prepare("INSERT INTO  bdd_paie.detail_agent_societe
        (agent_ID,societe_ID,dateDebut,creerPar,statut_ID,document,document_byte) VALUES (:agent_ID,:societe_ID,:dateDebut,:creerPar,:statut_ID,:document,:document_byte)");
        $reqAddSociete->bindValue(':agent_ID',$matricule);
        $reqAddSociete->bindValue(':societe_ID',$nouv_societe);
        $reqAddSociete->bindValue(':dateDebut',$dateDebut);
        $reqAddSociete->bindValue(':creerPar',$modifier_creerPar);
        $reqAddSociete->bindValue(':statut_ID','act');
        $reqAddSociete->bindValue(':document',$nomDoc_ag);
        $reqAddSociete->bindValue(':document_byte',$doc_ag_Binaire);
        $reqAddSociete->execute();

        $_SESSION['message'] = "Opération Effectuer !";
        $_SESSION['typeMsg'] = "info";
        header('location:accueil.php?page=Carriere');
        exit();




    }

    if(isset($_POST['addNewGrade'])){
        $matricule = validation_donnees($_POST['matric']);
        $dateDebut = validation_donnees($_POST['dateDebut']);
        $nouv_grade = validation_donnees($_POST['nouv_grade']);
        $id = "";
        
        $reqGetGradeID = $db->prepare("SELECT * FROM bdd_paie.detail_agent_grade 
        WHERE agent_ID = :agent_ID AND statut_ID = :statut_ID");

        $reqGetGradeID->bindValue(':agent_ID',$matricule);
        $reqGetGradeID->bindValue(':statut_ID','act');
        $reqGetGradeID->execute();
        while ($resGetGradeID = $reqGetGradeID->fetch()) {
            $id = $resGetGradeID['id_det_ag_gr'];
        }
        
        $reqUpdateGrade = $db->prepare("UPDATE bdd_paie.detail_agent_grade 
            SET dateFin = :dateFin, modifierPar = :modifierPar, statut_ID = :statut_ID
            WHERE id_det_ag_gr = :id_det_ag_gr");
        $reqUpdateGrade->bindValue(':id_det_ag_gr',$id);
        $reqUpdateGrade->bindValue(':dateFin',$dateDebut);
        $reqUpdateGrade->bindValue(':modifierPar',$modifier_creerPar);
        $reqUpdateGrade->bindValue(':statut_ID','desac');
        $reqUpdateGrade->execute();

        $reqAddGrade = $db->prepare("INSERT INTO  bdd_paie.detail_agent_grade
        (agent_ID,grade_ID,dateDebut,creerPar,statut_ID,document,document_byte) 
        VALUES (:agent_ID,:grade_ID,:dateDebut,:creerPar,:statut_ID,:document,:document_byte)");
        $reqAddGrade->bindValue(':agent_ID',$matricule);
        $reqAddGrade->bindValue(':grade_ID',$nouv_grade);
        $reqAddGrade->bindValue(':dateDebut',$dateDebut);
        $reqAddGrade->bindValue(':creerPar',$modifier_creerPar);
        $reqAddGrade->bindValue(':statut_ID','act');
        $reqAddGrade->bindValue(':document',$nomDoc_ag);
        $reqAddGrade->bindValue(':document_byte',$doc_ag_Binaire);
        $reqAddGrade->execute();

        $_SESSION['message'] = "Opération Effectuer !";
        $_SESSION['typeMsg'] = "info";
        header('location:accueil.php?page=Carriere');
        exit();




    }

    if(isset($_POST['addNewFonction'])){
        $matricule = validation_donnees($_POST['matric']);
        $dateDebut = validation_donnees($_POST['dateDebut']);
        $nouv_fonction = validation_donnees($_POST['nouv_fonction']);
        $id = "";
        
        $reqGetFonctionID = $db->prepare("SELECT * FROM bdd_paie.detail_agent_fonction     
        WHERE agent_ID = :agent_ID AND statut_ID = :statut_ID");

        $reqGetFonctionID->bindValue(':agent_ID',$matricule);
        $reqGetFonctionID->bindValue(':statut_ID','act');
        $reqGetFonctionID->execute();
        while ($resGetFonctionID = $reqGetFonctionID->fetch()) {
            $id = $resGetFonctionID['id_det_ag_fonction'];
        }
        
        $reqUpdateFonction = $db->prepare("UPDATE bdd_paie.detail_agent_fonction              
            SET dateFin = :dateFin, modifierPar = :modifierPar, statut_ID = :statut_ID
            WHERE id_det_ag_fonction = :id_det_ag_fonction");
        $reqUpdateFonction->bindValue(':id_det_ag_fonction',$id);
        $reqUpdateFonction->bindValue(':dateFin',$dateDebut);
        $reqUpdateFonction->bindValue(':modifierPar',$modifier_creerPar);
        $reqUpdateFonction->bindValue(':statut_ID','desac');
        $reqUpdateFonction->execute();

        $reqAddFonction = $db->prepare("INSERT INTO  bdd_paie.detail_agent_fonction
        (agent_ID,fonction_ID,dateDebut,creerPar,statut_ID,document,document_byte) 
        VALUES (:agent_ID,:fonction_ID,:dateDebut,:creerPar,:statut_ID,:document,:document_byte)");
        $reqAddFonction->bindValue(':agent_ID',$matricule);
        $reqAddFonction->bindValue(':fonction_ID',$nouv_fonction);
        $reqAddFonction->bindValue(':dateDebut',$dateDebut);
        $reqAddFonction->bindValue(':creerPar',$modifier_creerPar);
        $reqAddFonction->bindValue(':statut_ID','act');
        $reqAddFonction->bindValue(':document',$nomDoc_ag);
        $reqAddFonction->bindValue(':document_byte',$doc_ag_Binaire);
        $reqAddFonction->execute();

        $_SESSION['message'] = "Opération Effectuer !";
        $_SESSION['typeMsg'] = "info";
        header('location:accueil.php?page=Carriere');
        exit();




    }

    if(isset($_POST['addNewActivite'])){
        $matricule = validation_donnees($_POST['matric']);
        $dateDebut = validation_donnees($_POST['dateDebut']);
        $nouv_activite = validation_donnees($_POST['nouv_activite']);
        $id = "";
        
        $reqGetActiviteID = $db->prepare("SELECT * FROM bdd_paie.detail_agent_activ 
        WHERE agent_ID = :agent_ID AND statut_ID = :statut_ID");

        $reqGetActiviteID->bindValue(':agent_ID',$matricule);
        $reqGetActiviteID->bindValue(':statut_ID','act');
        $reqGetActiviteID->execute();
        while ($resGetActiviteID = $reqGetActiviteID->fetch()) {
            $id = $resGetActiviteID['id_det_ag_activite'];
        }
        
        $reqUpdateActivite = $db->prepare("UPDATE bdd_paie.detail_agent_activ 
            SET dateFin = :dateFin, modifierPar = :modifierPar, statut_ID = :statut_ID
            WHERE id_det_ag_activite = :id_det_ag_activite");
        $reqUpdateActivite->bindValue(':id_det_ag_activite',$id);
        $reqUpdateActivite->bindValue(':dateFin',$dateDebut);
        $reqUpdateActivite->bindValue(':modifierPar',$modifier_creerPar);
        $reqUpdateActivite->bindValue(':statut_ID','desac');
        $reqUpdateActivite->execute();

        $reqUpdateActiviteag = $db->prepare("UPDATE bdd_paie.t_agent SET activiter_ID = :nouv_activite
            WHERE matricule= :agent_ID");
        $reqUpdateActiviteag->bindValue(':nouv_activite',$nouv_activite );
        $reqUpdateActiviteag->bindValue(':agent_ID',$matricule);
        $reqUpdateActiviteag->execute();



        $reqAddActivite = $db->prepare("INSERT INTO  bdd_paie.detail_agent_activ
        (agent_ID,code_activ_ID,dateDebut,creerPar,statut_ID,document,document_byte) 
        VALUES (:agent_ID,:code_activ_ID,:dateDebut,:creerPar,:statut_ID,:document,:document_byte)");
        $reqAddActivite->bindValue(':agent_ID',$matricule);
        $reqAddActivite->bindValue(':code_activ_ID',$nouv_activite);
        $reqAddActivite->bindValue(':dateDebut',$dateDebut);
        $reqAddActivite->bindValue(':creerPar',$modifier_creerPar);
        $reqAddActivite->bindValue(':statut_ID','act');
        $reqAddActivite->bindValue(':document',$nomDoc_ag);
        $reqAddActivite->bindValue(':document_byte',$doc_ag_Binaire);
        $reqAddActivite->execute();

        $_SESSION['message'] = "Opération Effectuer !";
        $_SESSION['typeMsg'] = "info";
        header('location:accueil.php?page=Carriere');
        exit();

    }

    if(isset($_POST['addNewSyndicat'])){
        $matricule = validation_donnees($_POST['matric']);
        $dateDebut = validation_donnees($_POST['dateDebut']);
        $nouv_syndicat = validation_donnees($_POST['nouv_syndicat']);
        $id = "";
        
        $reqGetSyndicatID = $db->prepare("SELECT * FROM bdd_paie.detail_agent_syndicat     
        WHERE agent_ID = :agent_ID AND statut_ID = :statut_ID");

        $reqGetSyndicatID->bindValue(':agent_ID',$matricule);
        $reqGetSyndicatID->bindValue(':statut_ID','act');
        $reqGetSyndicatID->execute();
        while ($resGetSyndicatID = $reqGetSyndicatID->fetch()) {
            $id = $resGetSyndicatID['idDetail_Agent_Syndicat'];
        }
        
        $reqUpdateSyndicat = $db->prepare("UPDATE bdd_paie.detail_agent_syndicat              
            SET dateFin = :dateFin, modifierPar = :modifierPar, statut_ID = :statut_ID
            WHERE idDetail_Agent_Syndicat  = :idDetail_Agent_Syndicat ");
        $reqUpdateSyndicat->bindValue(':idDetail_Agent_Syndicat',$id);
        $reqUpdateSyndicat->bindValue(':dateFin',$dateDebut);
        $reqUpdateSyndicat->bindValue(':modifierPar',$modifier_creerPar);
        $reqUpdateSyndicat->bindValue(':statut_ID','desac');
        $reqUpdateSyndicat->execute();

        $reqAddSyndicat = $db->prepare("INSERT INTO  bdd_paie.detail_agent_syndicat
        (agent_ID,syndicat_ID,dateDebut,creerPar,statut_ID,document,document_byte) 
        VALUES (:agent_ID,:syndicat_ID,:dateDebut,:creerPar,:statut_ID,:document,:document_byte)");
        $reqAddSyndicat->bindValue(':agent_ID',$matricule);
        $reqAddSyndicat->bindValue(':syndicat_ID',$nouv_fonction);
        $reqAddSyndicat->bindValue(':dateDebut',$dateDebut);
        $reqAddSyndicat->bindValue(':creerPar',$modifier_creerPar);
        $reqAddSyndicat->bindValue(':statut_ID','act');
        $reqAddSyndicat->bindValue(':document',$nomDoc_ag);
        $reqAddSyndicat->bindValue(':document_byte',$doc_ag_Binaire);
        $reqAddSyndicat->execute();

        $_SESSION['message'] = "Opération Effectuer !";
        $_SESSION['typeMsg'] = "info";
        header('location:accueil.php?page=Carriere');
        exit();




    }