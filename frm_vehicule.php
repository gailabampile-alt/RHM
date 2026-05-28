<?php
    //session_start();
    include_once('sys_connexion.php');
?>
<h3><i class="fa fa-angle-right"></i> Saisie Véhicule</h3>
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
            <form class="form-horizontal style-form" method="POST" action="add_vehicule.php">
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
                                            $reqGetMatriculeAgent->bindValue(':activiter_ID',"01");
                                            $reqGetMatriculeAgent->execute();
                                                while($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()){
                                                    $matric = $resGetMatriculeAgent['matricule']; 
                                                    $nomComplet = $resGetMatriculeAgent['nom_ag'].' '.$resGetMatriculeAgent['postnom_ag'];?>
                                                <option value="<?php echo $matric;?>"> <?php echo $matric.' | '.$nomComplet;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modèle</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="modele">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Num Chassis</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="numChassis">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Num Permis</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="numPermis">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Carte Rose</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="numCarteRose">
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
                            <label class="col-sm-3 control-label">Immatriculation</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="immatric">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Observation</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="observ">
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="control-label col-md-3">Acte De Naissance</label>
                            <div class="controls col-md-8">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <span class="btn btn-theme03 btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Choix du fichier</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                        <input type="file" class="default" />
                                    </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div-->
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
                                <input type="date" class="form-control" value="<?php echo date('d-m-Y');?>"readonly>
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
                        </div-->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Le</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo date('d-m-Y');?>"readonly>
                            </div>
                        </div>
                        <!--div class="form-group">
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
                            name="addVehicule" style="margin-left:15px;width:150px;"><i class="fa fa-plus-circle"></i> Ajouter</button>
                        <a href="accueil.php?page=Voir_Vehicule" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                    </div>
                    </div>
                </div>
            </form>
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</div>
          
            