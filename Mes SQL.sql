--Voir LA LISTE DES utilisateurs

CREATE VIEW v_liste_utilisateur AS SELECT 
t_utilisateurs.id_user,t_utilisateurs.username,t_utilisateurs.creerPar,t_utilisateurs.modifierPar,
t_utilisateurs.dateCreation,t_utilisateurs.dateLast_Modifi,
t_utilisateurs.agent_ID,t_agent.nom_ag,t_agent.postnom_ag,t_agent.prenom_ag,
t_statut.libelle_st,t_statut.code_st,t_role_user.id_role,t_role_user.libelle_role
FROM t_utilisateurs
INNER JOIN t_agent ON t_agent.matricule = t_utilisateurs.agent_ID
INNER JOIN t_statut ON t_statut.code_st = t_utilisateurs.statut_ID
INNER JOIN t_role_user ON t_role_user.id_role = t_utilisateurs.role_user_ID
----------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------
-- DETAIL SUR TOUTES LES INFORMATION DE L AGENT ET SE DEPENDANCE
CREATE VIEW v_info_agent AS  
SELECT 
t_agent.matricule,t_agent.nom_ag,t_agent.postnom_ag,t_agent.prenom_ag,t_agent.sexe_ag,t_agent.etatCiv_ag,t_agent.NumCNSS_ag,t_agent.ind_logement_ag,t_agent.nbreEnfant_ag,t_agent.dateEngagemnt_ag,t_agent.dateNaiss_ag,t_agent.indiceCarburant,t_agent.NivEtude_ag,t_agent.creerPar,t_agent.modifierPar,t_agent.indiceVoiture,t_agent.NumCompt,t_agent.provNaiss,t_agent.provOrig,t_agent.photo,t_agent.photo_byte,
t_activite.code_activ,t_activite.libelle_activ,
t_direction.code_dir,t_direction.libelle_dir,
t_fonction.codeFonct,t_fonction.libelleFonct,
t_grade.code_grade,t_grade.libelle_grade,
t_siege.code_sieg,t_siege.libelle_sieg,
t_societe.code_soc,t_societe.libelle_soc,
t_syndicat.code_syndi,t_syndicat.libelle_syndi

FROM t_agent
INNER JOIN detail_agent_activ ON detail_agent_activ.agent_ID = t_agent.matricule 
INNER JOIN t_activite ON t_activite.code_activ = detail_agent_activ.code_activ_ID

INNER JOIN detail_agent_direction ON detail_agent_direction.agent_ID = t_agent.matricule 
INNER JOIN t_direction ON t_direction.code_dir = detail_agent_direction.direction_ID 

INNER JOIN detail_agent_fonction ON detail_agent_fonction.agent_ID = t_agent.matricule
INNER JOIN t_fonction ON t_fonction.codeFonct = detail_agent_fonction.fonction_ID 

INNER JOIN detail_agent_grade ON detail_agent_grade.agent_ID = t_agent.matricule
INNER JOIN t_grade ON t_grade.code_grade = detail_agent_grade.grade_ID

INNER JOIN detail_agent_siege ON detail_agent_siege.agent_ID = t_agent.matricule
INNER JOIN t_siege ON t_siege.code_sieg = detail_agent_siege.siege_ID

INNER JOIN detail_agent_societe ON detail_agent_societe.agent_ID = t_agent.matricule
INNER JOIN t_societe ON t_societe.code_soc = detail_agent_societe.societe_ID

INNER JOIN detail_agent_syndicat ON detail_agent_syndicat.agent_ID = t_agent.matricule
INNER JOIN t_syndicat ON t_syndicat.code_syndi = detail_agent_syndicat.syndicat_ID 

WHERE detail_agent_activ.statut_ID = 'act' AND detail_agent_direction.statut_ID = 'act' AND
detail_agent_fonction.statut_ID = 'act' AND detail_agent_grade.statut_ID = 'act' AND
detail_agent_siege.statut_ID = 'act' AND detail_agent_societe.statut_ID = 'act' AND
detail_agent_syndicat.statut_ID = 'act'

=========================================================================================
-- Pour voir tout les élements de la table pret ainsi que se table en rélation
CREATE VIEW v_info_pret AS SELECT 
t_pret.id_pret,t_pret.moisEpuration,t_pret.periodePret,t_pret.montantPreter,t_pret.solde,t_pret.montant_a_retenir,
t_pret.dateDebut_retenir,t_pret.taux_Interet,t_pret.creerPar,t_pret.modifierPar,t_pret.N_refPret,t_pret.dateModifier,t_pret.statut_ID,t_agent.matricule,
t_agent.nom_ag,t_agent.postnom_ag,t_agent.prenom_ag,t_pret.monnaie_ID,
t_codepaie.codePaie,t_codepaie.libelle_codePaie
FROM t_pret
INNER JOIN t_agent ON t_agent.matricule = t_pret.agent_ID
INNER JOIN t_codepaie ON t_codepaie.codePaie = t_pret.codePaie_ID
===================================================
$check = isset($_POST['test1']) ? "checked" : "unchecked";



==============
AFFICHE ANCIENNE FONCTION DANS CARRIERE
SELECT detail_agent_fonction.creerPar,detail_agent_fonction.modifierPar,t_fonction.libelleFonct
FROM detail_agent_fonction 
INNER JOIN t_fonction ON detail_agent_fonction.fonction_ID = t_fonction.codeFonct 
INNER JOIN t_agent ON detail_agent_fonction.agent_ID = t_agent.matricule
WHERE detail_agent_fonction.statut_ID = 'act' AND detail_agent_fonction.agent_ID = '04359'




<?php
// Chemin de l'image
$imagePath = 'chemin/vers/votre/image.jpg';

// Lire le contenu de l'image
$imageData = file_get_contents($imagePath);

// Convertir l'image en binaire
$binaryImage = base64_encode($imageData);

echo $binaryImage;
?>





