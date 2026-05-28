<?php
//session_start();
include_once('sys_connexion.php');

$Agent = '';
$nom_conj = '';
$postnom_conj = '';
$prenom_conj = '';
$lieu_naiss = '';
$date_naiss = '';
$lieu_mar = '';
$date_mar = '';
$sexe = '';
$Act_mar = '';
$creerPar = '';
$modifierPar = '';
$dateCreation = '';
$dateModif = '';
$nomComplets = '';

if (isset($_GET['id'])) {
    $id_conj = $_GET['id'];
    $req = $db->prepare('SELECT * FROM bdd_paie.t_conjoint inner join bdd_paie.t_agent on t_agent.matricule=t_conjoint.agent_ID 
WHERE id_conj  = :id_conj');
    $req->bindValue(':id_conj', $id_conj);
    $req->execute();
    while ($res = $req->fetch()) {
        $id_conj = $res['id_conj'];
        $nom_conj = $res['nom_conj'];
        $postnom_conj = $res['postnom_conj'];
        $prenom_conj = $res['prenom_conj'];
        $lieu_naiss = $res['lieu_naiss'];
        $date_naiss = $res['dateNaiss_conj'];
        $lieu_mar = $res['lieu_mariage'];
        $date_mar = $res['date_mariage'];
        $sexe = $res['sexe_conj'];
        $Act_mar = $res['fichier'];
        $creerPar = $res['creerPar'];
        $modifierPar = $res['modifierPar'];
        $dateCreation = $res['dateCreate'];
        $dateModif = $res['dateModif'];
        $matricule = $res['matricule'];
        $nomComplet_ag = $res['nom_ag'] . ' '
            . $res['postnom_ag'] . ' '
            . $res['prenom_ag'];
    }
}

?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var forms = document.querySelectorAll('form');
    forms.forEach(function(f){
        f.addEventListener('submit', function(e){
            if(!confirm('Voulez-vous modifier ?')){ e.preventDefault(); return false; }
        });
    });
});
</script>
<h3><i class="fa fa-angle-right"></i> Modification Conjoint(e)</h3>
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
            <form class="form-horizontal style-form" method="POST" action="update_conjoint.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Agent</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select"
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez un Agent" name="matric" required>
                                    <option value="<?php echo $matricule; ?>"> <?php echo $matricule . ' | ' . $nomComplet_ag; ?> </option>
                                    <?php
                                    $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent WHERE t_agent.activiter_ID=:activite');
                                    $reqGetMatriculeAgent->bindValue(':activite', "01");
                                    $reqGetMatriculeAgent->execute();
                                    while ($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()) {
                                        $matric = $resGetMatriculeAgent['matricule'];
                                        $nomComplet = $resGetMatriculeAgent['nom_ag'] . ' ' . $resGetMatriculeAgent['postnom_ag']; ?>
                                        <option value="<?php echo $matric; ?>"> <?php echo $matric . ' | ' . $nomComplet; ?> </option>
                                    <?php } ?>
                                </select>
                                <input type="hidden" class="form-control" name="id_conj" value="<?php echo $id_conj; ?>">
                                <input type="hidden" class="form-control" name="acte_naiss_byte" value="<?php echo  $Act_mar; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nom</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nom_conj" value="<?php echo $nom_conj; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">PostNom</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="postnom_conj" value="<?php echo $postnom_conj; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">PréNom</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="prenom_conj" value="<?php echo $prenom_conj; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sexe</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sexe_conj" required>
                                    <?php
                                    if ($sexe == "M") {
                                    ?>
                                        <option value="<?php echo $sexe ?>">M - Masculin</option>
                                    <?php
                                    } else { ?>
                                        <option value="<?php echo $sexe ?>">F - Feminin</option>
                                    <?php  } ?>
                                    <option value="M">M - Masculin</option>
                                    <option value="F">F - Feminin</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Lieu Naissance</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="lieu_naiss" value="<?php echo $lieu_naiss; ?>">
                            </div>
                        </div>


                    </div>

                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Naissance</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="date_naiss_conj" value="<?php echo $date_naiss; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Lieu Mariage</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="lieu_mariage" value="<?php echo $lieu_mar; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Mariage</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="date_mariage" value="<?php echo $date_mar; ?>">
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
                                    $nomComplets = $resGetNomUtilisateur['nom_ag'] . ' ' . $resGetNomUtilisateur['postnom_ag'] . ' ' . $resGetNomUtilisateur['prenom_ag'];
                                }
                                ?>
                                <input type="text" class="form-control" name="creerPar" value="<?php echo $nomComplets; ?>" readonly>
                            </div>
                        </div>



                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Le</label>
                            <div class="col-sm-8">
                                <input type="dateTime" class="form-control" value="<?php echo $dateCreation; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Acte De Mariage</label>
                            <div class="controls col-md-8">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <span class="btn btn-theme03 btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i>Modifier : <?php echo $Act_mar; ?></span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                        <input type="file" class="default" name="fich_act_mar" value="<?php echo $Act_mar; ?>" />
                                        <input type="hidden" class="default" name="fich_act_mar_Exist" value="<?php echo $Act_mar; ?>" />
                                    </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addAgent"
                                name="update_conjoint" style="margin-left:15px;width:150px;"><i class="fa fa-edit"></i>Modifier</button>
                            <a href="accueil.php?page=Voir_conjoint" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                            <!--a href="accueil.php?page=Voir_Enfant" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a-->
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
        <br><br>
    </div>
</div>