<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['add_document_ag'])){
            $matric = "";
            /*$reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
            $reqGetNomUtilisateur->bindvalue(':id_user',$_SESSION['id_utilisateur']);
            $reqGetNomUtilisateur->execute();
            while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                $matric = $resGetNomUtilisateur['agent_ID'];
            }
            */
            $matric = validation_donnees($_POST['matric']);
            $observ = validation_donnees($_POST['observ']);
            $typeDoc = validation_donnees($_POST['typeDoc']);
            $nRef_doc = validation_donnees($_POST['nRef_doc']);
            $observ = validation_donnees($_POST['observ']);
            $dateJr = date('Y-m-d');
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
                    header('location:accueil.php?page=Documents');
                    exit;
                }
            }
            //$dateCreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";

            if(!empty($matric) || !empty($nRef_doc) || !empty($observ) || !empty($doc_ag_Binaire) ||
               !empty($doc_ag_Data) )
            {
                try {
                    $reqAddVehicule = $db->prepare ("INSERT INTO bdd_paie.t_doc_agent (id_typedoc,matricule,ref_doc,observation,document,document_byte,creerPar,datecreat) 
                    VALUES (:id_typedoc,:matricule,:ref_doc,:observation,:document,:document_byte,:creerPar,:datecreat)");
                    $reqAddVehicule->bindValue(':id_typedoc',$typeDoc);
                    $reqAddVehicule->bindValue(':matricule',$matric);
                    $reqAddVehicule->bindValue(':ref_doc',$nRef_doc);
                    $reqAddVehicule->bindValue(':observation',$observ);
                    $reqAddVehicule->bindValue(':document',$nomDoc_ag);
                    $reqAddVehicule->bindValue(':document_byte',$doc_ag_Binaire);
                    $reqAddVehicule->bindValue(':creerPar',$creerPar);   
                    $reqAddVehicule->bindValue(':datecreat',$dateJr);

                    $reqAddVehicule->execute();

                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=Documents');
                    exit();
    
                  } catch (PDOException $e) {
                    echo "Erreur: " . $e->getMessage();
                    echo $doc_ag_Data;
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Documents');
                exit();
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Documents');
        exit();
        
    }


