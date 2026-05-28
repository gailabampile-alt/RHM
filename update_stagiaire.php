<?php
session_start();
require_once('sys_connexion.php');
require_once('sys_fonction.php');

// -----------------------------
// Désactivation / fin de stage
// -----------------------------
if (isset($_GET['code_desac_stg'])) {
    try {
        $reqFinStage = $db->prepare("
            UPDATE bdd_paie.t_stagiare
               SET statut_ID   = :statut_ID,
                   dateFin_stg = :dateFin_stg,
                   modifierPar = :modifierPar,
                   histo_stg        = CONCAT(histo_stg,' | ',:histo)
             WHERE id_stg      = :id_stg
        ");
        $dateFin = $_GET['dateF'] ?? null;
        $reqFinStage->bindValue(':statut_ID', 'desac', PDO::PARAM_STR);
        $reqFinStage->bindValue(':dateFin_stg', date('Y-m-d'), PDO::PARAM_STR);
        $reqFinStage->bindValue(':modifierPar', $_SESSION['id_utilisateur'], PDO::PARAM_INT);
        $reqFinStage->bindValue(':histo', ($dateFin . ' à ' . date('Y-m-d')), PDO::PARAM_STR);
        $reqFinStage->bindValue(':id_stg', $_GET['code_desac_stg'], PDO::PARAM_INT);
        $reqFinStage->execute();

        $_SESSION['message'] = "Suspension du stage effectuée !";
        $_SESSION['typeMsg'] = "info";
    } catch (Exception $e) {
        $_SESSION['message'] = "Erreur de suspension : " . $e->getMessage();
        $_SESSION['typeMsg'] = "danger";
    }
    header('location:accueil.php?page=Voir_Stagiaire');
    exit();
}

if (isset($_POST['ModifStg_act'])) {
    $dateDebut = $_POST['dateDebut_stg'];
    $dateFin = $_POST['dateFin_stg'];
    $statut = $_POST['statut'];
    $id_stg = $_POST['id_stg'];
    try {
        $sql = "
            UPDATE bdd_paie.t_stagiare
               SET dateDebut_stage = :dateDebut,
                   dateFin_stg     = :dateFin,
                   modifierPar     = :modifierPar,
                   histo_stg       = :histo,
                   statut_ID       = :statut   
            WHERE id_stg = :id_stg     
        ";
        $reqUpdate = $db->prepare($sql);

        // Bind communs
        $reqUpdate->bindValue(':dateDebut',  $dateDebut, PDO::PARAM_STR);
        $reqUpdate->bindValue(':dateFin',    $dateFin,   PDO::PARAM_STR);
        $reqUpdate->bindValue(':modifierPar',$_SESSION['id_utilisateur'], PDO::PARAM_INT);
        $reqUpdate->bindValue(':histo',      !empty($histo) ? $histo : ($dateDebut . ' à ' . $dateFin), PDO::PARAM_STR);
        $reqUpdate->bindValue(':statut',    $statut,   PDO::PARAM_STR);
        $reqUpdate->bindValue(':id_stg',     $id_stg,    PDO::PARAM_INT);

        $reqUpdate->execute();

        $_SESSION['message'] = "Recondiction du stagiaire effectuée !";
        $_SESSION['typeMsg'] = "info";
        header('location:accueil.php?page=Voir_Stagiaire');
        exit();
        
    } catch (Exception $e) {
        $_SESSION['message'] = "Erreur de Modification : " . $e->getMessage();
        $_SESSION['typeMsg'] = "danger";
        header('location:accueil.php?page=Voir_Stagiaire');
        exit();
    }
    



}

try {
    if (isset($_POST['ModifStg'])) {
        // -----------------------------
        // Récupération + nettoyage
        // -----------------------------
        $id_stg    = validation_donnees($_POST['id_stg']);
        $nom       = validation_donnees($_POST['nom_stg']);
        $postnom   = validation_donnees($_POST['postnom_stg']);
        $prenom    = validation_donnees($_POST['prenom_stg']);
        $sexe      = validation_donnees($_POST['sexe_stg']);
        $etatCiv   = validation_donnees($_POST['etatCiv_stg']);
        $nivEtud   = validation_donnees($_POST['nivEtude_stg']);
        $siege     = validation_donnees($_POST['siege_stg']);
        $dir       = validation_donnees($_POST['dir_stg']);
        $pOrigi    = validation_donnees($_POST['pOrigi_stg']);
        $pNaiss    = validation_donnees($_POST['pNaiss_stg']);
        $dateNaiss = validation_donnees($_POST['dateNaiss_stg']);
        $dateDebut = validation_donnees($_POST['dateDebut_stg']);
        $dateFin   = validation_donnees($_POST['dateFin_stg']);
        $phone     = validation_donnees($_POST['phone_stg']);
        $adresse   = validation_donnees($_POST['adresse_stg']);
        $statut   = validation_donnees($_POST['statut']);
        //$histo     = validation_donnees($_POST['histo_stg']); // si vide, on posera une valeur par défaut plus bas
        $modifierPar   = $_SESSION['id_utilisateur'];
        $anciennePhoto = $_POST['ancienne_photo'] ?? '';
        $ancienDoc     = $_POST['ancienFdoc'] ?? '';

        // Champs obligatoires
        $obligatoiresOK = (
            !empty($nom) && !empty($postnom) && !empty($prenom) && !empty($sexe) && !empty($etatCiv) &&
            !empty($nivEtud) && !empty($siege) && !empty($dir) && !empty($pOrigi) && !empty($pNaiss) &&
            !empty($dateNaiss) && !empty($dateDebut) && !empty($phone) && !empty($adresse)
        );

        if (!$obligatoiresOK) {
            $_SESSION['message'] = "Veuillez remplir tous les champs obligatoires.";
            $_SESSION['typeMsg'] = "warning";
            header('location:accueil.php?page=Voir_Stagiaire');
            exit();
        }

        // -----------------------------
        // Détermination de la stratégie "fichiers"
        // -----------------------------
        $cheminDocAncien   = 'DocumentsStagiaire/' . $ancienDoc;
        $cheminPhotoAncien = 'photoStagiaire/' . $anciennePhoto;
        $fichiersExistants = (is_file($cheminDocAncien) && is_file($cheminPhotoAncien));

        // Préfixes et config upload
        $maxSize = 10 * 1024 * 1024; // 10 Mo
        $extOk   = ['pdf','doc','docx','jpg','jpeg','png'];

        // Flags d’upload
        $docUploaded   = (isset($_FILES['Fdoc']) && $_FILES['Fdoc']['error'] === UPLOAD_ERR_OK);
        $photoUploaded = (isset($_FILES['photo_stg']) && $_FILES['photo_stg']['error'] === UPLOAD_ERR_OK);

        // Variables cibles (noms + binaires) – par défaut on reprend l’existant
        $nomDoc      = $ancienDoc;
        $docBinaire  = null; // si tu veux conserver l’ancien binaire, charge-le ici
        $photoStg    = $anciennePhoto;
        $photoBinaire= null;

        // Helper pour extension
        $getExt = function(string $filename): string {
            return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        };

        // -----------------------------
        // Traitement upload DOCUMENT
        // -----------------------------
        if ($docUploaded) {
            if ($_FILES['Fdoc']['size'] > $maxSize) {
                $_SESSION['message'] = "Le document dépasse 10 Mo.";
                $_SESSION['typeMsg'] = "warning";
                header('location:accueil.php?page=Voir_Stagiaire');
                exit();
            }
            $nomDocTmp = $_FILES['Fdoc']['name'];
            $extDoc    = $getExt($nomDocTmp);
            if (!in_array($extDoc, $extOk, true)) {
                $_SESSION['message'] = "Type de fichier document non pris en charge.";
                $_SESSION['typeMsg'] = "warning";
                header('location:accueil.php?page=Voir_Stagiaire');
                exit();
            }
            // Nom final (tu peux ajouter un uniqid pour éviter collisions)
            $nomDoc    = $nomDocTmp;
            $cibleDoc  = 'DocumentsStagiaire/' . $nomDoc;
            if (!move_uploaded_file($_FILES['Fdoc']['tmp_name'], $cibleDoc)) {
                $_SESSION['message'] = "Échec de l'upload du document.";
                $_SESSION['typeMsg'] = "danger";
                header('location:accueil.php?page=Voir_Stagiaire');
                exit();
            }
            $docBinaire = base64_encode(file_get_contents($cibleDoc));
        }

        // -----------------------------
        // Traitement upload PHOTO
        // -----------------------------
        if ($photoUploaded) {
            if ($_FILES['photo_stg']['size'] > $maxSize) {
                $_SESSION['message'] = "La photo dépasse 10 Mo.";
                $_SESSION['typeMsg'] = "warning";
                header('location:accueil.php?page=Voir_Stagiaire');
                exit();
            }
            $nomPhotoTmp = $_FILES['photo_stg']['name'];
            $extPhoto    = $getExt($nomPhotoTmp);
            if (!in_array($extPhoto, $extOk, true)) {
                $_SESSION['message'] = "Type de photo non pris en charge.";
                $_SESSION['typeMsg'] = "warning";
                header('location:accueil.php?page=Voir_Stagiaire');
                exit();
            }
            $photoStg   = $nomPhotoTmp;
            $ciblePhoto = 'photoStagiaire/' . $photoStg;
            if (!move_uploaded_file($_FILES['photo_stg']['tmp_name'], $ciblePhoto)) {
                $_SESSION['message'] = "Échec de l'upload de la photo.";
                $_SESSION['typeMsg'] = "danger";
                header('location:accueil.php?page=Voir_Stagiaire');
                exit();
            }
            $photoBinaire = base64_encode(file_get_contents($ciblePhoto));
        }

        // -----------------------------
        // Construction de l'UPDATE
        // -----------------------------
        // Base SET (toujours)
        $sql = "
            UPDATE bdd_paie.t_stagiare
               SET nom_stg          = :nom,
                   postnom_stg      = :postnom,
                   prenom_stg       = :prenom,
                   sexe_stg         = :sexe,
                   etatCiv_stg      = :etatCiv,
                   nivEtude_stg     = :nivEtud,
                   siege_stg        = :siege,
                   dir_stg          = :dir,
                   pOrigi_stg       = :pOrigi,
                   pNaiss_stg       = :pNaiss,
                   dateNaiss        = :dateNaiss,
                   phone_stg        = :phone,
                   adresse_stg      = :adresse,
                   modifierPar      = :modifierPar       
        ";
        //dateDebut_stage  = :dateDebut,dateFin_stg      = :dateFin,statut_ID        = :statut
        // Ajouts conditionnels si de nouveaux fichiers ont été uploadés
        if ($photoUploaded) {
            $sql .= ",
                   photo_stg        = :photo_stg,
                   photo_byte_stg   = :photo_byte_stg
            ";
        }
        if ($docUploaded) {
            $sql .= ",
                   document         = :document,
                   document_byte    = :document_byte
            ";
        }

        $sql .= " WHERE id_stg = :id_stg";

        // -----------------------------
        // Prépare + bind + exécute
        // -----------------------------
        $reqUpdate = $db->prepare($sql);

        // Bind communs
        $reqUpdate->bindValue(':nom',        $nom,       PDO::PARAM_STR);
        $reqUpdate->bindValue(':postnom',    $postnom,   PDO::PARAM_STR);
        $reqUpdate->bindValue(':prenom',     $prenom,    PDO::PARAM_STR);
        $reqUpdate->bindValue(':sexe',       $sexe,      PDO::PARAM_STR);
        $reqUpdate->bindValue(':etatCiv',    $etatCiv,   PDO::PARAM_STR);
        $reqUpdate->bindValue(':nivEtud',    $nivEtud,   PDO::PARAM_STR);
        $reqUpdate->bindValue(':siege',      $siege,     PDO::PARAM_STR);
        $reqUpdate->bindValue(':dir',        $dir,       PDO::PARAM_STR);
        $reqUpdate->bindValue(':pOrigi',     $pOrigi,    PDO::PARAM_STR);
        $reqUpdate->bindValue(':pNaiss',     $pNaiss,    PDO::PARAM_STR);
        $reqUpdate->bindValue(':dateNaiss',  $dateNaiss, PDO::PARAM_STR);
        //$reqUpdate->bindValue(':dateDebut',  $dateDebut, PDO::PARAM_STR);
        //$reqUpdate->bindValue(':dateFin',    $dateFin,   PDO::PARAM_STR);
        $reqUpdate->bindValue(':phone',      $phone,     PDO::PARAM_STR);
        $reqUpdate->bindValue(':adresse',    $adresse,   PDO::PARAM_STR);
        $reqUpdate->bindValue(':modifierPar',$modifierPar, PDO::PARAM_INT);
        //histo_stg        = CONCAT(histo_stg,' | ',:histo),$reqUpdate->bindValue(':histo',      !empty($histo) ? $histo : ($dateFin . ' à ' . date('Y-m-d')), PDO::PARAM_STR);
        //$reqUpdate->bindValue(':statut',    $statut,   PDO::PARAM_STR);
        $reqUpdate->bindValue(':id_stg',     $id_stg,    PDO::PARAM_INT);

        // Bind optionnels
        if ($photoUploaded) {
            $reqUpdate->bindValue(':photo_stg',      $photoStg,     PDO::PARAM_STR);
            $reqUpdate->bindValue(':photo_byte_stg', $photoBinaire,  PDO::PARAM_STR);
        }
        if ($docUploaded) {
            $reqUpdate->bindValue(':document',       $nomDoc,       PDO::PARAM_STR);
            $reqUpdate->bindValue(':document_byte',  $docBinaire,    PDO::PARAM_STR);
        }

        $reqUpdate->execute();

        $_SESSION['message'] = "Modification du stagiaire effectuée !";
        $_SESSION['typeMsg'] = "info";
        header('location:accueil.php?page=Voir_Stagiaire');
        exit();

    } else {
        $_SESSION['message'] = "Aucune donnée reçue pour la modification du stagiaire.";
        $_SESSION['typeMsg'] = "danger";
        header('location:accueil.php?page=Voir_Stagiaire');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['message'] = "Erreur lors de la modification du stagiaire : " . $e->getMessage();
    $_SESSION['typeMsg'] = "danger";
    header('location:accueil.php?page=Voir_Stagiaire');
    exit();
}