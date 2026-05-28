<?php
     function validation_donnees($donnees){
        $donnees = trim($donnees);
        //$donnees = stripslashes($donnees);
        //$donnees = htmlspecialchars($donnees);
        return $donnees;
    }

    function h($value): string {
        if (is_array($value) || is_object($value)) {
            return '';
        }
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }

    function normalizePeriode($periode) {
    // Retirer espaces inutiles
    $periode = trim($periode);

    // Séparer mois et année
    list($m, $y) = explode('/', $periode);

    // Normaliser le mois sur 2 chiffres
    $m = str_pad(intval($m), 2, '0', STR_PAD_LEFT);

    // Si année est sur 2 chiffres -> on ajoute 20 devant (2000+)
    if (strlen($y) == 2) {
        $y = "20" . $y;
    }

    // Retourner format final
    return "$m/$y";
}

    function mot_de_passe_Aleatoire($leng = 8){
        $str = '0123456789@&abcdefghijklmnopqrsptuvwxyz@&ABCDEFGHIJKLMNOPQRSTUVWXYZ@&';
        $passAleat = '';
        for($i=0;$i<$leng;$i++){
        $passAleat .= $str[rand(0,strlen($str)-1)];
        }
        return $passAleat;
    }

    function getEtat_historique_con_agent($bdd,$role){
        $reqInfoAgent = $bdd->prepare("SELECT * FROM bdd_paie.v_historique 
        WHERE v_historique.id_role = :id_role");
        $reqInfoAgent ->bindValue(':id_role',$role);
        $reqInfoAgent ->execute();
        $nombre = $reqInfoAgent->rowCount();
        return $nombre;
    }

   // function getInfo_conger($bdd,$statut){
     //   $reqInfoConger = $bdd->prepare("SELECT * FROM bdd_paie.t_conge 
    //    INNER JOIN bdd_paie.t_demandeconge ON t_demandeconge.id_demande =t_conge.id_dem_conge 
    //    INNER JOIN bdd_paie.t_typconge ON t_typconge.id_type_conge=t_demandeconge.id_typeconge 
     //   INNER JOIN bdd_paie.t_agent ON t_agent.matricule=t_demandeconge.matricule 
     //   WHERE CURDATE() BETWEEN t_conge.date_debut AND t_conge.date_fin AND t_conge.statut=:statut");
     //   $reqInfoConger ->bindValue(':statut',$statut);
        //$reqInfoConger ->bindValue(':etat',$etat);
    ///    $reqInfoConger ->execute();
    //    $nombre = $reqInfoConger->rowCount();
    //    return $nombre;
   // }
    
    function getEtat_activiter_agent($bdd,$activite){
        $reqInfoAgent = $bdd->prepare("SELECT * FROM bdd_paie.t_agent 
        INNER JOIN bdd_paie.t_activite ON t_activite.code_activ = t_agent.activiter_ID
        WHERE t_activite.code_activ = :code_activ ");
        $reqInfoAgent ->bindValue(':code_activ',$activite);
        $reqInfoAgent ->execute();
        $nombre = $reqInfoAgent->rowCount();
        return $nombre;
    }
    function getPlanning_Retraite_agent($bdd,$valAge,$symbol){
        $reqPlanningRetraite = $bdd->prepare("SELECT 
        t_agent.matricule,
        t_agent.nom_ag,
        t_agent.postnom_ag,
        t_agent.prenom_ag, 
        YEAR(CURDATE()) - YEAR(dateNaiss_ag) AS DiffDate 
        FROM 
        bdd_paie.t_agent 
        WHERE 
        YEAR(CURDATE()) - YEAR(dateNaiss_ag) $symbol $valAge 
            AND bdd_paie.t_agent.activiter_ID = '01'");// symbole peut prendre la val egal ou sup
        $reqPlanningRetraite ->execute();
        $nombre = $reqPlanningRetraite->rowCount();
        return $nombre;
    }
    
    
    
    
function formatDateFr(?string $date, string $type = 'long'): string
{
    if (empty($date)) {
        return 'Inconnu'; // ou 'Date non disponible'
    }

    try {
        $dateObj = new DateTime($date);

        if ($type === 'long') {
            $formatter = new IntlDateFormatter(
                'fr_FR',
                IntlDateFormatter::LONG,
                IntlDateFormatter::NONE
            );
            return $formatter->format($dateObj);
        } elseif ($type === 'court') {
            return $dateObj->format('d m Y');
        } else {
            return $dateObj->format('Y-m-d');
        }
    } catch (Exception $e) {
        return 'Date invalide';
    }
}


// MASSE SALARIALE FONCTION
    function get_MasseSal($bdd,$typePaie,$codePaie,$periode){
        $reqInfoAgent = $bdd->prepare("SELECT SUM(montant_payer) AS total_montant FROM bdd_paie.t_paie
        WHERE type_paie = :type_paie AND codeEiPaie = :codeEiPaie AND periode = :periode");
        $reqInfoAgent ->bindValue(':type_paie',$typePaie);
        $reqInfoAgent ->bindValue(':codeEiPaie',$codePaie);
        $reqInfoAgent ->bindValue(':periode',$periode);
        $reqInfoAgent ->execute();
        
        $total = $reqInfoAgent->fetchColumn();

        //$total = number_format($total, 2, ',', ' ');
        //$total = number_format($total, 2, ',', ' ');
        return $total;
    }

?>