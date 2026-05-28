<?php
//session_start();
include_once('sys_connexion.php');
include_once('sys_fonction.php');
$code_gr = "";
$libelle_gr = "";
$eqPaie = "";
$eqCompt = "";
$creerPar = "";
$date_creat = "";
$modifierPar = "";
$dateModif = "";
$statut = "";
if (isset($_GET['code_enfant'])) {
    $code_enf = $_GET['code_enfant'];
    $reqInfoEnfant = $db->prepare("SELECT 
            t_enfants_agent.id_enf,t_enfants_agent.agent_ID,t_enfants_agent.nom_enf,t_enfants_agent.postnom_enf,
            t_enfants_agent.postnom_enf,t_enfants_agent.prenom_enf,t_enfants_agent.sexe_enf,t_enfants_agent.lien_filiation,t_enfants_agent.creerPar,
            t_enfants_agent.dateCreate,t_enfants_agent.modifierPar,t_enfants_agent.dateModif,t_enfants_agent.lieu_naiss,t_enfants_agent.dateNaiss_enf,
            t_enfants_agent.statut_ID,t_enfants_agent.fichier,t_enfants_agent.fichier_byte,t_agent.matricule,t_agent.nom_ag,t_agent.postnom_ag,t_agent.prenom_ag
            FROM bdd_paie.t_enfants_agent 
            INNER JOIN bdd_paie.t_agent ON t_enfants_agent.agent_ID = t_agent.matricule
            WHERE id_enf = :id_enf");
    $reqInfoEnfant->bindvalue(':id_enf', $code_enf);
    $reqInfoEnfant->execute();

    while ($resInfoEnfant = $reqInfoEnfant->fetch()) {
        $code_enf = $resInfoEnfant['id_enf'];
        $matricule = $resInfoEnfant['matricule'];
        $nomComplet_ag = $resInfoEnfant['nom_ag'] . ' '
            . $resInfoEnfant['postnom_ag'] . ' '
            . $resInfoEnfant['prenom_ag'];

        $nom = $resInfoEnfant['nom_enf'];
        $postnom = $resInfoEnfant['postnom_enf'];
        $prenom = $resInfoEnfant['prenom_enf'];
        $sexe = $resInfoEnfant['sexe_enf'];
        $lien = $resInfoEnfant['lien_filiation'];
        $acte_naiss = $resInfoEnfant['fichier']; //"fichierEnf_Agent/".
        $acte_naiss_byte = $resInfoEnfant['fichier'];
        $date_naiss = $resInfoEnfant['dateNaiss_enf'];
        $creerPar = $resInfoEnfant['creerPar'];
        $date_creat = $resInfoEnfant['dateCreate'];
        $modifierPar = $resInfoEnfant['modifierPar'];
        $dateModif = $resInfoEnfant['dateModif'];
        $statut = $resInfoEnfant['statut_ID'];
        $lieu_naiss = $resInfoEnfant['lieu_naiss'];
    }
}
?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
});
</script>
<h3><i class="fa fa-angle-right"></i> Modifier Enfant</h3>
<!-- BASIC FORM ELELEMNTS -->

