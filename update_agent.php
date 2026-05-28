
<?php
session_start();

try {
    require_once('sys_connexion.php');
    require_once('sys_fonction.php');

    if (isset($_POST['updateAgent'])) {

        /* ========= DONNEES ========= */
        $matric     = validation_donnees($_POST['matric']);
        $lastMatric = validation_donnees($_POST['lastMatric']);
        $nom        = validation_donnees($_POST['nom']);
        $postnom    = validation_donnees($_POST['postnom']);
        $prenom     = validation_donnees($_POST['prenom']);
        $sexe       = validation_donnees($_POST['sexe']);
        $phone      = validation_donnees($_POST['phone']);
        $adresse    = validation_donnees($_POST['adress']);

        $dateEngag  = validation_donnees($_POST['dateEngag']);
        $dateNaiss  = validation_donnees($_POST['dateNaiss']);

        $grade      = validation_donnees($_POST['grade']);
        $siege      = validation_donnees($_POST['siege']);
        $activ      = validation_donnees($_POST['activ']);
        $dir        = validation_donnees($_POST['dir']);
        $fonct      = validation_donnees($_POST['fonct']);
        $syndi      = validation_donnees($_POST['syndi']);
        $societe    = validation_donnees($_POST['societe']);

        $nCompte    = validation_donnees($_POST['nCompte']);
        $nCNSS      = validation_donnees($_POST['nCNSS']);
        $etatCiv    = validation_donnees($_POST['etatCiv']);
        $nbrEnf     = validation_donnees($_POST['nbrEnf']);
        $nivEtud    = validation_donnees($_POST['nivEtud']);
        $pNaiss     = validation_donnees($_POST['pNaiss']);
        $pOrigi     = validation_donnees($_POST['pOrigi']);

        $indCarbu   = validation_donnees($_POST['indCarbu']);
        $indVoiture = validation_donnees($_POST['indVoiture']);
        $logemnt    = validation_donnees($_POST['logemnt']);

        $modifierPar = $_SESSION['id_utilisateur'];
        $alloc_famlily = ($nbrEnf > 0) ? 'E' : 'N';

        /* ========= PHOTO ========= */
        $nomPhoto = null;
        $photoBinaire = null;

        if (!empty($_FILES['photo_ag']['name'])) {

            $fichier = $_FILES['photo_ag'];
            $ext = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));
            $valid = ['jpg','jpeg','png'];

            if (!in_array($ext, $valid)) {
                die("Format image non supporté");
            }

            if ($fichier['size'] > 10000000) {
                die("Image trop volumineuse");
            }

            $nomPhoto = uniqid() . '.' . $ext;
            $chemin = 'photoAgent/' . $nomPhoto;

            move_uploaded_file($fichier['tmp_name'], $chemin);
            $photoBinaire = base64_encode(file_get_contents($chemin));
        }

        /* ========= UPDATE AGENT ========= */
        $db->beginTransaction();

        $sql = "UPDATE bdd_paie.t_agent SET
            matricule = :matric,
            nom_ag = :nom,
            postnom_ag = :postnom,
            prenom_ag = :prenom,
            sexe_ag = :sexe,
            etatCiv_ag = :etatCiv,
            NumCNSS_ag = :nCNSS,
            ind_logement_ag = :logement,
            nbreEnfant_ag = :nbrEnf,
            dateEngagemnt_ag = :dateEngag,
            dateNaiss_ag = :dateNaiss,
            indiceCarburant = :carbu,
            NivEtude_ag = :nivEtud,
            indiceVoiture = :voiture,
            NumCompt = :compte,
            provNaiss = :pNaiss,
            provOrig = :pOrigi,
            activiter_ID = :activ,
            alloc_fam_ID = :alloc,
            phone = :phone,
            adresse = :adresse,
            modifierPar = :modifier";

        if ($nomPhoto !== null) {
            $sql .= ", photo = :photo, photo_byte = :photo_byte";
        }

        $sql .= " WHERE matricule = :lastMatric";

        $req = $db->prepare($sql);

        $params = [
            ':matric' => $matric,
            ':nom' => $nom,
            ':postnom' => $postnom,
            ':prenom' => $prenom,
            ':sexe' => $sexe,
            ':etatCiv' => $etatCiv,
            ':nCNSS' => $nCNSS,
            ':logement' => $logemnt,
            ':nbrEnf' => $nbrEnf,
            ':dateEngag' => $dateEngag,
            ':dateNaiss' => $dateNaiss,
            ':carbu' => $indCarbu,
            ':nivEtud' => $nivEtud,
            ':voiture' => $indVoiture,
            ':compte' => $nCompte,
            ':pNaiss' => $pNaiss,
            ':pOrigi' => $pOrigi,
            ':activ' => $activ,
            ':alloc' => $alloc_famlily,
            ':phone' => $phone,
            ':adresse' => $adresse,
            ':modifier' => $modifierPar,
            ':lastMatric' => $lastMatric
        ];

        if ($nomPhoto !== null) {
            $params[':photo'] = $nomPhoto;
            $params[':photo_byte'] = $photoBinaire;
        }

        $req->execute($params);

        /* ========= AUTRES TABLES ========= */

        // Activité
        $db->prepare("UPDATE bdd_paie.detail_agent_activ 
            SET agent_ID=:matric, code_activ_ID=:activ 
            WHERE agent_ID=:last")
        ->execute([':matric'=>$matric, ':activ'=>$activ, ':last'=>$lastMatric]);

        // Direction
        $db->prepare("UPDATE bdd_paie.detail_agent_direction 
            SET agent_ID=:matric, direction_ID=:dir 
            WHERE agent_ID=:last")
        ->execute([':matric'=>$matric, ':dir'=>$dir, ':last'=>$lastMatric]);

        // Grade
        $db->prepare("UPDATE bdd_paie.detail_agent_grade 
            SET agent_ID=:matric, grade_ID=:grade 
            WHERE agent_ID=:last")
        ->execute([':matric'=>$matric, ':grade'=>$grade, ':last'=>$lastMatric]);

        // Siège
        $db->prepare("UPDATE bdd_paie.detail_agent_siege 
            SET agent_ID=:matric, siege_ID=:siege 
            WHERE agent_ID=:last")
        ->execute([':matric'=>$matric, ':siege'=>$siege, ':last'=>$lastMatric]);

        // Syndicat
        $db->prepare("UPDATE bdd_paie.detail_agent_syndicat 
            SET agent_ID=:matric, syndicat_ID=:syndi 
            WHERE agent_ID=:last")
        ->execute([':matric'=>$matric, ':syndi'=>$syndi, ':last'=>$lastMatric]);

        // Société
        $db->prepare("UPDATE bdd_paie.detail_agent_societe 
            SET agent_ID=:matric, societe_ID=:societe 
            WHERE agent_ID=:last")
        ->execute([':matric'=>$matric, ':societe'=>$societe, ':last'=>$lastMatric]);

        // Fonction
        $db->prepare("UPDATE bdd_paie.detail_agent_fonction 
            SET agent_ID=:matric, fonction_ID=:fonct 
            WHERE agent_ID=:last")
        ->execute([':matric'=>$matric, ':fonct'=>$fonct, ':last'=>$lastMatric]);

        $db->commit();

        $_SESSION['message'] = "✅ Modification réussie";
        $_SESSION['typeMsg'] = "success";
        header('location:accueil.php?page=Voir_Agent');
        exit();

    }

} catch (Exception $e) {

    if ($db->inTransaction()) {
        $db->rollBack();
    }

    $_SESSION['message'] = "Erreur : " . $e->getMessage();
    $_SESSION['typeMsg'] = "danger";
    header('location:accueil.php?page=Signalitique');
    exit();
}
?>

