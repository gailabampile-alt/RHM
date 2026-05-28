<form class="form-horizontal style-form" method="POST" action="traiemnt_print_fp_op.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-xl-8">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" active 
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
                                                <option value="<?php echo $matric;?>"> <?php echo $matric.' | '.$nomComplet;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Période</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez une période" name="periode" required>
                                    <option></option>
                                        <?php
                                            $reqGetPeriode = $db->prepare("SELECT DISTINCT periode FROM bdd_paie.t_paie");
                                            //$reqGetMatriculeAgent->bindValue(':sexe_ag',"M");sexe_ag = :sexe_ag AND 
                                            //$reqGetPeriode->bindValue(':codeEiPaie',"999");
                                            $reqGetPeriode->execute();
                                                while($resGetPeriode = $reqGetPeriode->fetch()){
                                                    $periode = $resGetPeriode['periode']; ?>
                                                <option value="<?php echo $periode;?>"> <?php echo $periode;?> </option>
                                            <?php } ?>   
                                </select>         
                            </div>
                        </div>

                        <!--div class="form-group">
                            <label class="col-sm-3 control-label">Code Siège</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="code_siege">
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
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-round btn-primary col-sm-3" id="addAgent"
                                name="printBy" style="margin-left:15px;width:150px;">
                                <i class="fa fa-print"></i> Print by</button>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-xl-3">
                        <div class="form-group">
                            <a href="print_op.php" target="_blank" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-print"></i> Print All</a>
                        </div>
                    </div>
                    
                </div>

            </form>
