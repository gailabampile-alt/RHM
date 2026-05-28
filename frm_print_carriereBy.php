<?php
    //session_start();
    include_once('sys_connexion.php');
?>
<h3><i class="fa fa-angle-right"></i> IMPRESSION SUIVI DE CARRIERE</h3>
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
            <form class="form-horizontal style-form" method="POST" action="traiemnt_print_bulletin.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-xl-8">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Matricule</label>
                            <div class="col-sm-8">
                                <select class="form-control chzn-select" 
                                    onchange="showInfoSiege(this.value)" data-placeholder="Selectionnez un Agent"name="matric">
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
                            <a href="print_bulletin_paie.php" target="_blank" class="btn btn-round btn-warning col-sm-3" style="margin-left:15px;width:150px;"><i class="fa fa-print"></i> Print All</a>
                        </div>
                    </div>
                    
                </div>

            </form>
        </div>
        <br><br><br><br><br><br><br><br>
    </div>
</div>
          
            