<?php
    //session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');
?>
<h3><i class="fa fa-angle-right"></i> Signalitique De l' Agent</h3>
<!-- BASIC FORM ELELEMNTS -->
<div class="row mt">
    <div class="col-lg-12">
        
        <div class="form-panel">
        <?php if (isset($_SESSION['message'])) {?>
            <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
              <button type="button" class="close" data-dismiss="alert">×</button>  
                <span><?php echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['typeMsg']); ?></span> 
            </div>
        <?php } ?>

            <form class="form-horizontal style-form" id="formSignalitique" action="add_agent.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="creerAgent" value="1">
                
                <div id="step1" class="form-step">
                    <h4 style="color: #0066cc;">Informations personnelles</h4>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Matricule</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="matric" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nom</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nom" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Postnom</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="postnom" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Prénom</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="prenom">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Sexe</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="sexe" required>
                                        <option value="">Choisir un sexe</option>
                                        <option value="M">M - Masculin</option>
                                        <option value="F">F - Feminin</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Etat Civil</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="etatCiv" required>
                                        <option value="">Choisir EtatCivil</option>
                                        <option value="C">Célibataire</option>
                                        <option value="M">Marié</option>
                                        <option value="D">Divorcé</option>
                                        <option value="V">Veuf|Veuve</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nbrs Enfs</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="nbrEnf">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Lieu Nais</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="pNaiss">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Date Nais</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" name="dateNaiss" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">P.Origine</label>
                                <div class="col-sm-8">
                                    <select class="form-control chzn-select" name="pOrigi" required>
                                        <option value=""> Choisir de la province </option>
                                        <?php
                                            $reqGetProvince = $db->prepare('SELECT code_prov,libelle_prov FROM bdd_paie.t_province');
                                            $reqGetProvince->execute();
                                            while($resGetProvince = $reqGetProvince->fetch()){
                                                $cod_prov = $resGetProvince['code_prov'];
                                                $lib_prov = $resGetProvince['libelle_prov']; ?>
                                            <option value="<?php echo $cod_prov;?>"> <?php echo $lib_prov;?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Niv d'Etude</label>
                                <div class="col-sm-8">
                                    <select class="form-control chzn-select" name="nivEtud" required>
                                        <option value="">Choisir Niveau d'étude</option>
                                        <?php
                                            $reqGetNivEtude = $db->prepare('SELECT id_niv_etud, libelle_niv_etud FROM bdd_paie.t_niv_etud');
                                            $reqGetNivEtude->execute();
                                            while($resGetNivEtude = $reqGetNivEtude->fetch()){
                                                $id_niv = $resGetNivEtude['id_niv_etud'];
                                                $lib_niv = $resGetNivEtude['libelle_niv_etud']; ?>
                                            <option value="<?php echo $id_niv;?>"><?php echo $lib_niv;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Adresse</label>
                                <div class="col-sm-8">
                                    <textarea type="text" class="form-control" rows="5" name="adress"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Phone</label>
                                <div class="col-sm-8">
                                    <input type="tel" class="form-control" name="phone">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="step2" class="form-step" style="display:none;">
                    <h4 style="color: #0066cc;">Informations professionnelles</h4>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-xl-4">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Société</label>
                                <div class="col-sm-8">
                                    <select required class="form-control chzn-select" name="societe">
                                        <option value=""> Choisir La Société </option>
                                        <?php
                                            $reqGetSociete = $db->prepare('SELECT code_soc,libelle_soc FROM bdd_paie.t_societe');
                                            $reqGetSociete->execute();
                                            while($resGetSociete = $reqGetSociete->fetch()){
                                                $cod_soc = $resGetSociete['code_soc'];
                                                $lib_soc = $resGetSociete['libelle_soc']; ?>
                                            <option value="<?php echo $cod_soc;?>"> <?php echo $cod_soc.' | '.$lib_soc;?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Grade</label>
                                <div class="col-sm-8">
                                    <select class="form-control chzn-select" name="grade" required>
                                        <option value=""> Choisir un Grade </option>
                                        <?php
                                            $reqGetGrade = $db->prepare('SELECT code_grade,libelle_grade FROM bdd_paie.t_grade');
                                            $reqGetGrade->execute();
                                            while($resGetGrade = $reqGetGrade->fetch()){
                                                $cod_gr = $resGetGrade['code_grade'];
                                                $lib_gr = $resGetGrade['libelle_grade']; ?>
                                            <option value="<?php echo $cod_gr?>"> <?php echo $cod_gr.' | '.$lib_gr;?> </option>
                                        <?php } ?> 
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Siège</label>
                                <div class="col-sm-8">
                                    <select class="form-control chzn-select" name="siege" required>
                                        <option value=""> Choisir du Siège </option>
                                        <?php
                                            $reqGetSiege = $db->prepare('SELECT code_sieg,libelle_sieg FROM bdd_paie.t_siege');
                                            $reqGetSiege->execute();
                                            while($resGetSiege = $reqGetSiege->fetch()){
                                                $cod_sieg = $resGetSiege['code_sieg'];
                                                $lib_sieg = $resGetSiege['libelle_sieg']; ?>
                                            <option value="<?php echo(trim($cod_sieg))?>"> <?php echo $cod_sieg.' | '.$lib_sieg;?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Direction</label>
                                <div class="col-sm-8">
                                    <select class="form-control chzn-select" name="dir" required>
                                        <option > Choisir Direction </option>
                                        <?php
                                            $reqGetDirection = $db->prepare('SELECT code_dir,libelle_dir FROM bdd_paie.t_direction');
                                            $reqGetDirection->execute();
                                            while($resGetDirection = $reqGetDirection->fetch()){
                                                $cod_dir = $resGetDirection['code_dir']; 
                                                $lib_dir = $resGetDirection['libelle_dir'];?>
                                            <option value="<?php echo $cod_dir;?>"> <?php echo $lib_dir;?> </option>
                                        <?php } ?>   
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Fonction</label>
                                <div class="col-sm-8">
                                    <select class="form-control chzn-select" name="fonct" required>
                                        <option value=""> Choisir une Fonction </option>
                                        <?php
                                            $reqGetFonction = $db->prepare('SELECT codeFonct,libelleFonct FROM bdd_paie.t_fonction');
                                            $reqGetFonction->execute();
                                            while($resGetFonction = $reqGetFonction->fetch()){
                                                $cod_fonct = $resGetFonction['codeFonct']; 
                                                $lib_fonct = $resGetFonction['libelleFonct'];?>
                                            <option value="<?php echo(trim($cod_fonct))?>"> <?php echo $cod_fonct.' | '.$lib_fonct;?> </option>
                                        <?php } ?>  
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Activité</label>
                                <div class="col-sm-8">
                                    <select class="form-control chzn-select" name="activ" required>
                                        <option value=""> Choisir l'Activiter </option>
                                        <?php
                                            $reqGetActiviter = $db->prepare('SELECT code_activ,libelle_activ FROM bdd_paie.t_activite');
                                            $reqGetActiviter->execute();
                                            while($resGetActiviter = $reqGetActiviter->fetch()){
                                                $cod_activ = $resGetActiviter['code_activ']; 
                                                $lib_activ = $resGetActiviter['libelle_activ'];?>
                                            <option value="<?php echo $cod_activ;?>"> <?php echo validation_donnees($lib_activ);?> </option>
                                        <?php } ?>  
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-xl-4">
                           
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Syndicat</label>
                                <div class="col-sm-8">
                                    <select class="form-control chzn-select" name="syndi" required>
                                        <option value=""> Choisir le syndicat </option>
                                        <?php
                                            $reqGetSyndicat = $db->prepare('SELECT code_syndi,libelle_syndi FROM bdd_paie.t_syndicat');
                                            $reqGetSyndicat->execute();
                                            while($resGetSyndicat = $reqGetSyndicat->fetch()){
                                                $cod_syndi = $resGetSyndicat['code_syndi'];
                                                $lib_syndi = $resGetSyndicat['libelle_syndi'];  ?>
                                            <option value="<?php echo $cod_syndi;?>"> <?php echo $lib_syndi;?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Date Engag</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control" name="dateEngag" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">N° CNSS</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nCNSS" >
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">N°Compte</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nCompte" >
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-sm-3 control-label">Indice Carburant</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="indCarbu" required>
                                        <option value="">Choisir Indice</option>
                                        <option value="0">Non - Carburant</option>
                                        <option value="1">Oui - Carburant</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-4 col-xl-4">
                             <div class="form-group last">
                                <label class="control-label col-md-3">Image</label>
                                <div class="col-md-9">
                                    <div class="fileupload fileupload-new" data-provides="fileupload">
                                        <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt="" />
                                        </div>
                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                        <div>
                                            <span class="btn btn-theme03 btn-file">
                                                <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                                <input type="file" class="default" name="photo_ag" accept="image/png, image/jpg,image/jpeg">
                                            </span>
                                            <a href="advanced_form_components.html#" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Indice Voiture</label>
                                <div class="col-sm-8">
                                    <select class="form-control chzn-select" name="indVoiture" required>
                                        <option value="">Choisir l'indice</option>
                                        <option value="1">Avec Véhicule</option>
                                        <option value="0">Sans Véhicule</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-lg-12 text-center">
                        <button type="button" class="btn btn-round btn-default" id="prevBtn" onclick="nextPrev(-1)" style="display:none;margin-right:10px;">Précédent</button>
                        <button type="button" class="btn btn-round btn-primary" id="nextBtn" onclick="nextPrev(1)" style="margin-right:10px;">Suivant</button>
                        <input type="submit" class="btn btn-round btn-success" id="btnCreerAgent" value="Créer" name="creerAgent" style="display:none;margin-right:10px;width:150px;">
                        <a href="accueil.php?page=Voir_Agent" class="btn btn-round btn-warning" style="margin-left:10px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</div>

<script>
var currentStep = 0;

function showStep(n) {
    var steps = document.getElementsByClassName('form-step');
    for (var i = 0; i < steps.length; i++) {
        steps[i].style.display = 'none';
    }
    steps[n].style.display = 'block';
    document.getElementById('prevBtn').style.display = n === 0 ? 'none' : 'inline-block';
    if (n === steps.length - 1) {
        document.getElementById('nextBtn').style.display = 'none';
        document.getElementById('btnCreerAgent').style.display = 'inline-block';
    } else {
        document.getElementById('nextBtn').style.display = 'inline-block';
        document.getElementById('btnCreerAgent').style.display = 'none';
    }
}

function nextPrev(n) {
    if (!validateForm()) {
        return;
    }
    var steps = document.getElementsByClassName('form-step');
    currentStep += n;
    if (currentStep >= steps.length) {
        currentStep = steps.length - 1;
    }
    if (currentStep < 0) {
        currentStep = 0;
    }
    showStep(currentStep);
}

function validateForm() {
    var steps = document.getElementsByClassName('form-step');
    var inputs = steps[currentStep].querySelectorAll('input, select, textarea');
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].hasAttribute('required') && inputs[i].value === '') {
            alert('Veuillez remplir tous les champs obligatoires');
            inputs[i].focus();
            return false;
        }
    }
    return true;
}

document.addEventListener("DOMContentLoaded", function () {
    $(".chzn-select").chosen({width: "100%"});
    showStep(currentStep);
});
</script>
