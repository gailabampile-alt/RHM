<?php
session_start();

try {
    require_once('sys_connexion.php');
    require_once('sys_fonction.php');

    $db->exec("CREATE TABLE IF NOT EXISTS bdd_paie.t_calendrier_conge_engagement (
        id_planning INT NOT NULL AUTO_INCREMENT,
        matricule VARCHAR(50) NOT NULL,
        exercice INT NOT NULL,
        date_debut DATE NOT NULL,
        date_fin DATE NOT NULL,
        nbre_jour INT NOT NULL DEFAULT 0,
        statut VARCHAR(20) NOT NULL DEFAULT 'planifie',
        observation TEXT NULL,
        creerPar VARCHAR(50) NULL,
        datecreat DATE NULL,
        modifierPar VARCHAR(50) NULL,
        datemodif DATE NULL,
        PRIMARY KEY (id_planning),
        UNIQUE KEY uq_calendrier_conge_engagement (matricule, exercice)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

    if (!isset($_POST['save_planning_engagement'])) {
        header('location:accueil.php?page=Calendrier_Engagement');
        exit();
    }

    $exercice = isset($_POST['exercice']) ? (int) $_POST['exercice'] : (int) date('Y');
    $matricules = isset($_POST['matricule']) && is_array($_POST['matricule']) ? $_POST['matricule'] : array();
    $datesDebut = isset($_POST['date_debut']) && is_array($_POST['date_debut']) ? $_POST['date_debut'] : array();
    $datesFin = isset($_POST['date_fin']) && is_array($_POST['date_fin']) ? $_POST['date_fin'] : array();
    $jours = isset($_POST['nbre_jour']) && is_array($_POST['nbre_jour']) ? $_POST['nbre_jour'] : array();
    $statuts = isset($_POST['statut']) && is_array($_POST['statut']) ? $_POST['statut'] : array();
    $observations = isset($_POST['observation']) && is_array($_POST['observation']) ? $_POST['observation'] : array();

    $reqSave = $db->prepare("INSERT INTO bdd_paie.t_calendrier_conge_engagement
        (matricule, exercice, date_debut, date_fin, nbre_jour, statut, observation, creerPar, datecreat, modifierPar, datemodif)
        VALUES (:matricule, :exercice, :date_debut, :date_fin, :nbre_jour, :statut, :observation, :creerPar, :datecreat, :modifierPar, :datemodif)
        ON DUPLICATE KEY UPDATE
            date_debut = VALUES(date_debut),
            date_fin = VALUES(date_fin),
            nbre_jour = VALUES(nbre_jour),
            statut = VALUES(statut),
            observation = VALUES(observation),
            modifierPar = VALUES(modifierPar),
            datemodif = VALUES(datemodif)");

    $reqTypeConge = $db->prepare("SELECT id_type_conge
        FROM bdd_paie.t_typconge
        ORDER BY
            CASE
                WHEN libelle_conge LIKE '%annuel%' THEN 0
                WHEN libelle_conge LIKE '%ordinaire%' THEN 1
                ELSE 2
            END,
            id_type_conge ASC
        LIMIT 1");
    $reqTypeConge->execute();
    $idTypeConge = $reqTypeConge->fetchColumn();

    if (!$idTypeConge) {
        throw new Exception("Aucun type de conge n'est configure dans t_typconge.");
    }

    $reqFindDemande = $db->prepare("SELECT id_demande, statut
        FROM bdd_paie.t_demandeconge
        WHERE matricule = :matricule
            AND excercice = :exercice
            AND id_typeconge = :id_typeconge
        LIMIT 1");

    $reqInsertDemande = $db->prepare("INSERT INTO bdd_paie.t_demandeconge
        (id_typeconge, date_demande, date_debut, date_fin, excercice, nbrejr_solic, date_accord, nbrejr_accord, matricule, AccordePar, creerpar, statut, etat)
        VALUES (:id_typeconge, :date_demande, :date_debut, :date_fin, :exercice, :nbre_jour, NULL, NULL, :matricule, NULL, :creerpar, 'naprv', 'act')");

    $reqUpdateDemande = $db->prepare("UPDATE bdd_paie.t_demandeconge
        SET date_demande = :date_demande,
            date_debut = :date_debut,
            date_fin = :date_fin,
            nbrejr_solic = :nbre_jour,
            creerpar = :creerpar,
            statut = 'naprv',
            etat = 'act'
        WHERE id_demande = :id_demande
            AND statut = 'naprv'");

    $db->beginTransaction();
    $saved = 0;
    $demandesCreated = 0;
    $demandesUpdated = 0;
    $demandesSkipped = 0;
    $user = isset($_SESSION['id_utilisateur']) ? $_SESSION['id_utilisateur'] : 'sysAdmin';

    foreach ($matricules as $index => $matricule) {
        $matricule = validation_donnees($matricule);
        $dateDebut = isset($datesDebut[$index]) ? validation_donnees($datesDebut[$index]) : '';
        $dateFin = isset($datesFin[$index]) ? validation_donnees($datesFin[$index]) : '';
        $nbreJour = isset($jours[$index]) ? (int) $jours[$index] : 0;
        $statut = isset($statuts[$index]) ? validation_donnees($statuts[$index]) : 'planifie';
        $observation = isset($observations[$index]) ? validation_donnees($observations[$index]) : '';

        if ($matricule === '' || $dateDebut === '' || $dateFin === '' || $nbreJour <= 0) {
            continue;
        }

        if (strtotime($dateFin) < strtotime($dateDebut)) {
            throw new Exception("La date fin ne peut pas etre inferieure a la date debut pour le matricule " . $matricule);
        }

        $reqSave->bindValue(':matricule', $matricule);
        $reqSave->bindValue(':exercice', $exercice);
        $reqSave->bindValue(':date_debut', $dateDebut);
        $reqSave->bindValue(':date_fin', $dateFin);
        $reqSave->bindValue(':nbre_jour', $nbreJour, PDO::PARAM_INT);
        $reqSave->bindValue(':statut', $statut);
        $reqSave->bindValue(':observation', $observation);
        $reqSave->bindValue(':creerPar', $user);
        $reqSave->bindValue(':datecreat', date('Y-m-d'));
        $reqSave->bindValue(':modifierPar', $user);
        $reqSave->bindValue(':datemodif', date('Y-m-d'));
        $reqSave->execute();
        $saved++;

        if ($statut === 'valide') {
            $reqFindDemande->bindValue(':matricule', $matricule);
            $reqFindDemande->bindValue(':exercice', $exercice);
            $reqFindDemande->bindValue(':id_typeconge', $idTypeConge);
            $reqFindDemande->execute();
            $demande = $reqFindDemande->fetch(PDO::FETCH_ASSOC);

            if ($demande) {
                if ($demande['statut'] === 'naprv') {
                    $reqUpdateDemande->bindValue(':date_demande', date('Y-m-d'));
                    $reqUpdateDemande->bindValue(':date_debut', $dateDebut);
                    $reqUpdateDemande->bindValue(':date_fin', $dateFin);
                    $reqUpdateDemande->bindValue(':nbre_jour', $nbreJour, PDO::PARAM_INT);
                    $reqUpdateDemande->bindValue(':creerpar', $user);
                    $reqUpdateDemande->bindValue(':id_demande', $demande['id_demande']);
                    $reqUpdateDemande->execute();
                    $demandesUpdated++;
                } else {
                    $demandesSkipped++;
                }
            } else {
                $reqInsertDemande->bindValue(':id_typeconge', $idTypeConge);
                $reqInsertDemande->bindValue(':date_demande', date('Y-m-d'));
                $reqInsertDemande->bindValue(':date_debut', $dateDebut);
                $reqInsertDemande->bindValue(':date_fin', $dateFin);
                $reqInsertDemande->bindValue(':exercice', $exercice);
                $reqInsertDemande->bindValue(':nbre_jour', $nbreJour, PDO::PARAM_INT);
                $reqInsertDemande->bindValue(':matricule', $matricule);
                $reqInsertDemande->bindValue(':creerpar', $user);
                $reqInsertDemande->execute();
                $demandesCreated++;
            }
        }
    }

    $db->commit();
    $_SESSION['message'] = $saved . " ligne(s) du calendrier enregistree(s). Demandes creees : " . $demandesCreated . ", mises a jour : " . $demandesUpdated . ", deja traitees : " . $demandesSkipped . ".";
    $_SESSION['typeMsg'] = "info";
    header('location:accueil.php?page=Calendrier_Engagement&annee=' . $exercice);
    exit();
} catch (Exception $ex) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    $_SESSION['message'] = "Erreur : " . $ex->getMessage();
    $_SESSION['typeMsg'] = "danger";
    header('location:accueil.php?page=Calendrier_Engagement');
    exit();
}
