?>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var form = document.querySelector('form.form-horizontal'); if(!form) return;
    
});
</script>
<h3><i class="fa fa-angle-right"></i> Modifier Stagiaire</h3>
    $dir = '';
    $dateFin = '';
    $dateFin = '';
    $histo = '';
    $creerPar = '';
    $modifierPar = '';
    $statut = '';
    $phone = '';
    $adresse = '';
    $pOrigin = '';
    $pNaiss_stg = '';
    
    $nomPhoto = '';
    $photoBinaire = '';
    $nomDoc = '';
    $documentBinaire = '';

    if(isset($_GET['id_stg'])){
        $id_stg = $_GET['id_stg'];
        $req = $db->prepare('SELECT * FROM bdd_paie.t_stagiare WHERE id_stg = :id_stg');
        $req->bindValue(':id_stg',$id_stg);
        $req->execute();
        while ($res = $req->fetch()) {
            $id_stg = $res['id_stg'];
            $nom = $res['nom_stg'];
            $postnom = $res['postnom_stg'];
            $prenom = $res['prenom_stg'];
            $sexe = $res['sexe_stg'];
            $etatCiv = $res['etatCiv_stg'];
            $nivEtude = $res['nivEtude_stg'];
            $siege = $res['siege_stg'];
            $dir = $res['dir_stg'];
            $dateFin = $res['dateFin_stg'];
            $dateDebut_stg = $res['dateDebut_stage'];
            $dateNaiss = $res['dateNaiss'];
            $histo = $res['histo_stg'];
            $creerPar = $res['creerPar'];
            $modifierPar = $res['modifierPar'];
            $statut = $res['statut_ID'];
            $phone = $res['phone_stg'];
            $adresse = $res['adresse_stg'];
            $pOrigin = $res['pOrigi_stg'];
            $pNaiss_stg = $res['pNaiss_stg']; 
            $nomPhoto = $res['photo_stg'];
            $photoBinaire = $res['photo_byte_stg'];
            $nomDoc = $res['document'];
            $documentBinaire = $res['document_byte'];
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
            <form class="form-horizontal style-form" action="update_stagiaire.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                
                    <div class="col-lg-4 col-md-4 col-xl-4">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nom</label>
                            <div class="col-sm-8">
                                <input type="text" value="<?php echo $nom;?>" class="form-control" name="nom_stg" required>
                                <input type="hidden" value="<?php echo $id_stg;?>" class="form-control" name="id_stg">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Postnom</label>
                            <div class="col-sm-8">
                                <input type="text" value="<?php echo $postnom;?>" class="form-control" name="postnom_stg" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Prénom</label>
                            <div class="col-sm-8">
                                <input type="text" value="<?php echo $prenom;?>" class="form-control" name="prenom_stg">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sexe</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sexe_stg" required>
                                    <option value="<?php echo ($sexe == "M")?"M":"F";?>"> <?php echo ($sexe == "M")?"M - Masculin":"F - Féminin";?> </option>
                                    <option value="<?php echo ($sexe != "M")?"M":"F";?>"> <?php echo ($sexe != "M")?"M - Masculin":"F - Féminin";?> </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Etat Civil</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="etatCiv_stg" required>
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
                            <label class="col-sm-3 control-label">Niv d'Etude</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" name="nivEtude_stg" required>
                                    <option value="<?php echo $nivEtude;?>"> <?php echo $nivEtude;?> </option>
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

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                            <?php 
                                if($creerPar == "sysAdmin"){
                                ?>
                                <input type="text" value="<?php echo $creerPar;?>" class="form-control" readonly>
                                <?php 
                                }else{
                                $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                                WHERE id_user = :creerPar');
                                $reqGetInfoUser->bindValue(':creerPar',$creerPar);
                                $reqGetInfoUser->execute();
                                while ($resGetInfoUser = $reqGetInfoUser->fetch()) {
                                    $nom_postnom = $resGetInfoUser['nom_ag'].' '.$resGetInfoUser['postnom_ag'];
                                    $prenom = ucfirst(strtolower($resGetInfoUser['prenom_ag']));
                                    $nomComplet = $nom_postnom.' '.$prenom;
                                }?>
                                <input type="text" value="<?php echo $nomComplet;?>" class="form-control" readonly>
                            <?php } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                            <?php 
                                if($modifierPar == "sysAdmin"){
                                ?>
                                <input type="text" value="<?php echo $modifierPar;?>" class="form-control" readonly>
                                <?php 
                                }else{
                                $reqGetInfoUser = $db->prepare('SELECT nom_ag,postnom_ag,prenom_ag FROM bdd_paie.v_liste_utilisateur 
                                WHERE id_user = :modifierPar');
                                $reqGetInfoUser->bindValue(':modifierPar',$modifierPar);
                                $reqGetInfoUser->execute();
                                while ($resGetInfoUser = $reqGetInfoUser->fetch()) {
                                    $nom_postnom = $resGetInfoUser['nom_ag'].' '.$resGetInfoUser['postnom_ag'];
                                    $prenom = ucfirst(strtolower($resGetInfoUser['prenom_ag']));
                                    $nomComplet = $nom_postnom.' '.$prenom;
                                }?>
                                <input type="text" value="<?php echo $nomComplet;?>" class="form-control" readonly>
                            <?php } ?>
                                
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
                                    <option value="<?php echo $siege;?>"> <?php echo $siege;?> </option>
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
                                    <option value="<?php echo $dir;?>"> <?php echo $dir;?> </option>
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
                                    <option value="<?php echo $pOrigin;?>"> <?php echo $pOrigin;?> </option>
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
                                    <option value="<?php echo $pNaiss_stg;?>"> <?php echo $pNaiss_stg;?> </option>
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
                                <input type="date" value="<?php echo $dateNaiss;?>" class="form-control" name="dateNaiss_stg" required>
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Début</label>
                            <div class="col-md-8">
                                <input type="date" value="<?php echo $dateDebut_stg;?>" class="form-control" name="dateDebut_stg" required readonly> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date Fin</label>
                            <div class="col-md-8">
                                <input type="date" value="<?php echo $dateFin;?>" class="form-control" name="dateFin_stg" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Statut</label>
                            <div class="col-sm-2 text-center">
                                <select class="form-control" name="statut" style="width: auto;" readonly>
                                    <option value="<?php echo ($statut == "act") ?"act":"desac";?>"> <?php echo ($statut=="act")?"Activer":"Désactiver";?></option>
                                    <option value="<?php echo ($statut != "act") ?"act":"desac";?>"> <?php echo ($statut=="act")?"Désactiver":"Activer";?></option>
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
                                    <img src="photoStagiaire/<?php echo $nomPhoto;?>" alt="" />
                                </div>
                                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                <div>
                                    <span class="btn btn-theme03 btn-file">
                                    <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                                    <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                        <input type="file" class="default" name="photo_stg"/>
                                        <input type="hidden" class="default" name="ancienne_photo" value="<?php echo $nomPhoto;?>">
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
                                        <input type="file" class="default" name="Fdoc" >
                                        <input type="hidden" class="default" name="ancienFdoc" value="<?php echo $nomDoc;?>">
                                    </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"> <?php echo $nomDoc;?> </span>
                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Phone</label>
                            <div class="col-sm-8">
                                <input type="tel" value="<?php echo $phone;?>" class="col-sm-3 form-control" name="phone_stg">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Adresse</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" rows="5" name="adresse_stg">
                                    <?php echo $adresse;?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Historique</label>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" rows="5" name="histo_stg" readonly>
                                    <?php echo $histo;?>
                                </textarea>
                            </div>
                        </div>

                    </div>
                
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="form-group">
                            <input type="submit" class="btn btn-round btn-primary col-sm-3" value="Modifier" name="ModifStg" style="margin-left:15px;width:150px;">
                            <a href="accueil.php?page=Voir_Stagiaire" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        </div>
                    </div>
                </div>
            </form>
            <?php include_once('confirm_modify_modal.php'); ?>
        </div>
        
    </div>
</div>
          
            