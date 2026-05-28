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
    if(isset($_GET['code_doc_ag'])){
        $code_doc = $_GET['code_doc_ag'];
        $reqInfoEnfant = $db->prepare("SELECT 
        t_doc_agent.id_doc,t_doc_agent.id_typedoc,t_doc_agent.matricule,t_doc_agent.ref_doc,
        t_doc_agent.observation,t_doc_agent.document,t_doc_agent.document_byte,t_doc_agent.creerPar,
        t_doc_agent.datecreat,t_doc_agent.dateModif,t_doc_agent.modifierPar,
        t_agent.nom_ag,t_agent.postnom_ag,t_agent.prenom_ag,t_type_doc.libelle_typedoc
        FROM bdd_paie.t_doc_agent
        INNER JOIN bdd_paie.t_agent ON  t_doc_agent.matricule = t_agent.matricule
        INNER JOIN bdd_paie.t_type_doc ON t_type_doc.id_typedoc = t_doc_agent.id_typedoc
        WHERE id_doc = :id_doc");
        $reqInfoEnfant->bindvalue(':id_doc',$code_doc);
        $reqInfoEnfant->execute();

        while($resInfoEnfant=$reqInfoEnfant->fetch()){
            $id_doc = $resInfoEnfant['id_doc'];
            $id_type_doc = $resInfoEnfant['id_typedoc'];
            $lib_type_doc = $resInfoEnfant['libelle_typedoc'];
            $nRef = $resInfoEnfant['ref_doc'];
            $matricule = $resInfoEnfant['matricule'];
            $nomComplet_ag = $resInfoEnfant['nom_ag'].' '
                .$resInfoEnfant['postnom_ag'].' '
                .$resInfoEnfant['prenom_ag'];
            
            $doc_ag_Existant = $resInfoEnfant['document'];
            //$new_doc = $resInfoEnfant['postnom_enf'];
            $creerPar = $resInfoEnfant['creerPar'];
            $ModifierPar = $resInfoEnfant['modifierPar'];
            $datecreat = $resInfoEnfant['datecreat'];
            $dateModif = $resInfoEnfant['dateModif'];
            $observ = $resInfoEnfant['observation'];
            
        }

    }
?>
<h3><i class="fa fa-angle-right"></i> Modification Des Document</h3>
<!-- BASIC FORM ELELEMNTS -->

<div class="row mt">
    <div class="col-lg-12">
        
        <div class="form-panel">
            <?php if (isset($_SESSION['message'])) {?>
                <div class="alert alert-<?php echo ($_SESSION['typeMsg']);?>"> 
                <button type="button" class="close" data-dismiss="salert">×</button>  
                    <span><?php echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                    unset($_SESSION['typeMsg']); ?></span> 
                </div>
            <?php } ?>
            <form class="form-horizontal style-form" method="POST" action="update_document_ag.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xl-6">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="matric" value="<?php echo $matricule.' | '.$nomComplet_ag;?>" readonly>
                                <input type="hidden" class="form-control" name="id_doc" value="<?php echo $id_doc?>" readonly>         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Num Réf</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?php echo $nRef?>" name="nRef_doc">
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
                                        <input type="hidden" class="default" name="doc_ag_Existant" value="<?php echo $doc_ag_Existant;?>" >
                                    </span>
                                    <span class="fileupload-preview" style="margin-left:5px;"> <?php echo $doc_ag_Existant?></span>
                                    <a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Modifier Par</label>
                            <div class="col-sm-8">
                            <?php 
                                if($modifierPar == "sysAdmin" OR $modifierPar == NULL){
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
                                ?>
                                <!-- confirmation modal trigger will be added below -->
                            <?php } ?>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Créer Le</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" value="<?php echo $datecreat;?>" readonly>
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
                                    <option value ="<?php echo $id_type_doc?>"> <?php echo $id_type_doc. " | " .$lib_type_doc ?></option>
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
                                    $reqGetNomUtilisateur->bindvalue(':id_user',$creerPar);
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
                                <input type="date" class="form-control" value="<?php echo $datecreat;?>" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Observation</label>
                            <div class="col-sm-8">
                                <textarea rows="4" class="form-control" name="observ">
                                    <?php echo $observ?>
                                </textarea>
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
                            name="update_document_ag" style="margin-left:15px;width:150px;"><i class="fa fa-plus-circle"></i> Modifier</button>
                            <a href="accueil.php?page=Voir_Documents" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a>
                        <!--a href="accueil.php?page=Voir_Enfant" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-list"></i> Mode Liste</a-->
                    </div>
                    </div>
                </div>
            </form>
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</div>
                
                