<div class="row mt">
    <div class="col-lg-12">

        <div class="form-panel">
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?php echo ($_SESSION['typeMsg']); ?>">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <span><?php echo $_SESSION['message'];
                            unset($_SESSION['message']);
                            unset($_SESSION['typeMsg']); ?></span>
                </div>
            <?php } ?>
            <form class="form-horizontal style-form" method="POST" action="update_enfant.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Agent</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select"
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez un Agent" name="matric" required>
                                    <option value="<?php echo $matricule; ?>"> <?php echo $matricule . ' | ' . $nomComplet_ag; ?> </option>
                                    <?php
                                    $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent WHERE sexe_ag = :sexe_ag');
                                    $reqGetMatriculeAgent->bindValue(':sexe_ag', "M");
                                    $reqGetMatriculeAgent->execute();
                                    while ($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()) {
                                        $matric = $resGetMatriculeAgent['matricule'];
                                        $nomComplet = $resGetMatriculeAgent['nom_ag'] . ' ' . $resGetMatriculeAgent['postnom_ag']; ?>
                                        <option value="<?php echo $matric; ?>"> <?php echo $matric . ' | ' . $nomComplet; ?> </option>
                                    <?php } ?>
                                </select>
                                <input type="hidden" class="form-control" name="id_enf" value="<?php echo $code_enf; ?>">
                                <input type="hidden" class="form-control" name="acte_naiss_byte" value="<?php echo $acte_naiss_byte; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nom Enfant</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nom_enf" value="<?php echo $nom; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">PostNom Enfant</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="postnom_enf" value="<?php echo $postnom; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">PréNom Enfant</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="prenom_enf" value="<?php echo $prenom; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sexe Enfant</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sexe" required>
                                    <option value="<?php echo ($sexe == "M") ? "M" : "F"; ?>"> <?php echo ($sexe == "M") ? "M - Masculin" : "F - Féminin"; ?> </option>
                                    <option value="<?php echo ($sexe != "M") ? "M" : "F"; ?>"> <?php echo ($sexe != "M") ? "M - Masculin" : "F - Féminin"; ?> </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Lieu de Naissance</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="lieu_naiss" value="<?php echo $lieu_naiss; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Naissance</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="date_naiss_enf" value="<?php echo $date_naiss; ?>">
                            </div>
                        </div>



                    </div>

                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Lien de filiation</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" data-placeholder="Selectionnez un lien" name="lien" required>
                                    <option><?php echo $lien; ?></option>
                                    <option>Enfant legitime </option>
                                    <option>Enfant Adoptif </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Acte De Naissance</label>
                            <div class="controls col-md-8">
                               
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <span class="btn btn-theme03 btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Modifier : <?php echo $acte_naiss; ?></span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                        <input type="file" class="default" name="fich_act_nais" />
                                        <input type="hidden" class="default" name="fich_act_nais_Exist" value="<?php echo $acte_naiss; ?>" />
                                    </span>
                                     
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                                <?php
                                $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                                $reqGetNomUtilisateur->bindvalue(':id_user', $creerPar);
                                $reqGetNomUtilisateur->execute();
                                while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                                    $nomComplet = $resGetNomUtilisateur['nom_ag'] . ' ' . $resGetNomUtilisateur['postnom_ag'] . ' ' . $resGetNomUtilisateur['prenom_ag'];
                                }
                                ?>
                                <input type="text" class="form-control" name="creerPar" value="<?php echo $nomComplet; ?>" readonly>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Le</label>
                            <div class="col-sm-8">
                                <input type="dateTime" class="form-control" value="<?php echo $date_creat; ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <?php
                                if ($modifierPar == "sysAdmin") {
                                ?>
                                    <input type="text" value="<?php echo $modifierPar; ?>" class="form-control" readonly>
                                <?php
                                } else {
                                    $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                                WHERE id_user = :modifierPar');
                                    $reqGetInfoUser->bindValue(':modifierPar', $modifierPar);
                                    $reqGetInfoUser->execute();
                                    while ($resGetInfoUser = $reqGetInfoUser->fetch()) {
                                        $nom_postnom = $resGetInfoUser['nom_ag'] . ' ' . $resGetInfoUser['postnom_ag'];
                                        $prenom = ucfirst(strtolower($resGetInfoUser['prenom_ag']));
                                        $nomComplet = $nom_postnom . ' ' . $prenom;
                                    } ?>
                                    <input type="text" value="<?php echo $nomComplet; ?>" class="form-control" readonly>
                                <?php } ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Le</label>
                            <div class="col-sm-8">
                                <input type="dateTime" class="form-control" value="<?php echo $dateModif; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Statut</label>
                            <div class="col-sm-2 text-center">
                                <input type="checkbox" name="statutCode"
                                    <?php echo ($statut == "act") ? "checked" : "unchecked"; ?> data-toggle="switch" />
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Equipe Compt</label>
                            <div class="col-sm-8">
                                <select name="eqCompt" class="form-control">
                                    <option value="0">Choix Equipe</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div-->

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addAgent"
                                name="update_enfant" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i> Modifier</button>
                            <a href="accueil.php?page=Voir_Enfant_for_modif" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</div>