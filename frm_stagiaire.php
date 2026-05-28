<?php
    //session_start();
    include_once('sys_connexion.php');
    include_once('sys_fonction.php');
?>
<h3><i class="fa fa-angle-right"></i> Stagiaires</h3>
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
            <form class="form-horizontal style-form" action="add_stagiaire.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                
                    <div class="col-lg-4 col-md-4 col-xl-4">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nom</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nom_stg" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Postnom</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="postnom_stg" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Prénom</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="prenom_stg">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sexe</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sexe_stg" required>
                                    <option value="">Choisir un sexe</option>
                                    <option value="M">M - Masculin</option>
                                    <option value="F">F - Feminin</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Etat Civil</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="etatCiv_stg" required>
                                    <option value="">Choisir EtatCivil</option>
                                    <option value="C">Célibataire</option>
                                    <option value="M">Marié</option>
                                    <option value="D">Divorcé</option>
                                    <option value="V">Veuf|Veuve</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Niv d'Etude</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="nivEtude_stg" required>
                                    <option > Choisir Direction </option>
                                    <?php
                                        $reqGetDirection = $db->prepare('SELECT id_niv_etud,libelle_niv_etud FROM bdd_paie.t_niv_etud WHERE statut_ID=:statut');
                                        $reqGetDirection->bindValue(':statut',"act");
                                        $reqGetDirection->execute();
                                        while($resGetDirection = $reqGetDirection->fetch()){
                                            $cod_dir = $resGetDirection['id_niv_etud']; 
                                            $lib_dir = $resGetDirection['libelle_niv_etud'];?>
                                        <option value="<?php echo $cod_dir;?>"> <?php echo $lib_dir;?> </option>
                                    <?php } ?>   
                                </select>
                                <!--input type="text" class="form-control" name="nivEtude_stg" required-->
                            </div>
                        </div>

                        
                    </div>

                    <div class="col-lg-4 col-md-4 col-xl-4">
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Société</label>
                            <div class="col-sm-8">
                            <select required class="form-control chzn-select" name="societe">
                                    <option value=""> Choisir La Société </option>
                                    <?php   /*
                                        $reqGetSociete = $db->prepare('SELECT code_soc,libelle_soc FROM bdd_paie.t_societe');
                                        $reqGetSociete->execute();
                                        while($resGetSociete = $reqGetSociete->fetch()){
                                            $cod_soc = $resGetSociete['code_soc'];
                                            $lib_soc = $resGetSociete['libelle_soc']; ?>
                                        <option value="<?php echo $cod_soc;?>"> <?php echo $cod_soc.' | '.$lib_soc;?> </option>
                                    <?php } */ ?>
                                </select>
                                
                            </div>
                        </div-->
                                            
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Siège</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="siege_stg" required>
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
                                <select class="form-control chzn-select" name="dir_stg" required>
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
                            <label class="col-sm-3 control-label">P.Origine</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="pOrigi_stg" required>
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
                            <label class="col-sm-3 control-label">Lieu Nais</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="pNaiss_stg" required>
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
                            <label class="col-sm-3 control-label">Date Nais</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="dateNaiss_stg" required>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Début</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="dateDebut_stg" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Fin</label>
                            <div class="col-md-8">
                                <input type="date" class="form-control" name="dateFin_stg" required>
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
                                    <input type="file" class="default" name="photo_stg" accept="image/png, image/jpg,image/jpeg">
                                    </span>
                                    <a href="advanced_form_components.html#" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                                </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                                <label class="control-label col-md-3">Document</label>
                            <div class="controls col-md-9">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <span class="btn btn-theme03 btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select file</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="Fdoc">
                                    </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Phone</label>
                            <div class="col-sm-8">
                                <input type="tel" class="col-sm-3 form-control" name="phone_stg">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Adresse</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" rows="5" name="adresse_stg"></textarea>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Historique</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" rows="5" name="histo_stg"></textarea>
                            </div>
                        </div-->

                    </div>
                
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Créer" name="creerStg" style="margin-left:15px;width:150px;">
                            <a href="accueil.php?page=Voir_Stagiaire" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</div>
          
            