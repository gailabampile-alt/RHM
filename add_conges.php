<?php
    session_start();
    try {
        require_once('sys_connexion.php');
        require_once('sys_fonction.php');

        if(isset($_POST['addConge'])){
            $matric = validation_donnees($_POST['matric']);
          $id_demande = validation_donnees($_POST['id_demande']);
           
            $fichierdoc_Data = "";
            $fichierdoc_Binaire = "";
            if($_FILES['fich_doc']['size'] < 10000000){
                $nomFichier_doc = $_FILES['fich_doc']['name'];
                $cheminFichierdoc = 'Documents/'.$nomFichier_doc;
                $fichierdoc_Path = pathinfo($cheminFichierdoc,PATHINFO_EXTENSION);
                $valid  = array("jpg","jpeg","docx","pdf");
                if(in_array(strtolower($fichierdoc_Path),$valid)){
                    move_uploaded_file($_FILES['fich_doc']['tmp_name'],$cheminFichierdoc);
                    $fichierdoc_Data = file_get_contents($cheminFichierdoc);
                    $fichierdoc_Binaire = base64_encode($fichierdoc_Data); 
                    
                }else{
                    $_SESSION['message'] = "Votre type de Fichier n'est correspond pas aux types prises en charge";
                    $_SESSION['typeMsg'] = "warning";
                    header('location:accueil.php?page=Conge');
                    exit;
                }
            }
            $datecreat = date('Y-m-d');
            $creerPar = $_SESSION['id_utilisateur'];
            $statut = "act";

            if(!empty($matric) || !empty($id_dem) || !empty($nbrejr)  )
            {
                try {
                    $db->beginTransaction();

                    $reqAddConges = $db->prepare("INSERT INTO `bdd_paie`.`t_conge` (`id_dem_conge`, `date_debut`, `date_fin`, `nbre_jour`, `statut`, `document`, `document_byte`, `creerPar`, `datecreat`)
                    SELECT `id_demande`, `date_debut`, `date_fin`, `nbrejr_accord`, 'act', NULL, NULL, NULL, NULL FROM `bdd_paie`.`t_demandeconge` 
                    WHERE `matricule` = :matric AND `etat` = :etat");

                    $reqAddConges->bindValue(':etat',"act");
                    $reqAddConges->bindValue(':matric',$matric);
                    
                    $reqAddConges->execute();

                    $reqGetInfobar = $db->prepare("select * from bdd_paie.t_conge where id_dem_conge=:id_demande");
                    $reqGetInfobar->bindValue(':id_demande',$id_demande);
                    $reqGetInfobar->execute();

                    while($resGetInfobar = $reqGetInfobar->fetch())
                        {
    
                            $id_conge=$resGetInfobar['id_conge'];
    
                        }

                        

                    $updateConges = $db->prepare( "UPDATE bdd_paie.t_conge SET statut=:statut,`document`=:document,`document_byte`=:document_bytes,`creerPar`=:creerPar,`datecreat`=:datecreat WHERE id_conge=:id_conge");
                    $updateConges->bindValue(':statut', "act"); 
                    $updateConges->bindValue(':document', $nomFichier_doc); 
                    $updateConges->bindValue(':document_bytes', $fichierdoc_Binaire ); 
                    $updateConges->bindValue(':creerPar', $creerPar); 
                    $updateConges->bindValue(':datecreat', $datecreat);
                    $updateConges->bindValue(':id_conge', $id_conge); 
                    $updateConges->execute();

                    $updateConge = $db->prepare ("UPDATE bdd_paie.t_demandeconge SET statut =:statut, etat=:etat WHERE id_demande=:id_demande");
                    $updateConge->bindValue(':etat',"act"); 
                    $updateConge->bindValue(':statut',"encours");
                    $updateConge->bindValue(':id_demande',$id_demande);
                   
                    $updateConge->execute();

                    $db->commit();
                  
                    $_SESSION['message']  = "Enregistrement Effectuer !";
                    $_SESSION['typeMsg']  = "info";
                    header('location:accueil.php?page=voir_conger_autorise');
                    exit();
                   
                  } catch (PDOException $e) {
                    $db->rollBack();
                    echo "Erreur: " . $e->getMessage();
                  }
            }else{
                $_SESSION['message']  = "Opération Echouer  : Veuillez remplir toutes les zones";
                $_SESSION['typeMsg']  = "danger";
                header('location:accueil.php?page=Conge');
                exit();
                
            }

            
        }
    
    } catch (PDOException $ex) {
        $_SESSION['message']  = "Erreur  : ".$ex->getMessage();
        $_SESSION['typeMsg']  = "danger";
        header('location:accueil.php?page=Conge');
        exit();
        
    }


