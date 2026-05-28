<?php
    //session_start();
    include_once('sys_connexion.php');
?>
<h3><i class="fa fa-angle-right"></i> Ajout Document</h3>
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
            <form class="form-horizontal style-form" method="POST" action="add_document_ag.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez un Agent"name="matric" required>
                                    <option></option>
                                        <?php
                                            $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent WHERE activiter_ID = :activiter_ID');
                                            //$reqGetMatriculeAgent->bindValue(':sexe_ag',"M");sexe_ag = :sexe_ag AND 
                                            $reqGetMatriculeAgent->bindValue(':activiter_ID',"01");
                                            $reqGetMatriculeAgent->execute();
                                                while($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()){
                                                    $matric = $resGetMatriculeAgent['matricule']; 
                                                    $nomComplet = $resGetMatriculeAgent['nom_ag'].' '.$resGetMatriculeAgent['postnom_ag'];?>
                                                <option value="<?php echo $matric;?>" > <?php echo $matric.' | '.$nomComplet;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Num Doc</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nRef_doc">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Document</label>
                            <div class="controls col-md-8">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <span class="btn btn-theme03 btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Choix du fichier</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                        <input type="file" class="default" name="Fdoc">
                                    </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>

                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                                <?php /*
                                    $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                                    $reqGetNomUtilisateur->bindvalue(':id_user',$_SESSION['id_utilisateur']);
                                    $reqGetNomUtilisateur->execute();
                                    while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                                        $nomComplet = $resGetNomUtilisateur['nom_ag'].' '.$resGetNomUtilisateur['postnom_ag'].' '.$resGetNomUtilisateur['prenom_ag'];
                                    }
                                ?>
                                <input type="text" class="form-control" name="creerPar" value="<?php echo $nomComplet; */?>" readonly>
                            </div>
                        </div-->
                        
                        
                    </div>
                    
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type Doc</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez un Agent"name="typeDoc" required>
                                    <option></option>
                                        <?php
                                            $reqGetMatriculeAgent = $db->prepare('SELECT * FROM bdd_paie.t_type_doc');
                                            $reqGetMatriculeAgent->execute();
                                                while($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()){
                                                    $matric = $resGetMatriculeAgent['id_typedoc']; 
                                                    $nomComplet = $resGetMatriculeAgent['libelle_typedoc'];?>
                                                <option value="<?php echo $matric;?>"> <?php echo $matric.' | '.$nomComplet;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Par</label>
                            <div class="col-sm-8">
                                <?php
                                    $reqGetNomUtilisateur = $db->prepare("SELECT * FROM bdd_paie.v_liste_utilisateur WHERE id_user = :id_user");
                                    $reqGetNomUtilisateur->bindvalue(':id_user',$_SESSION['id_utilisateur']);
                                    $reqGetNomUtilisateur->execute();
                                    while ($resGetNomUtilisateur = $reqGetNomUtilisateur->fetch()) {
                                        $nomComplet = $resGetNomUtilisateur['nom_ag'].' '.$resGetNomUtilisateur['postnom_ag'].' '.$resGetNomUtilisateur['prenom_ag'];
                                    }
                                ?>
                                <input type="text" class="form-control" name="creerPar" value="<?php echo $nomComplet; ?>" readonly>
                            </div>
                        </div>     

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Le</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Observation</label>
                            <div class="col-sm-8">
                                <textarea rows="4" class="form-control" name="observ"></textarea>
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
                            name="add_document_ag" style="margin-left:15px;width:150px;"><i class="fa fa-plus-circle"></i> Ajouter</button>
                            <a href="accueil.php?page=Voir_Documents" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        <!--a href="accueil.php?page=Voir_Enfant" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a-->
                    </div>
                    </div>
                </div>
            </form>
        </div>
        <br><br>
    </div>
</div>
          
            