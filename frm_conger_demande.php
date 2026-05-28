<?php
    //session_start();
    include_once('sys_connexion.php');
?>
<h3><i class="fa fa-angle-right"></i> Démande de Congé</h3>
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
            <form class="form-horizontal style-form" method="POST" action="add_demande_conge.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Agent</label>
                            <div class="col-sm-8">
                            <select class="form-control chzn-select" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez un Agent" name="matric" required>
                                    <option></option>
                                        <?php
                                            $reqGetMatriculeAgent = $db->prepare('SELECT matricule,nom_ag, postnom_ag FROM bdd_paie.t_agent WHERE activiter_ID = :activiter_ID');
                                            //$reqGetMatriculeAgent->bindValue(':sexe_ag',"M");sexe_ag = :sexe_ag AND 
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
                            <label class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="date_demande" required >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Exercice</label>
                            <div class="col-sm-8">
                                <input type="" class="form-control" name="excercice" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">A prendre</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nbrejrsol" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">A bénéficié</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="nbrejracc" readonly >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date_Autorisé</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" name="date_acc" readonly >
                            </div>
                        </div>
                        

                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Sexe</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="sexe_enf" required>
                                    <option value="">Choisir un sexe</option>
                                    <option value="M">M - Masculin</option>
                                    <option value="F">F - Feminin</option>
                                </select>
                            </div>
                        </div-->
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
                            <label class="col-sm-3 control-label">Ecart</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="ecart" readonly>
                            </div>
                        </div>
                    <div class="form-group">
                            <label class="col-sm-3 control-label">Type de Congé</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez un Agent"name="conge" required>
                                    <option></option>
                                        <?php
                                            $reqGetMatriculeAgent = $db->prepare('SELECT * FROM bdd_paie.t_typconge');
                                            //$reqGetMatriculeAgent->bindValue(':sexe_ag',"M");sexe_ag = :sexe_ag AND 
                                            //$reqGetMatriculeAgent->bindValue(':activiter_ID',"01");
                                            $reqGetMatriculeAgent->execute();
                                                while($resGetMatriculeAgent = $reqGetMatriculeAgent->fetch()){
                                                    $id = $resGetMatriculeAgent['id_type_conge']; 
                                                    $conge = $resGetMatriculeAgent['libelle_conge'];?>
                                                <option value="<?php echo $id;?>"> <?php echo $conge;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Periode</label>
                            <div class="col-md-8">
                            <div class="input-group input-large" data-date="2024/01/01" data-date-format="yyy/mm/dd">
                             <input type="text" class="form-control dpd1" name="dateDu" readonly>
                            <span class="input-group-addon">Au</span>
                            <input type="text" class="form-control dpd2" name="dateAu" readonly>
                            </div>

                        </div>

                        </div>
                        <!--div class="form-group">
                            <label class="control-label col-md-3">Acte De Naissance</label>
                            <div class="controls col-md-8">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <span class="btn btn-theme03 btn-file">
                                        <span class="fileupload-new"><i class="fa fa-paperclip"></i> Choix du fichier</span>
                                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Changer</span>
                                        <input type="file" class="default" name="fich_act_nais" />
                                    </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"></span>
                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Observation</label>
                            <div class="col-sm-8">
                                <textarea rows="4"class="form-control" name="observation"></textarea>
                            </div>
                        </div>-->
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
                                <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" name='date_creat' readonly>
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
                            name="add_dem_conge" style="margin-left:15px;width:150px;"><i class="fa fa-plus-circle"></i> Ajouter</button>
                            <a href="accueil.php?page=voir_demande" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                            <a href="accueil.php?page=Calendrier_Conges" class="btn btn-round btn-success col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-calendar"></i> Calendrier</a>
                        <!--a href="accueil.php?page=Voir_Enfant" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a-->
                    </div>
                    </div>
                </div>
            </form>
        </div>
        <br><br><br>
    </div>
</div>
          
            
