?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
});
</script>
<h3><i class="fa fa-angle-right"></i> Modifier Signalitique</h3>
            $postnom = $resInfoAgent['postnom_ag'];
            $prenom = $resInfoAgent['prenom_ag'];
            $sexe = $resInfoAgent['sexe_ag'];
            $nCNSS = $resInfoAgent['NumCNSS_ag'];
            $logemnt = $resInfoAgent['ind_logement_ag'];
            $dateEngag = $resInfoAgent['dateEngagemnt_ag'];
            $dateNaiss = $resInfoAgent['dateNaiss_ag'];
            $provOrigi = $resInfoAgent['provOrig'];
            $cod_naiss = $resInfoAgent['provNaiss'];
            $indCarbu = $resInfoAgent['indiceCarburant'];
            $indVoiture = $resInfoAgent['indiceVoiture'];
            $nivEtude = $resInfoAgent['NivEtude_ag'];
            $creerPar = $resInfoAgent['creerPar'];
            $modifierPar = $resInfoAgent['modifierPar'];
            $numCompte = $resInfoAgent['NumCompt'];
            $etatCiv = $resInfoAgent['etatCiv_ag'];
            $cod_activ = $resInfoAgent['code_activ'];
            $lib_activ = $resInfoAgent['libelle_activ'];
            $cod_dir = $resInfoAgent['code_dir'];
            $lib_dir = $resInfoAgent['libelle_dir'];
            $cod_grade = $resInfoAgent['code_grade'];
            $lib_grade = $resInfoAgent['libelle_grade'];
            $cod_soc = $resInfoAgent['code_soc'];
            $lib_soc = $resInfoAgent['libelle_soc'];
            $cod_syndi = $resInfoAgent['code_syndi'];
            $lib_syndi = $resInfoAgent['libelle_syndi'];
            $cod_fonct = $resInfoAgent['codeFonct'];
            $lib_fonct = $resInfoAgent['libelleFonct'];
            $cod_sieg = $resInfoAgent['code_sieg'];
            $lib_sieg = $resInfoAgent['libelle_sieg'];
            $nbrEnf = $resInfoAgent['nbreEnfant_ag'];

            $nomPhoto = $resInfoAgent['photo'];
            $photoBinaire = $resInfoAgent['photo_byte'];
            
        }
    }
    
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
            <form class="form-horizontal style-form" action="add_agentss.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                
                    <div class="col-lg-4 col-md-4 col-xl-4">
                        

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $matric;?>" name="matric" required>
                                <input type="hidden" value="<?php echo $matric;?>" name="lastMatric">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nom</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $nom;?>" name="nom" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Postnom</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $postnom;?>" name="postnom" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Prénom</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $prenom;?>" name="prenom">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sexe</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sexe" required>
                                    <option value="<?php echo ($sexe == "M")?"M":"F";?>"> <?php echo ($indCarbu == "M")?"M - Masculin":"F - Féminin";?> </option>
                                    <option value="<?php echo ($sexe != "M")?"M":"F";?>"> <?php echo ($indCarbu != "M")?"M - Masculin":"F - Féminin";?> </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Etat Civil</label>
                            <div class="col-sm-8">
                            <select class="form-control" name="etatCiv" required>
                                    <?php 
                                    switch ($etatCiv) {
                                        case 'C':?>
                                            <option value="C"> Célibataire </option>
                                            <option value="M">Marié</option>
                                            <option value="D">Divorcé</option>
                                            <option value="V">Veuf|Veuve</option>
                                        <?php    break;
                                        case 'M':?>
                                            <option value="M"> Marié </option>
                                            <option value="C">Célibataire</option>
                                            <option value="D">Divorcé</option>
                                            <option value="V">Veuf|Veuve</option>
                                        <?php    break;
                                        case 'D':?>
                                            <option value="D">Divorcé </option>
                                            <option value="C">Célibataire</option>
                                            <option value="M">Marié</option>
                                            <option value="V">Veuf|Veuve</option>
                                        <?php    break;
                                        case 'V':?>
                                            <option value="V">Veuf|Veuve </option>
                                            <option value="C">Célibataire</option>
                                            <option value="D">Divorcé</option>
                                            <option value="M">Marié</option>
                                        <?php    break;
                                    }?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Nais</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo $dateEngag;?>" name="dateEngag" required>
                            </div>
                            
                        </div>

                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">N° CNSS</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $nCNSS;?>" name="nCNSS">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Niv d'Etude</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $nivEtude;?>" name="nivEtud" required>
                            </div>
                        </div>
                        
                    </div>

                    <div class="col-lg-4 col-md-4 col-xl-4">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Société</label>
                            <div class="col-sm-8">
                                <select required class="form-control chzn-select" name="societe">
                                    <option value="<?php echo $cod_soc;?>"> <?php echo $lib_soc;?> </option>
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
                                <option value="<?php echo $cod_grade;?>"> <?php echo $cod_grade.' | '.$lib_grade;?> </option>
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
                                    <option value="<?php echo $cod_sieg;?>"> <?php echo $lib_sieg;?> </option>
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
                                    <option value="<?php echo $cod_dir;?>"> <?php echo $lib_dir;?> </option>
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
                            <label class="col-sm-3 control-label">Activité</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="activ" required>
                                    <option value="<?php echo $cod_activ;?>"> <?php echo $lib_activ;?> </option>
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

                        <div class="form-group">
                            <label class="col-sm-3 control-label">P.Origine</label>
                            <div class="col-sm-8">
                            <select class="form-control chzn-select" name="pOrigi" required>
                                    <?php
                                        $reqGetNomProvince = $db->prepare('SELECT * FROM bdd_paie.t_province WHERE code_prov = :code_prov');
                                        $reqGetNomProvince->bindValue(':code_prov',$provOrigi);
                                        $reqGetNomProvince->execute();
                                        while($resGetNomProvince = $reqGetNomProvince->fetch()){
                                            $lib_prov = $resGetNomProvince['libelle_prov'];?>
                                        <option value="<?php echo $provOrigi;?>"> <?php echo $lib_prov;?> </option>
                                    <?php } ?>
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
                            <label class="col-sm-3 control-label">Fonction</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="fonct" required>
                                <option value="<?php echo $cod_fonct;?>"> <?php echo $lib_fonct;?> </option>
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
                            <label class="col-sm-3 control-label">Syndicat</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="pNaiss" required>
                                    <option value=""> Choisir le syndicat </option>
                                    <?php
                                        $reqGetProvince = $db->prepare('SELECT code_syndi,libelle_syndi FROM bdd_paie.t_syndicat');
                                        $reqGetProvince->execute();
                                        while($resGetProvince = $reqGetProvince->fetch()){
                                            $cod_prov = $resGetProvince['code_syndi'];
                                            $lib_prov = $resGetProvince['libelle_syndi']; ?>
                                        <option value="<?php echo $cod_prov;?>"> <?php echo $lib_prov;?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Lieu Nais</label>
                            <div class="col-sm-8">
                            <select class="form-control chzn-select" name="pNaiss" required>
                                <?php
                                        $reqGetNomProvince = $db->prepare('SELECT * FROM bdd_paie.t_province WHERE code_prov = :code_prov');
                                        $reqGetNomProvince->bindValue(':code_prov',$provOrigi);
                                        $reqGetNomProvince->execute();
                                        while($resGetNomProvince = $reqGetNomProvince->fetch()){
                                            $lib_prov = $resGetNomProvince['libelle_prov'];?>
                                        <option value="<?php echo $provOrigi;?>"> <?php echo $lib_prov;?> </option>
                                    <?php } ?>
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
                            <label class="col-sm-3 control-label">Indice Voiture</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="indVoiture" required>
                                    <option value="<?php echo ($indVoiture == 0)?"0":"1";?>"> <?php echo ($indVoiture == 0)?"Sans Véhicule":"Avec Véhicule";?> </option>
                                    <option value="<?php echo ($indVoiture != 0)?"0":"1";?>"> <?php echo ($indVoiture != 0)?"Sans Véhicule":"Avec Véhicule";?> </option>
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
                                    <img src="photoAgent/<?php echo $nomPhoto;?>" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-theme03 btn-file">
                                    <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                    <input type="file" class="default" name="photo_ag" value="<?php echo $nomPhoto;?>">
                                    <input type="hidden" class="default" name="ancienne_photo" value="<?php echo $nomPhoto;?>">
                                    </span>
                                    <a href="advanced_form_components.html#" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Engag</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" value="<?php echo $dateNaiss;?>" name="dateNaiss" required>
                            </div>
                        </div>
                        

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Enfant</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" value="<?php echo $nbrEnf;?>" name="nbrEnf" required>
                                <!--select class="form-control" name="nbrEnf" required>
                                    <option value="">Choisir</option>
                                    <option value="1">Avec Enfant</option>
                                    <option value="0">Sans Enfant</option>
                                </select-->
                            </div>
                                
                            
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Logement</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="logemnt">
                                    <option value="<?php echo ($logemnt == 0)?"1":"0";?>"> <?php echo ($logemnt == 0)?"Par Cadeco":"Personnel";?> </option>
                                    <option value="<?php echo ($logemnt != 0)?"1":"0";?>"> <?php echo ($logemnt != 0)?"Par Cadeco":"Personnel";?> </option>
                                </select>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Indice Carburant</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="indCarbu" required>
                                    <option value="<?php echo ($indCarbu == 0)?"0":"1";?>"> <?php echo ($indCarbu == 0)?"Non - Carburant":"Oui - Carburant";?> </option>
                                    <option value="<?php echo ($indCarbu != 0)?"0":"1";?>"> <?php echo ($indCarbu != 0)?"Non - Carburant":"Oui - Carburant";?> </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">N°Compte</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nCompte" required>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Date Engagement</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control">
                            </div>
                        </div-->

                    </div>
                
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Créer" name="creerAgent" style="margin-left:15px;width:150px;">
                            <a href="accueil.php?page=Voir_Agent" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
            </form>
            <?php include_once('confirm_modify_modal.php'); ?>
        </div>
        
    </div>
</div>
          
            